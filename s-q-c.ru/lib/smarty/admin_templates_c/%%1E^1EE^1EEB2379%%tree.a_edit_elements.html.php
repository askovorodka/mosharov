<?php /* Smarty version 2.6.11, created on 2015-12-05 18:19:34
         compiled from /var/www/sqc//modules/tree/admin/templates/tree.a_edit_elements.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'regex_replace', '/var/www/sqc//modules/tree/admin/templates/tree.a_edit_elements.html', 68, false),)), $this); ?>
<?php $this->assign('editor_mode', "editor.js");  $this->assign('editor_style', 'html');  echo '
<script language=JavaScript src=\'';  echo $this->_tpl_vars['base_url'];  echo '/javascript/editor/scripts/language/russian/editor_lang.js\'></script>
<script language=JavaScript src=\'';  echo $this->_tpl_vars['base_url'];  echo '/javascript/editor/scripts'; ?>
/<?php echo $this->_tpl_vars['editor_mode'];  echo '\'></script>

<script language="Javascript">
function check_form() {
	'; ?>

	<?php if ($this->_tpl_vars['editor_style'] != 'html'): ?>
	<?php echo '
		document.edit_elements.edit_elements.value = edit_elements_text.getHTMLBody();
	'; ?>

	<?php else: ?>
	<?php echo '
		document.edit_elements.edit_elements.value = document.getElementById(\'edit_elements_text\').value;
	'; ?>

	<?php endif; ?>
	<?php echo '
	return true;
}
</script>
'; ?>


<?php if ($this->_tpl_vars['error_message']): ?><center><font color=red><b><?php echo $this->_tpl_vars['error_message']; ?>
</b></font></center><br><br><?php endif; ?>
	
<form action="" method=post name=edit_elements onSubmit="return check_form();">
<input type=hidden name=id value=<?php echo $this->_tpl_vars['node']['id']; ?>
>

<table width=100% cellpadding=3 cellspacing=1>
	<tr bgcolor=#99CCFF>
		<td width=20%><b>Редактировать шаблон узла</b></td>
	</tr>
</table>

Узел: <?php echo $this->_tpl_vars['node']['name']; ?>

<br><br>
Элементы:<br>

	<input type=hidden name=edit_elements value="">
<?php if ($this->_tpl_vars['editor_style'] != 'html'):  echo '
<script>
				var edit_elements_text = new InnovaEditor("edit_elements_text");
			
					edit_elements_text.btnStyles=true;

					edit_elements_text.width="100%";
					edit_elements_text.height="400";

					edit_elements_text.css="style.css";
					edit_elements_text.cmdAssetManager="modalDialogShow(\'';  echo $this->_tpl_vars['base_url'];  echo '/javascript/editor/assetmanager/assetmanager.php?lang=russian\',640,465)";
			
					edit_elements_text.features=["FullScreen","Preview","Print","Search",
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
						"JustifyLeft","JustifyCenter","JustifyRight","JustifyFull","|","Tables","Photo","Mail"];
			
			
				edit_elements_text.RENDER(\'';  echo ((is_array($_tmp=$this->_tpl_vars['node']['elements'])) ? $this->_run_mod_handler('regex_replace', true, $_tmp, "/[\r\t\n]/", ' ') : smarty_modifier_regex_replace($_tmp, "/[\r\t\n]/", ' '));  echo '\');
			</script>
'; ?>

<?php else: ?>

<div class=tag_box>
<a href="add_tag" onclick="return insert_tag(document.edit_elements.edit_elements_text,'<b>','</b>')" class=tag_button><b>B</b></a>
<a href="add_tag" onclick="return insert_tag(document.edit_elements.edit_elements_text,'<i>','</i>')" class=tag_button><i>I</i></a>
<a href="add_tag" onclick="return insert_tag(document.edit_elements.edit_elements_text,'<u>','</u>')" class=tag_button><u>U</u></a>
<a href="add_tag" onclick="return insert_tag(document.edit_elements.edit_elements_text,'<img src=>','</img>')" class=tag_button>IMG</a>
<a href="add_tag" onclick="return insert_tag(document.edit_elements.edit_elements_text,'<a href=>','</a>')" class=tag_button>URL</a>
<a href="add_tag" onclick="return insert_tag(document.edit_elements.edit_elements_text,'<br>','')" class=tag_button>BR</a>
</div>

<textarea id=edit_elements_text class=field style="width:100%" rows=20><?php echo $this->_tpl_vars['node']['elements']; ?>
</textarea>

<?php endif; ?>
<input type=checkbox name=default_elements id="ch_load"><label for="ch_load"> Загрузить шаблон по умолчанию.</label>
<input type=hidden name=submit_edit_elements value="go">
<br><br>
<center><input type=submit name=submit_edit_elements value="Сохранить изменения" class=button style="width:50%;"></center>
</form>