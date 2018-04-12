function loadText()
    	{    
    	var txtLang = document.getElementsByName("txtLang");
	txtLang[0].innerHTML = "\u0420\u0430\u0437\u043C\u0435\u0440";
	txtLang[1].innerHTML = "\u0421\u0432\u043E\u0439\u0441\u0442\u0432\u0430";
	txtLang[2].innerHTML = "\u0421\u0442\u0438\u043B\u044C";
	txtLang[3].innerHTML = "\u0428\u0438\u0440\u0438\u043D\u0430";
	txtLang[4].innerHTML = "\u0420\u0430\u0437\u043C\u0435\u0440 \u043F\u043E \u0442\u0435\u043A\u0441\u0442\u0443";
	txtLang[5].innerHTML = "\u0424\u0438\u043A\u0441\u0438\u0440-\u0430\u044F \u0448\u0438\u0440\u0438\u043D\u0430";
	txtLang[6].innerHTML = "\u0412\u044B\u0441\u043E\u0442\u0430";
	txtLang[7].innerHTML = "\u0420\u0430\u0437\u043C\u0435\u0440 \u043F\u043E \u0442\u0435\u043A\u0441\u0442\u0443";
	txtLang[8].innerHTML = "\u0424\u0438\u043A\u0441\u0438\u0440-\u0430\u044F \u0432\u044B\u0441\u043E\u0442\u0430";
	txtLang[9].innerHTML = "\u0412\u044B\u0440\u0430\u0432\u043D\u0438\u0432\u0430\u043D\u0438\u0435<br>\u0442\u0435\u043A\u0441\u0442\u0430";
	txtLang[10].innerHTML = "\u041D\u0430\u0431\u0438\u0432\u043A\u0430";
	txtLang[11].innerHTML = "\u0412\u043B\u0435\u0432\u043E";
	txtLang[12].innerHTML = "\u0412\u043F\u0440\u0430\u0432\u043E";
	txtLang[13].innerHTML = "\u0412\u0432\u0435\u0440\u0445";
	txtLang[14].innerHTML = "\u0412\u043D\u0438\u0437";
	txtLang[15].innerHTML = "\u041F\u0440\u043E\u043F\u0443\u0441\u043A\u0438";
	txtLang[16].innerHTML = "\u041F\u043E\u0434\u043B\u043E\u0436\u043A\u0430";
	txtLang[17].innerHTML = "\u041F\u0440\u0435\u0434\u043F\u0440\u043E\u0441\u043C\u043E\u0442\u0440";
	txtLang[18].innerHTML = "CSS \u0442\u0435\u043A\u0441\u0442";
	txtLang[19].innerHTML = "\u041F\u0440\u0438\u043C\u0435\u043D\u0438\u0442\u044C \u043A";

    	document.getElementById("btnPick").value = "\u0412\u044B\u0431\u043E\u0440";
    	document.getElementById("btnImage").value = "\u0418\u0437\u043E\u0431\u0440-\u043D\u0438\u0435";
    	document.getElementById("btnText").value = " \u0424\u043E\u0440\u043C\u0430\u0442\u0438\u0440\u043E\u0432\u0430\u043D\u0438\u0435 \u0442\u0435\u043A\u0441\u0442\u0430 ";
    	document.getElementById("btnBorder").value = " \u0421\u0442\u0438\u043B\u044C \u0440\u0430\u043C\u043A\u0438 ";

    	document.getElementById("btnCancel").value = "\u043E\u0442\u043C\u0435\u043D\u0430";
    	document.getElementById("btnApply").value = "\u043F\u0440\u0438\u043C\u0435\u043D\u0438\u0442\u044C";
    	document.getElementById("btnOk").value = " ok ";
    
    	var optLang = document.getElementsByName("optLang");
	optLang[0].text = "\u043F\u0438\u043A\u0441\u0435\u043B\u0438"
	optLang[1].text = "\u043F\u0440\u043E\u0446\u0435\u043D\u0442"
	optLang[2].text = "\u043F\u0438\u043A\u0441\u0435\u043B\u0438"
	optLang[3].text = "\u043F\u0440\u043E\u0446\u0435\u043D\u0442"
	optLang[4].text = "\u043D\u0435\u0442"
	optLang[5].text = "\u0432\u0432\u0435\u0440\u0445"
	optLang[6].text = "\u0441\u0435\u0440\u0435\u0434\u0438\u043D\u0430"
	optLang[7].text = "\u0432\u043D\u0438\u0437"
	optLang[8].text = "\u043D\u0438\u0436\u043D.\u043A\u0440\u0430\u0439"
	optLang[9].text = "\u043F\u043E\u0434"
	optLang[10].text = "\u043D\u0430\u0434"
	optLang[11].text = "\u0432\u0435\u0440\u0445 \u0442\u0435\u043A\u0441\u0442\u0430"
	optLang[12].text = "\u043D\u0438\u0437 \u0442\u0435\u043A\u0441\u0442\u0430"
	optLang[13].text = "\u043D\u0435\u0442"
	optLang[14].text = "\u0432\u043B\u0435\u0432\u043E"
	optLang[15].text = "\u0446\u0435\u043D\u0442\u0440"
	optLang[16].text = "\u0432\u043F\u0440\u0430\u0432\u043E"
	optLang[17].text = "\u0432\u044B\u0440\u0430\u0432\u043D\u0438\u0432\u0430\u0442\u044C"
	optLang[18].text = "\u043D\u0435\u0442"
	optLang[19].text = "\u043D\u0435 \u043F\u0435\u0440\u0435\u043D\u043E\u0441\u0438\u0442\u044C"
	optLang[20].text = "pre"
	optLang[21].text = "\u041E\u0431\u044B\u0447\u043D\u044B\u0439"
	optLang[22].text = "\u0422\u0435\u043A\u0443\u0449. \u044F\u0447\u0435\u0439\u043A\u0430"
	optLang[23].text = "\u0422\u0435\u043A\u0443\u0449. \u0441\u0442\u0440\u043E\u043A\u0430"
	optLang[24].text = "\u0422\u0435\u043A\u0443\u0449. \u043A\u043E\u043B\u043E\u043D\u043A\u0430"
    	}
function getText(s)
    	{
    	switch(s)
        	{
		case "Custom Colors": return "\u041E\u0431\u044B\u0447\u043D\u044B\u0435 \u0446\u0432\u0435\u0442\u0430";
		case "More Colors...": return "\u0411\u043E\u043B\u044C\u0448\u0435 \u0446\u0432\u0435\u0442\u043E\u0432...";
		default: return "";
        	}
    	}    
function writeTitle()
	{
	document.write("<title>\u0421\u0432\u043E\u0439\u0441\u0442\u0432\u0430 \u044F\u0447\u0435\u0439\u043A\u0438</title>")
	}