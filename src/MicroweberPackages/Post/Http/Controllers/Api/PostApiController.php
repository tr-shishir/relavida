<?php
/**
 * Created by PhpStorm.
 * User: Bojidar
 * Date: 8/19/2020
 * Time: 4:09 PM
 */
namespace MicroweberPackages\Post\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use MicroweberPackages\App\Http\Controllers\AdminDefaultController;
use MicroweberPackages\Post\Http\Requests\PostRequest;
use MicroweberPackages\Post\Repositories\PostRepository;
use Illuminate\Support\Facades\DB;

class PostApiController extends AdminDefaultController
{
    public $post;

    public function __construct(PostRepository $post)
    {
        $this->post = $post;
    }

    /**
     * Display a listing of the product.\
     *
     * @param PostRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return (new JsonResource(
            $this->post
                ->filter($request->all())
                ->paginate($request->get('limit', 30))
                ->appends($request->except('page'))

        ))->response();
    }

    /**
     * Store product in database
     * @param PostRequest $request
     * @return mixed
     */
    public function store(PostRequest $request)
    {

        $stores = (new JsonResource($this->post->create($request->all())));
        //store the blog information in blog table
        $blog_image_link = get_first_position_image_from_media($stores['id']);
        $blog_information = array(
            'content_id' => $stores['id'],
            'title' => $request->title,
            'content' => $request->content,
            'link' => $request->url,
            'image' => $blog_image_link,
            'created_at' => $request->created_at
        );
        insert_blog_information($blog_information);
        cat_reset_logic();
        return $stores;
    }

    /**
     * Display the specified resource.show
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return (new JsonResource($this->post->show($id)));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  PostRequest $request
     * @param  string $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        if(isset($request->content) && isset($_REQUEST['content']) && $request->content != $_REQUEST['content'] ){
            $newContent = array('content'=>change_content_value($_REQUEST['content']));
            $request->merge($newContent);
        }

        $updates = (new JsonResource($this->post->update($request->all(), $id)));

        if($request->is_active == 1){
            $blog_image_link = get_first_position_image_from_media($id);
            $blog_information = array(
                'title' => $request->title,
                'content' => $request->content,
                'link' => $request->url,
                'image' => $blog_image_link,
                'created_at' => $request->created_at,
                'updated_at' => $request->updated_at
            );
            update_or_insert_blog_information($id,$blog_information);
        }
        //end blog information end in blogs table
        cat_reset_logic();
        return $updates;
    }

    /**
     * Destroy resources by given ids.
     *
     * @param string $ids
     * @return void
     */
    public function delete($id)
    {
        return (new JsonResource($this->post->delete($id)));
    }

    /**
     * Delete resources by given ids.
     *
     * @param string $ids
     * @return void
     */
    public function destroy($ids)
    {
        return (new JsonResource($this->post->destroy($ids)));
    }

}
