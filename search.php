<?php
require 'vendor/autoload.php';

use HopHey\Trademarks\Proxy\CachedTradeMarksScraper;
use HopHey\Trademarks\TradeMarksDetailScraper;
use HopHey\Trademarks\TradeMarksScraper;
use HopHey\Trademarks\Http\UrlBuilder;


$config = require 'config/app.php';
$urlBuilder = new UrlBuilder($config['url']);
$scraper = new TradeMarksScraper($config, $urlBuilder);
$cachedScraper = new CachedTradeMarksScraper($scraper, $config['cache_lifetime'], $config['cache_dir']);
$detailScraper = new TradeMarksDetailScraper($config, $urlBuilder);
$result = $cachedScraper->scrape('abc');
$details = [];
foreach ($result['links'] as $link) {
    $details[] = $detailScraper->getDetailsFromPage($link);
}
$response = [
    'count' => $result['number'],
    'items' => $details
];

var_export($response);
