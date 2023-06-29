<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Services\CartService;
use App\Http\Services\FacebookApiConversoesService;
use App\Models\Category;
use App\Models\Gem;
use App\Models\OperadoraCartoes;
use App\Models\Order;
use App\Models\OrderData;
use App\Models\OrderItems;
use App\Models\Product;
use App\Models\ProductImages;
use App\Models\State;
use App\Models\SubCategories;
use App\Models\Topic;
use App\Models\User;
use App\Notifications\FailPagamento;
use App\Notifications\SuccessPagamento;
use App\Repositories\CategoryRepository;
use App\Repositories\CollectionRepository;
use App\Repositories\OrderItemsRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use App\Models\Collection;


class LandingController extends Controller
{
    private FacebookApiConversoesService $apiConversoesService;

    public function __construct(FacebookApiConversoesService $apiConversoesService)
    {
        $this->apiConversoesService = $apiConversoesService;
    }


    public function multiplas(){
        $this->apiConversoesService->PageView(auth()->check(),url()->current());
        return Inertia::render('Landing/Multiplas');
    }

}
