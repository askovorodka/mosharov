<?php /* Smarty version 2.6.11, created on 2016-03-10 19:40:57
         compiled from /home/a0031953/domains/s-q-c.ru/public_html//modules/edit_conf/admin/templates/edit_conf.a_templates.html */ ?>
<b>Доступные шаблоны в системе:</b>
<br><br>

<?php if (! $this->_tpl_vars['templates_list']): ?>
Нет ни одного доступного шаблона
<?php else: ?>
<form action="" method=post>
<table width=40% cellspacing=1 cellpadding=3>
<?php $_from = $this->_tpl_vars['templates_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['template']):
?>
	<tr>
		<td width=40% align=left><input type=text name=temlpate_name[<?php echo $this->_tpl_vars['template']['id']; ?>
] class=field value="<?php echo $this->_tpl_vars['template']['name']; ?>
"></td>
		<td width=40% align=left><input type=text name=temlpate_file[<?php echo $this->_tpl_vars['template']['id']; ?>
] class=field value="<?php echo $this->_tpl_vars['template']['file']; ?>
"></td>
		<td>[<a href=index.php?mod=edit_conf&action=delete_template&id=<?php echo $this->_tpl_vars['template']['id']; ?>
>Удалить</a>]</td>
	</tr>
<?php endforeach; endif; unset($_from); ?>
</table>
<br><br>
<input type=submit name=submit_edit_templates value="Сохранить">
</form>
<?php endif; ?>

<br><br><br>

<form action="" method=post>
<table width=40% cellspacing=1 cellpadding=3>
	<tr>
		<td width=40%><input type=text name=template_name class=field></td>
		<td width=40%><input type=text name=template_file class=field></td>
		<td><input type=submit name=submit_add_template value="Добавить"></td>
	</tr>
</table>
</form>