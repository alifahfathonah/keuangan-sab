<table id="tableJemputan" class="table table-striped table-bordered table-hover">
	<thead>
		<tr>
			<th class="center">No</th>
			<th>Nama Siswa</th>
			<th>Nama Driver</th>
			<th>Jarak Rumah</th>
			<th>Jemputan Club</th>
			<th>Status Jemputan</th>
			<th></th>
		</tr>
	</thead>

	<tbody>
	<?php
	$no=1;
	foreach ($d->result() as $k => $v) 
	{
	?>
		<tr>
			<td style="text-align:center"><?=$no;?></td>
			<td style="text-align:left"><?=$v->nama_siswa;?></td>
			<td style="text-align:left"><?=($v->nama_driver);?></td>
			<td style="text-align:center"><?=number_format($v->jarak);?> meter</td>
			<td style="text-align:center"><?=($v->jemputan_club=='t' ? 'Ikut' : 'Tidak Ikut');?></td>
			<td style="text-align:center"><?=(ucwords($v->status));?></td>
			<td style="text-align:center">
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
				var oTable1 = $('#tableJemputan').dataTable({
					bAutoWidth: false,
					"aoColumns": [
					  { "bSortable": false },
					  null, null,null,null,null,
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