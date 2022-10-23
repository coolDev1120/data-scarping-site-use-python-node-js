<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class CarsController extends Controller
{
    public function index()
    {
        $page = request()->has('page') ? request('page') : 1;

        $perPage = request()->has('per_page') ? request('per_page') : 4;
        $offset = ($page * $perPage) - $perPage;

        $newCollection = collect(json_decode(file_get_contents(storage_path() . "/cars.json"), true));

        if (request()->has('yearMax')) {
            $newCollection = $newCollection->filter(function ($item) {
                if (isset($item['registrationYear']) && $item['registrationYear'] <= request('yearMax')) {
                    return $item;
                }
            });
        }

        if (request()->has('yearMin')) {
            $newCollection = $newCollection->filter(function ($item) {
                if (isset($item['registrationYear']) && $item['registrationYear'] >= request('yearMin')) {
                    return $item;
                }
            });
        }

        if (request()->has('priceMax')) {
            $newCollection = $newCollection->filter(function ($item) {
                if (isset($item['price']) && substr($item['price'], 2) <= request('priceMax')) {
                    return $item;
                }
            });
        }

        if (request()->has('priceMin')) {
            $newCollection = $newCollection->filter(function ($item) {
                if (isset($item['price']) && substr($item['price'], 2) >= request('priceMin')) {
                    return $item;
                }
            });
        }

        if (request()->has('mileage')) {
            $newCollection = $newCollection->filter(function ($item) {
                if (isset($item['summaryIcons'][1]['text']) && substr($item['summaryIcons'][1]['text'], 0, -3) <= request('mileage')) {
                    return $item;
                }
            });
        }

        if (request()->has('transmission') && request('transmission') != 'All') {
            $newCollection = $newCollection->filter(function ($item) {
                if (isset($item['summaryIcons'][2]['text']) && $item['summaryIcons'][2]['text'] == request('transmission')) {
                    return $item;
                }
            });
        }

        $cars =  new LengthAwarePaginator(
            $newCollection->slice($offset, $perPage),
            $newCollection->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('cars', compact('cars'));
    }
}