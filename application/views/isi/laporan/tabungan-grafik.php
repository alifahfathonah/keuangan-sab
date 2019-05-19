<div id="container_<?=$waktu?>" style="width:800px; height: 300px; margin: 0 auto"></div>
					
<script type="text/javascript">
	$('#container_<?=$waktu?>').highcharts({
	        chart: {
	            type: 'column'
	        },
	        title: {
	            text: '<?=$penerimaan?> : <?=($date)?>'
	        },
	        colors: [<?=$color?>],
	        xAxis: {
	            type: 'category',
	            labels: {
	                rotation: -45,
	                style: {
	                    fontSize: '11px',
	                    fontFamily: 'Verdana, sans-serif'
	                }
	            }
	        },
	        yAxis: {
	            min: 0,
	            title: {
	                text: 'Rupiah'
	            }
	        },
	        legend: {
	            enabled: false
	        },
	        tooltip: {
	            pointFormat: 'Jumlah : <b>{point.y}</b>'
	        },
	        series: [{
	            name: 'Penerimaan',
	            data: [<?=$g?>],
		        type: 'column',
		        colorByPoint: true,
	            dataLabels: {
	                enabled: true,
	                rotation: 0,
	                color: '#000',
	                align: 'center',
	                x: 4,
	                y: -10,
	                style: {
	                    fontSize: '11px',
	                    fontFamily: 'Verdana, sans-serif',
	                }
	            }
	        }]
	    });
</script>