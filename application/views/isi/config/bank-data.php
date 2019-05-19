<table id="tableBank" class="table table-striped table-bordered table-hover">
	<thead>
		<tr>
			<th class="center">No</th>
			<th>Nama Bank</th>
			<th>No Rekening</th>
			<th>Nama Rekening</th>
			<th>Kode Akun</th>
			<th>Saldo</th>
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
			<td style="text-align:left"><?=$v->nama_bank;?></td>
			<td style="text-align:left"><?=($v->no_rekening);?></td>
			<td style="text-align:center"><?=$v->nama_rekening?></td>
			<td style="text-align:center"><?=$v->kode_akun?></td>
			<td style="text-align:right"><?=number_format($v->saldo,0,',','.')?></td>
			<td style="text-align:center">
				<button class="btn btn-primary btn-minier" type="button" onclick="edit('<?=$v->id_bank?>')">
					<i class="fa fa-pencil"></i>
				</button>				
				<button class="btn btn-danger btn-minier" type="button" onclick="hapus('<?=$v->id_bank?>')">
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
				var oTable1 = $('#tableBank').dataTable({
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