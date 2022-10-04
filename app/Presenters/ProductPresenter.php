<?php


namespace App\Presenters;


use Illuminate\Database\Eloquent\Model;
use Nahid\Presento\Presenter;

class ProductPresenter extends Presenter
{
    public function present(): array
    {
        return [
            'id',
            'drm_ref_id',
            'title',
            'url',
            'parent',
            'is_active',
            'ean',
            'created_at',
            'updated_at',
            'created_by',
        ];
    }

    public function convert($data): array
    {
        if ($data instanceof Model) {
            return $data->toArray();
        }

        if (isset($data['data'])) {
            return $data['data'];
        }

        return $data;
    }
}
