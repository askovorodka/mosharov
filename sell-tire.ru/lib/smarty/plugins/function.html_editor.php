<?php


function smarty_function_html_editor($params){

	$str = '';
	$height = '';
	$width = '';
	$type = '';
	$value = '';
	$name = '';

	foreach ($params as $key=>$val){

	 	switch($key){
	 		case 'name': $name = $val; break;
	 		case 'value': $value = $val; break;
	 		case 'type': $type = $val; break;
	 		case 'width': $width = $val; break;
	 		case 'height': $height = $val; break;
	 	}
	}

	if ($width=="") $width="100%";
	if ($height=="") $height="400px";
	else $height=$height."px";

	if ($type == 'html'){

		$str = "
			<div class=tag_box>
			<a href=\"add_tag\" onclick=\"return insert_tag($name,'<b>','</b>')\" class=tag_button><b>B</b></a>
			<a href=\"add_tag\" onclick=\"return insert_tag($name,'<i>','</i>')\" class=tag_button><i>I</i></a>
			<a href=\"add_tag\" onclick=\"return insert_tag($name,'<u>','</u>')\" class=tag_button><u>U</u></a>
			<a href=\"add_tag\" onclick=\"return insert_tag($name,'<img src=>','</img>')\" class=tag_button>IMG</a>
			<a href=\"add_tag\" onclick=\"return insert_tag($name,'<a href=>','</a>')\" class=tag_button>URL</a>
			<a href=\"add_tag\" onclick=\"return insert_tag($name,'<br>','')\" class=tag_button>BR</a>
			</div>

			<textarea name=".$name." style=\"width: ".$width."; height:".$height."\">".$value."</textarea>
		";

	}
	else {

		$str = "
  		<script language=JavaScript>

          	var ".$name." = new InnovaEditor('".$name."');
            $name.btnStyles=true;
            $name.width=\"".$width."\";
            $name.height=\"".$height."\";
            $name.css=\"style.css\";

            $name.cmdAssetManager=\"modalDialogShow('{$base_url}/javascript/editor/assetmanager/assetmanager.php?lang=russian',640,465)\";

            $name.features=[\"FullScreen\",\"Search\",
              \"Cut\",\"Copy\",\"Paste\",\"PasteWord\",\"PasteText\",\"|\",\"Undo\",\"Redo\",\"|\",
              \"ForeColor\",\"BackColor\",\"|\",\"Bookmark\",\"Hyperlink\",
              \"XHTMLSource\",\"Numbering\",\"Bullets\",\"|\",\"Indent\",\"Outdent\",\"|\",\"Image\",\"|\",
              \"Table\",\"Guidelines\",\"Absolute\",\"|\",\"Characters\",\"Line\",
              \"Clean\",\"ClearAll\",\"BRK\",
              \"Paragraph\",\"FontSize\",\"|\",
              \"Bold\",\"Italic\",
              \"Underline\",\"Strikethrough\",\"|\",\"Superscript\",\"Subscript\",\"|\",
              \"JustifyLeft\",\"JustifyCenter\",\"JustifyRight\",\"JustifyFull\",\"|\",\"Tables\",\"Photo\",\"Mail\"];

            $name.RENDER('".str_replace("\r\n", "", $value)."');
            </script>
		";
	}

  return $str;
}
?>