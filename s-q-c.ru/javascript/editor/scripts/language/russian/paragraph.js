function loadText()
    	{
    	var txtLang = document.getElementsByName("txtLang");
	txtLang[0].innerHTML = "\u0412\u044B\u0440\u0430\u0432\u043D\u0438\u0432\u0430\u043D\u0438\u0435";
	txtLang[1].innerHTML = "\u041E\u0442\u0441\u0442\u0443\u043F";
	txtLang[2].innerHTML = "\u041C\u0435\u0436\u0434\u0443 \u0441\u043B\u043E\u0432\u0430\u043C\u0438";
	txtLang[3].innerHTML = "\u041C\u0435\u0436\u0441\u0438\u043C\u0432.";
	txtLang[4].innerHTML = "\u0412\u044B\u0441\u043E\u0442\u0430 \u0441\u0442\u0440\u043E\u043A\u0438";
	txtLang[5].innerHTML = "\u0417\u0430\u0433\u043B/\u0441\u0442\u0440\u043E\u0447";
	txtLang[6].innerHTML = "\u041F\u0440\u043E\u043F\u0443\u0441\u043A";
    
    	document.getElementById("divPreview").innerHTML = "Lorem ipsum dolor sit amet, " +
        	"consetetur sadipscing elitr, " +
        	"sed diam nonumy eirmod tempor invidunt ut labore et " +
        	"dolore magna aliquyam erat, " +
        	"sed diam voluptua. At vero eos et accusam et justo " +
        	"duo dolores et ea rebum. Stet clita kasd gubergren, " +
        	"no sea takimata sanctus est Lorem ipsum dolor sit amet.";
    
    	var optLang = document.getElementsByName("optLang");
	optLang[0].text = "\u041D\u0435 \u0443\u0441\u0442-\u043D";
	optLang[1].text = "\u0412\u043B\u0435\u0432\u043E";
	optLang[2].text = "\u0412\u043F\u0440\u0430\u0432\u043E";
	optLang[3].text = "\u0426\u0435\u043D\u0442\u0440";
	optLang[4].text = "\u0412\u044B\u0440\u0430\u0432\u043D\u0438\u0432\u0430\u0442\u044C";
	optLang[5].text = "\u041D\u0435 \u0443\u0441\u0442-\u043D";
	optLang[6].text = "\u0417\u0430\u0433\u043B\u0430\u0432\u043D\u044B\u0435";
	optLang[7].text = "\u0417\u0430\u0433\u043B\u0430\u0432\u043D\u044B\u0435 \u0432\u0441\u0435";
	optLang[8].text = "\u0421\u0442\u0440\u043E\u0447\u043D\u044B\u0435";
	optLang[9].text = "\u041D\u0435\u0442";
	optLang[10].text = "\u041D\u0435 \u0443\u0441\u0442.";
	optLang[11].text = "\u041D\u0435 \u043F\u0435\u0440\u0435\u043D\u043E\u0441\u0438\u0442\u044C";
	optLang[12].text = "pre";
	optLang[13].text = "\u041D\u043E\u0440\u043C\u0430\u043B\u044C\u043D\u044B\u0439";
    
    	document.getElementById("btnCancel").value = "\u043E\u0442\u043C\u0435\u043D\u0430";
    	document.getElementById("btnApply").value = "\u043F\u0440\u0438\u043C\u0435\u043D\u0438\u0442\u044C";
    	document.getElementById("btnOk").value = " ok ";   
    	}
function writeTitle()
	{
	document.write("<title>\u0410\u0431\u0437\u0430\u0446 - \u0424\u043E\u0440\u043C\u0430\u0442\u0438\u0440\u043E\u0432\u0430\u043D\u0438\u0435</title>")
	}
