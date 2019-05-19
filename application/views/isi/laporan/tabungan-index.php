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
											Data Tagihan
										</small>
									</h1>
								</div>
							</div>
							
							<div class="col-xs-12">
								<!-- /.page-header -->

								
								<legend>Rekap Transaksi</legend>
													<div class="tabbable">
														<ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
															<li class="active">
																<a data-toggle="tab" href="#total">Total Tabungan</a>
															</li>
															<li class="">
																<a data-toggle="tab" href="#home4">Harian</a>
															</li>

															<li>
																<a data-toggle="tab" href="#profile4">Bulanan</a>
															</li>

															<li>
																<a data-toggle="tab" href="#dropdown14">Tahunan</a>
															</li>
															<!-- <li>
																<a data-toggle="tab" href="#perkelas">Per Kelas</a>
															</li> -->
														</ul>

														<div class="tab-content" style="padding-top: 5px !important;float:left;width:100%" >
																
															<div id="total" class="tab-pane in active">
																<div class="form-group" style="margin-bottom:0px !important;padding-top:0px !important">
																	<label class="col-sm-10 control-label no-padding-right" for="form-field-1" style="text-align:right;padding-top:5px !important">Level </label>

																	<div class="col-sm-2" style="text-align:left;">
																		
																			<select class="chosen-select" id="kelas" name="kelas" data-placeholder="Data Kelas" onchange="gettotal()">
																				<!-- <option value=""></option> -->
																				<option value="all" selected="selected">Keseluruhan</option>
																				<?php	
																				$vbk=$this->config->item('levelkelas');								
																					if(count($vbk)!=0)
																					{
																						foreach ($vbk as $k => $v) 
																						{
																							// $dSiswa=$vbs[$v->nis];
																							$n_level=str_replace(' ', '%20', $v->nama_level);
																							echo '<option value="'.$v->id_level.'_'.$n_level.'">'.$v->nama_level.'</option>';
																						}
																					}
																				?>
																			</select>			
																				
																			
																		
																	</div>
																</div>
																<div id="id_grafik_total" class="tab-pane in active">
																</div>
															</div>
															<div id="home4" class="tab-pane in">
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
																			<a data-toggle="tab" href="#id_grafik_harian">
																				Grafik Harian
																			</a>
																		</li>
																	</ul>

																	<div class="tab-content">
																		<div id="id_grafik_harian" class="tab-pane in active"></div>

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
																			<?
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
																			<?
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
																			<a data-toggle="tab" href="#id_grafik_bulanan">
																				Grafik Bulanan
																			</a>
																		</li>


																	</ul>

																	<div class="tab-content">
																		<div id="id_grafik_bulanan" class="tab-pane in active"></div>

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
																			<?
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
																			<a data-toggle="tab" href="#id_grafik_tahunan">
																				Grafik Tahunan
																			</a>
																		</li>

																	</ul>

																	<div class="tab-content">
																		<div id="id_grafik_tahunan" class="tab-pane in active"></div>

																	</div>
																</div>
															</div>
															<!-- <div id="perkelas" class="tab-pane">
																<div class="row">
																	<div class="col-xs-12">Per Kelas</div>
																</div>
															</div> -->
														</div>
													</div>
												</div>
							</div>
							
						</div>
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->
			
<script type="text/javascript">
$('.chosen-select').chosen({allow_single_deselect:true}); 
	$('input#rekap_harian').datepicker({
		autoclose: true,
		todayHighlight: true
	}).on('changeDate', function(ev){
            // alert(ev.format());
		$('div#id_grafik_harian').load('<?=site_url()?>laporan/tabungandata/harian/'+ev.format()+'/1');
    });
	$('div#id_grafik_harian').load('<?=site_url()?>laporan/tabungandata/harian/-1/1');
	$('div#id_grafik_bulanan').load('<?=site_url()?>laporan/tabungandata/bulanan/-1/1');
	$('div#id_grafik_tahunan').load('<?=site_url()?>laporan/tabungandata/tahunan/-1/1');
	$('div#id_grafik_total').load('<?=site_url()?>laporan/tabungandata/total/all/1');

	function gettotal()
	{
		var level=$('#kelas').val();
		$('div#id_grafik_total').load('<?=site_url()?>laporan/tabungandata/total/'+level+'/1');
	}

	function getrekaptahunan()
	{
		var tahun=$('#tahunan').val();
		$('div#id_grafik_tahunan').load('<?=site_url()?>laporan/tabungandata/tahunan/'+tahun+'/1');
	}

	function getrekapbulanan()
	{
		var tahun=$('#tahun').val();
		var bulan=$('#bulan').val();
		$('div#id_grafik_bulanan').load('<?=site_url()?>laporan/tabungandata/bulanan/'+bulan+'-'+tahun+'/1');
	}
</script>
<style type="text/css">
	#kelas_chosen
	{
		width:190px !important;
	}
</style>