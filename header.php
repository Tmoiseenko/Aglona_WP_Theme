<?php
/** The template for displaying the header */
if (isset(WC()->session)) {
    if (!WC()->session->has_session()) {
        WC()->session->set_customer_session_cookie(true);
    }
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="<? echo (wp_is_mobile()) ? "js touch chrome android" :"js no-touch"; ?> _hide-scroll-top catalog-page _prod _cart-1 _loaded <? echo (is_cart()) ? "cart-page" :""; ?> ">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, viewport-fit=cover">
    <title><? the_title(); ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="<? bloginfo( 'template_url' ); ?>/img/favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="<? bloginfo( 'template_url' ); ?>/img/favicon.ico">

    <?php wp_head(); ?>
</head>

<header class="header js-header">
    <div class="inner-content">
        <a class="h-logo-link" href="/">
            <span><? bloginfo('name '); ?></span>
        </a>

        <div class="h-selection-b js-h-selection-b ">
            <img class="h-selection__icon" src="<? bloginfo( 'template_url' ); ?>/img/svg/cart_selection_icon.svg" alt="">
            <img class="h-selection__icon _h-selection-white" src="<? bloginfo( 'template_url' ); ?>/img/svg/cart_selection_icon_white.svg" alt="">
            <img class="h-selection__icon _hover-icon" src="<? bloginfo( 'template_url' ); ?>/img/svg/cart_selection_icon_green.svg" alt="">
            <div class="h-cart__info js-catalog-selection-count">0</div>
            <div class="h-selection__info-b">В вашей подборке нет товаров.
                <br>Для подбора перейдите в
                <span class="js-h-to-catalog" data-href="/catalog/">каталог</span>.</div>
        </div>
        <a class="h-cart-b js-h-cart-b " href="<? echo wc_get_cart_url(); ?>">
            <img class="h-cart__icon" src="<? bloginfo( 'template_url' ); ?>/img/svg/cart.svg" alt="">
            <img class="h-cart__icon _h-cart-white" src="<? bloginfo( 'template_url' ); ?>/img/svg/cart_w.svg" alt="">
            <img class="h-cart__icon _hover-icon" src="<? bloginfo( 'template_url' ); ?>/img/svg/cart_green.svg" alt="">
            <div class="h-cart__info js-h-cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></div>
        </a>
        <div class="h-burger-btn js-burger-btn">
            <div class="h-burger__line _top"></div>
            <div class="h-burger__line _middle"></div>
            <div class="h-burger__line _bottom"></div>
        </div>
        <div class="h-burger-b">

                <?
                wp_nav_menu( [
                    'container'       => 'div',
                    'container_class' => 'h-burger__wrap',
                    'menu'            => 'main-menu',
                    'menu_class'      => 'h-nav',
                    'menu_id'         => '',
                    'items_wrap'      => '<nav class="%2$s">%3$s</nav>',
                    'walker'          => new Custom_Walker_Nav_Menu(),
                ]);

                ?>

        </div>
    </div>
</header>

<body>