<?php

namespace HopHey\Trademarks\Parsers;

use Symfony\Component\DomCrawler\Crawler;

class CsrfHtmlParser extends HtmlParser
{

    public function parse(string $html): array
    {
        $crawler = new Crawler($html);
        $csrfTokenElement = $crawler->filter($this->getConfig('csrf_field_selector'));
        if ($csrfTokenElement->count() === 0) {
            throw new \Exception('CSRF token not found.');
        }
        $csrfToken = $csrfTokenElement->attr('value');
        return [
            '_csrf' => $csrfToken
        ];
    }
}