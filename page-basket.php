<?php
/* Template name: basket-template */

get_header();
?>

    <section class="content js-cart-page " >
        <div class="catalog__content__head-b">
            <div class="inner-content _z-15">
                <? woocommerce_breadcrumb(); ?>
                <h1><? the_title(); ?></h1>
            </div>
        </div>
    <div class="catalog__content__body-b">

    <div class="about__tabs-wrap">
    <section class="about__content-wrap">
        <div class="inner-content _cols-wrap">

            <div class="delivery__map-wrap">

                <?php

                /* Start the Loop */
                while ( have_posts() ) :
                    the_post();

                    the_content();

                    // If comments are open or we have at least one comment, load up the comment template.
                    if ( comments_open() || get_comments_number() ) {
                        comments_template();
                    }

                endwhile; // End of the loop.
                ?>
            </div>




        </div>
    </section>
    </div>
    </div>
    </section>
    <script>
        jQuery( function( $ ) {
            $(document).ready(function () {
                if($('._second-store').length>1 ){
                    var sec_top =  ( $('._second-store:first').offset().top - $('._second-store:last').offset().top) / 2 ;
                    $('.second-store-wrapp').offset({top: $('._second-store:first').offset().top - sec_top + 30});
                }else {
                    var sec_top =   $('._second-store').offset().top / 2 ;
                    $('.second-store-wrapp').offset({top: $('._second-store').offset().top + 30});
                }

                if($('._first-store').length>1 ){
                    var first_top =  ( $('._first-store:first').offset().top - $('._first-store:last').offset().top) / 2 ;
                    $('.first-store-wrapp').offset({top: $('._first-store:first').offset().top - first_top + 30});
                }else {
                    var first_top =   $('._first-store').offset().top / 2 ;
                    $('.first-store-wrapp').offset({top: $('._first-store').offset().top + 30});
                }
            });
        });
    </script>
<?php

get_footer();