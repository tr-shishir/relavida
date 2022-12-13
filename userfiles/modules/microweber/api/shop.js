// JavaScript Document
mw.require('forms.js');


mw.cart = {

    add_and_checkout: function (content_id, price, c) {
        if (typeof(c) == 'undefined') {
            var c = function () {
                window.location.href = mw.settings.api_url + 'shop/redirect_to_checkout';
            }
        }
        return mw.cart.add_item(content_id, price, c);
    },

    add_item: function (content_id, price, c) {
        var data = {};
        if (content_id == undefined) {
            return;
        }

        data.content_id = content_id;

        if (price != undefined && data != undefined) {
            data.price = price;
        }

        $.post(mw.settings.api_url + 'update_cart', data,
            function (data) {

             //   mw.cart.after_modify(data);


                if (typeof c === 'function') {
                    c.call(data);
                }
                mw.cart.after_modify(data,['mw.cart.add']);

              //  mw.trigger('mw.cart.add', [data]);
            });
    },

    add_item_v2: function (content_id, price, c) {
        var data = {};
        if (content_id == undefined) {
            return;
        }

        data.content_id = content_id;

        if (price != undefined && data != undefined) {
            data.price = price;
        }

        $.post(mw.settings.api_url + 'update_cart_v2', data,
            function (data) {

             //   mw.cart.after_modify(data);


                if (typeof c === 'function') {
                    c.call(data);
                }
                mw.cart.after_modify(data,['mw.cart.add']);

              //  mw.trigger('mw.cart.add', [data]);
            });
    },

    add_item_bundle: function (content_id, qty) {
        var data = {};
        if (content_id == undefined) {
            return;
        }

        data.content_id = content_id;

        if (qty != undefined && qty != undefined) {
            data.qty = qty;
        }

        $.post(mw.settings.api_url + 'update_cart', data,
            function (data) {

             //   mw.cart.after_modify(data);

                mw.cart.after_modify(data,['mw.cart.add']);

              //  mw.trigger('mw.cart.add', [data]);
            });
    },

    add: function (selector, price, c, status) {
        var data = mw.form.serialize(selector);
		if (status != null) {
            var value=document.getElementById('valueSub').value;
            if(value==1){
                var cycle=document.getElementById('cycles').value;
                var sub=document.getElementById('subId').value;
                var pro_id=document.getElementById('pId').value;
                var pro_price=document.getElementById('totalPrice').value;
                var uID = document.getElementById('uId').value;
                if(sub!=0)
                {
                    // window.alert(pro_id);
                    $.post("<?=api_url('save_sub_cart')?>", {
                        product_id: pro_id,
                        subscription_id: sub,
                        order_price : pro_price,
                        cycles : cycle,
                        user_id: uID

                        }).then((res, err) => {
                            console.log(res, err);
                        });
                }
            }
        } else{
            $.post("<?=api_url('delete_sub_session') ?>").
            then((res, err) => {
                console.log(res, err);
            });
        }


        var is_form_valid = true;
        mw.$('[required],.required', selector).each(function () {

            if (!this.validity.valid) {
                is_form_valid = false

                var is_form_valid_check_all_fields_tip = mw.tooltip({
                    id: 'mw-cart-add-invalid-form-tooltip-show',
                    content: 'This field is required',
                    close_on_click_outside: true,
                    group: 'mw-cart-add-invalid-tooltip',
                    skin: 'warning',
                    element: this
                });


                return false;
            }
        });

        if (!is_form_valid) {
            return;
        }


        if (price != undefined && data != undefined) {
            data.price = price;
        }
        if (data.price == null) {
            data.price = 0;
        }
        $.post(mw.settings.api_url + 'update_cart', data,
            function (data) {

               // mw.trigger('mw.cart.add', [data]);

                if (typeof c === 'function') {
                    c.call(data);
                }
                mw.cart.after_modify(data,['mw.cart.add']);



            });
			 $.post("<?=api_url('ecommerce_tracking_add_cart')?>",{
                id: data
            },(res) => {
                $(".main").append(res.message);
            }).then((res, err) => {
                console.log(res, err);
                });

			if (status != null) {
                if(value==1){
                    if(sub!=0){
                        window.location.href = "<?=url('/')?>/checkout";
                    }
                }
            }

    },

    add_v2: function (selector, price, c, status) {
        var data = mw.form.serialize(selector);
		if (status != null) {
            var value=document.getElementById('valueSub').value;
            if(value==1){
                var cycle=document.getElementById('cycles').value;
                var sub=document.getElementById('subId').value;
                var pro_id=document.getElementById('pId').value;
                var pro_price=document.getElementById('totalPrice').value;
                var uID = document.getElementById('uId').value;
                if(sub!=0)
                {
                    // window.alert(pro_id);
                    $.post("<?=api_url('save_sub_cart')?>", {
                        product_id: pro_id,
                        subscription_id: sub,
                        order_price : pro_price,
                        cycles : cycle,
                        user_id: uID

                        }).then((res, err) => {
                            console.log(res, err);
                        });
                }
            }
        } else{
            $.post("<?=api_url('delete_sub_session') ?>").
            then((res, err) => {
                console.log(res, err);
            });
        }


        var is_form_valid = true;
        mw.$('[required],.required', selector).each(function () {

            if (!this.validity.valid) {
                is_form_valid = false

                var is_form_valid_check_all_fields_tip = mw.tooltip({
                    id: 'mw-cart-add-invalid-form-tooltip-show',
                    content: 'This field is required',
                    close_on_click_outside: true,
                    group: 'mw-cart-add-invalid-tooltip',
                    skin: 'warning',
                    element: this
                });


                return false;
            }
        });

        if (!is_form_valid) {
            return;
        }


        if (price != undefined && data != undefined) {
            data.price = price;
        }
        if (data.price == null) {
            data.price = 0;
        }
        $.post(mw.settings.api_url + 'update_cart_v2', data,
            function (data) {

               // mw.trigger('mw.cart.add', [data]);

                if (typeof c === 'function') {
                    c.call(data);
                }
                mw.cart.after_modify(data,['mw.cart.add']);



            });
			 $.post("<?=api_url('ecommerce_tracking_add_cart')?>",{
                id: data
            },(res) => {
                $(".main").append(res.message);
            }).then((res, err) => {
                console.log(res, err);
                });

			if (status != null) {
                if(value==1){
                    if(sub!=0){
                        window.location.href = "<?=url('/')?>/checkout";
                    }
                }
            }

    },

    remove: function ($id) {
        var data = {}
        data.id = $id;
        sessionStorage.setItem('delete_cart',false);

		$.post("<?=api_url('delete_sub_cart')?>", {
            id : $id

             }).then((res, err) => {
             console.log(res, err);
             });


        $.post("<?=api_url('delete_sub_session') ?>").
        then((res, err) => {
            console.log(res, err);
        });

        $.post(mw.settings.api_url + 'remove_cart_item', data,
            function (data) {
                var parent = mw.$('.mw-cart-item-' + $id).parent();
                mw.$('.mw-cart-item-' + $id).fadeOut(function () {
                    mw.$(this).remove();
                    if (parent.find(".mw-cart-item").length == 0) {

                    }
                });
                //mw.cart.after_modify();
                // mw.reload_module('shop/cart');
                // mw.reload_module('shop/shipping');
                // mw.trigger('mw.cart.remove', [data]);
                mw.cart.after_modify(data,['mw.cart.remove']);

            });
    },

    qty: function ($id, $qty) {
        var data = {}
        data.id = $id;
        data.qty = $qty;
        $.post(mw.settings.api_url + 'get_product_stock_by_id', data)
         .then(function (res) {
             if(res == 0){
                 swal({
                     text: "This product is out of limit. Have no more stock",
                 });
            } else if(res == 1){
                $.post(mw.settings.api_url + 'update_cart_item_qty', data,
                    function (data) {
                        mw.cart.after_modify(data,['mw.cart.qty']);
                    });
             }
         });



    },

    after_modify: function (data, events_to_trigger) {



        var modules = ["shop/cart", "shop/shipping", "shop/payments"].filter(function(module){
            return !!document.querySelector('[data-type="'+ module +'"');
        });

        var events = ['mw.cart.modify'];

        if(!!events_to_trigger) {
            var events = events.concat(events_to_trigger);
         }



        if(modules.length) {
            mw.reload_modules(modules, function (data) {
                events.forEach(function(item){
                    mw.trigger(item, [data]);
                })
            }, true);
        } else {
            events.forEach(function(item){
                mw.trigger(item, [data]);
            })
        }


        // mw.reload_module('shop/cart');
        // mw.reload_module('shop/shipping');
        // mw.reload_module('shop/payments');



        if((typeof data == 'object') && typeof data.cart_items_quantity !== 'undefined'){
            $('.js-shopping-cart-quantity').html(data.cart_items_quantity);
        }


        mw.trigger('mw.cart.after_modify', data);





    },

    checkout: function (selector, callback) {
        sessionStorage.setItem('selector', JSON.stringify(selector));
        sessionStorage.setItem('callback', JSON.stringify(callback));

        var form = mw.$(selector);

        $( document ).trigger( "checkoutBeforeProcess", form );

        var state = form.dataset("loading");
        if (state == 'true') return false;
        form.dataset("loading", 'true');
        form.find('.mw-checkout-btn').attr('disabled', 'disabled');
        form.find('.mw-checkout-btn').hide();

        setTimeout(function(){

            var form = mw.$(selector);

            var obj = mw.form.serialize(form);

            sessionStorage.setItem('obj', JSON.stringify(obj));

            sessionStorage.setItem('form', JSON.stringify(form));



        $.ajax({
            type: "POST",
            url: mw.settings.api_url + 'checkout',
            data: obj
        })
            .done(function (data) {

				let type = data.type ?? false;

                if(type == 'subscription' || type == 'easy'){
                    window.location.href = data.redirect;
                }

                sessionStorage.setItem('data', JSON.stringify(data));

                mw.trigger('checkoutDone', data);

                if(data.errors){
                    mw.notification.warning("Please fill up all required field");
                }


                if(data.error !== undefined) {
                    alert (data.error);
                    console.log(data);
                    return false;
                }


                var data2 = data;

                if (data != undefined) {
                    mw.$(selector + ' .mw-cart-data-btn').removeAttr('disabled');
                    mw.$('[data-type="shop/cart"]').removeAttr('hide-cart');


                    if (typeof(data2.error) != 'undefined') {
                        mw.$(selector + ' .mw-cart-data-holder').show();
                        if (typeof(data2.error.address_error) != 'undefined') {
                            var form_with_err = form;
                           var isModalForm = $(form_with_err).attr('is-modal-form')

                          if(isModalForm){
                              mw.cart.modal.showStep(form_with_err, 'delivery-address');
                          }
                          mw.notification.error('Please fill your address details');

                        }

                        mw.response(selector, data2);
                    } else if (typeof(data2.success) != 'undefined') {


                        if (typeof callback === 'function') {
                            callback.call(data2.success);

                        } else if (typeof window[callback] === 'function') {
                            window[callback](selector, data2.success);
                        } else {

                            mw.$('[data-type="shop/cart"]').attr('hide-cart', 'completed');
                            mw.reload_module('shop/cart');
                            mw.$(selector + ' .mw-cart-data-holder').hide();
                            mw.response(selector, data2);
                        }


                        mw.trigger('mw.cart.checkout.success', data2);


                        if (typeof(data2.redirect) != 'undefined') {

                            setTimeout(function () {
                                window.location.href = data2.redirect;
                            }, 10)

                        }


                    } else if (parseInt(data) > 0) {
                        mw.$('[data-type="shop/checkout"]').attr('view', 'completed');
                        mw.reload_module('shop/checkout');
                    } else {
                        if (obj.payment_gw != undefined) {
                            var callback_func = obj.payment_gw + '_checkout';
                            if (typeof window[callback_func] === 'function') {
                                window[callback_func](data, selector);
                            }
                            var callback_func = 'checkout_callback';
                            if (typeof window[callback_func] === 'function') {
                                window[callback_func](data, selector);
                            }
                        }
                    }

                }
                form.dataset("loading", 'false');
                form.find('.mw-checkout-btn').removeAttr('disabled');
                form.find('.mw-checkout-btn').show();
                mw.trigger('mw.cart.checkout', [data]);
            });

        }, 1500);
    }
}



mw.cart.modal = {};

mw.cart.modal.init = function (root_node) {
    mw.cart.modal.bindStepButtons(root_node);

/*
    var inner_cart_module = $(root_node).find('[parent-module-id="js-ajax-cart-checkout-process"]')[0];
*/
    var inner_cart_module = $(root_node).find('[id="cart_checkout_js-ajax-cart-checkout-process"]')[0];
    if(inner_cart_module ){
        var check  = $(document).find('[id="'+inner_cart_module.id+'"]').length
        mw.on.moduleReload(inner_cart_module.id);
    }
};


mw.cart.modal.bindStepButtons = function (root_node) {
    if(typeof root_node === 'string') {
        root_node = mw.$(root_node);
    }

    if(root_node[0]._bindStepButtons) {
        return;
    }
    root_node[0]._bindStepButtons = true;

     var checkout_form = $(root_node).find('form').first();


    $('body').on("mousedown touchstart", '.js-show-step', function () {
        var step = $(this).attr('data-step');

        mw.cart.modal.showStep(checkout_form, step);



    });
};

mw.cart.modal.showStep = function (form, step) {


    var prevStep = mw.$('.js-show-step.active', form).data('step');

    if(prevStep === step) return;

    var prevHolder =  $(form).find('.js-' + prevStep).first();

    $(form).attr('is-modal-form',true);

    if (step === 'checkout-complete') {
        return;
    }

    var validate = function (callback) {
        var hasError = false;
        mw.$('input,textarea,select', prevHolder).each(function () {
            if (!this.checkValidity()) {
                mw.$(this).addClass('is-invalid');
                hasError = true;
            } else {
                mw.$(this).removeClass('is-invalid');
            }
        });
        if (step === 'payment-method'  || step === 'preview') {
            if (hasError) {
                step = 'delivery-address';
                callback.call(undefined, hasError, undefined, step);
            }
        }
        if (step === 'payment-method') {
            $.post(mw.settings.api_url + 'checkout/validate', mw.serializeFields(prevHolder), function (data) {
                if(!data.valid){
                step = 'delivery-address';
                }
                callback.call(undefined, !data.valid, undefined, step);

            }).fail(function (data){
                mw.errorsHandle(data)
            });
        } else {
            callback.call(undefined, hasError, undefined, step);
        }
    };

    validate(function (hasError, message, step){
        if (hasError) {
            message = message || 'Please fill properly the required fields';
            mw.notification.warning(message);
        }

        mw.$('.js-show-step').removeClass('active');
        mw.$('[data-step]').removeClass('active');
        mw.$('[data-step="' + step + '"]').addClass('active').parent().removeClass('muted');
        mw.$(this).addClass('active');
        var step1 = '.js-' + step;
        mw.$('.js-step-content').hide();
        mw.$(step1).show();

    });


};


mw.cart.modal.bindStepButtons__old = function (root_node) {
    if(typeof root_node === 'string') {
        root_node = mw.$(root_node);
    }

    if(root_node[0]._bindStepButtons) {
        return;
    }
    root_node[0]._bindStepButtons = true;

    root_node.find('.js-show-step').on( "mousedown touchstart" , function(  ) {

        var has_error = false;

        var form = mw.tools.firstParentWithTag(this, 'form');
        var prevStep = mw.$('.js-show-step.active', form).data('step');
        var step = this.dataset.step;

        if(prevStep === step) return;


        var prevHolder = form.querySelector('.js-' + prevStep);


        if (step === 'checkout-complete') {
            return;
        }
        mw.$('input,textarea,select', prevHolder).each(function () {
            if (!this.checkValidity()) {
                 mw.$(this).addClass('is-invalid');
                has_error = 1;
            } else {
                mw.$(this).removeClass('is-invalid');
            }
        });
        if (step === 'payment-method'  || step === 'preview') {
            if (has_error) {
                step = 'delivery-address';
            }
        }
        mw.$('.js-show-step').removeClass('active');
        mw.$('[data-step]').removeClass('active');
        mw.$('[data-step="' + step + '"]').addClass('active').parent().removeClass('muted');
        mw.$(this).addClass('active');
        var step1 = '.js-' + step;
        mw.$('.js-step-content').hide();
        mw.$(step1).show();
        if (has_error) {
            mw.notification.warning('Please fill the required fields');
        }
    });

}
