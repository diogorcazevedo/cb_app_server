<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Services\FacebookApiConversoesService;
use App\Models\Category;
use App\Models\Collection;
use App\Models\OperadoraCartoes;
use App\Models\Order;
use App\Models\OrderData;
use App\Models\OrderItems;
use App\Models\Product;
use App\Models\ProductImages;
use App\Models\User;
use App\Notifications\FailPagamento;
use App\Notifications\SuccessPagamento;
use App\Repositories\Api\CategoryRepository;
use App\Repositories\Api\CollectionRepository;
use App\Repositories\Api\OrderItemsRepository;
use App\Repositories\Api\ProductRepository;


class StoreController extends Controller
{
    private FacebookApiConversoesService $apiConversoesService;
    private CollectionRepository $collectionRepository;
    private CategoryRepository $categoryRepository;
    private ProductRepository $productRepository;
    private OrderItemsRepository $orderItemsRepository;

    public function __construct(FacebookApiConversoesService $apiConversoesService,
                                CollectionRepository $collectionRepository,
                                CategoryRepository $categoryRepository,
                                ProductRepository $productRepository,
                                OrderItemsRepository $orderItemsRepository)
    {
        $this->apiConversoesService = $apiConversoesService;
        $this->collectionRepository = $collectionRepository;
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
        $this->orderItemsRepository = $orderItemsRepository;
    }

    public function index(){

        $collections = $this->collectionRepository->store_data();
        $this->apiConversoesService->PageView(auth()->check(),url()->current());
        return response()->json($collections);
    }

    public function collections(){
        $collections = $this->collectionRepository->collections_data();
        $this->apiConversoesService->PageView(auth()->check(),url()->current());
        return response()->json($collections);

    }

    public function dear_collections(){
        $collections = $this->collectionRepository->dear_data();
        $this->apiConversoesService->PageView(auth()->check(),url()->current());
        return response()->json($collections);

    }

    public function collection(Collection $collection){


        $image = $collection->images->where('image_type_id',3 )->first();
        $products = $this->collectionRepository->collection_products($collection);
        $this->apiConversoesService->PageView(auth()->check(),url()->current());
        $joints = $collection->joints()->with(['joint'=>function($q){
            $q->with(['images' => function($q) {
                $q->where('image_type_id',3 );
            }])->with(['products' => function($q) {
                $q->where('sale',1 )->with(['images'=>function($q){
                    $q->where('image_type_id',50 );
                }])->with('stock');
            }]);

        }])->get();

        return response()->json([
            'joints'        =>$joints,
            'collection'    =>$collection,
            'products'      =>$products,
            'image'         =>$image,
        ]);
    }
    public function collections_group($group){
        $collections = $this->collectionRepository->collections_group($group);
        $this->apiConversoesService->PageView(auth()->check(),url()->current());

        return response()->json($collections);

    }

    public function category(Category $category){

        $products = $this->categoryRepository->category_products($category);
        $this->apiConversoesService->PageView(auth()->check(),url()->current());

        return response()->json([
            'category'=>$category,
            'products'=>$products,
        ]);
    }

    public function subcategory($subCategory){

        $products = $this->categoryRepository->subcategory_products($subCategory);
        $this->apiConversoesService->PageView(auth()->check(),url()->current());

        return response()->json($products);
    }

    public function product(Product $product){

        $stock  = $product->stock;
        $images = $this->productRepository->store_product_images($product);
        $features = $this->productRepository->store_product_features($product);
        $this->apiConversoesService->PageView(auth()->check(),url()->current());
        $this->apiConversoesService->ViewContent(auth()->check(),url()->current(),$product);

        if (ProductImages::where('product_id',$product->id)->where('image_type_id','802')->count() >0){
            $cat_img = ProductImages::where('product_id',$product->id)->where('image_type_id','802')->latest('id')->first();
        }else{
            $cat_img = ProductImages::where('product_id',$product->id)->where('image_type_id','50')->latest('id')->first();
        }

        return response()->json([
            'product'   =>$product,
            'images'    =>$images,
            'stock'     =>$stock,
            'cat_img'   =>$cat_img,
            'features'  =>$features,
        ]);
    }

    public function checkout($id,$operadora=null)
    {
        $order =Order::find($id);
        $user  = $order->user;
        $items = $this->orderItemsRepository->findByOrder($order);
        $operadora = ($operadora == null) ? OperadoraCartoes::where('main',1)->first() : OperadoraCartoes::find($operadora);
        $this->apiConversoesService->PageView(auth()->check(),url()->current());
        $this->apiConversoesService->initiateCheckoutPersonalizado(auth()->check(),$order,url()->current());


        return response()->json([
            'order'     => $order,
            'user'      => $user,
            'items'     => $items,
            'operadora' => $operadora,
        ]);
    }

    public function exception($id)
    {
        $orderData  = OrderData::find($id);
        $order      = Order::find($orderData->order_id);
        $client     = User::find($orderData->user_id);
        $items      = OrderItems::where('order_id',$order->id)->with('product')->get();
        $this->apiConversoesService->PageView(auth()->check(),url()->current());
        $this->apiConversoesService->Purchase(auth()->check(),url()->current(),$order);

        $usr  = User::find(9);
        $usr->notify(new FailPagamento($client,$orderData));

        return response()->json([
            'order_data'=> $orderData,
            'order'     => $order,
            'client'    => $client,
            'items'     => $items,
        ]);

    }

    public function success($id)
    {
        $orderData      = OrderData::find($id);
        $order          = Order::find($orderData->order_id);
        $client         = User::find($orderData->user_id);
        $items          = OrderItems::where('order_id',$order->id)->with('product')->get();

        $this->apiConversoesService->PageView(auth()->check(),url()->current());
        $this->apiConversoesService->Purchase(auth()->check(),url()->current(),$order);

        $usr  = User::find(9);
        $usr->notify(new SuccessPagamento($client,$orderData));

        return response()->json([
            'order_data'    => $orderData,
            'order'         => $order,
            'client'        => $client,
            'items'         => $items,
        ]);

    }


    //NÃO USADOS AINDA
    //NÃO USADOS AINDA
    //NÃO USADOS AINDA
    //NÃO USADOS AINDA
    //NÃO USADOS AINDA
    //NÃO USADOS AINDA
    //NÃO USADOS AINDA
    //NÃO USADOS AINDA
    //NÃO USADOS AINDA
    //NÃO USADOS AINDA

//    public function gem(Gem $gem){
//
//        $products = $gem->products()
//            ->with('stock')
//            ->with(['images' => function($q) {
//                $q->where('image_type_id',50);
//            }])->has('stock')->orderBy('line_up','desc')->get();
//
//        $this->apiConversoesService->PageView(auth()->check(),url()->current());
//
//        return Inertia::render('Store/Gem',[
//            'gem'=>$gem,
//            'products'=>$products,
//        ]);
//    }

//    public function topic( Topic $topic){
//
//        $products = $topic->products()
//            ->with('stock')
//            ->with(['images' => function($q) {
//                $q->where('image_type_id',50);
//            }])->has('stock')->orderBy('collection_id','desc')->get();
//
//        $this->apiConversoesService->PageView(auth()->check(),url()->current());
//
//
//        return Inertia::render('Store/Topic',[
//            'topic'=>$topic,
//            'products'=>$products,
//        ]);
//    }


}
