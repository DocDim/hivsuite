var x=document.getElementById("region");

function formationFunction() {
	
   if ( document.getElementById("region").selectedIndex=="1") {
	   	   
	    var l = document.createElement("OPTION");
		l.setAttribute("value", "HRM1");
		var t = document.createTextNode("HRM1");
		l.appendChild(t);
		document.getElementById("facility").appendChild(l);
		
		var k = document.createElement("OPTION");
		k.setAttribute("value", "GP");
		var s = document.createTextNode("GP");
		k.appendChild(s);
		document.getElementById("facility").appendChild(k);	


		var k = document.createElement("OPTION");
		k.setAttribute("value", "SED");
		var s = document.createTextNode("SED");
		k.appendChild(s);
		document.getElementById("facility").appendChild(k);	   
	}
	else
		if ( document.getElementById("region").selectedIndex=="2") {

			
			var l = document.createElement("OPTION");
			l.setAttribute("value", "HRM2");
			var t = document.createTextNode("HRM2");
			l.appendChild(t);
			document.getElementById("facility").appendChild(l);
			
			var k = document.createElement("OPTION");
			k.setAttribute("value", "BBR");
			var s = document.createTextNode("BBR");
			k.appendChild(s);
			document.getElementById("facility").appendChild(k);	


			var k = document.createElement("OPTION");
			k.setAttribute("value", "GENIE");
			var s = document.createTextNode("GENIE");
			k.appendChild(s);
			document.getElementById("facility").appendChild(k);	   
	}
}

function bmiFunction() {
	
   
}




