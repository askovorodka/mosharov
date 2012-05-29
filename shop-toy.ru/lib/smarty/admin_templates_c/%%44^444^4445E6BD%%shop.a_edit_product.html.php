<?php /* Smarty version 2.6.11, created on 2012-02-06 16:37:12
         compiled from /home/alex/data/www/shop-toy.mosharov.com/modules/shop/admin/templates/shop.a_edit_product.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'replace', '/home/alex/data/www/shop-toy.mosharov.com/modules/shop/admin/templates/shop.a_edit_product.html', 166, false),array('function', 'math', '/home/alex/data/www/shop-toy.mosharov.com/modules/shop/admin/templates/shop.a_edit_product.html', 333, false),)), $this); ?>
<?php echo '
<script language=JavaScript src=\'';  echo $this->_tpl_vars['base_url']; ?>
/<?php echo 'javascript/editor/scripts/language/russian/editor_lang.js\'></script>
<script language=JavaScript src=\'';  echo $this->_tpl_vars['base_url']; ?>
/<?php echo 'javascript/editor/scripts'; ?>
/<?php echo $this->_tpl_vars['editor_mode'];  echo '\'></script>

<script language="JavaScript">
function check_form() {
	document.edit_product.edit_description.value = edit_description.getHTMLBody();
	return true;
}
function show(name, elem)
{
if(document.getElementById(name).style.display!="none") {
		document.getElementById(name).style.display="none";
		elem.className = "plus";
	}
	else {
		document.getElementById(name).style.display="";
		elem.className = "minus";
	}
}
function shows(name)
{
if(document.getElementById(name).style.display!="none") {
		document.getElementById(name).style.display="none";
		document.getElementById(\'nav_\' + name).style.display="";
	}
	else {
		document.getElementById(name).style.display="";
		document.getElementById(\'nav_\' + name).style.display="none";
	}
}
</script>
'; ?>



<form action="" method=post name=edit_product enctype="multipart/form-data" onSubmit="check_form();">
<input type=hidden name=id value=<?php echo $this->_tpl_vars['product']['id']; ?>
>
<center>
<?php if ($this->_tpl_vars['error']): ?><font color=red><b><?php echo $this->_tpl_vars['error']; ?>
</b></font><br><br><?php endif; ?>
<table width=100% class=content_table>
<tr>
<th><?php if ($this->_tpl_vars['mode'] == 'edit'): ?>Редактировать продукт<?php else: ?>Добавить продукт<?php endif; ?></th>
</tr>
</table>


<table width=100% class=content_table>
<tr>
	<td width=15% class=td1_left>Раздел:</td>
	<td class=td1_right>
		<select name=edit_parent class=field style="width:100%;">
		<?php $_from = $this->_tpl_vars['cat_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['entry']):
?>
			<option value=<?php echo $this->_tpl_vars['entry']['id'];  if ($this->_tpl_vars['entry']['id'] == $this->_tpl_vars['product']['parent'] || $this->_tpl_vars['entry']['id'] == $this->_tpl_vars['cat']): ?> selected=true<?php endif; ?>><?php echo $this->_tpl_vars['entry']['full_title']; ?>
</option>
		<?php endforeach; endif; unset($_from); ?>
		</select>	</td>
</tr>
<tr>
	<td class=td1_left>Имя:</td><td class=td1_right><input type=text name=edit_name class=field style="width:100%;" value="<?php echo $this->_tpl_vars['product']['name']; ?>
"></td>
</tr>

<?php if ($this->_tpl_vars['mode'] == 'edit'): ?>
<tr>
  <td class=td1_left style="border-bottom: none;">Статус:</td>
  <td class=td1_right style="border-bottom: none;">
  
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="35%"><select name=edit_status style="width:200px;" class=field>
		<option value="1" <?php if ($this->_tpl_vars['product']['status'] == '1'): ?>selected=true<?php endif; ?>>Активный</option>
		<option value="0" <?php if ($this->_tpl_vars['product']['status'] == '0'): ?>selected=true<?php endif; ?>>Ждёт</option>
	</select>	</td>
      </tr>
</table>

  </td>
</tr>
<?php endif; ?>

<tr>
  <td class=td1_left style="border-bottom: none;">Цена:</td>
  <td class=td1_right style="border-bottom: none;">
  <input type=text name=edit_price class=field style="width:200px;" value="<?php echo $this->_tpl_vars['product']['price']; ?>
">&nbsp;&nbsp;<?php echo $this->_tpl_vars['currency_admin']['znak']; ?>

  </td>
</tr>

<tr>
  <td class=td1_left style="border-bottom: none;">Артикул:</td>
  <td class=td1_right style="border-bottom: none;">
  <input type=text name=edit_article class=field style="width:200px;" value="<?php echo $this->_tpl_vars['product']['article']; ?>
">
  </td>
</tr>

<tr>
  <td class=td1_left style="border-bottom: none;">Страна производства:</td>
  <td class=td1_right style="border-bottom: none;">
  <input type=text name=edit_country class=field style="width:200px;" value="<?php echo $this->_tpl_vars['product']['country']; ?>
">
  </td>
</tr>

<tr>
  <td class=td1_left style="border-bottom: none;">Гарантия:</td>
  <td class=td1_right style="border-bottom: none;">
  <input type=text name=edit_garant class=field style="width:200px;" value="<?php echo $this->_tpl_vars['product']['garant']; ?>
">
  </td>
</tr>

<tr>
  <td class=td1_left style="border-bottom: none;">Пол:</td>
  <td class=td1_right style="border-bottom: none;">
  <select name="edit_sex"><option value="boy" <?php if ($this->_tpl_vars['product']['sex'] == 'boy'): ?>selected<?php endif; ?>>Мальчик</option>
  <option <?php if ($this->_tpl_vars['product']['sex'] == 'girl'): ?>selected<?php endif; ?> value="girl">Девочка</option></select>
  </td>
</tr>

<tr>
  <td class=td1_left style="border-bottom: none;">Возраст:</td>
  <td class=td1_right style="border-bottom: none;">
	<select name="edit_age">
    <option value="0" <?php if ($this->_tpl_vars['product']['age'] == '0'): ?>selected<?php endif; ?>>Менее года</option>
    <option value="1" <?php if ($this->_tpl_vars['product']['age'] == '1'): ?>selected<?php endif; ?>>1 год</option>
    <option value="2" <?php if ($this->_tpl_vars['product']['age'] == '2'): ?>selected<?php endif; ?>>2 года</option>
    <option value="3" <?php if ($this->_tpl_vars['product']['age'] == '3'): ?>selected<?php endif; ?>>3</option>
    <option value="4" <?php if ($this->_tpl_vars['product']['age'] == '4'): ?>selected<?php endif; ?>>4</option>
    <option value="5" <?php if ($this->_tpl_vars['product']['age'] == '5'): ?>selected<?php endif; ?>>5</option>
    <option value="6" <?php if ($this->_tpl_vars['product']['age'] == '6'): ?>selected<?php endif; ?>>6</option>
    <option value="7" <?php if ($this->_tpl_vars['product']['age'] == '7'): ?>selected<?php endif; ?>>7</option>
    <option value="8" <?php if ($this->_tpl_vars['product']['age'] == '8'): ?>selected<?php endif; ?>>8</option>
    <option value="9" <?php if ($this->_tpl_vars['product']['age'] == '9'): ?>selected<?php endif; ?>>9</option>
    <option value="10" <?php if ($this->_tpl_vars['product']['age'] == '10'): ?>selected<?php endif; ?>>10</option>
	</select>
  </td>
</tr>


<tr>
<td class=td1_single colspan=2>

<input type=hidden name=edit_description value="">
<p><font color=red>*</font> Описание товара:</p>
<?php echo '
<script language="JavaScript">
				var edit_description = new InnovaEditor("edit_description");

				edit_description.btnStyles=true;

				edit_description.width="100%";
				edit_description.height="400";

				edit_description.css="style.css";
				edit_description.cmdAssetManager="modalDialogShow(\'';  echo $this->_tpl_vars['base_url']; ?>
/<?php echo 'javascript/editor/assetmanager/assetmanager.php?lang=russian\',640,465)";

				edit_description.features=["FullScreen","Search",
						"Cut","Copy","Paste","PasteWord","PasteText","|","Undo","Redo","|",
						"ForeColor","BackColor","|","Bookmark","Hyperlink",
						"XHTMLSource","Numbering","Bullets","|","Indent","Outdent","|","Image","|",
						"Table","Guidelines","Absolute","|","Characters","Line",
						"Clean","ClearAll","BRK",
						"Paragraph","FontSize","|",
						"Bold","Italic",
						"Underline","Strikethrough","|","Superscript","Subscript","|",
						"JustifyLeft","JustifyCenter","JustifyRight","JustifyFull"];


				edit_description.RENDER(\'';  echo ((is_array($_tmp=$this->_tpl_vars['product']['description'])) ? $this->_run_mod_handler('replace', true, $_tmp, "\r\n", "") : smarty_modifier_replace($_tmp, "\r\n", ""));  echo '\');
</script>
'; ?>

</td>
</tr>


</table>


<table width=100% class=content_table>
	<tr>
		<th bgcolor=#99CCFF onClick="show('metas', this);" class="button plus" style="border-bottom: none; text-align: left; padding-left: 30px;"><b>Metas</b></th>
	</tr>
 </table>
    <div id="metas" style="display:none;">
<table width=100% class=content_table>
	<tr>
		<td width=15% class=td2_left><b>Title:</b><br><small>(заголовок страницы)</small></td>
		<td class=td2_right><input type=text name=edit_title class=field style="width:100%;" value="<?php echo $this->_tpl_vars['product']['title']; ?>
"></td>
	</tr>
	<tr>
		<td width=15% class=td2_left><b>Keywords:</b><br><small>(meta keywords)</small></td>
		<td class=td2_right><input type=text name=edit_meta_keywords class=field style="width:100%;" value="<?php echo $this->_tpl_vars['product']['meta_keywords']; ?>
"></td>
	</tr>
	<tr>
		<td width=15% class=td2_left><b>Description:</b><br><small>(meta description)</small></td>
		<td class=td2_right><input type=text name=edit_meta_description class=field style="width:100%;" value="<?php echo $this->_tpl_vars['product']['meta_description']; ?>
"></td>
	</tr>
</table>
</div>

<?php if ($this->_tpl_vars['mode'] == 'edit'):  if ($this->_tpl_vars['product']['properties']): ?>
<table width=100% class=content_table>
	<tr>
		<th bgcolor=#99CCFF onClick="show('others', this);" class="button plus" style="border-bottom: none; text-align: left; padding-left: 30px;"><b>Дополнительные свойства</b></th>
	</tr>
 </table>
    <div id="others" style="display: none;">
<table width=100% class=content_table>
	<?php $_from = $this->_tpl_vars['product']['properties']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['tree'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['tree']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['entry']):
        $this->_foreach['tree']['iteration']++;
?>
    <?php if ($this->_tpl_vars['entry']): ?>
    <tr>
		<td width=15% class=td2_left><?php echo $this->_tpl_vars['entry']['1']; ?>
:</td>
		<td class=td2_right><?php if ($this->_tpl_vars['entry']['2'] == '1'): ?>
		<select name="edit_properties[<?php echo $this->_tpl_vars['entry']['0']; ?>
]">
		<option value=""></option>
		<?php unset($this->_sections['element']);
$this->_sections['element']['name'] = 'element';
$this->_sections['element']['loop'] = is_array($_loop=$this->_tpl_vars['entry']['3']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['element']['show'] = true;
$this->_sections['element']['max'] = $this->_sections['element']['loop'];
$this->_sections['element']['step'] = 1;
$this->_sections['element']['start'] = $this->_sections['element']['step'] > 0 ? 0 : $this->_sections['element']['loop']-1;
if ($this->_sections['element']['show']) {
    $this->_sections['element']['total'] = $this->_sections['element']['loop'];
    if ($this->_sections['element']['total'] == 0)
        $this->_sections['element']['show'] = false;
} else
    $this->_sections['element']['total'] = 0;
if ($this->_sections['element']['show']):

            for ($this->_sections['element']['index'] = $this->_sections['element']['start'], $this->_sections['element']['iteration'] = 1;
                 $this->_sections['element']['iteration'] <= $this->_sections['element']['total'];
                 $this->_sections['element']['index'] += $this->_sections['element']['step'], $this->_sections['element']['iteration']++):
$this->_sections['element']['rownum'] = $this->_sections['element']['iteration'];
$this->_sections['element']['index_prev'] = $this->_sections['element']['index'] - $this->_sections['element']['step'];
$this->_sections['element']['index_next'] = $this->_sections['element']['index'] + $this->_sections['element']['step'];
$this->_sections['element']['first']      = ($this->_sections['element']['iteration'] == 1);
$this->_sections['element']['last']       = ($this->_sections['element']['iteration'] == $this->_sections['element']['total']);
?>
		<option value="<?php echo $this->_tpl_vars['entry']['3'][$this->_sections['element']['index']]; ?>
" <?php if ($this->_tpl_vars['entry']['3'][$this->_sections['element']['index']] == $this->_tpl_vars['entry']['5']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['entry']['3'][$this->_sections['element']['index']]; ?>
</option>
		<?php endfor; endif; ?>
		</select>
		<?php elseif ($this->_tpl_vars['entry']['2'] == '0'): ?>
		<textarea name="edit_properties[<?php echo $this->_tpl_vars['entry']['0']; ?>
]" class=field style="width:100%; height:35px"><?php echo $this->_tpl_vars['entry']['5']; ?>
</textarea>
		<?php else: ?>&nbsp;<?php endif; ?></td></tr><?php endif; ?>
		<?php endforeach; endif; unset($_from); ?>
</table>
</div>
<?php endif;  endif; ?>




<br><br>
<center><input type=submit name=<?php if ($this->_tpl_vars['mode'] == 'edit'): ?>submit_edit_product value="Сохранить изменения"<?php else: ?>submit_add_product value="Добавить продукт"<?php endif; ?> class=button></center>
</form>



<?php if ($this->_tpl_vars['mode'] == 'edit'): ?>
<br><br>
<table width=100% cellspacing=1 cellpadding=3 class=content_table>
<tr>
<th>Фотоальбом продукта</th>
</tr>
</table>

<form action="" method=post name=edit_photos>
<?php if (! $this->_tpl_vars['photos_list']): ?>
<br><br><br><center>В альбоме нет фотографий</center><br><br>
<?php else: ?>
<table width=100% cellspacing=1 cellpadding=3 class=content_table>
<tr>
<td class=td1_single valign=top>



<table width=<?php if ($this->_tpl_vars['photos_count'] == '1'): ?>25<?php endif;  if ($this->_tpl_vars['photos_count'] == '2'): ?>50<?php endif;  if ($this->_tpl_vars['photos_count'] == '3'): ?>75<?php endif;  if ($this->_tpl_vars['photos_count'] > 3): ?>100<?php endif; ?>% cellspacing=1 cellpadding=3>
<tr>
<?php $this->assign('i', 0);  $_from = $this->_tpl_vars['photos_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['tp'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['tp']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['entry']):
        $this->_foreach['tp']['iteration']++;
 if ($this->_tpl_vars['i'] == 4):  $this->assign('i', 0); ?></tr><tr><?php endif; ?>
<td valign=top width="25%">
<input type=hidden id=order_<?php echo $this->_tpl_vars['entry']['id']; ?>
 name=order_changed[<?php echo $this->_tpl_vars['entry']['id']; ?>
] value="">
<input type=hidden id=title_<?php echo $this->_tpl_vars['entry']['id']; ?>
 name=title_changed[<?php echo $this->_tpl_vars['entry']['id']; ?>
] value="">
<table width=100% cellspacing=1 cellpadding=3 bgcolor=#666666>
<tr bgcolor=#ffffff>
<td height=120 style="padding: 2px;">

<div id="photo_<?php echo $this->_tpl_vars['entry']['id']; ?>
" style="display: none; height: 120px;">
<textarea class=field style="width:100%; height: 118px;" name=edit_title[<?php echo $this->_tpl_vars['entry']['id']; ?>
] onchange="document.getElementById('title_<?php echo $this->_tpl_vars['entry']['id']; ?>
').value=1;"><?php echo $this->_tpl_vars['entry']['title']; ?>
</textarea>
</div>

<table width="100%" style="height: 120px;" border="0" cellspacing="0" cellpadding="0" id="nav_photo_<?php echo $this->_tpl_vars['entry']['id']; ?>
">
  <tr>
    <td align="center"><img src=../uploaded_files/shop_images/resized-<?php echo $this->_tpl_vars['entry']['id']; ?>
.<?php echo $this->_tpl_vars['entry']['ext']; ?>
 border="0" width="100" height="100" alt=""></td>
  </tr>
</table>

</td></tr>
<tr><td onClick="shows('photo_<?php echo $this->_tpl_vars['entry']['id']; ?>
');" class="button" bgcolor="#3689d8" style="height: 20px; color: white; padding-left: 10px;"><small>комментарии</small></td></tr>
<tr bgcolor=#ffffff class=table_content>
<td>

<table width="100%" style="height: 25px;" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><input type=checkbox name=delete_photos[] value=<?php echo $this->_tpl_vars['entry']['id']; ?>
 id="del_photo_<?php echo $this->_tpl_vars['entry']['id']; ?>
"> <label for="del_photo_<?php echo $this->_tpl_vars['entry']['id']; ?>
">Удалить</label></td>
    <td align="right" style="padding-right: 2px;"><input type=text size="2" class=field name=edit_order[<?php echo $this->_tpl_vars['entry']['id']; ?>
] value=<?php echo $this->_tpl_vars['entry']['sort_order']; ?>
 onchange="document.getElementById('order_<?php echo $this->_tpl_vars['entry']['id']; ?>
').value=1;"></td>
  </tr>
</table>

</td></tr>
</table>

</td>
<?php echo smarty_function_math(array('equation' => "x + y",'x' => $this->_tpl_vars['i'],'y' => 1,'assign' => 'i'), $this);?>

<?php endforeach; endif; unset($_from); ?>
</tr>
</table>


</td></tr>
</table>

<br><br>
<center><input type=submit name=submit_save_photos value="Сохранить изменения в фотоальбоме" class=button></center>
<?php endif; ?></form>
<br><br>

<form action="" method=post name=add_photos enctype="multipart/form-data">
<input type=hidden name=parent value=<?php echo $this->_tpl_vars['product']['id']; ?>
>
<table width=100%  class=content_table>
<tr>
<th colspan="2">Добавить картинку в фотоальбом продукта</th></tr>
<tr>
<td width=20% class=td1_left>Подпись к картинке:</td><td class=td1_right><textarea name="add_photo_title" class="field" style="width: 450px; height: 60px;"><?php echo $this->_tpl_vars['photo_title']; ?>
</textarea></td>
</tr>
<tr>
<td class=td1_left style="height: 30px;">Картинка:</td><td class=td1_right><input type=file class=field name=add_new_photo style="width:450px;"><br><div style="padding-top: 5px; font-size: 10px; color: #999;">Разрешенные форматы для загрузки jpg, gif, png. Максимальный размер файла 2 Мб.</div></td>
</tr></table>
<br><br><center><input type=submit name=submit_add_photo value="Добавить фотографию"></center>
<br><br>
</form>
<?php endif; ?>