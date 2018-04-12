<?php /* Smarty version 2.6.11, created on 2016-02-16 18:58:49
         compiled from /home/a0031953/domains/a0031953.xsph.ru/public_html/conf/../modules/shop/front/templates/basket_submit_block.html */ ?>
<div class="form_line">
    <textarea class="form_input form_textarea" name="cart_message" placeholder="Сообщение"><?php if (! empty ( $this->_tpl_vars['user']['info'] )):  echo $this->_tpl_vars['user']['info'];  endif; ?></textarea>
</div>
<div class="form_line">
    <label><button class="form_button form_button--yellow" type="submit">Оформить заказ</button> <span class="g-text-big">Есть вопросы? Звоните: <?php echo @PHONE; ?>
</span></label>
</div>