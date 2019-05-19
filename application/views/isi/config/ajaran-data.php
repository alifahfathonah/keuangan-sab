<table id="tableAjaran" class="table table-striped table-bordered table-hover">
	<thead>
		<tr>
			<th class="center">No</th>
			<th>Tahun Ajaran</th>
			<th>Awal Tahun Ajaran</th>
			<th>Akhir Tahun Ajaran</th>
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
			<td style="text-align:left"><?=$v->tahun_ajaran;?></td>
			<td style="text-align:left"><?=($v->bulan_awal)?></td>
			<td style="text-align:center"><?=$v->bulan_akhir?></td>
			<td style="text-align:center">
				<button class="btn btn-primary btn-minier" type="button" onclick="edit('<?=$v->id_ajaran?>')">
					<i class="fa fa-pencil"></i>
				</button>				
				<button class="btn btn-danger btn-minier" type="button" onclick="hapus('<?=$v->id_ajaran?>')">
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
				var oTable1 = $('#tableAjaran').dataTable({
					bAutoWidth: false,
					"aoColumns": [
					  { "bSortable": false },
					  null, null,null,
					  { "bSortable": false }
					],
					"aaSorting": [],			
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