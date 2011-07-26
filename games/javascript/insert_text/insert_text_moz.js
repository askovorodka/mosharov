function pnhGetSelectionStart(element) {
	var startpos = 0;
	startpos = element.selectionStart;
	return startpos;
}

function pnhGetSelectionEnd(element) {
	var endpos = 0;
	endpos = element.selectionEnd;
	return endpos;

}

function pnhSetSelectionStart(element,newposition) {
	element.selectionStart = newposition;
}


function pnhSetSelectionEnd(element,newposition) {
	element.selectionEnd = newposition;
}

function pnhSetSelection(element,newstart,newend) {
	pnhSetSelectionStart(element,newstart);
	pnhSetSelectionEnd(element,newend);
}

function pnhStringInsert(DOMEle,newtext,newpos) {
	DOMEle.value=DOMEle.value.slice(0,newpos)+newtext+DOMEle.value.slice(newpos);
}


function insert_tag(textarea,startTag,endTag) {
	var ta = textarea;
	
	var firstPos = pnhGetSelectionStart(ta);
	var secondPos = pnhGetSelectionEnd(ta)+startTag.length;
	pnhStringInsert(ta,startTag,firstPos);
	pnhStringInsert(ta,endTag,secondPos);

	pnhSetSelectionStart(ta,firstPos+startTag.length);
	pnhSetSelectionEnd(ta,secondPos);
	ta.focus();
	
	return false;
}