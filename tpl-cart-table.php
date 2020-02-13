<div class="cart__table-b js-cart-table-b _active" data-city="podolsk">
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
        foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
            $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
            $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
            if ($_product->get_attribute('pa_in_store') == $first_store) {
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
                            if (!$product_permalink) {
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
                             data-sum="<? echo $cart_item ["quantity"] * (int)$cart_item["data"]->get_price(); ?>">
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
                <div class="cart__table__total-text js-cart-sum" data-cart-sum="<? echo $total_cart; ?>"><? echo $total_cart; ?> ₽</div>
            </div>
            <div class="cart__table__total-delivery-b">
                <div class="cart__table__total-title js-cart-delivery-title"><? echo $chosen_method->get_label() ?>:</div>
                <div class="cart__table__total-text _orange js-cart-delivery-sum"><? echo $chosen_method->get_cost(); ?> ₽</div>
            </div>
        </div>

        <div class="cart__tables__info-b _absent-info">
            <div class="cart__tables__info-title">Позиции, отсутствующие на выбранном складе</div>
            <div class="cart__tables__info-text">Вы можете отправить заказ, менеджер осуществит перемещение, предложит иные условия доставки или подберет аналогичный товар.</div>
        </div>
        <?foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
            $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
            $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

            if($_product->get_attribute('pa_in_store') != $first_store){
                ?>

                <div class="cart__table-line js-cart-table-line"
                     data-id="<? echo $cart_item["variation_id"] ?>"
                     data-key="<? echo $cart_item_key ?>">
                    <div class="cat-cart__top-clear"></div>
                    <div class="cart__table__cell _num">
                        <div class="cart__table__cell-text"><? echo $num; ?></div>
                    </div>
                    <div class="cart__table__cell _title">
                        <div class="cart__table__title-text-1">
                            <?php
                            if (!$product_permalink) {
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
                        <div class="cart__table__cell-text">В пути</div>
                    </div>
                    <div class="cart__table__cell _weight">
                        <div class="cart__table__cell-title _in-cell">Масса, т</div>
                        <div class="cat-cart__table-cell__weight-input-b">
                            <input class="cat-cart__table-cell__weight-input"
                                   name="good_824" type="text"
                                   value="<? echo $cart_item ["quantity"]; ?>"
                                   autocomplete="off">
                            <div class="cat-cart__table-cell__weight-minus js-cat-cart-weight-minus"></div>
                            <div class="cat-cart__table-cell__weight-plus js-cat-cart-weight-plus"></div>
                        </div>
                    </div>
                    <div class="cart__table__cell _amount">
                        <div class="cart__table__cell-title _in-cell">Кол-во, пог. м</div>
                        <input class="cat-cart__table-cell__amount-input-b"
                               data-amount="<? echo $_product->get_attribute('pa_amount'); ?>"
                               type="text"
                               value="<? echo $cart_item['quantity'] * $_product->get_attribute('pa_amount'); ?>">
                    </div>
                    <div class="cart__table__cell _sum">
                        <div class="cart__table__cell-sum-title">В пути</div>
                    </div>
                </div>
                <? $num++;
            }
        }
        ?>
        <div class="cart__table__total-b">
            <div class="cart__table__total-sum-b">
                <div class="cart__table__total-title">Сумма:</div>
                <div class="cart__table__total-text " >По запросу</div>
            </div>
            <div class="cart__table__total-delivery-b">
                <div class="cart__table__total-title ">Доставка:</div>
                <div class="cart__table__total-text _orange ">По запросу</div>
            </div>
        </div>


        <div class="cart__table__big-total-b">
            <div class="cart__table__big-total-title">Итого:</div>
            <div class="cart__table__big-total-text js-cart-total-sum"><? echo WC()->cart->get_totals()['total'] ?> ₽</div>
        </div>

    </div>


</div>