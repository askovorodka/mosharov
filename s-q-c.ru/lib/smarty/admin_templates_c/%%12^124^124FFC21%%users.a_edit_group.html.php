<?php /* Smarty version 2.6.11, created on 2015-12-15 18:42:00
         compiled from /var/www/alex/data/www/scl.mosharov.com//modules/users/admin/templates/users.a_edit_group.html */ ?>
<?php if ($this->_tpl_vars['error_message']): ?><br><font color=red><?php echo $this->_tpl_vars['error_message']; ?>
</font><br><br><?php endif; ?>

<form action="" method=POST>
<?php if ($this->_tpl_vars['mode'] == 'edit'): ?>
<input type=hidden name=id value=<?php echo $this->_tpl_vars['id']; ?>
>
<?php endif; ?>
<table width=100% class=content_table>
	<tr>
		<th><?php if ($this->_tpl_vars['mode'] == 'edit'): ?>Редактировать группу<?php else: ?>Добавить группу<?php endif; ?></th>
	</tr>
</table>


<table width=100% class=content_table>
	<tr>
		<td width=15% class=td1_left>Название:</td>
		<td class=td1_right><input type=text name=edit_group_name style="width:400px" class=field value="<?php echo $this->_tpl_vars['group']['name']; ?>
"></td>
	</tr>
	<tr>
		<td width=15% class=td1_left>Привилегии:<br><small>числовое значение</small></td>
		<td class=td1_right><input type=text name=edit_group_priv style="width:400px" class=field value="<?php echo $this->_tpl_vars['group']['priv']; ?>
"></td>
	</tr>
</table>
<br>
<center><input type=submit <?php if ($this->_tpl_vars['mode'] == 'edit'): ?>name=submit_edit_group value="Сохранить изменения"<?php else: ?>name=submit_add_group value="Добавить группу"<?php endif; ?>></center>
</form>
<br><br>
<table class=content_table>
							<tr>
                            <th width="100">Привилегии</th>
								<th width="300">Название группы</th>
								
							</tr>
							<?php $_from = $this->_tpl_vars['priv_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['entry']):
?>
							<tr>
                            <td class=td1_right align="center"><?php echo $this->_tpl_vars['entry']['priv']; ?>
</td>
							<td class=td1_left><?php echo $this->_tpl_vars['entry']['name']; ?>
</td>
							</tr>
							<?php endforeach; endif; unset($_from); ?>
</table>