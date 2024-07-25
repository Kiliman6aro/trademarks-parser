<?php

namespace HopHey\Trademarks;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use HopHey\Trademarks\Contract\Http\UrlBuilderContract;
use Symfony\Component\DomCrawler\Crawler;

class TradeMarksScraper
{
    private Client $client;
    private array $config;

    private UrlBuilderContract $urlBuilder;

    public function __construct(array $config, UrlBuilderContract $urlBuilder)
    {
        $this->client = new Client([
            'cookies' => true,
            'verify' => false,
        ]);
        $this->config = $config;
        $this->urlBuilder = $urlBuilder;
    }

    public function scrape(string $searchTerm): array
    {
        try {
            $response = $this->client->get($this->urlBuilder->toMainPage());
            $html = (string) $response->getBody();
            $crawler = new Crawler($html);

            $csrfTokenElement = $crawler->filter($this->config['selectors']['csrf_token']);
            if ($csrfTokenElement->count() === 0) {
                throw new \Exception('CSRF token not found.');
            }
            $csrfToken = $csrfTokenElement->attr('value');

            $formData = [
                '_csrf' => $csrfToken,
                'wv[0]' => $searchTerm,
            ];

            $response = $this->client->post($this->urlBuilder->toSearch(), [
                'form_params' => $formData,
            ]);

            $html = (string) $response->getBody();
            $crawler = new Crawler($html);

            $numberElement = $crawler->filter($this->config['selectors']['result_count']);
            $number = $numberElement->count() > 0 ? $numberElement->text() : 'No results found';

            $links = [];
            $crawler->filter($this->config['selectors']['pagination_links'])->each(function (Crawler $node) use (&$links) {
                $link = $node->attr('href');
                if (!empty($link)) {
                    $links[] = $this->urlBuilder->buildAbsoluteUrl($link);
                }
            });

            return [
                'number' => $number,
                'links' => $links,
            ];

        } catch (RequestException $e) {
            throw new \Exception("HTTP request failed: " . $e->getMessage());
        } catch (\Exception $e) {
            throw new \Exception("An error occurred: " . $e->getMessage());
        }
    }
}
