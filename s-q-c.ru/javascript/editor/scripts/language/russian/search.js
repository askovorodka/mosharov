function loadText()
	{
    	var txtLang = document.getElementsByName("txtLang");
	txtLang[0].innerHTML = "\u041F\u043E\u0438\u0441\u043A";
	txtLang[1].innerHTML = "\u0417\u0430\u043C\u0435\u043D\u0430";
	txtLang[2].innerHTML = "\u0423\u0447\u0438\u0442\u044B\u0432\u0430\u0442\u044C \u0440\u0435\u0433\u0438\u0441\u0442\u0440";
	txtLang[3].innerHTML = "\u0421\u043B\u043E\u0432\u043E \u0446\u0435\u043B\u0438\u043A\u043E\u043C";
    
    	document.getElementById("btnSearch").value = "\u0418\u0441\u043A\u0430\u0442\u044C \u0434\u0430\u043B\u0435\u0435";
    	document.getElementById("btnReplace").value = "\u0437\u0430\u043C\u0435\u043D\u0438\u0442\u044C";
    	document.getElementById("btnReplaceAll").value = "\u0437\u0430\u043C\u0435\u043D\u0438\u0442\u044C \u0432\u0441\u0435";
    	document.getElementById("btnClose").value = "\u0437\u0430\u043A\u0440\u044B\u0442\u044C";
	}
function writeTitle()
	{
	document.write("<title>\u041F\u043E\u0438\u0441\u043A \u0438 \u0437\u0430\u043C\u0435\u043D\u0430</title>")
	}