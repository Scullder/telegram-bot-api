<?php

require 'vendor/autoload.php';

use Scullder\TelegramBotApi\TGClient;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Psr\Log\NullLogger;

$config = require './config.php';

$telegramBot = new TGClient(
    botLink: $config['bot_api_link'],
    client: Psr18ClientDiscovery::find(),
    requestFactory: Psr17FactoryDiscovery::findRequestFactory(),
    logger: new NullLogger
);

/**
 * Указать Id чата
 */
$chat = 11111111;
$telegramBot->sendMessage('Hello there!', $chat);
