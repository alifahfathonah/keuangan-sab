<table id="tableCatering" class="table table-striped table-bordered table-hover">
	<thead>
		<tr>
			<th class="center">No</th>
			<th>Nama Catering</th>
			<th>Penanggung Jawab</th>
			<th>Alamat</th>
			<th>Telp</th>
			<th>Email</th>
			<th>&nbsp;</th>
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
			<td style="text-align:left"><?=$v->nama_catering;?></td>
			<td style="text-align:left"><?=($v->penanggung_jawab);?></td>
			<td style="text-align:center"><?=($v->alamat)?></td>
			<td style="text-align:right"><?=($v->telp_pj);?></td>
			<td style="text-align:right"><?=($v->email_pj);?></td>
			<td style="text-align:center">
				<button class="btn btn-primary btn-minier" type="button" onclick="edit('<?=$v->id_catering?>')">
					<i class="fa fa-pencil"></i>
				</button>				
				<button class="btn btn-danger btn-minier" type="button" onclick="hapus('<?=$v->id_catering?>')">
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
				var oTable1 = $('#tableCatering').dataTable({
					bAutoWidth: false,
					"aoColumns": [
					  { "bSortable": false },
					  null, null,null,null,null,
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