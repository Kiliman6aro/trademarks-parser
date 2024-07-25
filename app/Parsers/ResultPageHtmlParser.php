<?php

namespace HopHey\Trademarks\Parsers;

use Symfony\Component\DomCrawler\Crawler;

class ResultPageHtmlParser extends HtmlParser
{
    public function parse(string $html): array
    {
        $crawler = new Crawler($html);
        $numberElement = $crawler->filter($this->getConfig('count_selector'));
        $number = $numberElement->count() > 0 ? $numberElement->text() : null;
        $countItemsOnPage = $crawler->filter($this->getConfig('rows_selector'))->count();
        if(!$number && !$countItemsOnPage){
            throw new \RuntimeException("Not found results on page.");
        }
        $linkTemplate = $crawler->filter($this->getConfig('pagination_links_selector'))->eq(2)->attr('href');
        $links = $this->linksGenerate($number, $countItemsOnPage, $linkTemplate);

        return [
            'number' => $number,
            'links' => $links,
        ];
    }

    /**
     * Generates pagination links based on the total number of records and the number of records per page.
     * It uses the first page as a starting point and adjusts the links accordingly.
     * @param int $number
     * @param int $countItemsOnPage
     * @param string $linkTemplate
     * @return array
     */
    public function linksGenerate(int $number, int $countItemsOnPage, string $linkTemplate): array
    {
        $links = [];
        $pages = ceil($number / $countItemsOnPage);
        for ($i = 0; $i < $pages; $i++) {
            $url = preg_replace('/p=\d+/', 'p=' . $i, $linkTemplate);
            $links[] = $url;
        }
        return $links;
    }
}