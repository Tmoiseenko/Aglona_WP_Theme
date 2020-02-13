<?php
/**
 * Show options for ordering
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/orderby.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version     3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$pa_brand = get_terms( 'pa_brand', array(
        'hide_empty' => false,
    )
);

$pa_size = get_terms( 'pa_size', array(
        'hide_empty' => false,
    )
);

?>




<form class="cat__prod__filters-b js-catalog-filter">

    <select class="js-select2-size"  name="size" style="width: calc(33% - 5px)">
        <option value="all">Все размеры</option>

        <? foreach ( $pa_size as $size ): ?>
            <option value="<? echo $size->name; ?>"  ><? echo $size->name; ?></option>
        <? endforeach; ?>

    </select>

    <select class="js-select2-mark" name="mark" style="width: calc(33% - 5px)">
        <option value="all">Все марки</option>
        <? foreach ( $pa_brand as $brand ): ?>
            <option value="<? echo $brand->name; ?>"  ><? echo $brand->name; ?></option>
        <? endforeach; ?>
    </select>

    <div class="cat__prod__filter-item js-stock-item ">
        <label class="cat__prod-filters__select-label">
            <input class="cat__prod-filters__input js-filter-input" name="stock" type="checkbox" >
            <div class="cat__prod__filter-item-text">В наличии</div>
        </label>
    </div>
</form>
