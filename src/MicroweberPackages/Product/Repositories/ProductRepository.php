<?php

namespace MicroweberPackages\Product\Repositories;

use MicroweberPackages\Core\Repositories\BaseRepository;
use MicroweberPackages\Product\Events\ProductIsCreating;
use MicroweberPackages\Product\Events\ProductIsUpdating;
use MicroweberPackages\Product\Events\ProductWasCreated;
use MicroweberPackages\Product\Events\ProductWasDeleted;
use MicroweberPackages\Product\Events\ProductWasUpdated;
use MicroweberPackages\Product\Models\ProductDt;

class ProductRepository extends BaseRepository
{

    public function __construct(ProductDt $product)
    {
        $this->model = $product;
    }

    public function create($data)
    {
        event($event = new ProductIsCreating($data));
        
        $data = collect(array($data))->map(function($item){
            $item['vk_price'] = $item['price'];
            $item['sku'] = $item['content_data']['sku'];
            $item['quantity'] = $item['content_data']['qty'];
            $item['special_price'] = $item['content_data']['special_price'];
            $item['description'] = $item['content_body'];
            return $item;
        })->toArray()[0];

        $product = $this->model->create($data);

        event(new ProductWasCreated($product, $data));

        return $product;
    }

    public function update($data, $id)
    {
        $product = $this->model->find($id);

        event($event = new ProductIsUpdating($product, $data));

        $product->update($data);

        event(new ProductWasUpdated($product, $data));

        return $product;
    }


    public function delete($id)
    {
        $product = $this->model->find($id);

        event(new ProductWasDeleted($product));

        return $product->delete();
    }


    public function destroy($ids)
    {
        event(new ProductWasDestroy($ids));

        return $this->model->destroy($ids);
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

}
