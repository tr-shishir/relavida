<?php


namespace App\Presenters;


use Illuminate\Database\Eloquent\Model;
use Nahid\Presento\Presenter;

class OrderPresenter extends Presenter
{
    public function present(): array
    {
        return [
            "id",
            "amount",
            "transaction_id",
            "currency",
            "currency_code",
            "first_name",
            "last_name",
            "email",
            "country",
            "city",
            "state",
            "zip",
            "address",
            "address2",
            "phone",
            "order_completed",
            "is_paid",
            "url",
            "items_count",
            "custom_fields_data",
            "payment_gw",
            "payment_amount",
            "payment_currency",
            "payment_status",
            "payment_email",
            "payment_phone",
            "payment_type",
            "order_status",
            "is_active",
            "price",
            "shipping",
            "other_info",
            "promo_code",
            "skip_promo_code",
            "coupon_id",
            "discount_type",
            "discount_value",
            "taxes_amount",
            'tax_rate',
            "carts",
            'created_at',
            'updated_at',
            'shipping_name',
            'billing_name',
            'billing_country',
            'billing_city',
            'billing_state',
            'billing_zip',
            'billing_address',



        ];
    }

    public function convert($data)
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
