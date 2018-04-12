function loadText()
    	{
    	var txtLang = document.getElementsByName("txtLang");
	txtLang[0].innerHTML = "Web-\u043F\u0430\u043B\u0438\u0442\u0440\u0430";
	txtLang[1].innerHTML = "\u0418\u043C\u0435\u043D\u043D\u044B\u0435 \u0446\u0432\u0435\u0442\u0430";
	txtLang[2].innerHTML = "\u0411\u0435\u0437\u043E\u043F\u0430\u0441\u043D\u0430\u044F";
	txtLang[3].innerHTML = "\u041D\u043E\u0432\u044B\u0439";
	txtLang[4].innerHTML = "\u0422\u0435\u043A\u0443\u0449\u0438\u0439";
	txtLang[5].innerHTML = "\u041E\u0441\u043E\u0431\u044B\u0435 \u0446\u0432\u0435\u0442\u0430";

    	document.getElementById("btnAddToCustom").value = "\u0414\u043E\u0431\u0430\u0432\u0438\u0442\u044C \u0432 \u043E\u0441\u043E\u0431\u044B\u0435";
    	document.getElementById("btnCancel").value = " \u043E\u0442\u043C\u0435\u043D\u0430 ";
    	document.getElementById("btnRemove").value = " \u0443\u0434\u0430\u043B\u0438\u0442\u044C \u0446\u0432\u0435\u0442 ";
    	document.getElementById("btnApply").value = " \u043F\u0440\u0438\u043C\u0435\u043D\u0438\u0442\u044C ";
    	document.getElementById("btnOk").value = " ok ";
    	}
function writeTitle()
	{
	document.write("<title>\u0426\u0432\u0435\u0442\u0430</title>")
	}