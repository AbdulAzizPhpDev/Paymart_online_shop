<div class="hard-code-installment-price">
    <span class="price__number">{$product['installment']|number_format:false:false:' '} {$currencies[$smarty.const.CART_PRIMARY_CURRENCY].symbol}</span>
    <span class="price__month">x 12 {__('month')|lower}</span>
</div>