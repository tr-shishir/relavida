<?php

namespace App\Http\Controllers\Api\V1;

use App\Presenters\CustomerPresenter;
use App\Presenters\PaginatorPresenter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Customer\CustomerService;

class CustomerController extends Controller
{
    private $service;

    public function __construct(CustomerService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = $this->service->all()->toArray();
        $data = (new PaginatorPresenter($data))->presentBy(CustomerPresenter::class);

        return response()->json($data);
    }

    public function show($id): \Illuminate\Http\JsonResponse
    {
        $data = $this->service->getById($id);

        return response()->json((new CustomerPresenter($data))->get());
    }

    public function store(Request $request)
    {
        try {

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    public function update($id, Request $request)
    {
        try {

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
