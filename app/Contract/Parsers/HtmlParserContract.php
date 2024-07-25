<?php

namespace HopHey\Trademarks\Contract\Parsers;

interface HtmlParserContract
{
    public function parse(string $html): array;
}