<?php /* Smarty version 2.6.11, created on 2014-08-03 11:43:18
         compiled from /home/alex/data/www/vlasov.mosharov.com/modules/shop/front/templates/admin_order_notice.txt */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', '/home/alex/data/www/vlasov.mosharov.com/modules/shop/front/templates/admin_order_notice.txt', 3, false),array('modifier', 'format_price', '/home/alex/data/www/vlasov.mosharov.com/modules/shop/front/templates/admin_order_notice.txt', 7, false),)), $this); ?>
<p>Вас приветствует почтовый робот сайта <?php echo $this->_tpl_vars['site_url']; ?>
</p>

<p>В Вашем онлайн магазине появился новый заказ от <?php echo ((is_array($_tmp=$this->_tpl_vars['date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d.%m.%Y в %T") : smarty_modifier_date_format($_tmp, "%d.%m.%Y в %T")); ?>
</p>

<p>Номер заказа: <?php echo $this->_tpl_vars['order_id']; ?>
</p>

<p>Количество заказанных товаров: <?php echo $this->_tpl_vars['number']; ?>
, на сумму <?php echo ((is_array($_tmp=$this->_tpl_vars['total_sum'])) ? $this->_run_mod_handler('format_price', true, $_tmp) : smarty_modifier_format_price($_tmp)); ?>
 <?php echo $this->_tpl_vars['currency']; ?>
, 
подробности смотрите в администраторской панели, раздел "Управление заказами".</p>

<p><b>Детализация заказа:</b></p>

<table>
<tr><th>№</th>
<th>Наименование</th>
<th>Количество</th>
<th>Стоимость за единицу</th>
<th>Сумма</th></tr>
<?php $_from = $this->_tpl_vars['products']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['for1'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['for1']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['product']):
        $this->_foreach['for1']['iteration']++;
?>
<tr>
<td><?php echo $this->_foreach['for1']['iteration']; ?>
</td>

<td><?php echo $this->_tpl_vars['product']['details']['name']; ?>
</td>
<td><?php echo $this->_tpl_vars['product']['count']; ?>
</td>
<td><?php echo ((is_array($_tmp=$this->_tpl_vars['product']['details']['price'])) ? $this->_run_mod_handler('format_price', true, $_tmp) : smarty_modifier_format_price($_tmp)); ?>
 руб.</td>
<td><?php echo ((is_array($_tmp=$this->_tpl_vars['product']['sum'])) ? $this->_run_mod_handler('format_price', true, $_tmp) : smarty_modifier_format_price($_tmp)); ?>
 руб.</td>
</tr>
<?php endforeach; endif; unset($_from); ?>

<tr>
<td colspan="4" align="right">Итого:</td>
<td><?php echo ((is_array($_tmp=$this->_tpl_vars['total_sum'])) ? $this->_run_mod_handler('format_price', true, $_tmp) : smarty_modifier_format_price($_tmp)); ?>
 руб.</td>
</tr>

</table>

<table>
<tr><td colspan="2">Информация о пользователе:</td></tr>

<tr><td>Как зовут:</td><td><?php echo $this->_tpl_vars['name']; ?>
</td></tr>

<tr><td>Как связаться:</td><td><?php echo $this->_tpl_vars['user']['mail']; ?>
</td></tr>

<tr><td>Куда доставить:</td><td><?php echo $this->_tpl_vars['user']['address']; ?>
</td></tr>

</table>

<p>До скорых встреч!</p>