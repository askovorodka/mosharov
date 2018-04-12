var sStyleWeight1;
var sStyleWeight2;
var sStyleWeight3;
var sStyleWeight4; 

function loadText()
    	{
    	var txtLang = document.getElementsByName("txtLang");
	txtLang[0].innerHTML = "\u0428\u0440\u0438\u0444\u0442";
	txtLang[1].innerHTML = "\u0421\u0442\u0438\u043B\u044C";
	txtLang[2].innerHTML = "\u0420\u0430\u0437\u043C\u0435\u0440";
	txtLang[3].innerHTML = "\u0426\u0432\u0435\u0442 \u0442\u0435\u043A\u0441\u0442\u0430";
	txtLang[4].innerHTML = "\u0424\u043E\u043D";
	txtLang[5].innerHTML = "\u042D\u0444\u0444\u0435\u043A\u0442\u044B";
	
	txtLang[6].innerHTML = "\u041E\u0442\u043E\u0431\u0440\u0430\u0436\u0435\u043D\u0438\u0435";
	txtLang[7].innerHTML = "\u0417\u0430\u0433\u043B./\u0441\u0442\u0440\u043E\u0447\u043D.";
	txtLang[8].innerHTML = "\u041C\u0438\u043D\u0438-\u0437\u0430\u0433\u043B.";
	txtLang[9].innerHTML = "\u0412\u0435\u0440\u0442\u0438\u043A\u0430\u043B\u044C";

	txtLang[10].innerHTML = "\u043D\u0435 \u0443\u0441\u0442.";
	txtLang[11].innerHTML = "\u043F\u043E\u0434\u0447\u0435\u0440\u043A\u043D\u0443\u0442\u044C";
	txtLang[12].innerHTML = "\u043D\u0430\u0434\u0447\u0435\u0440\u043A\u043D\u0443\u0442\u044C";
	txtLang[13].innerHTML = "\u043F\u0435\u0440\u0435\u0447\u0435\u0440\u043A\u043D\u0443\u0442\u044C";
	txtLang[14].innerHTML = "\u043D\u0435\u0442";

	txtLang[15].innerHTML = "\u041D\u0435 \u0443\u0441\u0442";
	txtLang[16].innerHTML = "\u0417\u0430\u0433\u043B\u0430\u0432\u043D\u044B\u0435";
	txtLang[17].innerHTML = "\u0412\u0441\u0435 \u0437\u0430\u0433\u043B\u0430\u0432\u043D\u044B\u0435";
	txtLang[18].innerHTML = "\u0412\u0441\u0435 \u0441\u0442\u0440\u043E\u0447\u043D\u044B\u0435";
	txtLang[19].innerHTML = "\u041D\u0435\u0442";

	txtLang[20].innerHTML = "\u041D\u0435 \u0443\u0441\u0442.";
	txtLang[21].innerHTML = "\u041C\u0438\u043D\u0438-\u0437\u0430\u0433\u043B.";
	txtLang[22].innerHTML = "\u041E\u0431\u044B\u0447\u043D\u043E";

	txtLang[23].innerHTML = "\u041D\u0435 \u0443\u0441\u0442";
	txtLang[24].innerHTML = "\u0412\u0432\u0435\u0440\u0445\u0443";
	txtLang[25].innerHTML = "\u0412\u043D\u0438\u0437\u0443";
	txtLang[26].innerHTML = "\u041E\u0442\u043D\u043E\u0441\u0438\u0442\u0435\u043B\u044C\u043D\u043E";
	txtLang[27].innerHTML = "\u041F\u043E \u043D\u0438\u0437\u0443";
	
	txtLang[28].innerHTML = "\u041C\u0435\u0436\u0434\u0443 \u0441\u0438\u043C\u0432\u043E\u043B\u0430\u043C\u0438";
	txtLang[29].innerHTML = "\u041F\u0440\u0435\u0434\u043F\u0440\u043E\u0441\u043C\u043E\u0442\u0440";
    
    	var optLang = document.getElementsByName("optLang");
	optLang[0].text = "\u041E\u0431\u044B\u0447\u043D\u044B\u0439"
	optLang[1].text = "\u041A\u0443\u0440\u0441\u0438\u0432"
	optLang[2].text = "\u0416\u0438\u0440\u043D\u044B\u0439"
	optLang[3].text = "\u0416\u0440\u043D+\u043A\u0443\u0440"

	optLang[0].value = "\u041E\u0431\u044B\u0447\u043D\u044B\u0439"
	optLang[1].value = "\u041A\u0443\u0440\u0441\u0438\u0432"
	optLang[2].value = "\u0416\u0438\u0440\u043D\u044B\u0439"
	optLang[3].value = "\u0416\u0440\u043D+\u043A\u0443\u0440"
    
	sStyleWeight1 = "\u041E\u0431\u044B\u0447\u043D\u044B\u0439"
	sStyleWeight2 = "\u041A\u0443\u0440\u0441\u0438\u0432"
	sStyleWeight3 = "\u0416\u0438\u0440\u043D\u044B\u0439"
	sStyleWeight4 = "\u0416\u0440\u043D+\u043A\u0443\u0440"
    
	optLang[4].text = "\u0412\u0435\u0440\u0445"
	optLang[5].text = "\u0421\u0435\u0440\u0435\u0434\u0438\u043D\u0430"
	optLang[6].text = "\u041D\u0438\u0437"
	optLang[7].text = "\u0412\u0435\u0440\u0445 \u0442\u0435\u043A\u0441\u0442\u0430"
	optLang[8].text = "\u041D\u0438\u0437 \u0442\u0435\u043A\u0441\u0442\u0430"
    
    	document.getElementById("btnPick1").value = "\u0412\u044B\u0431\u043E\u0440";
    	document.getElementById("btnPick2").value = "\u0412\u044B\u0431\u043E\u0440";

    	document.getElementById("btnCancel").value = "\u043E\u0442\u043C\u0435\u043D\u0430";
    	document.getElementById("btnOk").value = " ok ";
    	}
function getText(s)
    	{
    	switch(s)
        	{
		case "Custom Colors": return "\u041E\u0441\u043E\u0431\u044B\u0435 \u0446\u0432\u0435\u0442\u0430";
		case "More Colors...": return "\u0411\u043E\u043B\u044C\u0448\u0435 \u0446\u0432\u0435\u0442\u043E\u0432...";
		default: return "";
        	}
    	}
function writeTitle()
	{
	document.write("<title>\u0424\u043E\u0440\u043C\u0430\u0442\u0438\u0440\u043E\u0432\u0430\u043D\u0438\u0435 \u0442\u0435\u043A\u0441\u0442\u0430</title>")
	}