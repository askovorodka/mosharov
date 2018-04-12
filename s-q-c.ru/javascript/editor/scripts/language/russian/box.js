function loadText()
    	{
    	var txtLang = document.getElementsByName("txtLang");
	txtLang[0].innerHTML = "\u0426\u0432\u0435\u0442";
	txtLang[1].innerHTML = "\u0422\u0435\u043D\u044C";	
	
	txtLang[2].innerHTML = "\u041E\u0442\u0441\u0442\u0443\u043F";
	txtLang[3].innerHTML = "\u041B\u0435\u0432\u044B\u0439";
	txtLang[4].innerHTML = "\u041F\u0440\u0430\u0432\u044B\u0439";
	txtLang[5].innerHTML = "\u0412\u0435\u0440\u0445\u043D\u0438\u0439";
	txtLang[6].innerHTML = "\u041D\u0438\u0436\u043D\u0438\u0439";
	
	txtLang[7].innerHTML = "\u041D\u0430\u0431\u0438\u0432\u043A\u0430";
	txtLang[8].innerHTML = "\u041B\u0435\u0432\u0430\u044F";
	txtLang[9].innerHTML = "\u041F\u0440\u0430\u0432\u0430\u044F";
	txtLang[10].innerHTML = "\u0412\u0435\u0440\u0445\u043D\u044F\u044F";
	txtLang[11].innerHTML = "\u041D\u0438\u0436\u043D\u044F\u044F";
	
	txtLang[12].innerHTML = "\u0420\u0430\u0437\u043C\u0435\u0440\u044B";
	txtLang[13].innerHTML = "\u0428\u0438\u0440\u0438\u043D\u0430";
	txtLang[14].innerHTML = "\u0412\u044B\u0441\u043E\u0442\u0430";
    
    	var optLang = document.getElementsByName("optLang");
	optLang[0].text = "\u043F\u0438\u043A\u0441\u0435\u043B\u044B";
	optLang[1].text = "\u043F\u0440\u043E\u0446\u0435\u043D\u0442";
	optLang[2].text = "\u043F\u0438\u043A\u0441\u0435\u043B\u044B";
	optLang[3].text = "\u043F\u0440\u043E\u0446\u0435\u043D\u0442";
    
    	document.getElementById("btnCancel").value = "\u043E\u0442\u043C\u0435\u043D\u0430";
    	document.getElementById("btnApply").value = "\u043F\u0440\u0438\u043C\u0435\u043D\u0438\u0442\u044C";
    	document.getElementById("btnOk").value = " ok ";
    	}
function getText(s)
    	{
    	switch(s)
        	{
		case "No Border": return "\u0411\u0435\u0437 \u0440\u0430\u043C\u043A\u0438";
		case "Outside Border": return "\u0412\u043D\u0435\u0448\u043D\u044F\u044F \u0440\u0430\u043C\u043A\u0430";
		case "Left Border": return "\u041B\u0435\u0432\u0430\u044F \u0440\u0430\u043C\u043A\u0430";
		case "Top Border": return "\u0412\u0435\u0440\u0445\u043D\u044F\u044F \u0440\u0430\u043C\u043A\u0430";
		case "Right Border": return "\u041F\u0440\u0430\u0432\u0430\u044F \u0440\u0430\u043C\u043A\u0430";
		case "Bottom Border": return "\u041D\u0438\u0436\u043D\u044F\u044F \u0440\u0430\u043C\u043A\u0430";
		case "Pick": return "\u0412\u044B\u0431\u043E\u0440";
		case "Custom Colors": return "\u041E\u0441\u043E\u0431\u044B\u0435 \u0446\u0432\u0435\u0442\u0430";
		case "More Colors...": return "\u0411\u043E\u043B\u044C\u0448\u0435 \u0446\u0432\u0435\u0442\u043E\u0432...";
		default: return "";
        	}
    	}

function writeTitle()
	{
	document.write("<title>\u0424\u043E\u0440\u043C\u0430\u0442\u0438\u0440\u043E\u0432\u0430\u043D\u0438\u0435 \u044F\u0447\u0435\u0439\u043A\u0438</title>")
	}