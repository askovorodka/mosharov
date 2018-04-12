function loadText()
    	{
    	var txtLang = document.getElementsByName("txtLang");
	txtLang[0].innerHTML = "\u041F\u0443\u0442\u044C";
	txtLang[1].innerHTML = "\u041F\u043E\u0434\u043B\u043E\u0436\u043A\u0430";
	txtLang[2].innerHTML = "\u0428\u0438\u0440\u0438\u043D\u0430";
	txtLang[3].innerHTML = "\u0412\u044B\u0441\u043E\u0442\u0430";
	txtLang[4].innerHTML = "\u041A\u0430\u0447\u0435\u0441\u0442\u0432\u043E";	
	txtLang[5].innerHTML = "\u0412\u044B\u0440\u0430\u0432\u043D-\u0435";
	txtLang[6].innerHTML = "\u0426\u0438\u043A\u043B";
	txtLang[7].innerHTML = "\u0414\u0430";
	txtLang[8].innerHTML = "\u041D\u0435\u0442";
    
	txtLang[9].innerHTML = "Class ID";
	txtLang[10].innerHTML = "CodeBase";
	txtLang[11].innerHTML = "PluginsPage";

    	var optLang = document.getElementsByName("optLang");
	optLang[0].text = "\u041D\u0438\u0437\u043A\u043E\u0435"
	optLang[1].text = "\u0412\u044B\u0441\u043E\u043A\u043E\u0435"
	optLang[2].text = "<\u043D\u0435 \u0443\u0441\u0442-\u043D\u043E>"
	optLang[3].text = "\u0412\u043B\u0435\u0432\u043E"
	optLang[4].text = "\u0412\u043F\u0440\u0430\u0432\u043E"
	optLang[5].text = "\u0412\u0432\u0435\u0440\u0445"
	optLang[6].text = "\u0412\u043D\u0438\u0437"
    
    	document.getElementById("btnPick").value = "\u0412\u044B\u0431\u043E\u0440";
    
    	document.getElementById("btnCancel").value = "\u043E\u0442\u043C\u0435\u043D\u0430";
    	document.getElementById("btnOk").value = " ok ";
    	}
function getText(s)
    	{
    	switch(s)
        	{
		case "Custom Colors": return "\u041E\u0441\u043E\u0431\u044B\u0435 \u0446\u0432\u0435\u0442\u0430";
		case "More Colors...": return "\u0411\u043E\u043B\u044C\u0448\u0435 \u0446\u0432\u0435\u0442\u043E\u0432...";
		default: return "";
        	}
    	}    
function writeTitle()
	{
	document.write("<title>\u0412\u0441\u0442\u0430\u0432\u0438\u0442\u044C Flash</title>")
	}