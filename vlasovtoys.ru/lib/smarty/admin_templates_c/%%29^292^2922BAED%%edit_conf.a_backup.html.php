<?php /* Smarty version 2.6.11, created on 2011-07-28 21:23:34
         compiled from /home/simpleuser/data/www/vlasovtoys.ru/modules/edit_conf/admin/templates/edit_conf.a_backup.html */ ?>
<form action="" method=post>
<table width=60% align=center class=content_table>
	<th colspan="2">
		��������� ����������� ���� ������
	</th>
	
	<tr>
		<td class=td1_left width=25%>
			���� ������:
		</td>
		
		<td class=td1_right>
			<b><?php echo $this->_tpl_vars['db_name']; ?>
</b>
		</td>
	</tr>
	
	<tr>
		<td class=td1_left>
			������ ������:
		</td>
		
		<td class=td1_right>
			<input type=tex name=filter class=field style="width:100%">
		</td>
	</tr>
	
	<tr>
		<td class=td1_left>
			������ ������:
		</td>
		
		<td class=td1_right>
			<select name=pack class=field style="width:100%">
				<option value="0">��� ������</option>
				<option value="1">Gzip</option>
				<option value="2">Bzip2</option>
			</select>
		</td>
	</tr>
	
	<tr>
		<td class=td1_left>
			������� ������:
		</td>
		
		<td class=td1_right>
			<select name=pack_rate class=field style="width:100%">
				<option value="0">��� ������</option>
				<option value="1">9 (������������)</option>
				<option value="1">8</option>
				<option value="1">7</option>
				<option value="1">6</option>
				<option value="1">5</option>
				<option value="1">4</option>
				<option value="1">3</option>
				<option value="1">2</option>
				<option value="1">1 (�����������)</option>
			</select>
		</td>
	</tr>
	
	<tr>
		<td cplspan=2>
			&nbsp;
		</td>
	</tr>
	
	<tr>
		<td colspan=2 align=center>
			<input type=submit name=submit_backup value="������� ��������� �����">
		</td>
	</tr>
	
</table>
</form>

<?php if ($this->_tpl_vars['is_dev'] && $this->_tpl_vars['files_list']): ?>
<br><br>



<form action="" method=post>
<table width=60% align=center class=content_table>
	<th colspan="2">
		�������������� ���� ������
	</th>
	
	<tr>
		<td class=td1_left width=20%>
			����:
		</td>
		
		<td class=td1_right>
			<select name=file class=field style="width:100%">
				<?php $_from = $this->_tpl_vars['files_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['entry']):
?>
					<option value="<?php echo $this->_tpl_vars['entry']; ?>
"><?php echo $this->_tpl_vars['entry']; ?>
</option>
				<?php endforeach; endif; unset($_from); ?>
			</select>
		</td>
	</tr>
	
	<tr>
		<td cplspan=2>
			&nbsp;
		</td>
	</tr>
	
	<tr>
		<td colspan=2 align=center>
			<input type=submit name=submit_restore value="������������ ����">
		</td>
	</tr>
	
</table>
</form>

<?php endif; ?>

<br><br>
<?php if ($this->_tpl_vars['action'] == 'backup'): ?>

���� �����: <?php echo $this->_tpl_vars['file_name']; ?>
<br>
������ ��: <?php echo $this->_tpl_vars['table_size']; ?>
 ��<br>
������ ����� �����: <?php echo $this->_tpl_vars['file_size']; ?>
 ��<br>

������ ����������: <?php echo $this->_tpl_vars['tables_count']; ?>
<br>
����� ����������: <?php echo $this->_tpl_vars['rows_count']; ?>
<br><br>

���������� ��������� �������:<br><br>
<?php $_from = $this->_tpl_vars['tables_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['entry']):
 echo $this->_tpl_vars['entry']; ?>
<br>
<?php endforeach; endif; unset($_from); ?>

<?php endif; ?>

<?php if ($this->_tpl_vars['action'] == 'restore'): ?>

���� ������� �������������.<br><br>

���� �������� �����: <?php echo $this->_tpl_vars['file_date']; ?>
<br><br>

������ ���������: <?php echo $this->_tpl_vars['t_number']; ?>
<br>
����� ���������: <?php echo $this->_tpl_vars['r_number']; ?>
<br>
�������� ���������: <?php echo $this->_tpl_vars['q_number']; ?>

<?php endif; ?>