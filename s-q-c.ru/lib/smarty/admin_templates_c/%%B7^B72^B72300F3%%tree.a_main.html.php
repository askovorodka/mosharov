<?php /* Smarty version 2.6.11, created on 2015-11-29 20:05:32
         compiled from /var/www/sqc//modules/tree/admin/templates/tree.a_main.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'str_repeat', '/var/www/sqc//modules/tree/admin/templates/tree.a_main.html', 32, false),)), $this); ?>
<DIV id=dhtmltooltip></DIV>
<?php echo '
<SCRIPT language=JavaScript>
<!--
function confirm_delete(delete_id)
{
if (confirm("Дейтсвительно удалить этот узел?")) {
parent.location.href = "index.php?mod=tree&action=delete&id=" + delete_id;
}
}
-->
</SCRIPT>
<script language=JavaScript src=\'';  echo $this->_tpl_vars['base_url'];  echo '/javascript/tooltips.js\'></script>
'; ?>

	<table width=100% class="content_table">

	<tr><th>Название</th><th width=10%>Документов</th><th width=10%>Модуль</th><th width=6%>Меню</th><th width=6%>Статус</th><th  width="6%" nowrap>Действия</th></tr>

	<?php $_from = $this->_tpl_vars['content']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['tree'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['tree']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['entry']):
        $this->_foreach['tree']['iteration']++;
?>
	<tr onmouseover="flatlinkOver(this)" <?php if ($this->_foreach['tree']['iteration']%2 == 1): ?>onmouseout="flatlinkOut(this)"<?php else: ?>onmouseout="flatlinkOut1(this)"<?php endif; ?>>
	<?php if ($this->_tpl_vars['col'] == 1): ?>
	<?php $this->assign('td', 'td1'); ?>
	<?php $this->assign('col', 0); ?>
	<?php else: ?>
	<?php $this->assign('td', 'td2'); ?>
	<?php $this->assign('col', 1); ?>
	<?php endif; ?>

			<td class=<?php echo $this->_tpl_vars['td']; ?>
_left>
				<table cellpadding="0" cellspacing="0" border="0" width="100%">
					<tr>
						<td width="1%" valign="top" align="right"><?php echo smarty_function_str_repeat(array('str' => "&nbsp;",'num' => $this->_tpl_vars['entry']['param_level'],'mod' => '4'), $this);?>
<img src=templates/img/tree.gif></td>
						<td style="height: 25px;">
							<?php if ($this->_tpl_vars['entry']['param_level'] == '0'): ?>
								<?php echo $this->_tpl_vars['base_url']; ?>

							<?php else: ?>
								<?php echo $this->_tpl_vars['entry']['name']; ?>

								<div style="margin-top: 3px"><a href="<?php echo $this->_tpl_vars['base_url']; ?>
/<?php echo $this->_tpl_vars['entry']['full_url']; ?>
" target="_blank" class="gray" id="mini"><?php echo $this->_tpl_vars['base_url']; ?>
/<?php echo $this->_tpl_vars['entry']['full_url']; ?>
</a></div>
							<?php endif; ?>
						</td>
					</tr>
				</table>
				
			</td>
			<td align=center class=<?php echo $this->_tpl_vars['td']; ?>
_middle>
			<?php if ($this->_tpl_vars['entry']['module'] == 'page'): ?><small>[ <a href="?mod=tree&action=documents_list&parent=<?php echo $this->_tpl_vars['entry']['id']; ?>
"><strong><?php echo $this->_tpl_vars['entry']['documents']; ?>
</strong></a> ]</small><?php endif; ?>
			</td>
			<td align=center class=<?php echo $this->_tpl_vars['td']; ?>
_middle>
			<?php echo $this->_tpl_vars['entry']['module']; ?>

			</td>
			<td align=center class=<?php echo $this->_tpl_vars['td']; ?>
_middle>
			<?php if ($this->_tpl_vars['entry']['param_level'] != '0'): ?><a href="?mod=tree&action=change_in_menu&id=<?php echo $this->_tpl_vars['entry']['id']; ?>
" title="Изменить статус"><img src=templates/img/status_<?php echo $this->_tpl_vars['entry']['in_menu']; ?>
.gif border=0></a><?php endif; ?>
			</td>
						<td align=center class=<?php echo $this->_tpl_vars['td']; ?>
_middle>
			<?php if ($this->_tpl_vars['entry']['param_level'] != '0'): ?><a href="?mod=tree&action=change_status&id=<?php echo $this->_tpl_vars['entry']['id']; ?>
"><img src=templates/img/status_<?php echo $this->_tpl_vars['entry']['status']; ?>
.gif border=0></a><?php endif; ?>
			</td>
			<td class=<?php echo $this->_tpl_vars['td']; ?>
_right nowrap>
			<?php if ($this->_foreach['tree']['iteration'] == 1): ?>
			<div style="text-align: left;"><a href=?mod=tree&action=add&parent=<?php echo $this->_tpl_vars['entry']['id']; ?>
 class=img_link onmouseover="ddrivetip('Добавить подузел')" onmouseout=hideddrivetip()><img src=templates/img/add_cat.gif border=0 style="margin-left: 2px;"></a></div>
			<?php else: ?>
            	<?php if ($this->_tpl_vars['entry']['module'] == 'page'): ?><a href=?mod=tree&action=add&parent=<?php echo $this->_tpl_vars['entry']['id']; ?>
 class=img_link onmouseover="ddrivetip('Добавить подузел')" onmouseout=hideddrivetip()><img src=templates/img/add_cat.gif border=0></a><?php else: ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php endif; ?>
            	<a href=?mod=tree&action=edit&id=<?php echo $this->_tpl_vars['entry']['id']; ?>
 class=img_link onmouseover="ddrivetip('Редактировать узел')" onmouseout=hideddrivetip()><img src=templates/img/ico_edit.gif border=0></a>&nbsp;
				<a href=?mod=tree&action=edit_elements&id=<?php echo $this->_tpl_vars['entry']['id']; ?>
 onmouseover="ddrivetip('Редактировать шаблон узла')" onmouseout=hideddrivetip()><img src=templates/img/elements.gif border=0></a>&nbsp;
                <a href="javascript:confirm_delete('<?php echo $this->_tpl_vars['entry']['id']; ?>
');" class=img_link onmouseover="ddrivetip('Удалить узел')" onmouseout=hideddrivetip()><img src=templates/img/ico_delete.gif border=0></a>
				<a href=?mod=tree&action=move_up&id=<?php echo $this->_tpl_vars['entry']['id']; ?>
 class=img_link onmouseover="ddrivetip('Переместить узел вверх')" onmouseout=hideddrivetip()><img src=templates/img/ico_up.gif border=0></a><a href=?mod=tree&action=move_down&id=<?php echo $this->_tpl_vars['entry']['id']; ?>
 class=img_link onmouseover="ddrivetip('Переместить узел вниз')" onmouseout=hideddrivetip()><img src=templates/img/ico_down.gif border=0></a>
			<?php endif; ?>
			</td>
		</tr>

	<?php endforeach; endif; unset($_from); ?>

	</table>
    <br>
<div class="add_but" onClick="location.href='index.php?mod=tree&action=add'"><div><a href="index.php?mod=tree&action=add">добавить раздел</a></div></div>