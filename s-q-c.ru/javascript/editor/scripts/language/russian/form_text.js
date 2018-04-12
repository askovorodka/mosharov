function loadText()
    	{
    	var txtLang = document.getElementsByName("txtLang");
	txtLang[0].innerHTML = "\u0422\u0438\u043F";
	txtLang[1].innerHTML = "\u0418\u043C\u044F";
	txtLang[2].innerHTML = "\u0420\u0430\u0437\u043C\u0435\u0440";
	txtLang[3].innerHTML = "\u041C\u0430\u043A\u0441. \u0434\u043B\u0438\u043D\u0430";
	txtLang[4].innerHTML = "\u041D\u0443\u043C\u0435\u0440\u0430\u0446\u0438\u044F";
	txtLang[5].innerHTML = "\u0417\u043D\u0430\u0447\u0435\u043D\u0438\u0435";

    	var optLang = document.getElementsByName("optLang");
	optLang[0].text = "\u0422\u0435\u043A\u0441\u0442. \u0441\u0442\u0440\u043E\u043A\u0430"
	optLang[1].text = "\u0411\u043E\u043B\u044C\u0448\u043E\u0435 \u0442\u0435\u043A\u0441\u0442. \u043F\u043E\u043B\u0435"
	optLang[2].text = "\u041F\u043E\u043B\u0435 - \u043F\u0430\u0440\u043E\u043B\u044C"
    
    	document.getElementById("btnCancel").value = "\u043E\u0442\u043C\u0435\u043D\u0430";
    	document.getElementById("btnInsert").value = "\u0432\u0441\u0442\u0430\u0432\u043A\u0430";
    	document.getElementById("btnApply").value = "\u043F\u0440\u0438\u043C\u0435\u043D\u0438\u0442\u044C";
    	document.getElementById("btnOk").value = " ok ";
    	}
function writeTitle()
	{
	document.write("<title>\u0422\u0435\u043A\u0441\u0442\u043E\u0432\u043E\u0435 \u043F\u043E\u043B\u0435</title>")
	}