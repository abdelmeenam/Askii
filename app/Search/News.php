<?php

namespace App\Search;

use Algolia\ScoutExtended\Searchable\Aggregator;

class News extends Aggregator
{
    /**
     * The names of the models that should be aggregated.
     *
     * @var string[]
     */
    protected $models = [
        \App\Models\Question::class,
        \App\Models\Answer::class,
    ];
}