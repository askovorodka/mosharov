function loadText()
    {
    var txtLang = document.getElementsByName("txtLang");
	txtLang[0].innerHTML = "\u041F\u0440\u0435\u0434\u043F\u0440\u043E\u0441\u043C\u043E\u0442\u0440";
	txtLang[1].innerHTML = "CSS \u0442\u0435\u043A\u0441\u0442";
	txtLang[2].innerHTML = "\u0418\u043C\u044F Class-\u0430";
	txtLang[3].innerHTML = "\u041F\u0440\u0438\u043C\u0435\u043D\u0438\u0442\u044C \u043A";

    var optLang = document.getElementsByName("optLang");
	optLang[0].text = "\u0412\u044B\u0434\u0435\u043B\u0435\u043D\u043D\u044B\u0439 \u0442\u0435\u043A\u0441\u0442"
	optLang[1].text = "\u0422\u0435\u043A\u0443\u0449\u0438\u0439 \u0442\u044D\u0433"

    document.getElementById("btnCancel").value = "\u043E\u0442\u043C\u0435\u043D\u0430";
    document.getElementById("btnApply").value = "\u043F\u0440\u0438\u043C\u0435\u043D\u0438\u0442\u044C";
    document.getElementById("btnOk").value = " ok ";
    }
function getText(s)
    {
    switch(s)
        {
	case "You're selecting BODY element.":
		return "\u0412\u044B \u0432\u044B\u0431\u0440\u0430\u043B\u0438 BODY \u0442\u044D\u0433.";
	case "Please select a text.":
		return "\u041F\u043E\u0436\u0430\u043B\u0443\u0439\u0441\u0442\u0430, \u0432\u044B\u0434\u0435\u043B\u0438\u0442\u0435 \u0442\u0435\u043A\u0441\u0442.";
	default:return "";;
        }
    }
function writeTitle()
	{
	document.write("<title>\u041E\u0441\u043E\u0431\u044B\u0439 CSS</title>")
	}