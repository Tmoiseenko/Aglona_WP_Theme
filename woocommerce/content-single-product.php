<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
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

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked wc_print_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>


<div class="catalog__content__body-b">
    <div class="catalog__tabs-wrap">
        <div class="catalog__tabs-wrap__inner-wrap">

            <?
            /**
             * Hook: woocommerce_sidebar.
             *
             * @hooked woocommerce_get_sidebar - 10
             */
            do_action( 'woocommerce_sidebar' );

            ?>

            <div class="catalog__tab js-catalog-tab" data-tab="2" >
                <div class="inner-content">
                    <div class="cat__prod__inner-wrap">
                        <div class="cat__prod-b js-cart-prod-b">

	<?php
	/**
	 * Hook: woocommerce_before_single_product_summary.
	 *
	 * @hooked woocommerce_show_product_sale_flash - 10
	 * @hooked woocommerce_show_product_images - 20
	 */

	do_action( 'woocommerce_before_single_product_summary' );

		/**
		 * Hook: woocommerce_single_product_summary.
		 *
		 * @hooked woocommerce_template_single_title - 5
		 * @hooked woocommerce_template_single_rating - 10
		 * @hooked woocommerce_template_single_price - 10
		 * @hooked woocommerce_template_single_excerpt - 20
		 * @hooked woocommerce_template_single_add_to_cart - 30
		 * @hooked woocommerce_template_single_meta - 40
		 * @hooked woocommerce_template_single_sharing - 50
		 * @hooked WC_Structured_Data::generate_product_data() - 60
         *
		 */

		do_action( 'woocommerce_single_product_summary' );
		?>
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
    <? wc_get_template_part( 'content', 'product_mytemplate' );
    wc_get_template( 'single-product/tabs/description.php' );?>
	</div>
	</div>
	</div>
	</div>

	<?php
    get_sidebar( 'right' );

	/**
	 * Hook: woocommerce_after_single_product_summary.
	 *
	 * @hooked woocommerce_output_product_data_tabs - 10
	 * @hooked woocommerce_upsell_display - 15
	 * @hooked woocommerce_output_related_products - 20
	 */
//	do_action( 'woocommerce_after_single_product_summary' );
	?>
</div>
</div>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>
