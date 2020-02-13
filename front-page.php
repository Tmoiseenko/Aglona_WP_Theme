<?php
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
                            <aside class="content__left-b ">
                                <? get_sidebar('page'); ?>
                            </aside>
                        <div class="content__right-b ">

                            <?php

                            while ( have_posts() ) :
                                the_post();
                                the_post_thumbnail('thumbnail');
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
get_footer();
