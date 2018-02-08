function loadText()
    {
    var txtLang =  document.getElementsByName("txtLang");
	txtLang[0].innerHTML = "\u0410\u0432\u0442\u043E\u0440\u0430\u0437\u043C\u0435\u0440";
	txtLang[1].innerHTML = "\u0421\u0432\u043E\u0439\u0441\u0442\u0432\u0430";
	txtLang[2].innerHTML = "\u0421\u0442\u0438\u043B\u044C";
	txtLang[3].innerHTML = "\u0428\u0438\u0440\u0438\u043D\u0430";
	txtLang[4].innerHTML = "\u0420\u0430\u0437\u043C\u0435\u0440 \u043F\u043E \u0442\u0435\u043A\u0441\u0442\u0443";
	txtLang[5].innerHTML = "\u0424\u0438\u043A\u0441\u0438\u0440-\u0430\u044F \u0448\u0438\u0440\u0438\u043D\u0430 \u0442\u0430\u0431\u043B.";
	txtLang[6].innerHTML = "\u0423\u043C\u0435\u0441\u0442\u0438\u0442\u044C \u0432 \u043E\u043A\u043D\u043E";
	txtLang[7].innerHTML = "\u0412\u044B\u0441\u043E\u0442\u0430";
	txtLang[8].innerHTML = "\u0420\u0430\u0437\u043C\u0435\u0440 \u043F\u043E \u0442\u0435\u043A\u0441\u0442\u0443";
	txtLang[9].innerHTML = "\u0424\u0438\u043A\u0441\u0438\u0440-\u0430\u044F \u0432\u044B\u0441\u043E\u0442\u0430 \u0442\u0430\u0431\u043B.";
	txtLang[10].innerHTML = "\u0423\u043C\u0435\u0441\u0442\u0438\u0442\u044C \u0432 \u043E\u043A\u043D\u043E";
	txtLang[11].innerHTML = "\u0412\u044B\u0440\u0430\u0432\u043D\u0438\u0432\u0430\u043D\u0438\u0435";
	txtLang[12].innerHTML = "\u041E\u0442\u0441\u0442\u0443\u043F";
	txtLang[13].innerHTML = "\u0412\u043B\u0435\u0432\u043E";
	txtLang[14].innerHTML = "\u0412\u043F\u0440\u0430\u0432\u043E";
	txtLang[15].innerHTML = "\u0412\u0432\u0435\u0440\u0445";
	txtLang[16].innerHTML = "\u0412\u043D\u0438\u0437";	
	txtLang[17].innerHTML = "\u0420\u0430\u043C\u043A\u0430";
	txtLang[19].innerHTML = "\u0421\u0431\u043B\u0438\u0437\u0438\u0442\u044C";
	txtLang[18].innerHTML = "\u041F\u043E\u0434\u043B\u043E\u0436\u043A\u0430";
	txtLang[20].innerHTML = "\u041C\u0435\u0436\u0434\u0443 \u044F\u0447\u0435\u0439\u043A\u0430\u043C\u0438";
	txtLang[21].innerHTML = "\u041D\u0430\u0431\u0438\u0432\u043A\u0430 \u044F\u0447\u0435\u0435\u043A";
	txtLang[22].innerHTML = "CSS \u0442\u0435\u043A\u0441\u0442";
    
    var optLang = document.getElementsByName("optLang");
	optLang[0].text = "\u043F\u0438\u043A\u0441\u0435\u043B\u0438"
	optLang[1].text = "\u043F\u0440\u043E\u0446\u0435\u043D\u0442"
	optLang[2].text = "\u043F\u0438\u043A\u0441\u0435\u043B\u0438"
	optLang[3].text = "\u043F\u0440\u043E\u0446\u0435\u043D\u0442"
	optLang[4].text = "\u0432\u043B\u0435\u0432\u043E"
	optLang[5].text = "\u0446\u0435\u043D\u0442\u0440"
	optLang[6].text = "\u0432\u043F\u0440\u0430\u0432\u043E"
	optLang[7].text = "\u041D\u0435\u0442 \u0440\u0430\u043C\u043A\u0438"
	optLang[8].text = "\u0414\u0430"
	optLang[9].text = "\u041D\u0435\u0442"

    document.getElementById("btnPick").value="\u0412\u044B\u0431\u043E\u0440";
    document.getElementById("btnImage").value="\u0418\u0437\u043E\u0431\u0440-\u043D\u0438\u0435";

    document.getElementById("btnCancel").value = "\u043E\u0442\u043C\u0435\u043D\u0430";
    document.getElementById("btnApply").value = "\u043F\u0440\u0438\u043C\u0435\u043D\u0438\u0442\u044C";
    document.getElementById("btnOk").value = " ok ";
    }
function getText(s)
    {
    switch(s)
        {
		case "Custom Colors": return "\u041E\u0441\u043E\u0431\u044B\u0435 \u0446\u0432\u0435\u0442\u0430";
		case "More Colors...": return "\u0411\u043E\u043B\u044C\u0448\u0435 \u0446\u0432\u0435\u0442\u043E\u0432...";
		default:return "";
        }
    }
function writeTitle()
	{
	document.write("<title>\u0421\u0432\u043E\u0439\u0441\u0442\u0432\u0430 \u0442\u0430\u0431\u043B\u0438\u0446\u044B</title>")
	}