<?php /* Smarty version 2.6.11, created on 2014-07-28 01:25:22
         compiled from ../templates/basket_block.html */ ?>
<div id="basket_block" class="shoppingcart"<?php if (! $this->_tpl_vars['basket_number']): ?> style="display:none;"<?php endif; ?>>
           <span class="shoppingcart-items">Товаров: 
           <span id="basket_number"><?php echo $this->_tpl_vars['basket_number']; ?>
</span>, 
           на сумму: <span id="basket_currency"><?php echo $this->_tpl_vars['basket_total']; ?>
</span></span>
           <button href="/catalog/basket/" class="shoppingcart-button" onClick="location.href=$(this).attr('href');">В корзину</button>
</div>