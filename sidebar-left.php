<?php

$terms = get_terms( 'product_cat', array('hide_empty'   => 0)  );
$parent_term = [];
foreach ($terms as $term){
    if ( $term->parent == 0 && $term->slug != "uncategorized" ) array_push($parent_term, $term);
}

?>

<div class="catalog__tab js-catalog-tab" data-tab="1">
    <div class="catalog__inner-tab-toggle-b">
        <div class="catalog__inner-tab-toggle-item js-inner-tabs-toggle _mobile">Вернуться к продукции</div>
        <div class="catalog__inner-tab-toggle-item js-inner-tabs-toggle _tablet">Свернуть список</div>
    </div>
    <div class="inner-content">
        <div class="catalog__list__toggle-b">
            <a class="catalog__list__toggle-item _active" href="#" data-list="all">Все</a>
        </div>
        <div class="catalog__list__content-wrap">
            <div class="catalog__list__links-wrap js-list-content _active" data-list="all">

                <? foreach ($parent_term as $prod_cat): ?>

                            <div class="catalog__list__links-b js-list-items-toggle-b _open">
                                <div class="catalog__list__links-head js-list-items-toggle-head"><? echo $prod_cat->name; ?></div>
                                <?
                                    $children_terms = get_terms( 'product_cat', array('hide_empty'   => 0, 'child_of' => $prod_cat->term_id )  );
                                ?>

                                <nav class="catalog__list__links-content js-list-items-toggle-content">

                                    <? foreach ($children_terms as $child):?>

                                    <li class="catalog__list__link-item-wrap">
                                        <a class="catalog__list__link-item <? echo ( is_product_category($child->slug) ) ?  "_active" : ""; ?>" href="<? echo get_term_link( $child ); ?>"><? echo $child->name; ?></a>
                                    </li>

                                    <? endforeach; ?>

                                </nav>
                            </div>

                <? endforeach; ?>


            </div>
        </div>
    </div>
</div>