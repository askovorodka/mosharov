function loadText()
    	{
    	var txtLang = document.getElementsByName("txtLang");
	txtLang[0].innerHTML = "\u0418\u043C\u044F";
	txtLang[1].innerHTML = "\u041A\u043E\u043B-\u0432\u043E";
	txtLang[2].innerHTML = "\u0412\u044B\u0431\u043E\u0440 \u043D\u0435\u0441\u043A-\u0438\u0445";
	txtLang[3].innerHTML = "\u0417\u043D\u0430\u0447\u0435\u043D\u0438\u044F";
    
    	document.getElementById("btnAdd").value = "  \u0414\u043E\u0431.  ";
    	document.getElementById("btnUp").value = "  \u0432\u043D\u0438\u0437  ";
    	document.getElementById("btnDown").value = "  \u0432\u0432\u0435\u0440\u0445  ";
    	document.getElementById("btnDel").value = "  \u0423\u0434\u0430\u043B  ";
    	document.getElementById("btnCancel").value = "\u043E\u0442\u043C\u0435\u043D\u0430";
    	document.getElementById("btnInsert").value = "\u0432\u0441\u0442\u0430\u0432\u043A\u0430";
    	document.getElementById("btnApply").value = "\u043F\u0440\u0438\u043C\u0435\u043D\u0438\u0442\u044C";
    	document.getElementById("btnOk").value = " ok ";
    	}
function writeTitle()
	{
	document.write("<title>\u0421\u043F\u0438\u0441\u043E\u043A</title>")
	}