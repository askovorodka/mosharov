function loadText()
    	{
    	var txtLang = document.getElementsByName("txtLang");
	txtLang[0].innerHTML = "\u0422\u0438\u043F";
	txtLang[1].innerHTML = "\u0418\u043C\u044F";
	txtLang[2].innerHTML = "\u0417\u043D\u0430\u0447\u0435\u043D\u0438\u0435";

    	var optLang = document.getElementsByName("optLang");
	optLang[0].text = "\u041A\u043D\u043E\u043F\u043A\u0430"
	optLang[1].text = "\u041A\u043D\u043E\u043F\u043A\u0430-\u043E\u0442\u043F\u0440\u0430\u0432\u0438\u0442\u044C"
	optLang[2].text = "\u041A\u043D\u043E\u043F\u043A\u0430-\u0441\u0431\u0440\u043E\u0441"

        
    	document.getElementById("btnCancel").value = "\u043E\u0442\u043C\u0435\u043D\u0430";
    	document.getElementById("btnInsert").value = "\u0432\u0441\u0442\u0430\u0432\u0438\u0442\u044C";
    	document.getElementById("btnApply").value = "\u043F\u0440\u0438\u043C\u0435\u043D\u0438\u0442\u044C";
    	document.getElementById("btnOk").value = " ok ";
    	}
function writeTitle()
	{
	document.write("<title>\u041A\u043D\u043E\u043F\u043A\u0430</title>")
	}