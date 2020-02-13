
<h2>Ajax response</h2>
<div class="cat__prod__item-prices-b">
    <div class="cat-prod__item-prices__size-cell">
        <div class="cat-prod__item-prices__size-title _in-cell">Размер:</div>
        <a class="cat-prod__item-prices__size-text js-cat-prod-item-size" href="<? echo $link; ?>">
            <? echo $options['pa_size'][0]; ?>
        </a>
    </div>
    <div class="cat-prod__item-prices__cells-wrap">
        <? foreach ($options['prod_price'] as $key=>$price): ?>

            <div class="cat-prod__item-prices__cells-line js-prod-cells-line" id="<? echo $options['prod_id'][$key];?>" data-qty="1" data-id="<? echo $options['prod_id'][$key];?>" data-price="<? echo $options['prod_price'][$key];?>" data-title="<? echo $options['prod_title'][$key];?>" data-mark="<? echo $options['pa_brand'][$key]; ?>" data-amount="<? echo $options['pa_amount'][$key]; ?>" >

                <div class="cat-prod__item-prices__cell _mark">
                    <div class="cat-prod__item-prices__mark-text-b">
                        <div class="cat-prod__item-prices__mark-text js-cat-prod-item-mark"><? echo $options['pa_brand'][$key]; ?></div>
                        <div class="cat-prod__item-prices__mark-popup">ГОСТ 5781-82</div>
                    </div>
                </div>
                <div class="cat-prod__item-prices__cell _length">
                    <div class="cat-prod__item-prices__length-text js-cat-prod-item-length"><? echo $options['pa_length'][$key]; ?></div>
                </div>
                <div class="cat-prod__item-prices__cell _price">
                    <div class="cat-prod__item-prices__price-text js-cat-prod-item-price ">
                        <span class='js-line-price'><? echo $options['prod_price'][$key]; ?></span> ₽/т
                    </div>
                </div>
                <div class="cat-prod__item-prices__cell">
                    <div class="cat-prod__item-prices__add-b">
                        <div class="cat-prod__item-prices__added"></div>
                        <div class="cat-prod__item-prices__add-btn js-cat-prod-item-add"></div>
                    </div>
                </div>

            </div>

        <? endforeach; ?>

    </div>

</div>


