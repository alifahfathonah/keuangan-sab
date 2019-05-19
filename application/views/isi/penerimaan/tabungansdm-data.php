<table id="tablepotongan" class="table table-striped table-bordered table-hover" style="width:100%">
	<thead>
		<tr>
			<th class="center">No</th>
			<th>Nama SDM</th>
			<th>Jumlah Tabungan</th>
			<th>Update Terakhir</th>
			<!-- <th></th> -->
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
			if($id!=$v->id_guru)
				continue;
		}
		$nama=ucwords(strtolower($v->nama_guru));
	
		$lastupdate='';
		$tab='';
	
		if(isset($tabungan[$v->id_guru]))
		{

			if(count($tabungan[$v->id_guru])!=0)
			{
				foreach($tabungan[$v->id_guru] as $kkk => $vvv)
				{
					$tab.=$vvv->no_tabungan_rekening .' -- <a href="javascript:detailtabungan(\''.$v->id_guru.'\',\''.$vvv->no_tabungan_rekening.'\')">Rp. '.number_format($vvv->saldo,0,',','.').'</a>;';
					$lastupdate.=tgl_indo_time($vvv->last_update).',';
				}
				$tab=str_replace(';','<br>',substr($tab,0,-1));
				$lastupdate=str_replace(',','<br>',substr($lastupdate,0,-1));
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
			<td style="text-align:left"><a href="#" onclick=""><?php echo $nama; ?></a></td>
			<td style="text-align:right"><?php echo $tab; ?></td>
			<td style="text-align:center"><?php echo $lastupdate; ?></td>
			<!-- <td style="text-align:center">
				<a class="btn btn-info  btn-minier" href="#" onclick="edit(<?php echo $v->id_guru; ?>)">
					<i class="fa fa-pencil"></i>
				</a>

				<button class="btn btn-danger btn-minier" type="button" onclick="hapus(<?php echo $v->id_guru; ?>)">
					<i class="fa fa-trash"></i>
				</button>
			</td> -->
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
					  null, null,
					  { "bSortable": false }
					],
					"iDisplayLength": 25

			    } );
		});
</script>