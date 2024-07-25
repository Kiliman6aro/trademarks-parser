<?php

namespace Parsers;

use HopHey\Trademarks\Parsers\ResultPageHtmlParser;
use PHPUnit\Framework\TestCase;

class ResultPageHtmlParserTest extends TestCase
{
    private string $htmlFixturePath;
    private array $config;

    protected function setUp(): void
    {
        $this->htmlFixturePath = __DIR__ . '/../_fixtures/html/result.html';
        if (!file_exists($this->htmlFixturePath)) {
            throw new \RuntimeException("File: " . $this->htmlFixturePath . " not found");
        }

        $config = require(__DIR__ . '/../../config/app.php');
        $this->config = $config['parser']['result_page'];
    }

    public function testParseReturnsNumberAndLinks(): void
    {
        $html = file_get_contents($this->htmlFixturePath);

        $resultPageHtmlParser = new ResultPageHtmlParser($this->config);
        $result = $resultPageHtmlParser->parse($html);

        $this->assertArrayHasKey('number', $result);
        $this->assertEquals(928, $result['number']);
        $this->assertArrayHasKey('links', $result);
        $this->assertCount(10, $result['links']);
        $this->assertEquals('/trademarks/search/result?s=6e9151d4-728e-4126-95c7-f4400ea670cb&p=0', $result['links'][0]);
        $this->assertEquals('/trademarks/search/result?s=6e9151d4-728e-4126-95c7-f4400ea670cb&p=1', $result['links'][1]);
        $this->assertEquals('/trademarks/search/result?s=6e9151d4-728e-4126-95c7-f4400ea670cb&p=2', $result['links'][2]);
        $this->assertEquals('/trademarks/search/result?s=6e9151d4-728e-4126-95c7-f4400ea670cb&p=3', $result['links'][3]);
        $this->assertEquals('/trademarks/search/result?s=6e9151d4-728e-4126-95c7-f4400ea670cb&p=4', $result['links'][4]);
        $this->assertEquals('/trademarks/search/result?s=6e9151d4-728e-4126-95c7-f4400ea670cb&p=5', $result['links'][5]);
        $this->assertEquals('/trademarks/search/result?s=6e9151d4-728e-4126-95c7-f4400ea670cb&p=6', $result['links'][6]);
        $this->assertEquals('/trademarks/search/result?s=6e9151d4-728e-4126-95c7-f4400ea670cb&p=7', $result['links'][7]);
        $this->assertEquals('/trademarks/search/result?s=6e9151d4-728e-4126-95c7-f4400ea670cb&p=8', $result['links'][8]);
        $this->assertEquals('/trademarks/search/result?s=6e9151d4-728e-4126-95c7-f4400ea670cb&p=9', $result['links'][9]);
    }

    public function testParseReturnsNoResultsFoundWhenCountSelectorIsMissing(): void
    {
        $html = '<html><head><title>No Results</title></head><body></body></html>';

        $resultPageHtmlParser = new ResultPageHtmlParser($this->config);
        $this->expectException(\RuntimeException::class);
        $result = $resultPageHtmlParser->parse($html);
    }
}