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
											Data Jurnal
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
															<a href="javascript:getdatajurnal('<?=$v?>')"><?=$v?></a>
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
											<form class="form-search">
												<span class="input-icon">
													<input type="text" placeholder="Cari Nama Siswa" class="nav-search-input" id="nav-search-input" autocomplete="off" style="width:350px">
													<i class="ace-icon fa fa-search nav-search-icon"></i>
												</span>
											</form>
										
									</div>
									<div class="col-xs-4">

										<div style="float:right;margin-bottom:5px;">
											<div id="bulan_tahun">
												<select class="" id="bulan" name="bulan" data-placeholder="Bulan" onchange="getdatajurnal('null')">
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
												<select class="" id="tahun" name="tahun" data-placeholder="Tahun" onchange="getdatajurnal('null')" style="width:100px !important;">
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
										
										<div id="data" style="border:1px solid #ddd;padding:15px;">Silahkan Pilih Jenis Jurnal Terlebih Dahulu</div>
									</div>
								</div>

							</div>

						</div>
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->
			<input type="hidden" name="jenis" id="jenis">
			<?=$this->load->view($footer,'',TRUE)?>
<script type="text/javascript">
	$('div#bulan_tahun').hide();
	$('div#harian').hide();
	$('#loader-data').hide();

	function datakelas(batch_id)
	{
		var bulan=$('#bulan').val();
		var tahun=$('#tahun').val();
		$('#batch_id').val(batch_id);
		$('#loader-data').show();
		$('#data').load('<?=site_url()?>laporan/datatagihan/'+batch_id+'/'+bulan+'/'+tahun,function(){

			$('#loader-data').hide();
		});
		// $('#data').load('<?=site_url()?>laporan/datatagihan/'+batch_id);
	}
	function downloadjurnal(jenis)
	{
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
			'<?=site_url()?>laporan/jurnalexcel/'+jenis+'/'+date,
			'_blank'
		);
	}
	function getdatajurnal(jenis)
	{
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
		$('#data').load('<?=site_url()?>laporan/jurnaldata2/'+jenis+'/'+date,function(){
			$('#loader-data').hide();
			$('#data').css({'background':'transparent','opacity':'1.0'});

		});

	}
	function reloadjurnal(jenis,date,j_lap)
	{
		$('#loader-data').show();
		$('#data').css({'background':'white','opacity':'0.2'});
		$('#data').load('<?=site_url()?>laporan/jurnaldata2/'+jenis+'/'+date+'/'+j_lap,function(){
			$('#loader-data').hide();
			$('#data').css({'background':'transparent','opacity':'1.0'});

		});
	}
	$('input#rekap_harian').datepicker({
		autoclose: true,
		todayHighlight: true
	}).on('changeDate', function(ev){
            // alert(ev.format());
			$('#loader-data').show();
            $('#data').load('<?=site_url()?>laporan/jurnaldata2/Harian/'+ev.format(),function(){
				$('#loader-data').hide();
		});
    });

	function jurnalnonsekolah(jenis,date)
	{
		$('#data').css({'background':'white','opacity':'0.2'});
		$('#loader-data').show();
        $('#data').load('<?=site_url()?>laporan/jurnaldata2/'+jenis+'/'+date+'/non',function(){
			$('#loader-data').hide();
			$('#data').css({'background':'transparent','opacity':'1.0'});
		});
	}
	function jurnalsekolah(jenis,date)
	{
		$('#data').css({'background':'white','opacity':'0.2'});
		$('#loader-data').show();
        $('#data').load('<?=site_url()?>laporan/jurnaldata2/'+jenis+'/'+date+'/sekolah',function(){
			$('#loader-data').hide();
			$('#data').css({'background':'transparent','opacity':'1.0'});
		});
	}
	$(document).keypress(function(e) {
		
		if(e.which == 100) {
			$('i#hapus-icon').each(function(){
				$(this).css({'display':'inline'});
			});
		}
		if(e.which == 101) {
			$('i#edit-icon').each(function(){
				$(this).css({'display':'inline'});
			});
		}
	});

	$('#nav-search-input').keyup(function(){
		var nama = $(this).val();
		nama = nama.replace(/ /g,'%20');
		if(nama=='')
			var nm='null';
		else
			var nm=nama;
		$('#loader-data').show();
            $('#data').load('<?=site_url()?>laporan/jurnaldata2/nama/'+nm,function(){
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
</style>
