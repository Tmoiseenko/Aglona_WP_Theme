<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!--<ul class="products columns---><?php //echo esc_attr( wc_get_loop_prop( 'columns' ) ); ?><!--">-->

<div class="cat__prod__item-content-wrap">
    <div class="products cat__prod__item-content-b js-cat-prod-content _active" data-item="price">
        <div class="cat__prod__item-prices-wrap js-catalog-output-b">
            <div class="cat__prod__item-prices-head-b">
                <div class="cat-prod__item-prices__size-cell">
                    <div class="cat-prod__item-prices__size-title">Размер</div>
                </div>
                <div class="cat-prod__item-prices__cell _mark">
                    <div class="cat-prod__item-prices__cell-title">Марка</div>
                </div>
                <div class="cat-prod__item-prices__cell _length">
                    <div class="cat-prod__item-prices__cell-title">Длина</div>
                </div>
                <div class="cat-prod__item-prices__cell _price">
                    <div class="cat-prod__item-prices__cell-title">Цена, с НДС</div>
                </div>
                <div class="cat-prod__item-prices__cell _add">
                    <div class="cat-prod__item-prices__cell-title">Подборка</div>
                </div>
            </div>
            <div class="prod-wrapp">

