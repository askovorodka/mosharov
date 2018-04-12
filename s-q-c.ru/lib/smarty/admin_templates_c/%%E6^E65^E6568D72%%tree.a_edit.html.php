<?php /* Smarty version 2.6.11, created on 2015-12-05 18:19:25
         compiled from /var/www/sqc//modules/tree/admin/templates/tree.a_edit.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'replace', '/var/www/sqc//modules/tree/admin/templates/tree.a_edit.html', 168, false),)), $this); ?>
<?php if ($this->_tpl_vars['node']['module'] == 'page'):  echo '
<script language=JavaScript src=\'';  echo $this->_tpl_vars['base_url']; ?>
/<?php echo 'javascript/editor/scripts/language/russian/editor_lang.js\'></script>
<script language=JavaScript src=\'';  echo $this->_tpl_vars['base_url']; ?>
/<?php echo 'javascript/editor/scripts'; ?>
/<?php echo $this->_tpl_vars['editor_mode'];  echo '\'></script>
'; ?>



<?php echo '
<script type="text/javascript" src="';  echo $this->_tpl_vars['base_url'];  echo '/javascript/jquery-1.3.2.js"></script>
<script type="text/javascript" src="';  echo $this->_tpl_vars['base_url']; ?>
/<?php echo 'javascript/tinymce/jscripts/tiny_mce/jquery.tinymce.js"></script>
<script language="javascript" type="text/javascript" src="';  echo $this->_tpl_vars['base_url']; ?>
/<?php echo 'javascript/tinymce/jscripts/tiny_mce/plugins/imagemanager/js/mcimagemanager.js"></script>
<script type="text/javascript">
	$().ready(function() {
		$(\'textarea.edit_page_text\').tinymce({
			// Location of TinyMCE script
			script_url : \'';  echo $this->_tpl_vars['base_url']; ?>
/<?php echo 'javascript/tinymce/jscripts/tiny_mce/tiny_mce.js\',

			// General options
			theme : "advanced",
			plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

			// Theme options
			theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,insertimage,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
			theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
			theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,
			file_browser_callback : "mcImageManager.filebrowserCallBack",

			// Example content CSS (should be your site CSS)
			content_css : "css/content.css",

			// Drop lists for link/image/media/template dialogs
			template_external_list_url : "lists/template_list.js",
			external_link_list_url : "lists/link_list.js",
			external_image_list_url : "lists/image_list.js",
			media_external_list_url : "lists/media_list.js",

			// Replace values for the template plugin
			template_replace_values : {
				username : "Some User",
				staffid : "991234"
			}
		});
	});
</script>
<!-- /TinyMCE -->
'; ?>

<?php endif; ?>

<?php echo '
<script language=JavaScript>
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
	if (document.edit_node.edit_node_url.value==\'\') {
		alert("Заполните пожалуйста обязательные поля");
		return false;
	}
	else {
		'; ?>

		<?php if ($this->_tpl_vars['node']['module'] == 'page'): ?>
			<?php if ($this->_tpl_vars['editor_style'] != 'html'):  echo 'document.edit_node.edit_page_text.value = page_text.getHTMLBody();'; ?>

			<?php else: ?>
			<?php echo 'document.edit_node.edit_page_text.value = document.getElementById(\'page_text\').value;'; ?>

			<?php endif; ?>
		<?php endif; ?>
		<?php echo '
		return true;
	}
}
</script>
'; ?>


<?php if ($this->_tpl_vars['error_message']): ?><center><font color=red><b><?php echo $this->_tpl_vars['error_message']; ?>
</b></font></center><br><br><?php endif; ?>

<form action="" method=post name=edit_node onSubmit="return form_check();" enctype="multipart/form-data">
<?php if ($this->_tpl_vars['mode'] != 'edit'):  $_from = $this->_tpl_vars['templates_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['sq'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['sq']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['template']):
        $this->_foreach['sq']['iteration']++;
 if (($this->_foreach['sq']['iteration'] <= 1)): ?>
<input type=hidden name=edit_node_template value="<?php echo $this->_tpl_vars['template']['file']; ?>
">
<?php endif;  endforeach; endif; unset($_from);  endif; ?>
<input type=hidden name=id value=<?php echo $this->_tpl_vars['node']['id']; ?>
>
<input type=hidden name=old_parent value=<?php echo $this->_tpl_vars['parent']; ?>
>
<input type=hidden name=old_url value=<?php echo $this->_tpl_vars['node']['url']; ?>
>
<table width=100% class=content_table>
	<tr bgcolor=#99CCFF>
		<th><?php if ($this->_tpl_vars['mode'] == 'edit'): ?>Редактировать узел<?php else: ?>Добавить узел<?php endif; ?></th>
	</tr>
</table>

<table width=100% class=content_table>
	<tr>
		<td width=15% class=td1_left><b>Категория:</b></td>
		<td class=td1_right>
		<select name=edit_node_parent style="width:100%;font-weight:bold; font-size:9pt;" class=field>
		<?php $_from = $this->_tpl_vars['nodes_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['entry']):
?>
		<option value=<?php echo $this->_tpl_vars['entry']['id'];  if ($this->_tpl_vars['entry']['id'] == $this->_tpl_vars['parent']): ?> selected=true<?php endif; ?>><?php echo $this->_tpl_vars['entry']['full_title']; ?>
</option>
		<?php endforeach; endif; unset($_from); ?>
		</select>
		</td>
	</tr>

	<tr>
		<td width=15% class=td1_left><b>Название:</b></td>
		<td class=td1_right><input type=text name=edit_node_name style="width:100%;" class=field value="<?php echo $this->_tpl_vars['node']['name']; ?>
">
	</tr>

	<tr>
		<td width=15% class=td1_left><b>Заголовок:</b></td>
		<td class=td1_right><input type=text name=edit_node_label style="width:100%;" class=field value="<?php echo $this->_tpl_vars['node']['label']; ?>
">
	</tr>

	<tr>
		<td width=15% class=td1_left><b><font color=red><small>*</small></font>URL:</b></td>
		<td class=td1_right>
		<input type=text name=edit_node_url style="width:100%;" class=field value="<?php echo $this->_tpl_vars['node']['url']; ?>
">
		</td>
	</tr>

	<tr>
		<td width=15% class=td1_left><b>Модуль:</b></td>
		<td class=td1_right>
		<?php if (! $this->_tpl_vars['node']['module']): ?>
			<select name=edit_node_module style="width:50%;" class=field>
			<?php $_from = $this->_tpl_vars['modules']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['entry']):
?>
				<option value=<?php echo $this->_tpl_vars['entry']['name'];  if ($this->_tpl_vars['entry']['name'] == $this->_tpl_vars['node']['module']): ?> selected=true<?php endif; ?>><?php echo $this->_tpl_vars['entry']['title']; ?>
</option>
			<?php endforeach; endif; unset($_from); ?>
			</select>
		<?php else: ?>
			<input type=hidden name=edit_node_module value=<?php echo $this->_tpl_vars['node']['module']; ?>
><?php $_from = $this->_tpl_vars['modules']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['entry']):
 if ($this->_tpl_vars['entry']['name'] == $this->_tpl_vars['node']['module']):  echo $this->_tpl_vars['entry']['title'];  endif;  endforeach; endif; unset($_from); ?>
		<?php endif; ?>
		</td>
	</tr>
</table>

<?php if ($this->_tpl_vars['node']['module'] == 'page'): ?>
<br>
<b>Текст:</b><br>

<textarea name="edit_page_text" class="edit_page_text" style="width:100%; height:600px;"><?php echo ((is_array($_tmp=$this->_tpl_vars['node']['text'])) ? $this->_run_mod_handler('replace', true, $_tmp, "\r\n", "") : smarty_modifier_replace($_tmp, "\r\n", "")); ?>
</textarea>



<br><?php endif;  if ($this->_tpl_vars['mode'] == 'edit'): ?>
<table width=100% class=content_table>

	<tr bgcolor=#99CCFF>
		<th colspan="2" onClick="show('editor', this);" class="button plus" style="border-bottom: none; text-align: left; padding-left: 30px;">Дополнительные настройки</th>
	</tr>
</table>
<div id="editor" style="display: none;">
<table width=100% class=content_table>
<tr>
		<td width=15% class=td1_left><b>Дополнительные модули:</b></td>
		<td class=td1_right>
		<select multiple=multiple size="4" name=edit_node_supmodules[] style="width:50%;" class=field>
		<?php $_from = $this->_tpl_vars['modules_support']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['entry']):
?>
			<option value=<?php echo $this->_tpl_vars['entry']['name'];  if (substr_count ( $this->_tpl_vars['node']['support_modules'] , $this->_tpl_vars['entry']['name'] ) > 0): ?> selected=true<?php endif; ?>><?php echo $this->_tpl_vars['entry']['title']; ?>
</option>
		<?php endforeach; endif; unset($_from); ?>
		</select>
		</td>
	</tr>
	<tr>
		<td width=15% class=td1_left><b>Шаблон страницы:</b></td>
		<td class=td1_right>
		<select name=edit_node_template style="width:50%;" class=field>
		<?php $_from = $this->_tpl_vars['templates_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['template']):
?>
			<option value="<?php echo $this->_tpl_vars['template']['file']; ?>
" <?php if ($this->_tpl_vars['node']['template'] == $this->_tpl_vars['template']['file']): ?>selected=true<?php endif; ?>><?php echo $this->_tpl_vars['template']['name']; ?>
</option>
		<?php endforeach; endif; unset($_from); ?>
		</select>
		</td>
	</tr>
	<tr>
		<td width=15% class=td1_left><b>В меню:</b></td>
		<td class=td1_right><select name=edit_node_menu style="width: 50%;" class=field>
					<option value="1">Показывать</option>
					<option value="0" <?php if ($this->_tpl_vars['node']['in_menu'] == '0'): ?>selected=true<?php endif; ?>>Не показывать</option>
					</select>
		
		</td>
	</tr>
	
		
    <tr>
    <td class=td1_left><strong>Статус:</strong></td>
    <td class=td1_right><select name=edit_node_status style="width: 50%;" class=field>
					<option value="1">Активный</option>
					<option value="0" <?php if ($this->_tpl_vars['node']['status'] == '0'): ?>selected=true<?php endif; ?>>Ждёт</option>
					</select></td>
    </tr>
	<tr>
		<td width=15% class=td1_left><b>Картинка:</b></td>
		<td class=td1_right>
		<input type="hidden" name=edit_node_image_old value="<?php echo $this->_tpl_vars['node']['image']; ?>
">
		<?php if ($this->_tpl_vars['node']['image'] == ""): ?><input type="file" name=edit_node_image style="width:50%;" class=field><?php else: ?>
		<div style="width: 100px; height: 100px; background: url('<?php echo $this->_tpl_vars['base_url']; ?>
/uploaded_files/tree_images/<?php echo $this->_tpl_vars['node']['image']; ?>
') 50% 50% no-repeat; border: 1px solid #ccc;">&nbsp;</div>
		<div>
			<input type="checkbox" name="edit_node_image_delete" id="del_img"><label for="del_img">Удалить картинку</label>
		</div>
		<?php endif; ?>
		</td>
	</tr>
</table>
<?php endif;  if ($this->_tpl_vars['mode'] == 'edit' && $this->_tpl_vars['node']['module'] == 'page'): ?>
<table width=100% class=content_table>
	<tr>
		<td width=15% class=td1_left style="border-bottom: none;"><b>Показывать:</b></td>
		<td class=td1_right   style="border-bottom: none;">
			
            <table width="50%" border="0" cellspacing="0" cellpadding="0">
              <tr>
              	<td>&nbsp;<input type="checkbox" id="doc_01" onClick="shows('documents');" name="edit_node_show_documents" <?php if ($this->_tpl_vars['node']['show_documents'] == '1'): ?>checked<?php endif; ?>></td>
               	<td nowrap><label for="doc_01">Документы</label></td>
                <td>&nbsp;<input type="checkbox" name="edit_node_show_nodes" id="doc_02" <?php if ($this->_tpl_vars['node']['show_nodes'] == '1'): ?>checked<?php endif; ?>></td>
              	<td nowrap><label for="doc_02">Подстраницы</label></td>
              </tr>
            </table>

		</td>
	</tr>
</table>
<div id="documents" style="display:<?php if ($this->_tpl_vars['node']['show_documents'] == '1'): ?>all<?php else: ?>none<?php endif; ?>;">
<table width=100% class=content_table>
<th colspan="2" style="background: #ccc;"><strong>Список документы</strong></th>
	<tr>
		<td width=15% class=td2_left><b>Шаблон:</b></td>
		<td class=td2_right>
			<select name="edit_node_documents_template" style="width:50%;" class=field>
				<?php $_from = $this->_tpl_vars['documents_templates']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
					<option value="<?php echo $this->_tpl_vars['item']; ?>
" <?php if ($this->_tpl_vars['node']['documents_template'] == $this->_tpl_vars['item']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['item']; ?>
</option>
				<?php endforeach; endif; unset($_from); ?>
			</select>

		</td>
	</tr>
	<tr>
		<td width=15% class=td1_left><b>Сортировать по:</b></td>
		<td class=td1_right>
		<select name=edit_node_show_documents_orderby style="width:50%;" class=field>
			<option value="0"></option>
			<?php $_from = $this->_tpl_vars['documents_orderby_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
				<option value="<?php echo $this->_tpl_vars['item']['id']; ?>
" <?php if ($this->_tpl_vars['node']['show_documents_orderby'] == $this->_tpl_vars['item']['id']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['item']['name']; ?>
 (в <?php if ($this->_tpl_vars['item']['orderbysc'] == 'ASC'): ?>прямом<?php else: ?>обратном<?php endif; ?> порядке)</option>
			<?php endforeach; endif; unset($_from); ?>
		</select>
		</td>
	</tr>
	<tr>
		<td width=15% class=td2_left><b>Показать:</b></td>
		<td class=td2_right>
			<input type="text" name="edit_node_show_documents_number" value="<?php echo $this->_tpl_vars['node']['show_documents_number']; ?>
" style="width: 60px;"> документов
		</td>
	</tr>
</table></div><?php endif;  if ($this->_tpl_vars['mode'] == 'edit'): ?></div>
<table width=100% class=content_table>
	<tr>
		<th bgcolor=#99CCFF onClick="show('metas', this);" class="button plus" style="border-bottom: none; text-align: left; padding-left: 30px;"><b>Metas</b></th>
	</tr>
 </table>
    <div id="metas" style="display:<?php if ($this->_tpl_vars['node']['meta_keywords'] != '' || $this->_tpl_vars['node']['meta_description'] != '' || $this->_tpl_vars['node']['title']): ?>all<?php else: ?>none<?php endif; ?>;">
<table width=100% class=content_table>
	<tr>
		<td width=15% class=td1_left><b>Title:</b><br><small>(заголовок страницы)</small></td>
		<td class=td1_right><input type=text name=edit_node_title style="width: 500px;" class=field value="<?php echo $this->_tpl_vars['node']['title']; ?>
">
	</tr>
	<tr>
		<td width=15% class=td1_left><b>Кeywords:</b><br><small>(ключевые слова)</small></td>
		<td class=td1_right><textarea name=edit_node_keywords class=field rows="4" style="width: 500px;"><?php echo $this->_tpl_vars['node']['meta_keywords']; ?>
</textarea></td>
	</tr>

	<tr>
		<td class=td1_left><b>Description:<br><small></b>(описание страницы)</small></td>
		<td class=td1_right><textarea name=edit_node_description class=field rows="4" style="width: 500px;"><?php echo $this->_tpl_vars['node']['meta_description']; ?>
</textarea></td>
	</tr>
</table>

</div>
<table width=100% class=content_table>
	<tr>
		<th bgcolor=#99CCFF onClick="show('access', this);" class="button plus" style="text-align: left; padding-left: 30px;"><b>Права доступа</b></th>
	</tr>
</table>

<div id="access" style="display:none;">
<table width=100% class=content_table>
	<tr>
		<td width=15% class=td1_left></td>
		<td class=td1_right>
		<input type="hidden" name="users_list" id="users_list" value="<?php echo $this->_tpl_vars['users_checked']; ?>
">
		<b>Права доступа на просмотр:</b><br><br>
		<small><font color=#666666>Если права для чтения на родительский раздел ограничены, они автоматически распространяются на дочерние разделы.</font></small><br><br>
		<input type=radio name=access_to value="all" <?php if ($this->_tpl_vars['access_mode'] == 'all'): ?>checked=true<?php endif; ?> id="joi_01"> <label for="joi_01">Доступен для всех</label><br>
		<input type=radio name=access_to value="registered" <?php if ($this->_tpl_vars['access_mode'] == 'registered'): ?>checked=true<?php endif; ?> id="joi_02"> <label for="joi_02">Только для зарегестрированных</label><br>
		<input type=radio name=access_to value="list" <?php if ($this->_tpl_vars['access_mode'] == 'list'): ?>checked=true<?php endif; ?> id="joi_03"> <label for="joi_03">Доступен только для</label>&nbsp;<a href="javascript: void(getTreeTools(<?php echo $_GET['id']; ?>
));">редактировать</a>&nbsp;<span id="label"></span><br>
		</td>
	</tr>
</table>
</div>
<?php endif; ?>
<br><br>
<center><input type=submit <?php if ($this->_tpl_vars['mode'] == 'edit'): ?>name=submit_edit_node value="Сохранить изменения"<?php else: ?>name=submit_add_node value="Добавить узел"<?php endif; ?> class=button style="width:50%;"></center>
</form>




