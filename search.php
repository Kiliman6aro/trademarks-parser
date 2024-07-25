<?php
require 'vendor/autoload.php';

use HopHey\Trademarks\Http\UrlBuilder;
use HopHey\Trademarks\Services\TradeMarksService;
use HopHey\Trademarks\Http\HttpClient;
use HopHey\Trademarks\Factories\ParserFactory;


$config = require 'config/app.php';
$urlBuilder = new UrlBuilder($config['url']);
$factory = new ParserFactory($config['parser']);
$service = new TradeMarksService(
    new HttpClient(),
    $urlBuilder,
    $factory
);
$result = $service->search('abc');
var_dump($result['items']);
