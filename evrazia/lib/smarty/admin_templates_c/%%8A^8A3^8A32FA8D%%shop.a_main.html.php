<?php /* Smarty version 2.6.11, created on 2012-02-06 13:10:26
         compiled from /home/alex/data/www/shop-toy.mosharov.com/modules/shop/admin/templates/shop.a_main.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'str_repeat', '/home/alex/data/www/shop-toy.mosharov.com/modules/shop/admin/templates/shop.a_main.html', 30, false),)), $this); ?>
<?php echo '
<DIV id=dhtmltooltip></DIV>
<SCRIPT language=JavaScript>
<!--
function confirm_delete(delete_id)
{
if (confirm("Дейтсвительно удалить этот раздел?")) {
parent.location.href = "index.php?mod=shop&action=delete_cat&id=" + delete_id;
}
}
-->
</SCRIPT>
<script language=JavaScript src=\'';  echo $this->_tpl_vars['base_url'];  echo '/javascript/tooltips.js\'></script>
'; ?>

	<table width=100% class=content_table>

	<tr><th>Название</th><th width=10%>Продуктов</th><th width=10%>Статус</th><th style="width: 120px;">Действия</th></tr>

	<?php $_from = $this->_tpl_vars['cat_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['tree'] = array('total' => count($_from), 'iteration' => 0);
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
				<?php echo smarty_function_str_repeat(array('str' => "&nbsp;",'num' => $this->_tpl_vars['entry']['param_level'],'mod' => '4'), $this);?>
<img src=templates/img/tree.gif><?php if ($this->_tpl_vars['entry']['param_right']-$this->_tpl_vars['entry']['param_left'] != 1): ?><a href=index.php?mod=shop&action=products_list&cat=<?php echo $this->_tpl_vars['entry']['id']; ?>
><?php echo $this->_tpl_vars['entry']['name']; ?>
</a><?php else:  echo $this->_tpl_vars['entry']['name'];  endif;  if ($this->_tpl_vars['entry']['properties'] > 0): ?> <small><font color="#666666">(Свойств: <?php echo $this->_tpl_vars['entry']['properties']; ?>
)</font></small><?php endif; ?>
			</td>
			<td class=<?php echo $this->_tpl_vars['td']; ?>
_middle align=center style="font-size: 11px;">
				<?php if ($this->_tpl_vars['entry']['products'] > 0): ?>[ <a href=index.php?mod=shop&action=products_list&cat=<?php echo $this->_tpl_vars['entry']['id']; ?>
><b><?php echo $this->_tpl_vars['entry']['products']; ?>
</b></a> ]<?php endif; ?>
			</td>
			<td align=center class=<?php echo $this->_tpl_vars['td']; ?>
_middle>
			<?php if ($this->_tpl_vars['entry']['param_level'] != 0): ?><a href="?mod=shop&action=change_status&id=<?php echo $this->_tpl_vars['entry']['id']; ?>
" title="Изменить статус"><img src=templates/img/status_<?php echo $this->_tpl_vars['entry']['status']; ?>
.gif border=0></a><?php endif; ?>
			</td>
			<?php if ($this->_tpl_vars['entry']['param_level'] == 0): ?>
            <td align=center class=<?php echo $this->_tpl_vars['td']; ?>
_right nowrap style="text-align: left;">
            	<a href=?mod=shop&action=add_cat&parent=<?php echo $this->_tpl_vars['entry']['id']; ?>
 class=img_link onmouseover="ddrivetip('Добавить подкатегорию')" onmouseout=hideddrivetip()><img src=templates/img/add_cat.gif border=0></a>&nbsp;
                <a href=?mod=shop&action=edit_cat&id=<?php echo $this->_tpl_vars['entry']['id']; ?>
 class=img_link onmouseover="ddrivetip('Редактировать категорию')" onmouseout=hideddrivetip()><img src=templates/img/ico_edit.gif border=0></a>&nbsp;
			</td>
            <?php else: ?>
            <td align=center class=<?php echo $this->_tpl_vars['td']; ?>
_right nowrap style="text-align: left;">
            <a href=?mod=shop&action=add_cat&parent=<?php echo $this->_tpl_vars['entry']['id']; ?>
 class=img_link onmouseover="ddrivetip('Добавить подкатегорию')" onmouseout=hideddrivetip()><img src=templates/img/add_cat.gif border=0></a>&nbsp;<a href=?mod=shop&action=edit_cat&id=<?php echo $this->_tpl_vars['entry']['id']; ?>
 class=img_link onmouseover="ddrivetip('Редактировать категорию')" onmouseout=hideddrivetip()><img src=templates/img/ico_edit.gif border=0></a>&nbsp;<a href="javascript:confirm_delete('<?php echo $this->_tpl_vars['entry']['id']; ?>
');" class=img_link onmouseover="ddrivetip('Удалить категорию')" onmouseout=hideddrivetip()><img src=templates/img/ico_delete.gif border=0></a>
			<a href=?mod=shop&action=cat_move_up&id=<?php echo $this->_tpl_vars['entry']['id']; ?>
 class=img_link onmouseover="ddrivetip('Переместить категорию вверх')" onmouseout=hideddrivetip()><img src=templates/img/ico_up.gif border=0></a><a href=?mod=shop&action=cat_move_down&id=<?php echo $this->_tpl_vars['entry']['id']; ?>
 class=img_link onmouseover="ddrivetip('Переместить категорию вниз')" onmouseout=hideddrivetip()><img src=templates/img/ico_down.gif border=0></a>
            <?php endif; ?>
		</tr>

	<?php endforeach; endif; unset($_from); ?>

	</table>
    <br>
<div class="add_but" onClick="location.href='?mod=shop&action=add_cat&parent=1'"><div><a href="?mod=shop&action=add_cat&parent=1">Добавить категорию каталога</a></div></div>