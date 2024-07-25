<?php

namespace Http;

use HopHey\Trademarks\Http\UrlBuilder;
use PHPUnit\Framework\TestCase;

class UrlBuilderTest extends TestCase
{
    private UrlBuilder $urlBuilder;

    protected function setUp(): void
    {
        $config = [
            'base_url' => 'https://search.ipaustralia.gov.au',
            'main_page' => 'trademarks/search/advanced',
            'search_url' => 'trademarks/search/doSearch',
        ];
        $this->urlBuilder = new UrlBuilder($config);
    }

    public function testToMainPage(): void
    {
        $expected = 'https://search.ipaustralia.gov.au/trademarks/search/advanced';
        $this->assertEquals($expected, $this->urlBuilder->toMainPage());
    }

    public function testToSearch(): void
    {
        $expected = 'https://search.ipaustralia.gov.au/trademarks/search/doSearch';
        $this->assertEquals($expected, $this->urlBuilder->toSearch());
    }

    public function testBuildAbsoluteUrl(): void
    {
        $relativeUrl = '/path/to/resource';
        $expected = 'https://search.ipaustralia.gov.au/path/to/resource';
        $this->assertEquals($expected, $this->urlBuilder->buildAbsoluteUrl($relativeUrl));

        $relativeUrl = 'path/to/resource';
        $expected = 'https://search.ipaustralia.gov.au/path/to/resource';
        $this->assertEquals($expected, $this->urlBuilder->buildAbsoluteUrl($relativeUrl));
    }
}