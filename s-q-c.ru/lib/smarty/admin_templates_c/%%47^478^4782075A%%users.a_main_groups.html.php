<?php /* Smarty version 2.6.11, created on 2016-03-02 15:45:55
         compiled from /home/a0031953/domains/s-q-c.ru/public_html//modules/users/admin/templates/users.a_main_groups.html */ ?>
<DIV id=dhtmltooltip></DIV>
<?php echo '
<SCRIPT LANGUAGE="JavaScript"><!--
function confirm_delete(delete_id)
{
if (confirm("Дейтсвительно удалить эту группу?")) {
parent.location.href = "?mod=users&action=delete_group&id=" + delete_id;
}
}
--></script>
<script language=JavaScript src=\'';  echo $this->_tpl_vars['base_url'];  echo '/javascript/tooltips.js\'></script>
'; ?>

<?php if ($this->_tpl_vars['error_message']): ?><br><font color=red><?php echo $this->_tpl_vars['error_message']; ?>
</font><br><br><?php endif; ?>
<table width=100% class=content_table>
	<tr><th>Название группы</th><th width=15%>Пользователей</th><th width=15%>Привилегии</th><th width=10% align=center>Действия</th></tr>
	<?php $_from = $this->_tpl_vars['priv_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['entry']):
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
_left><a href="?mod=users&action=edit_group&id=<?php echo $this->_tpl_vars['entry']['id']; ?>
"><strong><?php echo $this->_tpl_vars['entry']['name']; ?>
</strong></a></td>
			<td class=<?php echo $this->_tpl_vars['td']; ?>
_middle align="center"><?php echo $this->_tpl_vars['entry']['users']; ?>
</td>
			<td class=<?php echo $this->_tpl_vars['td']; ?>
_middle align="center"><?php echo $this->_tpl_vars['entry']['priv']; ?>
</td>
			<td align=center class=<?php echo $this->_tpl_vars['td']; ?>
_right><a href="javascript:confirm_delete('<?php echo $this->_tpl_vars['entry']['id']; ?>
');" class=img_link onmouseover="ddrivetip('Удалить группу')" onmouseout=hideddrivetip()><img src=templates/img/ico_delete.gif border=0></a>
			<a href=?mod=users&action=edit_group&id=<?php echo $this->_tpl_vars['entry']['id']; ?>
 class=img_link onmouseover="ddrivetip('Редактировать данные группы')" onmouseout=hideddrivetip()><img src=templates/img/ico_edit.gif border=0></a></td>
		</tr>
	<?php endforeach; endif; unset($_from); ?>	
	</table>
    
    <br><br>
<div class="add_but" style="float: left;" onClick="location.href='index.php?mod=users&action=add_group'"><div><a href="index.php?mod=users&action=add_group">добавить группу</a></div></div>