function loadText()
    	{
    	var txtLang =  document.getElementsByName("txtLang");
	txtLang[0].innerHTML = "\u0421\u0442\u0440\u043E\u043A\u0438";
	txtLang[1].innerHTML = "\u041C\u0435\u0436\u0434\u0443 \u044F\u0447\u0435\u0439\u043A\u0430\u043C\u0438";
	txtLang[2].innerHTML = "\u0421\u0442\u043E\u043B\u0431\u0446\u044B";
	txtLang[3].innerHTML = "\u041D\u0430\u0431\u0438\u0432\u043A\u0430";
	txtLang[4].innerHTML = "\u0420\u0430\u043C\u043A\u0430";
	txtLang[5].innerHTML = "\u0421\u0431\u043B\u0438\u0437\u0438\u0442\u044C";
    
	var optLang = document.getElementsByName("optLang");
	optLang[0].text = "\u0411\u0435\u0437 \u0440\u0430\u043C\u043A\u0438"
	optLang[1].text = "\u0414\u0430"
	optLang[2].text = "\u041D\u0435\u0442"
    
    	document.getElementById("btnCancel").value = "\u043E\u0442\u043C\u0435\u043D\u0430";
    	document.getElementById("btnInsert").value = "\u0432\u0441\u0442\u0430\u0432\u043A\u0430";

   	document.getElementById("btnSpan1").value = "\u041E\u0431\u044A\u0435\u0434. v";
    	document.getElementById("btnSpan2").value = "\u041E\u0431\u044A\u0435\u0434 >";
    	}
function writeTitle()
	{
	document.write("<title>\u0412\u0441\u0442\u0430\u0432\u043A\u0430 \u0442\u0430\u0431\u043B\u0438\u0446\u044B</title>")
	}