{literal}
<script language=JavaScript src='{/literal}{$base_url}/{literal}javascript/editor/scripts/language/russian/editor_lang.js'></script>
<script language=JavaScript src='{/literal}{$base_url}/{literal}javascript/editor/scripts{/literal}/{$editor_mode}{literal}'></script>

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
		document.getElementById('nav_' + name).style.display="";
	}
	else {
		document.getElementById(name).style.display="";
		document.getElementById('nav_' + name).style.display="none";
	}
}
</script>
{/literal}


<form action="" method=post name=edit_product enctype="multipart/form-data" onSubmit="check_form();">
<input type=hidden name=id value={$product.id}>
<input type=hidden name=type value=office>
<center>
{if $error}<font color=red><b>{$error}</b></font><br><br>{/if}
<table width=100% class=content_table>
<tr>
<th>{if $mode=='edit'}Редактировать {if $product.type=='office'}офис{else}квартиру{/if}{else}Добавить {if $smarty.get.type=='office'}офис{else}квартиру{/if}{/if}</th>
</tr>
</table>


<table width=100% class=content_table>
<tr>
	<td width=15% class=td1_left>Раздел:</td>
	<td class=td1_right>
		<select name=edit_parent class=field style="width:100%;">
		{foreach from=$cat_list item=entry}
			<option value={$entry.id}{if $entry.id==$product.parent or $entry.id==$smarty.get.cat} selected=true{/if}>{$entry.full_title}</option>
		{/foreach}
		</select>	</td>
</tr>
<tr>
	<td class=td1_left>Название:</td><td class=td1_right><input type=text name=edit_name class=field style="width:100%;" value="{$product.name}"></td>
</tr>

<tr>
	<td class=td1_left>Ссылка:</td><td class=td1_right><input type=text name=site_url class=field style="width:100%;" value="{$product.site_url}"></td>
</tr>

<tr>
	<td class=td1_left>Доп.текст:</td><td class=td1_right><input type=text name=small_text class=field style="width:100%;" value="{$product.small_text}"></td>
</tr>

{if $mode=='edit'}
<tr>
  <td class=td1_left style="border-bottom: none;">Статус:</td>
  <td class=td1_right style="border-bottom: none;">
  
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="35%"><select name=edit_status style="width:200px;" class=field>
		<option value="1" {if $product.status=='1'}selected=true{/if}>Активный</option>
		<option value="0" {if $product.status=='0'}selected=true{/if}>Ждёт</option>
	</select>	</td>
  </tr>
</table>

  </td>
</tr>
{/if}


<tr>
<td class=td1_single colspan=2>

<input type=hidden name=edit_description value="">
<p><font color=red>*</font> Описание:</p>
{literal}
<script language="JavaScript">
				var edit_description = new InnovaEditor("edit_description");

				edit_description.btnStyles=true;

				edit_description.width="100%";
				edit_description.height="400";

				edit_description.css="style.css";
				edit_description.cmdAssetManager="modalDialogShow('{/literal}{$base_url}/{literal}javascript/editor/assetmanager/assetmanager.php?lang=russian',640,465)";

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


				edit_description.RENDER('{/literal}{$product.description|replace:"\r\n":""}{literal}');
</script>
{/literal}
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
		<td class=td2_right><input type=text name=edit_title class=field style="width:100%;" value="{$product.title}"></td>
	</tr>
	<tr>
		<td width=15% class=td2_left><b>Keywords:</b><br><small>(meta keywords)</small></td>
		<td class=td2_right><input type=text name=edit_meta_keywords class=field style="width:100%;" value="{$product.meta_keywords}"></td>
	</tr>
	<tr>
		<td width=15% class=td2_left><b>Description:</b><br><small>(meta description)</small></td>
		<td class=td2_right><input type=text name=edit_meta_description class=field style="width:100%;" value="{$product.meta_description}"></td>
	</tr>
</table>
</div>


<br><br>
<center><input type=submit name={if $mode=='edit'}submit_edit_product value="Сохранить изменения"{else}submit_add_product value="Добавить офис"{/if} class=button></center>
</form>
