<?php /* Smarty version 2.6.11, created on 2016-02-08 17:20:22
         compiled from /var/www/alex/data/www/scl.mosharov.com//modules/shop/front/templates/order_notice.txt */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', '/var/www/alex/data/www/scl.mosharov.com//modules/shop/front/templates/order_notice.txt', 5, false),)), $this); ?>
<p>������������, <?php echo $this->_tpl_vars['name']; ?>
</p>

<p>�� ������� ����� �� ����� http://<?php echo $_SERVER['SERVER_NAME']; ?>
</p>

<p>����: <?php echo ((is_array($_tmp=$this->_tpl_vars['date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d.%m.%Y � %T") : smarty_modifier_date_format($_tmp, "%d.%m.%Y � %T")); ?>
</p> 

<p>����� ������ ������: <?php echo $this->_tpl_vars['order_id']; ?>
</p>

<p>�� �������� <?php echo $this->_tpl_vars['number']; ?>
 ������� �� ����� <?php echo $this->_tpl_vars['order_total']; ?>
  <?php echo $this->_tpl_vars['currency']; ?>
.</p>

<p>������ ��������: <?php if ($this->_tpl_vars['delivery'] == 2): ?>��������<?php else: ?>���������<?php endif; ?></p>

<p><b>������ ���������� �������</b></p>

<table>
<tr>
<th>�</th>
<th>������������</th>
<th>����������</th>
<th>��-�� ������</th>
<th>��������� �� �������</th><th>�����</th></tr>
<?php $_from = $this->_tpl_vars['products']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['for1'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['for1']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['product']):
        $this->_foreach['for1']['iteration']++;
?>
<tr><td><?php echo $this->_foreach['for1']['iteration']; ?>
</td>
<td><?php echo $this->_tpl_vars['product']['details']['name']; ?>
</td>
<td><?php echo $this->_tpl_vars['product']['count']; ?>
</td>
<td>
				<?php if (! empty ( $this->_tpl_vars['product']['properties'] )): ?>
					<?php $_from = $this->_tpl_vars['product']['properties']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['forP'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['forP']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['property']):
        $this->_foreach['forP']['iteration']++;
?>
						<?php if ($this->_tpl_vars['key'] == 'color'): ?>
							����: <span style="background-color: <?php echo $this->_tpl_vars['property']; ?>
; display: inline-block; width: 10px; height: 10px;"></span>
						<?php endif; ?>

						<?php if ($this->_tpl_vars['key'] == 'size'): ?>
						������: <?php echo $this->_tpl_vars['property']; ?>

						<?php endif; ?>
						<?php if (! ($this->_foreach['for1']['iteration'] == $this->_foreach['for1']['total'])): ?>, <?php endif; ?>
					<?php endforeach; endif; unset($_from); ?>
				<?php endif; ?>
</td>
<td><?php echo $this->_tpl_vars['product']['details']['price']; ?>
 ���.</td>
<td><?php echo $this->_tpl_vars['product']['sum']; ?>
 ���.</td></tr>
<?php endforeach; endif; unset($_from); ?>

<tr>
<td colspan="4" align="right">��������� ��������:</td>
<td><?php echo $this->_tpl_vars['order_price']; ?>
 ���.</td>
</tr>

<tr>
<td colspan="4" align="right">�����:</td>
<td><?php echo $this->_tpl_vars['order_total']; ?>
 ���.</td>
</tr>

<?php if (! empty ( $this->_tpl_vars['promoSale'] )): ?>
<tr>
<td colspan="4" align="right">������ �� �����-����:</td>
<td><?php echo $this->_tpl_vars['promoSale']; ?>
 ���.</td>
</tr>
<?php endif; ?>

<?php if (! empty ( $this->_tpl_vars['registerSale'] )): ?>
<tr>
<td colspan="4" align="right">������ ��������������� ������������:</td>
<td><?php echo $this->_tpl_vars['registerSale']; ?>
 ���.</td>
</tr>
<?php endif; ?>

<tr>
<td colspan="4" align="right">� ������ ������:</td>
<td><?php echo $this->_tpl_vars['order_total']; ?>
 ���.</td>
</tr>

</table>

<p>��� ����� ����������� �����: <?php echo $this->_tpl_vars['email']; ?>
</p>

<p>����� ��������� ���� ��� ������: <?php echo $this->_tpl_vars['address']; ?>
</p>

<p>�������: <?php echo $this->_tpl_vars['phone']; ?>
</p>

<p>��� �����������: <?php echo $this->_tpl_vars['comment']; ?>
</p>

�� ������ ������!