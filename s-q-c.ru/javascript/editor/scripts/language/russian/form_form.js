function loadText()
    	{
    	var txtLang = document.getElementsByName("txtLang");
	txtLang[0].innerHTML = "\u0418\u043C\u044F";
	txtLang[1].innerHTML = "Action (\u043D\u0430 \u0441\u0442\u0440\u0430\u043D\u0438\u0446\u0443)";
	txtLang[2].innerHTML = "Method (\u043C\u0435\u0442\u043E\u0434)";
        
    	document.getElementById("btnCancel").value = "\u043E\u0442\u043C\u0435\u043D\u0430";
    	document.getElementById("btnInsert").value = "\u0432\u0441\u0442\u0430\u0432\u043A\u0430";
    	document.getElementById("btnApply").value = "\u043F\u0440\u0438\u043C\u0435\u043D\u0438\u0442\u044C";
    	document.getElementById("btnOk").value = " ok ";
    	}
function writeTitle()
	{
	document.write("<title>\u0424\u043E\u0440\u043C\u0430 - Form</title>")
	}