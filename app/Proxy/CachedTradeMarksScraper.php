<?php

namespace HopHey\Trademarks\Proxy;

use HopHey\Trademarks\TradeMarksScraper;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\CacheInterface;

class CachedTradeMarksScraper
{
    private TradeMarksScraper $scraper;
    private CacheInterface $cache;

    public function __construct(TradeMarksScraper $scraper, $cacheLifetime = 600, $cacheDir = 'cache')
    {
        $this->scraper = $scraper;
        $this->cache = new FilesystemAdapter(
            '',
            $cacheLifetime,
            $cacheDir
        );
    }

    /**
     * @throws InvalidArgumentException
     */
    public function scrape($searchTerm)
    {
        $cacheKey = md5($searchTerm);
        $cachedItem = $this->cache->getItem($cacheKey);

        if (!$cachedItem->isHit()) {
            try {
                $result = $this->scraper->scrape($searchTerm);

                $cachedItem->set($result);
                $this->cache->save($cachedItem);

            } catch (\Exception $e) {
                throw new \Exception("Scraping failed: " . $e->getMessage());
            }
        } else {
            $result = $cachedItem->get();
        }

        return $result;
    }
}