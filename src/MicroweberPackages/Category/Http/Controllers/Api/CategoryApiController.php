<?php
/**
 * Created by PhpStorm.
 * User: Bojidar
 * Date: 8/19/2020
 * Time: 4:09 PM
 */
namespace MicroweberPackages\Category\Http\Controllers\Api;

use App\Enums\SyncEvent;
use App\Enums\SyncType;
use App\Models\SyncHistory;
use MicroweberPackages\App\Http\Controllers\AdminDefaultController;
use Illuminate\Support\Facades\DB;
use MicroweberPackages\Category\Http\Requests\CategoryRequest;
use MicroweberPackages\Category\Repositories\CategoryRepository;

class CategoryApiController extends AdminDefaultController
{
    public $category;

    public function __construct(CategoryRepository $category)
    {
        $this->category = $category;
    }

    /**
     * Display a listing of the product.\
     *
     * @param CategoryRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->category->all();
    }

    /**
     * Store product in database
     * @param CategoryRequest $request
     * @return mixed
     */
    public function store(CategoryRequest $request)
    {
        $id = $this->category->create($request->all());
//        if (env('SYNC_ENABLE') && $id) {
        if ($id) {
            SyncHistory::create([
                'sync_type' => SyncType::CATEGORY,
                'sync_event' => SyncEvent::CREATE,
                'model_id' => $id
            ]);
        }

        return $id;
    }

    /**
     * Display the specified resource.show
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->category->find($id);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  CategoryRequest $request
     * @param  string $id
     * @return Response
     */
    public function update(CategoryRequest $request, $id)
    {
        $data = $this->category->update($request->all(), $id);
//        if (env('SYNC_ENABLE') && $id) {
        if ($id) {
            SyncHistory::create([
                'sync_type' => SyncType::CATEGORY,
                'sync_event' => SyncEvent::UPDATE,
                'model_id' => $id
            ]);
        }

        return $data;
    }

    /**
     * Destroy resources by given ids.
     *
     * @param string $ids
     * @return void
     */
    public function delete($id)
    {
        $category = $this->category->find($id);
//        if (env('SYNC_ENABLE') && !empty($category->drm_ref_id)) {
        if (!empty($category->drm_ref_id)) {
            SyncHistory::create([
                'sync_type' => SyncType::CATEGORY,
                'sync_event' => SyncEvent::DELETE,
                'model_id' => $id,
                'drm_ref_id'=> $category->drm_ref_id,
            ]);
        }
        DB::table('categories_items')->where('parent_id',$id)->delete();


        return $this->category->delete($id);
    }

    /**
     * Delete resources by given ids.
     *
     * @param string $ids
     * @return void
     */
    public function destroy($ids)
    {
        if(!is_array($ids)) {
            $ids = array($ids);
        }
        foreach ($ids as $id) {
            $category = $this->category->find($id);
//            if (env('SYNC_ENABLE') && !empty($category->drm_ref_id)) {
            if (!empty($category->drm_ref_id)) {
                SyncHistory::create([
                    'sync_type' => SyncType::CATEGORY,
                    'sync_event' => SyncEvent::DELETE,
                    'model_id' => $id,
                    'drm_ref_id'=> $category->drm_ref_id,
                ]);
            }
            $cat_ids['id'] = $id;
            DB::table('categories_items')->where('parent_id',$id)->delete();
            category_hide($cat_ids);
        }

        return $this->category->destroy($ids);
    }

}
