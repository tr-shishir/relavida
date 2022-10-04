<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Content;
use App\Presenters\CategoryPresenter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Category\CategoryService;
use App\Presenters\PaginatorPresenter;
use App\Models\SyncHistory;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use App\Services\DrmSyncService;
use Illuminate\Support\Facades\Artisan;

class CategoryController extends Controller
{
    private $service;

    public function __construct(CategoryService $categoryService)
    {
        $this->service = $categoryService;
    }

    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = $this->service->all($request->all())->toArray();
        $data = (new PaginatorPresenter($data))->presentBy(CategoryPresenter::class);

        return response()->json($data);
    }

    public function show($id): \Illuminate\Http\JsonResponse
    {
        $data = $this->service->getById($id);
        $data = (new CategoryPresenter($data))->get();

        return response()->json($data);
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $position = @DB::table('categories')->max('position')+1 ?? 0;
            $shop = Content::where([
                'content_type' => 'page',
                'url' => 'shop',
//                'title' => 'Shop',
            ])->first();

            if ($request->get('parent_id') == 0){
                $rel_id = $shop->id;
            }else{
                $rel_id = 0;
            }

            $requestData = array_merge($request->only('title', 'drm_ref_id'), [
                'url' => mw()->url_manager->slug($request->get('title')).'-'.rand(),
                'parent_id' => $request->get('parent_id'),
                'rel_type' => 'content',
                'rel_id' => $rel_id,
                'is_hidden' => 1,
                'category_subtype' => 'default',
                'data_type' => 'category',
                'position' => $position,
            ]);

            $data = $this->service->store($requestData);
            $cat_ids['id'] = $data['parent_id'];
            category_hide($cat_ids);
            app()->log_manager->save('is_system=y');

            return response()->json((new CategoryPresenter($data))->get());
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    public function update($id, Request $request): \Illuminate\Http\JsonResponse
    {
        $shop = Content::where([
            'content_type' => 'page',
            'url' => 'shop',
//            'title' => 'Shop',
        ])->first();

        if ($request->get('parent_id') == 0){
            $rel_id = $shop->id;
        }else{
            $rel_id = 0;
        }

        $cat_url = Category::where('drm_ref_id' , '=' , $id)->select('url','position')->first();
        if(isset($cat_url->url)){
            $url = $cat_url->url;
        }else{
            $url = mw()->url_manager->slug($request->get('title')).'-'.rand();
        }
        if(isset($cat_url->position)){
            $position = $cat_url->position;
        }else{
            $position = @DB::table('categories')->max('position')+1;
        }
        try {
            $data = $this->service->update($id, array_merge(
                    $request->only('title'),
                    [
                        'url' => $url,
                        'parent_id' => $request->get('parent_id'),
                        'rel_type' => 'content',
                        'rel_id' => $rel_id,
                        'category_subtype' => 'default',
                        'data_type' => 'category',
                        'position' => $position,
                    ]
                )
            );

            $cat_ids['id'] = $data['parent_id'];
            category_hide($cat_ids);

            cat_reset_by_drm($data['id']);

            app()->log_manager->save('is_system=y');

            return response()->json((new CategoryPresenter($data))->get());
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        try {
            $cat_ids['id'] = Category::where('drm_ref_id', $id)->first()->id;
            DB::table('categories_items')->where('parent_id',$cat_ids['id'])->delete();
            category_hide($cat_ids);
            $data = $this->service->destroy($id);
            app()->log_manager->save('is_system=y');

            return response()->json(['success' => true, 'message' => 'Category deleted successfully', 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    public function __destruct()
    {
        Artisan::call('cache:clear');
    }

}
