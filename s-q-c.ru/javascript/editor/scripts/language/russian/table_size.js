function loadText()
    {
    var txtLang =  document.getElementsByName("txtLang");
    txtLang[0].innerHTML = "\u0412\u0441\u0442\u0430\u0432\u0438\u0442\u044C \u0441\u0442\u0440\u043E\u043A\u0443";
    txtLang[1].innerHTML = "\u0412\u0441\u0442\u0430\u0432\u0438\u0442\u044C \u0441\u0442\u043E\u043B\u0431\u0435\u0446";
    txtLang[2].innerHTML = "\u041E\u0431\u044A\u0435\u0434 \u0441\u0442\u0440\u043E\u043A\u0443";
    txtLang[3].innerHTML = "\u041E\u0431\u044A\u0435\u0434 \u0441\u0442\u043E\u043B\u0431\u0435\u0446";
    txtLang[4].innerHTML = "\u0423\u0434\u0430\u043B\u0438\u0442\u044C \u0441\u0442\u0440\u043E\u043A\u0443";
    txtLang[5].innerHTML = "\u0423\u0434\u0430\u043B\u0438\u0442\u044C \u0441\u0442\u043E\u043B\u0431\u0435\u0446";

	document.getElementById("btnInsRowAbove").title="Insert Row (Above)";
	document.getElementById("btnInsRowBelow").title="Insert Row (Below)";
	document.getElementById("btnInsColLeft").title="Insert Column (Left)";
	document.getElementById("btnInsColRight").title="Insert Column (Right)";
	document.getElementById("btnIncRowSpan").title="Increase Rowspan";
	document.getElementById("btnDecRowSpan").title="Decrease Rowspan";
	document.getElementById("btnIncColSpan").title="Increase Colspan";
	document.getElementById("btnDecColSpan").title="Decrease Colspan";
	document.getElementById("btnDelRow").title="Delete Row";
	document.getElementById("btnDelCol").title="Delete Column";

	document.getElementById("btnClose").value = " \u0437\u0430\u043A\u0440\u044B\u0442\u044C ";
    }
function getText(s)
    {
    switch(s)
        {
		case "Cannot delete column.":
			return "\u041D\u0435\u0432\u043E\u0437\u043C\u043E\u0436\u043D\u043E \u0443\u0434\u0430\u043B\u0438\u0442\u044C \u043A\u043E\u043B\u043E\u043D\u043A\u0443. \u041A\u043E\u043B\u043E\u043D\u043A\u0430 \u0441\u043E\u0434\u0435\u0440\u0436\u0438\u0442 \u043E\u0431\u044A\u0435\u0434\u0438\u043D\u0435\u043D\u043D\u044B\u0435 \u044F\u0447\u0435\u0439\u043A\u0438 \u0434\u0440\u0443\u0433\u0438\u0445 \u043A\u043E\u043B\u043E\u043D\u043E\u043A. \u0421\u043D\u0430\u0447\u0430\u043B\u0430 \u0443\u0434\u0430\u043B\u0438\u0442\u0435 \u044D\u0442\u043E \u043E\u0431\u044A\u0435\u0434\u0438\u043D\u0435\u043D\u0438\u0435.";
		case "Cannot delete row.":
			return "\u041D\u0435\u0432\u043E\u0437\u043C\u043E\u0436\u043D\u043E \u0443\u0434\u0430\u043B\u0438\u0442\u044C \u0441\u0442\u0440\u043E\u043A\u0443. \u0421\u0442\u0440\u043E\u043A\u0430 \u0441\u043E\u0434\u0435\u0440\u0436\u0438\u0442 \u043E\u0431\u044A\u0435\u0434\u0438\u043D\u0435\u043D\u043D\u044B\u0435 \u044F\u0447\u0435\u0439\u043A\u0438 \u0434\u0440\u0443\u0433\u0438\u0445 \u0441\u0442\u0440\u043E\u043A. \u0421\u043D\u0430\u0447\u0430\u043B\u0430 \u0443\u0434\u0430\u043B\u0438\u0442\u0435 \u044D\u0442\u043E \u043E\u0431\u044A\u0435\u0434\u0438\u043D\u0435\u043D\u0438\u0435.";
        default:return "";
        }
    }
function writeTitle()
    {
    document.write("<title>\u042F\u0447\u0435\u0439\u043A\u0438&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</title>")
    }