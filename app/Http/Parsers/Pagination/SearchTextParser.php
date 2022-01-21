<?php

namespace App\Http\Parsers\Pagination;

use App\Http\Parsers\ParserInterface;

class SearchTextParser implements ParserInterface
{
    private $request;

    public function __construct(&$request)
    {
        $this->request = $request;
    }

    public function parse(): string
    {
        if(!$this->request->has('search'))
            return '';

        $search = $this->request->input('search');

        if($search === null)
            return '';

        return $search;
    }
}
