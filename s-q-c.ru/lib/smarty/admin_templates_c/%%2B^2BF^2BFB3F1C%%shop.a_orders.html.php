<?php /* Smarty version 2.6.11, created on 2018-04-07 17:22:48
         compiled from /home/a0031953/domains/s-q-c.ru/public_html//modules/shop/admin/templates/shop.a_orders.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', '/home/a0031953/domains/s-q-c.ru/public_html//modules/shop/admin/templates/shop.a_orders.html', 41, false),array('modifier', 'format_number', '/home/a0031953/domains/s-q-c.ru/public_html//modules/shop/admin/templates/shop.a_orders.html', 47, false),)), $this); ?>
<?php echo '
<DIV id=dhtmltooltip></DIV>
<SCRIPT language=JavaScript>
<!--
function confirm_delete(delete_id)
{
if (confirm("Дейтсвительно удалить этот заказ?")) {
parent.location.href = "index.php?mod=shop&action=delete_order&id=" + delete_id;
}
}
-->
</SCRIPT>
<script language=JavaScript src=\'';  echo $this->_tpl_vars['base_url'];  echo '/javascript/tooltips.js\'></script>
'; ?>


<?php if ($this->_tpl_vars['orders_list']): ?>
	<table width=100% class=content_table>

	<tr>
	<th width=5%>ID</th>
	<th width=10%>Дата <a href="?mod=shop&action=orders&page=<?php echo $this->_tpl_vars['current_page']; ?>
&sort=insert_date&order=asc" class=img_link><img src=templates/img/cat_up.gif border=0></a>&nbsp;<a href="?mod=shop&action=orders&page=<?php echo $this->_tpl_vars['current_page']; ?>
&sort=insert_date&order=desc" class=img_link><img src=templates/img/cat_down.gif border=0></a></th>
	<th>Пользователь </th>
	<th width=15%>Сумма <a href="?mod=shop&action=orders&page=<?php echo $this->_tpl_vars['current_page']; ?>
&sort=total_price&order=asc" class=img_link><img src=templates/img/cat_up.gif border=0></a>&nbsp;<a href="?mod=shop&action=orders&page=<?php echo $this->_tpl_vars['current_page']; ?>
&sort=total_price&order=desc" class=img_link><img src=templates/img/cat_down.gif border=0></a></th>
	<th width=15%>Статус <a href="?mod=shop&action=orders&page=<?php echo $this->_tpl_vars['current_page']; ?>
&sort=status&order=asc" class=img_link><img src=templates/img/cat_up.gif border=0></a>&nbsp;<a href="?mod=shop&action=orders&page=<?php echo $this->_tpl_vars['current_page']; ?>
&sort=status&order=desc" class=img_link><img src=templates/img/cat_down.gif border=0></a></th>
	<th width=15%>Действия</th></tr>

	<?php $_from = $this->_tpl_vars['orders_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['tree'] = array('total' => count($_from), 'iteration' => 0);
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
_left align=center>
				<?php echo $this->_tpl_vars['entry']['id']; ?>

			</td>
			<td class=<?php echo $this->_tpl_vars['td']; ?>
_middle align=center>
				<?php echo ((is_array($_tmp=$this->_tpl_vars['entry']['insert_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d.%m.%Y") : smarty_modifier_date_format($_tmp, "%d.%m.%Y")); ?>

			</td>
			<td class=<?php echo $this->_tpl_vars['td']; ?>
_middle>
			<a href="?mod=shop&action=order_details&id=<?php echo $this->_tpl_vars['entry']['id']; ?>
"><strong><?php echo $this->_tpl_vars['entry']['user_name']; ?>
</strong></a>
			</td>
			<td class=<?php echo $this->_tpl_vars['td']; ?>
_middle align="right">
				<?php echo ((is_array($_tmp=$this->_tpl_vars['entry']['total_price'])) ? $this->_run_mod_handler('format_number', true, $_tmp) : smarty_modifier_format_number($_tmp)); ?>
 <?php echo $this->_tpl_vars['currency_site']['znak']; ?>

			</td>
			<td class=<?php echo $this->_tpl_vars['td']; ?>
_middle align="center">
				<font style="color: <?php if ($this->_tpl_vars['entry']['status_number'] == '0'): ?>red<?php endif;  if ($this->_tpl_vars['entry']['status_number'] == '1'): ?>#f7c21e<?php endif;  if ($this->_tpl_vars['entry']['status_number'] > 1): ?>#3fda2a<?php endif; ?>"><strong><?php echo $this->_tpl_vars['entry']['status']; ?>
</strong></font>
			</td>
			<td align=center class=<?php echo $this->_tpl_vars['td']; ?>
_right>
				<a href="javascript:confirm_delete('<?php echo $this->_tpl_vars['entry']['id']; ?>
');" class=img_link onmouseover="ddrivetip('Удалить заказ')" onmouseout=hideddrivetip()><img src=templates/img/ico_delete.gif border=0></a>
				<a href=?mod=shop&action=order_details&id=<?php echo $this->_tpl_vars['entry']['id']; ?>
 class=img_link onmouseover="ddrivetip('Редактировать заказ')" onmouseout=hideddrivetip()><img src=templates/img/ico_edit.gif border=0></a>
			</td>
		</tr>

	<?php endforeach; endif; unset($_from); ?>

	</table>
<?php if ($this->_tpl_vars['total_pages'] > 1): ?>
<br><br>
<div class="listing">
<li class="str">
<ul>
<li class="center"><a href="?mod=shop&action=orders&user=<?php echo $this->_tpl_vars['user']; ?>
&sort=<?php echo $this->_tpl_vars['sort']; ?>
&order=<?php echo $this->_tpl_vars['order']; ?>
&page=1">&laquo;</a>
<?php unset($this->_sections['p']);
$this->_sections['p']['name'] = 'p';
$this->_sections['p']['loop'] = is_array($_loop=$this->_tpl_vars['pages']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['p']['show'] = true;
$this->_sections['p']['max'] = $this->_sections['p']['loop'];
$this->_sections['p']['step'] = 1;
$this->_sections['p']['start'] = $this->_sections['p']['step'] > 0 ? 0 : $this->_sections['p']['loop']-1;
if ($this->_sections['p']['show']) {
    $this->_sections['p']['total'] = $this->_sections['p']['loop'];
    if ($this->_sections['p']['total'] == 0)
        $this->_sections['p']['show'] = false;
} else
    $this->_sections['p']['total'] = 0;
if ($this->_sections['p']['show']):

            for ($this->_sections['p']['index'] = $this->_sections['p']['start'], $this->_sections['p']['iteration'] = 1;
                 $this->_sections['p']['iteration'] <= $this->_sections['p']['total'];
                 $this->_sections['p']['index'] += $this->_sections['p']['step'], $this->_sections['p']['iteration']++):
$this->_sections['p']['rownum'] = $this->_sections['p']['iteration'];
$this->_sections['p']['index_prev'] = $this->_sections['p']['index'] - $this->_sections['p']['step'];
$this->_sections['p']['index_next'] = $this->_sections['p']['index'] + $this->_sections['p']['step'];
$this->_sections['p']['first']      = ($this->_sections['p']['iteration'] == 1);
$this->_sections['p']['last']       = ($this->_sections['p']['iteration'] == $this->_sections['p']['total']);
?>
  <?php if ($this->_tpl_vars['pages'][$this->_sections['p']['index']] == $this->_tpl_vars['current_page']): ?>
  <a class="active" href="?mod=shop&action=orders&user=<?php echo $this->_tpl_vars['user']; ?>
&sort=<?php echo $this->_tpl_vars['sort']; ?>
&order=<?php echo $this->_tpl_vars['order']; ?>
&page=<?php echo $this->_tpl_vars['pages'][$this->_sections['p']['index']]; ?>
"><?php echo $this->_tpl_vars['pages'][$this->_sections['p']['index']]; ?>
</a>
  <?php else: ?>
  <a href="?mod=shop&action=orders&user=<?php echo $this->_tpl_vars['user']; ?>
&sort=<?php echo $this->_tpl_vars['sort']; ?>
&order=<?php echo $this->_tpl_vars['order']; ?>
&page=<?php echo $this->_tpl_vars['pages'][$this->_sections['p']['index']]; ?>
"><?php echo $this->_tpl_vars['pages'][$this->_sections['p']['index']]; ?>
</a>
  <?php endif;  endfor; endif; ?>
<a href="?mod=shop&action=orders&user=<?php echo $this->_tpl_vars['user']; ?>
&sort=<?php echo $this->_tpl_vars['sort']; ?>
&order=<?php echo $this->_tpl_vars['order']; ?>
&page=<?php echo $this->_tpl_vars['total_pages']; ?>
">&raquo;</a></li>
</ul></li></div><?php endif; ?>	
<?php else: ?>
<center>В магазине нет заказов</center>
<?php endif; ?>