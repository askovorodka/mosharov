function loadText()
	{
    	document.getElementById("btnCancel").value = "\u043E\u0442\u043C\u0435\u043D\u0430";
    	document.getElementById("btnOk").value = " ok ";
	}
function getText(s)
	{
	switch(s)
		{
		case "Required":
			return "ieSpell \u0442\u0440\u0435\u0431\u0443\u0435\u0442\u0441\u044F (\u0441 www.iespell.com).";
		default:return "";
		}
	}
function writeTitle()
	{
	document.write("<title>\u041F\u0440\u043E\u0432\u0435\u0440\u043A\u0430 \u043E\u0440\u0444\u043E\u0433\u0440\u0430\u0444\u0438\u0438</title>")
	}