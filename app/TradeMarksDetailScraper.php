<?php

namespace HopHey\Trademarks;

use GuzzleHttp\Client;
use HopHey\Trademarks\Contract\Http\UrlBuilderContract;
use Symfony\Component\DomCrawler\Crawler;

class TradeMarksDetailScraper
{
    private array $config;
    private Client $client;

    private UrlBuilderContract $urlBuilder;

    public function __construct($config, UrlBuilderContract $urlBuilder)
    {
        $this->client = new Client([
            'cookies' => true,
            'verify' => false,
        ]);
        $this->config = $config;
        $this->urlBuilder = $urlBuilder;
    }

    public function getDetailsFromPage($pageUrl)
    {
        $response = $this->client->get($pageUrl);
        $html = (string) $response->getBody();
        $crawler = new Crawler($html);

        $details = $crawler->filter('#resultsTable tbody tr')->each(function (Crawler $row) {
            return [
                'number' => $this->getNumber($row),
                'status' => $this->getStatus($row),
                'url_logo' => $this->getUrlLogo($row),
                'name' => $this->getName($row),
                'class' => $this->getClass($row),
                'url_details_page' => $this->getDetailsUrl($row),
            ];
        });

        return $details;
    }

    private function getNumber(Crawler $row): string
    {
        return $row->filter('td.number')->text();
    }

    /**
     * @param Crawler $row
     * @return string
     */
    function getStatus(Crawler $row): string
    {
        $statusElement = $row->filter('td.status');

        // Remove icon from element
        $statusElement->filter('i')->each(function (Crawler $icon) {
            $icon->getNode(0)->parentNode->removeChild($icon->getNode(0));
        });

        return $statusElement->text();
    }

    /**
     * @param Crawler $row
     * @return string|null
     */
    function getUrlLogo(Crawler $row): ?string
    {
        $imgElement = $row->filter('td.trademark.image img');

        if ($imgElement->count() > 0) {
            $src = $imgElement->attr('src');
            return !empty($src) ? $src : null;
        }
        return null;
    }

    /**
     * @param Crawler $row
     * @return string
     */
    function getName(Crawler $row): string
    {
        return $row->filter('td.trademark.words')->text();
    }

    /**
     * @param Crawler $row
     * @return string
     */
    function getClass(Crawler $row): string
    {
        return $row->filter('td.classes')->text();
    }

    /**
     * @param Crawler $row
     * @return string|null
     */
    function getDetailsUrl(Crawler $row): ?string
    {
        return $this->urlBuilder->buildAbsoluteUrl($row->filter('td.number a')->attr('href'));
    }
}