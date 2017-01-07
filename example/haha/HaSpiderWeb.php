<?php

namespace haha;

use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use Spider\SpiderWeb;
use Symfony\Component\DomCrawler\Crawler;

/**
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */
class HaSpiderWeb extends SpiderWeb
{
    public $name = 'ha';

    /**
     * @param Crawler $crawler
     * @param ResponseInterface $response
     * @return mixed
     */
    function process(Crawler $crawler, ResponseInterface $response)
    {
        preg_match('/\d+/', $crawler->filter('.jump-page')->eq(0)->text(), $match);
        $total = (string) $match[0];

        $this->setMaxProgress($total);
        $this->setStartProgress(1);

        for ($i = 1; $i <= $total; $i++) {
            $this->emit(new PageSpiderWeb('GET', $this->uri->getScheme() . '://' . $this->uri->getHost() . '/topic/1/new/' . $i));
        }
    }

    /**
     * @param RequestException $requestException
     * @return mixed
     */
    function error(RequestException $requestException)
    {
        output($requestException->getMessage());
    }
}