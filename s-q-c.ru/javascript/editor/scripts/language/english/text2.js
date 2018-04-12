var sStyleWeight1;
var sStyleWeight2;
var sStyleWeight3;
var sStyleWeight4; 

function loadText()
    {
    var txtLang = document.getElementsByName("txtLang");
    txtLang[0].innerHTML = "Font";
    txtLang[1].innerHTML = "Style";
    txtLang[2].innerHTML = "Size";
    txtLang[3].innerHTML = "Foreground";
    txtLang[4].innerHTML = "Background";
    txtLang[5].innerHTML = "Effects";
    
    txtLang[6].innerHTML = "Decoration";
    txtLang[7].innerHTML = "Text Case";
    txtLang[8].innerHTML = "Minicaps";
    txtLang[9].innerHTML = "Vertical";

    txtLang[10].innerHTML = "Not Set";
    txtLang[11].innerHTML = "Underline";
    txtLang[12].innerHTML = "Overline";
    txtLang[13].innerHTML = "Line-through";
    txtLang[14].innerHTML = "None";

    txtLang[15].innerHTML = "Not Set";
    txtLang[16].innerHTML = "Capitalize";
    txtLang[17].innerHTML = "Uppercase";
    txtLang[18].innerHTML = "Lowercase";
    txtLang[19].innerHTML = "None";

    txtLang[20].innerHTML = "Not Set";
    txtLang[21].innerHTML = "Small-Caps";
    txtLang[22].innerHTML = "Normal";

    txtLang[23].innerHTML = "Not Set";
    txtLang[24].innerHTML = "Superscript";
    txtLang[25].innerHTML = "Subscript";
    txtLang[26].innerHTML = "Relative";
    txtLang[27].innerHTML = "Baseline";
    
    txtLang[28].innerHTML = "Character Spacing";
    txtLang[29].innerHTML = "Preview";
    
    var optLang = document.getElementsByName("optLang");
    optLang[0].text = "Regular"
    optLang[1].text = "Italic"
    optLang[2].text = "Bold"
    optLang[3].text = "Bold Italic"

    optLang[0].value = "Regular"
    optLang[1].value = "Italic"
    optLang[2].value = "Bold"
    optLang[3].value = "Bold Italic"
    
    sStyleWeight1 = "Regular"
    sStyleWeight2 = "Italic"
    sStyleWeight3 = "Bold"
    sStyleWeight4 = "Bold Italic"
    
    optLang[4].text = "Top"
    optLang[5].text = "Middle"
    optLang[6].text = "Bottom"
    optLang[7].text = "Text-Top"
    optLang[8].text = "Text-Bottom"
    
    document.getElementById("btnPick1").value = "Pick";
    document.getElementById("btnPick2").value = "Pick";

    document.getElementById("btnCancel").value = "cancel";
    document.getElementById("btnOk").value = " ok ";
    }
function getText(s)
    {
    switch(s)
        {
        case "Custom Colors": return "Custom Colors";
        case "More Colors...": return "More Colors...";
        default: return "";
        }
    }
function writeTitle()
    {
    document.write("<title>Text Formatting</title>")
    }