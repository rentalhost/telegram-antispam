<?php

declare(strict_types = 1);

namespace Rentalhost\TelegramAntispam\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Request;
use Rentalhost\TelegramAntispam\Fluents\Entities;

class AntispamService
{
    public static function deleteMessage(int $messageId, int $chatId): void
    {
        try {
            $guzzleClient = new Client();
            $guzzleClient->get(sprintf('https://api.telegram.org/bot%s/deleteMessage', env('TELEGRAM_BOT_TOKEN')), [
                'query' => [
                    'message_id' => $messageId,
                    'chat_id'    => $chatId,
                ],
            ]);
        }
        catch (ClientException) {
        }
    }

    public static function handle(): JsonResponse
    {
        $requestBase = Request::input('message') ?? Request::input('edited_message');

        if (!$requestBase) {
            return new JsonResponse(true);
        }

        $fromId = Arr::get($requestBase, 'from.id');
        $chatId = Arr::get($requestBase, 'chat.id');

        if ($fromId === $chatId) {
            return new JsonResponse(true);
        }

        $entities = new Entities(Arr::get($requestBase, 'entities'));

        foreach ($entities->getEntities() as $entity) {
            if ($entity->isUrl()) {
                $entityUrl = $entity->getText(Arr::get($requestBase, 'text'));

                if ($entityUrl) {
                    $allowedDomains = config('antispam.allowedDomains');
                    $entityUrlHost  = mb_strtolower(parse_url($entityUrl, PHP_URL_HOST) ?? $entityUrl);

                    if (!in_array($entityUrlHost, $allowedDomains)) {
                        self::deleteMessage(Arr::get($requestBase, 'message_id'), $chatId);

                        return new JsonResponse(false);
                    }
                }
            }
            else if ($entity->isTextMention()) {
                $entityUserId = $entity->getUserId();

                if ($entityUserId && !self::isChatMember($entityUserId, $chatId)) {
                    self::deleteMessage(Arr::get($requestBase, 'message_id'), $chatId);

                    return new JsonResponse(false);
                }
            }
        }

        return new JsonResponse(true);
    }

    public static function isChatMember(int $userId, int $chatId): bool
    {
        try {
            $guzzleClient = new Client();
            $guzzleClient->get(sprintf('https://api.telegram.org/bot%s/getChatMember', env('TELEGRAM_BOT_TOKEN')), [
                'query' => [
                    'user_id' => $userId,
                    'chat_id' => $chatId,
                ],
            ]);

            return true;
        }
        catch (ClientException) {
        }

        return false;
    }
}
