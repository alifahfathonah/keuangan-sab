<div class="main-container" id="main-container">
			<script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>

			<?=$this->load->view('layout/top-menu','',TRUE)?>

			<div class="main-content">
				<div class="main-content-inner">
					<div class="page-content">
						<div class="row">
							<div class="col-xs-12">
								<div class="page-header">
									<h1>
										Transaksi
										<small>
											<i class="ace-icon fa fa-angle-double-right"></i>
											Penerimaan
										</small>
									</h1>
								</div>
							</div>

							<div class="col-xs-12">
								<!-- /.page-header -->


								<div class="row">
									<div class="col-xs-12">
										<div class="tabbable tabs-left">
											<ul class="nav nav-tabs" id="myTab3">
												<li class="active">
													<a data-toggle="tab" href="#profile3">
														<i class="blue ace-icon glyphicon  glyphicon-tags bigger-110"></i>
														Transaksi Bank
													</a>
												</li>
												<li>
													<a data-toggle="tab" href="#home3">
														<i class="pink ace-icon glyphicon glyphicon-tag bigger-110"></i>
														Transaksi Langsung
													</a>
												</li>

												 <li>
													<a data-toggle="tab" href="#lain">
														<i class="brown ace-icon glyphicon  glyphicon-tags bigger-110"></i>
														Transaksi Lain
													</a>
												</li> 
												<li>
													<a data-toggle="tab" href="#rekap">
														<i class="green ace-icon glyphicon  glyphicon-tags bigger-110"></i>
														Rekap Transaksi
													</a>
												</li>
											</ul>

											<div class="tab-content" style="min-height:400px !important;">
												<div id="home3" class="tab-pane in">

													<form class="form-horizontal" role="form" id="simpantransaksi" action="<?=site_url()?>transaksi/process" method="post">

														<legend>Form Transanksi Langsung</legend>
														<div class="form-group">
															<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Tanggal Transaksi </label>

															<div class="col-sm-9">
																<div class="input-group" style="width:100px !important;">
																	<input  id="tanggal_transaksi" name="tanggal_transaksi" type="text" data-date-format="dd-mm-yyyy" style="width:110px !important;" placeholder="Tgl Transaksi" oninvalid="this.setCustomValidity('Tanggal Transaksi Harus Diisi')"  value="<?=(date("d-m-Y"))?>"/>
																	<span class="input-group-addon">
																	<i class="fa fa-calendar bigger-110"></i>
																	</span>
																</div>
															</div>
														</div>
														<div class="form-group">
															<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Nama Siswa </label>

															<div class="col-sm-6">
																<select name="siswa" id="siswa" class="col-xs-12 col-sm-12 chosen-select" data-rel="chosen">
																	<option value="">-Pilih Nama Siswa-</option>
																	<?php
																	foreach ($siswa as $k => $v)
																	{
																		echo '<option value="'.$v->id.'__'.$v->nis.'">'.$v->nama_murid.'</option>';
																	}
																	?>
																</select>
															</div>
														</div>

														<div id="kelas"></div>
														<div class="form-group">
															<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Penyetor </label>

															<div class="col-sm-5">
																	<input  id="penyetor" class="col-xs-12 col-sm-12" name="penyetor" type="text"  placeholder="Nama Penyetor"/>
															</div>
														</div>
														<div class="form-group">
															<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Persiapan </label>

															<div class="col-sm-2">
																<select name="persiapan" id="persiapan" class="col-xs-12 col-sm-12 chosen-select" data-rel="chosen">
																	<option value="0">Tidak</option>
																	<option value="1">Ya</option>
																</select>
															</div>
														</div>
														<div class="form-group">
															<label class="col-sm-3 control-label no-padding-right" for="form-field-1"><b> Tagihan</b> </label>
															<div class="col-sm-9">&nbsp;</div>
															<div class="col-sm-12">
																<center>
																	<div id="loader-tagihan"><img src="<?=base_url()?>assets/img/loading-bl-blue.gif"></div>
																</center>
																<div id="tagihan"></div>
															</div>
														</div>
														<div class="clearfix form-actions">
															<div class="col-md-offset-3 col-md-9">
																<button class="btn btn-info" id="simpan" type="button">

																	<i class="ace-icon fa fa-check bigger-110"></i> Simpan Transaksi
																</button>
																&nbsp; &nbsp; &nbsp;
															</div>
														</div>

														<div class="hr hr-24"></div>
													</form>
												</div>

												<div id="profile3" class="tab-pane in active">
													<?php
													$d['bank']=$bank;
													$d['siswa']=$siswa;
													?>
													<?=$this->load->view('isi/transaksi/form-bank',$d,TRUE)?>
												</div>
												<div id="lain" class="tab-pane">
													<form class="form-horizontal" role="form" id="simpantransaksilain" action="<?=site_url()?>transaksi/penerimaanlainprocess" method="post">

														<legend>Form Transanksi Lainnya</legend>
														<?php
														$dataj['jenis']=$jenis;
														//print_r($jenis);
														?>
														<?=$this->load->view('isi/transaksi/penerimaan-form',$dataj,TRUE)?>

														<div class="hr hr-24"></div>
													</form>
												</div>
												<div id="rekap" class="tab-pane">
													<legend>Rekap Transaksi</legend>
													<div class="tabbable">
														<ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
															<li class="active">
																<a data-toggle="tab" href="#home4">Harian</a>
															</li>

															<li>
																<a data-toggle="tab" href="#profile4">Bulanan</a>
															</li>

															<!-- <li>
																<a data-toggle="tab" href="#dropdown14">Tahunan</a>
															</li> -->
														</ul>

														<div class="tab-content">
															<div id="home4" class="tab-pane in active">
																<div class="form-group" style="margin-bottom:0px !important;padding-top:0px !important">
																	<label class="col-sm-10 control-label no-padding-right" for="form-field-1" style="text-align:right;padding-top:5px !important">Tanggal </label>

																	<div class="col-sm-2" style="text-align:right;">
																		<div class="input-group" style="width:100px !important;">
																			<input  id="rekap_harian" name="rekap_harian" type="text" data-date-format="dd-mm-yyyy" style="width:110px !important;float:right" placeholder="Pilih Tanggal" oninvalid="this.setCustomValidity('Tanggal Harus Diisi')"  value="<?=(date("d-m-Y"))?>"/>
																			<span class="input-group-addon">
																			<i class="fa fa-calendar bigger-110"></i>
																			</span>
																		</div>
																	</div>
																</div>
																<div class="tabbable tabs-left" style="padding-top: 5px !important;float:left;width:100%" >
																	<ul class="nav nav-tabs" id="">
																		<li class="active">
																			<a data-toggle="tab" href="#id_rekap_harian">
																				Tabel Rekap
																			</a>
																		</li>

																		<li>
																			<a data-toggle="tab" href="#id_grafik_harian">
																				Grafik Rekap
																			</a>
																		</li>
																		<li>
																			<a data-toggle="tab" href="#presentase_harian">
																				Presentase Pembayaran
																			</a>
																		</li>

																	</ul>

																	<div class="tab-content">
																		<div id="id_rekap_harian" class="tab-pane in active">
																			<center>
																				<div id="loader-rekap-harian"><img src="<?=base_url()?>assets/img/loading-bl-blue.gif"></div>
																			</center>
																		</div>

																		<div id="id_grafik_harian" class="tab-pane">
																			<center>
																				<div id="loader-grafik-harian"><img src="<?=base_url()?>assets/img/loading-bl-blue.gif"></div>
																			</center>
																		</div>
																		<div id="presentase_harian" class="tab-pane">
																			<center>
																				<div id="loader-presentase-harian"><img src="<?=base_url()?>assets/img/loading-bl-blue.gif"></div>
																			</center>
																		</div>

																	</div>
																</div>
															</div>

															<div id="profile4" class="tab-pane">
																<div class="row">
																	<div class="col-xs-8">
																	&nbsp;
																	</div>
																	<div class="col-xs-4">

																		<div style="float:right;margin-bottom:5px;">
																			<select class="" id="bulan" name="bulan" data-placeholder="Bulan" onchange="getrekapbulanan()">
																			<?php
																			// $bulan=array();
																			for($i=1;$i<=12;$i++)
																			{
																				if($i==date('n'))
																					echo '<option selected="selected" value="'.$i.'">'.getBulan($i).'</option>';
																				else
																					echo '<option value="'.$i.'">'.getBulan($i).'</option>';
																			}
																			?>
																			</select>
																			<select class="" id="tahun" name="tahun" data-placeholder="Tahun" onchange="getrekapbulanan()" style="width:100px !important;">
																			<?php
																			for($i=(date('Y')-10);$i<=(date('Y')+1);$i++)
																			{
																				if($i==date('Y'))
																					echo '<option selected="selected" value="'.$i.'">'.$i.'</option>';
																				else
																					echo '<option value="'.$i.'">'.$i.'</option>';
																			}
																			?>
																			</select>

																		</div>

																		<!-- PAGE CONTENT BEGINS -->

																	</div><!-- /.col -->
																</div>
																<div class="tabbable tabs-left" style="padding-top: 5px !important;float:left;width:100%" >
																	<ul class="nav nav-tabs" id="">
																		<li class="active">
																			<a data-toggle="tab" href="#id_rekap_bulanan">
																				Tabel Rekap
																			</a>
																		</li>

																		<li>
																			<a data-toggle="tab" href="#id_grafik_bulanan">
																				Grafik Rekap
																			</a>
																		</li>
																		<li>
																			<a data-toggle="tab" href="#presentase_bulanan">
																				Presentase Pembayaran
																			</a>
																		</li>

																	</ul>

																	<div class="tab-content">
																		<div id="id_rekap_bulanan" class="tab-pane in active">
																			<center>
																				<div id="loader-rekap-bulan"><img src="<?=base_url()?>assets/img/loading-bl-blue.gif"></div>
																			</center>
																		</div>

																		<div id="id_grafik_bulanan" class="tab-pane">
																			<center>
																				<div id="loader-grafik-bulan"><img src="<?=base_url()?>assets/img/loading-bl-blue.gif"></div>
																			</center>
																		</div>
																		<div id="presentase_bulanan" class="tab-pane">
																			<center>
																				<div id="loader-presentase-bulan"><img src="<?=base_url()?>assets/img/loading-bl-blue.gif"></div>
																			</center>
																		</div>

																	</div>
																</div>
															</div>

															<!-- <div id="dropdown14" class="tab-pane">
																<div class="row">
																	<div class="col-xs-8">
																	&nbsp;
																	</div>
																	<div class="col-xs-4">

																		<div style="float:right;margin-bottom:5px;">

																			<select class="" id="tahunan" name="tahunan" data-placeholder="Tahun" onchange="getrekaptahunan()" style="width:100px !important;">
																			<?php
																			for($i=(date('Y')-10);$i<=(date('Y')+1);$i++)
																			{
																				if($i==date('Y'))
																					echo '<option selected="selected" value="'.$i.'">'.$i.'</option>';
																				else
																					echo '<option value="'.$i.'">'.$i.'</option>';
																			}
																			?>
																			</select>

																		</div>

																	

																	</div>
																</div>
																<div class="tabbable tabs-left" style="padding-top: 5px !important;float:left;width:100%" >
																	<ul class="nav nav-tabs" id="">
																		<li class="active">
																			<a data-toggle="tab" href="#id_rekap_tahunan">
																				Tabel Rekap
																			</a>
																		</li>

																		<li>
																			<a data-toggle="tab" href="#id_grafik_tahunan">
																				Grafik Rekap
																			</a>
																		</li>
																		<li>
																			<a data-toggle="tab" href="#id_prsentase_tahunan">
																				Grafik Rekap
																			</a>
																		</li>

																	</ul>

																	<div class="tab-content">
																		<div id="id_rekap_tahunan" class="tab-pane in active">
																			<center>
																				<div id="loader-rekap-tahunan"><img src="<?=base_url()?>assets/img/loading-bl-blue.gif"></div>
																			</center>
																		</div>
																		<div id="id_grafik_tahunan" class="tab-pane">
																			<center>
																				<div id="loader-grafik-tahunan"><img src="<?=base_url()?>assets/img/loading-bl-blue.gif"></div>
																			</center>
																		</div>
																		<div id="id_prsentase_tahunan" class="tab-pane">
																			<center>
																				<div id="loader-presentase-tahunan"><img src="<?=base_url()?>assets/img/loading-bl-blue.gif"></div>
																			</center>
																		</div>

																	</div>
																</div>
															</div> -->
														</div>
													</div>
												</div>

											</div>
										</div>
									</div>
								</div>

							</div>

						</div>
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->
<?=$this->load->view($footer,'',TRUE)?>
<style type="text/css">
	#siswa_chosen,#persiapan_chosen
	{
		width:100% !important;
	}
	label
	{
		font-size:11px !important;
	}
</style>
<script type="text/javascript">
	lihatdata(-1,-1,-1,-1);
	function lihatdata(v,tr,idrow,nis)
	{
		// var nis=$('#siswa').val();
		if(tr==-1)
		{
			$('#loader-tagihan').hide();
			$('#tagihan').html('<h2><center>Silahkan Pilih Nama Siswa dan Tahun Ajaran Terlebih Dahulu</center></h2>');
		}
		else
		{
			v=v.replace(/\//g,'::');
			v=v.replace(/ /g,'%20');
			// alert(v);
			$('#loader-tagihan').show();
			if(tr==0)
			{
				// var nnis=$('input.siswaa_'+idrow).val();
				$('#tagihan_'+idrow).load('<?=site_url()?>transaksi/tagihan/'+nis+'/'+v+'/0',function(){

					$('#loader-tagihan').hide();
				});
			}
			else
			{
				$('#tagihan').load('<?=site_url()?>transaksi/tagihan/'+nis+'/'+v,function(){
					$('#loader-tagihan').hide();
				});
			}
		}
	}
	$('#loader-grafik-harian').show();
	$('#loader-rekap-harian').show();
	$('#loader-presentase-harian').show();
	$('div#presentase_harian').load('<?=site_url()?>transaksi/presentase/harian',function(){
		$('#loader-presentase-harian').hide();
	});
	$('div#id_rekap_harian').load('<?=site_url()?>transaksi/rekap/penerimaan/harian',function(){
		$('#loader-rekap-harian').hide();
	});
	$('div#id_grafik_harian').load('<?=site_url()?>transaksi/rekap/penerimaan/harian/-1/1',function(){
		$('#loader-grafik-harian').hide();
	});

	$('#loader-grafik-bulan').show();
	$('#loader-rekap-bulan').show();
	$('div#id_grafik_bulanan').load('<?=site_url()?>transaksi/rekap/penerimaan/bulanan/-1/1',function(){
		$('#loader-grafik-bulan').hide();
	});
	$('div#id_rekap_bulanan').load('<?=site_url()?>transaksi/rekap/penerimaan/bulanan',function(){
		$('#loader-rekap-bulan').hide();
	});

	$('#loader-grafik-tahunan').show();
	$('#loader-rekap-tahunan').show();
	$('div#id_grafik_tahunan').load('<?=site_url()?>transaksi/rekap/penerimaan/tahunan/-1/1',function(){
		$('#loader-grafik-tahunan').hide();
	});
	$('div#id_rekap_tahunan').load('<?=site_url()?>transaksi/rekap/penerimaan/tahunan',function(){
		$('#loader-rekap-tahunan').hide();
	});

	$('.chosen-select').chosen({allow_single_deselect:true});
	$('#siswa').change(function(){
		var nis=$(this).val();
		
		$('#kelas').load('<?=site_url()?>kelas/getkelasbynis/'+nis+'/1',function(){
				$('#dkelas').chosen({allow_single_deselect:true});
				var batch_id=$('#dkelas').val();
				batch_id=batch_id.replace(/\//g,'::');
				batch_id=batch_id.replace(/ /g,'%20');
				// alert(nis);
				// if(batch_id=='')
				// {
				// 	$('#tagihan').load('<?=site_url()?>transaksi/tagihan/'+nis+'/null');
				// }
				// else
				$('#loader-tagihan').show();
				$('#tagihan').load('<?=site_url()?>transaksi/tagihan/'+nis+'/'+batch_id,function(){
					$('#loader-tagihan').hide();
				});
		});
	});

	$('#tanggal_transaksi').datepicker({
		autoclose: true,
		todayHighlight: true
	});
	$('input#rekap_harian').datepicker({
		autoclose: true,
		todayHighlight: true
	}).on('changeDate', function(ev){
            // alert(ev.format());
		$('#loader-rekap-harian').show();
		$('#loader-grafik-harian').show();
		$('div#id_rekap_harian').load('<?=site_url()?>transaksi/rekap/penerimaan/harian/'+ev.format(),function(){
			$('#loader-rekap-harian').hide();

		});
		$('div#id_grafik_harian').load('<?=site_url()?>transaksi/rekap/penerimaan/harian/'+ev.format()+'/1',function(){
			$('#loader-grafik-harian').hide();
		});
  });

	function getrekaptahunan()
	{
		var tahun=$('#tahunan').val();
		$('#loader-rekap-tahunan').show();
		$('#loader-grafik-tahunan').show();
		$('div#id_rekap_tahunan').load('<?=site_url()?>transaksi/rekap/penerimaan/tahunan/'+tahun,function(){
			$('#loader-rekap-tahunan').hide();
		});
		$('div#id_grafik_tahunan').load('<?=site_url()?>transaksi/rekap/penerimaan/tahunan/'+tahun+'/1',function(){
			$('#loader-grafik-tahunan').hide();
		});
	}

	function getrekapbulanan()
	{
		var tahun=$('#tahun').val();
		var bulan=$('#bulan').val();
		$('#loader-rekap-bulan').show();
		$('#loader-grafik-bulan').show();
		$('div#id_rekap_bulanan').load('<?=site_url()?>transaksi/rekap/penerimaan/bulanan/'+bulan+'-'+tahun,function(){
			$('#loader-rekap-bulan').hide();
		});
		$('div#id_grafik_bulanan').load('<?=site_url()?>transaksi/rekap/penerimaan/bulanan/'+bulan+'-'+tahun+'/1',function(){
			$('#loader-grafik-bulan').hide();
		});
	}

	function hitungnominal(id_jenis,ido,val)
	{
		$('input#transaksiform_'+ido).formatCurrency({symbol:''});
		var total=0;
		$('input.formtr_'+id_jenis).each(function(a)
		{
			var n=$(this).val();
			if(n=='')
				var nn=0;
			else
				var nn=n.replace(/,/g,'');
			// var t=(n);
			t=parseFloat(nn);
			total+=t;
		});
		$('span#total_'+id_jenis).text(total);
		$('span#total_'+id_jenis).formatCurrency({symbol:''});
		var grand=0;
		$('span.sub_total').each(function(a){
			var sb=$(this).text();
			sb=sb.replace(/,/g,'');

			sub = parseFloat(sb);
			grand+=sub;
		});
		$('#grandtotal').text(grand);
		$('#grandtotal').formatCurrency({symbol:''});
	}

	$("#simpan").on(ace.click_event, function() {
				bootbox.confirm("<h3>Apakah Data Transaksi ini sudah Benar ?</h3>", function(result) {
					if(result)
					{
						// $('form#simpantransaksi').submit();
						$.ajax({
							url : '<?=site_url()?>transaksi/process/2-Tunai',
							type : 'POST',
							data : $('#simpantransaksi').serialize(),
							success : function(a){
								window.open(
									'<?=site_url()?>transaksi/cetakkwitansi/'+a,
									'_blank'
								);
								location.href='<?=site_url()?>transaksi/penerimaan';
							}
						});
					}
				});
			});
	$("#submitlain").on(ace.click_event, function() {
			bootbox.confirm("<h3>Apakah Data Transaksi ini sudah Benar </h3>", function(result) {
					if(result) 
					{
						$.ajax({
							url : '<?=site_url()?>transaksi/penerimaanlainprocess',
							type : 'POST',
							data : $('#simpantransaksilain').serialize(),
							success : function(a){
								//tampilpesan(a);
								setTimeout(function(){ location.href='<?=site_url()?>transaksi/penerimaan'; }, 1000);
							}	
						});
						// alert('aa');
						//$('#simpantransaksilain').submit();
					}
				});
	});

</script>
