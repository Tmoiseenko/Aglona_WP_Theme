<?php
/**
 * Single Product title
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/title.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://docs.woocommerce.com/document/template-structure/
 * @package    WooCommerce/Templates
 * @version    1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
    <div class="cat__prod-head__content-wrap">
        <H1 class="cat__prod-head__title"><? the_title(); ?></H1>
        <a class="cat__prod-head__all-link" href="<? echo $_SERVER['HTTP_REFERER']; ?>">
            <span>Все размеры</span>
        </a>
    </div>

