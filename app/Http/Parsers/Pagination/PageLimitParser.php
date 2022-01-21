<?php

namespace App\Http\Parsers\Pagination;

use App\Http\Parsers\ParserInterface;

class PageLimitParser implements ParserInterface
{
    const DEFAULT_PAGE_LIMIT = 20;
    const MAX_PAGE_LIMIT = 100;

    private $request;

    public function __construct(&$request)
    {
        $this->request = $request;
    }

    public function parse(): int
    {
        if ($this->request->has('limit')) {
            $pageLimit = $this->request->input('limit');

            if ($this->isPageLimitNumericAndNotGreaterThanMaxLimitValue($pageLimit))
                return $pageLimit;
        }

        return static::DEFAULT_PAGE_LIMIT;
    }

    private function isPageLimitNumericAndNotGreaterThanMaxLimitValue($pageLimit): bool
    {
        return is_numeric($pageLimit) && ($pageLimit <= static::MAX_PAGE_LIMIT);
    }
}
