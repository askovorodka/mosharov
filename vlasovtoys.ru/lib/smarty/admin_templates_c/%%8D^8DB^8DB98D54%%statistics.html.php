<?php /* Smarty version 2.6.11, created on 2011-07-28 22:47:05
         compiled from /home/simpleuser/data/www/vlasovtoys.ru/modules/shop/admin/templates/statistics.html */ ?>
Статистика по магазину:
<br><br>

<table width=60% cellspacing=1 cellpadding=3>
<tr>
<td width=30%><b>В каталоге разделов:</b></td><td><?php echo $this->_tpl_vars['count_cat']; ?>
</td>
</tr>
<tr>
<td><b>Продуктов всего:</b></td><td><?php echo $this->_tpl_vars['count_products']; ?>
</td>
</tr>
<tr>
<td><b>Заказов:</b></td><td><?php echo $this->_tpl_vars['count_orders']; ?>
</td>
</tr>
<tr>
<td><b>На общую сумму:</b></td><td><font color=red><b><?php echo $this->_tpl_vars['total_price']; ?>
 <?php echo $this->_tpl_vars['currency']; ?>
</b></font></td>
</tr>
</table>