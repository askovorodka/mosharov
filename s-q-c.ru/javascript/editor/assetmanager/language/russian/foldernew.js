function getText(s)
	{
	switch(s)
		{
		case "Folder already exists.": return "\u0422\u0430\u043A\u0430\u044F \u043F\u0430\u043F\u043A\u0430 \u0443\u0436\u0435 \u0441\u0443\u0449\u0435\u0441\u0442\u0432\u0443\u0435\u0442.";
		case "Folder created.": return "\u041F\u0430\u043F\u043A\u0430 \u0441\u043E\u0437\u0434\u0430\u043D\u0430.";
		case "Invalid input.":return "\u041D\u0435\u0432\u0435\u0440\u043D\u044B\u0439 \u0432\u0432\u043E\u0434.";
		}
	}	
function loadText()
	{
    document.getElementById("txtLang").innerHTML = "\u041D\u0430\u0437\u0432\u0430\u043D\u0438\u0435 \u043D\u043E\u0432\u043E\u0439 \u043F\u0430\u043F\u043A\u0438";
    document.getElementById("btnCloseAndRefresh").value = "\u0437\u0430\u043A\u0440\u044B\u0442\u044C \u0438 \u043E\u0431\u043D\u043E\u0432\u0438\u0442\u044C";
    document.getElementById("btnCreate").value = "\u0441\u043E\u0437\u0434\u0430\u0442\u044C";
	}
function writeTitle()
	{
	document.write("<title>\u0421\u043E\u0437\u0434\u0430\u0442\u044C \u043F\u0430\u043F\u043A\u0443</title>")
	}
