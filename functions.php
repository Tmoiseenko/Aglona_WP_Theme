<?php
add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}

add_theme_support( 'post-thumbnails' );

function my_script_load()
{
    wp_enqueue_style('select2-style', get_stylesheet_directory_uri() . '/css/select2.css');
    wp_enqueue_style('main-style', get_stylesheet_directory_uri() . '/css/main.css');
    wp_enqueue_style('aglona-style', get_stylesheet_directory_uri() . '/style.css');
    wp_enqueue_style('suggestions-style', 'https://cdn.jsdelivr.net/npm/suggestions-jquery@17.10.1/dist/css/suggestions.min.css');


    wp_enqueue_script('select2-custom-js', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.full.min.js');
    wp_enqueue_script('modernizr-custom-js', get_stylesheet_directory_uri() . '/js/modernizr.custom.js', '', '', true);
    wp_enqueue_script('vendor-js', get_stylesheet_directory_uri() . '/js/vendor.js', '', '', true);
    wp_enqueue_script('jq-cookie-js', get_stylesheet_directory_uri() . '/js/jquery.cookie.js', '', '', true);
//    wp_enqueue_script('main-js', get_stylesheet_directory_uri() . '/js/main.js', '', '', true);
    wp_enqueue_script('agnola-js', get_stylesheet_directory_uri() . '/js/agnola.js', '', '', true);
    wp_enqueue_script('validate-js', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js');

}

add_action('wp_enqueue_scripts', 'my_script_load');

register_nav_menus(array(
    'main-menu' => 'Главное меню',
));

if ( function_exists('register_sidebar') )
	register_sidebar(array(
        'name' => 'Sidebar Footer',
        'id'   => "sidebar-footer",
        'description'   => '',
        'class'         => 'f__contacts__content-col',
        'before_widget' => '<div class="f__info-link-wrap">',
        'after_widget'  => "</div>\n",
        'before_title'  => '<div class="f__info-title-wrap">',
        'after_title'   => "</div>\n",
    ));

function my_options(){

    add_settings_field('phone_number', 'Номер телефона', 'display_phone', 'general');
    register_setting('general', 'phone_number');

}
function display_phone(){
    echo '<input type="text" class="regular-text" name="phone_number" value="'.esc_attr(get_option('phone_number')).'">';
}
add_action('admin_menu', 'my_options');

add_filter('woocommerce_currency_symbol', 'change_existing_currency_symbol', 10, 2);

function change_existing_currency_symbol( $currency_symbol, $currency ) {
    switch( $currency ) {
        case 'RUB': $currency_symbol = '₽/т'; break;
    }
    return $currency_symbol;
}

function woocommerce_breadcrumb( $args = array() ) {
    $args = wp_parse_args(
        $args,
        apply_filters(
            'woocommerce_breadcrumb_defaults',
            array(
                'delimiter'   => '',
                'wrap_before' => '<ul class="breadcrumbs">',
                'wrap_after'  => '</ul>',
                'before'      => '',
                'after'       => '',
                'home'        => _x( 'Home', 'breadcrumb', 'woocommerce' ),
            )
        )
    );

    $breadcrumbs = new WC_Breadcrumb();

    if ( ! empty( $args['home'] ) ) {
        $breadcrumbs->add_crumb( $args['home'], apply_filters( 'woocommerce_breadcrumb_home_url', home_url() ) );
    }

    $args['breadcrumb'] = $breadcrumbs->generate();

    do_action( 'woocommerce_breadcrumb', $breadcrumbs, $args );

    wc_get_template( 'global/breadcrumb.php', $args );
};

function agnola_catalog_title(){
?>
    <div class="catalog__content__head-b" >
        <div class="inner-content _z-15">
            <? woocommerce_breadcrumb(); ?>
            <div class="h1">Каталог</div>
            <?
                if (is_product()):?>
                    <a class="cat__prod-head__all-link" href="<? echo get_posts_nav_link(); ?>">
                        <span>Все размеры</span>
                    </a>
                <? endif;
            ?>
        <div class="catalog__tabs-toggle-b">
            <div class="catalog__tabs-toggle__item js-mob-tabs-toggle _active">Продукция</div>
            <div class="catalog__tabs-toggle__item js-mob-tabs-toggle">Подборка
                <div class="catalog__selection-count js-catalog-selection-count"> </div>
            </div>
        </div>
        </div>
    </div>
<?
}

add_action( 'woocommerce_before_main_content', 'agnola_catalog_title', 15 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );


function woocommerce_taxonomy_archive_description() {
    if ( is_product_taxonomy() && 0 === absint( get_query_var( 'paged' ) ) ) {
        $term = get_queried_object();

        if ( $term && ! empty( $term->description ) ) {
            echo '<div class="cat__prod__item-content-b js-cat-prod-content" data-item="spec">' . wc_format_content( $term->description ) . '</div>'; // WPCS: XSS ok.
        }
    }
}

function agnola_archive_category_title(){
global $wp_query;
$cat_slug = $wp_query->query_vars["product_cat"];
$cat = $term = get_term_by('slug', $cat_slug, 'product_cat');
$thumbnail_id         = get_term_meta( $cat->term_id, 'thumbnail_id', true );
$image = wp_get_attachment_image_src( $thumbnail_id, 'thumbnail' );
$shopImage = get_the_post_thumbnail_url( 9, 'thumbnail' );
?>
    <div class="cat__prod__head-b">
        <div class="cat__prod-head__img-wrap">
        <? if(is_shop()): ?>
            <img class="cat__prod-head__img" src="<? echo $shopImage; ?>" alt="catalog">
        <? else: ?>
            <img class="cat__prod-head__img" src="<? echo $image[0]; ?>" alt="<? echo $cat->name; ?>">
        <? endif; ?>
        </div>
        <div class="cat__prod-head__content-wrap">
            <H1 class="cat__prod-head__title" data-term_id="<? echo $cat->term_id; ?>"><? echo $cat->name; ?></H1>
            <div class="cat__prod-head__toggle-b">
                <div class="cat__prod-head__toggle-item js-cat-prod-toggle _active" data-item="price">Цены</div>
                <div class="cat__prod-head__toggle-item js-cat-prod-toggle" data-item="spec">Описание</div>
            </div>
        </div>
    </div>
<?
}
add_action( 'woocommerce_before_shop_loop', 'agnola_archive_category_title', 3 );

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );

add_action( 'wp_enqueue_scripts', 'myajax_data', 99 );
function myajax_data(){
    wp_localize_script( 'agnola-js', 'ajaxurl', admin_url('admin-ajax.php')  );
}



add_action('wp_ajax_from_wish_to_cart', 'from_wish_to_cart_callback');
add_action('wp_ajax_nopriv_from_wish_to_cart', 'from_wish_to_cart_callback');
function from_wish_to_cart_callback() {
    $wishlist = $_POST['wishlist'];
    global $woocommerce;
    foreach ($wishlist as $item){
        $prodId = (int)$item['id'];
        $prodQty = (int)$item['qty'];
        $woocommerce->cart->add_to_cart( $prodId, $prodQty );
    }?>

  <span><? echo $woocommerce->cart->get_cart_contents_count(); ?></span>

<?
    wp_die();

}

add_action('wp_ajax_update_cart', 'update_cart_callback');
add_action('wp_ajax_nopriv_update_cart', 'update_cart_callback');
function update_cart_callback() {
    $prod_qty = (int)$_POST['qty'];
    $prod_key = $_POST['key'];
    $store = $_POST['store'];
    WC()->cart->set_quantity($prod_key, $prod_qty);
    $totals = WC()->cart->get_totals();
    $cart_total_main = 0;
    $cart_total_other = 0;
    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
        $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
        if ($_product->get_attribute('pa_in_store') == $store) {
            $cart_total_main += $cart_item['line_total'];
        }else{
            $cart_total_other += $cart_item['line_total'];
        }
    };
    $data = array(
        'count' => WC()->cart->get_cart_contents_count(),
        'subtotal_main' => $cart_total_main,
        'subtotal_other' => $cart_total_other,
        'total' => $cart_total_main+$cart_total_other+$totals['shipping_total'],
        'shipping_total' => $totals['shipping_total'],
    );
    return wp_send_json($data);
    wp_die();
}

add_action('wp_ajax_update_cart_count', 'update_cart_count_callback');
add_action('wp_ajax_nopriv_update_cart_count', 'update_cart_count_callback');
function update_cart_count_callback() {
    global $woocommerce;
    ?>
    <span><? echo $woocommerce->cart->get_cart_contents_count(); ?></span>
    <?
    wp_die();
}

add_action('wp_ajax_remove_cart_item', 'remove_cart_item_callback');
add_action('wp_ajax_nopriv_remove_cart_item', 'remove_cart_item_callback');
function remove_cart_item_callback() {
    $store = $_POST['store'];
    $prod_key = $_POST['key'];
    WC()->cart->remove_cart_item($prod_key);
    $totals = WC()->cart->get_totals();
    $noStore = true;
    $cart_total_main = 0;
    $cart_total_other = 0;
    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
        $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
        if ($_product->get_attribute('pa_in_store') == $store) {
            $cart_total_main += $cart_item['line_total'];
        }else{
            $cart_total_other += $cart_item['line_total'];
            $noStore = false;
        }
    };
    $data = array(
        'count' => WC()->cart->get_cart_contents_count(),
        'subtotal_main' => $cart_total_main,
        'subtotal_other' => $cart_total_other,
        'total' => $cart_total_main+$cart_total_other+$totals['shipping_total'],
        'shipping_total' => $totals['shipping_total'],
        'inStore' => $noStore,
    );

    return wp_send_json($data);
    wp_die();
};

add_action('wp_ajax_chenge_shipping_method', 'chenge_shipping_method_callback');
add_action('wp_ajax_nopriv_chenge_shipping_method', 'chenge_shipping_method_callback');
function chenge_shipping_method_callback() {
    $store = $_POST['store'];
    $method = $_POST['method_id'];
    WC()->session->set('chosen_shipping_methods', array( $method ) );
    WC()->cart->calculate_totals();
    $totals = WC()->cart->get_totals();
    $cart_total_main = 0;
    $cart_total_other = 0;
    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
        $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
        if ($_product->get_attribute('pa_in_store') == $store) {
            $cart_total_main += $cart_item['line_total'];
        }else{
            $cart_total_other += $cart_item['line_total'];
        }
    };
    $data = array(
        'count' => WC()->cart->get_cart_contents_count(),
        'subtotal_main' => $cart_total_main,
        'subtotal_other' => $cart_total_other,
        'total' => $cart_total_main+$cart_total_other+$totals['shipping_total'],
        'shipping_total' => $totals['shipping_total'],
    );

    return wp_send_json($data);
    wp_die();
};

add_action('wp_ajax_chenge_store', 'chenge_store_callback');
add_action('wp_ajax_nopriv_chenge_store', 'chenge_store_callback');
function chenge_store_callback() {
    $first_store = $_POST['store'];
    $chosen_method = get_shipping_choosen();
    ?>
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
<?
    wp_die();
};

function ajax_create_order() {
    // Получить корзину
    $cart = WC()->cart;
    $phone = esc_attr( trim( $_POST['phone'] ) );
    $email = esc_attr( trim( $_POST['email'] ) );
    $name = esc_attr( trim( $_POST['name'] ) );
    $comment = esc_attr( trim( $_POST['comment'] ) );
    $shipp = esc_attr( trim( $_POST['shipp'] ) );
    $ship_method = WC()->session->get( 'shipping_for_package_0' )['rates'][$shipp];

    $address = [
        'first_name' => $name,
        'email'      => $email,
        'phone'      => $phone,
        'country'    => 'RU',
    ];
    $order = wc_create_order();
    $shipping = new WC_Shipping_Rate( $ship_method->get_id(), $ship_method->get_label(), $ship_method->get_cost(), $ship_method->get_method_id(), $ship_method->get_instance_id() );
    // Информация о покупателе
    $order->add_shipping( $shipping );
    $order->set_address( $address, 'billing' );
    $order->set_address( $address, 'shipping' );
    $order->set_customer_note( $comment );
    // Товары из корзины
    foreach( $cart->get_cart() as $cart_item_key => $cart_item ) {
        $_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
        $product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
        $order->add_product( $_product, $cart_item['quantity'], [
            'variation' => $cart_item['variation'],
            'totals'    => [
                'subtotal'     => $cart_item['line_subtotal'],
                'subtotal_tax' => $cart_item['line_subtotal_tax'],
                'total'        => $cart_item['line_total'],
                'tax'          => $cart_item['line_tax'],
                'tax_data'     => $cart_item['line_tax_data']
            ]
        ]);
    }

    $order->calculate_totals();
    // Отправить письмо юзеру
    $mailer = WC()->mailer();
    $email = $mailer->emails['WC_Email_Customer_Processing_Order'];
    $email->trigger( $order->get_id() );
    // Отправить письмо админу
    $email = $mailer->emails['WC_Email_New_Order'];
    $email->trigger( $order->get_id() );
    // Очистить корзину
    $cart->empty_cart();
    $href = site_url() .'/checkout/order-received/';
    echo $href ;
    wp_die();
}
add_action( 'wp_ajax_create_order', 'ajax_create_order' );
add_action( 'wp_ajax_nopriv_create_order', 'ajax_create_order' );


add_action('wp_ajax_ajax_prod_filter', 'ajax_prod_filter_callback');
add_action('wp_ajax_nopriv_ajax_prod_filter', 'ajax_prod_filter_callback');
function ajax_prod_filter_callback() {

    $size = $_POST['size'];
    $mark = $_POST['mark'];
    $inStock = $_POST['inStock'];
    $category = (int)$_POST['category'];


    if ( !empty($category) ) {

        $category_query_args = array(
            'taxonomy'  => 'product_cat',
            'field'  => 'term',
            'terms'     =>  $category,
            'operator'  => 'IN'
        );
    }

    $args = array(
        'post_type'		=> 'product',
        'offset'        => 0,
        'tax_query'     => array(
            'category' => array(
                $category_query_args
            ),
        ),
        'fields'        => 'ids',
    );


    $loop = new WP_Query( $args );
    if ( $loop->have_posts() ) {
        while ($loop->have_posts()) : $loop->the_post();

                global $product;
                $link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );
                $prod_ids = $product->get_children() ;

                $options = [];
                $options['prod_price'] = [];
                $options['prod_id'] = [];
                $options['prod_sku'] = [];
                $options['prod_title'] = [];
                $options['pa_brand'] = [];
                $options['pa_amount'] = [];
                $options['pa_length'] = [];
                $options['pa_standart'] = [];
                $options['pa_size'] = [];
                foreach ($prod_ids as $key=>$prod_id) {

                    $_prod = wc_get_product($prod_id);

                    if($inStock == 'on'){
                        if($_prod->is_in_stock()){
                            array_push($options['prod_price'], $_prod->get_price());
                            array_push($options['prod_id'], $_prod->get_id());
                            array_push($options['prod_sku'], $_prod->get_sku());
                            array_push($options['prod_title'], $_prod->get_title());
                            $options['parent_id'] = $_prod->get_parent_id();
                            array_push($options['pa_brand'], $_prod->get_attribute('pa_brand'));
                            array_push($options['pa_amount'], $_prod->get_attribute('pa_amount'));
                            array_push($options['pa_length'], $_prod->get_attribute('pa_length'));
                            array_push($options['pa_standart'], $_prod->get_attribute('pa_standart'));
                            array_push($options['pa_size'], $_prod->get_attribute('pa_size'));


                        }


                    }else{
                        array_push($options['prod_price'], $_prod->get_price());
                        array_push($options['prod_id'], $_prod->get_id());
                        array_push($options['prod_sku'], $_prod->get_sku());
                        array_push($options['prod_title'], $_prod->get_title());
                        $options['parent_id'] = $_prod->get_parent_id();
                        array_push($options['pa_brand'], $_prod->get_attribute('pa_brand'));
                        array_push($options['pa_amount'], $_prod->get_attribute('pa_amount'));
                        array_push($options['pa_length'], $_prod->get_attribute('pa_length'));
                        array_push($options['pa_standart'], $_prod->get_attribute('pa_standart'));
                        array_push($options['pa_size'], $_prod->get_attribute('pa_size'));
                    }




                }

            if($size != 'all' ):
                if($options['pa_size'][0] == $size):?>
                    <div class="cat__prod__item-prices-b">
                        <div class="cat-prod__item-prices__size-cell">
                            <div class="cat-prod__item-prices__size-title _in-cell">Размер:</div>
                            <a class="cat-prod__item-prices__size-text js-cat-prod-item-size" href="<? echo $link; ?>">
                                <? echo $options['pa_size'][0]; ?>
                            </a>
                        </div>
                        <div class="cat-prod__item-prices__cells-wrap">
                            <? if($mark != 'all' ):?>



                                <? foreach ($options['prod_price'] as $key=>$price): ?>

                                    <? if($options['pa_brand'][$key] == $mark): ?>

                                        <div class="cat-prod__item-prices__cells-line js-prod-cells-line" id="<? echo $options['prod_id'][$key];?>" data-qty="1" data-id="<? echo $options['prod_id'][$key];?>" data-price="<? echo $options['prod_price'][$key];?>" data-title="<? echo $options['prod_title'][$key];?>" data-mark="<? echo $options['pa_brand'][$key]; ?>" data-amount="<? echo $options['pa_amount'][$key]; ?>" >

                                            <div class="cat-prod__item-prices__cell _mark">
                                                <div class="cat-prod__item-prices__mark-text-b">
                                                    <div class="cat-prod__item-prices__mark-text js-cat-prod-item-mark"><? echo $options['pa_brand'][$key]; ?></div>
                                                    <div class="cat-prod__item-prices__mark-popup"><? echo $options['pa_standart'][$key]; ?></div>
                                                </div>
                                            </div>
                                            <div class="cat-prod__item-prices__cell _length">
                                                <div class="cat-prod__item-prices__length-text js-cat-prod-item-length"><? echo $options['pa_length'][$key]; ?></div>
                                            </div>
                                            <div class="cat-prod__item-prices__cell _price">
                                                <div class="cat-prod__item-prices__price-text js-cat-prod-item-price ">
                                                    <span class='js-line-price'><? echo $options['prod_price'][$key]; ?></span> ₽/т
                                                </div>
                                            </div>
                                            <div class="cat-prod__item-prices__cell">
                                                <div class="cat-prod__item-prices__add-b">
                                                    <div class="cat-prod__item-prices__added"></div>
                                                    <div class="cat-prod__item-prices__add-btn js-cat-prod-item-add"></div>
                                                </div>
                                            </div>

                                        </div>

                                    <? endif; ?>

                                <? endforeach; ?>



                            <? else: ?>

                                        <? foreach ($options['prod_price'] as $key=>$price): ?>

                                            <div class="cat-prod__item-prices__cells-line js-prod-cells-line" id="<? echo $options['prod_id'][$key];?>" data-qty="1" data-id="<? echo $options['prod_id'][$key];?>" data-price="<? echo $options['prod_price'][$key];?>" data-title="<? echo $options['prod_title'][$key];?>" data-mark="<? echo $options['pa_brand'][$key]; ?>" data-amount="<? echo $options['pa_amount'][$key]; ?>" >

                                                <div class="cat-prod__item-prices__cell _mark">
                                                    <div class="cat-prod__item-prices__mark-text-b">
                                                        <div class="cat-prod__item-prices__mark-text js-cat-prod-item-mark"><? echo $options['pa_brand'][$key]; ?></div>
                                                        <div class="cat-prod__item-prices__mark-popup"><? echo $options['pa_standart'][$key]; ?></div>
                                                    </div>
                                                </div>
                                                <div class="cat-prod__item-prices__cell _length">
                                                    <div class="cat-prod__item-prices__length-text js-cat-prod-item-length"><? echo $options['pa_length'][$key]; ?></div>
                                                </div>
                                                <div class="cat-prod__item-prices__cell _price">
                                                    <div class="cat-prod__item-prices__price-text js-cat-prod-item-price ">
                                                        <span class='js-line-price'><? echo $options['prod_price'][$key]; ?></span> ₽/т
                                                    </div>
                                                </div>
                                                <div class="cat-prod__item-prices__cell">
                                                    <div class="cat-prod__item-prices__add-b">
                                                        <div class="cat-prod__item-prices__added"></div>
                                                        <div class="cat-prod__item-prices__add-btn js-cat-prod-item-add"></div>
                                                    </div>
                                                </div>

                                            </div>

                                        <? endforeach; ?>

                            <? endif; ?>


                        </div>

                    </div>
                <?endif;
            else:
                ?>

                <div class="cat__prod__item-prices-b">
                    <div class="cat-prod__item-prices__size-cell">
                        <div class="cat-prod__item-prices__size-title _in-cell">Размер:</div>
                        <a class="cat-prod__item-prices__size-text js-cat-prod-item-size" href="<? echo $link; ?>">
                            <? echo $options['pa_size'][0]; ?>

                        </a>
                    </div>
                    <div class="cat-prod__item-prices__cells-wrap">
                        <? foreach ($options['prod_price'] as $key=>$price): ?>

                            <div class="cat-prod__item-prices__cells-line js-prod-cells-line" id="<? echo $options['prod_id'][$key];?>" data-qty="1" data-id="<? echo $options['prod_id'][$key];?>" data-price="<? echo $options['prod_price'][$key];?>" data-title="<? echo $options['prod_title'][$key];?>" data-mark="<? echo $options['pa_brand'][$key]; ?>" data-amount="<? echo $options['pa_amount'][$key]; ?>" >

                                <div class="cat-prod__item-prices__cell _mark">
                                    <div class="cat-prod__item-prices__mark-text-b">
                                        <div class="cat-prod__item-prices__mark-text js-cat-prod-item-mark"><? echo $options['pa_brand'][$key]; ?></div>
                                        <div class="cat-prod__item-prices__mark-popup"><? echo $options['pa_standart'][$key]; ?></div>
                                    </div>
                                </div>
                                <div class="cat-prod__item-prices__cell _length">
                                    <div class="cat-prod__item-prices__length-text js-cat-prod-item-length"><? echo $options['pa_length'][$key]; ?></div>
                                </div>
                                <div class="cat-prod__item-prices__cell _price">
                                    <div class="cat-prod__item-prices__price-text js-cat-prod-item-price ">
                                        <span class='js-line-price'><? echo $options['prod_price'][$key]; ?></span> ₽/т
                                    </div>
                                </div>
                                <div class="cat-prod__item-prices__cell">
                                    <div class="cat-prod__item-prices__add-b">
                                        <div class="cat-prod__item-prices__added"></div>
                                        <div class="cat-prod__item-prices__add-btn js-cat-prod-item-add"></div>
                                    </div>
                                </div>

                            </div>

                        <? endforeach; ?>

                    </div>

                </div>

            <?
            endif;

        endwhile;
    }


wp_die();
}


class Custom_Walker_Nav_Menu extends Walker_Nav_Menu{

    public function start_el(&$output, $item, $depth=0, $args = array(), $id=0){
        $activeLink = site_url() . $_SERVER['REQUEST_URI'];
        $activeClass = ($item->current == true) ? "_active" : "" ;
        $dropdown = ( in_array( "menu-item-has-children", $item->classes) ) ? "_dropdown" : "" ;
        $html = '';
        if($depth == 0){
            $html .= "<li class='h-nav__item js-h-dropdown-link %s'><a class='h-nav__link js-h-dropdown-root-link %s' href=\"%s\">%s</a>";
            $output .= sprintf($html, $dropdown, $activeClass, $item->url, $item->title);
        }
        if($depth == 1){
            $html .= "<li class='h-subnav__item'><a class='h-subnav__link %s' href=\"%s\">%s</a>";
            $output .= sprintf($html,$activeClass,$item->url,$item->title);
        }

    }

    public function end_el(&$output, $item, $depth=0, $args = array()){

        $html = '';
        if($depth == 0) {
            $html .= '</li>';
            $output .= sprintf($html, get_bloginfo('template_url'));
        }
        elseif($depth == 1) {
            $output .= '</li>';
        }

    }

    public function start_lvl(&$output, $depth=0, $args = array(), $id=0){
        if($depth == 0) {
            $output .= '<nav class="h-subnav js-h-menu-dropdown">';
        }
    }

    public function end_lvl(&$output, $depth=0, $args = array(), $id=0){
        if($depth == 0) {
            $output .= '</nav>';
        }
    }
}

function agnola_product_title(){

}

remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
remove_action( 'woocommerce_single_product_summary', 'WC_Structured_Data::generate_product_data()', 60 );

add_filter( 'woocommerce_checkout_fields', 'my_default_address_fields' );
function my_default_address_fields( $fields ){
    unset($fields['billing']['billing_last_name']);
    unset($fields['billing']['billing_city']);
    unset($fields['billing']['billing_state']);
    unset($fields['billing']['billing_postcode']);
    unset($fields['billing']['billing_address_2']);
    unset($fields['billing']['billing_address_1']['label']);
    unset($fields['billing']['billing_email']['label']);
    unset($fields['billing']['billing_phone']['label']);
    unset($fields['billing']['billing_first_name']['label']);
    unset($fields['order']['order_comments']['label']);
    unset($fields['billing']['billing_country']['label']);
    unset($fields['billing']['billing_company']['label']);
    $fields['billing']['billing_email']['priority'] = 5;
    $fields['billing']['billing_email']['placeholder'] = 'Email';
    $fields['billing']['billing_phone']['priority'] = 25;
    $fields['billing']['billing_phone']['required'] = 0;
    $fields['billing']['billing_phone']['placeholder'] = 'Телефон (не обязательное поле)';
    $fields['billing']['billing_first_name']['class'][0] = '';
    $fields['billing']['billing_first_name']['placeholder'] = 'Имя';
    $fields['billing']['billing_address_1']['placeholder'] = 'Адрес';
    $fields['billing']['billing_company']['placeholder'] = 'Название компании';
    $fields['order']['order_comments']['placeholder'] = 'Комментарий (не обязательное поле)';

    return $fields;

}

function woocommerce_form_field( $key, $args, $value = null ) {
    $defaults = array(
        'type'              => 'text',
        'label'             => '',
        'description'       => '',
        'placeholder'       => '',
        'maxlength'         => false,
        'required'          => false,
        'autocomplete'      => false,
        'id'                => $key,
        'class'             => array(),
        'label_class'       => array(),
        'input_class'       => array(),
        'return'            => false,
        'options'           => array(),
        'custom_attributes' => array(),
        'validate'          => array(),
        'default'           => '',
        'autofocus'         => '',
        'priority'          => '',
    );

    $args = wp_parse_args( $args, $defaults );
    $args = apply_filters( 'woocommerce_form_field_args', $args, $key, $value );

    if ( $args['required'] ) {
        $args['class'][] = 'validate-required';
        $required        = '&nbsp;<abbr class="required" title="' . esc_attr__( 'required', 'woocommerce' ) . '">*</abbr>';
    } else {
        $required = '&nbsp;<span class="optional">(' . esc_html__( 'optional', 'woocommerce' ) . ')</span>';
    }

    if ( is_string( $args['label_class'] ) ) {
        $args['label_class'] = array( $args['label_class'] );
    }

    if ( is_null( $value ) ) {
        $value = $args['default'];
    }

    // Custom attribute handling.
    $custom_attributes         = array();
    $args['custom_attributes'] = array_filter( (array) $args['custom_attributes'], 'strlen' );

    if ( $args['maxlength'] ) {
        $args['custom_attributes']['maxlength'] = absint( $args['maxlength'] );
    }

    if ( ! empty( $args['autocomplete'] ) ) {
        $args['custom_attributes']['autocomplete'] = $args['autocomplete'];
    }

    if ( true === $args['autofocus'] ) {
        $args['custom_attributes']['autofocus'] = 'autofocus';
    }

    if ( $args['description'] ) {
        $args['custom_attributes']['aria-describedby'] = $args['id'] . '-description';
    }

    if ( ! empty( $args['custom_attributes'] ) && is_array( $args['custom_attributes'] ) ) {
        foreach ( $args['custom_attributes'] as $attribute => $attribute_value ) {
            $custom_attributes[] = esc_attr( $attribute ) . '="' . esc_attr( $attribute_value ) . '"';
        }
    }

    if ( ! empty( $args['validate'] ) ) {
        foreach ( $args['validate'] as $validate ) {
            $args['class'][] = 'validate-' . $validate;
        }
    }

    $field           = '';
    $label_id        = $args['id'];
    $sort            = $args['priority'] ? $args['priority'] : '';
    $field_container = '<p class="form-item %1$s" id="%2$s" data-priority="' . esc_attr( $sort ) . '">%3$s</p>';

    switch ( $args['type'] ) {
        case 'country':
            $countries = 'shipping_country' === $key ? WC()->countries->get_shipping_countries() : WC()->countries->get_allowed_countries();

            if ( 1 === count( $countries ) ) {

                $field .= '<strong>' . current( array_values( $countries ) ) . '</strong>';

                $field .= '<input type="hidden" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" value="' . current( array_keys( $countries ) ) . '" ' . implode( ' ', $custom_attributes ) . ' class="country_to_state" readonly="readonly" />';

            } else {

                $field = '<select name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" class="country_to_state country_select ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" ' . implode( ' ', $custom_attributes ) . '><option value="">' . esc_html__( 'Select a country&hellip;', 'woocommerce' ) . '</option>';

                foreach ( $countries as $ckey => $cvalue ) {
                    $field .= '<option value="' . esc_attr( $ckey ) . '" ' . selected( $value, $ckey, false ) . '>' . $cvalue . '</option>';
                }

                $field .= '</select>';

                $field .= '<noscript><button type="submit" name="woocommerce_checkout_update_totals" value="' . esc_attr__( 'Update country', 'woocommerce' ) . '">' . esc_html__( 'Update country', 'woocommerce' ) . '</button></noscript>';

            }

            break;
        case 'state':
            /* Get country this state field is representing */
            $for_country = isset( $args['country'] ) ? $args['country'] : WC()->checkout->get_value( 'billing_state' === $key ? 'billing_country' : 'shipping_country' );
            $states      = WC()->countries->get_states( $for_country );

            if ( is_array( $states ) && empty( $states ) ) {

                $field_container = '<p class="form-row %1$s" id="%2$s" style="display: none">%3$s</p>';

                $field .= '<input type="hidden" class="hidden" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" value="" ' . implode( ' ', $custom_attributes ) . ' placeholder="' . esc_attr( $args['placeholder'] ) . '" readonly="readonly" data-input-classes="' . esc_attr( implode( ' ', $args['input_class'] ) ) . '"/>';

            } elseif ( ! is_null( $for_country ) && is_array( $states ) ) {

                $field .= '<select name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" class="state_select ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" ' . implode( ' ', $custom_attributes ) . ' data-placeholder="' . esc_attr( $args['placeholder'] ? $args['placeholder'] : esc_html__( 'Select an option&hellip;', 'woocommerce' ) ) . '"  data-input-classes="' . esc_attr( implode( ' ', $args['input_class'] ) ) . '">
						<option value="">' . esc_html__( 'Select an option&hellip;', 'woocommerce' ) . '</option>';

                foreach ( $states as $ckey => $cvalue ) {
                    $field .= '<option value="' . esc_attr( $ckey ) . '" ' . selected( $value, $ckey, false ) . '>' . $cvalue . '</option>';
                }

                $field .= '</select>';

            } else {

                $field .= '<input type="text" class="form-input ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" value="' . esc_attr( $value ) . '"  placeholder="' . esc_attr( $args['placeholder'] ) . '" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" ' . implode( ' ', $custom_attributes ) . ' data-input-classes="' . esc_attr( implode( ' ', $args['input_class'] ) ) . '"/>';

            }

            break;
        case 'textarea':
            $field .= '<textarea name="' . esc_attr( $key ) . '" class=" ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" id="' . esc_attr( $args['id'] ) . '" placeholder="' . esc_attr( $args['placeholder'] ) . '" ' . ( empty( $args['custom_attributes']['rows'] ) ? ' rows="5"' : '' ) . ( empty( $args['custom_attributes']['cols'] ) ? ' cols="5"' : '' ) . implode( ' ', $custom_attributes ) . '>' . esc_textarea( $value ) . '</textarea>';

            break;
        case 'checkbox':
            $field = '<label class="checkbox ' . implode( ' ', $args['label_class'] ) . '" ' . implode( ' ', $custom_attributes ) . '>
						<input type="' . esc_attr( $args['type'] ) . '" class="input-checkbox ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" value="1" ' . checked( $value, 1, false ) . ' /> ' . $args['label'] . $required . '</label>';

            break;
        case 'text':
        case 'password':
        case 'datetime':
        case 'datetime-local':
        case 'date':
        case 'month':
        case 'time':
        case 'week':
        case 'number':
        case 'email':
        case 'url':
        case 'tel':
            $field .= '<input type="' . esc_attr( $args['type'] ) . '" class="form-input ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" placeholder="' . esc_attr( $args['placeholder'] ) . '"  value="' . esc_attr( $value ) . '" ' . implode( ' ', $custom_attributes ) . ' />';

            break;
        case 'select':
            $field   = '';
            $options = '';

            if ( ! empty( $args['options'] ) ) {
                foreach ( $args['options'] as $option_key => $option_text ) {
                    if ( '' === $option_key ) {
                        // If we have a blank option, select2 needs a placeholder.
                        if ( empty( $args['placeholder'] ) ) {
                            $args['placeholder'] = $option_text ? $option_text : __( 'Choose an option', 'woocommerce' );
                        }
                        $custom_attributes[] = 'data-allow_clear="true"';
                    }
                    $options .= '<option value="' . esc_attr( $option_key ) . '" ' . selected( $value, $option_key, false ) . '>' . esc_attr( $option_text ) . '</option>';
                }

                $field .= '<select name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" class="select ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" ' . implode( ' ', $custom_attributes ) . ' data-placeholder="' . esc_attr( $args['placeholder'] ) . '">
							' . $options . '
						</select>';
            }

            break;
        case 'radio':
            $label_id .= '_' . current( array_keys( $args['options'] ) );

            if ( ! empty( $args['options'] ) ) {
                foreach ( $args['options'] as $option_key => $option_text ) {
                    $field .= '<input type="radio" class="input-radio ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" value="' . esc_attr( $option_key ) . '" name="' . esc_attr( $key ) . '" ' . implode( ' ', $custom_attributes ) . ' id="' . esc_attr( $args['id'] ) . '_' . esc_attr( $option_key ) . '"' . checked( $value, $option_key, false ) . ' />';
                    $field .= '<label for="' . esc_attr( $args['id'] ) . '_' . esc_attr( $option_key ) . '" class="radio ' . implode( ' ', $args['label_class'] ) . '">' . $option_text . '</label>';
                }
            }

            break;
    }

    if ( ! empty( $field ) ) {
        $field_html = '';

        if ( $args['label'] && 'checkbox' !== $args['type'] ) {
            $field_html .= '<label for="' . esc_attr( $label_id ) . '" class="' . esc_attr( implode( ' ', $args['label_class'] ) ) . '">' . $args['label'] . $required . '</label>';
        }

        $field_html .= '<span class="form-item ">' . $field;

        if ( $args['description'] ) {
            $field_html .= '<span class="description" id="' . esc_attr( $args['id'] ) . '-description" aria-hidden="true">' . wp_kses_post( $args['description'] ) . '</span>';
        }

        $field_html .= '</span>';

        $container_class = esc_attr( implode( ' ', $args['class'] ) );
        $container_id    = esc_attr( $args['id'] ) . '_field';
        $field           = sprintf( $field_container, $container_class, $container_id, $field_html );
    }

    /**
     * Filter by type.
     */
    $field = apply_filters( 'woocommerce_form_field_' . $args['type'], $field, $key, $args, $value );

    /**
     * General filter on form fields.
     *
     * @since 3.4.0
     */
    $field = apply_filters( 'woocommerce_form_field', $field, $key, $args, $value );

    if ( $args['return'] ) {
        return $field;
    } else {
        echo $field; // WPCS: XSS ok.
    }
}

remove_action( 'woocommerce_checkout_order_review', 'woocommerce_order_review', 10 );
remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );
add_action( 'woocommerce_checkout_order_review', 'woocommerce_order_review', 20 );
add_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 10 );


add_action( 'woocommerce_review_order_before_submit', 'in_woocommerce_register_form' );
function in_woocommerce_register_form()
{ ?>
<div class="privacy-input-wrap">
    <label for="terms" class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
        <input type="checkbox" class="form-checkbox woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" name="terms" <?php checked( apply_filters( 'woocommerce_terms_is_checked_default', isset( $_POST['terms'] ) ), true ); ?> id="terms" />
        <span class="form-checkbox-marker"></span>
        <span>Согласие на <a href="http://aglona.loc/?page_id=3" class="woocommerce-terms-and-conditions-link">обработку персональных данных</a></span> <span class="required">*</span>
    </label>



<input type="hidden" name="terms-field" value="1" />
</div>
<?php
}

remove_action( 'woocommerce_cart_is_empty', 'wc_empty_cart_message', 10 );
add_action( 'woocommerce_cart_is_empty', 'my_empty_cart_message', 10 );

function my_empty_cart_message(){
    echo '<h3>' . wp_kses_post( apply_filters( 'wc_empty_cart_message', __( 'Your cart is currently empty.', 'woocommerce' ) ) ) . '</h3>';
}

function get_shipping_choosen() {
    if( WC()->session->get( 'chosen_shipping_methods' )[0] ){
        $chosen_rate = WC()->session->get( 'shipping_for_package_0' )['rates'];
        $chose = WC()->session->get( 'chosen_shipping_methods' )[0];
        return $chosen_rate[$chose];
    }else{
        class foo
        {
            function get_label()
            {
                return WC()->shipping->get_shipping_methods()["local_pickup"]->get_method_title();
            }

            function get_cost()
            {
                return 0;
            }

        }
        return new foo;
    }


}