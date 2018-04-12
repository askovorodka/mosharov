function loadText()
    	{
    	var txtLang = document.getElementsByName("txtLang");
	txtLang[0].innerHTML = "\u041D\u0443\u043C\u0435\u0440\u043E\u0432\u0430\u043D\u043D\u044B\u0439";
	txtLang[1].innerHTML = "\u041C\u0430\u0440\u043A\u0438\u0440\u043E\u0432\u0430\u043D\u043D\u044B\u0439";
	txtLang[2].innerHTML = "\u041D\u0430\u0447\u0438\u043D\u0430\u044F \u0441 \u043D\u043E\u043C\u0435\u0440\u0430";
	txtLang[3].innerHTML = "\u041B\u0435\u0432\u044B\u0439 \u043E\u0442\u0441\u0442\u0443\u043F";
	txtLang[4].innerHTML = "\u0418\u0437\u043E\u0431\u0440\u0430\u0436-\u0435"
	txtLang[5].innerHTML = "\u041B\u0435\u0432\u044B\u0439 \u043E\u0442\u0441\u0442\u0443\u043F";
    
    	document.getElementById("btnCancel").value = "\u043E\u0442\u043C\u0435\u043D\u0430";
    	document.getElementById("btnApply").value = "\u043F\u0440\u0438\u043C\u0435\u043D\u0438\u0442\u044C";
    	document.getElementById("btnOk").value = " ok ";   
    	}
function getText(s)
    	{
	switch(s)
		{
		case "Please select a list.":return "\u0422\u0438\u043F \u0441\u043F\u0438\u0441\u043A\u0430.";
		default:return "";
		}
    	}
function writeTitle()
	{
	document.write("<title>\u0424\u043E\u0440\u043C\u0430\u0442\u0438\u0440\u043E\u0432\u0430\u043D\u0438\u0435 \u0441\u043F\u0438\u0441\u043A\u0430</title>")
	}
