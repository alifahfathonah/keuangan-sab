
<table id="tablepotongan" class="table table-striped table-bordered table-hover">
	<thead>
		<tr>
			<th class="center">No</th>
			<th>Nama Siswa</th>
			<th>Kelas</th>
			<th>Tahun Ajaran</th>
			<th>Potongan</th>
			<th>Jumlah</th>
			<th>Persen</th>
			<th>Keterangan</th>
			<th></th>
		</tr>
	</thead>

	<tbody>
	<?php
	$no=1;
	foreach ($d as $k => $v) 
	{
	?>
		<tr>
			<td style="text-align:center"><?=$no;?></td>
			<td style="text-align:left"><?=$v->nama_siswa?></td>
			<td style="text-align:left"><?=$v->nama_kelas?></td>
			<td style="text-align:left"><?=$v->tahun_ajaran?></td>
			<td style="text-align:left"><?=$v->jenis_potongan?></td>
			<td style="text-align:right"><?=number_format($v->biaya,0);?></td>
			<td style="text-align:right"><?=($v->persen.' %');?></td>
			<td style="text-align:left"><?=($v->keterangan);?></td>
			<td style="text-align:center;width:80px;">
				<a class="btn btn-info  btn-minier" href="#" onclick="edit(<?=$v->id?>)">
					<i class="fa fa-pencil"></i>  	                                            
				</a>
				<button class="btn btn-danger btn-minier" type="button" onclick="hapus(<?=$v->id?>)">
					<i class="fa fa-trash"></i>
				</button>
			</td>
		</tr>
	<?php
		$no++;
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
					  null, null,null,null,null,null,null,
					  { "bSortable": false }
					],
					"iDisplayLength": 25		
					
			    } );
		});
</script>