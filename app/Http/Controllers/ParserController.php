<?php

namespace App\Http\Controllers;


use App\Services\parsers\RozetkaParser;

class ParserController
{
    /**
     * @var RozetkaParser
     */
    private $amazonParser;

    public function __construct(RozetkaParser $amazonParser)
    {
        $this->amazonParser = $amazonParser;
    }

    public function check()
    {
        $this->amazonParser->getReviews();
    }
}