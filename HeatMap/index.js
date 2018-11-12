var sensorids=[];

var time=0;

var canvas=[];

var interval=[];

$(function () {
	//this would not work
	//d3.json("php/data.php").post(JSON.stringify({time: 100}) ,function(err,data){console.log(data);});
	console.log(time);
	$.post("php/data.php", {"time": time}, initgraph);
	
	interval=setInterval(function (){
		time+=1;
		console.log(time);
		$.post("php/data.php", {"time": time}, graph);
		},1000);
	
});

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