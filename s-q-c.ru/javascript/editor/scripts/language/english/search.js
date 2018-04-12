function loadText()
	{
    var txtLang = document.getElementsByName("txtLang");
    txtLang[0].innerHTML = "Search";
    txtLang[1].innerHTML = "Replace";
    txtLang[2].innerHTML = "Match case";
    txtLang[3].innerHTML = "Match whole word";
    
    document.getElementById("btnSearch").value = "search next";;
    document.getElementById("btnReplace").value = "replace";
    document.getElementById("btnReplaceAll").value = "replace all";  
    document.getElementById("btnClose").value = "close";
	}
function writeTitle()
	{
	document.write("<title>Search & Replace</title>")
	}