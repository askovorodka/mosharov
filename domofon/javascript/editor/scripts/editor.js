/***********************************************************
InnovaStudio WYSIWYG Editor 2.2
Copyright © 2003-2005, INNOVA STUDIO (www.InnovaStudio.com). All rights reserved.
************************************************************/

/*** UTILITY OBJECT ***/
var oUtil=new InnovaEditorUtil();
function InnovaEditorUtil()
	{
	/*** Localization ***/
	this.langDir="english";
	try{if(LanguageDirectory)this.langDir=LanguageDirectory;}catch(e){;}
	var oScripts=document.getElementsByTagName("script");
	for(var i=0;i<oScripts.length;i++)
		{
		var sSrc=oScripts[i].src.toLowerCase();
		if(sSrc.indexOf("scripts/editor.js")!=-1) this.scriptPath=oScripts[i].src.replace(/editor.js/ig,"");
		}
	this.scriptPathLang=this.scriptPath+"language/"+this.langDir+"/";
	if(this.langDir=="english")
		document.write("<scr"+"ipt src='"+this.scriptPathLang+"editor_lang.js'></scr"+"ipt>");
	/*** /Localization ***/

	this.oName;this.oEditor;this.obj;
	this.oSel;
	this.sType;
	this.bInside=bInside;
	this.useSelection=true;
	this.arrEditor=[];
	this.onSelectionChanged=function(){return true;};
	this.activeElement;
	}

/*** FOCUS STUFF ***/
function bInside(oElement)
	{
	while(oElement!=null)
		{
		if(oElement.contentEditable=="true")return true;
		oElement=oElement.parentElement;
		}
	return false;
	}
function checkFocus()
	{
	var oEditor=eval("idContent"+this.oName);
	var oSel=oEditor.document.selection.createRange();
	var sType=oEditor.document.selection.type;

	if(oSel.parentElement!=null)
		{
		if(!bInside(oSel.parentElement()))return false;
		}
	else
		{
		if(!bInside(oSel.item(0)))return false;
		}
	return true;
	}
function iwe_focus()
	{
	var oEditor=eval("idContent"+this.oName);
	oEditor.focus()
	}

/*********************
	EDITOR OBJECT
**********************/
function InnovaEditor(oName)
	{
	this.oName=oName;
	this.RENDER=RENDER;
	this.IsSecurityRestricted=false;

	this.loadHTML=loadHTML;
	this.getHTMLBody=getHTMLBody;
	this.getXHTMLBody=getXHTMLBody;
	this.getHTML=getHTML;
	this.getXHTML=getXHTML;
	this.putHTML=putHTML;//source dialog
	this.css="";
	this.initialRefresh=false;

	this.bInside=bInside;
	this.checkFocus=checkFocus;
	this.focus=iwe_focus;

	this.doCmd=doCmd;
	this.applyParagraph=applyParagraph;
	this.applyFontName=applyFontName;
	this.applyFontSize=applyFontSize;
	this.applyBullets=applyBullets;
	this.applyNumbering=applyNumbering;
	this.applyJustifyLeft=applyJustifyLeft;
	this.applyJustifyCenter=applyJustifyCenter;
	this.applyJustifyRight=applyJustifyRight;
	this.applyJustifyFull=applyJustifyFull;
	this.applyBlockDirLTR=applyBlockDirLTR;
	this.applyBlockDirRTL=applyBlockDirRTL;
	this.doPaste=doPaste;
	this.doPasteText=doPasteText;
	this.applySpan=applySpan;
	this.makeAbsolute=makeAbsolute;
	this.insertHTML=insertHTML;
	this.clearAll=clearAll;
	this.spellcheckDialogShow=spellcheckDialogShow;
	this.insertCustomTag=insertCustomTag;
	this.selectParagraph=selectParagraph;
	this.doOnPaste=doOnPaste;
	this.isAfterPaste=false;
	this.doClean=doClean;

	this.hide=hide;
	this.dropShow=dropShow;

	this.width="663";
	this.height="250";
	this.publishingPath="";//ex."http://localhost/InnovaStudio/"

	var oScripts=document.getElementsByTagName("script");
	for(var i=0;i<oScripts.length;i++)
		{
		var sSrc=oScripts[i].src.toLowerCase();
		if(sSrc.indexOf("scripts/editor.js")!=-1) this.scriptPath=sSrc.replace(/editor.js/,"");
		}

	this.iconPath="icons/";
	this.iconWidth=25;this.iconHeight=24;
	this.writeIconToggle=writeIconToggle;
	this.writeIconStandard=writeIconStandard;
	this.writeDropDown=writeDropDown;
	this.writeBreakSpace=writeBreakSpace;
	this.dropTopAdjustment=1;

	this.runtimeBorder=runtimeBorder;
	this.runtimeBorderOn=runtimeBorderOn;
	this.runtimeBorderOff=runtimeBorderOff;
	this.IsRuntimeBorderOn=true;
	this.runtimeStyles=runtimeStyles;

	this.applyColor=applyColor;
	this.customColors=[];//["#ff4500","#ffa500","#808000","#4682b4","#1e90ff","#9400d3","#ff1493","#a9a9a9"];
	this.oColor1 = new ColorPicker("oColor1",this.oName);//to call: oEdit1.oColor1
	this.oColor2 = new ColorPicker("oColor2",this.oName);//rendered id: ...oColor1oEdit1
	this.expandSelection=expandSelection;

	this.fullScreen=fullScreen;
	this.stateFullScreen=false;
	this.onFullScreen=function(){return true;};
	this.onNormalScreen=function(){return true;};

	this.arrElm=new Array(300);
	this.getElm=iwe_getElm;

	this.features=[];
	this.buttonMap=["Save","FullScreen","Preview","Print","Search","SpellCheck","|",
			"Cut","Copy","Paste","PasteWord","PasteText","|","Undo","Redo","|",
			"ForeColor","BackColor","|","Bookmark","Hyperlink",
			"CustomTag","Image","Flash","Media","ContentBlock","InternalLink","CustomObject","|",
			"Table","Guidelines","Absolute","|","Characters","Line",
			"Form","Clean","HTMLFullSource","HTMLSource","XHTMLFullSource",
			"XHTMLSource","ClearAll","BRK",
			"StyleAndFormatting","|","Paragraph","FontName","FontSize","|",
			"Bold","Italic","Underline","Strikethrough","Superscript","Subscript","|",
			"JustifyLeft","JustifyCenter","JustifyRight","JustifyFull","|",
			"Numbering","Bullets","|","Indent","Outdent","LTR","RTL","|","Tables","Photo","Mail"];//complete, default

	this.btnSave=false;this.btnPreview=true;this.btnFullScreen=true;this.btnPrint=false;this.btnSearch=true;
	this.btnSpellCheck=false;this.btnTextFormatting=true;
	this.btnListFormatting=true;this.btnBoxFormatting=true;this.btnParagraphFormatting=true;this.btnCssText=true;
	this.btnStyles=false;this.btnParagraph=true;this.btnFontName=true;this.btnFontSize=true;
	this.btnCut=true;this.btnCopy=true;this.btnPaste=true;this.btnPasteText=false;this.btnUndo=true;this.btnRedo=true;
	this.btnBold=true;this.btnItalic=true;this.btnUnderline=true;
	this.btnStrikethrough=false;this.btnSuperscript=false;this.btnSubscript=false;
	this.btnJustifyLeft=true;this.btnJustifyCenter=true;this.btnJustifyRight=true;this.btnJustifyFull=true;
	this.btnNumbering=true;this.btnBullets=true;this.btnIndent=true;this.btnOutdent=true;
	this.btnLTR=false;this.btnRTL=false;this.btnForeColor=true;this.btnBackColor=true;
	this.btnHyperlink=true;this.btnBookmark=true;this.btnCharacters=true;this.btnCustomTag=false;
	this.btnImage=true;this.btnFlash=false;this.btnMedia=false;
	this.btnTable=true;this.btnGuidelines=true;
	this.btnAbsolute=true;this.btnPasteWord=true;this.btnLine=true;
	this.btnForm=true;this.btnClean=true;
	this.btnHTMLFullSource=false;this.btnHTMLSource=false;
	this.btnXHTMLFullSource=false;this.btnXHTMLSource=true;
	this.btnClearAll=false;

	//*** CMS Features ***
	this.cmdAssetManager="";

	this.btnContentBlock=false;
	this.cmdContentBlock=";";//needs ;
	this.btnInternalLink=false;
	this.cmdInternalLink=";";//needs ;
	this.insertLink=insertLink;
	this.btnCustomObject=false;
	this.cmdCustomObject=";";//needs ;
	//*****

	this.arrStyle=[];
	this.onCustomCssShow = new Function("modelessDialogShow('"+this.scriptPath+"styles_cssText.htm',360,380)");
	this.addonCSSBuilder=addonCSSBuilder;

	this.arrParagraph=[[getText("Heading 1"),"H1"],
						[getText("Heading 2"),"H2"],
						[getText("Heading 3"),"H3"],
						[getText("Heading 4"),"H4"],
						[getText("Heading 5"),"H5"],
						[getText("Heading 6"),"H6"],
						[getText("Preformatted"),"PRE"],
						[getText("Normal (P)"),"P"],
						[getText("Normal (DIV)"),"DIV"]];

	this.arrFontName=["Arial","Arial Black","Arial Narrow",
						"Book Antiqua","Bookman Old Style",
						"Century Gothic","Comic Sans MS","Courier New",
						"Franklin Gothic Medium","Garamond","Georgia",
						"Impact","Lucida Console","Lucida Sans","Lucida Unicode",
						"Modern","Monotype Corsiva","Palatino Linotype",
						"Roman","Script","Small Fonts","Symbol",
						"Tahoma","Times New Roman","Trebuchet MS",
						"Verdana","Webdings","Wingdings","Wingdings 2","Wingdings 3",
						"serif","sans-serif","cursive","fantasy","monoscape"];

	this.arrFontSize=[[getText("Size 1"),"1"],
						[getText("Size 2"),"2"],
						[getText("Size 3"),"3"],
						[getText("Size 4"),"4"],
						[getText("Size 5"),"5"],
						[getText("Size 6"),"6"],
						[getText("Size 7"),"7"]];

	this.arrCustomTag=[];//eg.[["Full Name","{%full_name%}"],["Email","{%email%}"]];

	this.docType="";
	this.html="<html>";
	this.headContent="";
	this.preloadHTML="";

	this.onSave=function(){return true;};
	this.useBR=false;
	this.useDIV=true;

	this.doUndo=doUndo;
	this.doRedo=doRedo;
	this.saveForUndo=saveForUndo;
	this.arrUndoList=[];
	this.arrRedoList=[];

	this.useTagSelector=true;
	this.TagSelectorPosition="bottom";
	this.moveTagSelector=moveTagSelector;
	this.selectElement=selectElement;
	this.removeTag=removeTag;
	this.doClick_TabCreate=doClick_TabCreate;
	this.doRefresh_TabCreate=doRefresh_TabCreate;

	this.arrCustomButtons = [["CustomName1","alert(0)","caption here","btnSave.gif"],
							["CustomName2","alert(0)","caption here","btnSave.gif"]];

	this.onSelectionChanged=function(){return true;};
	}

/*********************
	ADD-ONS
**********************/
function addonCSSBuilder(bEnabled)
	{
	if(bEnabled)
		this.onCustomCssShow = new Function("modelessDialogShow('"+this.scriptPath+"styles_cssText2.htm',430,462)");
	else
		this.onCustomCssShow = new Function("modelessDialogShow('"+this.scriptPath+"styles_cssText.htm',360,380)");
	}

/*********************
	UNDO/REDO
**********************/
function saveForUndo()
	{
	var oEditor=eval("idContent"+this.oName);
	var obj=eval(this.oName);
	if(obj.arrUndoList[0])
		if(oEditor.document.body.innerHTML==obj.arrUndoList[0][0])return;
	for(var i=20;i>1;i--)obj.arrUndoList[i-1]=obj.arrUndoList[i-2];
	obj.focus();
	var oSel=oEditor.document.selection.createRange();
	var sType=oEditor.document.selection.type;

	if(sType=="None")
		obj.arrUndoList[0]=[oEditor.document.body.innerHTML,
			oEditor.document.selection.createRange().getBookmark(),"None"];
	else if(sType=="Text")
		obj.arrUndoList[0]=[oEditor.document.body.innerHTML,
			oEditor.document.selection.createRange().getBookmark(),"Text"];
	else if(sType=="Control")
		{
		oSel.item(0).selThis="selThis";
		obj.arrUndoList[0]=[oEditor.document.body.innerHTML,null,"Control"];
		oSel.item(0).removeAttribute("selThis",0);
		}
	this.arrRedoList=[];//clear redo list

	if(this.btnUndo) makeEnableNormal(eval("document.all.btnUndo"+this.oName));
	if(this.btnRedo) makeDisabled(eval("document.all.btnRedo"+this.oName));
	}
function doUndo()
	{
	var oEditor=eval("idContent"+this.oName);
	var obj=eval(this.oName);
	if(!obj.arrUndoList[0])return;
	//~~~~
	for(var i=20;i>1;i--)obj.arrRedoList[i-1]=obj.arrRedoList[i-2];
	var oSel=oEditor.document.selection.createRange();
	var sType=oEditor.document.selection.type;
	if(sType=="None")
		this.arrRedoList[0]=[oEditor.document.body.innerHTML,
			oEditor.document.selection.createRange().getBookmark(),"None"];
	else if(sType=="Text")
		this.arrRedoList[0]=[oEditor.document.body.innerHTML,
			oEditor.document.selection.createRange().getBookmark(),"Text"];
	else if(sType=="Control")
		{
		oSel.item(0).selThis="selThis";
		this.arrRedoList[0]=[oEditor.document.body.innerHTML,null,"Control"];
		oSel.item(0).removeAttribute("selThis",0);
		}
	//~~~~
	sHTML=obj.arrUndoList[0][0];
	var arrA = String(sHTML).match(/<A[^>]*>/ig);
	if(arrA)
		for(var i=0;i<arrA.length;i++)
			{
			sTmp = arrA[i].replace(/href=/,"href_iwe=");
			sHTML=String(sHTML).replace(arrA[i],sTmp);
			}
	var arrB = String(sHTML).match(/<IMG[^>]*>/ig);
	if(arrB)
		for(var i=0;i<arrB.length;i++)
			{
			sTmp = arrB[i].replace(/src=/,"src_iwe=");
			sHTML=String(sHTML).replace(arrB[i],sTmp);
			}
	var arrC = String(sHTML).match(/<AREA[^>]*>/ig);
	if(arrC)
		for(var i=0;i<arrC.length;i++)
			{
			sTmp = arrC[i].replace(/href=/,"href_iwe=");
			sHTML=String(sHTML).replace(arrC[i],sTmp);
			}
	oEditor.document.body.innerHTML=sHTML;
	for(var i=0;i<oEditor.document.all.length;i++)
		{
		if(oEditor.document.all[i].getAttribute("href_iwe"))
			{
			oEditor.document.all[i].href=oEditor.document.all[i].getAttribute("href_iwe");
			oEditor.document.all[i].removeAttribute("href_iwe",0);
			}
		if(oEditor.document.all[i].getAttribute("src_iwe"))
			{
			oEditor.document.all[i].src=oEditor.document.all[i].getAttribute("src_iwe");
			oEditor.document.all[i].removeAttribute("src_iwe",0);
			}
		}
	//*** RUNTIME STYLES ***
	this.runtimeBorder(false);
	this.runtimeStyles();
	//***********************
	var oRange=oEditor.document.body.createTextRange();
	if(obj.arrUndoList[0][2]=="None")
		{
		oRange.moveToBookmark(obj.arrUndoList[0][1]);
		oRange.select(); //di-disable, spy tdk select all? tdk perlu utk undo
		}
	else if(obj.arrUndoList[0][2]=="Text")
		{
		oRange.moveToBookmark(obj.arrUndoList[0][1]);
		oRange.select();
		}
	else if(obj.arrUndoList[0][2]=="Control")
		{
		for(var i=0;i<oEditor.document.all.length;i++)
			{
			if(oEditor.document.all[i].selThis=="selThis")
				{
				var oSelRange=oEditor.document.body.createControlRange();
				oSelRange.add(oEditor.document.all[i]);
				oSelRange.select();
				oEditor.document.all[i].removeAttribute("selThis",0);
				}
			}
		}
	//~~~~
	for(var i=0;i<19;i++)obj.arrUndoList[i]=obj.arrUndoList[i+1];
	obj.arrUndoList[19]=null;
	realTime(this.oName);
	}
function doRedo()
	{
	var oEditor=eval("idContent"+this.oName);
	var obj=eval(this.oName);
	if(!obj.arrRedoList[0])return;
	//~~~~
	for(var i=20;i>1;i--)obj.arrUndoList[i-1]=obj.arrUndoList[i-2];
	var oSel=oEditor.document.selection.createRange();
	var sType=oEditor.document.selection.type;
	if(sType=="None")
		obj.arrUndoList[0]=[oEditor.document.body.innerHTML,
			oEditor.document.selection.createRange().getBookmark(),"None"];
	else if(sType=="Text")
		obj.arrUndoList[0]=[oEditor.document.body.innerHTML,
			oEditor.document.selection.createRange().getBookmark(),"Text"];
	else if(sType=="Control")
		{
		oSel.item(0).selThis="selThis";
		this.arrUndoList[0]=[oEditor.document.body.innerHTML,null,"Control"];
		oSel.item(0).removeAttribute("selThis",0);
		}
	//~~~~
	sHTML=obj.arrRedoList[0][0];
	var arrA = String(sHTML).match(/<A[^>]*>/ig);
	if(arrA)
		for(var i=0;i<arrA.length;i++)
			{
			sTmp = arrA[i].replace(/href=/,"href_iwe=");
			sHTML=String(sHTML).replace(arrA[i],sTmp);
			}
	var arrB = String(sHTML).match(/<IMG[^>]*>/ig);
	if(arrB)
		for(var i=0;i<arrB.length;i++)
			{
			sTmp = arrB[i].replace(/src=/,"src_iwe=");
			sHTML=String(sHTML).replace(arrB[i],sTmp);
			}
	var arrC = String(sHTML).match(/<AREA[^>]*>/ig);
	if(arrC)
		for(var i=0;i<arrC.length;i++)
			{
			sTmp = arrC[i].replace(/href=/,"href_iwe=");
			sHTML=String(sHTML).replace(arrC[i],sTmp);
			}
	oEditor.document.body.innerHTML=sHTML;
	for(var i=0;i<oEditor.document.all.length;i++)
		{
		if(oEditor.document.all[i].getAttribute("href_iwe"))
			{
			oEditor.document.all[i].href=oEditor.document.all[i].getAttribute("href_iwe");
			oEditor.document.all[i].removeAttribute("href_iwe",0);
			}
		if(oEditor.document.all[i].getAttribute("src_iwe"))
			{
			oEditor.document.all[i].src=oEditor.document.all[i].getAttribute("src_iwe");
			oEditor.document.all[i].removeAttribute("src_iwe",0);
			}
		}
	//*** RUNTIME STYLES ***
	this.runtimeBorder(false);
	this.runtimeStyles();
	//***********************
	var oRange=oEditor.document.body.createTextRange();
	if(obj.arrRedoList[0][2]=="None")
		{
		oRange.moveToBookmark(obj.arrRedoList[0][1]);
		//oRange.select(); //di-disable, sph tdk select all, utk redo perlu
		}
	else if(obj.arrRedoList[0][2]=="Text")
		{
		oRange.moveToBookmark(obj.arrRedoList[0][1]);
		oRange.select();
		}
	else if(obj.arrRedoList[0][2]=="Control")
		{
		for(var i=0;i<oEditor.document.all.length;i++)
			{
			if(oEditor.document.all[i].selThis=="selThis")
				{
				var oSelRange = oEditor.document.body.createControlRange();
				oSelRange.add(oEditor.document.all[i]);
				oSelRange.select();
				oEditor.document.all[i].removeAttribute("selThis",0);
				}
			}
		}
	//~~~~
	for(var i=0;i<19;i++)obj.arrRedoList[i]=obj.arrRedoList[i+1];
	obj.arrRedoList[19]=null;
	realTime(this.oName);
	}

/*********************
	RENDER
**********************/
function RENDER(sPreloadHTML)
	{
	/*** Tetap Ada (For downgrade compatibility) ***/
	if(sPreloadHTML.substring(0,4)=="<!--" &&
		sPreloadHTML.substring(sPreloadHTML.length-3)=="-->")
		sPreloadHTML=sPreloadHTML.substring(4,sPreloadHTML.length-3);

	if(sPreloadHTML.substring(0,4)=="<!--" &&
		sPreloadHTML.substring(sPreloadHTML.length-6)=="--&gt;")
		sPreloadHTML=sPreloadHTML.substring(4,sPreloadHTML.length-6);

	/*** Converting back HTML-encoded content (kalau tdk encoded tdk masalah) ***/
	sPreloadHTML=sPreloadHTML.replace(/&lt;/g,"<");
	sPreloadHTML=sPreloadHTML.replace(/&gt;/g,">");
	sPreloadHTML=sPreloadHTML.replace(/&amp;/g,"&");
	sPreloadHTML=sPreloadHTML.replace(/&quot;/g,"\"");

	/*** features ***/
	var bUseFeature=false;
	if(this.features.length>0)
		{
		bUseFeature=true;
		for(var i=0;i<this.buttonMap.length;i++)
			eval(this.oName+".btn"+this.buttonMap[i]+"=true");//ex: oEdit1.btnStyleAndFormatting=true (no problem), oEdit1.btn|=true (no problem), oEdit1.btnBRK=true (no problem)

		this.btnTextFormatting=false;this.btnListFormatting=false;
		this.btnBoxFormatting=false;this.btnParagraphFormatting=false;
		this.btnCssText=false;this.btnStyles=false;
		for(var j=0;j<this.features.length;j++)
			eval(this.oName+".btn"+this.features[j]+"=true");//ex: oEdit1.btnTextFormatting=true

		for(var i=0;i<this.buttonMap.length;i++)
			{
			sButtonName=this.buttonMap[i];
			bBtnExists=false;
			for(var j=0;j<this.features.length;j++)
				if(sButtonName==this.features[j])bBtnExists=true;//ada;

			if(!bBtnExists)//tdk ada; set false
				eval(this.oName+".btn"+sButtonName+"=false");//ex: oEdit1.btnBold=false, oEdit1.btn|=false (no problem), oEdit1.btnBRK=false (no problem)
			}
		//Remove:"TextFormatting","ListFormatting",dst.=>tdk perlu(krn diabaikan)
		this.buttonMap=this.features;
		}
	/*** /features ***/

	this.preloadHTML=sPreloadHTML;
	var sHTMLDropMenus="";
	var sHTMLIcons="";
	var sTmp="";

	for(var i=0;i<this.buttonMap.length;i++)
		{
		sButtonName=this.buttonMap[i];
		switch(sButtonName)
			{
			case "|":
				sHTMLIcons+=this.writeBreakSpace();
				break;
			case "BRK":
				sHTMLIcons+="</td></tr></table><table cellpadding=0 cellspacing=0><tr><td dir=ltr>";
				break;
			case "Save":
				if(this.btnSave)sHTMLIcons+=this.writeIconStandard("btnSave"+this.oName,this.oName+".onSave()","btnSave.gif",getText("Save"));
				break;
			case "Preview":
				if(this.btnPreview)
					{
					sHTMLIcons+=this.writeIconStandard("btnPreview"+this.oName,this.oName+".dropShow(this,dropPreview"+this.oName+")","btnPreview.gif",getText("Preview"));
					var arrPreviewSize=[[640,480],[800,600],[1024,768]];
					sTmp="";
					for(var j=0;j<arrPreviewSize.length;j++)
						{
						sTmp+= "<tr><td onclick=\"dropPreview"+this.oName+".style.display='none';setActiveEditor('"+this.oName+"');modalDialogShow('"+this.scriptPath+"preview.htm',"+arrPreviewSize[j][0]+","+arrPreviewSize[j][1]+");\" "+
							"style=\"padding:2px;padding-top:1px;font-family:Tahoma;font-size:11px;color:black;\" "+
							"onmouseover=\"this.style.backgroundColor='#708090';this.style.color='#FFFFFF';\" "+
							"onmouseout=\"this.style.backgroundColor='';this.style.color='#000000';\" unselectable=on>"+arrPreviewSize[j][0]+"x"+arrPreviewSize[j][1]+"</td></tr>";
						}
					sHTMLDropMenus+="<table id=dropPreview"+this.oName+" cellpadding=0 cellspacing=0 "+
						"style='z-index:1;display:none;position:absolute;border:#716F64 1px solid;"+
						"cursor:default;background-color:#fdfdfd;' unselectable=on>"+
						sTmp+"</table>";
					}
				break;
			case "FullScreen":
				if(this.btnFullScreen)sHTMLIcons+=this.writeIconStandard("btnFullScreen"+this.oName,this.oName+".fullScreen()","btnFullScreen.gif",getText("Full Screen"));
				break;
			case "Print":
				if(this.btnPrint)sHTMLIcons+=this.writeIconStandard("btnPrint"+this.oName,this.oName+".focus();"+this.oName+".doCmd('Print')","btnPrint.gif",getText("Print"));
				break;
			case "Search":
				if(this.btnSearch)sHTMLIcons+=this.writeIconStandard("btnSearch"+this.oName,this.oName+".hide();modelessDialogShow('"+this.scriptPath+"search.htm',375,163)","btnSearch.gif",getText("Search"));
				break;
			case "SpellCheck":
				if(this.btnSpellCheck)sHTMLIcons+=this.writeIconStandard("btnSpellCheck"+this.oName,this.oName+".hide();"+this.oName+".spellcheckDialogShow()","btnSpellCheck.gif",getText("Check Spelling"));
				break;
			case "StyleAndFormatting":
				sTmp="";
				if(this.btnTextFormatting)
					sTmp+="<tr><td onclick=\"modelessDialogShow('"+this.scriptPath+"text1.htm',511,534);"+
							"dropStyle"+this.oName+".style.display='none'\""+
							" style=\"padding:2px;padding-top:1px;font-family:Tahoma;font-size:11px;color:black;\" "+
							"onmouseover=\"this.style.backgroundColor='#708090';this.style.color='#FFFFFF';\" "+
							"onmouseout=\"this.style.backgroundColor='';this.style.color='#000000';\" unselectable=on>"+getText("Text Formatting")+"</td></tr>";
				if(this.btnParagraphFormatting)
					sTmp+="<tr><td onclick=\"modelessDialogShow('"+this.scriptPath+"paragraph.htm',440,284);"+
							"dropStyle"+this.oName+".style.display='none'\""+
							" style=\"padding:2px;padding-top:1px;font-family:Tahoma;font-size:11px;color:black;\" "+
							"onmouseover=\"this.style.backgroundColor='#708090';this.style.color='#FFFFFF';\" "+
							"onmouseout=\"this.style.backgroundColor='';this.style.color='#000000';\" unselectable=on>"+getText("Paragraph Formatting")+"</td></tr>";
				if(this.btnListFormatting)
					sTmp+="<tr><td onclick=\"modelessDialogShow('"+this.scriptPath+"list.htm',270,335);"+
							"dropStyle"+this.oName+".style.display='none'\""+
							" style=\"padding:2px;padding-top:1px;font-family:Tahoma;font-size:11px;color:black;\" "+
							"onmouseover=\"this.style.backgroundColor='#708090';this.style.color='#FFFFFF';\" "+
							"onmouseout=\"this.style.backgroundColor='';this.style.color='#000000';\" unselectable=on>"+getText("List Formatting")+"</td></tr>";
				if(this.btnBoxFormatting)
					sTmp+="<tr><td onclick=\"modelessDialogShow('"+this.scriptPath+"box.htm',438,380);"+
							"dropStyle"+this.oName+".style.display='none'\""+
							" style=\"padding:2px;padding-top:1px;font-family:Tahoma;font-size:11px;color:black;\" "+
							"onmouseover=\"this.style.backgroundColor='#708090';this.style.color='#FFFFFF';\" "+
							"onmouseout=\"this.style.backgroundColor='';this.style.color='#000000';\" unselectable=on>"+getText("Box Formatting")+"</td></tr>";
				if(this.btnStyles)
					sTmp+="<tr><td onclick=\"modelessDialogShow('"+this.scriptPath+"styles.htm',360,347);"+
							"dropStyle"+this.oName+".style.display='none'\""+
							" style=\"padding:2px;padding-top:1px;font-family:Tahoma;font-size:11px;color:black;\" "+
							"onmouseover=\"this.style.backgroundColor='#708090';this.style.color='#FFFFFF';\" "+
							"onmouseout=\"this.style.backgroundColor='';this.style.color='#000000';\" unselectable=on>"+getText("Styles")+"</td></tr>";
				if(this.btnCssText)
					sTmp+= "<tr><td onclick=\""+this.oName+".onCustomCssShow();"+
							"dropStyle"+this.oName+".style.display='none'\""+
							" style=\"padding:2px;padding-top:1px;font-family:Tahoma;font-size:11px;color:black;\" "+
							"onmouseover=\"this.style.backgroundColor='#708090';this.style.color='#FFFFFF';\" "+
							"onmouseout=\"this.style.backgroundColor='';this.style.color='#000000';\" unselectable=on>"+getText("Custom CSS")+"</td></tr>";
				if(this.btnTextFormatting||this.btnParagraphFormatting||this.btnListFormatting||this.btnBoxFormatting||this.btnStyles||this.btnCssText)
					{
					sHTMLIcons+=this.writeIconStandard("btnStyleAndFormat"+this.oName,this.oName+".dropShow(this,dropStyle"+this.oName+")","btnStyle.gif",getText("Styles & Formatting"));
					sHTMLDropMenus+="<table id=dropStyle"+this.oName+" cellpadding=0 cellspacing=0 "+
						"style='z-index:1;display:none;position:absolute;border:#716F64 1px solid;"+
						"cursor:default;background-color:#fdfdfd;' unselectable=on>"+
						sTmp+"</table>";
					}
				break;
			case "Paragraph":
				if(this.btnParagraph)
					{
					sHTMLDropMenus+="<table id=dropParagraph"+this.oName+" cellpadding=0 cellspacing=0 "+
						"style='z-index:1;display:none;position:absolute;border:#716F64 1px solid;"+
						"cursor:default;background-color:#fdfdfd;' unselectable=on>";
					for(var j=0;j<this.arrParagraph.length;j++)
						{
						sHTMLDropMenus+="<tr><td onclick=\""+this.oName+".applyParagraph('<"+this.arrParagraph[j][1]+">')\" "+
							"style=\"padding:0;padding-left:5px;padding-right:5px;font-family:tahoma;color:black;\" "+
							"onmouseover=\"this.style.backgroundColor='#708090';this.style.color='#FFFFFF';\" "+
							"onmouseout=\"this.style.backgroundColor='';this.style.color='#000000';\" unselectable=on align=center>"+
							"<"+this.arrParagraph[j][1]+" style=\"\margin-bottom:4px\"  unselectable=on> "+
							this.arrParagraph[j][0]+"</"+this.arrParagraph[j][1]+"></td></tr>";
						}
					sHTMLDropMenus+="</table>";
					sHTMLIcons+=this.writeDropDown("btnParagraph"+this.oName,this.oName+".selectParagraph();"+this.oName+".dropShow(this,dropParagraph"+this.oName+")","btnParagraph.gif",getText("Paragraph"),77);
					}
				break;
			case "FontName":
				if(this.btnFontName)
					{
					sHTMLDropMenus+="<table id=dropFontName"+this.oName+" cellpadding=0 cellspacing=0 "+
						"style='z-index:1;display:none;position:absolute;border:#716F64 1px solid;"+
						"cursor:default;background-color:#fdfdfd;' unselectable=on><tr><td>";

					//~~~~ up to 120 fonts
					var numOfFonts=0;
					for(var j=0;j<this.arrFontName.length;j++)
						{
						//if(this.arrFontName[j].length==1)
						if(this.arrFontName[j].toString().indexOf(",")==-1)
							{
							if(this.arrFontName[j]!="serif" &&
								this.arrFontName[j]!="sans-serif" &&
								this.arrFontName[j]!="cursive" &&
								this.arrFontName[j]!="fantasy" &&
								this.arrFontName[j]!="monoscape")numOfFonts++;
							}
						else numOfFonts++;
						}
					sHTMLDropMenus+="<table cellpadding=0 cellspacing=0>";
					for(var j=0;j<this.arrFontName.length;j++)
						{
						//if(this.arrFontName[j].length==1)
						if(this.arrFontName[j].toString().indexOf(",")==-1)						
							{
							if(this.arrFontName[j]!="serif" &&
								this.arrFontName[j]!="sans-serif" &&
								this.arrFontName[j]!="cursive" &&
								this.arrFontName[j]!="fantasy" &&
								this.arrFontName[j]!="monoscape")
								sHTMLDropMenus+="<tr><td onclick=\""+this.oName+".applyFontName('"+this.arrFontName[j]+"')\" "+
									"style=\"padding:2px;padding-top:1px;font-family:"+ this.arrFontName[j] +";font-size:11px;color:black;\" "+
									"onmouseover=\"if(this.style.backgroundColor=='#708090')this.sel='true';this.style.backgroundColor='#708090';this.style.color='#FFFFFF';\" "+
									"onmouseout=\"if(this.sel=='true'){this.sel='false'}else{this.style.backgroundColor='';this.style.color='#000000';}\" unselectable=on>"+
									this.arrFontName[j]+" <span unselectable=on style='font-family:tahoma'>("+ this.arrFontName[j] +")</span></td></tr>";
							}
						else
							{
							sHTMLDropMenus+="<tr><td onclick=\""+this.oName+".applyFontName('"+this.arrFontName[j][0]+"')\" "+
								"style=\"padding:2px;padding-top:1px;font-family:"+ this.arrFontName[j][0] +";font-size:11px;color:black;\" "+
								"onmouseover=\"if(this.style.backgroundColor=='#708090')this.sel='true';this.style.backgroundColor='#708090';this.style.color='#FFFFFF';\" "+
								"onmouseout=\"if(this.sel=='true'){this.sel='false'}else{this.style.backgroundColor='';this.style.color='#000000';}\" unselectable=on>"+
								this.arrFontName[j][1]+" <span unselectable=on style='font-family:tahoma'>("+ this.arrFontName[j][1] +")</span></td></tr>";
							}
						if(j==14||j==29||j==44||j==59||j==74||j==89||j==104)
							{
							if(j!=numOfFonts-1)
								{
								sHTMLDropMenus+="</table>";
								sHTMLDropMenus+="</td><td valign=top style='border-left:#716f64 1 solid'>";//main
								sHTMLDropMenus+="<table cellpadding=0 cellspacing=0>";
								}
							}
						}
					sHTMLDropMenus+="</table>";
					//~~~~

					sHTMLDropMenus+="</td></tr></table>";
					sHTMLIcons+=this.writeDropDown("btnFontName"+this.oName,this.oName+".expandSelection();"+this.oName+".dropShow(this,dropFontName"+this.oName+");realtimeFontSelect('"+this.oName+"')","btnFontName.gif",getText("Font Name"),77);
					}
				break;
			case "FontSize":
				if(this.btnFontSize)
					{
					sHTMLDropMenus+="<table id=dropFontSize"+this.oName+" cellpadding=0 cellspacing=0 "+
						"style='z-index:1;display:none;position:absolute;border:#716F64 1px solid;"+
						"cursor:default;background-color:#fdfdfd;' unselectable=on>";
					for(var j=0;j<this.arrFontSize.length;j++)
						{
						sHTMLDropMenus+="<tr><td onclick=\""+this.oName+".applyFontSize('"+this.arrFontSize[j][1]+"')\" "+
							"style=\"padding:0;padding-left:5px;padding-right:5px;font-family:tahoma;color:black;\" "+
							"onmouseover=\"if(this.style.backgroundColor=='#708090')this.sel='true';this.style.backgroundColor='#708090';this.style.color='#FFFFFF';\" "+
							"onmouseout=\"if(this.sel=='true'){this.sel='false'}else{this.style.backgroundColor='';this.style.color='#000000';}\" unselectable=on align=center>"+
							"<font unselectable=on size=\""+this.arrFontSize[j][1]+"\">"+
							this.arrFontSize[j][0]+"</font></td></tr>";
						}
					sHTMLDropMenus+="</table>";
					sHTMLIcons+=this.writeDropDown("btnFontSize"+this.oName,this.oName+".expandSelection();"+this.oName+".dropShow(this,dropFontSize"+this.oName+");realtimeSizeSelect('"+this.oName+"')","btnFontSize.gif",getText("Font Size"),60);
					}
				break;
			case "Cut":
				if(this.btnCut)sHTMLIcons+=this.writeIconStandard("btnCut"+this.oName,this.oName+".doCmd('Cut')","btnCut.gif",getText("Cut"));
				break;
			case "Copy":
				if(this.btnCopy)sHTMLIcons+=this.writeIconStandard("btnCopy"+this.oName,this.oName+".doCmd('Copy')","btnCopy.gif",getText("Copy"));
				break;
			case "Paste":
				if(this.btnPaste)sHTMLIcons+=this.writeIconStandard("btnPaste"+this.oName,this.oName+".doPaste()","btnPaste.gif",getText("Paste"));
				break;
			case "PasteWord":
				if(this.btnPasteWord)sHTMLIcons+=this.writeIconStandard("btnPasteWord"+this.oName,this.oName+".hide();modelessDialogShow('"+this.scriptPath+"paste_word.htm',400,280)","btnPasteWord.gif",getText("Paste from Word"));
				break;
			case "Tables":
				if(this.btnTables)sHTMLIcons+=this.writeIconStandard("btnTables"+this.oName,this.oName+".hide();window.open('../../../admin/index.php?mod=tables&action=mini_browser','Site_Path','width=600,height=400,resizable=yes')","btnTables.gif",getText("No Table"));
				break;
			case "Photo":
				if(this.btnPhoto)sHTMLIcons+=this.writeIconStandard("btnPhoto"+this.oName,this.oName+".hide();window.open('../../../admin/index.php?mod=photoalbum&action=mini_browser','Site_Path','width=600,height=400,resizable=yes')","btnPhoto.gif",getText("No Photos"));
				break;
			case "Mail":
				if(this.btnMail)sHTMLIcons+=this.writeIconStandard("btnMail"+this.oName,this.oName+".hide();window.open('../../../admin/index.php?mod=forms&action=mini_browser','Site_Path','width=600,height=400,resizable=yes')","btnMail.gif",getText("No Mail"));
				break;
			case "PasteText":
				if(this.btnPasteText)sHTMLIcons+=this.writeIconStandard("btnPasteText"+this.oName,this.oName+".doPasteText()","btnPasteText.gif",getText("Paste Text"));
				break;
			case "Undo":
				if(this.btnUndo)sHTMLIcons+=this.writeIconStandard("btnUndo"+this.oName,this.oName+".doUndo()","btnUndo.gif",getText("Undo"));
				break;
			case "Redo":
				if(this.btnRedo)sHTMLIcons+=this.writeIconStandard("btnRedo"+this.oName,this.oName+".doRedo()","btnRedo.gif",getText("Redo"));
				break;
			case "Bold":
				if(this.btnBold)sHTMLIcons+=this.writeIconToggle("btnBold"+this.oName,this.oName+".doCmd('Bold')","btnBold.gif",getText("Bold"));
				break;
			case "Italic":
				if(this.btnItalic)sHTMLIcons+=this.writeIconToggle("btnItalic"+this.oName,this.oName+".doCmd('Italic')","btnItalic.gif",getText("Italic"));
				break;
			case "Underline":
				if(this.btnUnderline)sHTMLIcons+=this.writeIconToggle("btnUnderline"+this.oName,this.oName+".doCmd('Underline')","btnUnderline.gif",getText("Underline"));
				break;
			case "Strikethrough":
				if(this.btnStrikethrough)sHTMLIcons+=this.writeIconToggle("btnStrikethrough"+this.oName,this.oName+".doCmd('Strikethrough')","btnStrikethrough.gif",getText("Strikethrough"));
				break;
			case "Superscript":
				if(this.btnSuperscript)sHTMLIcons+=this.writeIconToggle("btnSuperscript"+this.oName,this.oName+".doCmd('Superscript')","btnSuperscript.gif",getText("Superscript"));
				break;
			case "Subscript":
				if(this.btnSubscript)sHTMLIcons+=this.writeIconToggle("btnSubscript"+this.oName,this.oName+".doCmd('Subscript')","btnSubscript.gif",getText("Subscript"));
				break;
			case "JustifyLeft":
				if(this.btnJustifyLeft)sHTMLIcons+=this.writeIconToggle("btnJustifyLeft"+this.oName,this.oName+".applyJustifyLeft()","btnLeft.gif",getText("Justify Left"));
				break;
			case "JustifyCenter":
				if(this.btnJustifyCenter)sHTMLIcons+=this.writeIconToggle("btnJustifyCenter"+this.oName,this.oName+".applyJustifyCenter()","btnCenter.gif",getText("Justify Center"));
				break;
			case "JustifyRight":
				if(this.btnJustifyRight)sHTMLIcons+=this.writeIconToggle("btnJustifyRight"+this.oName,this.oName+".applyJustifyRight()","btnRight.gif",getText("Justify Right"));
				break;
			case "JustifyFull":
				if(this.btnJustifyFull)sHTMLIcons+=this.writeIconToggle("btnJustifyFull"+this.oName,this.oName+".applyJustifyFull()","btnFull.gif",getText("Justify Full"));
				break;
			case "Numbering":
				if(this.btnNumbering)sHTMLIcons+=this.writeIconToggle("btnNumbering"+this.oName,this.oName+".applyNumbering()","btnNumber.gif",getText("Numbering"));
				break;
			case "Bullets":
				if(this.btnBullets)sHTMLIcons+=this.writeIconToggle("btnBullets"+this.oName,this.oName+".applyBullets()","btnList.gif",getText("Bullets"));
				break;
			case "Indent":
				if(this.btnIndent)sHTMLIcons+=this.writeIconStandard("btnIndent"+this.oName,this.oName+".doCmd('Indent')","btnIndent.gif",getText("Indent"));
				break;
			case "Outdent":
				if(this.btnOutdent)sHTMLIcons+=this.writeIconStandard("btnOutdent"+this.oName,this.oName+".doCmd('Outdent')","btnOutdent.gif",getText("Outdent"));
				break;
			case "LTR":
				if(this.btnLTR)sHTMLIcons+=this.writeIconToggle("btnLTR"+this.oName,this.oName+".applyBlockDirLTR()","btnLTR.gif",getText("Left To Right"));
				break;
			case "RTL":
				if(this.btnRTL)sHTMLIcons+=this.writeIconToggle("btnRTL"+this.oName,this.oName+".applyBlockDirRTL()","btnRTL.gif",getText("Right To Left"));
				break;
			case "ForeColor":
				if(this.btnForeColor)sHTMLIcons+=this.writeIconStandard("btnForeColor"+this.oName,this.oName+".expandSelection();"+this.oName+".oColor1.show(this)","btnForeColor.gif",getText("Foreground Color"));
				break;
			case "BackColor":
				if(this.btnBackColor)sHTMLIcons+=this.writeIconStandard("btnBackColor"+this.oName,this.oName+".expandSelection();"+this.oName+".oColor2.show(this)","btnBackColor.gif",getText("Background Color"));
				break;
			case "Bookmark":
				if(this.btnBookmark)sHTMLIcons+=this.writeIconStandard("btnBookmark"+this.oName,this.oName+".hide();modelessDialogShow('"+this.scriptPath+"bookmark.htm',245,216)","btnBookmark.gif",getText("Bookmark"));
				break;
			case "Hyperlink":
				if(this.btnHyperlink)sHTMLIcons+=this.writeIconStandard("btnHyperlink"+this.oName,this.oName+".hide();modelessDialogShow('"+this.scriptPath+"hyperlink.htm',380,200)","btnHyperlink.gif",getText("Hyperlink"));
				break;
			case "CustomTag":
				if(this.btnCustomTag)
					{
					sHTMLDropMenus+="<table id=dropCustomTag"+this.oName+" cellpadding=0 cellspacing=0 "+
						"style='z-index:1;display:none;position:absolute;border:#716F64 1px solid;"+
						"cursor:default;background-color:#fdfdfd;' unselectable=on><tr><td valign=top>";

					//~~~~ up to 120 tags
					sHTMLDropMenus+="<table cellpadding=0 cellspacing=0>";
					for(var j=0;j<this.arrCustomTag.length;j++)
						{
						sHTMLDropMenus+="<tr><td onclick=\""+this.oName+".insertCustomTag('"+this.arrCustomTag[j][1]+"')\" "+
							"style=\"padding:1px;padding-left:5px;padding-right:5px;font-family:tahoma;font-size:11px;color:black;\" "+
							"onmouseover=\"this.style.backgroundColor='#708090';this.style.color='#FFFFFF';\" "+
							"onmouseout=\"this.style.backgroundColor='';this.style.color='#000000';\" unselectable=on align=center>"+
							this.arrCustomTag[j][0]+"</td></tr>";

						if(j==14||j==29||j==44||j==59||j==74||j==89||j==104)
							{
							if(j!=this.arrCustomTag.length-1)
								{
								sHTMLDropMenus+="</table>";
								sHTMLDropMenus+="</td><td valign=top style='border-left:#716f64 1 solid'>";//main
								sHTMLDropMenus+="<table cellpadding=0 cellspacing=0>";
								}
							}
						}
					sHTMLDropMenus+="</table>";
					//~~~~

					sHTMLDropMenus+="</td></tr></table>";
					sHTMLIcons+=this.writeDropDown("btnCustomTag"+this.oName,this.oName+".dropShow(this,dropCustomTag"+this.oName+")","btnCustomTag.gif",getText("Tags"),60);
					}
				break;
			case "Image":
				if(this.btnImage)sHTMLIcons+=this.writeIconStandard("btnImage"+this.oName,this.oName+".hide();modelessDialogShow('"+this.scriptPath+"image.htm',440,351)","btnImage.gif",getText("Image"));
				break;
			case "Flash":
				if(this.btnFlash)sHTMLIcons+=this.writeIconStandard("btnFlash"+this.oName,this.oName+".hide();modelessDialogShow('"+this.scriptPath+"flash.htm',340,275)","btnFlash.gif",getText("Flash"));
				break;
			case "Media":
				if(this.btnMedia)sHTMLIcons+=this.writeIconStandard("btnMedia"+this.oName,this.oName+".hide();modelessDialogShow('"+this.scriptPath+"media.htm',340,272)","btnMedia.gif",getText("Media"));
				break;
			case "ContentBlock":
				if(this.btnContentBlock)sHTMLIcons+=this.writeIconStandard("btnContentBlock"+this.oName,this.oName+".hide();"+this.cmdContentBlock,"btnContentBlock.gif",getText("Content Block"));
				break;
			case "InternalLink":
				if(this.btnInternalLink)sHTMLIcons+=this.writeIconStandard("btnInternalLink"+this.oName,this.oName+".hide();"+this.cmdInternalLink,"btnInternalLink.gif",getText("Internal Link"));
				break;
			case "CustomObject":
				if(this.btnCustomObject)sHTMLIcons+=this.writeIconStandard("btnCustomObject"+this.oName,this.oName+".hide();"+this.cmdCustomObject,"btnCustomObject.gif",getText("Object"));
				break;
			case "Table":
				if(this.btnTable)
					{
					sHTMLDropMenus+="<table id=dropTable"+this.oName+" cellpadding=0 cellspacing=0 "+
							"style='z-index:1;display:none;position:absolute;border:#716F64 1px solid;"+
							"cursor:default;background-color:#fdfdfd;' unselectable=on>"+
							"<tr><td id=\"mnuTableSize"+this.oName+"\" onclick=\"if(this.style.color!='gray'){modelessDialogShow('"+this.scriptPath+"table_size.htm',240,262);"+
							"	dropTable"+this.oName+".style.display='none'}\""+
							"	style=\"padding:2px;padding-top:1px;font-family:Tahoma;font-size:11px;color:black\""+
							"	onmouseover=\"if(this.style.color!='gray'){this.style.backgroundColor='#708090';this.style.color='#FFFFFF';}\""+
							"	onmouseout=\"if(this.style.color!='gray'){this.style.backgroundColor='';this.style.color='#000000';}\" unselectable=on>"+getText("Table Size")+" </td></tr>"+
							"<tr><td id=\"mnuTableEdit"+this.oName+"\" onclick=\"if(this.style.color!='gray'){modelessDialogShow('"+this.scriptPath+"table_edit.htm',358,360);"+
							"	dropTable"+this.oName+".style.display='none'}\""+
							"	style=\"padding:2px;padding-top:1px;font-family:Tahoma;font-size:11px;color:black\""+
							"	onmouseover=\"if(this.style.color!='gray'){this.style.backgroundColor='#708090';this.style.color='#FFFFFF';}\""+
							"	onmouseout=\"if(this.style.color!='gray'){this.style.backgroundColor='';this.style.color='#000000';}\" unselectable=on>"+getText("Edit Table")+" </td></tr>"+
							"<tr><td id=\"mnuCellEdit"+this.oName+"\" onclick=\"if(this.style.color!='gray'){modelessDialogShow('"+this.scriptPath+"table_editCell.htm',427,440);"+
							"	dropTable"+this.oName+".style.display='none'}\""+
							"	style=\"padding:2px;padding-top:1px;font-family:Tahoma;font-size:11px;color:black\""+
							"	onmouseover=\"if(this.style.color!='gray'){this.style.backgroundColor='#708090';this.style.color='#FFFFFF';}\""+
							"	onmouseout=\"if(this.style.color!='gray'){this.style.backgroundColor='';this.style.color='#000000';}\" unselectable=on>"+getText("Edit Cell")+" </td></tr>"+
							"</table>";

					sHTMLDropMenus+="<table width=195 id=dropTableCreate"+this.oName+" onmouseout='doOut_TabCreate();event.cancelBubble=true' style='position:absolute;display:none;cursor:default;background:#f3f3f3;border:#8a867a 1px solid;' cellpadding=0 cellspacing=2 border=0 unselectable=on>";
					for(var m=0;m<8;m++)
						{
						sHTMLDropMenus+="<tr>";
						for(var n=0;n<8;n++)
							{
							sHTMLDropMenus+="<td onclick='"+this.oName+".doClick_TabCreate()' onmouseover='doOver_TabCreate()' style='background:#ffffff;font-size:1px;border:#8a867a 1px solid;width:20px;height:20px;' unselectable=on>&nbsp;</td>";
							}
						sHTMLDropMenus+="</tr>";
						}
					sHTMLDropMenus+="<tr><td colspan=8 onclick=\""+this.oName+".hide();modelessDialogShow('"+this.scriptPath+"table_insert.htm',300,322);\" onmouseover=\"this.innerText='"+getText("Advanced Table Insert")+"';this.style.border='#777777 1px solid';this.style.backgroundColor='#8d9aa7';this.style.color='#ffffff'\" onmouseout=\"this.style.border='#f3f3f3 1px solid';this.style.backgroundColor='#f3f3f3';this.style.color='#000000'\" align=center style='font-family:verdana;font-size:10px;font-color:black;border:#f3f3f3 1px solid;' unselectable=on>"+getText("Advanced Table Insert")+"</td></tr>";
					sHTMLDropMenus+="</table>";

					sHTMLIcons+=this.writeIconStandard("btnTable"+this.oName,this.oName+".dropShow(this,dropTableCreate"+this.oName+")","btnTable.gif",getText("Insert Table"));
					sHTMLIcons+=this.writeIconStandard("btnTableEdit"+this.oName,this.oName+".dropShow(this,dropTable"+this.oName+")","btnTableEdit.gif",getText("Edit Table/Cell"));
					}
				break;
			case "Guidelines":
				if(this.btnGuidelines)sHTMLIcons+=this.writeIconStandard("btnGuidelines"+this.oName,this.oName+".runtimeBorder(true)","btnGuideline.gif",getText("Show/Hide Guidelines"));
				break;
			case "Absolute":
				if(this.btnAbsolute)sHTMLIcons+=this.writeIconStandard("btnAbsolute"+this.oName,this.oName+".makeAbsolute()","btnAbsolute.gif",getText("Absolute"));
				break;
			case "Characters":
				if(this.btnCharacters)sHTMLIcons+=this.writeIconStandard("btnCharacters"+this.oName,this.oName+".hide();modelessDialogShow('"+this.scriptPath+"characters.htm',495,162)","btnSymbol.gif",getText("Special Characters"));
				break;
			case "Line":
				if(this.btnLine)sHTMLIcons+=this.writeIconStandard("btnLine"+this.oName,this.oName+".doCmd('InsertHorizontalRule')","btnLine.gif",getText("Line"));
				break;
			case "Form":
				if(this.btnForm)
					{
					var arrFormMenu = [[getText("Form"),"form_form.htm","280","177"],
									[getText("Text Field"),"form_text.htm","285","289"],
									[getText("List"),"form_list.htm","295","332"],
									[getText("Checkbox"),"form_check.htm","235","174"],
									[getText("Radio Button"),"form_radio.htm","235","177"],
									[getText("Hidden Field"),"form_hidden.htm","235","152"],
									[getText("File Field"),"form_file.htm","235","132"],
									[getText("Button"),"form_button.htm","235","174"]];
					sHTMLIcons+=this.writeIconStandard("btnForm"+this.oName,this.oName+".dropShow(this,dropForm"+this.oName+")","btnForm.gif",getText("Form Editor"));
					sHTMLDropMenus+="<table id=dropForm"+this.oName+" cellpadding=0 cellspacing=0 "+
						"style='z-index:1;display:none;position:absolute;border:#716F64 1px solid;"+
						"cursor:default;background-color:#fdfdfd;' unselectable=on>";
						for(var j=0;j<arrFormMenu.length;j++)
							{
							sHTMLDropMenus+="<tr><td onclick=\"modelessDialogShow('"+this.scriptPath + arrFormMenu[j][1]+"',"+arrFormMenu[j][2]+","+arrFormMenu[j][3]+");"+
							"dropForm"+this.oName+".style.display='none'\""+
							" style=\"padding:2px;padding-top:1px;font-family:Tahoma;font-size:11px;color:black;\" "+
							"onmouseover=\"this.style.backgroundColor='#708090';this.style.color='#FFFFFF';\" "+
							"onmouseout=\"this.style.backgroundColor='';this.style.color='#000000';\" unselectable=on>"+arrFormMenu[j][0]+"</td></tr>";
							}
					sHTMLDropMenus+="</table>";
					}
				break;
			case "Clean":
				if(this.btnClean)sHTMLIcons+=this.writeIconStandard("btnClean"+this.oName,this.oName+".doClean()","btnRemoveFormat.gif",getText("Clean"));
				break;
			case "HTMLFullSource":
				if(this.btnHTMLFullSource)sHTMLIcons+=this.writeIconStandard("btnHTMLFullSource"+this.oName,"setActiveEditor('"+this.oName+"');"+this.oName+".hide();modalDialogShow('"+this.scriptPath+"source_html_full.htm',600,450);","btnSource.gif",getText("View/Edit Source"));
				break;
			case "HTMLSource":
				if(this.btnHTMLSource)sHTMLIcons+=this.writeIconStandard("btnHTMLSource"+this.oName,"setActiveEditor('"+this.oName+"');"+this.oName+".hide();modalDialogShow('"+this.scriptPath+"source_html.htm',600,450);","btnSource.gif",getText("View/Edit Source"));
				break;
			case "XHTMLFullSource":
				if(this.btnXHTMLFullSource)sHTMLIcons+=this.writeIconStandard("btnXHTMLFullSource"+this.oName,"setActiveEditor('"+this.oName+"');"+this.oName+".hide();modalDialogShow('"+this.scriptPath+"source_xhtml_full.htm',600,450);","btnSource.gif",getText("View/Edit Source"));
				break;
			case "XHTMLSource":
				if(this.btnXHTMLSource)sHTMLIcons+=this.writeIconStandard("btnXHTMLSource"+this.oName,"setActiveEditor('"+this.oName+"');"+this.oName+".hide();modalDialogShow('"+this.scriptPath+"source_xhtml.htm',600,450);","btnSource.gif",getText("View/Edit Source"));
				break;
			case "ClearAll":
				if(this.btnClearAll)sHTMLIcons+=this.writeIconStandard("btnClearAll"+this.oName,this.oName+".clearAll()","btnDelete.gif",getText("Clear All"));
				break;
			default:
				for(j=0;j<this.arrCustomButtons.length;j++)
					{
					if(sButtonName==this.arrCustomButtons[j][0])
						{
						sCbName=this.arrCustomButtons[j][0];
						//sCbCommand=this.arrCustomButtons[j][1];
						sCbCaption=this.arrCustomButtons[j][2];
						sCbImage=this.arrCustomButtons[j][3];
						sHTMLIcons+=this.writeIconStandard("btn"+sCbName+this.oName,"eval("+this.oName+".arrCustomButtons["+j+"][1])",sCbImage,sCbCaption);
						}
					}
				break;
			}
		}

	var sHTML="";

	if(!document.getElementById("id_refresh_z_index"))
		sHTML+="<div id=id_refresh_z_index style='margin:0'></div>";

	sHTML+="<table id=idArea"+this.oName+" name=idArea"+this.oName+" border=0 "+
			"cellpadding=0 cellspacing=0 width='"+this.width+"' height='"+this.height+"'>"+
			//"<tr><td colspan=2 bgcolor=#ffffff style=\"padding:1px;border:#cfcfcf 1px solid;filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#ffffff,endColorstr=#ebebeb);\">"+
			"<tr><td colspan=2 style=\"padding:1px;border:#cfcfcf 1px solid;background:url('"+this.scriptPath+"icons/bg.gif')\">"+
			"<table cellpadding=0 cellspacing=0><tr><td dir=ltr>"+
			sHTMLIcons+
			"</td></tr></table>"+
			"</td></tr>"+
			"<tr id=idTagSelTopRow"+this.oName+"><td colspan=2 id=idTagSelTop"+this.oName+" height=0></td></tr>";

	sHTML+="<tr><td colspan=2 valign=top height=100% style='background:white'>";

	if(this.IsSecurityRestricted)
		sHTML+="<iframe security='restricted' style='width:100%;height:100%;margin-top:1px;' src='"+this.scriptPath+"blank.gif'"+
			" name=idContent"+ this.oName + " id=idContent"+this.oName+
			" contentEditable=true></iframe>";//prohibit running ActiveX controls
	else
		sHTML+="<iframe style='width:100%;height:100%;margin-top:1px;' src='"+this.scriptPath+"blank.gif'"+
			" name=idContent"+ this.oName + " id=idContent"+this.oName+
			" contentEditable=true></iframe>";

	//Paste From Word
	sHTML+="<iframe style='width:1px;height:1px;overflow:auto;' src='"+this.scriptPath+"blank.gif'"+
		" name=idContentWord"+ this.oName +" id=idContentWord"+ this.oName+
		" contentEditable=true onfocus='"+this.oName+".hide()'></iframe>";

	if(this.css!="")
		{
		document.write("<iframe id=\"myStyle"+this.oName+"\" name=\"myStyle"+this.oName+"\" src='"+this.scriptPath+"blank.gif' style=\"display:none\"></iframe>");
		}

	sHTML+="</td></tr>";
	sHTML+="<tr id=idTagSelBottomRow"+this.oName+"><td colspan=2 id=idTagSelBottom"+this.oName+"></td></tr>";
	sHTML+="</table>";

	sHTML+=sHTMLDropMenus;//dropdown

	document.write(sHTML);

	//Render Color Picker (forecolor)
	this.oColor1.url=this.scriptPath+"color_picker_fg.htm";
	this.oColor1.onShow = new Function(this.oName+".hide()");
	this.oColor1.onMoreColor = new Function(this.oName+".hide()");
	this.oColor1.onPickColor = new Function(this.oName+".applyColor('ForeColor',eval('"+this.oName+"').oColor1.color)");
	this.oColor1.onRemoveColor = new Function(this.oName+".applyColor('ForeColor','')");
	this.oColor1.txtCustomColors=getText("Custom Colors");
	this.oColor1.txtMoreColors=getText("More Colors...");
	this.oColor1.RENDER();

	//Render Color Picker (backcolor)
	this.oColor2.url=this.scriptPath+"color_picker_bg.htm";
	this.oColor2.onShow = new Function(this.oName+".hide()");
	this.oColor2.onMoreColor = new Function(this.oName+".hide()");
	this.oColor2.onPickColor = new Function(this.oName+".applyColor('BackColor',eval('"+this.oName+"').oColor2.color)");
	this.oColor2.onRemoveColor = new Function(this.oName+".applyColor('BackColor','')");
	this.oColor2.txtCustomColors=getText("Custom Colors");
	this.oColor2.txtMoreColors=getText("More Colors...");
	this.oColor2.RENDER();

	if(this.useTagSelector)
		{
		if(this.TagSelectorPosition=="bottom")this.TagSelectorPosition="top";
		else this.TagSelectorPosition="bottom";
		this.moveTagSelector()
		}

	//paste from word temp storage
	var oWord=eval("idContentWord"+this.oName);
	oWord.document.designMode="on";
	oWord.document.open("text/html","replace");
	oWord.document.write("<html><head></head><body></body></html>");
	oWord.document.close();
	oWord.document.body.contentEditable=true;

	oUtil.oName=this.oName;//default active editor
	oUtil.oEditor=eval("idContent"+this.oName);
	oUtil.obj=eval(this.oName);

	oUtil.arrEditor.push(this.oName);

	var arrA = String(this.preloadHTML).match(/<HTML[^>]*>/ig);
	if(arrA)
		{//full html
		this.loadHTML("");
		//this.preloadHTML is required here. Can't use sPreloadHTML as in:
		//window.setTimeout(this.oName+".putHTML("+sPreloadHTML+")",0);
		window.setTimeout(this.oName+".putHTML("+this.oName+".preloadHTML)",0);
		//window.setTimeout utk fix swf loading.
		//Utk loadHTML & putHTML yg di SourceEditor tdk masalah
		}
	else
		{
		this.loadHTML(sPreloadHTML)
		}

	if(this.btnTable)
		{
		this.arrElm[0]=this.getElm("btnTableEdit");
		this.arrElm[1]=this.getElm("mnuTableSize");
		this.arrElm[2]=this.getElm("mnuTableEdit");
		this.arrElm[3]=this.getElm("mnuCellEdit");
		}
	if(this.btnParagraph)this.arrElm[4]=this.getElm("btnParagraph");
	if(this.btnFontName)this.arrElm[5]=this.getElm("btnFontName");
	if(this.btnFontSize)this.arrElm[6]=this.getElm("btnFontSize");
	if(this.btnCut)this.arrElm[7]=this.getElm("btnCut");
	if(this.btnCopy)this.arrElm[8]=this.getElm("btnCopy");
	if(this.btnPaste)this.arrElm[9]=this.getElm("btnPaste");
	if(this.btnPasteWord)this.arrElm[10]=this.getElm("btnPasteWord");
	if(this.btnPasteText)this.arrElm[11]=this.getElm("btnPasteText");
	if(this.btnUndo)this.arrElm[12]=this.getElm("btnUndo");
	if(this.btnRedo)this.arrElm[13]=this.getElm("btnRedo");
	if(this.btnBold)this.arrElm[14]=this.getElm("btnBold");
	if(this.btnItalic)this.arrElm[15]=this.getElm("btnItalic");
	if(this.btnUnderline)this.arrElm[16]=this.getElm("btnUnderline");
	if(this.btnStrikethrough)this.arrElm[17]=this.getElm("btnStrikethrough");
	if(this.btnSuperscript)this.arrElm[18]=this.getElm("btnSuperscript");
	if(this.btnSubscript)this.arrElm[19]=this.getElm("btnSubscript");
	if(this.btnNumbering)this.arrElm[20]=this.getElm("btnNumbering");
	if(this.btnBullets)this.arrElm[21]=this.getElm("btnBullets");
	if(this.btnJustifyLeft)this.arrElm[22]=this.getElm("btnJustifyLeft");
	if(this.btnJustifyCenter)this.arrElm[23]=this.getElm("btnJustifyCenter");
	if(this.btnJustifyRight)this.arrElm[24]=this.getElm("btnJustifyRight");
	if(this.btnJustifyFull)this.arrElm[25]=this.getElm("btnJustifyFull");
	if(this.btnIndent)this.arrElm[26]=this.getElm("btnIndent");
	if(this.btnOutdent)this.arrElm[27]=this.getElm("btnOutdent");
	if(this.btnLTR)this.arrElm[28]=this.getElm("btnLTR");
	if(this.btnRTL)this.arrElm[29]=this.getElm("btnRTL");
	if(this.btnForeColor)this.arrElm[30]=this.getElm("btnForeColor");
	if(this.btnBackColor)this.arrElm[31]=this.getElm("btnBackColor");
	if(this.btnLine)this.arrElm[32]=this.getElm("btnLine");
	}

function iwe_getElm(s)
	{
	return document.getElementById(s+this.oName)
	}

/*********************
	COLOR PICKER
**********************/
var arrColorPickerObjects=[];
function ColorPicker(sName,sParent)
	{
	this.oParent=sParent;
	if(sParent)
		{
		this.oName=sParent+"."+sName;
		this.oRenderName=sName+sParent;
		}
	else
		{
		this.oName=sName;
		this.oRenderName=sName;
		}
	arrColorPickerObjects.push(this.oName);

	this.url="color_picker.htm";
	this.onShow=function(){return true;};
	this.onHide=function(){return true;};
	this.onPickColor=function(){return true;};
	this.onRemoveColor=function(){return true;};
	this.onMoreColor=function(){return true;};
	this.show=showColorPicker;
	this.hide=hideColorPicker;
	this.hideAll=hideColorPickerAll;
	this.color;
	this.customColors=[];
	this.refreshCustomColor=refreshCustomColor;
	this.isActive=false;
	this.txtCustomColors="Custom Colors";
	this.txtMoreColors="More Colors...";
	this.align="left";
	this.currColor="#ffffff";//default current color
	this.RENDER=drawColorPicker;
	}
function drawColorPicker()
	{
	var arrColors=[["#800000","#8b4513","#006400","#2f4f4f","#000080","#4b0082","#800080","#000000"],
				["#ff0000","#daa520","#6b8e23","#708090","#0000cd","#483d8b","#c71585","#696969"],
				["#ff4500","#ffa500","#808000","#4682b4","#1e90ff","#9400d3","#ff1493","#a9a9a9"],
				["#ff6347","#ffd700","#32cd32","#87ceeb","#00bfff","#9370db","#ff69b4","#dcdcdc"],
				["#ffdab9","#ffffe0","#98fb98","#e0ffff","#87cefa","#e6e6fa","#dda0dd","#ffffff"]];
	var sHTMLColor="<table id=dropColor"+this.oRenderName+" style=\"z-index:1;display:none;position:absolute;border:#716F64 1px solid;cursor:default;background-color:#f3f3f3;padding:2px\" unselectable=on cellpadding=0 cellspacing=0 width=143 height=109><tr><td unselectable=on>";
	sHTMLColor+="<table align=center cellpadding=0 cellspacing=0 border=0 unselectable=on>";
	for(var i=0;i<arrColors.length;i++)
		{
		sHTMLColor+="<tr>";
		for(var j=0;j<arrColors[i].length;j++)
			sHTMLColor+="<td onclick=\""+this.oName+".color='"+arrColors[i][j]+"';"+this.oName+".onPickColor();"+this.oName+".currColor='"+arrColors[i][j]+"';"+this.oName+".hideAll()\" onmouseover=\"this.style.border='#777777 1px solid'\" onmouseout=\"this.style.border='#efefef 1px solid'\" style=\"cursor:default;padding:1px;border:#efefef 1px solid;\" unselectable=on>"+
				"<table style='margin:0;width:13px;height:13px;background:"+arrColors[i][j]+";border:white 1px solid' cellpadding=0 cellspacing=0 unselectable=on>"+
				"<tr><td unselectable=on></td></tr>"+
				"</table></td>";
		sHTMLColor+="</tr>";
		}

	//~~~ custom colors ~~~~
	sHTMLColor+="<tr><td colspan=8 id=idCustomColor"+this.oRenderName+"></td></tr>";

	//~~~ remove color & more colors ~~~~
	sHTMLColor+= "<tr>";
	sHTMLColor+= "<td unselectable=on>"+
		"<table style='margin-left:1px;width:14px;height:14px;background:#f3f3f3;' cellpadding=0 cellspacing=0 unselectable=on>"+
		"<tr><td onclick=\""+this.oName+".onRemoveColor();"+this.oName+".currColor='';"+this.oName+".hideAll()\" onmouseover=\"this.style.border='#777777 1px solid'\" onmouseout=\"this.style.border='white 1px solid'\" style=\"cursor:default;padding:1px;border:white 1px solid;font-family:verdana;font-size:10px;font-color:black;line-height:9px;\" align=center valign=top unselectable=on>x</td></tr>"+
		"</table></td>";
	sHTMLColor+= "<td colspan=7 unselectable=on>"+
		"<table style='margin:1px;width:117px;height:16px;background:#f3f3f3;border:#f3f3f3 1px solid' cellpadding=0 cellspacing=0 unselectable=on>"+
		"<tr><td onclick=\""+this.oName+".onMoreColor();"+this.oName+".hideAll();window.showModelessDialog('"+this.url+"',[window,'"+this.oName+"'],'dialogWidth:432px;dialogHeight:427px;edge:Raised;center:1;help:0;resizable:1;')\" onmouseover=\"this.style.border='#777777 1px solid';this.style.background='#8d9aa7';this.style.color='#ffffff'\" onmouseout=\"this.style.border='#efefef 1px solid';this.style.background='#f3f3f3';this.style.color='#000000'\" style=\"cursor:default;padding:1px;border:#efefef 1px solid\" style=\"font-family:verdana;font-size:9px;font-color:black;line-height:9px;padding:1px\" align=center valign=top nowrap unselectable=on>"+this.txtMoreColors+"</td></tr>"+
		"</table></td>";
	sHTMLColor+= "</tr>";

	sHTMLColor+= "</table>";
	sHTMLColor+="</td></tr></table>";
	document.write(sHTMLColor);
	}
function refreshCustomColor()
	{
	this.customColors=eval(this.oParent).customColors;//[CUSTOM] (Get from public definition)

	if(this.customColors.length==0)
		{
		eval("idCustomColor"+this.oRenderName).innerHTML="";
		return;
		}
	sHTML="<table cellpadding=0 cellspacing=0 width=100%><tr><td colspan=8 style=\"font-family:verdana;font-size:9px;font-color:black;line-height:9px;padding:1\">"+this.txtCustomColors+":</td></tr></table>";
	sHTML+="<table cellpadding=0 cellspacing=0><tr>";
	for(var i=0;i<this.customColors.length;i++)
		{
		if(i<22)
			{
			if(i==8||i==16||i==24||i==32)sHTML+="</tr></table><table cellpadding=0 cellspacing=0><tr>";
			sHTML+="<td onclick=\""+this.oName+".color='"+this.customColors[i]+"';"+this.oName+".onPickColor()\" onmouseover=\"this.style.border='#777777 1px solid'\" onmouseout=\"this.style.border='#efefef 1px solid'\" style=\"cursor:default;padding:1px;border:#efefef 1px solid;\" unselectable=on>"+
				"	<table  style='margin:0;width:13;height:13;background:"+this.customColors[i]+";border:white 1px solid' cellpadding=0 cellspacing=0 unselectable=on>"+
				"	<tr><td unselectable=on></td></tr>"+
				"	</table>"+
				"</td>";
			}
		}
	sHTML+="</tr></table>";
	eval("idCustomColor"+this.oRenderName).innerHTML=sHTML;
	}
function showColorPicker(oEl)
	{
	this.onShow();
	this.hideAll();
	var box=eval("dropColor"+this.oRenderName);
	box.style.display="block";
	var nTop=0;
	var nLeft=0;

	oElTmp=oEl;
	while(oElTmp.tagName!="BODY" && oElTmp.tagName!="HTML")
		{
		if(oElTmp.style.top!="")
			nTop+=oElTmp.style.top.substring(1,oElTmp.style.top.length-2)*1;
		else nTop+=oElTmp.offsetTop;
		oElTmp = oElTmp.offsetParent;
		}
	oElTmp=oEl;
	while(oElTmp.tagName!="BODY" && oElTmp.tagName!="HTML")
		{
		if(oElTmp.style.left!="")
			nLeft+=oElTmp.style.left.substring(1,oElTmp.style.left.length-2)*1;
		else nLeft+=oElTmp.offsetLeft;
		oElTmp=oElTmp.offsetParent;
		}

	if(this.align=="left") box.style.left=nLeft;
	else box.style.left=nLeft-143+oEl.offsetWidth;

	box.style.top=nTop+1+oUtil.obj.dropTopAdjustment;//[CUSTOM]
	//box.style.top=nTop+1+oEl.offsetHeight;//[CUSTOM]

	this.isActive=true;
	this.refreshCustomColor();
	}
function hideColorPicker()
	{
	this.onHide();
	var box=eval("dropColor"+this.oRenderName);
	box.style.display="none";
	this.isActive=false;
	}
function hideColorPickerAll()
	{
	for(var i=0;i<arrColorPickerObjects.length;i++)
		{
		var box=eval("dropColor"+eval(arrColorPickerObjects[i]).oRenderName);
		box.style.display="none";
		eval(arrColorPickerObjects[i]).isActive=false;
		}
	}

/*********************
	CONTENT
**********************/
function loadHTML(sHTML)//hanya utk first load.
	{
	var oEditor=eval("idContent"+this.oName);

	var oDoc=oEditor.document.open("text/html","replace");
	if(this.publishingPath!="")
		{
		var arrA = String(this.preloadHTML).match(/<base[^>]*>/ig);
		if(!arrA)
			{//if no <base> found
			sHTML=this.docType+"<HTML><HEAD><BASE HREF=\""+this.publishingPath+"\"/>"+this.headContent+"</HEAD><BODY contentEditable=true>" + sHTML + "</BODY></HTML>";
			//kalau cuma tambah <HTML><HEAD></HEAD><BODY.. tdk apa2.
			}
		}
	else
		{
		sHTML=this.docType+"<HTML><HEAD>"+this.headContent+"</HEAD><BODY contentEditable=true>"+sHTML+"</BODY></HTML>";
		}
	oDoc.write(sHTML);
	oDoc.close();

	oEditor.document.body.contentEditable=true;
	oEditor.document.execCommand("2D-Position", true, true);//make focus
	oEditor.document.execCommand("MultipleSelection", true, true);//make focus
	oEditor.document.execCommand("LiveResize", true, true);//make focus

	//RealTime
	oEditor.document.body.onkeydown = new Function("editorDoc_onkeydown('"+this.oName+"')");
	oEditor.document.body.onkeyup = new Function("editorDoc_onkeyup('"+this.oName+"')");
	oEditor.document.body.onmouseup = new Function("editorDoc_onmouseup('"+this.oName+"')");

	//Save for Undo
	oEditor.document.body.onpaste = new Function(this.oName+".doOnPaste()");
	oEditor.document.body.oncut = new Function(this.oName+".saveForUndo()");

	//Styles
	if(this.arrStyle.length>0)
		{
		var oElement=oEditor.document.createElement("<STYLE>");
		oEditor.document.documentElement.childNodes[0].appendChild(oElement);
		for(var i=0;i<this.arrStyle.length;i++)
			{
			selector=this.arrStyle[i][0];
			style=this.arrStyle[i][3];
			oEditor.document.styleSheets(0).addRule(selector,style);
			}
		}

	//*** RUNTIME STYLES ***
	this.runtimeBorder(false);
	this.runtimeStyles();
	//***********************

	//fix undisplayed content
	if(this.initialRefresh)
		{
		oEditor.document.execCommand("SelectAll");
		window.setTimeout("eval('idContentWord"+this.oName+"').document.execCommand('SelectAll');",0);
		}

	oEditor.document.body.style.width=50;
	oEditor.document.body.style.height=50;
	oEditor.document.body.style.width="";
	oEditor.document.body.style.height="";
	//oEditor.document.body.style.cssText="overflow-x:scroll;overflow-y:scroll";

	if(this.css!="")
		{
		eval("myStyle"+this.oName).document.open("text/html","replace");
		eval("myStyle"+this.oName).document.write("<html><head><link href=\""+this.css+"\" rel=\"stylesheet\" type=\"text/css\"></head><body onload=\"parent.ApplyExternalStyle('"+this.oName+"')\"></body></html>");
		eval("myStyle"+this.oName).document.close();

		try{ApplyExternalStyle(this.oName)}
		catch(e){;}
		}

	//<br> or <p>
	oEditor.document.body.onkeydown=new Function("doKeyPress(eval('idContent"+this.oName+"').event,'"+this.oName+"')");
	}
function doOnPaste()
	{
	this.isAfterPaste=true;
	eval(this.oName).saveForUndo();//Save for Undo
	}
function putHTML(sHTML)//used by source editor
	{
	var oEditor=eval("idContent"+this.oName);

	//save doctype (if any/if not body only)
	var arrA=String(sHTML).match(/<!DOCTYPE[^>]*>/ig);
	if(arrA)
		for(var i=0;i<arrA.length;i++)
			{
			this.docType=arrA[i];
			}
	else this.docType="";//back to default value

	//save html (if any/if not body only)
	var arrB=String(sHTML).match(/<HTML[^>]*>/ig);
	if(arrB)
		for(var i=0;i<arrB.length;i++)
			{
			s=arrB[i];
			s=s.replace(/\"[^\"]*\"/ig,function(x){
						x=x.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/'/g, "&apos;").replace(/[\s+]/ig,"#_#");
						return x});
			s=s.replace(/<([^ >]*)/ig,function(x){return x.toLowerCase()});					
			s=s.replace(/ ([^=]+)=([^" >]+)/ig," $1=\"$2\"");
			s=s.replace(/ ([^=]+)=/ig,function(x){return x.toLowerCase()});
			s=s.replace(/#_#/ig," ");
			this.html=s;
			}
	else this.html="<html>";//back to default value

	//Dalam pengeditan jangan pakai doctype,
	//membuat mouse tdk bisa di-klik di empty area
/*	sHTML=String(sHTML).replace(/<!DOCTYPE[^>]*>/ig,"");
*/
	if(this.publishingPath!="")
		{
		var arrA = sHTML.match(/<base[^>]*>/ig);
		if(!arrA)
			{
			sHTML="<BASE HREF=\""+this.publishingPath+"\"/>"+sHTML;
			}
		}

	var oDoc=oEditor.document.open("text/html","replace");
	oDoc.write(sHTML);
	oDoc.close();
	oEditor.document.body.contentEditable=true;
	oEditor.document.execCommand("2D-Position",true,true);
	oEditor.document.execCommand("MultipleSelection",true,true);
	oEditor.document.execCommand("LiveResize",true,true);

	//RealTime
	oEditor.document.body.onkeydown=new Function("editorDoc_onkeydown('"+this.oName+"')");
	oEditor.document.body.onkeyup=new Function("editorDoc_onkeyup('"+this.oName+"')");
	oEditor.document.body.onmouseup=new Function("editorDoc_onmouseup('"+this.oName+"')");

	//*** RUNTIME STYLES ***
	this.runtimeBorder(false);
	this.runtimeStyles();
	//***********************

	//<br> or <p>
	oEditor.document.body.onkeydown=new Function("doKeyPress(eval('idContent"+this.oName+"').event,'"+this.oName+"')");
	}
function getHTML()
	{
	var oEditor=eval("idContent"+this.oName);
	sHTML=oEditor.document.documentElement.outerHTML;
	sHTML=String(sHTML).replace(/ contentEditable=true/g,"");
	sHTML = String(sHTML).replace(/\<PARAM NAME=\"Play\" VALUE=\"0\">/ig,"<PARAM NAME=\"Play\" VALUE=\"-1\">");
	sHTML=this.docType+sHTML;//restore doctype (if any)
	return sHTML;
	}
function getHTMLBody()
	{
	var oEditor=eval("idContent"+this.oName);
	sHTML=oEditor.document.body.innerHTML;
	sHTML=String(sHTML).replace(/ contentEditable=true/g,"");
	sHTML = String(sHTML).replace(/\<PARAM NAME=\"Play\" VALUE=\"0\">/ig,"<PARAM NAME=\"Play\" VALUE=\"-1\">");
	return unescape(sHTML);
	}
var sBaseHREF="";
function getXHTML()
	{
	var oEditor=eval("idContent"+this.oName);

	//base handling
	sHTML=oEditor.document.documentElement.outerHTML;
	var arrTmp=sHTML.match(/<BASE([^>]*)>/ig);
	if(arrTmp!=null)sBaseHREF=arrTmp[0];
	for(var i=0;i<oEditor.document.all.length;i++)
		if(oEditor.document.all[i].tagName=="BASE")oEditor.document.all[i].removeNode();
	for(var i=0;i<oEditor.document.all.length;i++)
		if(oEditor.document.all[i].tagName=="BASE")oEditor.document.all[i].removeNode();
	//~~~~~~~~~~~~~
	sBaseHREF=sBaseHREF.replace(/<([^ >]*)/ig,function(x){return x.toLowerCase()});						
	sBaseHREF=sBaseHREF.replace(/ [^=]+="[^"]+"/ig,function(x){
				x=x.replace(/[\s+]/ig,"#_#");
				x=x.replace(/^#_#/," ");
				return x});
	sBaseHREF=sBaseHREF.replace(/ ([^=]+)=([^" >]+)/ig," $1=\"$2\"");
	sBaseHREF=sBaseHREF.replace(/ ([^=]+)=/ig,function(x){return x.toLowerCase()});
	sBaseHREF=sBaseHREF.replace(/#_#/ig," ");

	sBaseHREF=sBaseHREF.replace(/>$/ig," \/>").replace(/\/ \/>$/ig,"\/>");
	//~~~~~~~~~~~~~

	sHTML=recur(oEditor.document.documentElement,"");
	sHTML=this.docType+this.html+sHTML+"\n</html>";//restore doctype (if any) & html
	sHTML=sHTML.replace(/<\/title>/,"<\/title>"+sBaseHREF);//restore base href

	return sHTML;
	}
function getXHTMLBody()
	{
	var oEditor=eval("idContent"+this.oName);

	//base handling
	sHTML=oEditor.document.documentElement.outerHTML;
	var arrTmp=sHTML.match(/<BASE([^>]*)>/ig);
	if(arrTmp!=null)sBaseHREF=arrTmp[0];
	for(var i=0;i<oEditor.document.all.length;i++)
		if(oEditor.document.all[i].tagName=="BASE")oEditor.document.all[i].removeNode();
	for(var i=0;i<oEditor.document.all.length;i++)
		if(oEditor.document.all[i].tagName=="BASE")oEditor.document.all[i].removeNode();
	//~~~~~~~~~~~~~

	sHTML=recur(oEditor.document.body,"");
	return sHTML;
	}

function ApplyExternalStyle(oName)
	{
	var sTmp="";
	var myStyle=eval("myStyle"+oName);
	for(var i=0;i<myStyle.document.styleSheets(0).rules.length;i++)
		{
		sSelector=myStyle.document.styleSheets(0).rules.item(i).selectorText;
		sCssText=myStyle.document.styleSheets(0).rules.item(i).style.cssText.replace(/"/g,"&quot;");
		var itemCount = sSelector.split(".").length;
		if(itemCount>1) sTmp+=",[\""+sSelector+"\",true,\""+sSelector+"\",\""+ sCssText + "\"]";
		else sTmp+=",[\""+sSelector+"\",false,\"\",\""+ sCssText + "\"]";
		}
	var arrStyle = eval("["+sTmp.substr(1)+"]");

	if(arrStyle.length>0)
		{
		var oEditor=eval("idContent"+oName);
		var oElement=oEditor.document.createElement("<STYLE>");
		oEditor.document.documentElement.childNodes[0].appendChild(oElement);
		for(var i=0;i<arrStyle.length;i++)
			{
			selector=arrStyle[i][0];
			style=arrStyle[i][3].replace(/&quot;/g,"\"");
			if(style!="")
				{
				if(selector=="")selector="*";
				oEditor.document.styleSheets(0).addRule(selector,style);
				}
			}
		}
	eval(oName).arrStyle=arrStyle;
	}

/*********************
	REALTIME
**********************/
function editorDoc_onkeydown(oName)
	{
	realTime(oName);
	}
function editorDoc_onkeyup(oName)
	{
	if(eval(oName).isAfterPaste)
		{
		//*** RUNTIME STYLES ***
		eval(oName).runtimeBorder(false);
		eval(oName).runtimeStyles();
		//***********************
		eval(oName).isAfterPaste=false;
		}
	realTime(oName);
	}
function editorDoc_onmouseup(oName)
	{
	oUtil.activeElement=null;//focus ke editor, jgn pakai selection dari tag selector
	oUtil.oName=oName;oUtil.oEditor=eval("idContent"+oName);oUtil.obj=eval(oName);eval(oName).hide();//pengganti onfocus
	realTime(oName);
	}
function setActiveEditor(oName)
	{
	//eval(oName).focus();//focus first
	oUtil.oName=oName;
	oUtil.oEditor=eval("idContent"+oName);
	oUtil.obj=eval(oName);
	}
var arrTmp=[];
function GetElement(oElement,sMatchTag)//Used in realTime() only.
	{
	while (oElement!=null&&oElement.tagName!=sMatchTag)
		{
		if(oElement.tagName=="BODY")return null;
		oElement=oElement.parentElement;
		}
	return oElement;
	}
var arrTmp2=[];//TAG SELECTOR
function realTime(oName)
	{
	//Focus stuff
	if(!eval(oName).checkFocus())return;

	var oEditor=eval("idContent"+oName);
	var oSel=oEditor.document.selection.createRange();
	var obj=eval(oName);

	//Enable/Disable Table Edit & Cell Edit Menu
	if(obj.btnTable)
		{
		obj.arrElm[1].style.color="gray";
		obj.arrElm[2].style.color="gray";
		obj.arrElm[3].style.color="gray";
		var oTable=(oSel.parentElement!=null?GetElement(oSel.parentElement(),"TABLE"):GetElement(oSel.item(0),"TABLE"));
		if (oTable)
			{
			obj.arrElm[1].style.color="black";
			obj.arrElm[2].style.color="black";
			obj.arrElm[3].style.color="gray";
			makeEnableNormal(obj.arrElm[0]);
			}
		else makeDisabled(obj.arrElm[0]);

		var oTD=(oSel.parentElement!=null?GetElement(oSel.parentElement(),"TD"):GetElement(oSel.item(0),"TD"));
		if (oTD)
			{
			obj.arrElm[1].style.color="black";
			obj.arrElm[2].style.color="black";
			obj.arrElm[3].style.color="black";
			}
		}

	//REALTIME BUTTONS HERE
	if(obj.btnParagraph)
		{
		if(oEditor.document.queryCommandEnabled("FormatBlock"))
			makeEnableNormal(obj.arrElm[4]);
		else makeDisabled(obj.arrElm[4]);
		}
	if(obj.btnFontName)
		{
		if(oEditor.document.queryCommandEnabled("FontName"))
			makeEnableNormal(obj.arrElm[5]);
		else makeDisabled(obj.arrElm[5]);
		}
	if(obj.btnFontSize)
		{
		if(oEditor.document.queryCommandEnabled("FontSize"))
			makeEnableNormal(obj.arrElm[6]);
		else makeDisabled(obj.arrElm[6]);
		}
	if(obj.btnCut)
		{
		if(oEditor.document.queryCommandEnabled("Cut"))
			makeEnableNormal(obj.arrElm[7]);
		else makeDisabled(obj.arrElm[7]);
		}
	if(obj.btnCopy)
		{
		if(oEditor.document.queryCommandEnabled("Copy"))
			makeEnableNormal(obj.arrElm[8]);
		else makeDisabled(obj.arrElm[8]);
		}
	if(obj.btnPaste)
		{
		if(oEditor.document.queryCommandEnabled("Paste"))
			makeEnableNormal(obj.arrElm[9]);
		else makeDisabled(obj.arrElm[9]);
		}
	if(obj.btnPasteWord)
		{
		if(oEditor.document.queryCommandEnabled("Paste"))
			makeEnableNormal(obj.arrElm[10]);
		else makeDisabled(obj.arrElm[10]);
		}
	if(obj.btnPasteText)
		{
		if(oEditor.document.queryCommandEnabled("Paste"))
			makeEnableNormal(obj.arrElm[11]);
		else makeDisabled(obj.arrElm[11]);
		}

	if(obj.btnUndo)
		{
		if(!obj.arrUndoList[0])makeDisabled(obj.arrElm[12]);
		else makeEnableNormal(obj.arrElm[12]);
		}
	if(obj.btnRedo)
		{
		if(!obj.arrRedoList[0])makeDisabled(obj.arrElm[13]);
		else makeEnableNormal(obj.arrElm[13]);
		}

	if(obj.btnBold)
		{
		if(oEditor.document.queryCommandEnabled("Bold"))
			{
			if(oEditor.document.queryCommandState("Bold"))
				makeEnablePushed(obj.arrElm[14]);
			else makeEnableNormal(obj.arrElm[14]);
			}
		else makeDisabled(obj.arrElm[14]);
		}
	if(obj.btnItalic)
		{
		if(oEditor.document.queryCommandEnabled("Italic"))
			{
			if(oEditor.document.queryCommandState("Italic"))
				makeEnablePushed(obj.arrElm[15]);
			else makeEnableNormal(obj.arrElm[15]);
			}
		else makeDisabled(obj.arrElm[15]);
		}
	if(obj.btnUnderline)
		{
		if(oEditor.document.queryCommandEnabled("Underline"))
			{
			if(oEditor.document.queryCommandState("Underline"))
				makeEnablePushed(obj.arrElm[16]);
			else makeEnableNormal(obj.arrElm[16]);
			}
		else makeDisabled(obj.arrElm[16]);
		}
	if(obj.btnStrikethrough)
		{
		if(oEditor.document.queryCommandEnabled("Strikethrough"))
			{
			if(oEditor.document.queryCommandState('Strikethrough'))
				makeEnablePushed(obj.arrElm[17]);
			else makeEnableNormal(obj.arrElm[17]);
			}
		else makeDisabled(obj.arrElm[17]);
		}
	if(obj.btnSuperscript)
		{
		if(oEditor.document.queryCommandEnabled("Superscript"))
			{
			if(oEditor.document.queryCommandState("Superscript"))
				makeEnablePushed(obj.arrElm[18]);
			else makeEnableNormal(obj.arrElm[18]);
			}
		else makeDisabled(obj.arrElm[18]);
		}
	if(obj.btnSubscript)
		{
		if(oEditor.document.queryCommandEnabled("Subscript"))
			{
			if(oEditor.document.queryCommandState("Subscript"))
				makeEnablePushed(obj.arrElm[19]);
			else makeEnableNormal(obj.arrElm[19]);
			}
		else makeDisabled(obj.arrElm[19]);
		}
	if(obj.btnNumbering)
		{
		if(oEditor.document.queryCommandEnabled("InsertOrderedList"))
			{
			if(oEditor.document.queryCommandState("InsertOrderedList"))
				makeEnablePushed(obj.arrElm[20]);
			else makeEnableNormal(obj.arrElm[20]);
			}
		else makeDisabled(obj.arrElm[20]);
		}
	if(obj.btnBullets)
		{
		if(oEditor.document.queryCommandEnabled("InsertUnorderedList"))
			{
			if(oEditor.document.queryCommandState("InsertUnorderedList"))
				makeEnablePushed(obj.arrElm[21]);
			else makeEnableNormal(obj.arrElm[21]);
			}
		else makeDisabled(obj.arrElm[21]);
		}
	if(obj.btnJustifyLeft)
		{
		if(oEditor.document.queryCommandEnabled("JustifyLeft"))
			{
			if(oEditor.document.queryCommandState("JustifyLeft"))
				makeEnablePushed(obj.arrElm[22]);
			else makeEnableNormal(obj.arrElm[22]);
			}
		else makeDisabled(obj.arrElm[22]);
		}
	if(obj.btnJustifyCenter)
		{
		if(oEditor.document.queryCommandEnabled("JustifyCenter"))
			{
			if(oEditor.document.queryCommandState("JustifyCenter"))
				makeEnablePushed(obj.arrElm[23]);
			else makeEnableNormal(obj.arrElm[23]);
			}
		else makeDisabled(obj.arrElm[23]);
		}
	if(obj.btnJustifyRight)
		{
		if(oEditor.document.queryCommandEnabled("JustifyRight"))
			{
			if(oEditor.document.queryCommandState("JustifyRight"))
				makeEnablePushed(obj.arrElm[24]);
			else makeEnableNormal(obj.arrElm[24]);
			}
		else makeDisabled(obj.arrElm[24]);
		}
	if(obj.btnJustifyFull)
		{
		if(oEditor.document.queryCommandEnabled("JustifyFull"))
			{
			if(oEditor.document.queryCommandState("JustifyFull"))
				makeEnablePushed(obj.arrElm[25]);
			else makeEnableNormal(obj.arrElm[25]);
			}
		else makeDisabled(obj.arrElm[25]);
		}

	if(obj.btnIndent)
		{
		if(oEditor.document.queryCommandEnabled("Indent"))
			makeEnableNormal(obj.arrElm[26]);
		else makeDisabled(obj.arrElm[26]);
		}
	if(obj.btnOutdent)
		{
		if(oEditor.document.queryCommandEnabled("Outdent"))
			makeEnableNormal(obj.arrElm[27]);
		else makeDisabled(obj.arrElm[27]);
		}

	if(obj.btnLTR)
		{
		if(oEditor.document.queryCommandEnabled("BlockDirLTR"))
			{
			if(oEditor.document.queryCommandState("BlockDirLTR"))
				makeEnablePushed(obj.arrElm[28]);
			else makeEnableNormal(obj.arrElm[28]);
			}
		else makeDisabled(obj.arrElm[28]);
		}
	if(obj.btnRTL)
		{
		if(oEditor.document.queryCommandEnabled("BlockDirRTL"))
			{
			if(oEditor.document.queryCommandState("BlockDirRTL"))
				makeEnablePushed(obj.arrElm[29]);
			else makeEnableNormal(obj.arrElm[29]);
			}
		else makeDisabled(obj.arrElm[29]);
		}

	if(oSel.parentElement)
		{
		if(obj.btnForeColor)makeEnableNormal(obj.arrElm[30]);
		if(obj.btnBackColor)makeEnableNormal(obj.arrElm[31]);
		if(obj.btnLine)makeEnableNormal(obj.arrElm[32]);
		}
	else
		{
		if(obj.btnForeColor)makeDisabled(obj.arrElm[30]);
		if(obj.btnBackColor)makeDisabled(obj.arrElm[31]);
		if(obj.btnLine)makeDisabled(obj.arrElm[32]);
		}
	try{oUtil.onSelectionChanged()}catch(e){;}

	try{obj.onSelectionChanged()}catch(e){;}

	//TAG SELECTOR ~~~~~~~~~~~~~~~~~~
	if(obj.useTagSelector)
		{
		if (oSel.parentElement)	oElement=oSel.parentElement();
		else oElement=oSel.item(0);
		var sHTML="";var i=0;
		arrTmp2=[];//clear
		while (oElement!=null && oElement.tagName!="BODY")
			{
			arrTmp2[i]=oElement;
			var sTagName = oElement.tagName;
			sHTML = "&nbsp; &lt;<span id=tag"+oName+i+" unselectable=on style='text-decoration:underline;cursor:hand' onclick=\""+oName+".selectElement("+i+")\">" + sTagName + "</span>&gt;" + sHTML;
			oElement = oElement.parentElement;
			i++;
			}
		sHTML = "&nbsp;&lt;BODY&gt;" + sHTML;
		eval("idElNavigate"+oName).innerHTML = sHTML;
		eval("idElCommand"+oName).style.display="none";
		}
	}
function realtimeFontSelect(oName)
	{
	var oEditor=eval("idContent"+oName);
	var sFontName = oEditor.document.queryCommandValue("FontName");
	var iCols = eval("dropFontName"+oName).rows[0].childNodes.length;
	for(var i=0;i<iCols;i++)
		{
		var oFontTable=eval("dropFontName"+oName).rows[0].childNodes[i].childNodes[0];
		var rowFonts = oFontTable.rows;
		for(var j=0;j<rowFonts.length;j++)
			{
			if(sFontName+")"==rowFonts[j].innerText.split("(")[1])
				{
				rowFonts[j].childNodes[0].style.backgroundColor="#708090";
				rowFonts[j].childNodes[0].style.color="#FFFFFF";
				}
			else
				{
				rowFonts[j].childNodes[0].style.backgroundColor="";
				rowFonts[j].childNodes[0].style.color="#000000";
				}
			}
		}
	}
function realtimeSizeSelect(oName)
	{
	var oEditor=eval("idContent"+oName);
	var sFontSize=oEditor.document.queryCommandValue("FontSize");
	var rowFonts=eval("dropFontSize"+oName).rows;
	for(var i=0;i<rowFonts.length;i++)
		{
		if("Size "+sFontSize==rowFonts[i].innerText)
			{
			rowFonts[i].childNodes[0].style.backgroundColor="#708090";
			rowFonts[i].childNodes[0].style.color="#FFFFFF";
			}
		else
			{
			rowFonts[i].childNodes[0].style.backgroundColor="";
			rowFonts[i].childNodes[0].style.color="#000000";
			}
		}
	}

/*********************
	TAG SELECTOR
**********************/
function moveTagSelector()
	{
	var sTagSelTop="<table unselectable=on ondblclick='"+this.oName+".moveTagSelector()' width='100%' cellpadding=0 cellspacing=0><tr style='background:#e7e7e7;font-family:arial;font-size:10px;color:black;'>"+
		"<td id=idElNavigate"+ this.oName +" style='padding:1px;width:100%' valign=top>&nbsp;</td>"+
		"<td align=right valign=top nowrap>"+
		"<span id=idElCommand"+ this.oName +" unselectable=on style='display:none;text-decoration:underline;cursor:hand;padding-right:5;' onclick='"+this.oName+".removeTag()'>"+getText("Remove Tag")+"</span>"+
		"</td></tr></table>";

	var sTagSelBottom="<table unselectable=on ondblclick='"+this.oName+".moveTagSelector()' width='100%' cellpadding=0 cellspacing=0><tr style='background:#e7e7e7;font-family:arial;font-size:10px;color:black;'>"+
		"<td id=idElNavigate"+ this.oName +" style='padding:1px;width:100%' valign=top>&nbsp;</td>"+
		"<td align=right valign=top nowrap>"+
		"<span id=idElCommand"+ this.oName +" unselectable=on style='display:none;text-decoration:underline;cursor:hand;padding-right:5;' onclick='"+this.oName+".removeTag()'>"+getText("Remove Tag")+"</span>"+
		"</td></tr></table>";

	if(this.TagSelectorPosition=="top")
		{
		eval("idTagSelTop"+this.oName).innerHTML="";
		eval("idTagSelBottom"+this.oName).innerHTML=sTagSelBottom;
		eval("idTagSelTopRow"+this.oName).style.display="none";
		eval("idTagSelBottomRow"+this.oName).style.display="block";
		this.TagSelectorPosition="bottom"
		}
	else//if(this.TagSelectorPosition=="bottom")
		{
		eval("idTagSelTop"+this.oName).innerHTML=sTagSelTop;
		eval("idTagSelBottom"+this.oName).innerHTML="";
		eval("idTagSelTopRow"+this.oName).style.display="block";
		eval("idTagSelBottomRow"+this.oName).style.display="none";
		this.TagSelectorPosition="top"
		}
	}
function selectElement(i)
	{
	var oEditor=eval("idContent"+this.oName);
	var oSelRange = oEditor.document.body.createControlRange();
	var oActiveElement;
	try
		{
		oSelRange.add(arrTmp2[i]);
		oSelRange.select();
		realTime(this.oName);
		oActiveElement = arrTmp2[i];
		if(oActiveElement.tagName!="TD"&&
			oActiveElement.tagName!="TR"&&
			oActiveElement.tagName!="TBODY"&&
			oActiveElement.tagName!="LI")
			eval("idElCommand"+this.oName).style.display="block";	
		}
	catch(e)
		{
		try//utk multiple instance, kalau select tag tapi tdk focus atau select list & content lain di luar list lalu set color
			{
			var oSelRange = oEditor.document.body.createTextRange();
			oSelRange.moveToElementText(arrTmp2[i]);
			oSelRange.select();
			realTime(this.oName);
			oActiveElement = arrTmp2[i];
			if(oActiveElement.tagName!="TD"&&
				oActiveElement.tagName!="TR"&&
				oActiveElement.tagName!="TBODY"&&
				oActiveElement.tagName!="LI")
				eval("idElCommand"+this.oName).style.display="block";
			}
		catch(e){return;}
		}
	for(var j=0;j<arrTmp2.length;j++)eval("tag"+this.oName+j).style.background="";
	eval("tag"+this.oName+i).style.background="DarkGray";

	if(oActiveElement)
		oUtil.activeElement=oActiveElement;//Set active element in the Editor
	}
function removeTag()
	{
	if(!this.checkFocus())return;//Focus stuff
	eval(this.oName).saveForUndo();//Save for Undo
	var oEditor=eval("idContent"+this.oName);
	var oSel=oEditor.document.selection.createRange();
	var sType=oEditor.document.selection.type;
	if(sType=="Control")
		{
		oSel.item(0).outerHTML="";
		this.focus();
		realTime(this.oName);
		return;
		}

	var oActiveElement=oUtil.activeElement;
	var oSelRange = oEditor.document.body.createTextRange();
	oSelRange.moveToElementText(oActiveElement);
	oSel.setEndPoint("StartToStart",oSelRange);
	oSel.setEndPoint("EndToEnd",oSelRange);
	oSel.select();

	sHTML=oActiveElement.innerHTML;
	var arrA = String(sHTML).match(/<A[^>]*>/g);
	if(arrA)
		for(var i=0;i<arrA.length;i++)
			{
			sTmp = arrA[i].replace(/href=/,"href_iwe=");
			sHTML=String(sHTML).replace(arrA[i],sTmp);
			}
	var arrB = String(sHTML).match(/<IMG[^>]*>/g);
	if(arrB)
		for(var i=0;i<arrB.length;i++)
			{
			sTmp = arrB[i].replace(/src=/,"src_iwe=");
			sHTML=String(sHTML).replace(arrB[i],sTmp);
			}

	var oTmp=oActiveElement.parentElement;
	if(oTmp.innerHTML==oActiveElement.outerHTML)//<b><u>TEXT</u><b> (<u> is selected)
		{//oTmp=<b> , oActiveElement=<u>
		oTmp.innerHTML=sHTML;

		for(var i=0;i<oEditor.document.all.length;i++)
			{
			if(oEditor.document.all[i].getAttribute("href_iwe"))
				{
				oEditor.document.all[i].href=oEditor.document.all[i].getAttribute("href_iwe");
				oEditor.document.all[i].removeAttribute("href_iwe",0);
				}
			if(oEditor.document.all[i].getAttribute("src_iwe"))
				{
				oEditor.document.all[i].src=oEditor.document.all[i].getAttribute("src_iwe");
				oEditor.document.all[i].removeAttribute("src_iwe",0);
				}
			}

		var oSelRange = oEditor.document.body.createTextRange();
		oSelRange.moveToElementText(oTmp);
		oSel.setEndPoint("StartToStart",oSelRange);
		oSel.setEndPoint("EndToEnd",oSelRange);
		oSel.select();
		realTime(this.oName);
		this.selectElement(0);
		return;
		}
	else
		{
		oActiveElement.outerHTML="";
		oSel.pasteHTML(sHTML);

		for(var i=0;i<oEditor.document.all.length;i++)
			{
			if(oEditor.document.all[i].getAttribute("href_iwe"))
				{
				oEditor.document.all[i].href=oEditor.document.all[i].getAttribute("href_iwe");
				oEditor.document.all[i].removeAttribute("href_iwe",0);
				}
			if(oEditor.document.all[i].getAttribute("src_iwe"))
				{
				oEditor.document.all[i].src=oEditor.document.all[i].getAttribute("src_iwe");
				oEditor.document.all[i].removeAttribute("src_iwe",0);
				}
			}
		this.focus();
		realTime(this.oName);
		}

	//*** RUNTIME STYLES ***
	this.runtimeBorder(false);
	this.runtimeStyles();
	//***********************
	}

/*********************
	RUNTIME BORDERS
**********************/
function runtimeBorderOn()
	{
	this.runtimeBorderOff();//reset

	var oEditor=eval("idContent"+this.oName);
	var oTables=oEditor.document.getElementsByTagName("TABLE");
	for(i=0;i<oTables.length;i++)
		{
		if(oTables[i].border==0)
			{
			for(j=0;j<oTables[i].getElementsByTagName("TD").length;j++)
				{
				if(oTables[i].getElementsByTagName("TD")[j].style.borderLeftWidth=="0px"||
					oTables[i].getElementsByTagName("TD")[j].style.borderLeftWidth==""||
					oTables[i].getElementsByTagName("TD")[j].style.borderLeftWidth=="medium")
						{
						oTables[i].getElementsByTagName("TD")[j].runtimeStyle.borderLeftWidth=1;
						oTables[i].getElementsByTagName("TD")[j].runtimeStyle.borderLeftColor="#BCBCBC";
						oTables[i].getElementsByTagName("TD")[j].runtimeStyle.borderLeftStyle="dotted";
						}
				if(oTables[i].getElementsByTagName("TD")[j].style.borderRightWidth=="0px"||
					oTables[i].getElementsByTagName("TD")[j].style.borderRightWidth==""||
					oTables[i].getElementsByTagName("TD")[j].style.borderRightWidth=="medium")
						{
						oTables[i].getElementsByTagName("TD")[j].runtimeStyle.borderRightWidth=1;
						oTables[i].getElementsByTagName("TD")[j].runtimeStyle.borderRightColor="#BCBCBC";
						oTables[i].getElementsByTagName("TD")[j].runtimeStyle.borderRightStyle="dotted";
						}
				if(oTables[i].getElementsByTagName("TD")[j].style.borderTopWidth=="0px"||
					oTables[i].getElementsByTagName("TD")[j].style.borderTopWidth==""||
					oTables[i].getElementsByTagName("TD")[j].style.borderTopWidth=="medium")
						{
						oTables[i].getElementsByTagName("TD")[j].runtimeStyle.borderTopWidth=1;
						oTables[i].getElementsByTagName("TD")[j].runtimeStyle.borderTopColor="#BCBCBC";
						oTables[i].getElementsByTagName("TD")[j].runtimeStyle.borderTopStyle="dotted";
						}
				if(oTables[i].getElementsByTagName("TD")[j].style.borderBottomWidth=="0px"||
					oTables[i].getElementsByTagName("TD")[j].style.borderBottomWidth==""||
					oTables[i].getElementsByTagName("TD")[j].style.borderBottomWidth=="medium")
						{
						oTables[i].getElementsByTagName("TD")[j].runtimeStyle.borderBottomWidth=1;
						oTables[i].getElementsByTagName("TD")[j].runtimeStyle.borderBottomColor="#BCBCBC";
						oTables[i].getElementsByTagName("TD")[j].runtimeStyle.borderBottomStyle="dotted";
						}
				}
			}
		}
	}
function runtimeBorderOff()
	{
	var oEditor=eval("idContent"+this.oName);
	var oTables=oEditor.document.getElementsByTagName("TABLE");
	for(i=0;i<oTables.length;i++)
		{
		if(oTables[i].border==0)
			{
			for(j=0;j<oTables[i].getElementsByTagName("TD").length;j++)
				{
				oTables[i].getElementsByTagName("TD")[j].runtimeStyle.borderWidth="";
				oTables[i].getElementsByTagName("TD")[j].runtimeStyle.borderColor="";
				oTables[i].getElementsByTagName("TD")[j].runtimeStyle.borderStyle="";
				}
			}
		}
	}
function runtimeBorder(bToggle)
	{
	if(bToggle)
		{
		if(this.IsRuntimeBorderOn)
			{
			this.runtimeBorderOff();
			this.IsRuntimeBorderOn=false;
			}
		else
			{
			this.runtimeBorderOn();
			this.IsRuntimeBorderOn=true;
			}
		}
	else
		{//refresh based on the current status
		if(this.IsRuntimeBorderOn) this.runtimeBorderOn();
		else this.runtimeBorderOff();
		}
	}

/*********************
	RUNTIME STYLES
**********************/
function runtimeStyles()
	{
	var oEditor=eval("idContent"+this.oName);
	var oForms=oEditor.document.getElementsByTagName("FORM");
	for (i=0;i<oForms.length;i++) oForms[i].runtimeStyle.border="#7bd158 1px dotted";

	var oBookmarks=oEditor.document.getElementsByTagName("A");
	for (i=0;i<oBookmarks.length;i++)
		{
		if(oBookmarks[i].name||oBookmarks[i].NAME)
			{
			if(oBookmarks[i].innerHTML=="")oBookmarks[i].runtimeStyle.width="1px";
			oBookmarks[i].runtimeStyle.padding="0px";
			oBookmarks[i].runtimeStyle.paddingLeft="1px";
			oBookmarks[i].runtimeStyle.paddingRight="1px";
			oBookmarks[i].runtimeStyle.border="#888888 1 dotted";
			oBookmarks[i].runtimeStyle.borderLeft="#cccccc 10 solid";
			}
		}
	}

/*********************
	OTHERS
**********************/
function doCmd(sCmd,sOption)
	{
	if(!this.checkFocus())return;//Focus stuff
	eval(this.oName).saveForUndo();//Save for Undo
	var oEditor=eval("idContent"+this.oName);
	var oSel=oEditor.document.selection.createRange();
	var sType=oEditor.document.selection.type;
	var oTarget=(sType=="None"?oEditor.document:oSel);
	oTarget.execCommand(sCmd,false,sOption);
	realTime(this.oName);
	}
function applyColor(sType,sColor)
	{
	this.hide();
	this.focus();//Focus stuff
	var oEditor=eval("idContent"+this.oName);
	var oSel=oEditor.document.selection.createRange();
	this.saveForUndo();
	oSel.execCommand(sType,false,sColor);
	realTime(this.oName);
	if(sColor=="")return;
	this.selectElement(0);
	}
function applyParagraph(val)
	{
	var oEditor=eval("idContent"+this.oName);
	var oSel=oEditor.document.selection.createRange();
	this.hide();
	oSel.select();
	this.doCmd("FormatBlock",val);
	}
function applyFontName(val)
	{
	var oEditor=eval("idContent"+this.oName);
	var oSel=oEditor.document.selection.createRange();
	this.hide();//ini menyebabkan text yg ter-select menjadi tdk ter-select di framed-page.
	//Solusi: oSel di select lagi
	oSel.select();
	this.doCmd("fontname",val);
	}
function applyFontSize(val)
	{
	var oEditor=eval("idContent"+this.oName);
	var oSel=oEditor.document.selection.createRange();
	this.hide();
	oSel.select();
	this.doCmd("fontsize",val);
	}
function applyBullets()
	{
	this.doCmd("InsertUnOrderedList");
	makeEnableNormal(eval("document.all.btnNumbering"+this.oName));

	var oEditor=eval("idContent"+this.oName);
	var oSel=oEditor.document.selection.createRange();
	var oElement=oSel.parentElement();
	while (oElement!=null&&oElement.tagName!="OL"&&oElement.tagName!="UL")
		{
		if(oElement.tagName=="BODY")return;
		oElement=oElement.parentElement;
		}
	oElement.removeAttribute("type",0);
	oElement.style.listStyleImage="";
	}
function applyNumbering()
	{
	this.doCmd("InsertOrderedList");
	makeEnableNormal(eval("document.all.btnBullets"+this.oName));

	var oEditor=eval("idContent"+this.oName);
	var oSel=oEditor.document.selection.createRange();
	var oElement=oSel.parentElement();
	while (oElement!=null&&oElement.tagName!="OL"&&oElement.tagName!="UL")
		{
		if(oElement.tagName=="BODY")return;
		oElement=oElement.parentElement;
		}
	oElement.removeAttribute("type",0);
	oElement.style.listStyleImage="";
	}
function applyJustifyLeft()
	{
	this.doCmd("JustifyLeft");
	if(this.btnJustifyCenter) makeEnableNormal(eval("document.all.btnJustifyCenter"+this.oName));
	if(this.btnJustifyRight) makeEnableNormal(eval("document.all.btnJustifyRight"+this.oName));
	if(this.btnJustifyFull) makeEnableNormal(eval("document.all.btnJustifyFull"+this.oName));
	}
function applyJustifyCenter()
	{
	this.doCmd("JustifyCenter");
	if(this.btnJustifyLeft) makeEnableNormal(eval("document.all.btnJustifyLeft"+this.oName));
	if(this.btnJustifyRight) makeEnableNormal(eval("document.all.btnJustifyRight"+this.oName));
	if(this.btnJustifyFull) makeEnableNormal(eval("document.all.btnJustifyFull"+this.oName));
	}
function applyJustifyRight()
	{
	this.doCmd("JustifyRight");
	if(this.btnJustifyLeft) makeEnableNormal(eval("document.all.btnJustifyLeft"+this.oName));
	if(this.btnJustifyCenter) makeEnableNormal(eval("document.all.btnJustifyCenter"+this.oName));
	if(this.btnJustifyFull) makeEnableNormal(eval("document.all.btnJustifyFull"+this.oName));
	}
function applyJustifyFull()
	{
	this.doCmd("JustifyFull");
	if(this.btnJustifyLeft) makeEnableNormal(eval("document.all.btnJustifyLeft"+this.oName));
	if(this.btnJustifyCenter) makeEnableNormal(eval("document.all.btnJustifyCenter"+this.oName));
	if(this.btnJustifyRight) makeEnableNormal(eval("document.all.btnJustifyRight"+this.oName));
	}
function applyBlockDirLTR()
	{
	this.doCmd("BlockDirLTR");
	if(this.btnRTL) makeEnableNormal(eval("document.all.btnRTL"+this.oName));
	}
function applyBlockDirRTL()
	{
	this.doCmd("BlockDirRTL");
	if(this.btnLTR) makeEnableNormal(eval("document.all.btnLTR"+this.oName));
	}
function doPaste()
	{
	this.doCmd("Paste");
	//*** RUNTIME BORDERS ***
	this.runtimeBorder(false);
	//***********************
	}
function doPasteText()
	{
	if(!this.checkFocus())return;//Focus stuff
	var oEditor=eval("idContent"+this.oName);
	var oSel=oEditor.document.selection.createRange();
	this.saveForUndo();
	var oWord = eval("idContentWord"+this.oName);
	oWord.focus();
	oWord.document.execCommand("SelectAll");
	oWord.document.execCommand("Paste");
	oSel.pasteHTML(oWord.document.body.innerText);
	}
function insertCustomTag(sTag)
	{
	this.insertHTML(sTag);
	this.hide();
	this.focus();
	}
function expandSelection()
	{
	if(!this.checkFocus())return;//Focus stuff
	var oEditor=eval("idContent"+this.oName);
	var oSel=oEditor.document.selection.createRange();

	if(oSel.text!="")return;

	/*
	var oElement = oSel.parentElement();
	if(oElement.tagName!="BODY")
		{
		var oSelRange=oEditor.document.body.createTextRange();
		oSelRange.moveToElementText(oElement);
		oSel.setEndPoint("StartToStart",oSelRange);
		oSel.setEndPoint("EndToEnd",oSelRange);
		oSel.select();
		return;
		}*/

	oSel.expand("word");
	oSel.select();
	if(oSel.text.substr(oSel.text.length*1-1,oSel.text.length)==" ")
		{
		oSel.moveEnd("character",-1);
		oSel.select();
		}
	}
function selectParagraph()
	{
	if(!this.checkFocus())return;//Focus stuff
	var oEditor=eval("idContent"+this.oName);
	var oSel=oEditor.document.selection.createRange();

	if(oSel.parentElement)
		{
		if(oSel.text=="")
			{
			var oElement=oSel.parentElement();
			while (oElement!=null&&
				oElement.tagName!="H1"&&oElement.tagName!="H2"&&
				oElement.tagName!="H3"&&oElement.tagName!="H4"&&
				oElement.tagName!="H5"&&oElement.tagName!="H6"&&
				oElement.tagName!="PRE"&&oElement.tagName!="P"&&
				oElement.tagName!="DIV")
				{
				if(oElement.tagName=="BODY")return;
				oElement=oElement.parentElement;
				}
			var oSelRange = oEditor.document.body.createControlRange();
			try
				{
				oSelRange.add(oElement);
				oSelRange.select();
				}
			catch(e)
				{
				var oSelRange = oEditor.document.body.createTextRange();
				try{oSelRange.moveToElementText(oElement);
					oSelRange.select()
					}catch(e){;}
				}
			}
		}
	}
function insertHTML(sHTML)
	{
	this.focus();

	//if(!this.checkFocus())return;//Focus stuff
	var oEditor=eval("idContent"+this.oName);
	var oSel=oEditor.document.selection.createRange();

	var arrA = String(sHTML).match(/<A[^>]*>/ig);
	if(arrA)
		for(var i=0;i<arrA.length;i++)
			{
			sTmp = arrA[i].replace(/href=/,"href_iwe=");
			sHTML=String(sHTML).replace(arrA[i],sTmp);
			}

	var arrB = String(sHTML).match(/<IMG[^>]*>/ig);
	if(arrB)
		for(var i=0;i<arrB.length;i++)
			{
			sTmp = arrB[i].replace(/src=/,"src_iwe=");
			sHTML=String(sHTML).replace(arrB[i],sTmp);
			}

	if(oSel.parentElement)oSel.pasteHTML(sHTML);
	else oSel.item(0).outerHTML=sHTML;

	for(var i=0;i<oEditor.document.all.length;i++)
		{
		if(oEditor.document.all[i].getAttribute("href_iwe"))
			{
			oEditor.document.all[i].href=oEditor.document.all[i].getAttribute("href_iwe");
			oEditor.document.all[i].removeAttribute("href_iwe",0);
			}
		if(oEditor.document.all[i].getAttribute("src_iwe"))
			{
			oEditor.document.all[i].src=oEditor.document.all[i].getAttribute("src_iwe");
			oEditor.document.all[i].removeAttribute("src_iwe",0);
			}
		}
	}
function insertLink(url,title,target)
	{
	this.focus();//Focus stuff

	var oEditor=eval("idContent"+this.oName);
	var oSel=oEditor.document.selection.createRange();

	if(oSel.parentElement)
		{
		if(oSel.text=="")
			{
			var oSelTmp=oSel.duplicate();
			if(title!="" && title!=undefined) oSel.text=title;
			else oSel.text=url;
			oSel.setEndPoint("StartToStart",oSelTmp);
			oSel.select();
			}
		}
	oSel.execCommand("CreateLink",false,url);

	if (oSel.parentElement)	oEl=GetElement(oSel.parentElement(),"A");
	else oEl=GetElement(oSel.item(0),"A");
	if(oEl)
		{
		if(target!="" && target!=undefined)oEl.target=target;
		}
	}
function clearAll()
	{
	if(confirm(getText("Are you sure you wish to delete all contents?"))==true)
		{
		var oEditor=eval("idContent"+this.oName);
		oEditor.document.body.innerHTML="";
		}
	}
function spellcheckDialogShow()
	{
	window.open(this.scriptPath+"spellcheck.htm","","width=500,height=222;toolbar=no,menubar=no,location=no,directories=no,status=yes")
	}
function doClean()
	{
	if(!this.checkFocus())return;//Focus stuff
	eval(this.oName).saveForUndo();//Save for Undo

	if(oUtil.activeElement)
		{
		var oActiveElement=oUtil.activeElement;
		oActiveElement.removeAttribute("className",0);
		oActiveElement.removeAttribute("style",0);

		if(oActiveElement.tagName=="H1"||oActiveElement.tagName=="H2"||
			oActiveElement.tagName=="H3"||oActiveElement.tagName=="H4"||
			oActiveElement.tagName=="H5"||oActiveElement.tagName=="H6"||
			oActiveElement.tagName=="PRE"||oActiveElement.tagName=="P"||
			oActiveElement.tagName=="DIV")
			{
			if(this.useDIV)this.doCmd('FormatBlock','<DIV>');
			else this.doCmd('FormatBlock','<P>');
			}
		}
	else
		{
		var oEditor=eval("idContent"+this.oName);
		var oSel=oEditor.document.selection.createRange();
		var sType=oEditor.document.selection.type;
		if (oSel.parentElement)
			{
			oEl=oSel.parentElement();
			if(oEl.outerHTML==oSel.htmlText)
				{
				oEl.removeAttribute("className",0);
				oEl.removeAttribute("style",0);
				if(oEl.tagName=="H1"||oEl.tagName=="H2"||
					oEl.tagName=="H3"||oEl.tagName=="H4"||
					oEl.tagName=="H5"||oEl.tagName=="H6"||
					oEl.tagName=="PRE"||oEl.tagName=="P"||oEl.tagName=="DIV")
					{
					if(this.useDIV)this.doCmd('FormatBlock','<DIV>');
					else this.doCmd('FormatBlock','<P>');
					}
				}
			}
		else
			{
			oEl=oSel.item(0);
			oEl.removeAttribute("className",0);
			oEl.removeAttribute("style",0);
			}
		}
	this.doCmd('RemoveFormat');
	realTime(this.oName);
	}
function applySpan()
	{
	if(!this.checkFocus())return;//Focus stuff
	var oEditor=eval("idContent"+this.oName);
	var oSel=oEditor.document.selection.createRange();
	var sType=oEditor.document.selection.type;
	if(sType=="Control"||sType=="None")return;

	sHTML=oSel.htmlText;

	var oParent=oSel.parentElement();
	if(oParent.tagName=="SPAN")
		{
		idSpan=oParent;
		return idSpan;
		}

	var arrA = String(sHTML).match(/<A[^>]*>/ig);
	if(arrA)
		for(var i=0;i<arrA.length;i++)
			{
			sTmp = arrA[i].replace(/href=/,"href_iwe=");
			sHTML=String(sHTML).replace(arrA[i],sTmp);
			}

	var arrB = String(sHTML).match(/<IMG[^>]*>/ig);
	if(arrB)
		for(var i=0;i<arrB.length;i++)
			{
			sTmp = arrB[i].replace(/src=/,"src_iwe=");
			sHTML=String(sHTML).replace(arrB[i],sTmp);
			}

	oSel.pasteHTML("<span id='idSpan__abc'>"+sHTML+"</span>");
	var idSpan=oEditor.document.all.idSpan__abc;

	var oSelRange=oEditor.document.body.createTextRange();
	oSelRange.moveToElementText(idSpan);
	oSel.setEndPoint("StartToStart",oSelRange);
	oSel.setEndPoint("EndToEnd",oSelRange);
	oSel.select();

	for(var i=0;i<oEditor.document.all.length;i++)
		{
		if(oEditor.document.all[i].getAttribute("href_iwe"))
			{
			oEditor.document.all[i].href=oEditor.document.all[i].getAttribute("href_iwe");
			oEditor.document.all[i].removeAttribute("href_iwe",0);
			}
		if(oEditor.document.all[i].getAttribute("src_iwe"))
			{
			oEditor.document.all[i].src=oEditor.document.all[i].getAttribute("src_iwe");
			oEditor.document.all[i].removeAttribute("src_iwe",0);
			}
		}

	idSpan.removeAttribute("id",0);
	return idSpan;
	}
function makeAbsolute()
	{
	if(!this.checkFocus())return;//Focus stuff
	var oEditor=eval("idContent"+this.oName);
	var oSel=oEditor.document.selection.createRange();

	if(oSel.parentElement)
		{
		var oElement=oSel.parentElement();
		oElement.style.position="absolute";
		}
	else
		this.doCmd("AbsolutePosition");
	}
function doKeyPress(evt,oName)
	{
	if(!eval(oName).arrUndoList[0]){eval(oName).saveForUndo();}//pengganti saveForUndo_First

	if(evt.ctrlKey)
		{
		if(evt.keyCode==89)
			{//CTRL-Y (Redo)
			eval(oName).doRedo();
			}
		if(evt.keyCode==90)
			{//CTRL-Z (Undo)
			eval(oName).doUndo();
			}
		if(evt.keyCode==65) 
			{//CTRL-A (Select All) => spy jalan di modal dialog
			eval(oName).doCmd("SelectAll");
			}
		}

	if(evt.keyCode==37||evt.keyCode==38||evt.keyCode==39||evt.keyCode==40)//Arrow
		{
		eval(oName).saveForUndo();//Save for Undo
		}
	if(evt.keyCode==13)
		{
		if(eval(oName).useDIV && !eval(oName).useBR)
			{
			var oSel=document.selection.createRange();

			if(oSel.parentElement)
				{
				eval(oName).saveForUndo();//Save for Undo

				if(GetElement(oSel.parentElement(),"FORM"))
					{
					var oSel=document.selection.createRange();
					oSel.pasteHTML('<br>');
					evt.cancelBubble=true;
					evt.returnValue=false;
					oSel.select();
					oSel.moveEnd("character", 1);
					oSel.moveStart("character", 1);
					oSel.collapse(false);
					return false;
					}
				else
					{
					var oEl = GetElement(oSel.parentElement(),"H1");
					if(!oEl) oEl = GetElement(oSel.parentElement(),"H2");
					if(!oEl) oEl = GetElement(oSel.parentElement(),"H3");
					if(!oEl) oEl = GetElement(oSel.parentElement(),"H4");
					if(!oEl) oEl = GetElement(oSel.parentElement(),"H5");
					if(!oEl) oEl = GetElement(oSel.parentElement(),"H6");
					if(!oEl) oEl = GetElement(oSel.parentElement(),"PRE");
					if(!oEl)eval(oName).doCmd("FormatBlock","<div>");
					return true;
					}
				}
			}
		if((eval(oName).useDIV && eval(oName).useBR)||
			(!eval(oName).useDIV && eval(oName).useBR))
			{
			var oSel=document.selection.createRange();
			oSel.pasteHTML('<br>');
			evt.cancelBubble=true;
			evt.returnValue=false;
			oSel.select();
			oSel.moveEnd("character", 1);
			oSel.moveStart("character", 1);
			oSel.collapse(false);
			return false;
			}
		eval(oName).saveForUndo();//Save for Undo
		}
	}
function fullScreen()
	{
	this.hide();

	var oEditor=eval("idContent"+this.oName);

	if(this.stateFullScreen)
		{
		this.onNormalScreen();
		this.stateFullScreen=false;
		document.body.style.overflow="";
		document.all.id_refresh_z_index.style.margin="0px";
		eval("idArea"+this.oName).style.position="";
		eval("idArea"+this.oName).style.top="0";
		eval("idArea"+this.oName).style.left="0";
		eval("idArea"+this.oName).style.width=this.width;
		eval("idArea"+this.oName).style.height=this.height;

		//fix undisplayed content
		if(this.initialRefresh)
			{
			oEditor.document.execCommand("SelectAll");
			window.setTimeout("eval('idContentWord"+this.oName+"').document.execCommand('SelectAll');",0);
			}

		for(var i=0;i<oUtil.arrEditor.length;i++)
			{
			if(oUtil.arrEditor[i]!=this.oName)eval("idArea"+oUtil.arrEditor[i]).style.display="block";
			}
		}
	else
		{
		this.onFullScreen();
		this.stateFullScreen=true;
		scroll(0,0);
		document.body.style.overflow="hidden";
		document.all.id_refresh_z_index.style.margin="70px";
		eval("idArea"+this.oName).style.position="absolute";
		eval("idArea"+this.oName).style.top="0";
		eval("idArea"+this.oName).style.left="0";

		//fix undisplayed content
		if(this.initialRefresh)
			{
			oEditor.document.execCommand("SelectAll");
			window.setTimeout("eval('idContentWord"+this.oName+"').document.execCommand('SelectAll');",0);
			}

		var numOfBrk=0;
		for(var j=0;j<this.buttonMap.length;j++)if(this.buttonMap[j]=="BRK")numOfBrk++;

		nToolbarHeight=(numOfBrk+1)*27;

		if (document.compatMode && document.compatMode!="BackCompat")
			{
			//using doctype
			try
				{
				var tes=dialogArguments;
				w=(document.body.offsetWidth);
				document.body.style.height="100%";
				h=document.body.offsetHeight-nToolbarHeight;
				document.body.style.height="";
				}
			catch(e)
				{
				w=(document.body.offsetWidth+20);
				document.body.style.height="100%";
				h=document.body.offsetHeight-nToolbarHeight;
				document.body.style.height="";
				}
			}
		else
			{
			if(document.body.style.overflow=="hidden")
				{
				w=document.body.offsetWidth;
				}
			else
				{
				w=document.body.offsetWidth-22;
				}
			h=document.body.offsetHeight-4;
			}

		eval("idArea"+this.oName).style.width=w;
		eval("idArea"+this.oName).style.height=h;

		for(var i=0;i<oUtil.arrEditor.length;i++)
			{
			if(oUtil.arrEditor[i]!=this.oName)eval("idArea"+oUtil.arrEditor[i]).style.display="none";
			}

		var oEditor=eval("idContent"+this.oName);
		oEditor.focus();
		}
	}

/*********************
	Table Insert Dropdown
**********************/
function doOver_TabCreate()
	{
	var oTD=event.srcElement;
	var oTable=oTD.parentElement.parentElement.parentElement;
	var nRow=oTD.parentElement.rowIndex;
	var nCol=oTD.cellIndex;
	var rows=oTable.rows;
	rows[rows.length-1].childNodes[0].innerHTML="<div align=right>"+(nRow*1+1) + " x " + (nCol*1+1) + " Table ...  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style='text-decoration:underline'>Advanced</span>&nbsp;</div>";
	for(var i=0;i<rows.length-1;i++)
		{
		var oRow=rows[i];
		for(var j=0;j<oRow.childNodes.length;j++)
			{
			var oCol=oRow.childNodes[j];
			if(i<=nRow&&j<=nCol)oCol.style.backgroundColor="#316ac5";
			else oCol.style.backgroundColor="#ffffff";
			}
		}
	event.cancelBubble=true;
	}
function doOut_TabCreate()
	{
	var oTable=event.srcElement;
	if(oTable.tagName!="TABLE")return;
	var rows=oTable.rows;
	rows[rows.length-1].childNodes[0].innerText=getText("Advanced Table Insert");
	for(var i=0;i<rows.length-1;i++)
		{
		var oRow=rows[i];
		for(var j=0;j<oRow.childNodes.length;j++)
			{
			var oCol=oRow.childNodes[j];
			oCol.style.backgroundColor="#ffffff";
			}
		}
	event.cancelBubble=true;
	}
function doRefresh_TabCreate()
	{
	var oTable=eval("dropTableCreate"+this.oName);
	var rows=oTable.rows;
	rows[rows.length-1].childNodes[0].innerText=getText("Advanced Table Insert");
	for(var i=0;i<rows.length-1;i++)
		{
		var oRow=rows[i];
		for(var j=0;j<oRow.childNodes.length;j++)
			{
			var oCol=oRow.childNodes[j];
			oCol.style.backgroundColor="#ffffff";
			}
		}
	}
function doClick_TabCreate()
	{
	this.hide();

	if(!this.checkFocus())return;//Focus stuff
	var oEditor=eval("idContent"+this.oName);
	var oSel=oEditor.document.selection.createRange();

	var oTD=event.srcElement;
	var nRow=oTD.parentElement.rowIndex+1;
	var nCol=oTD.cellIndex+1;

	this.saveForUndo();

	var sHTML="<table style='border-collapse:collapse;width:100%;'>";
	for(var i=1;i<=nRow;i++)
		{
		sHTML+="<tr>";
		for(var j=1;j<=nCol;j++)
			{
			sHTML+="<td></td>";
			}
		sHTML+="</tr>";
		}
	sHTML+="</table>";

	if(oSel.parentElement)
		oSel.pasteHTML(sHTML);
	else
		oSel.item(0).outerHTML = sHTML;

	realTime(this.oName);

	//*** RUNTIME STYLES ***
	this.runtimeBorder(false);
	this.runtimeStyles();
	//***********************
	}

/*********************
	Show/Hide Dropdown
**********************/
function dropShow(oEl,box)
	{
	this.hide();

	box.style.display="block";
	var nTop=0;
	var nLeft=0;

	oElTmp=oEl;
	while(oElTmp.tagName!="BODY" && oElTmp.tagName!="HTML")
		{
		if(oElTmp.style.top!="")
			nTop+=oElTmp.style.top.substring(1,oElTmp.style.top.length-2)*1;
		else nTop+=oElTmp.offsetTop;
		oElTmp = oElTmp.offsetParent;
		}

	oElTmp=oEl;
	while(oElTmp.tagName!="BODY" && oElTmp.tagName!="HTML")
		{
		if(oElTmp.style.left!="")
			nLeft+=oElTmp.style.left.substring(1,oElTmp.style.left.length-2)*1;
		else nLeft+=oElTmp.offsetLeft;
		oElTmp=oElTmp.offsetParent;
		}

	box.style.left=nLeft;
	box.style.top=nTop+1+this.dropTopAdjustment;
	}
function hide()
	{
	if(this.btnPreview)eval("dropPreview"+this.oName).style.display="none";
	if(this.btnTextFormatting||this.btnParagraphFormatting||this.btnListFormatting||this.btnBoxFormatting||this.btnStyles||this.btnCssText)eval("dropStyle"+this.oName).style.display="none";
	if(this.btnParagraph)eval("dropParagraph"+this.oName).style.display="none";
	if(this.btnFontName)eval("dropFontName"+this.oName).style.display="none";
	if(this.btnFontSize)eval("dropFontSize"+this.oName).style.display="none";
	if(this.btnTable)eval("dropTable"+this.oName).style.display="none";
	if(this.btnTable)eval("dropTableCreate"+this.oName).style.display="none";
	if(this.btnForm)eval("dropForm"+this.oName).style.display="none";
	if(this.btnCustomTag)eval("dropCustomTag"+this.oName).style.display="none";

	this.oColor1.hide();
	this.oColor2.hide();

	//additional
	if(this.btnTable)this.doRefresh_TabCreate();
	}

/*********************
	Open Dialog
**********************/
function modelessDialogShow(url,width,height)
	{
	window.showModelessDialog(url,window,
		"dialogWidth:"+width+"px;dialogHeight:"+height+"px;edge:Raised;center:1;help:0;resizable:1;");
	}
function modalDialogShow(url,width,height)
	{
	window.showModalDialog(url,window,
		"dialogWidth:"+width+"px;dialogHeight:"+height+"px;edge:Raised;center:1;help:0;resizable:1;maximize:1");
	}

/*********************
	HTML to XHTML
**********************/
function lineBreak1(tag) //[0]<TAG>[1]text[2]</TAG>
	{
	arrReturn = ["\n","",""];
	if(	tag=="A"||tag=="B"||tag=="CITE"||tag=="CODE"||tag=="EM"||
		tag=="FONT"||tag=="I"||tag=="SMALL"||tag=="STRIKE"||tag=="BIG"||
		tag=="STRONG"||tag=="SUB"||tag=="SUP"||tag=="U"||tag=="SAMP"||
		tag=="S"||tag=="VAR"||tag=="BASEFONT"||tag=="KBD"||tag=="TT")
		arrReturn=["","",""];

	if(	tag=="TEXTAREA"||tag=="TABLE"||tag=="THEAD"||tag=="TBODY"||
		tag=="TR"||tag=="OL"||tag=="UL"||tag=="DIR"||tag=="MENU"||
		tag=="FORM"||tag=="SELECT"||tag=="MAP"||tag=="DL"||tag=="HEAD"||
		tag=="BODY"||tag=="HTML")
		arrReturn=["\n","","\n"];

	if(	tag=="STYLE"||tag=="SCRIPT")
		arrReturn=["\n","",""];

	if(tag=="BR"||tag=="HR")
		arrReturn=["","\n",""];

	return arrReturn;
	}
function fixAttr(s)
	{
	s = String(s).replace(/&/g, "&amp;");
	s = String(s).replace(/</g, "&lt;");
	s = String(s).replace(/"/g, "&quot;");
	return s;
	}
function fixVal(s)
	{
	s = String(s).replace(/&/g, "&amp;");
	s = String(s).replace(/</g, "&lt;");
	return s;
	}
function recur(oEl,sTab)
	{
	var sHTML="";
	for(var i=0;i<oEl.childNodes.length;i++)
		{
		var oNode=oEl.childNodes(i);
		if(oNode.nodeType==1)//tag
			{
			var sTagName = oNode.nodeName;

			var bDoNotProcess=false;
			if(sTagName.substring(0,1)=="/")
				{
				bDoNotProcess=true;//do not process
				}
			else
				{
				/*** tabs ***/
				var sT= sTab;
				sHTML+= lineBreak1(sTagName)[0];
				if(lineBreak1(sTagName)[0] !="") sHTML+= sT;//If new line, use base Tabs
				/************/
				}

			if(bDoNotProcess)
				{
				;//do not process
				}
			else if(sTagName=="OBJECT" || sTagName=="EMBED")
				{
				s=oNode.outerHTML;

				s=s.replace(/\"[^\"]*\"/ig,function(x){
						x=x.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/'/g, "&apos;").replace(/[\s+]/ig,"#_#");
						return x});
				s=s.replace(/<([^ >]*)/ig,function(x){return x.toLowerCase()});		
				s=s.replace(/ ([^=]+)=([^"' >]+)/ig," $1=\"$2\"");//new
				s=s.replace(/ ([^=]+)=/ig,function(x){return x.toLowerCase()});
				s=s.replace(/#_#/ig," ");

				s=s.replace(/<param([^>]*)>/ig,"\n<param$1 />").replace(/\/ \/>$/ig," \/>");//no closing tag

				if(sTagName=="EMBED")
					if(oNode.innerHTML=="")
						s=s.replace(/>$/ig," \/>").replace(/\/ \/>$/ig,"\/>");//no closing tag

				s=s.replace(/<param name=\"Play\" value=\"0\" \/>/,"<param name=\"Play\" value=\"-1\" \/>");

				sHTML+=s;
				}
			else if(sTagName=="TITLE")
				{
				sHTML+="<title>"+oNode.innerHTML+"</title>";
				}
			else
				{
				if(sTagName=="AREA")
					{
					var sCoords=oNode.coords;
					var sShape=oNode.shape;
					}

				var oNode2=oNode.cloneNode();
				s=oNode2.outerHTML.replace(/<\/[^>]*>/,"");

				if(sTagName=="STYLE")
					{
					var arrTmp=s.match(/<[^>]*>/ig);
					s=arrTmp[0];
					}

				s=s.replace(/\"[^\"]*\"/ig,function(x){
						//x=x.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/'/g, "&apos;").replace(/[\s+]/ig,"#_#");
						//x=x.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/[\s+]/ig,"#_#");
						x=x.replace(/&/g, "&amp;").replace(/&amp;amp;/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/[\s+]/ig,"#_#");
						return x});
						//info ttg: .replace(/&amp;amp;/g, "&amp;")
						//ini karena '&' di (hanya) '&amp;' selalu di-replace lagi dgn &amp;.
						//tapi kalau &lt; , &gt; tdk (no problem) => default behaviour

				s=s.replace(/<([^ >]*)/ig,function(x){return x.toLowerCase()});		
				s=s.replace(/ ([^=]+)=([^" >]+)/ig," $1=\"$2\"");
				s=s.replace(/ ([^=]+)=/ig,function(x){return x.toLowerCase()});
				s=s.replace(/#_#/ig," ");

				//single attribute
				s=s.replace(/[<hr]?(noshade)/ig,"noshade=\"noshade\"");
				s=s.replace(/[<input]?(checked)/ig,"checked=\"checked\"");
				s=s.replace(/[<select]?(multiple)/ig,"multiple=\"multiple\"");
				s=s.replace(/[<option]?(selected)/ig,"selected=\"true\"");
				s=s.replace(/[<input]?(readonly)/ig,"readonly=\"readonly\"");
				s=s.replace(/[<input]?(disabled)/ig,"checked=\"disabled\"");
				s=s.replace(/[<td]?(nowrap )/ig,"nowrap=\"nowrap\" ");
				s=s.replace(/[<td]?(nowrap\>)/ig,"nowrap=\"nowrap\"\>");

				s=s.replace(/ contenteditable=\"true\"/ig,"");

				if(sTagName=="AREA")
					{
					s=s.replace(/ coords=\"0,0,0,0\"/ig," coords=\""+sCoords+"\"");
					s=s.replace(/ shape=\"RECT\"/ig," shape=\""+sShape+"\"");
					}

				var bClosingTag=true;
				if(sTagName=="IMG"||sTagName=="BR"||
					sTagName=="AREA"||sTagName=="HR"||
					sTagName=="INPUT"||sTagName=="BASE"||
					sTagName=="LINK")//no closing tag
					{
					s=s.replace(/>$/ig," \/>").replace(/\/ \/>$/ig,"\/>");//no closing tag
					bClosingTag=false;	
					}

				sHTML+=s;

				/*** tabs ***/
				if(sTagName!="TEXTAREA")sHTML+= lineBreak1(sTagName)[1];
				if(sTagName!="TEXTAREA")if(lineBreak1(sTagName)[1] !="") sHTML+= sT;//If new line, use base Tabs
				/************/

				if(bClosingTag)
					{
					/*** CONTENT ***/
					s=oNode.outerHTML;					
					if(sTagName=="SCRIPT")
						{
						s = s.replace(/<script([^>]*)>[\n+\s+\t+]*/ig,"<script$1>");//clean spaces
						s = s.replace(/[\n+\s+\t+]*<\/script>/ig,"<\/script>");//clean spaces
						s = s.replace(/<script([^>]*)>\/\/<!\[CDATA\[/ig,"");
						s = s.replace(/\/\/\]\]><\/script>/ig,"");
						s = s.replace(/<script([^>]*)>/ig,"");
						s = s.replace(/<\/script>/ig,"");		
						s = s.replace(/^\s+/,'').replace(/\s+$/,'');						

						sHTML+="\n"+
							sT + "//<![CDATA[\n"+
							sT + s + "\n"+
							sT + "//]]>\n"+sT;
						}
					if(sTagName=="STYLE")
						{
						s = s.replace(/<style([^>]*)>[\n+\s+\t+]*/ig,"<style$1>");//clean spaces
						s = s.replace(/[\n+\s+\t+]*<\/style>/ig,"<\/style>");//clean spaces			
						s = s.replace(/<style([^>]*)><!--/ig,"");
						s = s.replace(/--><\/style>/ig,"");
						s = s.replace(/<style([^>]*)>/ig,"");
						s = s.replace(/<\/style>/ig,"");		
						s = s.replace(/^\s+/,"").replace(/\s+$/,"");					

						sHTML+="\n"+
							sT + "<!--\n"+
							sT + s + "\n"+
							sT + "-->\n"+sT;
						}
					if(sTagName=="DIV"||sTagName=="P")
						{
						if(oNode.innerHTML==""||oNode.innerHTML=="&nbsp;")
							{
							sHTML+="&nbsp;";
							}
						else sHTML+=recur(oNode,sT+"\t");
						}
					else
						{
						sHTML+=recur(oNode,sT+"\t");
						}

					/*** tabs ***/
					if(sTagName!="TEXTAREA")sHTML+=lineBreak1(sTagName)[2];
					if(sTagName!="TEXTAREA")if(lineBreak1(sTagName)[2] !="")sHTML+=sT;//If new line, use base Tabs
					/************/

					sHTML+="</" + sTagName.toLowerCase() + ">";
					}
				}
			}
		else if(oNode.nodeType==3)//text
			{
			sHTML+= fixVal(oNode.nodeValue);
			}
		else if(oNode.nodeType==8)
			{
			if(oNode.outerHTML.substring(0,2)=="<"+"%")
				{//server side script
				sTmp=(oNode.outerHTML.substring(2));
				sTmp=sTmp.substring(0,sTmp.length-2);
				sTmp = sTmp.replace(/^\s+/,"").replace(/\s+$/,"");

				/*** tabs ***/
				var sT= sTab;
				/************/

				sHTML+="\n" +
					sT + "<%\n"+
					sT + sTmp + "\n" +
					sT + "%>\n"+sT;
				}
			else
				{//comments
				sTmp=oNode.nodeValue;
				sTmp = sTmp.replace(/^\s+/,"").replace(/\s+$/,"");

				sHTML+="\n" +
					sT + "<!--\n"+
					sT + sTmp + "\n" +
					sT + "-->\n"+sT;
				}
			}
		else
			{
			;//Not Processed
			}
		}
	return sHTML;
	}

/*********************
	TOOLBAR ICONS
**********************/
var buttonArrays=[];
var buttonArraysCount=0;

function writeIconToggle(id,command,img,title)
	{
	w=this.iconWidth;
	h=this.iconHeight;
	imgPath=this.scriptPath+this.iconPath+img;
	sHTML=""+
		"<td unselectable='on' style='padding-right:1px;VERTICAL-ALIGN: top;margin-left:0;margin-right:1px;margin-bottom:1px;width:"+w+"px;height:"+h+"px;'>"+
		"<span unselectable='on' style='position:absolute;clip: rect(0 "+w+"px "+h+"px 0)'>"+
		"<img name=\""+id+"\" id=\""+id+"\" btnIndex=\""+buttonArraysCount+"\" unselectable='on' src='"+imgPath+"' style='position:absolute;top:-0;width:"+w+"px'"+
		"onmouseover='doOver(this)' "+
		"onmouseout='doOut(this)' "+
		"onmousedown='doDown(this)' "+
		"onmouseup=\"if(doUpToggle(this)){"+command+"}\" alt=\""+title+"\">"+
		"</span></td>";
	sHTML="<table align=left cellpadding=0 cellspacing=0 style='table-layout:fixed;'><tr>"+sHTML+"</tr></table>";
	buttonArrays.push(["inactive"]);
	buttonArraysCount++;
	return sHTML;
	}
function writeIconStandard(id,command,img,title)
	{
	w=this.iconWidth;
	h=this.iconHeight;
	imgPath=this.scriptPath+this.iconPath+img;
	sHTML=""+
		"<td unselectable='on' style='padding-right:1px;VERTICAL-ALIGN: top;margin-left:0;margin-right:1px;margin-bottom:1px;width:"+w+"px;height:"+h+"px;'>"+
		"<span unselectable='on' style='position:absolute;clip: rect(0 "+w+"px "+h+"px 0)'>"+
		"<img name=\""+id+"\" id=\""+id+"\" btnIndex=\""+buttonArraysCount+"\" unselectable='on' src='"+imgPath+"' style='position:absolute;top:-0;width:"+w+"px'"+
		"onmouseover='doOver(this)' "+
		"onmouseout='doOut(this)' "+
		"onmousedown='doDown(this)' "+
		"onmouseup=\"if(doUp(this)){"+command+"}\" alt=\""+title+"\">"+
		"</span></td>";
	sHTML="<table align=left cellpadding=0 cellspacing=0 style='table-layout:fixed;'><tr>"+sHTML+"</tr></table>";
	buttonArrays.push(["inactive"]);
	buttonArraysCount++;
	return sHTML;
	}
function writeBreakSpace()
	{
	w=this.iconWidth;
	h=this.iconHeight;
	imgPath=this.scriptPath+this.iconPath+"brkspace.gif";
	sHTML=""+
		"<td unselectable='on' style='padding-left:0px;padding-right:0px;VERTICAL-ALIGN:top;margin-bottom:1px;width:5px;height:"+h+"px;'>"+
		"<img unselectable='on' src='"+imgPath+"'></td>";
	sHTML="<table align=left cellpadding=0 cellspacing=0 style='table-layout:fixed;'><tr>"+sHTML+"</tr></table>";
	return sHTML;
	}
function writeDropDown(id,command,img,title,width)
	{
	w=width;
	h=this.iconHeight;

	/*** Localization ***/
	imgPath=this.scriptPath+this.iconPath+oUtil.langDir+"/"+img;
	/*** /Localization ***/

	sHTML=""+
		"<td unselectable='on' style='padding-right:1px;VERTICAL-ALIGN: top;margin-left:0;margin-right:1px;margin-bottom:1px;width:"+w+"px;height:"+h+"px;'>"+
		"<span unselectable='on' style='position:absolute;clip: rect(0 "+w+"px "+h+"px 0)'>"+
		"<img name=\""+id+"\" id=\""+id+"\" btnIndex=\""+buttonArraysCount+"\" unselectable='on' src='"+imgPath+"' style='position:absolute;top:-0;width:"+w+"px'"+
		"onmouseover='doOver(this)' "+
		"onmouseout='doOut(this)' "+
		"onmousedown='doDown(this)' "+
		"onmouseup=\"if(doUp(this)){"+command+"}\" alt=\""+title+"\">"+
		"</span></td>";
	sHTML="<table align=left cellpadding=0 cellspacing=0 style='table-layout:fixed;'><tr>"+sHTML+"</tr></table>";
	buttonArrays.push(["inactive"]);
	buttonArraysCount++;
	return sHTML;
	}
function doOver(btn)
	{
	btnArr=buttonArrays[btn.btnIndex];
	if(btnArr[0]=="inactive")btn.style.top=-24;//no.2
	}
function doDown(btn)
	{
	btnArr=buttonArrays[btn.btnIndex];
	if(btnArr[0]!="disabled")btn.style.top=-48;//no.3
	}
var bCancel=false;
function doOut(btn)
	{
	if(btn.style.top=="-48px")
		{//lagi pushed tapi mouseout (cancel)
		bCancel=true;
		}
	btnArr=buttonArrays[btn.btnIndex];
	if(btnArr[0]=="active")btn.style.top=-72;//no.4 (remain active/pushed)
	if(btnArr[0]=="inactive")btn.style.top=0;//no.1 (remain inactive)
	}
function doUpToggle(btn)
	{
	if(bCancel)
		{//lagi pushed tapi mouseout (cancel)
		bCancel=false;btn.style.top=0;
		return false;
		}
	btnArr = buttonArrays[btn.btnIndex];
	if(btnArr[0]=="inactive")
		{
		btn.style.top=-72;//no.4
		btnArr[0]="active";
		return true;
		}
	if(btnArr[0]=="active")
		{
		btn.style.top=-24;//no.2
		btnArr[0]="inactive";
		return true;
		}
	}
function doUp(btn)//return true/false
	{
	if(bCancel)
		{//lagi pushed tapi mouseout (cancel)
		bCancel=false;btn.style.top=0;
		return false;
		}
	btnArr=buttonArrays[btn.btnIndex];
	if(btnArr[0]=="disabled") return false;
	btn.style.top=-24;//no.2
	return true;
	}
function makeEnablePushed(btn)
	{
	btnArr=buttonArrays[btn.btnIndex];
	btnArr[0]="active";
	btn.style.top=-72;//no.4
	}
function makeEnableNormal(btn)
	{
	btnArr=buttonArrays[btn.btnIndex];
	btnArr[0]="inactive";
	btn.style.top=0;//no.1
	}
function makeDisabled(btn)
	{
	btnArr=buttonArrays[btn.btnIndex];
	btnArr[0]="disabled";
	btn.style.top=-96;//no.5
	}