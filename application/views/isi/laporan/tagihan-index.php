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
							<div class="col-xs-2">
								<div class="row">
									<div class="col-xs-12">
										<div class="dd" >
											<ol class="dd-list">
												<?php
												foreach ($lk as $k => $v)
												{
												?>
													<li class="dd-item dd-collapsed" data-id="<?=$k?>">
														<div class="dd-handle">
															<?=$v->nama_level?>
														</div>
														<ol class="dd-list">
												<?php
													$x=1;
												if(isset($bt[$v->id_level]))
												{
													foreach ($bt[$v->id_level] as $kl => $vl) {
														# code...
												?>
														<li class="dd-item item-orange" data-id="<?=$x?>" style="cursor:pointer;">
															<div class="kolom">
																<a href="#" onclick="javascript:datakelas('<?=$vl->id_batch?>')">
																<?=$vl->nama_batch?>
																</a>
															</div>
														</li>
												<?php	# code...
													$x++;
													}
												}
												?>
															</ol>
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
									&nbsp;
									</div>
									<div class="col-xs-4">

										<div style="float:right;margin-bottom:5px;">
											<select class="" id="bulan" name="bulan" data-placeholder="Bulan" onchange="getdatatagihan()">
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
											<select class="" id="tahun" name="tahun" data-placeholder="Tahun" onchange="getdatatagihan()" style="width:100px !important;">
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
								</div><!-- /.row -->
								<div class="row">
									<div class="col-xs-12">
										<center>
											<div id="loader-data"><img src="<?=base_url()?>assets/img/loading-bl-blue.gif"></div>
										</center>
										<div id="data" style="border:1px solid #ddd;padding:15px;">Silahkan Pilih Data Kelas Terlebih Dahulu</div>
									</div>
								</div>

							</div>

						</div>
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->
			<input type="hidden" name="batch_id" id="batch_id">
			<?=$this->load->view($footer,'',TRUE)?>
<script type="text/javascript">
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

	function getdatatagihan()
	{
		var bulan=$('#bulan').val();
		var tahun=$('#tahun').val();
		var batch_id=$('input#batch_id').val();
		$('#loader-data').show();
		$('#data').load('<?=site_url()?>laporan/datatagihan/'+batch_id+'/'+bulan+'/'+tahun,function(){

			$('#loader-data').hide();
		});

	}
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
