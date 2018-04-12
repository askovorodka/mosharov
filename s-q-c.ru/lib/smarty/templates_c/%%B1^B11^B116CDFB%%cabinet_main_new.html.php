<?php /* Smarty version 2.6.11, created on 2016-02-05 00:33:26
         compiled from /var/www/alex/data/www/scl.mosharov.com//modules/cabinet/front/templates/cabinet_main_new.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', '/var/www/alex/data/www/scl.mosharov.com//modules/cabinet/front/templates/cabinet_main_new.html', 51, false),)), $this); ?>

<form method="post" action="/cabinet/save/">
<div class="cabinet">
	<div class="form_line form_line--yellow cabinet__yellow">
		<div class="cart_motivator">
			<span class="g-text-verybig">���� ������ ��� ����� � ��!</span><br>
			� �������� ���� ������ �������� email �������� ������, �� ��� ��������� ������ ����� ����� ��������.
		</div>
		<div class="form_line">
			<div class="form_input form_input--fake"><?php echo $this->_tpl_vars['profile']['mail']; ?>
</div> � ��������� email �������� ������
		</div>
		<div class="form_line">
			<label for="cart_password"><input id="cart_password" name="cart_password" type="password" class="form_input form_input--white" placeholder="������"/> �� �� ������ �������� ������</label>
		</div>
	</div>
</div>

<div class="text">

		<div class="form_line">
			<span class="g-text-bigger">��� �������� � �����:</span>
		</div>
		<div class="form_line">
			<label for="cart_name"><input id="cart_name" type="text" name="cart_name" value="<?php echo $this->_tpl_vars['profile']['name']; ?>
" class="form_input" placeholder="��������, ����"/> ���� ��� ������� ���� ������� ��������!</label>
		</div>
		<div class="form_line">
			<label for="cart_phone"><input id="cart_phone" name="cart_phone" value="<?php echo $this->_tpl_vars['profile']['phone_1']; ?>
" type="text" class="form_input" placeholder="(123) 456-78-90"/> ������� ��� ����� ��� ����������� �������</label>
		</div>
		<div class="form_line">
			<label for="cart_address"><input id="cart_address" name="cart_address" value="<?php echo $this->_tpl_vars['profile']['address']; ?>
" type="text" class="form_input" placeholder="�. �����������, ��������� ������, ����. 9"/> ���� ������ ����� �������� �� ����� ����� ���� ����</label>
		</div>
		<div class="form_line">
			<label for="cart_delivery1" class="g-pointer"><input id="cart_delivery1" name="cart_delivery" <?php if ($this->_tpl_vars['profile']['delivery'] == 2 || empty ( $this->_tpl_vars['profile']['delivery'] )): ?> checked<?php endif; ?> value="2" type="radio"/> �������� �������� <span class="g-text-light-gray">(�� ������)</span></label><br>
			<label for="cart_delivery2" class="g-pointer"><input id="cart_delivery2" name="cart_delivery" <?php if ($this->_tpl_vars['profile']['delivery'] == 1): ?> checked<?php endif; ?> value="1" type="radio"/> �������� ������ ������</label>
		</div>
		<div class="form_line">
			<textarea class="form_input form_textarea" placeholder="���������" name="cart_info"><?php echo $this->_tpl_vars['profile']['info']; ?>
</textarea>
		</div>
		<div class="form_line">
			<button class="form_button form_button--yellow">�������� ������</button>
		</div>
</div>
</form>

<?php if (! empty ( $this->_tpl_vars['orders'] )): ?>
<div class="cart_ready g-text-verybig">����������, ��� �� ����������:</div>

	<?php $_from = $this->_tpl_vars['orders']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['order']):
?>
		<div class="text">
			<div class="cabinet__history">
				<div class="cabinet__history_date"><?php echo ((is_array($_tmp=$this->_tpl_vars['order']['insert_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d.%m.%Y") : smarty_modifier_date_format($_tmp, "%d.%m.%Y")); ?>
</div>
				<?php if (! empty ( $this->_tpl_vars['order']['items'] )): ?>
				<div class="cabinet__history_items">
					<?php $_from = $this->_tpl_vars['order']['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
						<?php echo $this->_tpl_vars['item']['product']['name']; ?>
 <span class="g-text-gray">� <?php echo $this->_tpl_vars['item']['product_count']; ?>
 ��.</span><br>
					<?php endforeach; endif; unset($_from); ?>
				</div>
				<?php endif; ?>
				<div class="cabinet__history_price"><?php echo $this->_tpl_vars['order']['total_price']; ?>
 ���.</div>
			</div>
		</div>
	<?php endforeach; endif; unset($_from); ?>

<?php endif; ?>