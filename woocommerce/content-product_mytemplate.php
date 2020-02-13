<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;
$link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );
$prod_ids = $product->get_children() ;
//var_dump($product->get_ID());
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

    $attributes = $_prod->get_attributes();
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


