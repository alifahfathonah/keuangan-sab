<!DOCTYPE html>
<html>
<head>
	<title>Grafik Stok Barang</title>
</head>
<body>

	<!-- <div class="container">
    <div>
        <canvas id="myChart" width="400" height="400"></canvas>  
    </div>
    </div> -->
    <?php
    $d=array();
    foreach($data as $kd => $vd)
    {
        $jenis[]=$kd;
        $jlh[]=$vd;
    }
    // echo json_encode($jlh);
    // echo $tgl;
    ?>
<h2><?=str_replace('%20','',$title)?></h2>
  <table id="customers">
  <tr>
    <th>No </th>
    <th>Jenis Penerimaan</th>
    <th>Jumlah</th>
  </tr>
  <?php
  $no=1;
  $jumlah=0;
  foreach($data as $k => $v)
  {
    echo '<tr>
            <td style="text-align:center">'.$no.'</td>
            <td>'.$k.'</td>
            <td style="text-align:right">'.number_format($v,0,',','.').'</td>
        </tr>';
    $jumlah+=$v;
    $no++;
  }
  ?>
<tr>
    <th colspan="2">Total Penerimaan</th>
    <th style="text-align:right"><?=number_format($jumlah,0,',','.')?></th>
  </tr>
    </table>
	<!--Load chart js-->
	<!-- <script type="text/javascript" src="<?php echo base_url().'assets/chartjs/chartjs.js';?>"></script>
	<script>

            var ctx = document.getElementById("myChart");
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($jenis);?>,
                    datasets: [{
                        label: '',
                        data : <?php echo json_encode($jlh);?>,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                        ],
                        borderColor: [
                            'rgba(255,99,132,1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)',
                            'rgba(255, 206, 86, 1)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    title: {
                        display: true,
                        text: '<?=$title?>'
                    },
                    responsive:true,
                maintainAspectRatio: false,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }]
                    }
                }
            });
        
   	</script> -->
</body>
</html>
<style>
    canvas{
  
  width:100% !important;
  height:380px !important;

}

#customers {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

#customers td, #customers th {
    border: 1px solid #ddd;
    padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #4CAF50;
    color: white;
}
</style>