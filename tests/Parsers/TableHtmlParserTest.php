<?php

namespace Parsers;

use HopHey\Trademarks\Parsers\TableHtmlParser;
use PHPUnit\Framework\TestCase;

class TableHtmlParserTest extends TestCase
{
    private TableHtmlParser $parser;
    private string $htmlFixturePath;

    protected function setUp(): void
    {
        $this->htmlFixturePath = __DIR__ . '/../_fixtures/html/result.html';

        if (!file_exists($this->htmlFixturePath)) {
            throw new \RuntimeException("File: " . $this->htmlFixturePath . " not found");
        }

        $config = require(__DIR__ . '/../../config/app.php');
        $this->parser = new TableHtmlParser($config['parser']['table']);
    }

    public function testParse(): void
    {
        // Чтение содержимого HTML-файла
        $html = file_get_contents($this->htmlFixturePath);

        // Проверка, что HTML был успешно загружен
        $this->assertNotFalse($html, "Failed to read HTML fixture file");

        $result = $this->parser->parse($html);

        $this->assertIsArray($result, 'Result should be an array');
        $this->assertGreaterThan(0, count($result), 'Result array should not be empty');

        $firstRow = $result[0];
        $this->assertArrayHasKey('number', $firstRow);
        $this->assertArrayHasKey('status', $firstRow);
        $this->assertArrayHasKey('url_logo', $firstRow);
        $this->assertArrayHasKey('name', $firstRow);
        $this->assertArrayHasKey('class', $firstRow);
        $this->assertArrayHasKey('url_details_page', $firstRow);

        $this->assertEquals(5576, $firstRow['number']);
        $this->assertEquals('Status not available', $firstRow['status']);
        $this->assertEquals('https://cdn2.search.ipaustralia.gov.au/5576/TRADE_MARK/T21173901/1.0/T21173901.MEDIUM.JPG', $firstRow['url_logo']);
        $this->assertEquals('ABC STEEL ROLLER FLOUR HOUSEHOLD SPECIAL AUSTRALIAN', $firstRow['name']);
        $this->assertEquals('30', $firstRow['class']);
        $this->assertEquals('/trademarks/search/view/5576?s=6e9151d4-728e-4126-95c7-f4400ea670cb', $firstRow['url_details_page']);
    }
}