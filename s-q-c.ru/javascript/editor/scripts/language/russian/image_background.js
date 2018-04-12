function loadText()
    	{
    	var txtLang = document.getElementsByName("txtLang");
	txtLang[0].innerHTML = "\u041F\u0443\u0442\u044C \u043A \u0438\u0437\u043E\u0431\u0440\u0430\u0436\u0435\u043D\u0438\u044E";
	txtLang[1].innerHTML = "\u041F\u043E\u0432\u0442\u043E\u0440\u044F\u0442\u044C";
	txtLang[2].innerHTML = "\u0413\u043E\u0440\u0438\u0437. \u0432\u044B\u0440\u0430\u0432\u043D-\u043D\u0438\u0435";
	txtLang[3].innerHTML = "\u0412\u0435\u0440\u0442. \u0432\u044B\u0440\u0430\u0432\u043D-\u043D\u0438\u0435";

    	var optLang = document.getElementsByName("optLang");
	optLang[0].text = "\u041F\u043E\u0432\u0442\u043E\u0440\u044F\u0442\u044C"
	optLang[1].text = "\u041D\u0435 \u043F\u043E\u0432\u0442\u043E\u0440\u044F\u0442\u044C"
	optLang[2].text = "\u041F\u043E\u0432\u0442\u043E\u0440\u044F\u0442\u044C \u0433\u043E\u0440\u0438\u0437-\u043D\u043E"
	optLang[3].text = "\u041F\u043E\u0432\u0442\u043E\u0440\u044F\u0442\u044C \u0432\u0435\u0440\u0442-\u043D\u043E"
	optLang[4].text = "\u0432\u043B\u0435\u0432\u043E"
	optLang[5].text = "\u0446\u0435\u043D\u0442\u0440"
	optLang[6].text = "\u0432\u043F\u0440\u0430\u0432\u043E"
	optLang[7].text = "\u043F\u0438\u043A\u0441\u0435\u043B\u044B"
	optLang[8].text = "\u043F\u0440\u043E\u0446\u0435\u043D\u0442"
	optLang[9].text = "\u0432\u0432\u0435\u0440\u0445"
	optLang[10].text = "\u0441\u0435\u0440\u0435\u0434\u0438\u043D\u0430"
	optLang[11].text = "\u0432\u043D\u0438\u0437"
	optLang[12].text = "\u043F\u0438\u043A\u0441\u0435\u043B\u044B"
	optLang[13].text = "\u043F\u0440\u043E\u0446\u0435\u043D\u0442"
    
    	document.getElementById("btnCancel").value = "\u043E\u0442\u043C\u0435\u043D\u0430";
    	document.getElementById("btnOk").value = " ok ";
    	}
function writeTitle()
	{
	document.write("<title>\u0418\u0437\u043E\u0431\u0440\u0430\u0436\u0435\u043D\u0438\u0435 - \u043F\u043E\u0434\u043B\u043E\u0436\u043A\u0430</title>")
	}

