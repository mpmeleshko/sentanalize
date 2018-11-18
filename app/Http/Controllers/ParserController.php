<?php

namespace App\Http\Controllers;


use App\Services\parsers\AmazonParser;

class ParserController
{
    /**
     * @var AmazonParser
     */
    private $amazonParser;

    public function __construct(AmazonParser $amazonParser)
    {
        $this->amazonParser = $amazonParser;
    }

    public function check()
    {
        $this->amazonParser->getReviews();
    }
}