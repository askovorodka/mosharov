<?php /* Smarty version 2.6.11, created on 2016-03-30 09:43:50
         compiled from /home/a0031953/domains/s-q-c.ru/public_html//modules/modules/admin/templates/modules.a_install.html */ ?>
<center>

<table width=100% class=content_table>
<tr>
<td>
<?php if ($this->_tpl_vars['step'] == '2'): ?>
<br>
<b>�������� � ��������� ������:</b><br><br>
<center>
<table width=100% class=content_table>
	<tr><th width=70%>����</th><th width=30%>������</th></tr>
	<?php $_from = $this->_tpl_vars['checked_files']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['entry']):
?>
	<?php if ($this->_tpl_vars['col'] == 1): ?>
	<?php $this->assign('td', 'td1'); ?>
	<?php $this->assign('col', 0); ?>
	<?php else: ?>
	<?php $this->assign('td', 'td2'); ?>
	<?php $this->assign('col', 1); ?>
	<?php endif; ?>
			<td class=<?php echo $this->_tpl_vars['td']; ?>
_left><?php echo $this->_tpl_vars['entry']['file']; ?>
</td>
			<td align=center class=<?php echo $this->_tpl_vars['td']; ?>
_right><?php if ($this->_tpl_vars['entry']['checked'] == '1'): ?><font color=green>� �������</font><?php else: ?><font color=red>������</font><?php endif; ?></td>
		</tr>
	<?php endforeach; endif; unset($_from); ?>	
	</table>
</center>
<br><br>
<b>������� MySQL �������:</b> <?php if ($this->_tpl_vars['sql_install'] == '1'): ?><font color=green>�������</font><?php else: ?><font color=red>������</font><?php endif; ?>
<br><br><br>
<?php if ($this->_tpl_vars['status'] == 'failed'): ?>��������� �� ���������<?php if ($this->_tpl_vars['module_exists'] == '1'): ?>, ����� ������ ��� ����������<?php endif; ?>!<?php else: ?>��������� ��������� �������!<?php endif; ?>
<br><br>
<?php else: ?>
<center>
<br>
<form action="" method=get>
<input type=hidden name=mod value=modules>
<input type=hidden name=action value=install>
<input type=hidden name=step value=2>
��� ������: <input type=text name=module_name class=field style="width:250px;"><br><br><input type=submit value="���������� ������" class=button>
</form>
<br>
</center>
<?php endif; ?>
</td>
</tr>
</table>


</center>