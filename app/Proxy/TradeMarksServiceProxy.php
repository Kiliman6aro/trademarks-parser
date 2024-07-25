<?php

namespace HopHey\Trademarks\Proxy;

use HopHey\Trademarks\Contract\Services\SearchServiceContract;
use Symfony\Contracts\Cache\CacheInterface;

class TradeMarksServiceProxy implements SearchServiceContract
{
    private SearchServiceContract $service;
    private CacheInterface $cache;
    private string $cacheKeyPrefix;

    public function __construct(SearchServiceContract $service, CacheInterface $cache, string $cacheKeyPrefix = 'trade_marks_')
    {
        $this->service = $service;
        $this->cache = $cache;
        $this->cacheKeyPrefix = $cacheKeyPrefix;
    }

    public function search(string $searchTerm): array
    {
        $cacheKey = $this->cacheKeyPrefix . md5($searchTerm);
        $cacheItem = $this->cache->getItem($cacheKey);

        if ($cacheItem->isHit()) {
            return $cacheItem->get();
        }

        $result = $this->service->search($searchTerm);

        $cacheItem->set($result);
        $this->cache->save($cacheItem);

        return $result;
    }
}