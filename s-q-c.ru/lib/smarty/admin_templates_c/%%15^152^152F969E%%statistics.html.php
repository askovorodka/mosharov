<?php /* Smarty version 2.6.11, created on 2015-12-16 00:45:43
         compiled from /var/www/alex/data/www/scl.mosharov.com//modules/shop/admin/templates/statistics.html */ ?>
���������� �� ��������:
<br><br>

<table width=60% cellspacing=1 cellpadding=3>
<tr>
<td width=30%><b>� �������� ��������:</b></td><td><?php echo $this->_tpl_vars['count_cat']; ?>
</td>
</tr>
<tr>
<td><b>��������� �����:</b></td><td><?php echo $this->_tpl_vars['count_products']; ?>
</td>
</tr>
<tr>
<td><b>�������:</b></td><td><?php echo $this->_tpl_vars['count_orders']; ?>
</td>
</tr>
<tr>
<td><b>�� ����� �����:</b></td><td><font color=red><b><?php echo $this->_tpl_vars['total_price']; ?>
 <?php echo $this->_tpl_vars['currency']; ?>
</b></font></td>
</tr>
</table>