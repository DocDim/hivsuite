
  function initialize() {
  
	map = new google.maps.Map(document.getElementById("map_canvas"), {
        zoom: 6,
        center: new google.maps.LatLng(7.2746159,13.7202004),
        mapTypeId: google.maps.MapTypeId.ROADMAP
      });
	  
	var HRA_Kousseri=new google.maps.LatLng(12.08496,15.01923);
	var CMA_Blangoua=new google.maps.LatLng(12.77300,14.55228);
	var HD_Deido=new google.maps.LatLng(4.06581,9.70936);
	
	var marker1=new google.maps.Marker({
		position:HRA_Kousseri,
		icon:'images/pinkball.png',
		//animation:google.maps.Animation.BOUNCE
	});
	
	var marker2=new google.maps.Marker({
		position:CMA_Blangoua,
		icon:'images/pinkball.png',
		//animation:google.maps.Animation.BOUNCE
	});
	var marker3=new google.maps.Marker({
		position:HD_Deido,
		icon:'images/pinkball.png',
		//animation:google.maps.Animation.BOUNCE
	});

	marker1.setMap(map);
	marker2.setMap(map);
	marker3.setMap(map);	

	google.maps.event.addListener(marker1,'click',function() {	
	var infowindow = new google.maps.InfoWindow({
	content:"HRA Kousseri"
	});
	infowindow.open(map,marker1);
	});
	
	google.maps.event.addListener(marker2,'click',function() {	
	var infowindow = new google.maps.InfoWindow({
	content:"CMA Blangoua"
	});
	infowindow.open(map,marker2);
	});
	
	google.maps.event.addListener(marker3,'click',function() {	
	var infowindow = new google.maps.InfoWindow({
	content:"HD de Deido"
	});
	infowindow.open(map,marker3);
	});

	google.maps.event.addDomListener(window, 'load', initialize);
 
  }
