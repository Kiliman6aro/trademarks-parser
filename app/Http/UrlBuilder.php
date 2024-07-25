<?php

namespace HopHey\Trademarks\Http;

use HopHey\Trademarks\Contract\Http\UrlBuilderContract;

class UrlBuilder implements UrlBuilderContract
{
    private array $config;

    private string $baseUrl;

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->baseUrl = $config['base_url'];
    }

    public function toMainPage(): string
    {
        return $this->buildAbsoluteUrl($this->config['main_page']);
    }

    public function toSearch(): string
    {
        return $this->buildAbsoluteUrl($this->config['search_url']);
    }


    public function buildAbsoluteUrl(string $relativeUrl)
    {
        return $this->baseUrl . '/' . ltrim($relativeUrl, '/');
    }
}