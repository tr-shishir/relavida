<?php
namespace App\Services;

use Apiz\AbstractApi;

class DrmSyncService extends AbstractApi
{
    private $base_url;

    public function __construct($base_url = null)
    {
        $this->base_url = $base_url;
        parent::__construct();
    }

    protected function getBaseURL()
    {
        return !empty($this->base_url) ? $this->base_url : config('global.drm_base_url');
    }

    public function getPrefix()
    {
        return 'api/v1/sync';
    }

    protected function getDefaultHeaders()
    {
        return [
            'userToken' => config('microweber.userToken'),
            'userPassToken' => config('microweber.userPassToken'),
        ];
    }

    /*
     * Category Sync to DRM
     */
    public function storeCategory($data)
    {
        return $this->apizRequest('categories', 'post', $data);
    }

    public function updateCategory($id, $data)
    {
        return $this->apizRequest('categories/'.$id, 'put', $data);
    }

    public function deleteCategory($id)
    {
        return $this->apizRequest('categories/'.$id, 'delete');
    }

    /*
     * Customer Sync
     */
    public function storeCustomer($data = [])
    {
        return $this->apizRequest('customers', 'post', $data);
    }

    public function updateCustomer($id, $data = [])
    {
        return $this->apizRequest('customers/'.$id, 'put', $data);
    }

    public function deleteCustomer($id)
    {
        return $this->apizRequest('customers/'.$id, 'delete');
    }

    /*
        Product sync
    */
    public function storeProduct($data = [])
    {
        return $this->apizRequest('products/', 'post', $data);
    }

    public function updateProduct($id, $data = [])
    {
        return $this->apizRequest('products/'.$id, 'put', $data);
    }

    public function deleteProduct($id)
    {
        return $this->apizRequest('products/'.$id, 'delete');
    }

    /*
     * Sync Order to DRM
     */

    public function storeOrderTest($data)
    {
        return $this->apizRequest('orderstest', 'post', $data);
    }

    public function storeOrder($data)
    {
        return $this->apizRequest('orders', 'post', $data);
    }

    public function updateOrder($id, $data = [])
    {
        return $this->apizRequest('orders/'.$id, 'delete');
    }

    /*
     * Sync request
     */
    public function requestForSyncFromDT($data)
    {
        return $this->apizRequest('pull-history', 'post', $data);
    }

    public function apizRequest($uri, $method = 'post', $data = [])
    {
        $response = $this->withJson($data)->{$method}($uri);

        if ($response->getStatusCode() === 200) {
            return $response()->toArray();
        }

        return [];
    }
    public function createCustomer ($data)
        {
            return $this->apizRequest('create-customer', 'post', $data);
        }
}
