function loadText()
    	{
    	document.getElementById("txtLang").innerHTML = "\u041F\u0435\u0440\u0435\u043D\u043E\u0441\u0438\u0442\u044C \u0442\u0435\u043A\u0441\u0442";
    	document.getElementById("btnCancel").value = "\u043E\u0442\u043C\u0435\u043D\u0430";
    	document.getElementById("btnApply").value = "\u043F\u0440\u0438\u043C\u0435\u043D\u0438\u0442\u044C";
    	document.getElementById("btnOk").value = " ok ";
    	}
function getText(s)
    	{
    	switch(s)
        	{
		case "Search":return "\u041F\u043E\u0438\u0441\u043A";
		case "Cut":return "\u0412\u044B\u0440\u0435\u0437\u0430\u0442\u044C";
		case "Copy":return "\u041A\u043E\u043F\u0438\u0440\u043E\u0432\u0430\u0442\u044C";
		case "Paste":return "\u0412\u0441\u0442\u0430\u0432\u0438\u0442\u044C";
		case "Undo":return "\u0412\u0435\u0440\u043D\u0443\u0442\u044C \u043D\u0430\u0437\u0430\u0434";
		case "Redo":return "\u041F\u043E\u0432\u0442\u043E\u0440\u0438\u0442\u044C";
		default:return ""
        	}
    	}
function writeTitle()
	{
	document.write("<title>\u0420\u0435\u0434\u0430\u043A\u0442\u043E\u0440 \u0438\u0441\u0445\u043E\u0434\u043D\u043E\u0433\u043E \u043A\u043E\u0434\u0430</title>")
	}
