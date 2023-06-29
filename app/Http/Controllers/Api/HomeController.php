<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\FacebookApiConversoesService;
use App\Models\Collection;
use App\Models\Product;
use Inertia\Inertia;


class HomeController extends Controller
{

    private FacebookApiConversoesService $apiConversoesService;

    public function __construct(FacebookApiConversoesService $apiConversoesService)
    {
        $this->apiConversoesService = $apiConversoesService;
    }

    public function index(){

        $this->apiConversoesService->PageView(auth()->check(),url()->current());

        $highlights = Collection::with(['images' => function($q) {
                                    $q->where('image_type_id',3 );
                                }]) ->where('featured',1)
                                    ->orderBy('line_up')
                                    ->get();
        $collections = Collection::with(['images' => function($q) {
                                        $q->where('image_type_id',3 );
                                    }]) ->where('principal',1)
                                        ->orderBy('line_up')
                                        ->get();

      
        return response()->json([
            'highlights' => $highlights,
            'collections' => $collections,
        ]);
    }
}
