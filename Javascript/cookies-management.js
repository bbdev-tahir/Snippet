/******************************************/
/***** Check, Get and Set cookies **********/
/******************************************/
function setCookie(cname,cvalue,exdays, path = false) {
  var d = new Date();
  d.setTime(d.getTime() + (exdays*24*60*60*1000));
	var expires = "expires=" + d.toGMTString();
	if(path)
		document.cookie = cname + "=" + cvalue + ";" + expires + "; SameSite=Strict; path="+path;
	else
		document.cookie = cname + "=" + cvalue + ";" + expires + "; SameSite=Strict";
}

function getCookie(cname) {
  var name = cname + "=";
  var decodedCookie = decodeURIComponent(document.cookie);
  var ca = decodedCookie.split(';');
  for(var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

function deleteCookie(cname, path){
	document.cookie = cname + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path="+path;
}