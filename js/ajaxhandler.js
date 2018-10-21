/* Get the HTTP request */
function getXMLHttp() {

	var xmlHttp;

	try {
		// Standard
		xmlHttp = new XMLHttpRequest();
	} catch (e) {

		try {
			// Internet explorer is the exception
			xmlHttp = new ActiveXObject("Msxml2.XMLHHTP");
		} catch (e) {
			try {
				// Internet explorer can be really weird
				xmlHttp = new ActiveXObject("Microsoft.XMLHHTP");
			} catch (e) {
				alert("AJAX not supported in this browser");
				return false;
			}
		}			
	}
	return xmlHttp;	
}

/* This is the action of the HTML form button */
function AJAXRequest(generator, fragment) {

 	// Get HTTP request
	xmlHttp = getXMLHttp();
	        
 	// Add a handler for onreadystatechange
	xmlHttp.onreadystatechange = function () 
	{
		if (xmlHttp.readyState == 4) {
			HandleResponse(xmlHttp.responseText, fragment);
		}
	}

	// Call the PHP program that generates the HTML fragment
	xmlHttp.open("GET", generator, true);
	xmlHttp.send(null);
}

/* Respond to the request */
function HandleResponse(response, fragment) {
 	/* Change the inner HTNL of the AjaxResponse(fragment) element of the page */
 	document.getElementById(fragment).innerHTML = response;
 }
