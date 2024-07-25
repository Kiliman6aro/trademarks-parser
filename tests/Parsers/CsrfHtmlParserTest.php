<?php

namespace Parsers;

use HopHey\Trademarks\Parsers\CsrfHtmlParser;
use PHPUnit\Framework\TestCase;

class CsrfHtmlParserTest extends TestCase
{
    private string $htmlFixturePath;

    private array $config;

    protected function setUp(): void
    {
        $this->htmlFixturePath = __DIR__ . '/../_fixtures/html/main.html';
        if(!file_exists($this->htmlFixturePath)){
            throw  new \RuntimeException("File: ".$this->htmlFixturePath." not found");
        }
        $config = require(__DIR__.'/../../config/app.php');
        $this->config = $config['parser']['search_form'];
    }

    public function testParseReturnsCsrfToken(): void
    {
        $html = file_get_contents($this->htmlFixturePath);
        $csrfHtmlParser = new CsrfHtmlParser($this->config);
        $result = $csrfHtmlParser->parse($html);

        $this->assertArrayHasKey('_csrf', $result);
        $this->assertEquals('2faa362f-f9af-479d-b5cb-23d760acae6c', $result['_csrf']);
    }

    public function testParseThrowsExceptionWhenCsrfTokenNotFound(): void
    {
        $html = '<html><head><title>No CSRF</title></head><body></body></html>';

        $csrfHtmlParser = new CsrfHtmlParser($this->config);
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('CSRF token not found.');

        $csrfHtmlParser->parse($html);
    }
}