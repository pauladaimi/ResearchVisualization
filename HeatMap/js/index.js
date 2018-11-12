var sensorids=[];

var time=0;

var canvas=[];

var interval=[];

$(function () {
	//this would not work
	//d3.json("php/data.php").post(JSON.stringify({time: 100}) ,function(err,data){console.log(data);});
	console.log(time);
	initPlot();
	$.post("php/data.php", {"time": time}, initgraph);
	
	interval=setInterval(function (){
		time+=1;
		console.log(time);
		$.post("php/data.php", {"time": time}, graph);
		},1000);
	
});

function initPlot(){
	var Time=0;

        var xData=[];
        var yData=[];
        var i=0;
        var DataPerGraph=50;

        // Set the dimensions of the canvas / graph
var margin = {top: 30, right: 20, bottom: 30, left: 50},
    width = 600 - margin.left - margin.right,
    height = 270 - margin.top - margin.bottom;

    
// Adds the svg canvas
var svg = d3.select(".plot")
    .append("svg")
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom);

        var rect = svg.append("rect").attr("width", "100%").attr("height", "100%").attr("fill", "black");

        var g= svg.append("g")
        .attr("transform", 
              "translate(" + margin.left + "," + margin.top + ")");

        var result=[];
        $.post("Beirut2PHP.php",{ funcname:"func2"}, function(data){
        result=JSON.parse(data);

            });

        // Set the ranges
        var x = d3.time.scale().range([0, width]);
        var y = d3.scale.linear().range([height, 0]);

        // Define the axes
        var xAxis = d3.svg.axis().scale(x)
            .orient("bottom").ticks(10);

        var yAxis = d3.svg.axis().scale(y)
            .orient("left").ticks(15);

        // Add the X Axis
            g.append("g")
                .attr("class", "x axis")
                .attr("transform", "translate(0," + ((height/2)) + ")")
                .call(xAxis)
                .append("text")
                .attr("x", 500)
                .attr('y', -16)
                .attr("dy", "0.71em")
                .attr("fill", "#aaccff")
                .text('Time');

            // Add the Y Axis
            g.append("g")
                .attr("class", "y axis")
                .call(yAxis)
                .append("text")
                .attr("transform", "rotate(-90)")
                .attr("y", 6)
                .attr("dy", "0.71em")
                .attr("fill", "#aaccff")
                .text('AX');

        // Define the line
            var valueline = d3.svg.line()
                .interpolate("basis") 
                .x(function(x,y) { 
                    return x;})
                .y(function(x,y) { 
                    console.log(yData[y]);
                    return yData[y]; });

            // Add the valueline path.
            g.append("path")
                        .attr("class", "line")
                        .attr("d", valueline(xData,yData));

            d3.select(".plot").append("p").text("ID Number:");
            var selection=d3.select(".plot").append("Select").attr("class","Options");
            selection.on("change", function(){
                console.log("Hello")
                xData=[];
                yData=[];
                count=0;
            });

            d3.select(".plot").append("p").text("Type:");//Added
            var types=d3.select(".plot").append("Select").attr("class","Options");
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
            types.append('Option').text("Pressure").attr("value", "Pressure");

            types.on("change", function(){
                setTimeout(function(){ 
                    if(types.node().value == "Temperature"){
                        y.domain([-50, 50]);
                    }
                    else if(types.node().value == "AX"){
                         y.domain([-2, 2]);
                    }
                    else if(types.node().value == "AY"){
                         y.domain([-2, 2]);
                    }
                    else if(types.node().value == "AZ"){
                         y.domain([-2, 2]);
                    }
                    else if(types.node().value == "GX"){
                         y.domain([-250, 250]);
                    }
                    else if(types.node().value == "GY"){
                         y.domain([-250, 250]);
                    }
                    else if(types.node().value == "GZ"){
                         y.domain([-250, 250]);
                    }
                    else if(types.node().value == "MX"){
                         y.domain([-2500, 2500]);
                    }
                    else if(types.node().value == "MY"){
                         y.domain([-30000, 30000]);
                    }
                    else if(types.node().value == "MZ"){
                         y.domain([-25000, 25000]);
                    }

                xData=[];
                yData=[];
                count=0;
                }, 100);
            });

            var count=0;
            var IDs=[];
            var tempIDs=[];

        setInterval(function (){

            $.post("Beirut2PHP.php",{"fname": "func3", "ID": "1", "Time": ""+Time,"Type": ""}, function(data){
                IDs=JSON.parse(data);
            });

            IDs.sort();

            if(!arraysEqual(IDs,tempIDs)){
                for(var j=0; j<IDs.length; j++){
                    var opt= selection.append('Option').text(IDs[j]).attr("value", IDs[j]);
                }
            }
            
            tempIDs=IDs;

            //selection.data(IDs).enter().append('Option').text(function(d) { return d; });
            var selectedID = selection.node().value;
            var selectedType = types.node().value;
            $.post("Beirut2PHP.php",{ "fname": "func2", "ID": selectedID, "Time": ""+Time,"Type": selectedType}, function(data){
                try{
                    result=JSON.parse(data);
                }
                catch(err){
                    result=[];
                }
            });

            if(result[0]!=null){
                Time=result[0];

                if(DataPerGraph>count){
                xData.push(parseFloat(result[i]));
                yData.push(parseFloat(result[i+1]));
                count++;
            }
            else{
                xData.shift();
                yData.shift();
                xData.push(parseFloat(result[i]));
                yData.push(parseFloat(result[i+1]));
            }

            //i+=2;

            // Scale the range of the data
            x.domain([d3.min(xData),d3.max(xData)]);

             // Define the line
            var valueline = d3.svg.line()
                .interpolate("bundle") 
                .x(function(d,z) { 
                    return x(d);})
                .y(function(d,z) { 
                    return y(yData[z]); });

            // Add the valueline path.
            d3.select(".line").transition()   // change the line
            .attr("d", valueline(xData,yData));

            d3.select(".x.axis").transition() // change the x axis
            .call(xAxis);

            d3.select(".y.axis").transition() // change the y axis
            .call(yAxis);

            }


        }, 100);
}

function arraysEqual(arr1, arr2) {
    if(arr1.length !== arr2.length)
        return false;
    for(var i = arr1.length; i--;) {
        if(arr1[i] !== arr2[i])
            return false;
    }

    return true;
}

function resetGraph(){
    console.log("Hello")
    //xData=[];
    //yData=[];
    //count=0;
}

function initgraph(data)
{
  var margin = { top: 20, right: 50, bottom: 30, left: 50 },
      width = 800,
      height = 200;
	
	  
	data=JSON.parse(data);
	  
	var coloursYGB = ["#2c7bb6", "#00a6ca","#00ccbc","#90eb9d","#ffff8c","#f9d057","#f29e2e","#e76818","#d7191c"];
	var colourRangeYGB = d3.range(0, 100, 100.0 / (coloursYGB.length - 1));
	colourRangeYGB.push(100);
			   
	//Create color gradient
	var colorScaleYGB = d3.scaleLinear()
		.domain(colourRangeYGB)
		.range(coloursYGB)
		.interpolate(d3.interpolateHcl);
		
	// load sensor data

	// interpolate
	var barWidth = 10;
	var barHeight = 10;
	var heatmap=[width/barWidth*height/barHeight];
	for(var i=0; i<(height/barHeight); i++){
		for(var j=0; j<(width/barWidth); j++){
			// get distances
			
			var d=[data.length];
			var dtotal=0;
			for( var k=0; k<data.length; k++)
			{
				d[k]=Math.pow((i*barHeight*100/height+5)-data[k][4],2)+Math.pow((j*barWidth*100/width+5)-data[k][3],2);
				d[k]=1/(1+d[k]);
				dtotal+=d[k];
			}
			d.forEach(function(item, index, arr){arr[index]=item/dtotal;});
			
			heatmap[i+j*(height/barHeight)]=0; // reset to zero
			for( var k=0; k<data.length; k++)
			{
				heatmap[i+j*(height/barHeight)]+=d[k]*data[k][6];
			}
			heatmap[i+j*(height/barHeight)]={x: j, y: i, v: Math.round(100*heatmap[i+j*(height/barHeight)])};
			//heatmap[i+j*(height/barHeight)]={x: j, y: i, v: i+j};
		}
	}
	canvas = d3.select(".graph").append("svg").attr("width", width).attr("height", height).attr("transform", "translate(" + margin.left + "," + margin.top + ")").append("g");

	var bars = canvas.selectAll("rect").data(heatmap).enter().append("rect")
	.attr("x", function (d, i) {
	return d.x * barWidth;
	})
	.attr("y", function (d) {
	return d.y * barHeight;
	})
	.attr("height", barHeight).attr("width", barWidth).style('fill', function (d) {
	return colorScaleYGB(d.v);
	}) //CHANGE
	
	// add sensors
	for(var i=0; i<data.length; i++){
		canvas.append("circle").attr("cx",data[i][3]+'%').attr("cy",data[i][4]+'%').attr("r",15).style("fill","black").style("opacity","0.7").on("click",function(){console.log("circle clicked")})
	.on({"mouseover": function(d) {d3.select(this).style("cursor", "pointer");},"mouseout": function(d) {d3.select(this).style("cursor", "default"); }});
	}
	

	//LEGEND
	var legend = [0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100];
	var x_axis = 520;
	var y_axis = 50;

	var rectWidth = 30;

	var svgContainer = d3.select(".graph").append("svg").attr("width", rectWidth * legend.length + x_axis).attr("height", 200);

	var rect = svgContainer.selectAll(".rect").data(legend).enter().append("rect");
	var rectAttributes = rect.attr("x", function (d, i) {
	return x_axis + rectWidth * i;
	}).attr("y", function (d, i) {
	return y_axis;
	}).attr("width", rectWidth).attr("height", 20).style("fill", function (d) {
	return colorScaleYGB(d);
	});
	svgContainer.selectAll('.text').data(legend).enter().append('text').text(function (d) {
	return d.toString();
	}).attr("x", function (d, i) {
	return x_axis + rectWidth * i;
	}).attr("y", y_axis + 35);
}

function graph(data)
{
	var margin = { top: 20, right: 50, bottom: 30, left: 50 },
	width = 800,
	height = 200;
	
	console.log(data);	
	data=JSON.parse(data);
	  
	var coloursYGB = ["#2c7bb6", "#00a6ca","#00ccbc","#90eb9d","#ffff8c","#f9d057","#f29e2e","#e76818","#d7191c"];
	var colourRangeYGB = d3.range(0, 100, 100.0 / (coloursYGB.length - 1));
	colourRangeYGB.push(100);
			   
	//Create color gradient
	var colorScaleYGB = d3.scaleLinear()
		.domain(colourRangeYGB)
		.range(coloursYGB)
		.interpolate(d3.interpolateHcl);
		
	// load sensor data

	// interpolate
	var barWidth = 10;
	var barHeight = 10;
	var heatmap=[width/barWidth*height/barHeight];
	for(var i=0; i<(height/barHeight); i++){
		for(var j=0; j<(width/barWidth); j++){
			// get distances
			
			var d=[data.length];
			var dtotal=0;
			for( var k=0; k<data.length; k++)
			{
				d[k]=Math.pow((i*barHeight*100/height+5)-data[k][4],2)+Math.pow((j*barWidth*100/width+5)-data[k][3],2);
				d[k]=1/(1+d[k]);
				dtotal+=d[k];
			}
			d.forEach(function(item, index, arr){arr[index]=item/dtotal;});
			
			heatmap[i+j*(height/barHeight)]=0; // reset to zero
			for( var k=0; k<data.length; k++)
			{
				heatmap[i+j*(height/barHeight)]+=d[k]*data[k][6];
			}
			heatmap[i+j*(height/barHeight)]={x: j, y: i, v: Math.round(100*heatmap[i+j*(height/barHeight)])};
			//heatmap[i+j*(height/barHeight)]={x: j, y: i, v: i+j};
		}
	}
	
	canvas.selectAll("rect").data(heatmap).transition().duration(100).style('fill', function (d) {
	return colorScaleYGB(d.v);
	}) //CHANGE
}