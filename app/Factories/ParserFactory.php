<?php

namespace HopHey\Trademarks\Factories;

use HopHey\Trademarks\Contract\Factories\ParserFactoryContract;
use HopHey\Trademarks\Contract\Parsers\HtmlParserContract;
use HopHey\Trademarks\Parsers\CsrfHtmlParser;
use HopHey\Trademarks\Parsers\ResultPageHtmlParser;
use HopHey\Trademarks\Parsers\TableHtmlParser;

class ParserFactory implements ParserFactoryContract
{
    private array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function createCsrfParser(): HtmlParserContract
    {
        return new CsrfHtmlParser($this->config['search_form']);
    }

    public function createResultPageParser(): HtmlParserContract
    {
        return new ResultPageHtmlParser($this->config['result_page']);
    }

    public function createTableParser(): HtmlParserContract
    {
        return new TableHtmlParser($this->config['table']);
    }
}