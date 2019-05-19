<table id="simple-table" class="table table-striped table-bordered table-hover">
	<thead>
		<tr>
			<th class="center">No</th>
			<th>No VA</th>
			<th>NIS</th>
			<th>Nama</th>
			<th>Kelamin</th>
			<th>Tgl Lahir</th>
			<th>Alamat</th>
			<th>Nama Ayah &amp;<br> Nama Ibu</th>
			<th>No. HP Ayah &amp;<br> No. HP Ibu</th>
			<th>Email Ayah &amp;<br> Email Ibu</th>
			<th></th>
		</tr>
	</thead>

	<tbody>
	<?php
	$no=$hal+1;
	foreach ($dd as $k => $v) 
	{
	?>


		<tr>
			<td class="center"><?=$no?></td>

			<td><a href="#"><?=$v->no_virtual_account?></a></td>
			<td><a href="#"><?=$v->nisn?></a></td>
			<td><a href="#"><?=$v->nama_murid?></a></td>
			<td><?=($v->jenis_kelamin=='0' ? 'Perempuan' : 'Laki-laki')?></td>
			<td class="hidden-480"><?=tgl_indo($v->tanggal_lahir)?></td>
			<td><?=$v->alamat?></td>

			<td class="hidden-480">
				<?=$v->nama_ayah?><br><?=$v->nama_ibu?>
			</td>
			<td class="hidden-480">
				<?=$v->hp_ayah?><br><?=$v->hp_ibu?>
			</td>			
			<td class="hidden-480">
				<?=$v->email_ayah?><br><?=$v->email_ibu?>
			</td>

			<td>
				<div class="hidden-sm hidden-xs btn-group">
					<button class="btn btn-xs btn-info" onclick="edit(<?=$v->id?>)">
						<i class="ace-icon fa fa-pencil bigger-120"></i>
					</button>

					<button class="btn btn-xs btn-danger" onclick="hapus(<?=$v->id?>)">
						<i class="ace-icon fa fa-trash-o bigger-120"></i>
					</button>
				</div>
				<div class="hidden-md hidden-lg">
					<div class="inline pos-rel">
						<button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown" data-position="auto">
							<i class="ace-icon fa fa-cog icon-only bigger-110"></i>
						</button>

						<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">


							<li>
								<a href="#" class="tooltip-success" data-rel="tooltip" title="Edit" onclick="edit(<?=$v->id?>)">
									<span class="green">
										<i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
									</span>
								</a>
							</li>

							<li>
								<a href="#" class="tooltip-error" data-rel="tooltip" title="Delete" onclick="hapus(<?=$v->id?>)">
									<span class="red">
										<i class="ace-icon fa fa-trash-o bigger-120"></i>
									</span>
								</a>
							</li>
						</ul>
					</div>
				</div
			</td>
		</tr>
	<?php	# code...
		$no++;
	}
	?>
	</tbody>
</table>
<div style="width:100%;padding:20px 10px;background:#ddd;float:left">
	<?=$this->pagination->create_links2()?>
	<!-- <ul class="pagination" style="margin-top:0px !important;margin-bottom:0px !important;float:right;">
		<li class="disabled">
			<a href="#">
				<i class="ace-icon fa fa-angle-double-left"></i>
			</a>
		</li>

		<li class="active">
			<a href="#">1</a>
		</li>

		<li>
			<a href="#">2</a>
		</li>

		<li>
			<a href="#">3</a>
		</li>

		<li>
			<a href="#">4</a>
		</li>

		<li>
			<a href="#">5</a>
		</li>

		<li>
			<a href="#">
				<i class="ace-icon fa fa-angle-double-right"></i>
			</a>
		</li>
	</ul> -->
</div>
<script type="text/javascript">
	function <?=$class_js?>(h)
	{
			//alert(h);
		$('#data').load('<?=site_url()?>siswa/data/<?=$search?>/'+h);
	}
	function edit(id)
	{
		location.href='<?=site_url()?>siswa/form/'+id;
	}

	function hapus(id)
	{
		bootbox.confirm("<h3>Yakin Ingin Menghapus Data Siswa ini ?? </h3>", function(result) {
					if(result) 
					{
						$.ajax({
							url : '<?=site_url()?>siswa/siswahapus/'+id,
							success : function(a)
							{
								// alert(a);
								tampilpesan(a);
								// location.href='<?=site_url()?>siswa/form/'+id;
								$('#data').load('<?=site_url()?>siswa/data');
								// $('#form').load('<?=site_url()?>config/supirform/-1');
							}
						});
					}
				});
	}
</script>