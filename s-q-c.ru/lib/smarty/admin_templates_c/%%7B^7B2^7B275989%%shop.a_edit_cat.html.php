<?php /* Smarty version 2.6.11, created on 2015-12-05 17:29:22
         compiled from /var/www/sqc//modules/shop/admin/templates/shop.a_edit_cat.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'replace', '/var/www/sqc//modules/shop/admin/templates/shop.a_edit_cat.html', 115, false),)), $this); ?>
<?php echo '
<script language=JavaScript src=\'';  echo $this->_tpl_vars['base_url']; ?>
/<?php echo 'javascript/editor/scripts/language/russian/editor_lang.js\'></script>
<script language=JavaScript src=\'';  echo $this->_tpl_vars['base_url']; ?>
/<?php echo 'javascript/editor/scripts'; ?>
/<?php echo $this->_tpl_vars['editor_mode'];  echo '\'></script>

<SCRIPT language=JavaScript>
function swith_all(obj) {
	for(i=0; i<obj.elements.length; i++) {
		if (obj.elements[i].type=="checkbox" && obj.elements[i].id.indexOf("for_switch")!=-1) {
			obj.elements[i].checked=true;
		}
	}
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
	}
	else {
		document.getElementById(name).style.display="";
	}
}

function form_check() {
	//if (document.edit_cat.edit_cat_url.value==\'\') {
	if (false){
		alert("Заполните пожалуйста обязательные поля");
		return false;
	}
	else {
		document.edit_cat.edit_cat_text.value = cat_text.getHTMLBody();
		return true;
	}
}
</SCRIPT>
'; ?>


<?php if ($this->_tpl_vars['error_message']): ?><center><font color=red><b><?php echo $this->_tpl_vars['error_message']; ?>
</b></font></center><br><br><?php endif; ?>

<form action="" name=edit_cat method=post enctype="multipart/form-data" onSubmit="return form_check();">
<?php if ($this->_tpl_vars['mode'] == 'edit'): ?>
<input type=hidden name=old_url value=<?php echo $this->_tpl_vars['cat']['url']; ?>
>
<input type=hidden name=id value=<?php echo $this->_tpl_vars['cat']['id']; ?>
>
<input type=hidden name=old_image value=<?php echo $this->_tpl_vars['cat']['image']; ?>
>
<?php endif; ?>
<input type=hidden name=old_parent value=<?php echo $this->_tpl_vars['parent']; ?>
>
<table width=100% class=content_table>
	<tr><th><?php if ($this->_tpl_vars['mode'] == 'edit'): ?>Редактировать категорию<?php else: ?>Добавить категорию<?php endif; ?></th></tr>
</table>

<table width=100% class=content_table>
	<tr>
		<td width=20% class=td1_left>&nbsp;В раздел:</td>
		<td class=td1_right>
			<select name=edit_cat_parent style="width:100%;" class=field>
			<?php $_from = $this->_tpl_vars['cat_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['entry']):
?>
			<option value=<?php echo $this->_tpl_vars['entry']['id'];  if ($this->_tpl_vars['entry']['id'] == $this->_tpl_vars['parent']): ?> selected=true<?php endif; ?>><?php echo $this->_tpl_vars['entry']['full_title']; ?>
</option>
			<?php endforeach; endif; unset($_from); ?>
			</select>
		</td>
	</tr>

	<tr class=table_content>
		<td class=td1_left>&nbsp;Название:</td>
		<td class=td1_right><input type=text name=edit_cat_name style="width:100%;" class=field value="<?php echo $this->_tpl_vars['cat']['name']; ?>
"></td>
	</tr>
	<tr class=table_content>
		<td class=td1_left><font color=red></font>URL (<small>не обзятаельное, генерируется автоматом</small>):</td>
		<td class=td1_right><input type=text name=edit_cat_url style="width:100%;" class=field value="<?php echo $this->_tpl_vars['cat']['url']; ?>
"></td>
	</tr>
	
 	<?php if ($this->_tpl_vars['mode'] == 'edit'): ?>
	<tr>
		<td class=td1_single valign=top colspan="2">
			<p>&nbsp;Краткое описание:</p>
	<input type=hidden name=edit_cat_text value="">
	<?php if ($this->_tpl_vars['editor_style'] != 'html'): ?>
	<?php echo '
	<script language="JavaScript">
					var cat_text = new InnovaEditor("cat_text");
				
						cat_text.btnStyles=true;
	
						cat_text.width="100%";
						cat_text.height="400";
	
						cat_text.css="style.css";
						cat_text.cmdAssetManager="modalDialogShow(\'';  echo $this->_tpl_vars['base_url']; ?>
/<?php echo 'javascript/editor/assetmanager/assetmanager.php?lang=russian\',640,465)";
				
						cat_text.features=["FullScreen","Preview","Print","Search",
							"Cut","Copy","Paste","PasteWord","PasteText","|","Undo","Redo","|",
							"ForeColor","BackColor","|","Bookmark","Hyperlink",
							"XHTMLSource","Numbering","Bullets","|","Indent","Outdent","|","Image","|",
							"Table","Guidelines","Absolute","|","Characters","Line",
							"Clean","ClearAll","BRK",
							"StyleAndFormatting","TextFormatting","ListFormatting","BoxFormatting",
							"ParagraphFormatting","CssText","Styles","|",
							"Paragraph","FontName","FontSize","|",
							"Bold","Italic",
							"Underline","Strikethrough","|","Superscript","Subscript","|",
							"JustifyLeft","JustifyCenter","JustifyRight","JustifyFull"];
				
				
						cat_text.RENDER(\'';  echo ((is_array($_tmp=$this->_tpl_vars['cat']['text'])) ? $this->_run_mod_handler('replace', true, $_tmp, "\r\n", "") : smarty_modifier_replace($_tmp, "\r\n", ""));  echo '\');
	</script>
	'; ?>

	<?php else: ?>
	
	<div class=tag_box>
	<a href="add_tag" onclick="return insert_tag(document.edit_product.small_description,'<b>','</b>')" class=tag_button><b>B</b></a>
	<a href="add_tag" onclick="return insert_tag(document.edit_product.small_description,'<i>','</i>')" class=tag_button><i>I</i></a>
	<a href="add_tag" onclick="return insert_tag(document.edit_product.small_description,'<u>','</u>')" class=tag_button><u>U</u></a>
	<a href="add_tag" onclick="return insert_tag(document.edit_product.small_description,'<img src=>','</img>')" class=tag_button>IMG</a>
	<a href="add_tag" onclick="return insert_tag(document.edit_product.small_description,'<a href=>','</a>')" class=tag_button>URL</a>
	<a href="add_tag" onclick="return insert_tag(document.edit_product.small_description,'<br>','')" class=tag_button>BR</a>
	</div>
	
	<textarea id=cat_text class=field style="width:100%" rows=20><?php echo ((is_array($_tmp=$this->_tpl_vars['cat']['text'])) ? $this->_run_mod_handler('replace', true, $_tmp, "\r\n", "") : smarty_modifier_replace($_tmp, "\r\n", "")); ?>
</textarea>
	
	<?php endif; ?>
	<?php endif; ?>
	<tr>
		<td valign=top class=td1_left>&nbsp;Картинка:</td><td class=td1_right><?php if ($this->_tpl_vars['mode'] == 'edit' && $this->_tpl_vars['cat']['image'] != ''): ?><img src=<?php echo $this->_tpl_vars['base_url']; ?>
/uploaded_files/category_images/medium-<?php echo $this->_tpl_vars['cat']['image']; ?>
><br><input type=checkbox name=delete_image> Удалить картинку<br><br><?php endif; ?><input type=file name=edit_cat_image style="width:500px;" class=field></td>
	</tr>
	
	<tr>
		<td width=15% class=td1_left>&nbsp;Статус:</td>
		<td class=td1_right>
		<select name=edit_cat_status style="width: 500px;" class=field>
			<option value="1" <?php if ($this->_tpl_vars['cat']['status'] == '1'): ?>selected=true<?php endif; ?>>Активный</option>
			<option value="0" <?php if ($this->_tpl_vars['cat']['status'] == '0'): ?>selected=true<?php endif; ?>>Ждёт</option>
		</select>
		</td>
	</tr>
<?php if ($this->_tpl_vars['mode'] == 'edit'): ?>
	<tr>
		<td class="td1_left" valign="top">&nbsp;Свойства товаров:<br>
		</td>
		<td class="td1_right">
        &nbsp;&nbsp;<input type="checkbox" onClick="swith_all(form)" id="switch_all_id"><label for="switch_all_id"> Выделить все</label><br><br>
		<div id=properties_box style="width:500px; height:150px; padding: 8pt 5pt 0pt 5pt; overflow-y: scroll; background:#ffffff;">
			<table width="100%">
				<?php $_from = $this->_tpl_vars['properties']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['tree'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['tree']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['entry']):
        $this->_foreach['tree']['iteration']++;
?>
					<tr>
						<td width="20"><input id="for_switch_<?php echo $this->_tpl_vars['entry']['id']; ?>
" type="checkbox" name="edit_cat_properties[]" value="<?php echo $this->_tpl_vars['entry']['id']; ?>
" <?php if (in_array ( $this->_tpl_vars['entry']['id'] , $this->_tpl_vars['cat']['properties'] )): ?>checked<?php endif; ?>></td>
						<td width="30"><input name="edit_cat_properties_sort_order[<?php echo $this->_tpl_vars['entry']['id']; ?>
]" type="text" size="2" style="font-size: 7pt; padding: 0px; text-align: center" value="<?php if ($this->_tpl_vars['entry']['sort_order'] != 0):  echo $this->_tpl_vars['entry']['sort_order'];  endif; ?>"></td>
						<td>&nbsp;<label for="for_switch_<?php echo $this->_tpl_vars['entry']['id']; ?>
"><?php echo $this->_tpl_vars['entry']['name']; ?>
</label></td>
					</tr>
				<?php endforeach; endif; unset($_from); ?>
			</table>
		</div>
		</td>
	</tr>
<?php endif; ?>
	</table>

<table width=100% class=content_table>
	<tr>
		<th bgcolor=#99CCFF onClick="show('metas', this);" class="button plus" style="border-bottom: none; text-align: left; padding-left: 30px;"><b>Metas</b></th>
	</tr>
 </table>
    <div id="metas" style="display:<?php if ($this->_tpl_vars['cat']['meta_keywords'] != '' || $this->_tpl_vars['cat']['meta_description'] != '' || $this->_tpl_vars['cat']['title']): ?>all<?php else: ?>none<?php endif; ?>;">
<table width=100% class=content_table>
	<tr>
		<td width=15% class=td1_left><b>Title:</b><br><small>(заголовок страницы)</small></td>
		<td class=td1_right><input type=text name=edit_cat_title style="width: 500px;" class=field value="<?php echo $this->_tpl_vars['cat']['title']; ?>
">
	</tr>
	<tr>
		<td width=15% class=td1_left><b>Кeywords:</b><br><small>(ключевые слова)</small></td>
		<td class=td1_right><textarea name=edit_cat_keywords class=field rows="4" style="width: 500px;"><?php echo $this->_tpl_vars['cat']['meta_keywords']; ?>
</textarea></td>
	</tr>

	<tr>
		<td class=td1_left><b>Description:<br><small></b>(описание страницы)</small></td>
		<td class=td1_right><textarea name=edit_cat_description class=field rows="4" style="width: 500px;"><?php echo $this->_tpl_vars['cat']['meta_description']; ?>
</textarea></td>
	</tr>
</table>

</div>

<br>
<center><input type=submit name=<?php if ($this->_tpl_vars['mode'] == 'add'): ?>submit_add_cat value="Добавить раздел"<?php else: ?>submit_edit_cat value="Сохранить изменения"<?php endif; ?>></center>
</form>