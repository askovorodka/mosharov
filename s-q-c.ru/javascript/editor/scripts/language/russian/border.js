function loadText()
    {
    document.getElementById("txtLang").innerHTML = "\u0426\u0432\u0435\u0442";
    document.getElementById("btnCancel").value = "\u043E\u0442\u043C\u0435\u043D\u0430";
    document.getElementById("btnOk").value = " ok ";
    }
function getText(s)
	{
	switch(s)
		{
		case "No Border": return "\u041D\u0435\u0442 \u0440\u0430\u043C\u043A\u0438";
		case "Outside Border": return "\u0412\u043D\u0435\u0448\u043D\u044F\u044F \u0440\u0430\u043C\u043A\u0430";
		case "Left Border": return "\u041B\u0435\u0432\u0430\u044F \u0440\u0430\u043C\u043A\u0430";
		case "Top Border": return "\u0412\u0435\u0440\u0445\u043D\u044F\u044F \u0440\u0430\u043C\u043A\u0430";
		case "Right Border": return "\u041F\u0440\u0430\u0432\u0430\u044F \u0440\u0430\u043C\u043A\u0430";
		case "Bottom Border": return "\u041D\u0438\u0436\u043D\u044F\u044F \u0440\u0430\u043C\u043A\u0430";
		case "Pick": return "\u0412\u044B\u0431\u0440\u0430\u0442\u044C";
		case "Custom Colors": return "\u041E\u0441\u043E\u0431\u044B\u0435 \u0446\u0432\u0435\u0442\u0430";
		case "More Colors...": return "\u0411\u043E\u043B\u044C\u0448\u0435 \u0446\u0432\u0435\u0442\u043E\u0432...";
		default: return "";
		}
	}
function writeTitle()
	{
	document.write("<title>\u0420\u0430\u043C\u043A\u0430 - \u0433\u0440\u0430\u043D\u0438\u0446\u0430</title>")
	}