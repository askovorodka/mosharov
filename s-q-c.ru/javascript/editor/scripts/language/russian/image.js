function loadText()
    	{
    	var txtLang = document.getElementsByName("txtLang");
	txtLang[0].innerHTML = "\u041F\u0443\u0442\u044C";
	txtLang[1].innerHTML = "\u041D\u0430\u0437\u0432\u0430\u043D\u0438\u0435";	
	txtLang[2].innerHTML = "\u041E\u0442\u0441\u0442\u0443\u043F";
	txtLang[3].innerHTML = "\u0412\u044B\u0440\u0430\u0432\u043D\u0438\u0432\u0430\u043D\u0438\u0435";	
	txtLang[4].innerHTML = "\u0412\u0432\u0435\u0440\u0445";
	txtLang[5].innerHTML = "\u0413\u0440\u0430\u043D\u0438\u0446\u0430";	
	txtLang[6].innerHTML = "\u041D\u0438\u0437";
	txtLang[7].innerHTML = "\u0428\u0438\u0440\u0438\u043D\u0430";	
	txtLang[8].innerHTML = "\u0412\u043B\u0435\u0432\u043E";
	txtLang[9].innerHTML = "\u0412\u044B\u0441\u043E\u0442\u0430";		
	txtLang[10].innerHTML = "\u0412\u043F\u0440\u0430\u0432\u043E";	
    
    	var optLang = document.getElementsByName("optLang");
	optLang[0].text = "\u0430\u0431\u0441. \u043D\u0438\u0437"
	optLang[1].text = "\u0430\u0431\u0441. \u0441\u0435\u0440\u0435\u0434\u0438\u043D\u0430"
	optLang[2].text = "\u043E\u0441\u043D\u043E\u0432\u0430\u043D\u0438\u0435"
	optLang[3].text = "\u043D\u0438\u0437"
	optLang[4].text = "\u0432\u043B\u0435\u0432\u043E"
	optLang[5].text = "\u0441\u0435\u0440\u0435\u0434\u0438\u043D\u0430"
	optLang[6].text = "\u0432\u043F\u0440\u0430\u0432\u043E"
	optLang[7].text = "\u043F\u043E\u0432\u0435\u0440\u0445\u0443"
	optLang[8].text = "\u0432\u0432\u0435\u0440\u0445"
 
    	document.getElementById("btnBorder").value = " \u0421\u0442\u0438\u043B\u044C \u0440\u0430\u043C\u043A\u0438 ";
    	document.getElementById("btnReset").value = "\u0441\u0431\u0440\u043E\u0441"
    
    	document.getElementById("btnCancel").value = "\u043E\u0442\u043C\u0435\u043D\u0430";
    	document.getElementById("btnInsert").value = "\u0432\u0441\u0442\u0430\u0432\u0438\u0442\u044C";
    	document.getElementById("btnApply").value = "\u043F\u0440\u0438\u043C\u0435\u043D\u0438\u0442\u044C";
    	document.getElementById("btnOk").value = " ok ";
    	}
function writeTitle()
	{
	document.write("<title>\u0418\u0437\u043E\u0431\u0440\u0430\u0436\u0435\u043D\u0438\u0435</title>")
	}