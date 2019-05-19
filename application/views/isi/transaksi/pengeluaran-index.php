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
											Pengeluaran
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
													<a data-toggle="tab" href="#home3">
														<i class="pink ace-icon glyphicon glyphicon-tag bigger-110"></i>
														Pengeluaran
													</a>
												</li>
												<li>
													<a data-toggle="tab" href="#profile3">
														<i class="blue ace-icon glyphicon  glyphicon-tags bigger-110"></i>
														Transaksi Bank
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
												<div id="home3" class="tab-pane in active">
													<form class="form-horizontal" id="simpanpengeluaran" method="post" action="<?=site_url()?>transaksi/pengeluaranproses">

														<legend>Form Transanksi Pengeluaran</legend>
														<?php
														$data['jenis']=$jenis;
														?>
														<?=$this->load->view('isi/transaksi/pengeluaran-form',$data,TRUE)?>

														<div class="hr hr-24"></div>
													</form>
												</div>
												<div id="profile3" class="tab-pane in">
													<form class="form-horizontal" action="<?=site_url()?>transaksi/pengeluaranbank" id="simpanpengeluaranbank" method="post">
														<legend>Form Pengeluaran Bank</legend>
														<?php
															$data['bank']=$bank;
														?>
														<?=$this->load->view('isi/transaksi/pengeluaran-bank',$data,TRUE)?>

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

															<li>
																<a data-toggle="tab" href="#dropdown14">Tahunan</a>
															</li>
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

																	</ul>

																	<div class="tab-content">
																		<div id="id_rekap_harian" class="tab-pane in active"></div>

																		<div id="id_grafik_harian" class="tab-pane"></div>

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

																	</ul>

																	<div class="tab-content">
																		<div id="id_rekap_bulanan" class="tab-pane in active"></div>

																		<div id="id_grafik_bulanan" class="tab-pane"></div>

																	</div>
																</div>
															</div>

															<div id="dropdown14" class="tab-pane">
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
																	
																		<!-- PAGE CONTENT BEGINS -->
																		
																	</div><!-- /.col -->
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

																	</ul>

																	<div class="tab-content">
																		<div id="id_rekap_tahunan" class="tab-pane in active"></div>

																		<div id="id_grafik_tahunan" class="tab-pane"></div>

																	</div>
																</div>
															</div>
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
	#jenispengeluaran_chosen
	{
		width:100% !important;
	}
	label
	{
		font-size:11px !important;
	}
</style>
<script type="text/javascript">
	$('div#id_rekap_harian').load('<?=site_url()?>transaksi/rekap/pengeluaran/harian');
	$('div#id_grafik_harian').load('<?=site_url()?>transaksi/rekap/pengeluaran/harian/-1/1');
	$('div#id_grafik_bulanan').load('<?=site_url()?>transaksi/rekap/pengeluaran/bulanan/-1/1');
	$('div#id_grafik_tahunan').load('<?=site_url()?>transaksi/rekap/pengeluaran/tahunan/-1/1');

	$('div#id_rekap_bulanan').load('<?=site_url()?>transaksi/rekap/pengeluaran/bulanan');
	$('div#id_rekap_tahunan').load('<?=site_url()?>transaksi/rekap/pengeluaran/tahunan');
	$('.chosen-select').chosen({allow_single_deselect:true});
	$('#jumlah').each(function(a){
		$(this).keyup(function(){
			$(this).formatCurrency({symbol:''});
		});
	});

	$('#submit').click(function(){
			bootbox.confirm("<h3>Apakah Data Transaksi ini sudah Benar </h3>", function(result) {
					if(result) 
					{
						$.ajax({
							url : '<?=site_url()?>transaksi/pengeluaranprocess',
							type : 'POST',
							data : $('#simpanpengeluaran').serialize(),
							success : function(a){
								//tampilpesan(a);
								setTimeout(function(){ location.href='<?=site_url()?>transaksi/pengeluaran'; }, 1000);
							}	
						});
						// alert('aa');
						// $('form#simpanpengeluaran').submit();
					}
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
		$('div#id_rekap_harian').load('<?=site_url()?>transaksi/rekap/pengeluaran/harian/'+ev.format());
		$('div#id_grafik_harian').load('<?=site_url()?>transaksi/rekap/pengeluaran/harian/'+ev.format()+'/1');
    });

	function getrekaptahunan()
	{
		var tahun=$('#tahunan').val();
		$('div#id_rekap_tahunan').load('<?=site_url()?>transaksi/rekap/pengeluaran/tahunan/'+tahun);
		$('div#id_grafik_tahunan').load('<?=site_url()?>transaksi/rekap/pengeluaran/tahunan/'+tahun+'/1');
	}

	function getrekapbulanan()
	{
		var tahun=$('#tahun').val();
		var bulan=$('#bulan').val();
		$('div#id_rekap_bulanan').load('<?=site_url()?>transaksi/rekap/pengeluaran/bulanan/'+bulan+'-'+tahun);
		$('div#id_grafik_bulanan').load('<?=site_url()?>transaksi/rekap/pengeluaran/bulanan/'+bulan+'-'+tahun+'/1');
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
	}

	// $("#simpanbank").on(ace.click_event, function() {
	// 			bootbox.confirm("<h3>Apakah Data Transaksi ini sudah Benar </h3>", function(result) {
	// 				if(result) 
	// 				{
	// 					$('form#simpanpengeluaranbank').submit();

	// 				}
	// 			});
	// 		});
	

</script>