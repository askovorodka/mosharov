<?php /* Smarty version 2.6.11, created on 2016-03-02 15:44:04
         compiled from /home/a0031953/domains/s-q-c.ru/public_html//modules/users/admin/templates/users.a_edit.html */ ?>
<?php if ($this->_tpl_vars['error_message']): ?><br><font color=red><?php echo $this->_tpl_vars['error_message']; ?>
</font><br><br><?php endif; ?>

<form action="" method=POST>
<?php if ($this->_tpl_vars['mode'] == 'edit'): ?>
<input type=hidden name=id value=<?php echo $this->_tpl_vars['id']; ?>
>
<input type=hidden name=old_password value=<?php echo $this->_tpl_vars['user']['password']; ?>
>
<input type=hidden name=old_login value=<?php echo $this->_tpl_vars['user']['login']; ?>
>
<?php endif; ?>
<table width=100% class=content_table>
	<tr>
		<th><?php if ($this->_tpl_vars['mode'] == 'edit'): ?>Редактировать пользователя<?php else: ?>Добавить пользователя<?php endif; ?></th>
	</tr>
</table>


<table width=100% class=content_table>
	<tr>
		<td width=15% class=td1_left>Ф.И.О:</td>
		<td class=td1_right><input type=text name=edit_user_name style="width:100%" class=field value="<?php echo $this->_tpl_vars['user']['name']; ?>
"></td>
	</tr>
	<?php if ($this->_tpl_vars['mode'] == 'edit'): ?>	
	<tr>
		<td width=15% class=td1_left>Логин:</td>
		<td class=td1_right><input type=text name=edit_user_login style="width:100%" class=field value="<?php echo $this->_tpl_vars['user']['login']; ?>
"></td>
	</tr>
	<tr>
		<td width=15% class=td1_left>Изменить пароль:</td>
		<td class=td1_right><input type=text name=edit_user_password style="width:100%" class=field></td>
	</tr>
	<?php else: ?>
	<tr>
		<td width=15% class=td1_left><font color=red><small>*</small></font>Логин:</td>
		<td class=td1_right><input type=text name=edit_user_login style="width:100%" class=field></td>
	</tr>
	<tr>
		<td width=15% class=td1_left><font color=red><small>*</small></font>Пароль:</td>
		<td class=td1_right><input type=text name=edit_user_password style="width:100%" class=field></td>
	</tr>
	<?php endif; ?>
	<tr>
		<td width=15% class=td1_left>E-mail:</td>
		<td class=td1_right><input type=text name=edit_user_mail style="width: 100%;" class=field value="<?php echo $this->_tpl_vars['user']['mail']; ?>
"></td>
	</tr>
	<tr>
		<td width=15% class=td1_left>Телефон:</td>
		<td class=td1_right><input type=text name=edit_user_tel style="width: 100%" class=field value="<?php echo $this->_tpl_vars['user']['tel']; ?>
"></td>
	</tr>
	
	<tr>
		<td width=15% class=td1_left>Адрес доставки:</td>
		<td class=td1_right><textarea name=edit_user_deliver style="width: 400px;; height: 60px;" class=field><?php echo $this->_tpl_vars['user']['deliver']; ?>
</textarea></td>
	</tr>
	<tr>
		<td width=15% class=td1_left>Права:</td>
		<td class=td1_right>
		<select name=edit_user_priv style="width: 400px;" class=field>
		<?php $_from = $this->_tpl_vars['priv_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['entry']):
?>
		<option value=<?php echo $this->_tpl_vars['entry']['id']; ?>
 <?php if ($this->_tpl_vars['entry']['id'] == $this->_tpl_vars['user']['group_id']): ?>selected=true<?php endif; ?>><?php echo $this->_tpl_vars['entry']['name']; ?>
</option>
		<?php endforeach; endif; unset($_from); ?>
		</select>
		</td>
	</tr>
	<tr>
		<td width=15% class=td1_left>Статус:</td>
		<td class=td1_right>
		<select name=edit_user_status style="width: 400px;" class=field>
		<option value=1 <?php if ($this->_tpl_vars['user']['status'] == '1'): ?>selected=true<?php endif; ?>>Активен</option>
		<option value=0 <?php if ($this->_tpl_vars['user']['status'] == '0'): ?>selected=true<?php endif; ?>>Заблокирован</option>
		</select>
		</td>
	</tr>
</table>
<br>
<center><input type=submit <?php if ($this->_tpl_vars['mode'] == 'edit'): ?>name=submit_edit_user value="Сохранить изменения"<?php else: ?>name=submit_add_user value="Добавить пользователя"<?php endif; ?>></center>
</form>