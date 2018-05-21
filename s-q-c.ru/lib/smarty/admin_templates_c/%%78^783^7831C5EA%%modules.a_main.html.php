<?php /* Smarty version 2.6.11, created on 2018-04-10 20:54:20
         compiled from /home/a0031953/domains/s-q-c.ru/public_html//modules/modules/admin/templates/modules.a_main.html */ ?>
<DIV id=dhtmltooltip></DIV>
<?php echo '
<script language="JavaScript">
function confirm_delete(delete_id) {
	if (confirm("Дейтсвительно удалить этот модуль?")) {
		parent.location.href = "?mod=modules&action=delete&id=" + delete_id;
	}
}
</script>
<script language=JavaScript src=\'';  echo $this->_tpl_vars['base_url'];  echo '/javascript/tooltips.js\'></script>
'; ?>


<table width=100% class=content_table>
	<tr><th width=30%>Модуль</th><th>Имя</th><th width=20%>Тип</th><th width=10%>Статус</th><th width=10%>Действия</th></tr>
	<?php $_from = $this->_tpl_vars['modules']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['entry']):
?>
	<?php if ($this->_tpl_vars['entry']['section'] == 'admin_main' || $this->_tpl_vars['entry']['section'] == 'front_main'):  $this->assign('td', 'td0');  else:  $this->assign('td', 'td1');  endif; ?>
	<tr>
			<td class=<?php echo $this->_tpl_vars['td']; ?>
_left><?php echo $this->_tpl_vars['entry']['name']; ?>
</td>
			<td class=<?php echo $this->_tpl_vars['td']; ?>
_middle><b><?php echo $this->_tpl_vars['entry']['title']; ?>
</b></td>
			<td class=<?php echo $this->_tpl_vars['td']; ?>
_middle><?php echo $this->_tpl_vars['entry']['section']; ?>
</td>
			<td align=center class=<?php echo $this->_tpl_vars['td']; ?>
_middle><a href="?mod=modules&action=change_mod_status&id=<?php echo $this->_tpl_vars['entry']['id']; ?>
" title="Изменить статус"><img src=templates/img/status_<?php echo $this->_tpl_vars['entry']['status']; ?>
.gif border=0></a></td>
			<td align=center class=<?php echo $this->_tpl_vars['td']; ?>
_right><?php if ($this->_tpl_vars['entry']['section'] != 'admin_main' && $this->_tpl_vars['entry']['section'] != 'front_main'): ?><a href="javascript:confirm_delete('<?php echo $this->_tpl_vars['entry']['id']; ?>
');" class=img_link onmouseover="ddrivetip('Удалить модуль')" onmouseout=hideddrivetip()><img src=templates/img/ico_delete.gif border=0></a><?php else: ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php endif; ?><a href=?mod=modules&action=edit&name=<?php echo $this->_tpl_vars['entry']['name']; ?>
 class=img_link onmouseover="ddrivetip('Редактировать модуль')" onmouseout=hideddrivetip()><img src=templates/img/ico_edit.gif border=0></a></td>
		</tr>
	<?php endforeach; endif; unset($_from); ?>	
	</table>