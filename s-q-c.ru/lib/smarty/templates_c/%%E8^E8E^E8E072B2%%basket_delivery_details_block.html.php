<?php /* Smarty version 2.6.11, created on 2018-04-06 08:41:57
         compiled from /home/a0031953/domains/s-q-c.ru/public_html/conf/../modules/shop/front/templates/basket_delivery_details_block.html */ ?>
<div class="form_line">
    <span class="g-text-big"><span id="summary_info_block"><?php echo $this->_tpl_vars['total_price']; ?>
</span> руб.  Ч </span> это сумма вашего заказа. ≈сли вы укажете свои данные, нам будет проще доставить его.
</div>
<div class="form_line">
    <label for="cart_name">
        <input <?php if (! empty ( $this->_tpl_vars['profile'] )): ?> value="<?php echo $this->_tpl_vars['profile']['name']; ?>
"<?php endif; ?> id="cart_name" name="cart_name" type="text" class="form_input" placeholder="Ќапример, »ван"/> ваше им€ <span class="g-text-gray">сделает наше общение при€тнее!</span></label>
</div>
<div class="form_line">
			<label for="cart_lastname"><input id="cart_lastname" type="text" name="cart_lastname" value="<?php echo $this->_tpl_vars['profile']['lastname']; ?>
" class="form_input" placeholder="Ќапример, »ванов"/> фамили€ <span class="g-text-gray">поможет правильно доставить заказ</span></label>
		</div>
<div class="form_line">
    <label for="cart_phone"><input id="cart_phone" <?php if (! empty ( $this->_tpl_vars['profile'] )): ?> value="<?php echo $this->_tpl_vars['profile']['phone_1']; ?>
"<?php endif; ?> name="cart_phone" type="text" class="form_input" placeholder="(123) 456-78-90"/> телефон <span class="g-text-gray">нам нужен дл€ утверждени€ заказов</span></label>
</div>
<div class="form_line">
    <label for="cart_city"><input id="cart_city" <?php if (! empty ( $this->_tpl_vars['profile'] )): ?> value="<?php echo $this->_tpl_vars['profile']['city']; ?>
"<?php endif; ?> name="cart_city" type="text" class="form_input" placeholder="ћосква"/> город доставки <span class="g-text-gray">(начните набирать и мы предложим варианты)</span></label>
</div>
<div class="form_line">
    <label for="cart_street"><input id="cart_street" <?php if (! empty ( $this->_tpl_vars['profile'] )): ?> value="<?php echo $this->_tpl_vars['profile']['street']; ?>
"<?php endif; ?> name="cart_street" type="text" class="form_input" placeholder="ул.  расна€ площадь"/> улица <span class="g-text-gray">(начните набирать и мы предложим варианты)</span></label>
</div>
<div class="form_line">
    <label for="cart_house"><input id="cart_house" <?php if (! empty ( $this->_tpl_vars['profile'] )): ?> value="<?php echo $this->_tpl_vars['profile']['house']; ?>
"<?php endif; ?> name="cart_house" type="text" class="form_input" placeholder="20Ѕ"/> и номер дома</label>
</div>
<div class="form_line">
    <label for="cart_index"><input id="cart_index" <?php if (! empty ( $this->_tpl_vars['profile'] )): ?> value="<?php echo $this->_tpl_vars['profile']['post_index']; ?>
"<?php endif; ?> name="cart_index" type="text" class="form_input" placeholder="123456"/> почтовый индекс <span class="g-text-gray">(заполнитс€ автоматически, если остальные пол€ верны)</span></label>
</div>
<div class="form_line"><div class="form-active-link" data-ydwidget-open>¬ыберите себе доставку</div></div>
<div class="form_line" id="delivery_description"></div>
<div class="form_line" id="cart_errors"></div>
<input id="cart_address" <?php if (! empty ( $this->_tpl_vars['profile'] )): ?> value="<?php echo $this->_tpl_vars['profile']['address']; ?>
"<?php endif; ?> name="cart_address" type="text" class="g-hidden"/>
<input id="cart_delivery" value="" name="cart_delivery" type="text" class="g-hidden"/>