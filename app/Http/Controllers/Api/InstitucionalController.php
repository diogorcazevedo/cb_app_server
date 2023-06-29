<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Services\FacebookApiConversoesService;
use App\Models\Clip;
use App\Models\Destaque;
use App\Models\Event;
use Inertia\Inertia;

class InstitucionalController extends Controller
{

    private FacebookApiConversoesService $apiConversoesService;

    public function __construct(FacebookApiConversoesService $apiConversoesService)
    {
        $this->apiConversoesService = $apiConversoesService;
    }

    public function clipping()
    {
        $this->apiConversoesService->PageView(auth()->check(),url()->current());
        $clipping = Clip::with('images')->get();
        return response()->json($clipping);
    }

    public function events()
    {
        $this->apiConversoesService->PageView(auth()->check(),url()->current());
        $events = Event::with('images')->all();
        return response()->json($events);
    }

    public function event($id)
    {
        $this->apiConversoesService->PageView(auth()->check(),url()->current());
        $event = Event::with('images')->find($id);
        return response()->json($event);

    }


}
