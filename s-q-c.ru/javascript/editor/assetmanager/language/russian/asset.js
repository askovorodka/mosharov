function getText(s)
	{
	switch(s)
		{
		case "Cannot delete Asset Base Folder.":return "\u041D\u0435\u043B\u044C\u0437\u044F \u0443\u0434\u0430\u043B\u0438\u0442\u044C \u043A\u043E\u0440\u043D\u0435\u0432\u0443\u044E \u043F\u0430\u043F\u043A\u0443 \u0444\u0430\u0439\u043B\u043E\u0432.";
		case "Delete this file ?":return "\u0423\u0434\u0430\u043B\u0438\u0442\u044C \u044D\u0442\u043E\u0442 \u0444\u0430\u0439\u043B?";
		case "Uploading...":return "\u041E\u0431\u043D\u043E\u0432\u043B\u0435\u043D\u0438\u0435...";
		case "File already exists. Do you want to replace it?":return "\u0424\u0430\u0439\u043B \u0443\u0436\u0435 \u0441\u0443\u0449\u0435\u0441\u0442\u0432\u0443\u0435\u0442. \u0425\u043E\u0442\u0438\u0442\u0435 \u0437\u0430\u043C\u0435\u043D\u0438\u0442\u044C \u0435\u0433\u043E?"

		case "Files": return "\u0424\u0430\u0439\u043B\u044B";
		case "del": return "\u0423\u0434\u0430\u043B";
		case "Empty...": return "\u041F\u0443\u0441\u0442\u043E...";
		}
	}
function loadText()
	{
	var txtLang = document.getElementsByName("txtLang");
	txtLang[0].innerHTML = "\u041D\u043E\u0432&nbsp;\u043F\u0430\u043F\u043A\u0430";
	txtLang[1].innerHTML = "\u0423\u0434\u0430\u043B&nbsp;\u043F\u0430\u043F\u043A\u0443";
	txtLang[2].innerHTML = "\u0417\u0430\u0433\u0440\u0443\u0437\u0438\u0442\u044C \u0444\u0430\u0439\u043B";

	var optLang = document.getElementsByName("optLang");
    optLang[0].text = "\u0412\u0441\u0435 \u0444\u0430\u0439\u043B\u044B";
    optLang[1].text = "\u041C\u0435\u0434\u0438\u0430";
    optLang[2].text = "\u0418\u0437\u043E\u0431\u0440";
    optLang[3].text = "Flash";

    document.getElementById("btnOk").value = " ok ";
    document.getElementById("btnUpload").value = "\u0437\u0430\u0433\u0440\u0443\u0437\u0438\u0442\u044C";
	}
function writeTitle()
    {
    document.write("<title>\u0423\u043F\u0440\u0430\u0432. \u0444\u0430\u0439\u043B\u0430\u043C\u0438</title>")
    }