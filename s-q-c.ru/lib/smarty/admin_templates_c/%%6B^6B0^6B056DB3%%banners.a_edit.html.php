<?php /* Smarty version 2.6.11, created on 2015-12-16 10:44:33
         compiled from /var/www/alex/data/www/scl.mosharov.com//modules/banners/admin/templates/banners.a_edit.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_select_date', '/var/www/alex/data/www/scl.mosharov.com//modules/banners/admin/templates/banners.a_edit.html', 123, false),)), $this); ?>
<?php echo '
<script language="JavaScript">
function check_form() {
	if ((document.edit_banner.name.value==\'\') ||
		(document.edit_banner.url.value==\'\')) {
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

<form action="" name=edit_banner method=POST enctype="multipart/form-data" onSubmit="return check_form();">

<?php if ($this->_tpl_vars['mode'] == 'edit'): ?>
<input type=hidden name=id value=<?php echo $this->_tpl_vars['banner']['id']; ?>
>
<input type=hidden name=old_ext value=<?php echo $this->_tpl_vars['banner']['image']; ?>
>
<?php endif; ?>

<table width=100% class="content_table">
	<tr>
		<th><?php if ($this->_tpl_vars['mode'] == 'edit'): ?>Редактируем баннер<?php else: ?>Добавить баннер<?php endif; ?></th>
	</tr>
</table>

<table width=100% class="content_table">
	<tr>
		<td width=20% class=td1_left>
			<font color=red>*</font> Название:
		</td>
		<td class=td1_right>
			<input type=text name=name style="width:100%" value="<?php echo $this->_tpl_vars['banner']['name']; ?>
" class=field>
		</td>
	</tr>
	<tr>
		<td width=20% valign=top class=td1_left><font color=red>*</font> Группа:</td><td class=td1_right>
			<select name=group style="width:50%;" class=field>
			<?php $_from = $this->_tpl_vars['groups_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['entry']):
?>
				<option value="<?php echo $this->_tpl_vars['entry']['id']; ?>
" <?php if ($this->_tpl_vars['banner']['group'] == $this->_tpl_vars['entry']['id']): ?>selected=true<?php endif; ?>><?php echo $this->_tpl_vars['entry']['name']; ?>
</option>
			<?php endforeach; endif; unset($_from); ?>
			</select>
		</td>
	</tr>
	<tr>
		<td width=20% valign=top class=td1_left>&nbsp;
			
		</td>
		<td class=td1_right>&nbsp;
			
		</td>
	</tr>
	<tr>
		<td width=20% valign=top class=td1_left><font color=red>*</font> Тип:</td><td class=td1_right>
			<select name=type style="width:50%;" class=field>
				<option value="0" <?php if ($this->_tpl_vars['banner']['type'] == '0'): ?>selected=true<?php endif; ?>>Картинка</option>
				<option value="1" <?php if ($this->_tpl_vars['banner']['type'] == '1'): ?>selected=true<?php endif; ?>>Flash анимация</option>
			</select>
		</td>
	</tr>
	<tr>
		<td width=20% valign=top class=td1_left>
			Баннер:
		</td>
		<td class=td1_right>
			<?php if ($this->_tpl_vars['banner']['image'] != ''): ?>
			
			<?php if ($this->_tpl_vars['banner']['type'] == '0'): ?>
			<img src=<?php echo $this->_tpl_vars['base_url']; ?>
/uploaded_files/banners/<?php echo $this->_tpl_vars['banner']['id']; ?>
.<?php echo $this->_tpl_vars['banner']['image']; ?>
>
			<?php else: ?>
			
			<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="<?php echo $this->_tpl_vars['width']; ?>
" height="<?php echo $this->_tpl_vars['height']; ?>
">
			<param name="movie" value="<?php echo $this->_tpl_vars['base_url']; ?>
/uploaded_files/banners/<?php echo $this->_tpl_vars['banner']['id']; ?>
.<?php echo $this->_tpl_vars['banner']['image']; ?>
">
			<param name="quality" value="high">
			<param name="wmode" value="transparent">
			<embed src="<?php echo $this->_tpl_vars['base_url']; ?>
/uploaded_files/banners/<?php echo $this->_tpl_vars['banner']['id']; ?>
.<?php echo $this->_tpl_vars['banner']['image']; ?>
" wmode="transparent" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="<?php echo $this->_tpl_vars['width']; ?>
" height="<?php echo $this->_tpl_vars['height']; ?>
"></embed>
			</object>
			
			<?php endif; ?>
			
			
			<br>
			<input type=checkbox name=delete_image> Удалить баннер
			<br><br>
			<?php endif; ?><input type=file name=image style="width:50%" class=field>
		</td>
	</tr>
	<tr>
		<td width=20% valign=top class=td1_left>
			<font color=red>*</font> URL страницы:
		</td>
		<td class=td1_right>
			<input type=text name=url style="width:100%" value="<?php echo $this->_tpl_vars['banner']['target_url']; ?>
" class=field>
		</td>
	</tr>
	<tr>
		<td width=20% valign=top class=td1_left>&nbsp;
			
		</td>
		<td class=td1_right>&nbsp;
			
		</td>
	</tr>
	<tr>
		<td width=20% valign=top class=td1_left>
			&nbsp;&nbsp;Показывать, раз:
		</td>
		<td class=td1_right>
			<input type=text name=showings style="width:50%" value="<?php echo $this->_tpl_vars['banner']['showings']; ?>
" class=field><?php if ($this->_tpl_vars['mode'] == 'edit'): ?> показано раз: <?php echo $this->_tpl_vars['banner']['shown'];  endif; ?>
		</td>
	</tr>
	<tr>
		<td width=20% valign=top class=td1_left>
			&nbsp;&nbsp;Время показа:
		</td>
		<td class=td1_right>

			<table>
				<tr><td>C</td><td><?php echo smarty_function_html_select_date(array('prefix' => 'start_','start_year' => '2011','end_year' => '2021','time' => $this->_tpl_vars['curdate']), $this);?>
</td></tr>
				<tr><td colspan="2" height="10"></td></tr>
				<tr><td>По</td><td><?php echo smarty_function_html_select_date(array('prefix' => 'end_','start_year' => '2011','end_year' => '2021','time' => $this->_tpl_vars['curdate2']), $this);?>
</td></tr>
			</table>
		</td>
	</tr>
	<tr>
		<td width=20% valign=top class=td1_left>&nbsp;</td>
		<td class=td1_right>&nbsp;</td>
	</tr>
	
	<?php if ($this->_tpl_vars['mode'] == 'edit'): ?>
	<tr>
		<td width=20% valign=top class=td1_left>&nbsp;&nbsp;Кликов:</td><td class=td1_right><?php echo $this->_tpl_vars['banner']['clicks']; ?>
</td>
	</tr>
	<?php endif; ?>
	
	<tr>
		<td width=20% valign=top class=td1_left>&nbsp;&nbsp;Статус:</td><td class=td1_right>
			<select name=status style="width:50%;" class=field>
				<option value="1">Активный</option>
				<option value="0" <?php if ($this->_tpl_vars['banner']['status'] == '0'): ?>selected=true<?php endif; ?>>Ждёт</option>
			</select>
		</td>
	</tr>
	<tr>
		<td width=15% class=td1_left valign=top>Где показывать:</td>
		<td class=td1_right>
		<div style="height: 600px; width: 600px; overflow: auto;">
			<input type="checkbox" name="checked_all_items" value="1" id="checked_all_items">
			<label for="checked_all_items">Все</label>
		
			<?php $this->assign('urlslist', $this->_tpl_vars['cat_checkboxes']); ?>
			<?php $this->assign('fullurl', "/"); ?>
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../modules/banners/admin/templates/banners.a_edit_banner_list.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		</div>
		</td>
	</tr>
</table>
<br>
<center><input type=submit <?php if ($this->_tpl_vars['mode'] == 'edit'): ?>name=submit_edit_banner value="Сохранить изменения"<?php else: ?>name=submit_add_banner value="Добавить баннер"<?php endif; ?>></center>

</form>

<?php echo '
<SCRIPT language=JavaScript>
<!--
$("#checked_all_items").click(function(){
	if ( $(this).attr("checked") )
		{
			$("input.checkbox_tree").attr("checked", "true");
		}
	else
		{
			$("input.checkbox_tree").removeAttr("checked");
		}
});
-->
</SCRIPT>
'; ?>