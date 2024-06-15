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

        $results = Roach::collectSpider(GameLinksSpider::class);

        $games = collect();

        foreach ($results as $result) {
            $games->push(...$result->all());
        }

        return view('gameList', ['games' => $games]);
    }
}
