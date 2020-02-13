<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */

get_header();
?>

    <section class="content js-styles-page ">
        <div class="catalog__content__head-b">
            <div class="inner-content _z-15">
                <? woocommerce_breadcrumb(); ?>
                <h1><? the_title(); ?></h1>
            </div>
        </div>
        <div class="catalog__content__body-b">
            <div class="about__tabs-wrap">
                <section class="about__content-wrap" data-dest="sect_1">
                    <div class="inner-content _cols-wrap">
                        <? if(!is_order_received_page()): ?>
                            <aside class="content__left-b ">
                                <? get_sidebar('page'); ?>
                            </aside>
                        <? endif; ?>
                        <div class="content__right-b ">

                            <?php

                            while ( have_posts() ) :
                                the_post();

                                the_content();

                                if ( comments_open() || get_comments_number() ) {
                                    comments_template();
                                }

                            endwhile;
                            ?>

                        </div>
                    </div>
                </section>
            </div>    </div>
    </section>



<?php

if(is_order_received_page()):
                            ?>
    <script>
        jQuery( function( $ ) {
            $(document).ready(function () {
                $('html').find('.cart__order-made-b').parents('.content__right-b').css('width', '100%');
            });
        });
    </script>
<?
endif;
get_footer();
