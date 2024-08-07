<?php
require 'vendor/autoload.php';

use HopHey\Trademarks\Http\UrlBuilder;
use HopHey\Trademarks\Proxy\TradeMarksServiceProxy;
use HopHey\Trademarks\Services\TradeMarksService;
use HopHey\Trademarks\Http\HttpClient;
use HopHey\Trademarks\Factories\ParserFactory;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

$searchTerm = $argv[1] ?? null;
if(empty($searchTerm)){
    echo "Command: php search.php <searchTerm>\n";
    exit;
}

$config = require_once 'config/app.php';
$cache = new FilesystemAdapter(
    'trademarks_cache',
    $config['cache']['cache_lifetime'],
    __DIR__ . '/runtime/cache'
);

$urlBuilder = new UrlBuilder($config['url']);
$factory = new ParserFactory($config['parser']);
$service = new TradeMarksService(
    new HttpClient(),
    $urlBuilder,
    $factory
);

$serviceProxy = new TradeMarksServiceProxy($service, $cache);

$result = $serviceProxy->search($searchTerm);
var_dump($result);
