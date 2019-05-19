<form action="<?=site_url()?>penerimaan/hapusdataclub" method="post" id="hapusdataclub">
<table id="tableClub" class="table table-striped table-bordered table-hover">
	<thead>
		<tr>
			<th class="center">No</th>
			<th class="center">Pilih Semua<br><input type="checkbox" id="pilihsemua"></th>
			<th>Nama Siswa</th>
			<th>Nama Club</th>
			<th>Jadwal</th>
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
			<td style="text-align:center"><input type="checkbox" name="hapusdata[<?=$v->id?>]" id="hapus" class="hapus_<?=$no?>"></td>
			<td style="text-align:left"><?=$v->nama_siswa;?></td>
			<td style="text-align:left"><?=(str_replace(',', ', ', $v->nama_club));?></td>
			<td style="text-align:right"></td>
			<td style="text-align:center">
				<a class="btn btn-info  btn-minier" href="#" onclick="edit(<?=$v->id?>)">
					<i class="fa fa-pencil"></i>  	                                            
				</a>
				<a class="btn btn-danger btn-minier" href="javascript:hapus(<?=$v->id?>)">
					<i class="fa fa-trash"></i>
				</a>
			</td>
		</tr>
	<?php
		$no++;
	}
	?>
	</tbody>
</table>
</form>
<!-- <link ref="stylesheet" href="<?=base_url()?>assets/css/datatable.css">
<link ref="stylesheet" href="<?=base_url()?>assets/css/datatable-select.css">
<link ref="stylesheet" href="<?=base_url()?>assets/css/datatable-button.css">
<script src="<?=base_url()?>assets/js/datatable.js"></script>
<script src="<?=base_url()?>assets/js/datatable-select.js"></script>
<script src="<?=base_url()?>assets/js/datatable-button.js"></script> -->
<script type="text/javascript">
	jQuery(function($) {
		$('#hapus_data').hide();
		$('#hapus_data').click(function(){
			var c=confirm('Yakin Ingin Menghapus Data Club Siswa ini ?');
			if(c)
			{
				$('form#hapusdataclub').submit();
			}
		});
		$('#hapus_semua').click(function(){
			var c=confirm('Yakin Ingin Menghapus Semua Data Club Siswa ini ?');
			if(c)
			{
				$('form#hapusdataclub').submit();
			}
		});
	// 	var table = $('#tableClub').dataTable( {
    //     dom: 'Bfrtip',
    //     select: true,
    //     buttons: [
    //         {
    //             text: 'Select all',
    //             action: function () {
    //                 table.rows().select();
    //             }
    //         },
    //         {
    //             text: 'Select none',
    //             action: function () {
    //                 table.rows().deselect();
    //             }
    //         }
    //     ]
    // } );
		$('#pilihsemua').click(function(){
			$('input:checkbox').not(this).prop('checked', this.checked);
			if(this.checked)
			{
				$('#hapus_semua').hide();
				$('#hapus_data').show();
			}
			else
			{
				$('#hapus_data').hide();
				$('#hapus_semua').show();

			}
		});
				var oTable1 = $('#tableClub').DataTable({
					
					bAutoWidth: false,
					"aoColumns": [
					  { "bSortable": false },
					  null, null,null,null,
					  { "bSortable": false }
					],
					"aaSorting": [],	
					"iDisplayLength": 25,
					"buttons": [
						'selectAll',
						'selectNone'
					]
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