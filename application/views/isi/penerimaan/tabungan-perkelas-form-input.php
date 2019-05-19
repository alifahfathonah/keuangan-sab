<table id="tablepotongan" class="table table-striped table-bordered table-hover">
	<thead>
		<tr>
			<th class="center">No</th>
			<th>Nama Siswa</th>
			<th>Kelas</th>
			<th>Jumlah Tabungan</th>
			<!-- <th>Update Terakhir</th> -->
			<!-- <th></th> -->
		</tr>
	</thead>

	<tbody>
	<?php
	$no=1;
		// echo '<pre>';
		// print_r($d);
		// echo '</pre>';
		$total=0;
	if(count($vbsbk)!=0)
	{
		foreach ($vbsbk as $k => $v) 
		{
			// if($id!=-1)
			// {
			// 	if($id!=$v->id)
			// 		continue;
			// }
			if(isset($vbs[$v->nis]))
			{
				
				$dSiswa=$vbs[$v->nis];
				if(isset($tabungan[$v->id]))
				{

					if(count($tabungan[$v->id])!=0)
					{
						$total+=$tabungan[$v->id][0]->saldo;
						$tab=number_format($tabungan[$v->id][0]->saldo,0,',','.');
						$lastupdate=tgl_indo_time($tabungan[$v->id][0]->last_update);
					}
					else
					{
						$tab=0;
						$total+=$tab;
						$lastupdate='';
					}
				}
				else
				{

						$lastupdate='';
						$tab=0;
						$total+=$tab;
				}
		?>
			<tr>
				<td style="text-align:center"><?=$no;?></td>
				<td style="text-align:left"><?=$v->nama_murid;?></td>
				<td style="text-align:left"><?=$dSiswa->nama_batch?></td>
				<td style="text-align:right">
					<input type="text" name="jumlah[<?=$v->id?>]" value="0" id="jumlah" style="text-align: right;height:25px !important;">
				</td>
				<!-- <td style="text-align:center"><?=$lastupdate?></td> -->
				<!-- <td style="text-align:center">
					<a class="btn btn-info  btn-minier" href="#" onclick="edit(<?=$v->id?>)">
						<i class="fa fa-pencil"></i>  	                                            
					</a>
					
					<button class="btn btn-danger btn-minier" type="button" onclick="hapus(<?=$v->id?>)">
						<i class="fa fa-trash"></i>
					</button>
				</td> -->
			</tr>
		<?php
			
			$no++;
			}
		}
	}
	?>
	</tbody>
	<thead>
		<tr>
			<th class="center" colspan="3">T O T A L</th>
			<th style="text-align:right;"><div id="total">0</div></th>
			<!-- <th>Update Terakhir</th> -->
			<!-- <th></th> -->
		</tr>
	</thead>
</table>
<style type="text/css">
	.table > tbody > tr > td
	{
		padding:3px 8px !important;
	}
</style>
<script type="text/javascript">

	$('input#jumlah').each(function(a){
		$(this).keyup(function(){
				// alert('a');
			$(this).formatCurrency({symbol:''});
			hitungnominal();
		});
	});

	function hitungnominal()
	{
		var total=0;
		$('input#jumlah').each(function(a)
		{
			var n=$(this).val();
			if(n=='')
				var nn=0;
			else
				var nn=n.replace(/,/g,'');
			// var t=(n);
			t=parseFloat(nn);
			total+=t; 
		});
		$('div#total').text(total);
		$('div#total').formatCurrency({symbol:''});
	} 
</script>