<?php /* Smarty version 2.6.11, created on 2016-02-16 18:55:35
         compiled from /home/a0031953/domains/a0031953.xsph.ru/public_html/conf/../templates/basket_block.html */ ?>
    <div class="basket"><p>
	В вашей корзине <span id="basket_number"><?php echo $this->_tpl_vars['basket_number']; ?>
</span> товаров<br>
	На сумму: <span id="basket_currency"><?php echo $this->_tpl_vars['basket_total']; ?>
</span> руб.<br>
	<a href="/catalog/basket/">перейти в корзину</a>
    </p></div>
    <img src="<?php echo $this->_tpl_vars['template_image']; ?>
clear.gif" width="275" height="1">