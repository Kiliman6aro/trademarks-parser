<?php

namespace HopHey\Trademarks\Parsers;

use HopHey\Trademarks\Contract\Parsers\HtmlParserContract;

abstract class HtmlParser implements HtmlParserContract
{
    private array $config;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function getConfig($key): mixed
    {
        return $this->config[$key] ?? null;
    }
}