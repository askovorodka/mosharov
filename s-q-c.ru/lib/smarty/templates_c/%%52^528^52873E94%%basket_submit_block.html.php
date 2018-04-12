<?php /* Smarty version 2.6.11, created on 2016-04-25 23:44:53
         compiled from /home/a0031953/domains/s-q-c.ru/public_html/conf/../modules/shop/front/templates/basket_submit_block.html */ ?>
<div class="form_line">
    <textarea class="form_input form_textarea" name="cart_message" placeholder="Сообщение"><?php if (! empty ( $this->_tpl_vars['user']['info'] )):  echo $this->_tpl_vars['user']['info'];  endif; ?></textarea>
</div>
<div class="form_line">
    <label><input class="form_button form_button--yellow" value="Оформить заказ" type="button" data-ydwidget-createorder> <span class="g-text-big">Есть вопросы? Звоните: 8 (925) 329-320-9</span></label>
</div>