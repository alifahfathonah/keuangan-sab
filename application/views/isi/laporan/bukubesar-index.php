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
										Laporan
										<small>
											<i class="ace-icon fa fa-angle-double-right"></i>
											Data Buku Besar
										</small>
									</h1>
								</div>
							</div>
							<div class="col-xs-2">
								<div class="row">
									<div class="col-xs-12">
										<div class="dd" >
											<ol class="dd-list">
												<?php
												foreach ($lk as $k => $v)
												{
												?>
													<li class="dd-item" data-id="<?=$k?>" style="cursor:pointer">
														<div class="kolom">
															<a href="javascript:getdatabukubesar('<?=$v?>')"><?=$v?></a>
														</div>
													</li>

												<?php
												}
												?>
											</ol>
										</div>
									<!-- /.col -->
									</div><!-- /.col -->
								</div><!-- /.col -->

							</div>
							<div class="col-xs-10">
								<!-- /.page-header -->

								<div class="row">
									<div class="col-xs-8">
										<div id="divakun">
											<select class="col-xs-4 col-sm-4 chosen-select" id="kodeakun" name="kodeakun" data-placeholder="Kode Akun" onchange="getdata(this.value)">
													<option value="-1">- Kode Akun -</option>
													<?php
													echo count($kodeakun);
													foreach($kodeakun as $k => $v)
													{
														// if($ak_alt!='')
														// {
														// 	if($ak_alt==$v->akun_alternatif)
														// 	{
														// 		echo '<option value="'.$ak_alt.'" selected="selected">'.$v->akun_alternatif.' - '.$v->nama_akun.'</option>';
														// 	}
														// 	else
														// 	{
														// 		echo '<option value="'.$v->akun_alternatif.'">'.$v->akun_alternatif.' - '.$v->nama_akun.'</option>';
														// 	}
														// }
														// else
														// {
														// 	echo '<option value="'.$v->akun_alternatif.'">'.$v->akun_alternatif.' - '.$v->nama_akun.'</option>';
														// }
														if($ak_alt!='')
														{
															if($ak_alt==$v->kode_akun)
															{
																echo '<option value="'.$ak_alt.'" selected="selected">'.$v->kode_akun.' - '.$v->nama_akun.'</option>';
															}
															else
															{
																echo '<option value="'.$v->kode_akun.'">'.$v->kode_akun.' - '.$v->nama_akun.'</option>';
															}
														}
														else
														{
															echo '<option value="'.$v->kode_akun.'">'.$v->kode_akun.' - '.$v->nama_akun.'</option>';
														}
													}
													?>
													<option value="all">Keseluruhan</option>
											</select>
										</div>
									</div>
									<div class="col-xs-4">

										<div style="float:right;margin-bottom:5px;">
											<div id="bulan_tahun">
												<select class="" id="bulan" name="bulan" data-placeholder="Bulan" onchange="getdatabukubesar('null')">
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
												<select class="" id="tahun" name="tahun" data-placeholder="Tahun" onchange="getdatabukubesar('null')" style="width:100px !important;">
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
											<div id="harian">
												<div class="input-group" style="width:100px !important;">
													<input  id="rekap_harian" name="rekap_harian" type="text" data-date-format="dd-mm-yyyy" style="width:110px !important;float:right" placeholder="Pilih Tanggal" oninvalid="this.setCustomValidity('Tanggal Harus Diisi')"  value="<?=(date("d-m-Y"))?>"/>
													<span class="input-group-addon">
													<i class="fa fa-calendar bigger-110"></i>
													</span>
												</div>
											</div>
										</div>

										<!-- PAGE CONTENT BEGINS -->

									</div><!-- /.col -->
								</div><!-- /.row -->
								<div class="row">
									<div class="col-xs-12">
										<center>
											<div id="loader-data"><img src="<?=base_url()?>assets/img/loading-bl-blue.gif"></div>
										</center>
										
										<div id="data" style="border:1px solid #ddd;padding:15px;">Silahkan Pilih Jenis Buku Besar Terlebih Dahulu</div>
									</div>
								</div>

							</div>

						</div>
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->
			<input type="hidden" name="jenis" id="jenis" value="Harian">
			<?=$this->load->view($footer,'',TRUE)?>
<script type="text/javascript">
	$('div#bulan_tahun').hide();
	$('div#harian').hide();
	$('#divakun').hide();
	$('#loader-data').hide();
	$('.chosen-select').chosen({allow_single_deselect:true});

	var ak_alt='<?=$ak_alt?>';
	if(ak_alt!='')
	{
		$('div#bulan_tahun').show();
		$('div#harian').hide();
		$('select#bulan').show();
		$('#divakun').show();
		$('#loader-data').show();
		$('#data').css({'background':'white','opacity':'0.2'});
		$('#data').load('<?=site_url()?>laporan/bukubesardata2/Bulanan/<?=$date?>/'+ak_alt,function(){
			$('#loader-data').hide();
			$('#data').css({'background':'transparent','opacity':'1.0'});
		});
	}
	// alert(ak_alt);
	function getdatabukubesar(jenis)
	{
		var val=$('#kodeakun').val();
		$('#divakun').show();
		if(jenis!='null')
		{
			$('#jenis').val(jenis);
		}
		else
		{
			jenis=$('#jenis').val();
		}

		var bulan=$('#bulan').val();
		var tahun=$('#tahun').val();

		if(jenis=='Harian')
		{
			var date=$('#rekap_harian').val();
			$('div#bulan_tahun').hide();
			$('div#harian').show();
			$('select#bulan').hide();
		}
		else if(jenis=='Bulanan')
		{
			var date=tahun+'-'+bulan;
			$('div#bulan_tahun').show();
			$('div#harian').hide();
			$('select#bulan').show();
		}
		else if(jenis=='Tahunan')
		{
			var date=tahun;
			$('div#bulan_tahun').show();
			$('div#harian').hide();
			$('select#bulan').hide();
		}
		$('#loader-data').show();
		$('#data').css({'background':'white','opacity':'0.2'});
		$('#data').load('<?=site_url()?>laporan/bukubesardata2/'+jenis+'/'+date+'/'+val,function(){
			$('#loader-data').hide();
			$('#data').css({'background':'transparent','opacity':'1.0'});

		});

	}
	function reloadbukubesar(jenis,date)
	{
		var val=$('#kodeakun').val();
		$('#loader-data').show();
		$('#data').css({'background':'white','opacity':'0.2'});
		$('#data').load('<?=site_url()?>laporan/bukubesardata2/'+jenis+'/'+date+'/'+val,function(){
			$('#loader-data').hide();
			$('#data').css({'background':'transparent','opacity':'1.0'});

		});
	}
	function getdata(val)
	{
		var jenis=$('#jenis').val();
		var bulan=$('#bulan').val();
		var tahun=$('#tahun').val();
		if(jenis=='Bulanan')
		{
			var date=tahun+'-'+bulan;
			$('div#bulan_tahun').show();
			$('div#harian').hide();
			$('select#bulan').show();
		}
		else if(jenis=='Tahunan')
		{
			var date=tahun;
			$('div#bulan_tahun').show();
			$('div#harian').hide();
			$('select#bulan').hide();
		}
		$('#loader-data').show();
		$('#data').css({'background':'white','opacity':'0.2'});
		$('#data').load('<?=site_url()?>laporan/bukubesardata2/'+jenis+'/'+date+'/'+val,function(){
			$('#loader-data').hide();
			$('#data').css({'background':'transparent','opacity':'1.0'});

		});
	}
	function downloadbukubesar(jenis)
	{
		var val=$('#kodeakun').val();
		if(jenis!='null')
		{
			$('#jenis').val(jenis);
		}
		else
		{
			jenis=$('#jenis').val();
		}
		var bulan=$('#bulan').val();
		var tahun=$('#tahun').val();

		if(jenis=='Harian')
		{
			var date=$('#rekap_harian').val();
			$('div#bulan_tahun').hide();
			$('div#harian').show();
			$('select#bulan').hide();
		}
		else if(jenis=='Bulanan')
		{
			var date=tahun+'-'+bulan;
			$('div#bulan_tahun').show();
			$('div#harian').hide();
			$('select#bulan').show();
		}
		else if(jenis=='Tahunan')
		{
			var date=tahun;
			$('div#bulan_tahun').show();
			$('div#harian').hide();
			$('select#bulan').hide();
		}

		window.open(
			'<?=site_url()?>laporan/bukubesarexcel/'+jenis+'/'+date+'/'+val,
			'_blank'
		);
	}
	$('input#rekap_harian').datepicker({
		autoclose: true,
		todayHighlight: true
	}).on('changeDate', function(ev){
            // alert(ev.format());
			$('#loader-data').show();
            $('#data').load('<?=site_url()?>laporan/bukubesardata2/Harian/'+ev.format(),function(){
				$('#loader-data').hide();
		});
    });
</script>
<style type="text/css">
	.kolom
	{
		display: block;
	    min-height: 38px;
	    margin: 5px 0;
	    padding: 8px 12px;
	    background: #F8FAFF;
	    border: 1px solid #DAE2EA;
	    color: #7C9EB2;
	    text-decoration: none;
	    font-weight: 700;
	    -webkit-box-sizing: border-box;
	    -moz-box-sizing: border-box;
	    box-sizing: border-box;
	    border-left: solid 2px orange;
	}
	#kodeakun_chosen
	{
		width:50% !important;
	}
</style>