<?php /* Smarty version 2.6.11, created on 2018-04-06 08:47:56
         compiled from /home/a0031953/domains/s-q-c.ru/public_html//modules/shop/front/templates/admin_order_notice.txt */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', '/home/a0031953/domains/s-q-c.ru/public_html//modules/shop/front/templates/admin_order_notice.txt', 3, false),)), $this); ?>
<p>В вашем онлайн магазине http://<?php echo $_SERVER['SERVER_NAME']; ?>
 сделан заказ</p>

<p>Дата: <?php echo ((is_array($_tmp=$this->_tpl_vars['date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d.%m.%Y в %T") : smarty_modifier_date_format($_tmp, "%d.%m.%Y в %T")); ?>
</p> 

<p>Номер заказа: <?php echo $this->_tpl_vars['order_id']; ?>
</p>

<p>Имя пользователя: <?php echo $this->_tpl_vars['name']; ?>
 <?php echo $this->_tpl_vars['lastname']; ?>
</p>

<p>Email пользователя: <?php echo $this->_tpl_vars['email']; ?>
</p>
<p>Телефон пользователя: <?php echo $this->_tpl_vars['phone']; ?>
</p>
<p>Пользователь заказал <?php echo $this->_tpl_vars['number']; ?>
 товаров на сумму <?php echo $this->_tpl_vars['order_total']; ?>
 <?php echo $this->_tpl_vars['currency']; ?>
.</p> 

<p><b>Список заказанных товаров</b></p>

<table cellpadding="3">
<tr><th>№</th>
<th>Наименование</th>
<th>Количество</th>
<th>Св-ва товара</th>
<th>Стоимость за единицу</th>
<th>Сумма</th></tr>
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
					
						<?php if ($this->_tpl_vars['key'] == 'name'): ?>
							Цвет: <?php echo $this->_tpl_vars['property']; ?>

						<?php endif; ?>

						<?php if ($this->_tpl_vars['key'] == 'size'): ?>
						Размер: <?php echo $this->_tpl_vars['property']; ?>
(РФ)
						<?php endif; ?>
						
						<?php if ($this->_tpl_vars['key'] == 'size_brand'): ?>
						Размер: <?php echo $this->_tpl_vars['property']; ?>
(Бренд)
						<?php endif; ?>
						<?php if (! ($this->_foreach['for1']['iteration'] == $this->_foreach['for1']['total'])): ?>, <?php endif; ?>
					<?php endforeach; endif; unset($_from); ?>
				<?php endif; ?>
</td>
<td><?php echo $this->_tpl_vars['product']['price']; ?>
 руб.</td>
<td><?php echo $this->_tpl_vars['product']['sum']; ?>
 руб.</td></tr>
<?php endforeach; endif; unset($_from); ?>

<?php if (! empty ( $this->_tpl_vars['promoSale'] )): ?>
<tr>
<td colspan="4" align="right">Скидка по промо-коду:</td>
<td><?php echo $this->_tpl_vars['promoSale']; ?>
 руб.</td>
</tr>
<?php endif; ?>

<?php if (! empty ( $this->_tpl_vars['registerSale'] )): ?>
<tr>
<td colspan="4" align="right">Скидка авторизованному пользователю:</td>
<td><?php echo $this->_tpl_vars['registerSale']; ?>
 руб.</td>
</tr>
<?php endif; ?>

<tr>
<td colspan="4" align="right">Доставка:</td>
<td><?php echo $this->_tpl_vars['delivery']; ?>
</td>
</tr>

<tr>
<td colspan="4" align="right">Итого:</td>
<td><?php echo $this->_tpl_vars['order_total']; ?>
 руб.</td>
</tr>
<?php if (! empty ( $this->_tpl_vars['email'] )): ?>
	<tr>
	<td colspan="4" align="right">Со скидкой:</td>
	<td><?php echo $this->_tpl_vars['order_total']; ?>
 руб.</td>
	</tr>
<?php endif; ?>
</table>

<p>Адрес указанный при заказе: <?php echo $this->_tpl_vars['address']; ?>
</p>
<p>Комментарий пользователя: <?php echo $this->_tpl_vars['comment']; ?>
</p>

<p></p>
<p>Список заказов в панели управления: <?php echo $this->_tpl_vars['base_url']; ?>
/admin/index.php?mod=shop&action=orders</p>
<p>Детализация данного заказа в панели управления: <?php echo $this->_tpl_vars['base_url']; ?>
/admin/index.php?mod=shop&action=order_details&id=<?php echo $this->_tpl_vars['order_id']; ?>
</p>