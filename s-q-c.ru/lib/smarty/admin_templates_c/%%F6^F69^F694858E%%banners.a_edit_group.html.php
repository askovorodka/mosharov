<?php /* Smarty version 2.6.11, created on 2016-03-15 11:04:37
         compiled from /home/a0031953/domains/s-q-c.ru/public_html//modules/banners/admin/templates/banners.a_edit_group.html */ ?>
<?php echo '
<script language="JavaScript">
function check_form() {
	if ((document.edit_group.name.value==\'\')) {
		alert("Заполните, пожалуйста, обязательные поля");
		return false;
	}
	else {
		return true;
	}
}
</script>
'; ?>

<?php if ($this->_tpl_vars['error_message']): ?><center><font color=red><?php echo $this->_tpl_vars['error_message']; ?>
</font></center><br><?php endif; ?>
<form action="" name=edit_group method=POST onSubmit="return check_form();">
<?php if ($this->_tpl_vars['mode'] == 'edit'): ?>
<input type=hidden name=id value=<?php echo $this->_tpl_vars['group']['id']; ?>
>
<?php endif; ?>

<table width=100% class="content_table">
<tr><th><?php if ($this->_tpl_vars['mode'] == 'edit'): ?>Редактируем группу<?php else: ?>Добавить группу<?php endif; ?></th></tr>
</table>

<table width=100% class="content_table">
<tr>
<td width=20% class=td1_left>Название: <font color=red>*</font></td><td class=td1_right><input type=text name=name style="width:100%" value="<?php echo $this->_tpl_vars['group']['name']; ?>
" class=field></td>
</tr>
</table>
<br>
<center><input type=submit <?php if ($this->_tpl_vars['mode'] == 'edit'): ?>name=submit_edit_group value="Сохранить изменения"<?php else: ?>name=submit_add_group value="Добавить группу"<?php endif; ?>></center>

</form>