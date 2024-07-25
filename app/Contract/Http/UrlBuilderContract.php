<?php

namespace HopHey\Trademarks\Contract\Http;

interface UrlBuilderContract
{
    public function toMainPage(): string;

    public function toSearch(): string;

    public function buildAbsoluteUrl(string $relativeUrl);
}