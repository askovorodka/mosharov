<?php /* Smarty version 2.6.11, created on 2016-03-30 09:45:58
         compiled from /home/a0031953/domains/s-q-c.ru/public_html//modules/modules/admin/templates/modules.a_edit.html */ ?>

<form action="" method=post>
<input type=hidden name=edit_module_name value=<?php echo $this->_tpl_vars['module']['name']; ?>
>
<table width=100% class=content_table>
<tr><th colspan="2">Редактировать модуль</th></tr>
<tr>
<td width=20% class="td1_left"><b>Имя модуля:</b> </td><td class="td1_right"><?php echo $this->_tpl_vars['module']['name']; ?>
</td>
</tr>
<tr>
<td class="td1_left"><b>Статус:</b> </td><td class="td1_right"><?php if ($this->_tpl_vars['module']['section'] != 'admin_main' && $this->_tpl_vars['module']['section'] != 'front_main'): ?><select name=edit_module_status class=field style="width:50%;"><option <?php if ($this->_tpl_vars['module']['status'] == 0): ?>selected=true<?php endif; ?> value=0>Отключён</option><option <?php if ($this->_tpl_vars['module']['status'] == 1): ?>selected=true<?php endif; ?> value=1>Активен</option></select><?php else:  if ($this->_tpl_vars['module']['status'] == 0): ?>Отключён<?php else: ?>Активен<?php endif;  endif; ?></td>
</tr>
<tr>
<td class="td1_left"><b>Название модуля:</b> </td><td class="td1_right"><input type=text name=edit_module_title class=field value="<?php echo $this->_tpl_vars['module']['title']; ?>
" style="width:50%"></td>
</tr>
<tr>
<td class="td1_left"><b>Права доступа:</b> </td><td class="td1_right">
		<select name=edit_module_priv style="width:50%" class=field>
		<?php $_from = $this->_tpl_vars['priv_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['entry']):
?>
		<option value=<?php echo $this->_tpl_vars['entry']['value']; ?>
 <?php if ($this->_tpl_vars['entry']['value'] == $this->_tpl_vars['module']['priv']): ?>selected=true<?php endif; ?>><?php echo $this->_tpl_vars['entry']['name']; ?>
</option>
		<?php endforeach; endif; unset($_from); ?>
		</select>
</td>
</tr>
<?php if ($this->_tpl_vars['module']['section'] == 'front_additional' || $this->_tpl_vars['module']['section'] == 'front_support'): ?>
<tr>
<td class="td1_left"><b>Всегда активен:</b> </td><td class="td1_right">
		<select name=edit_module_default style="width:50%" class=field>
		<option value=0 <?php if ($this->_tpl_vars['module']['default_load'] == '0'): ?>selected=true<?php endif; ?>>Нет</option>
		<option value=1 <?php if ($this->_tpl_vars['module']['default_load'] == '1'): ?>selected=true<?php endif; ?>>Да</option>
		</select>
</td>
</tr>
<?php endif; ?>
<tr>
<td class="td1_left"><b>Версия модуля:</b> </td><td class="td1_right"><?php echo $this->_tpl_vars['version']; ?>
</td>
</tr>
</table>

<table width=100% class=content_table>
	<tr><th width=70%>Файл модуля</th><th width=30%>Статус</th></tr>
	<?php $_from = $this->_tpl_vars['checked_files']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['tree'] = array('total' => count($_from), 'iteration' => 0);
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
_left><?php echo $this->_tpl_vars['entry']['file']; ?>
</td>
			<td align=center class=<?php echo $this->_tpl_vars['td']; ?>
_right><?php if ($this->_tpl_vars['entry']['checked'] == '1'): ?><font color=green>В порядке</font><?php else: ?><font color=red>Ошибка</font><?php endif; ?></td>
		</tr>
	<?php endforeach; endif; unset($_from); ?>	
	</table>
<br>
<center><input type=submit name=submit_edit_module value="Сохранить изменения" class=button>
</center>
</form>


</center>