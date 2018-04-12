function loadText()
    {
    var txtLang = document.getElementsByName("txtLang");
    txtLang[0].innerHTML = "CSS Text";
    txtLang[1].innerHTML = "Class Name";
    txtLang[2].innerHTML = "Preview";
    txtLang[3].innerHTML = "Apply to";
    
    var optLang = document.getElementsByName("optLang");
    optLang[0].text = "Selected Text"
    optLang[1].text = "Current Tag"
    
    document.getElementById("btnCancel").value = "cancel";
    document.getElementById("btnApply").value = "apply";
    document.getElementById("btnOk").value = " ok ";
    }
function getText(s)
    {
    switch(s)
        {
        case "You're selecting BODY element.":
            return "You're selecting BODY element.";
        case "Please select a text.":
            return "Please select a text.";
        default:return "";
        }
    }
function writeTitle()
    {
    document.write("<title>Custom CSS</title>")
    }