<?php /* Smarty version 2.6.11, created on 2016-03-10 11:55:47
         compiled from /home/a0031953/domains/s-q-c.ru/public_html//modules/shop/admin/templates/shop.a_products_properties.html */ ?>
<?php if ($this->_tpl_vars['mode'] == 'edit' || $this->_tpl_vars['mode'] == 'add'):  echo '
<SCRIPT language=JavaScript>
function form_check() {
	if (document.edit_property.edit_property_name.value==\'\') {
		alert("Заполните пожалуйста обязательные поля");
		return false;
	}
	else {
		return true;
	}
}

function switch_div(val) {
	obj = document.getElementById(\'div_1\');
	if (val==\'1\') obj.style.display=\'inline\';
	else obj.style.display=\'none\';
}

</SCRIPT>
'; ?>


<form action="" name=edit_property method=post onSubmit="return form_check();">
<input type=hidden name=<?php if ($this->_tpl_vars['mode'] == 'add'): ?>submit_add_property<?php else: ?>submit_edit_property<?php endif; ?>>
<input type=hidden name="edit_property_type" value="1" />

<table width=100% class=content_table>
	<tr><th><?php if ($this->_tpl_vars['mode'] == 'edit'): ?>Редактировать свойство<input type=hidden name=id value=<?php echo $this->_tpl_vars['property']['id']; ?>
><?php else: ?>Добавить свойство<?php endif; ?></th></tr>
</table>

<table width=100% class=content_table>
	<tr>
		<td width=20% class=td1_left><b>Название свойства:</b></td>
		<td class=td1_right>
			<input type="text" name=edit_property_name style="width:100%;" class=field value="<?php echo $this->_tpl_vars['property']['name']; ?>
">
		</td>
	</tr>
	<tr>
		<td width=15% class=td1_left valign="top"><b>Тип свойства:</b></td>
		<td class=td1_right>
		<select name=edit_property_entity style="width:50%;" class=field>
			<option value="brand" <?php if ($this->_tpl_vars['property']['entity'] == 'brand'): ?>selected=true<?php endif; ?>>Бренд</option>
			<option value="color" <?php if ($this->_tpl_vars['property']['entity'] == 'color'): ?>selected=true<?php endif; ?>>Цвет</option>
			<option value="size" <?php if ($this->_tpl_vars['property']['entity'] == 'size'): ?>selected=true<?php endif; ?>>Размер</option>
		</select>
		<div id="div_1" style="display: block">
			<p>
				<strong>Варианты выбора:</strong> <font color="#666666"><small>(по одному на строке)</small></font><br>
				<textarea cols="40" rows="6" name="edit_property_elements"><?php echo $this->_tpl_vars['property']['elements']; ?>
</textarea>
			</p>
		</div>
		</td>
	</tr>
	<tr>
		<td width=15% class=td1_left><b>Статус:</b></td>
		<td class=td1_right>
		<select name=edit_property_status style="width:50%;" class=field>
			<option value="1" <?php if ($this->_tpl_vars['property']['status'] == '1'): ?>selected=true<?php endif; ?>>Активный</option>
			<option value="0" <?php if ($this->_tpl_vars['property']['status'] == '0'): ?>selected=true<?php endif; ?>>Ждёт</option>
		</select>
		</td>
	</tr>
</table>
<br>
<center><input type=submit value=<?php if ($this->_tpl_vars['mode'] == 'add'): ?>"Добавить свойство"<?php else: ?>"Сохранить изменения"<?php endif; ?>></center>
</form>
<?php else:  echo '
<DIV id=dhtmltooltip></DIV>
<SCRIPT language=JavaScript>
<!--
function confirm_delete(delete_id)
{
if (confirm("Дейтсвительно удалить это свойство? ВНИМАНИЕ: Это свойство удалится у всех имеющих его товаров!!!")) {
parent.location.href = "index.php?mod=shop&action=delete_property&id=" + delete_id;
}
}
-->
</SCRIPT>
<script language=JavaScript src=\'';  echo $this->_tpl_vars['base_url'];  echo '/javascript/tooltips.js\'></script>
'; ?>

<table width=100% class=content_table>
<tr><th>Название</th><th width=10%>Статус</th><th width=15%>Действия</th></tr>
<?php $_from = $this->_tpl_vars['properties_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['tree'] = array('total' => count($_from), 'iteration' => 0);
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
_left>
			<img src=templates/img/tree.gif><?php echo $this->_tpl_vars['entry']['name']; ?>

			</td>
			<td align=center class=<?php echo $this->_tpl_vars['td']; ?>
_middle>
			<a href="?mod=shop&action=change_property_status&id=<?php echo $this->_tpl_vars['entry']['id']; ?>
" title="Изменить статус"><img src=templates/img/status_<?php echo $this->_tpl_vars['entry']['status']; ?>
.gif border=0></a>
			</td>
			<td align=center class=<?php echo $this->_tpl_vars['td']; ?>
_right nowrap>
				<a href="javascript:confirm_delete('<?php echo $this->_tpl_vars['entry']['id']; ?>
');" class=img_link onmouseover="ddrivetip('Удалить свойство')" onmouseout=hideddrivetip()><img src=templates/img/ico_delete.gif border=0></a>
				<a href=?mod=shop&action=edit_property&id=<?php echo $this->_tpl_vars['entry']['id']; ?>
 class=img_link onmouseover="ddrivetip('Редактировать свойство')" onmouseout=hideddrivetip()><img src=templates/img/ico_edit.gif border=0></a>
			</td>
		</tr>

	<?php endforeach; endif; unset($_from); ?>

	</table>
<br>
<div class="add_but" style="float: left;" onClick="location.href='?mod=shop&action=add_property'"><div><a href="?mod=shop&action=add_property">добавить свойство</a></div></div>	
<?php endif; ?>