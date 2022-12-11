<?php

namespace MicroweberPackages\Offer\Models;

use Illuminate\Database\Eloquent\Model;
use MicroweberPackages\Product\Models\Product;
use MicroweberPackages\Database\Traits\CacheableQueryBuilderTrait;

class Offer extends Model
{
    use CacheableQueryBuilderTrait;

    public $table = 'offers';

    public $fillable = [
        "product_id",
        "price_id",
        "offer_price",
        "created_at",
        "updated_at",
        "expires_at",
        "created_by",
        "edited_by",
        "is_active",
    ];

    /**
     * Get the product associated with the offer.
     */
    public function product()
    {
        return $this->hasOne(Product::class);
    }

    public static function add($offerData)
    {
        if (isset($offerData['product_id_with_price_id'])) {
            $id_parts = explode('|', $offerData['product_id_with_price_id']);
            $offerData['product_id'] = $id_parts[0];
            $offerData['price_id'] = (int)$id_parts[1];
        } else if (isset($offerData['product_id'])) {
            if (strstr($offerData['product_id'], '|')) {
                $id_parts = explode('|', $offerData['product_id']);
                $offerData['product_id'] = $id_parts[0];
            }
        }
        if (isset($offerData['offer_price'])) {
            $offerData['offer_price'] = mw()->format->amount_to_float($offerData['offer_price']);
        }

        if (isset($offerData['expires_at']) and $offerData['expires_at'] != '') {
            // >>> Format date
            try {
                $carbonExpiresAt = Carbon::parse($offerData['expires_at']);
                $offerData['expires_at'] = $carbonExpiresAt->format('Y-m-d H:i:s');
            } catch (\Exception $e) {
                //
            }
            // <<< Format date
        } else {
            $offerData['expires_at'] = null;
        }

        if (empty($offerData['is_active'])) {
            $offerData['is_active'] = 0;
        } elseif ($offerData['is_active'] == 'on') {
            $offerData['is_active'] = 1;
        }
        if(isset($offerData['id'])){
                $offer = Offer::updateOrCreate(
                    ['id' =>  $offerData['id']],
                    $offerData
                );
        } else {
            $offer = Offer::create(
                $offerData
            );
        }
        cache_delete('offers');

        return $offer;
    }

    public static function getAll()
    {
        $offers = Offer::select(
            'offers.id',
            'offers.product_id',
            'offers.offer_price',
            'offers.created_at',
            'offers.updated_at',
            'offers.expires_at',
            'offers.is_active',
            'product.title as product_title',
            'product.is_deleted',
            'product.vk_price as price'
        )
            // ->where(['product.id' ])
            ->join('product', 'offers.product_id', '=', 'product.id')
            ->paginate(10);

        return $offers;
    }

    public static function getPrice($productId = false, $priceId)
    {
        $query = Offer::where('price_id', $priceId);

        if ($productId) {
            $query->where('product_id', '=', $productId);
        }

        $res  = $query->first();

        if(!empty($res)) {
            return $res->toArray();
        } else {
            return [];
        }
    }

    public static function getByProductId($productId)
    {
        $offers = Offer::select(
            'offers.id',
            'offers.product_id',
            'offers.offer_price',
            'offers.created_at',
            'offers.updated_at',
            'offers.expires_at',
            'offers.is_active',
            'product.title as product_title',
            'product.is_deleted',
            'product.vk_price as price'
        )
            ->where('product.id' , $productId)
            ->join('product', 'offers.product_id', '=', 'product.id')
            ->get()
            ->toArray();

        $specialOffers = array();

        foreach ($offers as $offer) {

            if (!($offer['expires_at']) || $offer['expires_at'] == '0000-00-00 00:00:00' || (strtotime($offer['expires_at']) > strtotime("now"))) {
                // converting price_name to lowercase to match key from in FieldsManager function get line 556

                if (isset($offer['offer_price']) and $offer['offer_price'] and isset($offer['price'])) {

                    $price_change_direction = 'decrease';
                    $offer['offer_price'] = floatval($offer['offer_price']);
                    $offer['price'] = floatval($offer['price']);

                    $answer = abs($offer['price'] - $offer['offer_price']);
                    $offer['price_change_direction_sign'] = '-';
                    $offer['offer_value_difference'] = $answer;

                    if ($offer['offer_price'] > $offer['price']) {
                        $price_change_direction = 'increase';
                        $answer = abs($offer['price'] - $offer['offer_price']);
                        $offer['price_change_direction_sign'] = '+';
                        $offer['offer_value_difference'] = $answer;
                    }

                    $percent = mw()->format->percent($offer['offer_value_difference'], $offer['price']);
                    $offer['offer_value_difference_percent'] = $percent;
                    $offer['price_change_direction'] = $price_change_direction;
                }

                $specialOffers['price'] = $offer;

            }
        }

        return $specialOffers;
    }

    public static function getById($offerId)
    {
        $offer = Offer::find($offerId);
        $res = [];
        $additionalFields = [];

        if (isset($offer->id) and isset($offer->product_id)) {
            $prodOffers = self::getByProductId($offer->product_id);
            if ($prodOffers) {
                foreach ($prodOffers as $key => $prodOffer) {
                    if ($prodOffer['id'] == $offer['id']) {
                        $additionalFields = $prodOffer;
                    }
                }
            }
        }

        if (!empty($additionalFields)) {
            $res = array_merge($offer->toArray(), $additionalFields);
        } elseif(!empty($offer)) {
            $res = $offer->toArray();
        }

        return $res;
    }

    public static function deleteById($offerId)
    {
        if (!isset($offerId)) {
            return false;
        }

        $offer = Offer::find($offerId);

        if(!empty($offer)) {
            $offer->delete();
            $res = true;
        } else {
            $res = false;
        }

        return $res;
    }
}
