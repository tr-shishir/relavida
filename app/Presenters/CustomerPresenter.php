<?php


namespace App\Presenters;


use Illuminate\Database\Eloquent\Model;
use Nahid\Presento\Presenter;

class CustomerPresenter extends Presenter
{
    public function present(): array
    {
        return [
            'id',
            'drm_ref_id',
            'username',
            'email',
            'is_active',
            'first_name',
            'middle_name',
            'last_name',
            'thumbnail',
            'created_at',
            'updated_at',
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
