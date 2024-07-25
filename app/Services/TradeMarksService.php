<?php

namespace HopHey\Trademarks\Services;

use HopHey\Trademarks\Contract\Factories\ParserFactoryContract;
use HopHey\Trademarks\Contract\Http\UrlBuilderContract;
use HopHey\Trademarks\Contract\Parsers\HtmlParserContract;
use HopHey\Trademarks\Http\HttpClient;

class TradeMarksService
{
    private HttpClient $httpClient;
    private UrlBuilderContract $urlBuilder;
    private HtmlParserContract $csrfParser;
    private HtmlParserContract $resultPageParser;
    private HtmlParserContract $tableParser;

    public function __construct(
        HttpClient            $httpClient,
        UrlBuilderContract    $urlBuilder,
        ParserFactoryContract $factory
    ) {
        $this->httpClient = $httpClient;
        $this->urlBuilder = $urlBuilder;
        $this->csrfParser = $factory->createCsrfParser();
        $this->resultPageParser = $factory->createResultPageParser();
        $this->tableParser = $factory->createTableParser();
    }

    public function search(string $searchTerm): array
    {
        $mainPageHtml = $this->httpClient->get($this->urlBuilder->toMainPage());
        $csrfData = $this->csrfParser->parse($mainPageHtml);

        $searchFormParams = array_merge(
            $csrfData,
            ['wv[0]' => $searchTerm]
        );
        $searchResultsHtml = $this->httpClient->post($this->urlBuilder->toSearch(), $searchFormParams);

        $searchResults = $this->resultPageParser->parse($searchResultsHtml);

        $details = [];
        foreach ($searchResults['links'] as $link) {
            $detailsPageHtml = $this->httpClient->get($this->urlBuilder->buildAbsoluteUrl($link));
            $pageDetails = $this->tableParser->parse($detailsPageHtml);
            $details = array_merge($details, $pageDetails);
        }

        return [
            'count' => $searchResults['number'],
            'items' => $details,
        ];
    }
}