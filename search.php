<?php
require 'vendor/autoload.php';

use HopHey\Trademarks\Proxy\CachedTradeMarksScraper;
use HopHey\Trademarks\TradeMarksDetailScraper;
use HopHey\Trademarks\TradeMarksScraper;


$config = require 'config/app.php';
$scraper = new TradeMarksScraper($config);
$cachedScraper = new CachedTradeMarksScraper($scraper, $config['cache_lifetime'], $config['cache_dir']);
$detailScraper = new TradeMarksDetailScraper($config);
$result = $cachedScraper->scrape('abc');
$details = [];
foreach ($result['links'] as $link) {
    $fullUrl = $config['base_url'] . $link;
    $details[] = $detailScraper->getDetailsFromPage($fullUrl);
}
$response = [
    'count' => $result['number'],
    'items' => $details
];

var_export($response);
