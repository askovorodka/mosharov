<?php /* Smarty version 2.6.11, created on 2016-03-25 00:21:58
         compiled from /home/a0031953/domains/s-q-c.ru/public_html//modules/forms/admin/templates/forms.a_edit.html */ ?>
<?php echo '

<script language="JavaScript">
function check_form() {
	if (document.edit_form.edit_forms_name.value==\'\') {
		alert("���������, ����������, ������������ ����");
		return false;
	}
	else {
		return true;
	}
}

function switcher(divname, value) {

	obj=document.getElementById(divname);

	if (value=="3") {
		obj.style.display=\'\';
	}
	else {
		obj.style.display=\'none\';
	}
}
</script>
'; ?>


<?php if ($this->_tpl_vars['success_message']): ?><center><font color=green><?php echo $this->_tpl_vars['success_message']; ?>
</font></center><br><?php endif;  if ($this->_tpl_vars['error_message']): ?><center><font color=red><?php echo $this->_tpl_vars['error_message']; ?>
</font></center><br><?php endif; ?>

<form action="" name="edit_form" method="post" onSubmit="return check_form();">

<?php if ($this->_tpl_vars['mode'] == 'edit'): ?>
<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['table']['id']; ?>
">
<?php endif; ?>

<table width=100% class="content_table">
	<tr>
		<th>
			<?php if ($this->_tpl_vars['mode'] == 'edit'): ?>�����������<?php else: ?>��������<?php endif; ?> �����
		</th>
	</tr>
</table>

<table width=100% class="content_table">
	<tr>
		<td width=20% class=td1_left>
			<font color=red><sup>*</sup></font>��������:
		</td>
		<td class=td1_right>
			<input type=text name=edit_forms_name style="width:100%" value="<?php echo $this->_tpl_vars['form']['name']; ?>
" class=field>
		</td>
	</tr>
	<tr>
		<td width=20% class=td1_left>&nbsp;&nbsp;E-mail:
		</td>
		<td class=td1_right>
			<input type=text name=edit_forms_email style="width:50%" value="<?php echo $this->_tpl_vars['form']['email']; ?>
" class=field>
		</td>
	</tr>
	<?php if ($this->_tpl_vars['mode'] == 'edit'): ?>
	<tr>
		<td colspan="2" class=td1_left valign="top">
			<p>���� �����:</p>
			<p>
				<table cellpadding="1" cellspacing="1" border="0" width="100%">
					<?php if ($this->_tpl_vars['form_elements']): ?>
					<tr>
						<td colspan="2">
							<table cellpadding="0" cellspacing="0" border="0" width="100%" class="content_table">
								<?php $_from = $this->_tpl_vars['form_elements']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['fel'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fel']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['entry']):
        $this->_foreach['fel']['iteration']++;
?>
									<?php if ($this->_tpl_vars['col'] == 1): ?>
									<?php $this->assign('td', 'td1'); ?>
									<?php $this->assign('col', 0); ?>
									<?php else: ?>
									<?php $this->assign('td', 'td2'); ?>
									<?php $this->assign('col', 1); ?>
									<?php endif; ?>
									<tr>
										<td rowspan="4" width="20" align="center"><strong><?php echo $this->_foreach['fel']['iteration']; ?>
.</strong></td>
										<td nowrap>
											<strong>�����:</strong> <input type="text" class=field name="edit_form_element_sort_order[<?php echo $this->_tpl_vars['entry']['id']; ?>
]" value="<?php echo $this->_tpl_vars['entry']['sort_order']; ?>
" size="2">&nbsp;&nbsp;&nbsp;&nbsp;
											<strong>������:</strong> <input type="checkbox" name="edit_form_element_status[<?php echo $this->_tpl_vars['entry']['id']; ?>
]" id="st_<?php echo $this->_tpl_vars['entry']['id']; ?>
"<?php if ($this->_tpl_vars['entry']['status'] == '1'): ?>checked<?php endif; ?>><label for="st_<?php echo $this->_tpl_vars['entry']['id']; ?>
">����������</label>
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="?mod=forms&action=delete_element&id=<?php echo $this->_tpl_vars['entry']['id']; ?>
">�������</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										</td>
										<td width="290" align="right" nowrap><strong>��� ����:</strong>
											<select class=field name="edit_form_element_type[<?php echo $this->_tpl_vars['entry']['id']; ?>
]" style="width:220px" onChange="switcher('div_element_<?php echo $this->_tpl_vars['entry']['id']; ?>
', this.value)">
												<option value="0"<?php if ($this->_tpl_vars['entry']['type'] == '0'): ?>selected<?php endif; ?>>������� �����</option>
												<option value="1"<?php if ($this->_tpl_vars['entry']['type'] == '1'): ?>selected<?php endif; ?>>������������ ��������� ����</option>
												<option value="2"<?php if ($this->_tpl_vars['entry']['type'] == '2'): ?>selected<?php endif; ?>>������������� ��������� ����</option>
												<option value="3"<?php if ($this->_tpl_vars['entry']['type'] == '3'): ?>selected<?php endif; ?>>�������� ������</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan="2">
											<input class=field type="text" name="edit_form_element_name[<?php echo $this->_tpl_vars['entry']['id']; ?>
]" value="<?php echo $this->_tpl_vars['entry']['name']; ?>
" style="width:100%">
										</td>
									</tr>
									<tr>
										<td colspan="2">
											<div id="div_element_<?php echo $this->_tpl_vars['entry']['id']; ?>
" <?php if ($this->_tpl_vars['entry']['type'] != '3'): ?>style="display: none;"<?php endif; ?>>
												<strong><strong>�������� ����</strong></strong> (�� ������ �� ������):<br>
												<textarea name="edit_form_element_value[<?php echo $this->_tpl_vars['entry']['id']; ?>
]" class=field style="width: 100%; height: 70px;"><?php echo $this->_tpl_vars['entry']['value']; ?>
</textarea>
											</div>
										</td>
									</tr>
									<tr>
										<td colspan="2"><hr></td>
									</tr>
								<?php endforeach; endif; unset($_from); ?>
							</table>
						</td>
					</tr>
					<?php endif; ?>
					<tr>
						<td>
							<table width="100%" cellspacing="1" cellpadding="0" border="0">
								<tr>
									<th colspan="2">�������� ����� ����</th>
								</tr>
								<tr>
									<td><strong>��� ����:</strong><br><input type="text" class=field name="edit_form_newelement_name" style="width:100%"></td>
									<td width="220"><strong>��� ����:</strong><br>
										<select name="edit_form_newelement_type" class=field style="width:100%" onChange="switcher('div_newelement', this.value)">
											<option value="0">������� �����</option>
											<option value="1" selected>������������ ��������� ����</option>
											<option value="2">������������� ��������� ����</option>
											<option value="3">�������� ������</option>
										</select>
									</td>
								</tr>
								<tr>
									<td colspan="2">
										<div id="div_newelement" style="display: none;">
											<strong>�������� ����</strong> (�� ������ �� ������):<br>
											<textarea name="edit_form_newelement_value" class=field style="width: 100%; height: 70px;"></textarea>
										</div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</p>
		</td>
	</tr>
	<tr>
		<td width=20% class=td1_left>
			������:
		</td>
		<td class=td1_right>
			<select name="edit_forms_status">
				<option value="1" <?php if ($this->_tpl_vars['form']['status'] == '1'): ?>selected<?php endif; ?>>��������</option>
				<option value="0" <?php if ($this->_tpl_vars['form']['status'] == '0'): ?>selected<?php endif; ?>>���</option>
			</select>
		</td>
	</tr>
	<?php endif; ?>
</table>
<br>
<center><input type=submit <?php if ($this->_tpl_vars['mode'] == 'edit'): ?>name=submit_edit_form value="��������� ���������"<?php else: ?>name=submit_add_form value="�������� �����"<?php endif; ?>></center>

</form>