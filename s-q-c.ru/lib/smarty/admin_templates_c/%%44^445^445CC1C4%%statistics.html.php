<?php /* Smarty version 2.6.11, created on 2016-02-18 15:45:13
         compiled from /home/a0031953/domains/a0031953.xsph.ru/public_html//modules/shop/admin/templates/statistics.html */ ?>
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