<?php
$user=$this->session->userdata('user');
$level=$user[0]->id_level;
?>
<div class="row">
	<div class="col-sm-12">
		<div class="tabbable tabs-left">
			<ul class="nav nav-tabs nav-tabs3" id="myTab3">
				<li class="active">
					<a data-toggle="tab" href="#home<?=$id?>">
						<i class="pink ace-icon fa fa-tachometer bigger-110"></i>
						Profil Kelas
					</a>
				</li>

				<!-- <li>
					<a data-toggle="tab" href="#profile<?=$id?>">
						<i class="blue ace-icon fa fa-user bigger-110"></i>
						Absensi Siswa
					</a>
				</li> -->
				<?php
				if($level!=4)
				{
				?>
				<li>
					<a data-toggle="tab" href="#tagihan<?=$id?>">
						<i class="red ace-icon fa fa-barcode bigger-110"></i>
						Tagihan Siswa
					</a>
				</li>
				<?php
				}
				?>

			</ul>

			<div class="tab-content kontentab" id="kontentab" style="min-height:400px !important">
				<div id="home<?=$id?>" class="tab-pane in active">
					<form class="form-horizontal" role="form" id="simpanjarak">
						<div class="form-group">
							<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Nama Kelas </label>

							<div class="col-sm-10">
								<input type="text" id="nama_kelas" name="nama_kelas" placeholder="Level" class="col-xs-12 col-sm-5" value="<?=$d->nama_batch?>" readonly style="background:#ffffff !important;font-weight:bold;" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Kategori Kelas </label>

							<div class="col-sm-10">
								<input type="text" id="kategori_kelas" name="kategori_kelas" placeholder="Kategori Kelas" readonly class="col-xs-12 col-sm-5" value="<?=$d->nama_level?>" style="background:#ffffff !important;font-weight:bold;"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Wali Kelas </label>

							<div class="col-sm-10">
								<input type="text" id="nama_level" name="wali_kelas" placeholder="Wali Kelas" readonly class="col-xs-12 col-sm-5" value="<?=$d->wali_kelas?>" style="background:#ffffff !important;font-weight:bold;"/>
							</div>
						</div>
					</form>
					<div class="row">
						<div class="col-sm-9" >
							<legend>Data Siswa</legend>
							<center>
								<div id="loader-data-siswa<?=$id?>"><img src="<?=base_url()?>assets/img/loading-bl-blue.gif"></div>
							</center>
							<div id="datasiswa<?=$id?>"></div>
						</div>
						<div class="col-sm-3">
							<form class="form-horizontal">
								<legend>Tambah Siswa</legend>
									<label for="form-field-select-2">Nama Siswa</label>
									<select multiple="" class="chosen-select form-control tag-input-style" id="pilihsiswa" data-placeholder="Pilih Nama Siswa">
									<?php
									$ceksiswa=$this->db->select('id')->from('v_batch_siswa')->where('active','1')->where('st_tbk','t')->where('status_tampil','1')->like('tahun_ajaran',$d->tahun_ajaran)->get()->result();
									// echo '<pre>';
									// print_r($ceksiswa);
									// echo '</pre>';
									$ds=array();
									foreach ($ceksiswa as $ks => $vs)
									{
										# code...
										$ds[$vs->id]=$vs->id;
									}
									if(count($siswa)!=0)
									{
										foreach ($siswa as $k => $v)
										{
											if(!in_array($v->id, $ds))
												echo '<option value="'.$v->id.'__'.$v->nis.'__'.str_replace(' ', '%20', $v->nama_murid).'">'.$v->nama_murid.'</option>';
												// unset($siswa[$v->id]);

										}
									}
									?>
									</select>
									<div class="clearfix form-actions">
										<div class="col-md-offset-3 col-md-9">
											<button class="btn btn-info btn-xs" id="simpandatasiswa" type="button">
												<i class="ace-icon fa fa-check bigger-110"></i> Simpan
											</button>

											&nbsp; &nbsp; &nbsp;
										</div>
									</div>
							</form>
						</div>
					</div>
				</div>

				<div id="profile<?=$id?>" class="tab-pane">

				</div>
				<div id="tagihan<?=$id?>" class="tab-pane">
					<!-- <form id="formTagihan" action="<?=site_url()?>penerimaan/setDataTagihan/<?=$d->id_batch?>" method="post"> -->
					<form id="formTagihan">

						<div class="row">
							<div class="col-xs-12" style="">
								<div style="float:right;margin-bottom:5px;">
									<select class="chosen-select" id="bulan" name="bulan" data-placeholder="Bulan" onchange="getdatatagihan()">
									<option value="">-Pilih-</option>
									<?php
									// $bulan=array();
									for($i=1;$i<=12;$i++)
									{
										// if($i==date('n'))
										// 	echo '<option selected="selected" value="'.$i.'">'.getBulan($i).'</option>';
										// else
											echo '<option value="'.$i.'">'.getBulan($i).'</option>';
									}
									?>
									</select>
									<select class="chosen-select" id="tahun" name="tahun" data-placeholder="Tahun" onchange="getdatatagihan()">
									<option value="">-Pilih-</option>
									<?php
									for($i=(date('Y')+1);$i>(date('Y')-5);$i--)
									{
										// if($i==date('Y'))
										// 	echo '<option selected="selected" value="'.$i.'">'.$i.'</option>';
										// else
											echo '<option value="'.$i.'">'.$i.'</option>';
									}
									?>
									</select>
									<button class="btn btn-white btn-info btn-xs" style="margin-bottom:5px;" id="simpanTagihan" type="button">
										<i class="ace-icon fa fa-save red2"></i> Simpan
									</button>
								</div>
							</div>
							<center>
								<div id="loader-data-tagihan<?=$id?>"><img src="<?=base_url()?>assets/img/loading-bl-blue.gif"></div>
							</center>
							<div class="col-xs-12" style="" id="datatagihan_<?=$id?>">

							</div>

						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<style type="text/css">
	#pilihsiswa_chosen
	{
		width: 250px !important;
	}

	input[type=text]
	{
		padding:4px !important;
		font-size:11px !important;
	}
	.form-group
	{
		margin-bottom:4px;
	}
</style>
<script type="text/javascript">
	$('#loader-data-siswa<?=$id?>').show();
	$('#loader-data-tagihan<?=$id?>').hide();
	$('#datasiswa<?=$id?>').load('<?=site_url()?>kelas/batchdatasiswa/<?=$id?>',function(){
		$('#loader-data-siswa<?=$id?>').hide();
	});
	/*$('#datatagihan_<?=$id?>').load('<?=site_url()?>kelas/batchdatasiswa/<?=$id?>/tagihan',function(){
		$('#loader-data-tagihan<?=$id?>').hide();
	});*/
	$('.chosen-select').chosen({allow_single_deselect:true});
	$('button#simpanTagihan').on('click',function(e){

		var bulan=$('#bulan').val();
		var tahun=$('#tahun').val();
		if(bulan=="")
		{
			alert("Bulan Belum Dipilih");
		}
		else if(tahun=="")
		{
			alert("Tahun Belum Dipilih");
		}
		else
		{

			bootbox.confirm("<h3>Apakah Data yang Diinput Sudah Benar ?? </h3>", function(result) {
				if(result)
				{
					// $('#formTagihan').submit();
					
					$.ajax({
						url :'<?=site_url()?>penerimaan/setDataTagihan/<?=$d->id_batch?>',
						type : 'POST',
						data : $('form#formTagihan').serialize(),
						success : function(a)
						{
							tampilpesan(a);
							// $('#datasiswa<?=$id?>').load('<?=site_url()?>kelas/batchdatasiswa/<?=$id?>');
							$('#loader-data-tagihan<?=$id?>').show();
							$('#datatagihan_<?=$id?>').load('<?=site_url()?>kelas/batchdatasiswa/<?=$id?>/tagihan/'+bulan+'/'+tahun,function(){
								$('#loader-data-tagihan<?=$id?>').hide();

							});
						}
					});
				}
			});
		}
	});
	$('button#simpandatasiswa').on('click',function(e)
	{
		var siswa = $('select#pilihsiswa').val();
		// alert(siswa);
		$('#loader-data').show();
		$('#loader-datanon').show();

		$.ajax({
			url : '<?=site_url()?>kelas/simpankebatch/<?=$id?>',
			type : 'POST',
			data : {idsiswa : siswa},
			success : function(a)
			{
				tampilpesan(a);
				$('#loader-data-siswa<?=$id?>').show();
				$('#loader-data-tagihan<?=$id?>').show();
				$('#datasiswa<?=$id?>').load('<?=site_url()?>kelas/batchdatasiswa/<?=$id?>',function(){
					$('#loader-data-siswa<?=$id?>').hide();
				});
				$('#datatagihan_<?=$id?>').load('<?=site_url()?>kelas/batchdatasiswa/<?=$id?>/tagihan',function(){
					$('#loader-data-tagihan<?=$id?>').hide();
				});
				$('select#pilihsiswa').val('').trigger('chosen:updated');

				$('#data').load('<?=site_url()?>kelas/batchdata/t',function(){
					$('#loader-data').hide();
				});
				$('#datanonaktif').load('<?=site_url()?>kelas/batchdata/f',function(){
					$('#loader-datanon').hide();
				});
			}
		});
	});

	function getdatatagihan()
	{
		var id=<?=$id?>;
		var bulan=$('#bulan').val();
		var tahun=$('#tahun').val();
		if(bulan!="" && tahun!="")
		{
			$('#loader-data-tagihan<?=$id?>').show();
			$('#datatagihan_<?=$id?>').css({'background':'white','opacity':'0.2'});
			$('#datatagihan_<?=$id?>').load('<?=site_url()?>kelas/batchdatasiswa/<?=$id?>/tagihan/'+bulan+'/'+tahun,function(){
				$('#loader-data-tagihan<?=$id?>').hide();
				$('#datatagihan_<?=$id?>').css({'background':'transparent','opacity':'1.0'});
			});
		}
	}
	function hapusbatchsiswa(id,idkonten)
	{
		bootbox.confirm("<h3>Yakin Ingin Menghapus Data ini ?? </h3>", function(result) {
					if(result)
					{
						$.ajax({
							url : '<?=site_url()?>kelas/hapusbatchsiswa/'+id,
							success : function(a)
							{
								// alert(a);
								tampilpesan(a);
								// $('#data').load('<?=site_url()?>kelas/batchdata/t');
								// $('#datanonaktif').load('<?=site_url()?>kelas/batchdata/f');
								$('#loader-data-tagihan<?=$id?>').hide();
								$('#loader-data-siswa<?=$id?>').hide();
								$('#datasiswa<?=$id?>').load('<?=site_url()?>kelas/batchdatasiswa/<?=$id?>',function(){
									$('#loader-data-siswa<?=$id?>').hide();
								});
								$('#datatagihan_<?=$id?>').load('<?=site_url()?>kelas/batchdatasiswa/<?=$id?>/tagihan',function(){
									$('#loader-data-tagihan<?=$id?>').hide();
								});
							}
						});
					}
				});
	}
</script>
<style>
	.chosen-container .chosen-drop {
		width: 200px !important;
		text-align: left !important;
		}
	.chosen-container-multi .chosen-choices li.search-choice
	{
		font-size:10px !important;
		text-align: left !important
		/*width:140px !important;*/
	}
	.chosen-container, [class*=chosen-container]
	{
		width:140px !important;
	}

</style>
