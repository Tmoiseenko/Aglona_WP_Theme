jQuery( function( $ ) {

    $(document).ready(function () {

        function divideNumberByPieces(x, delimiter) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, delimiter || " ");
        }

        function formatOptions(state) {
            if (!state.id) {
                return state.text;
            }
            var $state = $(
                '<div class="basic-select__opt-mark"></div><span>' + state.text + '</span>'
            );
            return $state;
        };

        $('.js-select2-mark').select2({
            templateResult: formatOptions,
        });

        $('.js-select2-size').select2({
            templateResult: formatOptions,
        });


        var addHtmlWishTable = function () {
            var local_arr = JSON.parse(localStorage.getItem('WISH_LIST'));
            var html = '';
            if (local_arr.length) {
                for (var key in local_arr) {
                    html += '<div class="cat-cart__table-line js-cart-line">';
                    html += '<div class="cat-cart__top-b">';
                    html += '<div class="cat-cart__top-title">' + local_arr[key].title + '<span>мм</span></div>';
                    html += '<div class="cat-cart__top-text">марка: <span class="cat-cart-mark js-cat-cart-mark">' + local_arr[key].mark + '</span>';
                    html += 'цена: <span class="cat-cart-mark-price js-cat-cart-mark-price">' + local_arr[key].price + '</span>₽/т</div>';
                    html += '<div class="cat-cart__top-clear js-cat-cart-line-clear" data-id="' + local_arr[key].id + '"></div>';
                    html += '</div>';
                    html += '<div class="cat-cart__table-cells-b">';
                    html += '<div class="cat-cart__table-cell">';
                    html += '<div class="cat-cart__table-cell__title">Масса, т</div>';
                    html += '<div class="cat-cart__table-cell__weight-input-b">';
                    html += '<input class="cat-cart__table-cell__weight-input js-cat-cart-weight-input" data-id="' + local_arr[key].id + '" name="good_' + local_arr[key].id + '" type="text" value="' + local_arr[key].qty + '" autocompvare="off">';
                    html += '<div class="cat-cart__table-cell__weight-minus js-cat-cart-weight-minus"></div>';
                    html += '<div class="cat-cart__table-cell__weight-plus js-cat-cart-weight-plus"></div>';
                    html += '</div>';
                    html += '</div>';
                    html += '<div class="cat-cart__table-cell">';
                    html += '<div class="cat-cart__table-cell__title">Кол-во, пог. м</div>';
                    html += '<input class="cat-cart__table-cell__amount-input-b js-cat-cart-amount" data-id="' + local_arr[key].id + '" data-amount="' + local_arr[key].amount + '" name="amount_' + local_arr[key].id + '" type="text" value="' + local_arr[key].amount + '">';
                    html += '</div>';
                    html += '<div class="cat-cart__table-cell">';
                    html += '<div class="cat-cart__table-cell__price js-cat-cart-price" data-id="' + local_arr[key].id + '" data-price="47490">' + (local_arr[key].price * local_arr[key].qty) + ' ₽</div>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                }
            }
            return html;
        };


        if (localStorage.getItem('WISH_LIST') == null) {
            var local_arr = JSON.parse(localStorage.getItem('WISH_LIST'));
            localStorage.setItem('WISH_LIST', JSON.stringify(new Array()));

        } else {
            var local_arr = JSON.parse(localStorage.getItem('WISH_LIST'));
            $('.js-catalog-selection-count').html(local_arr.length);
            if (local_arr.length) {
                $('html').removeClass('_cart-1');
                $('html').addClass('_cart-2');
                for (var key in local_arr) {
                    $('.js-prod-cells-line[data-id=' + local_arr[key].id + ']').toggleClass('_added')
                }
                $('.js-cart-lines-wrap').html(addHtmlWishTable());
                $('.catalog__tabs-wrap__inner-wrap').height('auto');
            } else {
                $('html').addClass('_cart-1');

            }
        }
        ;


        $('html').on('click', '.js-cart-clear-all', function () {
            localStorage.setItem('WISH_LIST', JSON.stringify(new Array()));
            $('.js-cart-lines-wrap').html('');
            $('.js-prod-cells-line._added').removeClass('_added');
            $('html').removeClass('_cart-2');
            $('html').addClass('_cart-1');
            $('.js-catalog-selection-count').html('0');
        });


        $('html').on('click', '.js-cat-cart-line-clear', function () {
            var divId = $(this).data('id');
            $('.js-prod-cells-line[data-id=' + divId + ']').find('.js-cat-prod-item-add').click();
        });


        $('html').on('click', '.js-cat-cart-weight-plus', function () {
            var local_arr = JSON.parse(localStorage.getItem('WISH_LIST'));
            var qty = $(this).siblings('.js-cat-cart-weight-input');
            qty.val(parseInt(qty.val()) + 1);
            for (var key in local_arr) {
                if (local_arr[key].id == qty.data('id')) {
                    local_arr[key].qty = qty.val();
                }
            }
            var json_data = JSON.stringify(local_arr);
            localStorage.setItem('WISH_LIST', json_data);
            qty.change();
        });

        $('html').on('click', '.js-cat-cart-weight-minus', function () {
            var local_arr = JSON.parse(localStorage.getItem('WISH_LIST'));
            var qty = $(this).siblings('.js-cat-cart-weight-input');
            if (parseInt(qty.val()) == 1) {
                qty.val(1);
                for (var key in local_arr) {
                    if (local_arr[key].id == qty.data('id')) {
                        local_arr[key].qty = qty.val();
                    }
                }
            } else {
                qty.val(parseInt(qty.val()) - 1);
                for (var key in local_arr) {
                    if (local_arr[key].id == qty.data('id')) {
                        local_arr[key].qty = qty.val();
                    }
                }
            }
            var json_data = JSON.stringify(local_arr);
            localStorage.setItem('WISH_LIST', json_data);
            qty.change();
        });


        $('html').on('change', '.js-cat-cart-weight-input', function () {
            var weightId = $(this).data('id');
            var ammount = $('.js-cat-cart-amount[data-id="' + weightId + '"]');
            var price = $('.js-cat-cart-price[data-id="' + weightId + '"]');
            ammount.val(ammount.data('amount') * $(this).val());
            var newPrice = price.data('price') * $(this).val();
            price.html(newPrice + " ₽")
        })


        $('html').on('click', '.js-cat-prod-item-add', function () {
            var data = $(this).parents('.js-prod-cells-line').data();
            $(this).parents('.js-prod-cells-line').toggleClass('_added');
            var local_arr = JSON.parse(localStorage.getItem('WISH_LIST'));
            if ($(this).parents('.js-prod-cells-line').hasClass('_added')) {
                local_arr.push(data);
            } else {
                for (var key in local_arr) {
                    if (local_arr[key].id == data.id) {
                        local_arr.splice(key, 1);
                    }
                }
            }
            if (local_arr.length) {
                $('html').removeClass('_cart-1');
                $('html').addClass('_cart-2');
            } else {
                $('html').removeClass('_cart-2');
                $('html').addClass('_cart-1');

            }
            var json_data = JSON.stringify(local_arr);
            localStorage.setItem('WISH_LIST', json_data);
            $('.js-catalog-selection-count').html(local_arr.length);
            $('.js-cart-lines-wrap').html(addHtmlWishTable());
        });


        $('html').on('click', '.js-list-items-toggle-head', function () {
            $(this).parents('.js-list-items-toggle-b').toggleClass('_open');
        });

        $('html').on('click', '.catalog__list__link-item', function () {
            $(this).toggleClass('_open');
        });

        $('html').on('click', '.js-filter-text', function () {
            $(this).siblings('.js-basic-select').toggleClass('_open');
            $(this).parents('.js-filter-select-item').toggleClass('_open');
        });

        $('html').on('click', '.js-basic-select-opt', function () {
            $(this).toggleClass(' _selected');
        });

        $('html').on('click', '.js-cat-prod-toggle', function () {
            $('.js-cat-prod-toggle._active').removeClass('_active');
            var data_item = $(this).data('item');
            $('.js-cat-prod-content._active').removeClass('_active');
            $('.js-cat-prod-content[data-item=' + data_item + ']').addClass('_active');
            $(this).addClass('_active');

        });

        $('html').on('click', '.js-send-to-cart-btn', function () {
            var wishList = JSON.parse(localStorage.getItem('WISH_LIST'));
            ;
            var data = {
                action: 'from_wish_to_cart',
                wishlist: wishList
            }
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: data,
                success: function (response) {
                    localStorage.setItem('WISH_LIST', JSON.stringify(new Array()));
                    $('.js-cart-lines-wrap').html('');
                    $('.js-prod-cells-line._added').removeClass('_added');
                    $('html').removeClass('_cart-2');
                    $('html').addClass('_cart-3');
                    $('.js-catalog-selection-count').html('0');
                    $('.js-h-cart-count').html(response);
                }
            });

        });


        $('html').on("change", "form.js-catalog-filter", function (event) {
            event.preventDefault();
            var size = $(this).find('select[name="size"] option:selected').val();
            var mark = $(this).find('select[name="mark"] option:selected').val();
            var inStock = $(this).find('input[name="stock"]:checked').val();
            var category = $('.cat__prod-head__title').data('term_id');
            var data = {
                action: 'ajax_prod_filter',
                size: size,
                mark: mark,
                inStock: inStock,
                category: category,
            }
            console.log(data);
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: data,
                success: function (response) {
                    $('.prod-wrapp').html(response);
                }
            });

        });

        $('html').on("change", ".js-cat-cart-weight-input", function () {
            var qty = $(this).val();
            var price = Number($(this).parents('.js-cart-table-line').find('.js-cart-line-price').data('price'));
            var amount = Number($(this).parents('.js-cart-table-line').find('.js-cat-cart-amount').data('amount'));
            var key = $(this).parents('.js-cart-table-line').data('key');
            var data = {
                action: 'update_cart',
                qty: qty,
                key: key,
                store: $('.js-store-toggle._active').data('store'),
            };
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: data,
                success: function (response) {
                    // alert(response);
                    $('.js-h-cart-count').html(response['count']);
                    $('.js-cart-sum').html(divideNumberByPieces(response['subtotal_main']) + " ₽");
                    $('.js-cart-sum-other').html(divideNumberByPieces(response['subtotal_other']) + " ₽");
                    $('.js-cart-sum').data('cart-sum', response['subtotal_main']);
                    $('.js-cart-total-sum').html(divideNumberByPieces(response['total']) + " ₽");
                }
            });
        });


        $(document.body).on('updated_cart_totals', function () {
            var data = {
                action: 'update_cart_count',
            }
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: data,
                success: function (response) {
                    $('.js-h-cart-count').html(response);
                }
            });
        });

        $('div.woocommerce').on('change', function () {
            $("[name='update_cart']").removeAttr("disabled").trigger("click");
        });


        $('html').on('click', '.js-inner-tabs-toggle', function () {
            $('html').toggleClass('_list');
            $('html').toggleClass('_prod');
        });

        $('html').on('click', '.js-burger-btn', function () {
            $('html').toggleClass('_burger');
        });

        $('html').on('click', '.js-mob-tabs-toggle', function () {
            $(this).siblings('.js-mob-tabs-toggle._active').toggleClass("_active");
            $(this).toggleClass("_active");
            $('html').toggleClass('_selection');
            $('html').toggleClass('_prod');

        });

        $('html').on('click', '.js-h-dropdown-link', function () {
            $(this).toggleClass('_open');
            $(this).children(".js-h-menu-dropdown").toggle();
        });

        $('html').on('click', '.js-store-toggle', function (e) {
            $(this).siblings('.js-store-toggle._active').toggleClass("_active");
            $(this).toggleClass("_active");

            var data = {
                action: 'chenge_store',
                store: $(this).data('store'),
            };

            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: data,
                success: function (response) {
                    $('.js-cart-tables-wrap').html(response);
                }
            });
        });

        $('html').on('click', '.js-delivery-toggle', function () {
            $(this).siblings('.js-delivery-toggle._active').toggleClass("_active");
            $(this).toggleClass("_active");
            var title = $(this).text();
            var method_id = $(this).data('method_id');


            var data = {
                action: 'chenge_shipping_method',
                method_id: method_id,
                store: $('.js-store-toggle._active').data('store'),
            };

            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: data,
                success: function (response) {
                    $('.js-cart-delivery-title').text(title + ":");
                    $('.js-cart-delivery-sum').text(divideNumberByPieces(response['shipping_total']) + ' ₽');
                    $('.js-cart-total-sum').html(divideNumberByPieces(response['total']) + " ₽");

                }
            });
        });

        $('html').on('click', '.js-cart-table-line-clear', function () {
            var key = $(this).parent();
            var data = {
                action: 'remove_cart_item',
                key: key.data('key'),
                store: $('.js-store-toggle._active').data('store'),
            };

            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: data,
                success: function (response) {
                    key.remove();
                    if (response['count']) {
                        console.log(response);
                        if (response['inStore']) {
                            $('._absent-info').toggle();
                            $('.cart__table__total-b').eq(1).toggle();
                        }
                        $('.js-h-cart-count').html(response['count']);
                        $('.js-cart-sum').html(divideNumberByPieces(response['subtotal_main']) + " ₽");
                        $('.js-cart-sum-other').html(divideNumberByPieces(response['subtotal_other']) + " ₽");
                        $('.js-cart-sum').data('cart-sum', response['subtotal_main']);
                        $('.js-cart-total-sum').html(divideNumberByPieces(response['total']) + " ₽");
                    } else {
                        location.reload();
                    }

                }
            });
        });

        $(".form-agree-item").on('click', function () {

            var name_p =  /^[аА-ба-абаa-zA-Z\s-]+$/;
            var phone_p =  /^\+\d{12}$/;
            var name = $('input[name="name"]');
            var phone = $('input[name="phone"]');
            var phone_check = false;
            var name_check = false;

            if(name.val().search(name_p) != 0){
                name.siblings('.js-error').toggle();
            }else {
                name_check = true;
            }

            if(phone.val().search(phone_p) != 0){
                phone.siblings('.js-error').toggle();
            }else {
                phone_check = true;
            }

            if (phone_check && name_check){
                $('input[name="order_agree"]').prop('checked', true);
                $('.form-checkbox-marker').css(
                    {
                        "background-color": "#18c6b6",
                        "border-color": "#18c6b6"
                    }
                )
                if ($('input[name="order_agree"]').prop('checked')) {
                    $('.js-form-send').removeClass('_disabled');
                } else {
                    $('.js-form-send').addClass('_disabled');
                }
            }else {
                $('.form-checkbox-marker').css();
                $('input[name="order_agree"]').prop('checked', false);
                $('.js-form-send').removeClass('_disabled');
            }




        });

        $('html').on('click', '.js-form-send', function (e) {
            e.preventDefault();
            var form = $('.js-order-form');

            var data = {
                action: 'create_order',
                name: form.find('input[name="name"]').val(),
                company: form.find('input[name="company"]').val(),
                email: form.find('input[name="email"]').val(),
                phone: form.find('input[name="phone"]').val(),
                comment: form.find('input[name="comment"]').val(),
                shipp: $('.js-delivery-toggle._active').data('method_id'),
            };

            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: data,
                beforeSend: function () {
                    $(".js-order-form").validate({
                        rules: {
                            email: {
                                required: true,
                                email: true
                            },
                            phone: {
                                required: true,
                                minlength: 5
                            }
                        }
                    });
                },
                success: function (response) {
                    console.log(response);
                    window.location.replace(response);
                }
            });

        });





    });


});

