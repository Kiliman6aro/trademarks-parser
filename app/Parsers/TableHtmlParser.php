<?php

namespace HopHey\Trademarks\Parsers;

use Symfony\Component\DomCrawler\Crawler;

class TableHtmlParser extends HtmlParser
{

    public function parse(string $html): array
    {
        $crawler = new Crawler($html);

        return $crawler->filter($this->getConfig('rows_selector'))->each(function (Crawler $row) {
            return [
                'number' => $this->getNumber($row),
                'status' => $this->getStatus($row),
                'url_logo' => $this->getUrlLogo($row),
                'name' => $this->getName($row),
                'class' => $this->getClass($row),
                'url_details_page' => $this->getViewUrl($row),
            ];
        });
    }

    private function getNumber(Crawler $row): string
    {
        return $row->filter($this->getConfig('number_selector'))->text();
    }

    /**
     * @param Crawler $row
     * @return string
     */
    private function getStatus(Crawler $row): string
    {
        $statusElement = $row->filter($this->getConfig('status_selector'));

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
    private function getUrlLogo(Crawler $row): ?string
    {
        $imgElement = $row->filter($this->getConfig('logo_selector'));

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
    private function getName(Crawler $row): string
    {
        return $row->filter($this->getConfig('name_selector'))->text();
    }

    /**
     * @param Crawler $row
     * @return string
     */
    private function getClass(Crawler $row): string
    {
        return $row->filter($this->getConfig('class_selector'))->text();
    }

    /**
     * @param Crawler $row
     * @return string|null
     */
    private function getViewUrl(Crawler $row): ?string
    {
        return $row->filter($this->getConfig('link_selector'))->attr('href');
    }
}