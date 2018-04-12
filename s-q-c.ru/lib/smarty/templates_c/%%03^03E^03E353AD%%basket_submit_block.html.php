<?php /* Smarty version 2.6.11, created on 2016-02-04 21:09:27
         compiled from /var/www/alex/data/www/scl.mosharov.com/conf/../modules/shop/front/templates/basket_submit_block.html */ ?>
<div class="form_line">
    <textarea class="form_input form_textarea" name="cart_message" placeholder="Сообщение"><?php if (! empty ( $this->_tpl_vars['user']['info'] )):  echo $this->_tpl_vars['user']['info'];  endif; ?></textarea>
</div>
<div class="form_line">
    <label><button class="form_button form_button--yellow" type="submit">Оформить заказ</button> <span class="g-text-big">Есть вопросы? Звоните: <?php echo @PHONE; ?>
</span></label>
</div>