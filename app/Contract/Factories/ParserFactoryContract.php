<?php

namespace HopHey\Trademarks\Contract\Factories;

use HopHey\Trademarks\Contract\Parsers\HtmlParserContract;

interface ParserFactoryContract
{
    public function createCsrfParser(): HtmlParserContract;
    public function createResultPageParser(): HtmlParserContract;
    public function createTableParser(): HtmlParserContract;
}