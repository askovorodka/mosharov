<?php /* Smarty version 2.6.11, created on 2012-02-07 17:46:20
         compiled from /home/alex/data/www/shop-toy.mosharov.com/conf/../templates/basket_block.html */ ?>
<div class="basket">
	<div class="basketin">� ��� <span class="basko" id="basket_number"><?php echo $this->_tpl_vars['basket_number']; ?>
</span> �������<br>�� �����: <span class="basks" id="basket_currency"><?php echo $this->_tpl_vars['basket_total']; ?>
</span> ���.</div>
	<div class="basketbut"><input onClick="location = 'http://' + location.hostname + '/catalog/basket/';" type="image" src="<?php echo $this->_tpl_vars['template_image']; ?>
but_top_basket.png" value="� �������"></div>
</div>