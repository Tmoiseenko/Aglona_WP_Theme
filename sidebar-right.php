<div class="catalog__tab js-catalog-tab" data-tab="3">
    <div class="inner-content">
        <div class="catalog__cart__step-b _step-1-b">
            <img class="cat-cart__empty-list-icon" src="<? bloginfo('template_url'); ?>/img/svg/cart_list_icon.svg" alt="">
            <div class="cat-cart__info-title-big">Создайте подборку</div>
            <div class="cat-cart__info-text">Вы сможете быстро определить количество
                <br>и расчитать стоимость. Для этого нажмите
                <br>на кнопку в таблице.</div>
            <img class="cat-cart__empty-icon" src="<? bloginfo('template_url'); ?>/img/svg/cart_empty_icon.svg" alt="">
        </div>
        <div class="catalog__cart__step-b _step-2-b">
            <div class="cat-cart__title">Подборка</div>
            <div class="cat-cart__table">
                <div class="cat-cart__table-lines-wrap js-cart-lines-wrap">

                </div>
                <div class="cat-cart__table-total-line">
                    <div class="cat-cart__table-total__title">Итого:</div>
                    <div class="cat-cart__table-total__price js-cart-total-price"></div>
                </div>
                <div class="cat-cart__info-text">Обратите внимание, что итоговое количество погонных метров может определяться фасовкой продукции.</div>

                <div class="cat-cart__selection-clear-wrap">
                    <div class="cat-cart__selection-clear js-cart-clear-all">Очистить</div>
                </div>
            </div>
            <div class="basic-btn cat-cart__step-2__cart-btn js-send-to-cart-btn  ajax_add_to_cart add_to_cart_button">В корзину</div>
        </div>
        <div class="catalog__cart__step-b _step-3-b">
            <div class="cat-cart__info-title">Подобранные вами
                <span class="js-cat-cart-count"></span> товаров,
                <br>добавлены в
                <a href="<? echo wc_get_cart_url(); ?>">Корзину</a>
            </div>
            <a class="basic-btn cat-cart__step-3__cart-btn" href="<? echo wc_get_cart_url(); ?>">Перейти в корзину</a>
        </div>
    </div>
</div>