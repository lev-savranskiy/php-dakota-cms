// Общая функция копирования - копирует текст переменной maintext в clipboard, рабоает для IE и Firefox
function copy_clip(maintext)
{
maintext = String(maintext)
if (window.clipboardData)
window.clipboardData.setData("Text", maintext);
else if (window.netscape)
{
try
{
netscape.security.PrivilegeManager.enablePrivilege('UniversalXPConnect');
var gClipboardHelper = Components.classes["@mozilla.org/widget/clipboardhelper;1"].
getService(Components.interfaces.nsIClipboardHelper);
gClipboardHelper.copyString(maintext);
}
catch(err)
{ alert ("Clipboard copying error: " + err); return false }
}
alert('Text in buffer: ' + maintext)
return true;
}

function copyTitleInLink(obj)
{
copy_clip(obj.href)
return false
}