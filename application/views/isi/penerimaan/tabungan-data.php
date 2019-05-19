<table id="tablepotongan" class="table table-striped table-bordered table-hover">
	<thead>
		<tr>
			<th class="center">No</th>
			<th>Nama Siswa</th>
			<th>Kelas</th>
			<th>Jumlah Tabungan</th>
			<th>Update Terakhir</th>
			<th></th>
		</tr>
	</thead>

	<tbody>
	<?php
	$no=1;
		// echo '<pre>';
		// print_r($d);
		// echo '</pre>';
	foreach ($d as $k => $v)
	{
		if($id!=-1)
		{
			if($id!=$v->id)
				continue;
		}
		$nama=ucwords(strtolower($v->nama_murid));
		if(isset($vbs[$v->nis]))
		{

			$dSiswa=$vbs[$v->nis];
			$kelas=$dSiswa->nama_batch;

		}
		else {
			$kelas='';
			$lastupdate='';
			$tab=0;
		}

		if(isset($tabungan[$v->id]))
		{

			if(count($tabungan[$v->id])!=0)
			{
				$tab=number_format($tabungan[$v->id][0]->saldo,0,',','.');
				$lastupdate=tgl_indo_time($tabungan[$v->id][0]->last_update);
			}
			else
			{
				$tab=0;
				$lastupdate='';
			}
		}
		else
		{

				$lastupdate='';
				$tab=0;
		}
	?>
		<tr>
			<td style="text-align:center"><?php echo $no;; ?></td>
			<td style="text-align:left"><a href="#" onclick="javascript:detailtabungan('<?php echo $v->id; ?>')"><?php echo $nama; ?></a></td>
			<td style="text-align:left"><?php echo $kelas; ?></td>
			<td style="text-align:right"><?php echo $tab; ?></td>
			<td style="text-align:center"><?php echo $lastupdate; ?></td>
			<td style="text-align:center">
				<a class="btn btn-success  btn-minier" target="_blank" href="<?=site_url()?>penerimaan/tabunganexcel/<?=$v->id?>">
					<i class="fa fa-file-excel-o"></i>&nbsp;Download Xls
				</a>

				<!-- <button class="btn btn-danger btn-minier" type="button" onclick="hapus(<?php echo $v->id; ?>)">
					<i class="fa fa-trash"></i>
				</button> -->
			</td>
		</tr>
	<?php
		$no++;
		// }
	}
	?>
	</tbody>
</table>
<script type="text/javascript">
	jQuery(function($) {
				var oTable1 = $('#tablepotongan').dataTable({
					bAutoWidth: false,
					"aoColumns": [
					  { "bSortable": false },
					  null, null,null,
					  { "bSortable": false },
					  null
					],
					"iDisplayLength": 25

			    } );
		});
</script>