<?php

namespace App\Http\Controllers;

use App\Spiders\GameLinksSpider;
use App\Spiders\LaravelDocsSpider;
use Illuminate\Http\Request;
use RoachPHP\Roach;

class SpiderController extends Controller
{

    public function index()
    {

        // Roach::startSpider(GameLinksSpider::class);

        $results = Roach::collectSpider(GameLinksSpider::class);
        // dump($results[0]->all());

        $games = collect();

        foreach ($results as $result) {
            $games->push(...$result->all());
            // dump($result->all());
        }
        dump($games);
    }
}
