<html>
	<head>
	<title> Test Page for JS embedded in PHP</title>



		<?php
			function get_UTC_data($number,$year,$month,$day,$hour,$Data) {
				for($i = 0; $i < ($number-1); $i++) {
					$xAxisSeries = sprintf("[Date.UTC(%s,%s,%s,%s),%s]",$year[$i],$month[$i]-1,$day[$i],$hour[$i],$Data[$i]);
						$UTCstring =$UTCstring .  $xAxisSeries;
					if($i != ($number - 2)) {
						$UTCstring = $UTCstring . ",";
					}
					$xAxisString = NULL;
				}
				return $UTCstring;
			}
			$file = file_get_contents("Orono_forecast.txt")  or die("Couldn't open $file");
			$rows = explode("\n",$file);

			// Getting rid of the initial 8 lines that do not have the data
			// including the line with the labels
			array_shift($rows);
			array_shift($rows);
			array_shift($rows);
			array_shift($rows);
			array_shift($rows);
			array_shift($rows);
			array_shift($rows);
			
			// Initializing arrays to hold parsed data
			$yearData = array();
			$monthData = array();
			$dayData = array();
			$hourData = array();
			$temperatureData = array();
			$PrecipRateData = array();
			$dateData = array();
			$lineNo = 0;
			$Hours = array();
			$CloudData = array();
			$PressureData = array();
			$HumidityData = array();
			$WindSpeedData = array();
			$PrecipWaterData = array();
			$xAxisSeries = NULL;
			$UTCstring = NULL;
	
			foreach($rows as $val){
				$data = explode(" ",$val); 					
				$yearData[$lineNo] = strval($data[1]);
				$monthData[$lineNo] = strval($data[2]);
				$dayData[$lineNo] = strval($data[3]);
				$hourData[$lineNo] = strval($data[4]);
				$dateData[$lineNo] = strval($data[2]) . "/" .strval($data[3]);
				$temperatureData[$lineNo] = $data[5];
				$HumidityData[$lineNo] = $data[7];
				$PrecipRateData[$lineNo] = $data[9];
				$PrecipWaterData[$lineNo] = $data[8];
				$CloudData[$lineNo] = $data[10];

				$PressureData[$lineNo]=$data[12];
				$WindSpeedData[$lineNo] = $data[15];
				$lineNo++;
			}
			unset($PrecipWaterData[$lineNo - 1]);
			unset($PrecipRateData[$lineNo - 1]);
			unset($hourData[$lineNo - 1]);
			unset($temperatureData[$lineNo - 1]);
			unset($dateData[$lineNo - 1]);
			unset($yearData[$lineNo - 1]);
			unset($monthData[$lineNo - 1]);
			unset($dayData[$lineNo - 1]);
			unset($CloudData[$lineNo - 1]);
			unset($PressureData[$lineNo - 1]);
			unset($HumidityData[$lineNo - 1]);
			unset($WindSpeedData[$lineNo - 1]);
			
			$Humidity = array_map('floatval',$HumidityData);
			$Pressure = array_map('floatval',$PressureData);
			$Precipitation = array_map('floatval',$PrecipRateData);
			$Hours = $hourData;
			$Temperature = array_map('floatval',$temperatureData);
			$monthData = array_map('floatval',$monthData);
			$WindSpeed = array_map('floatval',$WindSpeedData);
			$PrecipWater = array_map('floatval',$PrecipWaterData);
			$CloudCover = array_map('floatval',$CloudData);
			$UTC_humidity = get_UTC_data($lineNo,$yearData,$monthData,$dayData,$hourData,$Humidity);
			$UTC_cloud = get_UTC_data($lineNo,$yearData,$monthData,$dayData,$hourData,$CloudCover);
			$UTC_temperature = get_UTC_data($lineNo,$yearData,$monthData,$dayData,$hourData,$Temperature);
			$UTC_precipRate = get_UTC_data($lineNo,$yearData,$monthData,$dayData,$hourData,$Precipitation);
			$UTC_pressure = get_UTC_data($lineNo,$yearData,$monthData,$dayData,$hourData,$Pressure);
			$UTC_windspeed = get_UTC_data($lineNo,$yearData,$monthData,$dayData,$hourData,$WindSpeed);
			$UTC_precipWater = get_UTC_data($lineNo,$yearData,$monthData,$dayData,$hourData,$PrecipWater);
		?>
	

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Highcharts Example</title>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<script src="js/highcharts.js" type="text/javascript"></script>
	<script src="js/exporting.js"></script>
	<script type="text/javascript">
	
	var chart1,chart2,chart3,chart4,chart5,chart6;
	
	$(document).ready(function() {
	
        function syncronizeCrossHairs(chart) {
            var container = $(chart.container),
            offset = container.offset(),
            x, y, isInside, report;

            container.mousemove(function(evt) {

				x = evt.clientX - chart.plotLeft - offset.left;
				y = evt.clientY - chart.plotTop - offset.top;
				var xAxis = chart.xAxis[0];
				//remove old plot line and draw new plot line (crosshair) for this chart
				var xAxis1 = chart1.xAxis[0];
				xAxis1.removePlotLine("myPlotLineId");
				xAxis1.addPlotLine({
					value: chart.xAxis[0].translate(x, true),
					width: 1,
					color: 'blue',
					//dashStyle: 'dash',                   
					id: "myPlotLineId"
				});
				//remove old crosshair and draw new crosshair on chart2
				var xAxis2 = chart2.xAxis[0];
				xAxis2.removePlotLine("myPlotLineId");
				xAxis2.addPlotLine({
					value: chart.xAxis[0].translate(x, true),
					width: 1,
					color: 'blue',
					//dashStyle: 'dash',                   
					id: "myPlotLineId"
				});

				var xAxis3 = chart3.xAxis[0];
				xAxis3.removePlotLine("myPlotLineId");
				xAxis3.addPlotLine({
					value: chart.xAxis[0].translate(x, true),
					width: 1,
					color: 'blue',
					//dashStyle: 'dash',                   
					id: "myPlotLineId"
				});

				var xAxis4 = chart4.xAxis[0];
				xAxis4.removePlotLine("myPlotLineId");
				xAxis4.addPlotLine({
					value: chart.xAxis[0].translate(x, true),
					width: 1,
					color: 'blue',
					//dashStyle: 'dash',                   
					id: "myPlotLineId"
				});

				var xAxis5 = chart5.xAxis[0];
				xAxis5.removePlotLine("myPlotLineId");
				xAxis5.addPlotLine({
					value: chart.xAxis[0].translate(x, true),
					width: 1,
					color: 'blue',
					//dashStyle: 'dash',                   
					id: "myPlotLineId"
				});
				var xAxis6 = chart6.xAxis[0];
				xAxis6.removePlotLine("myPlotLineId");
				xAxis6.addPlotLine({
					value: chart.xAxis[0].translate(x, true),
					width: 1,
					color: 'blue',
					//dashStyle: 'dash',                   
					id: "myPlotLineId"
				});
                //if you have other charts that need to be syncronized - update their crosshair (plot line) in the same way in this function.                   
			});
		}
	
		
		
			chart1 = new Highcharts.Chart({
			 chart: {
                        renderTo: 'containerTemperature',
                        type: 'line',
                        zoomType: 'x',
                        //x axis only                      
                        //'#022455',                       
                        isZoomed:false
                    },
				colors: ['#996633'],
				credits:{
					enabled: false
				},
			    title: {
				text: 'Temperature (°C)',
				x: -20 //center
			    },
			    subtitle: {
				text: 'Source: ',
				x: -20
			    },
			    xAxis: {    
				type: 'datetime',
				minTickInterval: 24 * 3600 * 1000,
				gridLineWidth: 1,
				dateTimeLabelFormats: {
					month:'%e. %b',
					year: '%b'
				}
			    },
			    yAxis: {
				title: {
				    text: ''
				},
				plotLines: [{
				    value: 100,
				    width: 1,
				    color: '#660000'
				}]
			    },
			    tooltip: {
				formatter: function() {
					return '<b>'+ this.series.name +'</b><br/>'+
					Highcharts.dateFormat('%e/%b/%HH', this.x) +'  '+'<b>'+ this.y +  ' °C'+'</b>';
				}
			    },
			    legend: {
				layout: 'vertical',
				align: 'right',
				verticalAlign: 'middle',
				borderWidth: 0
			    },
			    series: [{
				name: 'Orono',
				data:
				[
				 <?php echo $UTC_temperature;?>
				]
			    }]
			},function(chart) {
				syncronizeCrossHairs(chart);
			});
			
			
			
			
			chart2 = new Highcharts.Chart({
				chart: {
                        renderTo: 'containerPrecipWater',
                        type: 'line',
                        zoomType: 'x',
                        //x axis only                    
                        //'#022455',                      
                        isZoomed:false
                    },
			    colors: ['#FF9900'],
				credits:{
					enabled: false
				},
			    title: {
				text: 'Precipitable Water (kg m-2)',
				x: -20 //center
			    },
			    subtitle: {
				text: 'Source: ',
				x: -20
			    },
			    xAxis: {
				type: 'datetime',
				minTickInterval: 24 * 3600 * 1000,
				gridLineWidth: 1,
				dateTimeLabelFormats: {
					month:'%e. %b',
					year: '%b'
				}
				//categories:<?php echo json_encode($Hours);?> 
				    
			    },
			    yAxis: {
				min:0,
				title: {
				    text: ''
				},
				min:0,
				plotLines: [{
				    value: 100,
				    width: 1,
				    color: '#808080'
				}]
				
			    },
			    tooltip: {
				formatter: function() {
					return '<b>'+ this.series.name +'</b><br/>'+
					Highcharts.dateFormat('%e/%b/%HH', this.x) +'  '+'<b>'+ this.y +'kg m-2'+'</b>';
				}
			    },
			    legend: {
				layout: 'vertical',
				align: 'right',
				verticalAlign: 'middle',
				borderWidth: 0
			    },
			    series: [{
				name: 'Orono',
				data:
				[
					<?php echo $UTC_precipWater;?>
				] 
 				
			    }]
			},function(chart) {
				syncronizeCrossHairs(chart);
			});
		    
			
		    
		
		
			

		
		chart3 = new Highcharts.Chart({
			chart: {
                        	renderTo: 'containerPressure',
                        	type: 'line',
                        	zoomType: 'x',
                        	//x axis only                    
                        	//'#022455',                      
                        	isZoomed:false
                   	 },
				colors:['#669900'],
				credits:{
					enabled: false
				},
			    title: {
				text: 'Mean Sea Level Pressure (mb)',
				x: -20 //center
			    },
			    subtitle: {
				text: 'Source: ',
				x: -20
			    },
			    xAxis: {    
				type: 'datetime',
				minTickInterval: 24 * 3600 * 1000,
				gridLineWidth: 1,
				dateTimeLabelFormats: {
					month:'%e. %b',
					year: '%b'
				}
			    },
			    yAxis: {
				min:980,
				max:1075,
				title: {
				    text: ''
				},
				plotLines: [{
				    value: 100,
				    width: 1,
				    color: '#808080'
				}]
			    },
			    tooltip: {
				formatter: function() {
					return '<b>'+ this.series.name +'</b><br/>'+
					Highcharts.dateFormat('%e/%b/%HHR', this.x) +'  '+'<b>'+ this.y +'mb'+'</b>';
				}
			    },
			    legend: {
				layout: 'vertical',
				align: 'right',
				verticalAlign: 'middle',
				borderWidth: 0
			    },
			    series: [{
				name: 'Orono',
				data:
				[
				 <?php echo $UTC_pressure;?>
				]
			    }]
		},function(chart) {
				syncronizeCrossHairs(chart);
			});
			
		

			
		//$(function () {
		//	$('#containerWindspeed').highcharts({

		chart4 = new Highcharts.Chart({
			chart: {
                        	renderTo: 'containerWindspeed',
                        	type: 'line',
                        	zoomType: 'x',
                        	//x axis only                    
                        	//'#022455',                      
                        	isZoomed:false
                   	 },
				colors: ['#0099FF'],
				credits:{
					enabled: false
				},
			    title: {
				text: 'Wind Speed (m/s)',
				x: -20 //center
			    },
			    subtitle: {
				text: 'Source: ',
				x: -20
			    },
			    xAxis: {
				type: 'datetime',
				minTickInterval: 24 * 3600 * 1000,
				gridLineWidth: 1,
				dateTimeLabelFormats: {
					month:'%e. %b',
					year: '%b'
				}
			    },
			    yAxis: {
				title: {
				    text: ''
				},
				plotLines: [{
				    value: 100,
				    width: 1,
				    color: '#808080'
				}]
			    },
			    tooltip: {
				formatter: function() {
					return '<b>'+ this.series.name +'</b><br/>'+
					Highcharts.dateFormat('%e/%b/%HH', this.x) +'  '+'<b>'+ this.y +'m/s'+'</b>';
				}
			    },
			    legend: {
				layout: 'vertical',
				align: 'right',
				verticalAlign: 'middle',
				borderWidth: 0
			    },
			    series: [{
				name: 'Orono',
				data:
				[
				 <?php echo $UTC_windspeed;?>
				]
			    }]
			},function(chart) {
				syncronizeCrossHairs(chart);
			});
		   
			
			
			
		//	$(function () {
		//	$('#containerCloud').highcharts({
		chart5 = new Highcharts.Chart({
			chart: {
                        	renderTo: 'containerCloud',
                        	type: 'line',
                        	zoomType: 'x',
                        	//x axis only                    
                        	//'#022455',                      
                        	isZoomed:false
                   	 },
				colors: ['#990033'],
				credits:{
					enabled: false
				},
			    title: {
				text: 'Cloud Cover (%)',
				x: -20 //center
			    },
			    subtitle: {
				text: 'Source: ',
				x: -20
			    },
			    xAxis: {
				type: 'datetime',
				minTickInterval: 24 * 3600 * 1000,
				gridLineWidth: 1,
				dateTimeLabelFormats: {
					month:'%e. %b',
					year: '%b'
				}
			    },
			    yAxis: {
				min: 0,
				max:100,
				title: {
				    text: ''
				},
				plotLines: [{
				    value: 100,
				    width: 1,
				    color: '#808080'
				}]
			    },
			    tooltip: {
				formatter: function() {
					return '<b>'+ this.series.name +'</b><br/>'+
					Highcharts.dateFormat('%e/%b/%HH', this.x) +'  '+'<b>'+ this.y +'%'+'</b>';
				}
			    },
			    legend: {
				layout: 'vertical',
				align: 'right',
				verticalAlign: 'middle',
				borderWidth: 0
			    },
			    series: [{
				name: 'Orono',
				data:
				[
				 <?php echo $UTC_cloud;?>
				]
			    }]
			},function(chart) {
				syncronizeCrossHairs(chart);
			});
		    
			
			//$(function () {
			//$('#containerPrecip').highcharts({
		chart6 = new Highcharts.Chart({
			chart: {
                        	renderTo: 'containerPrecip',
                        	type: 'line',
                        	zoomType: 'x',
                        	//x axis only                    
                        	//'#022455',                      
                        	isZoomed:false
                   	 },
				colors: ['#FF00FF'],
				credits:{
					enabled: false
				},
			    title: {
				text: 'Precipitation Rate (kg m-2 s-1)',
				x: -20 //center
			    },
			    subtitle: {
				text: 'Source: ',
				x: -20
			    },
			    xAxis: {
				type: 'datetime',
				minTickInterval: 24 * 3600 * 1000,
				gridLineWidth: 1,
				dateTimeLabelFormats: {
					month:'%e. %b',
					year: '%b'
				}
			    },
			    yAxis: {
				min:0,
				title: {
				    text: ''
				},
				plotLines: [{
				    value: 100,
				    width: 1,
				    color: '#808080'
				}]
			    },
			    tooltip: {
				formatter: function() {
					return '<b>'+ this.series.name +'</b><br/>'+
					Highcharts.dateFormat('%e/%b/%HH', this.x) +'  '+'<b>'+ this.y +'kg m-2 s-1'+'</b>';
				}
			    },
			    legend: {
				layout: 'vertical',
				align: 'right',
				verticalAlign: 'middle',
				borderWidth: 0
			    },
			    series: [{
				name: 'Orono',
				data:
				[
				 <?php echo $UTC_precipRate;?>
				]
			    }]
			},function(chart) {
				syncronizeCrossHairs(chart);
			});
		   // });
		//	});
		    
		});
		</script>

	
	
	</head>
	<body>
		<script src="./js/highcharts.js"></script>
		<script src="./js/exporting.js"></script>	
		
		<div id="containermain" style="min-width: 564px; height: 1030px; margin: 0 auto">
		<div id="containerTemperature" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
		<div id="containerPrecipWater" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
		<div id="containerPressure" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
		<div id="containerWindspeed" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
		<div id="containerPrecip" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
		<div id="containerCloud" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
	<!--	<div id="containerHumidity" style="min-width: 310px; height: 400px; margin: 0 auto"></div> -->	
		</div>
	</body>
</html>


