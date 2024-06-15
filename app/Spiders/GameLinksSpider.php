<?php

declare(strict_types=1);

namespace App\Spiders;

use Generator;
use RoachPHP\Http\Response;
use RoachPHP\Spider\BasicSpider;
use RoachPHP\Spider\ParseResult;
use RoachPHP\Extensions\LoggerExtension;
use RoachPHP\Extensions\StatsCollectorExtension;
use RoachPHP\Downloader\Middleware\RequestDeduplicationMiddleware;
use RoachPHP\Http\Request;
use Exception;

class GameLinksSpider extends BasicSpider
{
    public int $pageNum;
    public string $initLink;
    public array $startUrls;

    public function nextLink(): string
    {

        $this->pageNum++;
        $this->initLink = 'https://marketplace.xbox.com/hu-hu/Games?page=' . $this->pageNum . '&pagesize=90';

        return $this->initLink;
    }

    public function __construct()
    {
        $this->pageNum = 0;
        $this->startUrls = [];
        array_push($this->startUrls, $this->nextLink());
        parent::__construct();
    }

    public array $downloaderMiddleware = [
        RequestDeduplicationMiddleware::class,
    ];

    public array $spiderMiddleware = [
        //
    ];

    public array $itemProcessors = [
        //
    ];

    public array $extensions = [
        LoggerExtension::class,
        StatsCollectorExtension::class,
    ];

    public int $concurrency = 2;

    public int $requestDelay = 1;

    public function parse(Response $response): Generator
    {
        $gameLinks = collect();

        $response->filter('a.h2')->each(function ($element) use (&$gameLinks) {

            $gameLinks->put($element->text(), 'https://marketplace.xbox.com' . $element->attr('href'));
        });

        try {
            $nextPageUrl = $this->nextLink();

            if ($gameLinks->count() != 0) {
                yield $this->request('GET', $nextPageUrl);
            }
        } catch (Exception) {
            dd('nincs kövi oldal');
        }

        if ($gameLinks->count() != 0) {

            yield $this->item([
                'game-links' => $gameLinks->toArray()
            ]);
        }
    }
}
