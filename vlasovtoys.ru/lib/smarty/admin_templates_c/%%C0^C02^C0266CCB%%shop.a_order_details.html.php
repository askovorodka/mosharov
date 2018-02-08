<?php /* Smarty version 2.6.11, created on 2014-08-31 14:50:36
         compiled from /home/simpleuser/data/www/vlasovtoys.ru/modules/shop/admin/templates/shop.a_order_details.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'nl2br', '/home/simpleuser/data/www/vlasovtoys.ru/modules/shop/admin/templates/shop.a_order_details.html', 53, false),)), $this); ?>
<?php echo '
<SCRIPT language=JavaScript>
<!--
function confirm_delete(order_id,product_id)
{
if (confirm("Дейтсвительно удалить этот продукт из заказа?")) {
parent.location.href = "index.php?mod=shop&action=delete_from_order&order_id=" + order_id + "&product_id=" + product_id;
}
}
-->
</SCRIPT>

'; ?>

<form name=change_status method=post>
<input type="hidden" name="edit_order_status" value="1">
<input type=hidden name=id value=<?php echo $_GET['id']; ?>
>
<table width=100% class=content_table>
<tr><th style="text-align: left; border-right: none;">Заказ №<?php echo $_GET['id']; ?>
</th>
<th width=100 style="border-left: none; border-right: none; font-weight: normal;">cтатус заказа:</th>
<th width=150 style="border-left: none;"><select name=edit_status style="width: 140px;" class=field onChange="this.form.submit();">
<?php $_from = $this->_tpl_vars['status_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['status']):
?>
<option value=<?php echo $this->_tpl_vars['status']['value']; ?>
 <?php if ($this->_tpl_vars['status']['value'] == $this->_tpl_vars['order_info']['status']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['status']['name']; ?>
</option>
<?php endforeach; endif; unset($_from); ?>
</select>
</th></tr>
<table>
</form>

<form action="" method="post">
<input type="hidden" name="order_id" value="<?php echo $_GET['id']; ?>
">
<table width=100% class=content_table>
<tr valign="top">
<td width="50%" class="td1_left">
<table width=100% border="0" cellpadding="0" cellspacing="0">
<tr>
<td style="border-bottom: 1px solid white; height:35px;"><strong>Как зовут:</strong></td><td style="border-bottom: 1px solid white;"><strong><?php echo $this->_tpl_vars['order_info']['name']; ?>
</strong></td>
</tr>
<tr>
<td style="border-bottom: 1px solid white; height:35px;"><strong>Как связаться:</strong></td><td style="border-bottom: 1px solid white;"><?php echo $this->_tpl_vars['order_info']['mail']; ?>
</td>
</tr>
<tr>
<td style="border-bottom: 1px solid white; height:35px;"><strong>Куда доставить:</strong></td><td style="border-bottom: 1px solid white;"><?php echo $this->_tpl_vars['order_info']['address']; ?>
</td>
</tr>
</table>

</td>
<td width="50%" class="td1_right">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign=top style="font-size: 10px;"><strong>комментарии:</strong></td></tr>
    <tr>
    <td valign="top" style="padding-top: 5px;"><textarea name="comment_user" style="width: 96%; height: 60px;"><?php echo ((is_array($_tmp=$this->_tpl_vars['order_info']['comments'])) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
</textarea>
    <br><input type="submit" value="Сохранить комментарии &#8594;" style="font-size: 10px;" class="hand" name="submit_edit_user_order"></td>
  </tr>
</table>

</td></tr>
</table>
</form>
<br>
<?php if ($this->_tpl_vars['orders']): ?>
<form action="" method=post>
<input type=hidden name=id value=<?php echo $_GET['id']; ?>
>
	<table width=100% class=content_table>

	<tr><th>Заказанные товары</th><th width=100>Кол-во</th><th width=15%>Цена</th><th width=100>Действия</th></tr>
    <?php $this->assign('total_summ', ""); ?>
	<?php $_from = $this->_tpl_vars['orders']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['tree'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['tree']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['entry']):
        $this->_foreach['tree']['iteration']++;
?>

	<?php if ($this->_tpl_vars['col'] == 1): ?>
	<?php $this->assign('td', 'td1'); ?>
	<?php $this->assign('col', 0); ?>
	<?php else: ?>
	<?php $this->assign('td', 'td2'); ?>
	<?php $this->assign('col', 1); ?>
	<?php endif; ?>
	<tr onmouseover="flatlinkOver(this)" <?php if ($this->_foreach['tree']['iteration']%2 == 1): ?>onmouseout="flatlinkOut(this)"<?php else: ?>onmouseout="flatlinkOut1(this)"<?php endif; ?>>
			<td class=<?php echo $this->_tpl_vars['td']; ?>
_left>
            <?php if (intval ( $this->_tpl_vars['entry']['hit'] ) == 1): ?><img src="templates/img/hit.gif" width="21" height="21" border="0" alt="Хит продаж" align="right" style="margin: 2px 5px 0 10px;"><?php endif; ?>
				<small><font color=#666666><?php echo $this->_tpl_vars['entry']['cat_title']; ?>
</font></small><br>
				<a href="?mod=shop&action=edit_product&id=<?php echo $this->_tpl_vars['entry']['product_id']; ?>
"><?php echo $this->_tpl_vars['entry']['name']; ?>
</a>
			</td>
			<td class=<?php echo $this->_tpl_vars['td']; ?>
_middle align=center>
				<input type=text name=edit_number[<?php echo $this->_tpl_vars['entry']['product_id']; ?>
] value="<?php echo $this->_tpl_vars['entry']['product_count']; ?>
" class=field style="width:100%;">
			</td>
			<td class=<?php echo $this->_tpl_vars['td']; ?>
_middle align="right">
				<?php echo $this->_tpl_vars['entry']['total_summ']; ?>

					<?php echo $this->_tpl_vars['currency_site']['znak']; ?>

			</td>
			<td class=<?php echo $this->_tpl_vars['td']; ?>
_right align=center>
				<a href="javascript:confirm_delete('<?php echo $this->_tpl_vars['entry']['id']; ?>
','<?php echo $this->_tpl_vars['entry']['product_id']; ?>
');" class=img_link><img src=templates/img/ico_delete.gif border=0></a>
			</td>
		</tr>

	<?php endforeach; endif; unset($_from); ?>
	<tr>
		<td class=2_left></td>
		<td class=2_middle align=center>&nbsp;</td>
		<td class=2_middle align="right">Итого: <font color=red><b><?php echo $this->_tpl_vars['order_price']; ?>
 <?php echo $this->_tpl_vars['currency_site']['znak']; ?>
</b></font></td>
		<td class=2_right align=center><input type=submit name=submit_number_recount style="font-size: 9px; width: 100px; cursor: hand; cursor: pointer;" value="Пересчитать"></td>
	</tr>
</table>
</form>
<br>
<table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td width="50%"><?php if ($this->_tpl_vars['previous_order'] != ""): ?><link rel="next" href="?mod=shop&action=order_details&id=<?php echo $this->_tpl_vars['previous_order']; ?>
" id="NextLink" /><a href="?mod=shop&action=order_details&id=<?php echo $this->_tpl_vars['previous_order']; ?>
" style="font-size: 10px; text-decoration: underline;"><span>&#8592;</span> предыдущий заказ</a><?php endif; ?></td>
    <td align="right"><?php if ($this->_tpl_vars['next_order'] != ""): ?><link rel="prev" href="?mod=shop&action=order_details&id=<?php echo $this->_tpl_vars['next_order']; ?>
" id="PrevLink" /><a href="?mod=shop&action=order_details&id=<?php echo $this->_tpl_vars['next_order']; ?>
" style="font-size: 10px; text-decoration: underline;" rel="prev" id="PrevLink">следующий заказ <span>&#8594;</span></a><?php endif; ?></td>
  </tr>
</table><br>

<?php else: ?>
<center>В заказе нет позиций</center>
<?php endif; ?>