<?php
/** Template name: cart-checkout-template */

if(WC()->cart->is_empty()){
    get_template_part('tpl', 'empty-cart');
    exit();
}

get_header();



$stores = get_terms( 'pa_in_store', array(
        'hide_empty' => false,
    )
);
$first_store = '';
$available_gateways = WC()->session->get( 'shipping_for_package_0' )['rates'];
$chosen_rate = WC()->session->get( 'chosen_shipping_methods' )[0];
$chosen_method = get_shipping_choosen();
$total_cart = (int)mb_split('₽/т', WC()->cart->get_subtotal() )[0];


?>

    <section class="content js-cart-page " >
    <div class="catalog__content__head-b">
        <div class="inner-content _z-15">
            <? woocommerce_breadcrumb(); ?>
            <h1><? the_title(); ?></h1>
        </div>
    </div>
    <div class="catalog__content__body-b">

        <div class="about__tabs-wrap">

    <section class="about__content-wrap">
        <div class="inner-content _cols-wrap">
            <aside class="content__left-b">
                <div class="contacts__city__toggle-b">
                    <div class="contacts__city__toggle-title">Складской комплекс</div>
                    <div class="contacts__city__toggle-btns-b">
                        <? $i=0; foreach ($stores as $store):
                            if($i == 0) $first_store = $store->name;
                            ?>
                            <div
                                class="contacts__city__toggle-btn js-store-toggle <? echo ($i==0) ? '_active' : ''; ?>"
                                data-store="<? echo $store->name; ?>"
                            ><? echo $store->name; $i++?></div>
                        <? endforeach; ?>

                    </div>
                </div>
                <div class="contacts__city__toggle-b">
                    <div class="contacts__city__toggle-title">Способ доставки</div>
                    <div class="contacts__city__toggle-btns-b">
                    <?php
                    if ( ! empty( $available_gateways ) ) {
                        foreach ( $available_gateways as $key=>$method ) {
                            ?>
                                <div class="contacts__city__toggle-btn js-delivery-toggle <? echo ($key == $chosen_rate) ? '_active' : ''; ?>" data-method_id="<? echo $method->get_id(); ?>" data-shipping_cost="<? echo $method->get_cost(); ?>"><? echo $method->get_label(); ?></div>
                            <?
                        }
                    }
                    ?>
                    </div>
                </div>
            </aside>

            <div class="content__right-b">
                <div class="delivery__map-wrap">

                    <div class="cart__tables-wrap js-cart-tables-wrap">


                        <div class="cart__table-b js-cart-table-b _active">

                            <div class="cart__table-wrap">
                                <div class="cart__table-head-b">
                                    <div class="cart__table__cell _num">
                                        <div class="cart__table__cell-title">№</div>
                                    </div>
                                    <div class="cart__table__cell _title">
                                        <div class="cart__table__cell-title">Наименование</div>
                                    </div>
                                    <div class="cart__table__cell _price">
                                        <div class="cart__table__cell-title">Цена, с НДС</div>
                                    </div>
                                    <div class="cart__table__cell _weight">
                                        <div class="cart__table__cell-title">Масса, т</div>
                                    </div>
                                    <div class="cart__table__cell _amount">
                                        <div class="cart__table__cell-title">Кол-во, пог. м</div>
                                    </div>
                                    <div class="cart__table__cell _sum">
                                        <div class="cart__table__cell-title">Сумма</div>
                                    </div>
                                </div>

                                <? $num = 1;
                                $cart_total = 0;
                                foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                                    $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                                    $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
                                    if ($_product->get_attribute('pa_in_store') == $first_store) {
                                        $cart_total_main += $cart_item['line_total'];
                                        ?>

                                        <div class="cart__table-line js-cart-table-line"
                                             data-id="<? echo $cart_item["variation_id"] ?>"
                                             data-key="<? echo $cart_item_key ?>">
                                            <div class="cat-cart__top-clear js-cart-table-line-clear"></div>
                                            <div class="cart__table__cell _num">
                                                <div class="cart__table__cell-text"><? echo $num; ?></div>
                                            </div>
                                            <div class="cart__table__cell _title">
                                                <div class="cart__table__title-text-1">
                                                    <?php
                                                    if (!isset($product_permalink) && !$product_permalink) {
                                                        echo wp_kses_post(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key) . '&nbsp;');
                                                    } else {
                                                        echo wp_kses_post(apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s">%s</a>', esc_url($product_permalink), $_product->get_name()), $cart_item, $cart_item_key));
                                                    }

                                                    do_action('woocommerce_after_cart_item_name', $cart_item, $cart_item_key);

                                                    // Meta data.
                                                    echo wc_get_formatted_cart_item_data($cart_item); // PHPCS: XSS ok.

                                                    // Backorder notification.
                                                    if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) {
                                                        echo wp_kses_post(apply_filters('woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__('Available on backorder', 'woocommerce') . '</p>', $product_id));
                                                    }
                                                    ?>
                                                </div>
                                                <div class="cart__table__title-text-2"><? echo $_product->get_attribute('pa_brand'); ?></div>
                                            </div>
                                            <div class="cart__table__cell _price">
                                                <div class="cart__table__cell-title _in-cell">Цена, с НДС</div>
                                                <div class="cart__table__cell-text js-cart-line-price"
                                                     data-price="<? echo (int)$cart_item["data"]->get_price(); ?>">
                                                    <?php
                                                    echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key); // PHPCS: XSS ok.
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="cart__table__cell _weight">
                                                <div class="cart__table__cell-title _in-cell">Масса, т</div>
                                                <div class="cat-cart__table-cell__weight-input-b">
                                                    <input class="cat-cart__table-cell__weight-input js-cat-cart-weight-input"
                                                           name="good_824" type="text"
                                                           value="<? echo $cart_item ["quantity"]; ?>"
                                                           autocomplete="off">
                                                    <div class="cat-cart__table-cell__weight-minus js-cat-cart-weight-minus"></div>
                                                    <div class="cat-cart__table-cell__weight-plus js-cat-cart-weight-plus"></div>
                                                </div>
                                            </div>
                                            <div class="cart__table__cell _amount">
                                                <div class="cart__table__cell-title _in-cell">Кол-во, пог. м</div>
                                                <input class="cat-cart__table-cell__amount-input-b js-cat-cart-amount"
                                                       data-amount="<? echo $_product->get_attribute('pa_amount'); ?>"
                                                       type="text"
                                                       value="<? echo $cart_item['quantity'] * $_product->get_attribute('pa_amount'); ?>">
                                            </div>
                                            <div class="cart__table__cell _sum">
                                                <div class="cart__table__cell-sum-title js-cat-cart-price"
                                                     data-sum="<? echo $cart_item["line_total"]; ?>">
                                                    <?php
                                                    echo mb_split('₽/т', apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key))[0]; // PHPCS: XSS ok.
                                                    ?> ₽
                                                </div>
                                            </div>
                                        </div>
                                        <? $num++;
                                    }
                                }
                                    ?>
                                <div class="cart__table__total-b">
                                    <div class="cart__table__total-sum-b">
                                        <div class="cart__table__total-title">Сумма:</div>
                                        <div class="cart__table__total-text js-cart-sum" data-cart-sum="<? echo $cart_total_main; ?>"><? echo $cart_total_main; ?> ₽</div>
                                    </div>
                                    <?php
                                    $glabel = $chosen_method->get_label();
                                    $gcost = $chosen_method->get_cost();
                                    ?>
                                    <div class="cart__table__total-delivery-b">
                                        <div class="cart__table__total-title js-cart-delivery-title"><? echo (isset($glabel)) ? $glabel : $glabel ?>:</div>
                                        <div class="cart__table__total-text _orange js-cart-delivery-sum"><? echo (isset($gcost)) ? $gcost : '1'; ?> ₽</div>
                                    </div>
                                </div>

                                <?foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                                    $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                                    $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

                                    if($_product->get_attribute('pa_in_store') != $first_store) {

                                        ?>
                                        <div class="cart__tables__info-b _absent-info">
                                            <div class="cart__tables__info-title">Позиции, отсутствующие на выбранном складе</div>
                                            <div class="cart__tables__info-text">Вы можете отправить заказ, менеджер осуществит перемещение, предложит
                                                иные условия доставки или подберет аналогичный товар.
                                            </div>
                                        </div>
                                        <?
                                        break;
                                    }
                                }?>

                                    <?
                                    $cart_total_other = 0;
                                    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                                        $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                                        $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

                                        if($_product->get_attribute('pa_in_store') != $first_store){
                                            $cart_total_other += $cart_item['line_total'];
                                        ?>

                                            <div class="cart__table-line js-cart-table-line"
                                                 data-id="<? echo $cart_item["variation_id"] ?>"
                                                 data-key="<? echo $cart_item_key ?>">
                                                <div class="cat-cart__top-clear js-cart-table-line-clear"></div>
                                                <div class="cart__table__cell _num">
                                                    <div class="cart__table__cell-text"><? echo $num; ?></div>
                                                </div>
                                                <div class="cart__table__cell _title">
                                                    <div class="cart__table__title-text-1">
                                                        <?php
                                                        if (!isset($product_permalink) && !$product_permalink) {
                                                            echo wp_kses_post(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key) . '&nbsp;');
                                                        } else {
                                                            echo wp_kses_post(apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s">%s</a>', esc_url($product_permalink), $_product->get_name()), $cart_item, $cart_item_key));
                                                        }

                                                        do_action('woocommerce_after_cart_item_name', $cart_item, $cart_item_key);

                                                        // Meta data.
                                                        echo wc_get_formatted_cart_item_data($cart_item); // PHPCS: XSS ok.

                                                        // Backorder notification.
                                                        if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) {
                                                            echo wp_kses_post(apply_filters('woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__('Available on backorder', 'woocommerce') . '</p>', $product_id));
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="cart__table__title-text-2"><? echo $_product->get_attribute('pa_brand'); ?></div>
                                                </div>
                                                <div class="cart__table__cell _price">
                                                    <div class="cart__table__cell-title _in-cell">Цена, с НДС</div>
                                                    <div class="cart__table__cell-text js-cart-line-price"
                                                         data-price="<? echo (int)$cart_item["data"]->get_price(); ?>">
                                                        <?php
                                                        echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key); // PHPCS: XSS ok.
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="cart__table__cell _weight">
                                                    <div class="cart__table__cell-title _in-cell">Масса, т</div>
                                                    <div class="cat-cart__table-cell__weight-input-b">
                                                        <input class="cat-cart__table-cell__weight-input js-cat-cart-weight-input"
                                                               name="good_824" type="text"
                                                               value="<? echo $cart_item ["quantity"]; ?>"
                                                               autocomplete="off">
                                                        <div class="cat-cart__table-cell__weight-minus js-cat-cart-weight-minus"></div>
                                                        <div class="cat-cart__table-cell__weight-plus js-cat-cart-weight-plus"></div>
                                                    </div>
                                                </div>
                                                <div class="cart__table__cell _amount">
                                                    <div class="cart__table__cell-title _in-cell">Кол-во, пог. м</div>
                                                    <input class="cat-cart__table-cell__amount-input-b js-cat-cart-amount"
                                                           data-amount="<? echo $_product->get_attribute('pa_amount'); ?>"
                                                           type="text"
                                                           value="<? echo $cart_item['quantity'] * $_product->get_attribute('pa_amount'); ?>">
                                                </div>
                                                <div class="cart__table__cell _sum">
                                                    <div class="cart__table__cell-sum-title js-cat-cart-price"
                                                         data-sum="<? echo $cart_item["line_total"]; ?>">
                                                        <?php
                                                        echo mb_split('₽/т', apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key))[0]; // PHPCS: XSS ok.
                                                        ?> ₽
                                                    </div>
                                                </div>
                                            </div>
                                        <? $num++;
                                    }
                                }
                                ?><?foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                                    $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);

                                    if($_product->get_attribute('pa_in_store') != $first_store) {
                                        ?>
                                        <div class="cart__table__total-b">
                                            <div class="cart__table__total-sum-b">
                                                <div class="cart__table__total-title">Сумма:</div>
                                                <div class="cart__table__total-text js-cart-sum-other" ><? echo $cart_total_other; ?></div>
                                            </div>
                                            <div class="cart__table__total-delivery-b">
                                                <div class="cart__table__total-title">Доставка:</div>
                                                <div class="cart__table__total-text _orange ">По запросу</div>
                                            </div>
                                        </div>
                                        <?
                                        break;
                                    }
                                }?>

                                <div class="cart__table__big-total-b">
                                    <div class="cart__table__big-total-title">Итого:</div>
                                    <?php
                                    $gcost = $chosen_method->get_cost();
                                    $gcost_total = (isset($gcost)) ? $gcost : 0;
                                    ?>
                                    <div class="cart__table__big-total-text js-cart-total-sum"><? echo $cart_total_main+$cart_total_other+$gcost_total; ?> ₽</div>
                                </div>

                            </div>


                        </div>


                    </div>

                    <div class="cart__order-form-wrap">
                        <div class="fb-form-wrap js-form-wrap">
                            <form class="fb-form js-form js-order-form" >
                                <h3>Оформить заказ</h3>
                                <div class="form-items-wrap">
                                    <div class="form-item js-form-item js-required-item">
                                        <input class="form-input js-form-input js-required" required name="name" type="text" data-type="text" value="">
                                        <span class="form-item-label">Имя</span>
                                        <div class="form-error js-error">Неверный формат имени</div>
                                    </div>
                                    <div class="form-item js-form-item js-required-item">
                                        <input class="form-input js-form-input js-required" name="company" type="text" value="">
                                        <span class="form-item-label">Компания</span>
                                        <div class="form-error js-error">Неверный формат названия</div>
                                    </div>
                                    <div class="form-item js-form-item js-required-item">
                                        <input class="form-input js-form-input js-required" name="email" type="text" data-type="email">
                                        <span class="form-item-label">Email</span>
                                        <div class="form-error js-error">Неверный формат.
                                            <span>Пример: adress@mail.com</span>
                                        </div>
                                    </div>
                                    <div class="form-item js-form-item">
                                        <input class="form-input js-form-input js-phone-input" required name="phone" type="text">
                                        <span class="form-item-label">Телефон (необязательное поле)</span>
                                        <div class="form-error js-error">Неверный формат телефона</div>
                                    </div>
                                    <div class="form-item form-area-item js-form-item">
                                        <textarea class="form-area js-form-input" name="comment"></textarea>
                                        <span class="form-item-label">Комментарии (необязательное поле)</span>
                                        <div class="form-error js-error">Введите текст сообщения</div>
                                    </div>
                                    <div class="form-item form-agree-item js-form-item js-required-item">
                                        <input class="form-checkbox js-form-checkbox js-form-agree" name="order_agree" type="checkbox" value="1">
                                        <label class="form-checkbox-label">Согласие на
                                            <a href target="_blank">обработку персональных данных</a>
                                            <span class="form-checkbox-marker"></span>
                                        </label>
                                    </div>
                                    <div class="form-item recaptcha-wrap w-100">
                                        <div class="recaptcha-b" id="recaptcha-order"></div>
                                    </div>
                                </div>
                                <div class="form-send-wrap">
                                    <button class="basic-btn form-send-btn js-form-send _disabled" type="submit">Отправить</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
        </div>
    </div>
    </section>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
<!--    <script>-->
<!--        jQuery( function( $ ) {-->
<!--            $(document).ready(function () {-->
<!--                $(".js-order-form").validate({-->
<!--                    rules: {-->
<!--                        phone: {-->
<!--                            required: true,-->
<!--                            digits: true,-->
<!--                            minlength: 12-->
<!--                        },-->
<!--                        name: {-->
<!--                            required: true,-->
<!--                            minlength: 3-->
<!--                        }-->
<!--                    },-->
<!--                        messages:{-->
<!--                            phone:{-->
<!--                                digits:"Обязательно цифры",-->
<!--                                required:"Поле оязательно",-->
<!--                                min: 11,-->
<!--                                max: 11,-->
<!--                                minlength:"Минимальное кол-во символов 11",-->
<!--                                maxlength:"Максимальное кол-во символов 11",-->
<!--                            },-->
<!--                            name:{-->
<!--                                minlength:"Минимальное кол-во символов 3",-->
<!--                                required:"Поле оязательны"-->
<!--                            }-->
<!--                        }-->
<!--                    })-->
<!--                });-->
<!--            });-->
<!---->
<!--    </script>-->
<?php

get_footer();