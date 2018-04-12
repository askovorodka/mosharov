<?php /* Smarty version 2.6.11, created on 2016-02-14 00:55:57
         compiled from /var/www/alex/data/www/scl.mosharov.com//modules/shop/admin/templates/shop.a_edit_product.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'replace', '/var/www/alex/data/www/scl.mosharov.com//modules/shop/admin/templates/shop.a_edit_product.html', 199, false),array('function', 'math', '/var/www/alex/data/www/scl.mosharov.com//modules/shop/admin/templates/shop.a_edit_product.html', 402, false),)), $this); ?>
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
		<td class=td1_left style="border-bottom: none;">Цена со скидкой:</td>
		<td class=td1_right style="border-bottom: none;">
			<input type=text name=edit_price_sale class=field style="width:200px;" value="<?php echo $this->_tpl_vars['product']['price_sale']; ?>
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
  <td class=td1_left style="border-bottom: none;">Тип:</td>
  <td class=td1_right style="border-bottom: none;">
  <input type=text name=edit_type_name class=field style="width:200px;" value="<?php echo $this->_tpl_vars['product']['type_name']; ?>
">
  </td>
</tr>

<?php if ($this->_tpl_vars['mode'] == 'edit'): ?>

	

<?php endif; ?>

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



<br><br>
<center><input type=submit name=<?php if ($this->_tpl_vars['mode'] == 'edit'): ?>submit_edit_product value="Сохранить изменения"<?php else: ?>submit_add_product value="Добавить продукт"<?php endif; ?> class=button></center>
	<br><br>
</form>



<?php if ($this->_tpl_vars['mode'] == 'edit'): ?>
<table width=100% cellspacing=1 cellpadding=3 class=content_table>
	<tr>
		<th>Размеры и цвета продукта</th>
	</tr>

	<tr><td>
	<div id="sizes">

		<?php if (! empty ( $this->_tpl_vars['product_properties'] )): ?>
		<table width="100%" class=content_table>
			<?php $_from = $this->_tpl_vars['product_properties']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['forProperty'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['forProperty']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['property']):
        $this->_foreach['forProperty']['iteration']++;
?>

			<?php if ($this->_tpl_vars['col'] == 1): ?>
				<?php $this->assign('td', 'td1'); ?>
				<?php $this->assign('col', 0); ?>
			<?php else: ?>
				<?php $this->assign('td', 'td2'); ?>
			<?php $this->assign('col', 1); ?>
			<?php endif; ?>


			<tr>
				<td class=<?php echo $this->_tpl_vars['td']; ?>
_left width="4%">Размер:</td>
				<td class=<?php echo $this->_tpl_vars['td']; ?>
_left width="3%"><?php echo $this->_tpl_vars['property']['value']; ?>
</td>
				<td class=<?php echo $this->_tpl_vars['td']; ?>
_left width="3%">
					<?php if (! empty ( $this->_tpl_vars['property']['size_brand'] )): ?>
						<?php $_from = $this->_tpl_vars['property']['size_brand']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['sbrand']):
?>
							<?php echo $this->_tpl_vars['sbrand']['value']; ?>

						<?php endforeach; endif; unset($_from); ?>
					<?php else: ?>
						&mdash;
					<?php endif; ?>
				</td>
				<td class=<?php echo $this->_tpl_vars['td']; ?>
_left width="2%"><a href="?mod=shop&action=change_property_status&id=<?php echo $this->_tpl_vars['property']['id']; ?>
" title="Изменить статус свойства"><img src="templates/img/status_<?php echo $this->_tpl_vars['property']['status']; ?>
.gif" border="0"></a></td>
				<td class=<?php echo $this->_tpl_vars['td']; ?>
_left width="3%">Цвета:</td>
				<td class=<?php echo $this->_tpl_vars['td']; ?>
_left width="68%">
					<?php if (! empty ( $this->_tpl_vars['property']['colors'] )): ?>
						<?php $_from = $this->_tpl_vars['property']['colors']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['color']):
?>
							<a href="?mod=shop&action=change_property_status&id=<?php echo $this->_tpl_vars['color']['id']; ?>
" title="color:<?php echo $this->_tpl_vars['color']['value']; ?>
, статус:<?php if ($this->_tpl_vars['color']['status'] == 1): ?>Вкл<?php else: ?>Выкл<?php endif; ?>"
							   style="display: inline-block; width:25px; height: 20px; margin: 0 3px;border:1px solid <?php if ($this->_tpl_vars['color']['status'] == 1): ?>LawnGreen<?php else: ?>red<?php endif; ?>;">
								<div style="width:25px; height:20px; background-color:<?php echo $this->_tpl_vars['color']['value']; ?>
; text-align: center; vertical-align: middle; font-weight: bold;"><?php if ($this->_tpl_vars['color']['status'] == 1): ?>+<?php else: ?>-<?php endif; ?></div>
							</a>
						<?php endforeach; endif; unset($_from); ?>
					<?php endif; ?>
				</td>
				<td class=<?php echo $this->_tpl_vars['td']; ?>
_left width="15%">
					<form action="" method="post">
						<input type="hidden" name="product_id" value="<?php echo $this->_tpl_vars['product']['id']; ?>
" />
						<input type="hidden" name="parent_id" value="<?php echo $this->_tpl_vars['property']['id']; ?>
">
						Цвет [р.<?php echo $this->_tpl_vars['property']['value']; ?>
]: <input type="text" name="property_color" style="width: 55px;" value="" />
						<button type="submit">Добавить цвет</button>
					</form>
				</td>
			</tr>
			<?php endforeach; endif; unset($_from); ?>
		</table>
		<?php endif; ?>

		<br />
		<form action="" method="post">
			<input type="hidden" name="product_id" value="<?php echo $this->_tpl_vars['product']['id']; ?>
" />
			Размер: <input type="text" name="property_size" value="" style="width: 100px;" placeholder="Размер" />
			<input type="text" name="property_size_brand" value="" style="width: 150px;" placeholder="Размер производителя" />
			<button type="submit">Добавить размер</button>
		</form>
		<br />

		<table width=100% class=content_table>
		</table>
	</div>

	</td></tr>
</table>

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
    <td align="center"><img src=../uploaded_files/shop_images/100x100-<?php echo $this->_tpl_vars['entry']['id']; ?>
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