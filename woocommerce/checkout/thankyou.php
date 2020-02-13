<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="cart__order-made-b">
    <h3>Заказ <span class="js-order-id-from-ajax"></span> оформлен</h3>
    <div class="form-success__text">Спасибо! Ваш заказ успешно оформлен.
        <br>Мы свяжемся с вами в ближайшее время.</div>
    <a class="basic-btn form-success-btn js-form-success-btn" href="/catalog/">Перейти в каталог</a>
</div>
