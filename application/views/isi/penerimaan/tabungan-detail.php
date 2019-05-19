<table id="detailtabungan" class="table table-striped table-bordered table-hover">
	<thead>
		<tr>
			<th class="center">No</th>
			<th>Nama Siswa</th>
			<th>Tanggal</th>
			<!-- <th>Kelas</th> -->
			<th>Jenis</th>
			<th>Jumlah</th>
			<th>Keterangan</th>
			<th></th>
		</tr>
	</thead>

	<tbody>
	<?php
	$no=1;
	$jumlah=0;
	foreach ($tabungan as $k => $v)
	{
		if(isset($vbs[$d->nis]))
		{
			$dSiswa=$vbs[$d->nis];
			$namabatch=$dSiswa->nama_batch;
		}
		else
			$namabatch='';
	?>
		<tr>
			<td style="text-align:center"><?=$no;?></td>
			<td style="text-align:left"><?=$d->nama_murid;?></td>
			<td style="text-align:center"><?=tgl_indo2($v->tanggal)?></td>
			<!-- <td style="text-align:left"><?=$namabatch?></td> -->
			<td style="text-align:center"><?=$v->jenis;?></td>
			<?php
			if($v->jenis=='Tarik')
			{
			?>
				<td style="text-align:right;">(<i><?=number_format($v->jumlah,0,',','.');?></i>)</td>

			<?php
			}
			else
			{
			?>
				<td style="text-align:right;"><?=number_format($v->jumlah,0,',','.');?></td>
			<?php
			}
			?>
			<td style="text-align:center"><?=$v->keterangan;?></td>
			<td style="text-align:center">
				<a class="btn btn-info  btn-minier" href="#" onclick="editdetail(<?=$v->id_det?>,<?=$d->id?>)">
					<i class="fa fa-pencil"></i>
				</a>
				<button class="btn btn-danger btn-minier" type="button" onclick="hapusdetail(<?=$v->id_det?>,<?=$d->id?>)">
					<i class="fa fa-trash"></i>
				</button>
			</td>
		</tr>
	<?php
		$jlh=(strtolower($v->jenis)=='tarik' ? (0-$v->jumlah) : $v->jumlah);
		$jumlah+=$jlh;
		$no++;
	}
	?>
	</tbody>
	<thead>
		<tr>

			<th class="center" colspan="5">J U M L A H</th>
			<th style="text-align: right"><?=number_format($jumlah,0,',','.');?></th>
			<th></th>
		</tr>
	</thead>
</table>
<script type="text/javascript">
	jQuery(function($) {
				var oTable1 = $('#detailtabungan').dataTable({
					bAutoWidth: false,
					"aoColumns": [
					  null,null, null,null, null,null,
					  { "bSortable": false }
					],
					"iDisplayLength": 10

			    } );
		});

	function editdetail(id,siswa_id)
	{
		// oTable1.destroy();
		$.ajax({
			url : '<?=site_url()?>penerimaan/tabunganform/'+id,
			success : function(a)
			{
				bootbox.confirm(a, function(result) {
					if(result)
					{
						$.ajax({
							url : '<?=site_url()?>penerimaan/tabunganproses/'+id,
							type : 'POST',
							data : $('#edittabungan').serialize(),
							success : function(a)
							{
								// alert(a);
								//$('#bootbox-body').load('<?=site_url()?>penerimaan/tabungandetail/1');
								// detailtabungan(1);
								bootbox.hideAll();
								tampilpesan(a);
								// $('#detailtabungan').dataTable().fnClearTable();
								// $('#detailtabungan').dataTable().ajax.reload();
								$('#data').load('<?=site_url()?>penerimaan/tabungandata/'+siswa_id);


							}
						});
						//edittabungan
					}
				});
			}
		});
	}
	function hapusdetail(id,siswa_id)
	{
			bootbox.confirm("<h3>Yakin Ingin Menghapus Data Tabungan ini ?? </h3>", function(result) {
					if(result)
					{
						$.ajax({
							url : '<?=site_url()?>penerimaan/tabunganhapus/'+id+'/'+siswa_id,
							success : function(a)
							{
								bootbox.hideAll();
								tampilpesan(a);
								$('#data').load('<?=site_url()?>penerimaan/tabungandata/'+siswa_id);
							}
						});
					}
				});
	}
</script>
