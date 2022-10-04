<?php
//this function run the google analytical script for seo data

if (!function_exists('dt_google_analytical_product_script')) {
    function dt_google_analytical_product_script($id, $v){
        $params = array("id" => $id);
        $info = get_content($params);
        if(isset($info)){
            // dd($info);
            $image = '"';
            $sku = "";
            $name = "";
            $url = site_url();
            $des = strip_tags($info[0]['content_body']);
            // $des = substr($des, 0, 10);
            if(isset($info[0]['media'])){
                $count = count($info[0]['media']);
            }else{
                $count = 0;
            }
            for($i=0;$i<$count;$i++){
                $image .= $info[0]['media'][$i]['filename'];
                if(($i+1)<$count){
                    $image.='",
                    "';
                }
                elseif(($i+1)==$count){
                    $image.='"';
                }
            }
            $brand = $info[0]['brand'] ?? null;
            if(isset($info[0]['contentData'])){
                $count = count($info[0]['contentData']);
            }else{
                $count = 0;
            }
            for($i=0;$i<$count;$i++){
                if($info[0]['contentData'][$i]['field_name'] == "sku"){
                    if($info[0]['contentData'][$i]['field_value']!=null){
                        $sku = $info[0]['contentData'][$i]['field_value'];
                    }
                }
            }
            $brand_show ="";
            if($brand != null){
                $brand_show = <<<EOD
                "brand": {
                                "@type": "Brand",
                                "name": "{$brand}"
                                },
                EOD;
            }
            if($info[0]['created_by'] != null){
                $user_id = $info[0]['created_by'];
                $name = user_name($user_id, $mode = 'full');
            } else{
                $user_id = (int) get_users("is_admin=1")[0]['id'];
                $name = user_name($user_id, $mode = 'full');
            }
            $offers = "";
            $offer_check = DB::table('offers')->where('product_id', $id)->first();
            if(isset($offer_check)){
                $time = date('Y-m-d', strtotime($offer_check->expires_at));
                $offers = <<<EOD
                "offers": {
                                "@type": "Offer",
                                "url": "{$info[0]['url']}",
                                "price": "{$v}",
                                "priceCurrency": "EUR",
                                "priceValidUntil": "{$time}",
                                "availability": "https://schema.org/InStock"
                                }
                EOD;
            }
            else{
                $time = date('Y-m-d', strtotime('now'. ' +'.'60 days'));
                $offers = <<<EOD
                "offers": {
                                "@type": "Offer",
                                "url": "{$info[0]['url']}",
                                "price": "{$v}",
                                "priceCurrency": "EUR",
                                "priceValidUntil": "{$time}",
                                "availability": "https://schema.org/InStock"
                                }
                EOD;
            }
            // dd($offer_check);
            template_head('<script type="application/ld+json">
            {
                "@context": "https://schema.org/",
                "@type": "Product",
                "name": "'.$info[0]['title'].'",
                "image": [
                    '.$image.'
                ],
                "description": "'.$des.'",
                "sku": "'.$sku.'",
                "author": {
                "@type": "Person",
                "name": "'.$name.'"
                },
                "datePublished": "'.date('Y-m-d',strtotime($info[0]['created_at'])).'",
                '.$brand_show.'
                '.$offers.'
            }
            </script>');
        }
    }
}
if (!function_exists('basicGoogleAnalytical')) {
    function basicGoogleAnalytical()
    {
        $ads_id = get_option('google-ads-id', 'website');
        $tags_id = get_option('google-tag-manager-id', 'website');
        if ($ads_id) {
            template_head("<script async src='https://www.googletagmanager.com/gtag/js?id=AW-" . $ads_id . "'></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', 'AW-" . $ads_id . "');
        </script>");
        }
        if ($tags_id) {
            template_head("<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id=" . $tags_id . "'+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','" . $tags_id . "');</script>");
        }
    }
}
if (!function_exists('googleAnalyticalOrder')) {
    function googleAnalyticalOrder($price, $currency, $id)
    {
        $ads_label = get_option('google-ads-label', 'website');
        $ads_id = get_option('google-ads-id', 'website');
        if ($ads_label && $ads_id) {
            template_head("<script>
		  gtag('event', 'conversion', {
		      'send_to': 'AW-" . $ads_id . "/" . $ads_label . "',
		      'value': " . $price . ",
		      'currency': '" . $currency . "',
		      'transaction_id': '" . $id . "'
		  });
		</script>");
        }
    }
}

if (!function_exists('dt_google_analytical_ecommerce_tracking')) {
    function dt_google_analytical_ecommerce_tracking($id){
        $url_string = url()->previous();
        if(strpos($url_string, "thank-you") !== false){
            $product_rel = <<<EOD
            item_list_id: "Thank-You Page Upsell",
            item_list_name: "Thank-You Page Upsell",
            EOD;
        } else{
            if(Config::get('custom.item_list') != null){
                $product_rel = <<<EOD
                item_list_id: "Homepage-products",
                item_list_name: "Homepage Products",
                EOD;
            } else{
                $product_rel = <<<EOD
                item_list_id: "related-products",
                item_list_name: "Related Products",
                EOD;
            }
        }
        Config::set('custom.item_list', null);
        Config::save(array('custom'));
        $order_details = get_order_by_id($id);
        $item_deatils = get_cart("order_id=$id");
        $coupon = "";
        $discount = "";
        $hasCoupon = DB::table('cart_coupons')->first();
        if($hasCoupon){
            $coupon =<<<EOD
            coupon: "{$hasCoupon->coupon_name}",
            EOD;
            $discount =<<<EOD
            discount: {$hasCoupon->discount_value},
            EOD;
        }
        $transaction_data =<<<EOD
        gtag("event", "purchase", {
            currency: "EUR",
            transaction_id: "{$order_details['id']}",
            value: {$order_details['amount']},
            affiliation: "Google Store",
            {$coupon}
            shipping: {$order_details['shipping']},
            tax: {$order_details['taxes_amount']},
            items: [
        EOD;
        $text = "";
        if($item_deatils){
        foreach($item_deatils as $item){
            $category = "";
            $cat = DB::table('categories_items')->where('rel_id', $id)->first();
            $param = array("id"=>$item['rel_id']);
            $item_content = get_content($param);
            $price =  taxPrice($item['price']);
            $price = $price + $item['price'];
            if($cat){
                $cat_details = DB::table('categories')->where('id', $cat->parent_id)->first();
                if($cat_details){
                    $category = $cat_details->title;
                }
            }
            $brand = $item_content[0]['brand'] ?? "";
            $weight = $item_content[0]['single_size'] ?? "";
            $category = "";
            $cat = DB::table('categories_items')->where('rel_id', $item['rel_id'])->first();
            if($cat){
                $cat_details = DB::table('categories')->where('id', $cat->parent_id)->first();
                if($cat_details){
                    $category = $cat_details->title;
                }
            }
            $sku = "";
            if(isset($item['content_data']['sku'])){
                $sku = $item['content_data']['sku'];
            }
            $item_data = <<<EOD
                    {
                        item_id: "{$item['rel_id']}",
                        item_name: "{$item['title']}",
                        affiliation: "Google Store",
                        {$coupon}
                        currency: "EUR",
                        {$discount}
                        index: {$order_details['id']},
                        item_brand: "{$brand}",
                        item_category: "{$category}",
                        {$product_rel}
                        item_variant: "{$weight}",
                        price: {$price},
                        quantity: {$item['qty']}
                        },
             EOD;
             $text=$text."\n\t".$item_data;
        }
        template_head("<script>{$transaction_data}
             {$text}
            ]
            });
            </script>");
        }
    }
}

if (!function_exists('dt_google_analytical_view_item')) {
    function dt_google_analytical_view_item($id, $price){
        $params = array("id" => $id);
        $info = get_content($params);
        $coupon = "";
        $discount = "";
        $hasCoupon = DB::table('cart_coupons')->first();
        if($hasCoupon){
            $coupon =<<<EOD
            coupon: "{$hasCoupon->coupon_name}",
            EOD;
            $discount =<<<EOD
            discount: {$hasCoupon->discount_value},
            EOD;
        }
        $category = "";
        $cat = DB::table('categories_items')->where('rel_id', $id)->first();
        if($cat){
            $cat_details = DB::table('categories')->where('id', $cat->parent_id)->first();
            if($cat_details){
                $category = $cat_details->title;
            }
        }
        // dd($info);
        $sku = "";
        $brand = $info[0]['brand'] ?? "";
        $weight = $info[0]['single_size'] ?? "";
        $count = count($info[0]['contentData']);
        for($i=0;$i<$count;$i++){
            if($info[0]['contentData'][$i]['field_name'] == "sku"){
                if($info[0]['contentData'][$i]['field_value']!=null){
                    $sku = $info[0]['contentData'][$i]['field_value'];
                }
            }
        }
        $script =<<<EOD
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag("event", "view_item", {
            currency: "EUR",
            value: {$price},
            items: [
              {
                item_id: "{$info[0]['id']}",
                item_name: "{$info[0]['title']}",
                affiliation: "Google Store",
                {$coupon}
                currency: "EUR",
                {$discount}
                index: {$info[0]['id']},
                item_brand: "{$brand}",
                item_category: "{$category}",
                item_list_id: "related_products",
                item_variant: "{$weight}",
                price: {$price},
                quantity: 1
              }
            ]
          });
        EOD;
        template_head("<script>{$script}</script>");
    }
}

if (!function_exists('dt_google_analytical_checkout')) {
    function dt_google_analytical_checkout($data){
        // dd($data);
        $coupon = "";
        $discount = "";
        $hasCoupon = DB::table('cart_coupons')->first();
        if($hasCoupon){
            $coupon =<<<EOD
            coupon: "{$hasCoupon->coupon_name}",
            EOD;
            $discount =<<<EOD
            discount: {$hasCoupon->discount_value},
            EOD;
        }
        $main_part =<<<EOD
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag("event", "begin_checkout", {
            currency: "EUR",
            value: 7.77,
            {$coupon}
            items: [
        EOD;
        $text = "";
        foreach($data as $item){
            $price =  taxPrice($item['price']);
            $price = $price + $item['price'];
            $param = array("id"=>$item['rel_id']);
            $details = get_content($param);
            $sku = "";
            if(isset($item['content_data']['sku'])){
                $sku = $item['content_data']['sku'];
            }
            $brand = $details[0]['brand'] ?? "";
            $category = "";
            $cat = DB::table('categories_items')->where('rel_id', $item['rel_id'])->first();
            if($cat){
                $cat_details = DB::table('categories')->where('id', $cat->parent_id)->first();
                if($cat_details){
                    $category = $cat_details->title;
                }
            }
            $item_data =<<<EOD
            {
                  item_id: "{$item['rel_id']}",
                  item_name: "{$item['title']}",
                  affiliation: "Google Store",
                  {$coupon}
                  currency: "EUR",
                  {$discount}
                  index: {$item['rel_id']},
                  item_brand: "{$brand}",
                  item_category: "{$category}",
                  item_list_id: "related_products",
                  price: {$price},
                  quantity: {$item['qty']}
                },
            EOD;
            $text=$text."\n\t".$item_data;
        }
        template_head("<script>{$main_part}
             {$text}
    ]
    });
    </script>");
    }
}
