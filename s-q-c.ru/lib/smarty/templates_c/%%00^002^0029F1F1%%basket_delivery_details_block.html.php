<?php /* Smarty version 2.6.11, created on 2016-02-04 21:16:01
         compiled from /var/www/alex/data/www/scl.mosharov.com/conf/../modules/shop/front/templates/basket_delivery_details_block.html */ ?>
<div class="form_line">
    <span class="g-text-big"><span id="summary_info_block"><?php echo $this->_tpl_vars['total_price']; ?>
</span> ���.  � </span> ��� ����� ������ ������. ���� �� ������� ���� ������, ��� ����� ����� ��������� ���.
</div>
<div class="form_line">
    <label for="cart_name">
        <input <?php if (! empty ( $this->_tpl_vars['profile'] )): ?> value="<?php echo $this->_tpl_vars['profile']['name']; ?>
"<?php endif; ?> id="cart_name" name="cart_name" type="text" class="form_input" placeholder="��������, ����"/> ���� ��� ������� ���� ������� ��������!</label>
</div>
<div class="form_line">
    <label for="cart_phone"><input id="cart_phone" <?php if (! empty ( $this->_tpl_vars['profile'] )): ?> value="<?php echo $this->_tpl_vars['profile']['phone_1']; ?>
"<?php endif; ?> name="cart_phone" type="text" class="form_input" placeholder="(123) 456-78-90"/> ������� ������� ��� ��������� � ��������� ����� ;)</label>
</div>
<div class="form_line">
    <label for="cart_address"><input id="cart_address" <?php if (! empty ( $this->_tpl_vars['profile'] )): ?> value="<?php echo $this->_tpl_vars['profile']['address']; ?>
"<?php endif; ?> name="cart_address" type="text" class="form_input" placeholder="�. �����������, ��������� ������, ����. 9"/> ���� ������ ����� �������� �� ����� ����� ���� ����</label>
</div>
<div class="form_line">
    <label for="cart_delivery1" class="g-pointer"><input id="cart_delivery1" <?php if (! empty ( $this->_tpl_vars['profile']['delivery'] ) && $this->_tpl_vars['profile']['delivery'] == 2): ?>checked<?php endif; ?> name="delivery" type="radio" value="2"/> �������� �������� <span class="g-text-light-gray">(�� ������)</span></label><br>
    <label for="cart_delivery2" class="g-pointer"><input id="cart_delivery2" name="delivery" type="radio" <?php if (( ! empty ( $this->_tpl_vars['profile']['delivery'] ) && $this->_tpl_vars['profile']['delivery'] == 1 ) || empty ( $this->_tpl_vars['profile']['delivery'] )): ?>checked<?php endif; ?> value="1"/> �������� ������ ������</label>
</div>