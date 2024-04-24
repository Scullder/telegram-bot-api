<?php

namespace Scullder\TelegramBotApi;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Log\LoggerInterface;

class TGClient
{
    public function __construct(
        private string $botLink,
        private ClientInterface $client,
        private RequestFactoryInterface $requestFactory,
        private LoggerInterface $logger
    ) {
    }

    private function call(string $method, array $params = [])
    {
        $methodUri = $this->botLink . $method . ($params ? '?' . http_build_query($params) : '');
        $request = $this->requestFactory->createRequest('GET', $methodUri);

        try {
            $response = $this->client->sendRequest($request);
        } catch (ClientExceptionInterface $e) {
            $this->logger->error($e->getMessage());
        }

        $responseBody = (string) $response->getBody();

        $this->logger->info($responseBody);

        return $responseBody;
    }

    public function sendMessage(string $message, int|string $chat)
    {
        return $this->call('sendMessage', [
            'chat_id' => $chat,
            'text' => $message,
        ]);
    }
}
