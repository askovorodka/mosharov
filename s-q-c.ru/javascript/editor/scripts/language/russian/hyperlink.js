function loadText()
    	{
    	var txtLang = document.getElementsByName("txtLang");
	txtLang[0].innerHTML = "\u0410\u0434\u0440\u0435\u0441";
	txtLang[1].innerHTML = "\u0417\u0430\u043A\u043B\u0430\u0434\u043A\u0430";
	txtLang[2].innerHTML = "\u0424\u0440\u044D\u0439\u043C/\u043E\u043A\u043D\u043E (Target)";
	txtLang[3].innerHTML = "\u0422\u0435\u043A\u0441\u0442";

    	var optLang = document.getElementsByName("optLang");
	optLang[0].text = "Self(\u044D\u0442\u043E \u0436\u0435 \u043E\u043A\u043D\u043E/\u0444\u0440\u044D\u0439\u043C)"
	optLang[1].text = "Blank(\u043D\u043E\u0432\u043E\u0435 \u043E\u043A\u043D\u043E)"
	optLang[2].text = "Parent(\u0440\u043E\u0434\u0438\u0442-\u043E\u0435 \u043E\u043A\u043D\u043E)"
    
    	document.getElementById("btnCancel").value = "\u043E\u0442\u043C\u0435\u043D\u0430";
    	document.getElementById("btnInsert").value = "\u0432\u0441\u0442\u0430\u0432\u0438\u0442\u044C";
    	document.getElementById("btnApply").value = "\u043F\u0440\u0438\u043C\u0435\u043D\u0438\u0442\u044C";
    	document.getElementById("btnOk").value = " ok ";
    	}
function writeTitle()
	{
	document.write("<title>\u0421\u0441\u044B\u043B\u043A\u0430</title>")
	}