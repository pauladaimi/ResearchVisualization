<!DOCTYPE html>

<html>

<head>

    <meta charset="utf-8">

    <title>Crowd Management - Mecca</title>

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>


</head>

<head>

    <style>

        /* Always set the map height explicitly to define the size of the div

         * element that contains the map. */

        #map {

            height: 100%;

        }

        /* Optional: Makes the sample page fill the window. */

        html, body {

            height: 100%;

            margin: 0;

            padding: 0;

        }


    </style>

</head>



<body>



<!-- D3 ANIMATION STARTS HERE -->


<style> /* set the CSS */

.line {
  fill: none;
  stroke: steelblue;
  stroke-width: 1px;
}

.x.axis line{
  stroke: white;
}

.x.axis path{
  stroke: white;
  fill: none;
}

.x.axis text{
  fill: white;
  font-size: 11px;
}

.y.axis line{
  stroke: white;
}

.y.axis path{
  stroke: white;
  fill: none;
}

.y.axis tick{
  stroke: white;
  fill: white;
}

.y.axis text{
  fill: white;
  font-size: 11px;
}

.SelectedID {
        font-size: 20px;
    }

.IDNumber {
    font-style: bold;
    font-size: 20px;
    color: red;
    margin-left: 40px;
}

.Type{
    border-width: 2px;
	position: absolute;
	width: 300px;
	top: 44%;
	left: 23%;
    //margin-left: 200px;
    //margin-top: 0px;

}

.Type p{
	width: 100px;
    font-size: 20px;
}

        
.Type select {
   background: transparent;
   height: 34px;
   width: 150px;
   padding: 5px;
   font-size: 16px;
   color: grey;
   line-height: 1;
   border: 0;
   border-radius: 0;
   -webkit-appearance: none;
   overflow: hidden;
//   background: url(new_arrow.jpg) no-repeat right #ddd;
   border: 1px solid #ccc;
}

.HeatMap{
    margin-left: 200px;

}

</style>

<style>

    html, body {

        padding: 0;

        margin: 0;

        width: 100%;

        height: 100%;

        overflow: hidden;

        position: relative;

        background: white;

    }



    body > div {

        position: absolute;

        overflow: hidden;

    }



    #map {

        left: 50%;

        top: 0;

        z-index: 0;

        width: 50%;

        height: 50%;

    }



    #map svg {

        width: 50%;

        height: 50%;

    }



    #map .feature {

        fill : #2C2C43;

        stroke : #4A4A70;

    }



    #c {

        left: 0;

        top: 0;

        z-index: 1;

    }



    #s {

        left: 0;

        top: 0;

        z-index: 2;

    }



    .gtLeg, .gttLeg {

        fill : #f9f9f9;

        text-shadow: 0 1px 2px rgba(0, 0, 0, .5);

    }



    .com-mess {

        font-size: 11pt;

        font-family: Verdana,serif;

        fill: #ffffff;

        fill-opacity: .3;

    }



    #pb {

        left: 0;

        bottom: 0;

        position: fixed;

        z-index: 100;

        height: auto;

        font-size: 10px;

        text-shadow: 0 1px 2px rgba(0, 0, 0, .8);

    }



    #menu {

        top: 2px;

        left: 2px;

        z-index: 50;

        position: fixed;

    }



    #info {

        right: 2px;

        top: 2px;

        z-index: 51;

        position: fixed;

    }



    ul {

        padding: 0;

        margin: 0;

        list-style: none;

        background: rgba(69, 91, 115, .6);

        border: 1px solid rgba(147, 168, 190, .8);

        color: rgba(147, 168, 190, 1);

        text-shadow: 0 1px 2px rgba(0, 0, 0, .8);

        border-radius: 5px;

        overflow: hidden;

        vertical-align: middle;

    }



    li {

        margin: 0;

        padding: 4px 2px;

        margin-right: 2px;

        overflow: hidden;

        vertical-align: middle;

        display: inline-block;

    }



    img {

        display: inline-block;

    }



    li:last-child {

        margin-right: 0;

    }



    .btn {

        cursor: pointer;

        -moz-box-shadow:inset 0 1px 0 0 #ffffff;

        -webkit-box-shadow:inset 0 1px 0 0 #ffffff;

        box-shadow:inset 0 1px 0 0 #ffffff;

        background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #f9f9f9), color-stop(1, #e9e9e9) );

        background:-moz-linear-gradient( center top, #f9f9f9 5%, #e9e9e9 100% );

        filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#f9f9f9', endColorstr='#e9e9e9');

        background-color:#f9f9f9;

        -moz-border-radius:5px;

        -webkit-border-radius:5px;

        border-radius:5px;

        border:1px solid #dcdcdc;

        display:inline-block;

        color:#738eab;

        font-family: 'Times New Roman' serif;

        font-size: 14px;

        font-weight:normal;

        padding: 4px 8px;

        text-decoration:none;

        text-shadow:0 1px 1px #ffffff;

    }

    .btn:hover {

        background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #e9e9e9), color-stop(1, #f9f9f9) );

        background:-moz-linear-gradient( center top, #e9e9e9 5%, #f9f9f9 100% );

        filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#e9e9e9', endColorstr='#f9f9f9');

        background-color:#e9e9e9;

    }

    .btn:active {

        background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #DCDCDC), color-stop(1, #f9f9f9) );

        background:-moz-linear-gradient( center top, #DCDCDC 5%, #f9f9f9 100% );

        filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#DCDCDC', endColorstr='#f9f9f9');

        background-color:#e9e9e9;

        position:relative;

        /*top:1px;*/

        color: #587493;

        text-shadow:0 -1px 1px #ffffff;

    }

    /* This imageless css button was generated by CSSButtonGenerator.com */



    .tooltip {

        padding: .5em;

        background: rgba(88, 116, 147, .8);

        color: rgba(179, 193, 209, 1);

        text-shadow: 0 1px 2px rgba(0, 0, 0, .8);

        border: 1px solid #eee;

        line-height: 1.5em;

        box-shadow: 0 0 8px rgba(0, 0, 0, .5);

        z-index: 999;

        font-family: serif;

        font-size: 11px;

    }



    #info li {

        border: 0;

        border-right: 1px dotted rgba(115, 142, 171, 1);

        padding-right: 5px;

        cursor: pointer;

    }

    #info li ul {

        display: none;

        border-radius: 0;

        background: rgba(244, 244, 244, .6);

        border: 1px dotted rgba(75, 75, 0, .8);

        color: #f9f9f9;

        text-shadow: 0 2px 2px rgba(0, 0, 0, .8);

    }



    #info li li {

        display: block;

        border: 0;

        padding-right: 2px;

    }



    #info li:last-child {

        border: 0;

    }



    #info li:hover ul {

        display: block;

    }

</style>

<script src="http://d3js.org/d3.v3.min.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

<script>

</script>


<!-- Added by Omar Droubi -->

<!-- GOOGLE MAPS STARTS HERE -->



<script src='https://code.jquery.com/jquery-3.1.0.min.js'></script>

<div id="map"></div>

<script type="text/javascript" src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>

<script> 
    var markers;
    var markerCluster;
	var locations;
	
	//$.ajaxSetup({async:false});

    function makeInfoBox(controlDiv, map) {

        // Set CSS for the control border.

        var controlUI = document.createElement('div');

        controlUI.style.boxShadow = 'rgba(0, 0, 0, 0.298039) 0px 1px 4px -1px';

        controlUI.style.backgroundColor = '#fff';

        controlUI.style.border = '2px solid #fff';

        controlUI.style.borderRadius = '2px';

        controlUI.style.marginBottom = '22px';

        controlUI.style.marginTop = '10px';

        controlUI.style.textAlign = 'center';

        controlDiv.appendChild(controlUI);



        // Set CSS for the control interior.

        var controlText = document.createElement('div');

        controlText.style.color = 'rgb(25,25,25)';

        controlText.style.fontFamily = 'Roboto,Arial,sans-serif';

        controlText.style.fontSize = '100%';

        controlText.style.padding = '6px';

        controlText.textContent = 'Beirut - Crowd Management 2017';

        controlUI.appendChild(controlText);

    }


    function initMap() {

        map = new google.maps.Map(document.getElementById('map'), {

            zoom: 18,

            center: {lat: 21.4225, lng: 39.8262 },

            mapTypeId: 'satellite',

            styles: [

                {

                    "elementType": "geometry",

                    "stylers": [

                        {

                            "color": "#1d2c4d"

                        }

                    ]

                },

                {

                    "elementType": "labels.text.fill",

                    "stylers": [

                        {

                            "color": "#8ec3b9"

                        }

                    ]

                },

                {

                    "elementType": "labels.text.stroke",

                    "stylers": [

                        {

                            "color": "#1a3646"

                        }

                    ]

                },

                {

                    "featureType": "administrative.country",

                    "elementType": "geometry.stroke",

                    "stylers": [

                        {

                            "color": "#4b6878"

                        }

                    ]

                },

                {

                    "featureType": "administrative.land_parcel",

                    "elementType": "labels.text.fill",

                    "stylers": [

                        {

                            "color": "#64779e"

                        }

                    ]

                },

                {

                    "featureType": "administrative.province",

                    "elementType": "geometry.stroke",

                    "stylers": [

                        {

                            "color": "#4b6878"

                        }

                    ]

                },

                {

                    "featureType": "landscape.man_made",

                    "elementType": "geometry.stroke",

                    "stylers": [

                        {

                            "color": "#334e87"

                        }

                    ]

                },

                {

                    "featureType": "landscape.natural",

                    "elementType": "geometry",

                    "stylers": [

                        {

                            "color": "#023e58"

                        }

                    ]

                },

                {

                    "featureType": "poi",

                    "elementType": "geometry",

                    "stylers": [

                        {

                            "color": "#283d6a"

                        }

                    ]

                },

                {

                    "featureType": "poi",

                    "elementType": "labels.text.fill",

                    "stylers": [

                        {

                            "color": "#6f9ba5"

                        }

                    ]

                },

                {

                    "featureType": "poi",

                    "elementType": "labels.text.stroke",

                    "stylers": [

                        {

                            "color": "#1d2c4d"

                        }

                    ]

                },

                {

                    "featureType": "poi.park",

                    "elementType": "geometry.fill",

                    "stylers": [

                        {

                            "color": "#023e58"

                        }

                    ]

                },

                {

                    "featureType": "poi.park",

                    "elementType": "labels.text.fill",

                    "stylers": [

                        {

                            "color": "#3C7680"

                        }

                    ]

                },

                {

                    "featureType": "road",

                    "elementType": "geometry",

                    "stylers": [

                        {

                            "color": "#304a7d"

                        }

                    ]

                },

                {

                    "featureType": "road",

                    "elementType": "labels.text.fill",

                    "stylers": [

                        {

                            "color": "#98a5be"

                        }

                    ]

                },

                {

                    "featureType": "road",

                    "elementType": "labels.text.stroke",

                    "stylers": [

                        {

                            "color": "#1d2c4d"

                        }

                    ]

                },

                {

                    "featureType": "road.highway",

                    "elementType": "geometry",

                    "stylers": [

                        {

                            "color": "#2c6675"

                        }

                    ]

                },

                {

                    "featureType": "road.highway",

                    "elementType": "geometry.stroke",

                    "stylers": [

                        {

                            "color": "#255763"

                        }

                    ]

                },

                {

                    "featureType": "road.highway",

                    "elementType": "labels.text.fill",

                    "stylers": [

                        {

                            "color": "#b0d5ce"

                        }

                    ]

                },

                {

                    "featureType": "road.highway",

                    "elementType": "labels.text.stroke",

                    "stylers": [

                        {

                            "color": "#023e58"

                        }

                    ]

                },

                {

                    "featureType": "transit",

                    "elementType": "labels.text.fill",

                    "stylers": [

                        {

                            "color": "#98a5be"

                        }

                    ]

                },

                {

                    "featureType": "transit",

                    "elementType": "labels.text.stroke",

                    "stylers": [

                        {

                            "color": "#1d2c4d"

                        }

                    ]

                },

                {

                    "featureType": "transit.line",

                    "elementType": "geometry.fill",

                    "stylers": [

                        {

                            "color": "#283d6a"

                        }

                    ]

                },

                {

                    "featureType": "transit.station",

                    "elementType": "geometry",

                    "stylers": [

                        {

                            "color": "#3a4762"

                        }

                    ]

                },

                {

                    "featureType": "water",

                    "elementType": "geometry",

                    "stylers": [

                        {

                            "color": "#0e1626"

                        }

                    ]

                },

                {

                    "featureType": "water",

                    "elementType": "labels.text.fill",

                    "stylers": [

                        {

                            "color": "#4e6d70"

                        }

                    ]

                }

            ]

        });







        // Create the DIV to hold the control and call the makeInfoBox() constructor

        // passing in this DIV.

        var infoBoxDiv = document.createElement('div');

        makeInfoBox(infoBoxDiv, map);

        map.controls[google.maps.ControlPosition.TOP_CENTER].push(infoBoxDiv);
        

        // Create an array of alphabetical characters used to label the markers.

        /* var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'; */
		
        /*markers = locations.map(function(location, i) {
            return new google.maps.Marker({ position: location, label: labels[i % labels.length]});
        });*/

    }

    ////////////////////////////////////////////////////// Added By Paul for Graph and Map visualizations and interactions (Starts here) ////////////////////////////////////////////////////////////////////////

    function arraysEqual(arr1, arr2) {
    if(arr1.length !== arr2.length)
        return false;
    for(var i = arr1.length; i--;) {
        if(arr1[i] !== arr2[i])
            return false;
    }

    return true;
}


    // Added random locations
$(document).ready(function()
{
    locations = [{lat: 21.323151, lng: 39.825524}, {lat: 33.8938, lng: 35.5018}, {lat: 33.8938, lng: 35.5018}, {lat: 33.8938, lng: 35.5018}]
    var result = [];
    
    // Add a marker clusterer to manage the markers.
	markerCluster = new MarkerClusterer(map, markers,
	{imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});

    var selectedID=1;
    var counter=0;
    var count =0;
	var offset =0;
	var lasttime=0;
    var ids = [];
    var markerss ={};
    var colors ={};
    var circles = [];
    var markerscluster = [];
        ///////////////////////////////////////////////////////////AX vs Time starts Here////////////////////////////////////////////////////
    var Time=0;

    var xData=[];
    var yData=[];
    var TimeInit=false;
    var PlotTime=40; // seconds
    var startingTime=0;

    
	// Adds the svg canvas
	// Adds the svg canvas
	var svg = d3.select("body")
		.append("svg")
		.attr("width", "50%")
		.attr("height", "50%");
		

	// Set the dimensions of the canvas / graph
	var margin = {top: 30, right: 50, bottom: 50, left: 50},
		width = parseInt(svg.style('width'),10) - margin.left - margin.right,
		height = parseInt(svg.style('height'),10) - margin.top - margin.bottom;
		
	// Set the ranges
	var x = d3.scale.linear().range([0,width]);
	var y = d3.scale.linear().range([height, 0]);
	y.domain([-2, 2]);

	// Define the axes
	var xAxis = d3.svg.axis().scale(x)
		.orient("bottom").ticks(10);

	var yAxis = d3.svg.axis().scale(y)
		.orient("left").ticks(15);

	var rect = svg.append("rect").attr("width", "100%").attr("height", "100%").attr("fill", "black"); //Added

	var g= svg.append("g")
	.attr("transform", 
		  "translate(" + margin.left + "," + margin.top + ")");// Added
			

	// Add the X Axis
	g.append("g")//Modified
		.attr("class", "x axis")
		.attr("transform", "translate(0," + ((height/2)) + ")")
		.call(xAxis)
		.append("text")
		.attr("x", 600)
		.attr('y', -16)
		.attr("dy", "0.71em")
		.attr("fill", "#aaccff")
		.text('Time');


	// Add the Y Axis
	g.append("g")//Modified
		.attr("class", "y axis")
		.call(yAxis)
		.append("text")
		.attr("class","yVar")
		.attr("x",10)
		.attr("y", 0)
		.attr("dy", "0.71em")
		.attr("fill", "#aaccff")
		.text('AX (g)');

	svg.append("text").text("Selected ID:").attr("class","SelectedID").attr("fill", "white").attr('x',"5%").attr('y', "95%")/*.append('text').text('1').attr("class","IDNumber")*/;
	svg.append('text').text('1').attr("class","IDNumber").attr('y', "95%").attr('x', "25%").attr("fill", "white");

	// Define the line
	var valueline = d3.svg.line()
		.interpolate("basis") 
		.x(function(x,y) { 
			return x;})
		.y(function(x,y) { 
			console.log(yData[y]);
			return yData[y]; });

            // Add the valueline path.
            g.append("path")//Modified
                        .attr("class", "line")
                        .attr("d", valueline(xData,yData));

            /*var selection=d3.select("body").append("Select").attr("class","Options");
            selection.on("change", function(){
                console.log("Hello")
                xData=[];
                yData=[];
                ct=0;
            });*/
            var yVar = d3.select(".yVar");
			svg.append('text').text('Type:').attr("class","SelectedID").attr('y', "95%").attr('x', "35%").attr("fill", "white");
            var TypeDiv = d3.select("body").append("div").attr("class","Type");
            var types=TypeDiv.append("Select").attr("class","Options");
            types.append('Option').text("AX").attr("value", "AX");
            types.append('Option').text("AY").attr("value", "AY");
            types.append('Option').text("AZ").attr("value", "AZ");
            types.append('Option').text("GX").attr("value", "GX");
            types.append('Option').text("GY").attr("value", "GY");
            types.append('Option').text("GZ").attr("value", "GZ");
            types.append('Option').text("MX").attr("value", "MX");
            types.append('Option').text("MY").attr("value", "MY");
            types.append('Option').text("MZ").attr("value", "MZ");
            types.append('Option').text("Temperature").attr("value", "Temperature");
            types.append('Option').text("Heartrate").attr("value", "Pressure");

            types.on("change", function(){
                setTimeout(function(){ 
                    if(types.node().value == "Temperature"){
                        y.domain([-50, 50]);
                        yVar.text('Temperature').attr("x","-30");
                    }
                    else if(types.node().value == "AX"){
                         y.domain([-2, 2]);
                         yVar.text('AX (g)');
                    }
                    else if(types.node().value == "AY"){
                         y.domain([-2, 2]);
                         yVar.text('AY (g)');
                    }
                    else if(types.node().value == "AZ"){
                         y.domain([-2, 2]);
                         yVar.text('AZ (g)');
                    }
                    else if(types.node().value == "GX"){
                         y.domain([-250, 250]);
                         yVar.text('GX (deg/s)');
                    }
                    else if(types.node().value == "GY"){
                         y.domain([-250, 250]);
                         yVar.text('GY (deg/s)');
                    }
                    else if(types.node().value == "GZ"){
                         y.domain([-250, 250]);
                         yVar.text('GZ (deg/s)');
                    }
                    else if(types.node().value == "MX"){
                         y.domain([-1000, 1000]);
                         yVar.text('MX (mGauss)');
                    }
                    else if(types.node().value == "MY"){
                         y.domain([-1000, 1000]);
                         yVar.text('MY (mGauss)');
                    }
                    else if(types.node().value == "MZ"){
                         y.domain([-1000, 1000]);
                         yVar.text('MZ (mGauss)');
                    }
                    else if(types.node().value == "Pressure"){
                         y.domain([0, 200]);
                         yVar.text('Heartrate (BPS)');
                    }


                xData=[];
                yData=[];
                ct=0;
                }, 100);
            });

            var ct=0;
            var IDs=[];
			
			var previousID=1;
			setInterval(function (){
				
				//console.log(Time);
				var selectedType = types.node().value;
				
				$.post("Beirut2PHP.php",{ "funcname": "func1", "Type": selectedType, "Offset": ""+offset }, function(data){
					try{
						result=JSON.parse(data);
					}
					catch(err){
						result=[];
					}
				});

				/*
		setInterval(function (){

			//selection.data(IDs).enter().append('Option').text(function(d) { return d; });
			//var selectedID = selection.node().value;
			var selectedType = types.node().value;
			$.post("Beirut2PHP.php",{ "funcname": "func2", "ID": selectedID, "Time": ""+Time, "Type": selectedType, "LastTime": ""+lasttime }, function(data){
				try{
					resultSet=JSON.parse(data);
				}
				catch(err){
					resultSet=[];
				}
			});*/
			
				if(result.length!=0)
				{
					if(result[0]==selectedID)
					{
						if(TimeInit==false)
						{
							TimeInit=true;
							startingTime=result[1];
							console.log(startingTime);
						}
						xData.push(parseFloat(result[1]-startingTime));
						yData.push(parseFloat(result[4]));
						
						while(d3.max(xData)-d3.min(xData)>PlotTime)
						{
							xData.shift();
							yData.shift();
						}


						// Scale the range of the data
						x.domain([d3.min(xData),d3.min(xData)+PlotTime]);

						 // Define the line
						var valueline = d3.svg.line()
							.x(function(d,z) { 
								return x(d);})
							.y(function(d,z) { 
								return y(yData[z]); });

						// Add the valueline path.
						d3.select(".line")   // change the line
						.attr("d", valueline(xData,yData));

						d3.select(".x.axis").transition() // change the x axis
						.call(xAxis);

						d3.select(".y.axis").transition() // change the y axis
						.call(yAxis);
					}
				}
				
        ///////////////////////////////////////////////////AX vs Time Ends Here  ///////////////////////////////////////////////////////


				if(map.getZoom() < 19){
					markerCluster.addMarkers(markerscluster);
				}

				var cityCircle

				if(result.length!=0)
				{
					
					offset++;
					
					var id=result[0];
					var myLatLng = new google.maps.LatLng(result[2], result[3]);
					locations.push(myLatLng);

					if(ids.includes(id))
					{
						markerss[id].setPosition(myLatLng);
						if(map.getZoom() < 19)
						{
							//markerCluster.resetViewport();

							cityCircle = new google.maps.Circle({
							strokeColor: colors[id],
							strokeOpacity: 0,
							strokeWeight: 2,
							fillColor: colors[id],
							fillOpacity: 0,
							map: map,
							center: myLatLng,
							radius: 1
						});

							if(counter<40){
								circles.push(cityCircle);
								counter++;
								
							}
							else{
								circles.shift().setMap(null);;
								circles.push(cityCircle);
							}
						}
						else{

								cityCircle = new google.maps.Circle({
								strokeColor: colors[id],
								strokeOpacity: 0.9,
								strokeWeight: 2,
								fillColor: colors[id],
								fillOpacity: 0.8,
								map: map,
								center: myLatLng,
								radius: 1
								});

							if(counter<40){
								circles.push(cityCircle);
								counter++;
								
							}
							else{
								circles.shift().setMap(null);;
								circles.push(cityCircle);
							}

						}
						 

					}

					else{
						ids.push(id);

						var markerHighlighted = {
							labelOrigin: new google.maps.Point(10,12),
							url: 'highlighted_Marker2.png',
							origin: new google.maps.Point(0, 0),
						};

						var markerNormal = {
							labelOrigin: new google.maps.Point(10,12),
							url: 'Marker_Normal.png',
							origin: new google.maps.Point(0, 0),
						};

						var Marker = new google.maps.Marker({

							position: myLatLng,

							icon:markerNormal,

							label: {
													text: id,
													fontSize: "16px",
													fontWeight: "bold"
													},

							map:map

						});


						google.maps.event.addListener(Marker, 'click', function () {
						// Marker Clicking Listener
							markerss[previousID].setIcon(markerNormal);
							previousID=id;
							xData=[];
							yData=[];
							ct=0;
							selectedID=id;
							d3.select(".IDNumber").text(id);
							Marker.setIcon(markerHighlighted);
							
						});

						markerss[id]=Marker;
						markerscluster.push(Marker);
						colors[id]=getRandomColor();
					}
					}

        }, 10);
        //Bridge Start Here
        d3.select("body").append("img").attr("src","Heatmap_Sample.png").attr("class","HeatMap").style("visibility","hidden");

        var bridgeLocation = new google.maps.LatLng(21.423, 39.827);
        /*var BridgeMarker = new google.maps.Circle({
                        strokeColor: "red",
                        strokeOpacity: 0.9,
                        strokeWeight: 2,
                        fillColor: "red",
                        fillOpacity: 0.8,
                        map: map,
                        center: bridgeLocation,
                        radius: 4,
                    });*/
        var bridgeIconNormal = {
                    //labelOrigin: new google.maps.Point(10,12),
                    url: 'bridge.png'
                    //origin: new google.maps.Point(0, 0),
                };
        var bridgeIconHovered = {
                    //labelOrigin: new google.maps.Point(10,12),
                    url: 'bridge_hovered.png'
                    //origin: new google.maps.Point(0, 0),
                };

        var BridgeMarker = new google.maps.Marker({
                    position: bridgeLocation,
                    icon:bridgeIconNormal,
                    map:map

                });
				
		var Person1Marker = new google.maps.Marker({
				position: new google.maps.LatLng(21.4232, 39.8271),
				map:map,
				label: { text: "1"}
			});
			
		var Person2Marker = new google.maps.Marker({
				position: new google.maps.LatLng(21.4231, 39.8272),
				map:map,
				label: { text: "2"}
			});

        google.maps.event.addListener(BridgeMarker, 'mouseover', function () {
                    BridgeMarker.setIcon(bridgeIconHovered);
                });
        google.maps.event.addListener(BridgeMarker, 'mouseout', function () {
                    BridgeMarker.setIcon(bridgeIconNormal);
                });

        google.maps.event.addListener(BridgeMarker, 'click', function () {
                // Marker Clicking Listener
                    d3.select(".HeatMap").style("visibility","visible")
                });

        //Bridge Ends Here

        google.maps.event.addListener(map, 'zoom_changed', function() {
        if(map.getZoom() < 19){
            markerCluster.addMarkers(markerscluster);
                for(i=0; i<circles.length; i++){
                    circles[i].setOptions({fillOpacity:0, strokeOpacity:0});
                }

            }
            else{
                markerCluster.clearMarkers();
                for(i=0; i<markerscluster.length; i++){
                    markerscluster[i].setMap(map);
                }
               for(i=0; i<circles.length; i++){
                    circles[i].setOptions({fillOpacity:0.8, strokeOpacity:0.9});
                }
                
            }
    });
        setInterval(function (){
            markerCluster.resetViewport();
        },700);
    });

    function getRandomColor() {
  var letters = '0123456789ABCDEF';
  var color = '#';
  for (var i = 0; i < 6; i++) {
    color += letters[Math.floor(Math.random() * 16)];
  }
  return color;
}

    ////////////////////////////////////////////////////// Added By Paul for Graph and Map visualizations and interactions (Ends here) ////////////////////////////////////////////////////////////////////////

</script>

<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js">

</script>

<script async defer

src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBKbjRrU7DHlPRUJK_2nS8TBpAS2mMdYU0&libraries=visualization&callback=initMap">

</script>


<!-- Added by Omar Droubi -->

<!-- Interactive Circle Starts here -->



<meta charset="utf-8">

<style>



circle,

path {

  cursor: pointer;

}



circle {

  fill: none;

  pointer-events: all;

}



</style>





<script src="//d3js.org/d3.v3.min.js"></script>

<script>



var margin = {top: 350, right: 480, bottom: 350, left: 480},

    radius = Math.min(margin.top, margin.right, margin.bottom, margin.left) - 10;



var hue = d3.scale.category10();



var luminance = d3.scale.sqrt()

    .domain([0, 1e6])

    .clamp(true)

    .range([90, 20]);



var svg = d3.select("svg").append("svg")

  .append("g")



var partition = d3.layout.partition()

    .sort(function(a, b) { return d3.ascending(a.name, b.name); })

    .size([2 * Math.PI, radius]);



var arc = d3.svg.arc()

    .startAngle(function(d) { return d.x; })

    .endAngle(function(d) { return d.x + d.dx ; })

    .padAngle(.01)

    .padRadius(radius / 3)

    .innerRadius(function(d) { return radius / 3 * d.depth; })

    .outerRadius(function(d) { return radius / 3 * (d.depth + 1) - 1; });


/*
d3.json("flare.json", function(error, root) {

  if (error) throw error;



  // Compute the initial layout on the entire tree to sum sizes.

  // Also compute the full name and fill color for each node,

  // and stash the children so they can be restored as we descend.

  partition

      .value(function(d) { return d.size; })

      .nodes(root)

      .forEach(function(d) {

        d._children = d.children;

        d.sum = d.value;

        d.key = key(d);

        d.fill = fill(d);

      });



  // Now redefine the value function to use the previously-computed sum.

  partition

      .children(function(d, depth) { return depth < 2 ? d._children : null; })

      .value(function(d) { return d.sum; });



  var center = svg.append("circle")

      .on("click", zoomOut);



  center.append("title")

      .text("zoom out");



  var path = svg.selectAll("path")

      .data(partition.nodes(root).slice(1))

    .enter().append("path")

      .attr("d", arc)

      .style("fill", function(d) { return d.fill; })

      .each(function(d) { this._current = updateArc(d); })

      .on("click", zoomIn);



  function zoomIn(p) {

    if (p.depth > 1) p = p.parent;

    if (!p.children) return;

    zoom(p, p);

  }



  function zoomOut(p) {

    if (!p.parent) return;

    zoom(p.parent, p);

  }



  // Zoom to the specified new root.

  function zoom(root, p) {

    if (document.documentElement.__transition__) return;



    // Rescale outside angles to match the new layout.

    var enterArc,

        exitArc,

        outsideAngle = d3.scale.linear().domain([0, 2 * Math.PI]);



    function insideArc(d) {

      return p.key > d.key

          ? {depth: d.depth - 1, x: 0, dx: 0} : p.key < d.key

          ? {depth: d.depth - 1, x: 2 * Math.PI, dx: 0}

          : {depth: 0, x: 0, dx: 2 * Math.PI};

    }



    function outsideArc(d) {

      return {depth: d.depth + 1, x: outsideAngle(d.x), dx: outsideAngle(d.x + d.dx) - outsideAngle(d.x)};

    }



    center.datum(root);



    // When zooming in, arcs enter from the outside and exit to the inside.

    // Entering outside arcs start from the old layout.

    if (root === p) enterArc = outsideArc, exitArc = insideArc, outsideAngle.range([p.x, p.x + p.dx]);



    path = path.data(partition.nodes(root).slice(1), function(d) { return d.key; });



    // When zooming out, arcs enter from the inside and exit to the outside.

    // Exiting outside arcs transition to the new layout.

    if (root !== p) enterArc = insideArc, exitArc = outsideArc, outsideAngle.range([p.x, p.x + p.dx]);



    d3.transition().duration(d3.event.altKey ? 7500 : 750).each(function() {

      path.exit().transition()

          .style("fill-opacity", function(d) { return d.depth === 1 + (root === p) ? 1 : 0; })

          .attrTween("d", function(d) { return arcTween.call(this, exitArc(d)); })

          .remove();



      path.enter().append("path")

          .style("fill-opacity", function(d) { return d.depth === 2 - (root === p) ? 1 : 0; })

          .style("fill", function(d) { return d.fill; })

          .on("click", zoomIn)

          .each(function(d) { this._current = enterArc(d); });



      path.transition()

          .style("fill-opacity", 1)

          .attrTween("d", function(d) { return arcTween.call(this, updateArc(d)); });

    });

  }

}); */



function key(d) {

  var k = [], p = d;

  while (p.depth) k.push(p.name), p = p.parent;

  return k.reverse().join(".");

}



function fill(d) {

  var p = d;

  while (p.depth > 1) p = p.parent;

  var c = d3.lab(hue(p.name));

  c.l = luminance(d.sum);

  return c;

}



function arcTween(b) {

  var i = d3.interpolate(this._current, b);

  this._current = i(0);

  return function(t) {

    return arc(i(t));

  };

}



function updateArc(d) {

  return {depth: d.depth, x: d.x, dx: d.dx};

}



d3.select(self.frameElement).style("height", margin.top + margin.bottom + "px");



</script>













</body>

</html>