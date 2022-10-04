<?php

namespace App\Http\Controllers\Api\V1;

use App\Presenters\CategoryPresenter;
use App\Presenters\OrderPresenter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Presenters\PaginatorPresenter;
use App\Services\Order\OrderService;

class OrderController extends Controller
{
    private $service;

    public function __construct(OrderService $OrderService)
    {
        $this->service = $OrderService;
    }

    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = $this->service->all()->toArray();
        $data = (new PaginatorPresenter($data))->presentBy(OrderPresenter::class);

        return response()->json($data);
    }

    public function show($id): \Illuminate\Http\JsonResponse
    {
        $data = $this->service->getById($id);
        $data = (new OrderPresenter($data))->get();

        return response()->json($data);
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $requestData = array_merge($request->only('title', 'drm_ref_id'), [

            ]);
            $data = $this->service->store($requestData);

            return response()->json((new OrderPresenter($data))->get());
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    public function update($id, Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $data = $this->service->update($id, array_merge(
                    $request->only('title'),
                    ['url' => mw()->url_manager->slug($request->get('title'))]
                )
            );

            return response()->json((new OrderPresenter($data))->get());
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        try {
            return response()->json($this->service->destroy($id));
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

}
