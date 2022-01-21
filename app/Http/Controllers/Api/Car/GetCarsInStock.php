<?php

namespace App\Http\Controllers\Api\Car;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;
use App\Http\Parsers\Pagination\PageLimitParser;
use App\Http\Parsers\Pagination\SearchTextParser;
use App\Http\Resources\Car\CarPaginatedData as CarPaginatedDataResource;
use App\Repositories\Car\CarRepositoryInterface;
use Log;

class GetCarsInStock extends Controller
{
    private $carRepo;

	public function __construct(CarRepositoryInterface $carRepo)
	{
		$this->carRepo = $carRepo;
	}

    public function __invoke(Request $request): \Illuminate\Http\JsonResponse
    {
        try
        {
            $search = (new SearchTextParser($request))->parse();
            $pageLimit = (new PageLimitParser($request))->parse();

            $cars = $this->carRepo->getCarsInStock($search, $pageLimit);
        }
        catch(\Exception $e)
        {
            Log::critical('Failed to get list of customers - ' . $e->getMessage());

            return $this->serverErrorResponse();
        }

        return $this->withSuccessStatus()
                    ->withData(['cars' => new CarPaginatedDataResource($cars)])
                    ->respond();
    }
}
