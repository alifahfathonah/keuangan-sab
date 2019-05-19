<table id="tableCatering" class="table table-striped table-bordered table-hover">
	<thead>
		<tr>
			<th class="center">No</th>
			<th>Nama Siswa</th>
			<th>Kelas</th>
			<th>Nama Catering</th>
			<th></th>
		</tr>
	</thead>

	<tbody>
	<?php
	$no=1;
	foreach ($d as $k => $v)
	{
		$kelas=$this->config->item('vbatchsiswa');
	?>
		<tr>
			<td style="text-align:center"><?=$no;?></td>
			<td style="text-align:left"><?=$v->nama_siswa;?></td>
			<td style="text-align:left"><?=(isset($kelas[$v->nis]) ? $kelas[$v->nis]->nama_batch : '')?></td>
			<td style="text-align:left"><?=(str_replace(',', ', ', $v->nama_catering));?></td>
			<td style="text-align:center">
				<a class="btn btn-info  btn-minier" href="#" onclick="edit(<?=$v->id?>)">
					<i class="fa fa-pencil"></i>
				</a>
				<button class="btn btn-danger btn-minier" type="button" onclick="hapus(<?=$v->id?>)">
					<i class="fa fa-trash"></i>)
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
				var oTable1 = $('#tableCatering').dataTable({
					bAutoWidth: false,
					"aoColumns": [
					  { "bSortable": false },
					  null, null,null,
					  { "bSortable": false }
					],
					"aaSorting": [],
					"iDisplayLength": 25
					//,
					//"sScrollY": "200px",
					//"bPaginate": false,

					//"sScrollX": "100%",
					//"sScrollXInner": "120%",
					//"bScrollCollapse": true,
					//Note: if you are applying horizontal scrolling (sScrollX) on a ".table-bordered"
					//you may want to wrap the table inside a "div.dataTables_borderWrap" element

					//"iDisplayLength": 50
			    } );
		});
</script>
