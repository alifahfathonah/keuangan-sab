<table id="tablepotongan" class="table table-striped table-bordered table-hover">
	<thead>
	<?php
	if($id=='all')
	{
	?>
		<tr>
			<th class="center">No</th>
			<th>Kelas</th>
			<th>Jumlah Tabungan</th>
			<th></th>
		</tr>
	<?php
	}
	else
	{	
	?>
		<tr>
			<th class="center">No</th>
			<th>Nama Siswa</th>
			<th>Kelas</th>
			<th>Jumlah Tabungan</th>
			<th>Update Terakhir</th>
			<!-- <th></th> -->
		</tr>
	<?php
	}
	?>
	</thead>

	<tbody>
	<?php
	if($id=='all')
	{
		$no=1;
		$total=0;
		foreach($vbsbk as $k=>$v)
		{
			if(count($jlh)!=0)
			{
				$jumlah=$jlh[$v->id_batch];
			}
			else
				$jumlah=0;
	?>
		<tr>
			<td style="text-align:center"><?=$no;?></td>
			<td style="text-align:left"><?=$v->nama_batch?></td>
			<td style="text-align:right"><?=number_format($jumlah,0,',','.');?></td>
			<td style="text-align:center">
				<!-- <a class="btn btn-success  btn-minier" target="_blank" href="<?=site_url()?>penerimaan/tabunganperkelasexcel/<?=$v->id_batch?>">
					<i class="fa fa-file-excel-o"></i>&nbsp;Download Xls
				</a> -->
			</td>
		</tr>
	<?php
		$total+=$jumlah;
		$no++;
		}
	?>
		<tr>
				<th class="center" colspan="2">T O T A L</th>
				<th style="text-align:right;"><?=number_format($total,0,',','.')?></th>
				<th>&nbsp;</th>
			</tr>
	<?php
	}
	else
	{
			
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
					<td style="text-align:left"><a href="#" onclick="javascript:detailtabungan('<?=$v->id?>')"><?=ucwords(strtolower($v->nama_murid));?></a></td>
					<td style="text-align:left"><?=$dSiswa->nama_batch?></td>
					<td style="text-align:right"><?=$tab?></td>
					<td style="text-align:center"><?=$lastupdate?></td>
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
				<th style="text-align:right;"><?=number_format($total,0,',','.')?></th>
				<th>Update Terakhir</th>
				<!-- <th></th> -->
			</tr>
		
		</thead>
	<?php
	}
	?>
</table>
<?php
// echo '<pre>';
// print_r($tabungan);
// echo '</pre>';
?><script type="text/javascript">
	jQuery(function($) {
		var id='<?php echo $id;?>';
		if(id=='all')
		{
			var oTable1 = $('#tablepotongan').dataTable({
					bAutoWidth: false,
					"aoColumns": [
					  { "bSortable": false },
					  null
					],
					"iDisplayLength": 25

			    } );
		}
		else
		{

				var oTable1 = $('#tablepotongan').dataTable({
					bAutoWidth: false,
					"aoColumns": [
					  { "bSortable": false },
					  null, null,null,
					  { "bSortable": false }
					],
					"iDisplayLength": 25

			    } );
		}
		});
</script>
