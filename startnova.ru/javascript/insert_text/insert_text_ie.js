function insert_tag(textarea,startTag,endTag) {
	textarea.focus();
	var r=document.selection.createRange();
	r.text = startTag + r.text + endTag;
	r.select();
	
	return false;
}