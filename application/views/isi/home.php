<div class="main-container" id="main-container">
			<script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>

			<?=$this->load->view('layout/top-menu','',TRUE)?>

			<div class="main-content">
				<div class="main-content-inner">
					<div class="page-content">

						<!-- /.page-header -->
						<div class="row">
							<div class="col-xs-12 col-sm-12">
								<div class="row">
									<div class="col-sm-8">
										<div class="widget-box transparent">
											<div class="widget-header widget-header-flat">
												<h4 class="widget-title lighter">
													<?=$title?>
												</h4>

											</div>

											<?=$this->load->view('isi/home/utama','',true)?>
										</div>
										<!-- PAGE CONTENT ENDS -->
									</div><!-- /.col -->
									<div class="col-sm-4">
										<div class="widget-box transparent">
											<div class="widget-header widget-header-flat">
												<h4 class="widget-title lighter">
													<i class="ace-icon fa fa-signal"></i>
													Jumlah Hari
												</h4>

											</div>

											<div class="widget-body">
												<div class="widget-main padding-6" >
													<div style="float:right;margin-bottom:5px;">
														Tahun <select class="chosen-select" id="tahun" name="tahun" data-placeholder="Tahun" style="width:100px;">
														<?php
														for ($i=(date('Y')-5); $i <=(date('Y')+1) ; $i++) {
															if(date('Y')==$i)
																echo '<option selected value="'.$i.'">'.$i.'</option>';
															else
																echo '<option value="'.$i.'">'.$i.'</option>';
														}
														?>
														</select>


													</div>
													<div style="float:left;margin-bottom:5px;margin-right:20px;">
														Level Program <select class="chosen-select" id="level_program" name="level_program" data-placeholder="Level Program" style="width:100px;">
															<option value="-1">-Semua Level-</option>
														<?php
														$level=array(
																'PS' => array('PG','TKA','TKB'),
																'SD' => array('Kelas 1','Kelas 2','Kelas 3','Kelas 4','Kelas 5','Kelas 6'),
																'SM' => array('Kelas 7','Kelas 8','Kelas 9')
														);
														foreach ($level as $k => $v)
														{
															echo '<optgroup label="'.$k.'">';
															foreach ($v as $kk => $vv)
															{
																echo '<option value="'.str_replace(' ','%20',$k.'__'.$vv).'">'.$vv.'</option>';
															}
															echo '</optgroup>';
														}
														?>
														</select>


													</div>
													<center>
														<div id="loader-he"><img src="<?=base_url()?>assets/img/loading-bl-blue.gif"></div>
													</center>
													<div id="datahariefeketif"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div><!-- /.row -->
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->

			<?=$this->load->view($footer,'',TRUE)?>
<script type="text/javascript">
	jQuery(function($){
			$('#loader-he').show();
			$('#datahariefeketif').load('<?=site_url()?>config/hariefektif/<?=date('Y')?>',function(){
				$('#loader-he').hide();
			});

			$('#tahun').change(function(){
				var id=$(this).val();
				var he=$('#level_program').val();
				$('#loader-he').show();
				$('#datahariefeketif').load('<?=site_url()?>config/hariefektif/'+id+'/'+he,function(){
					$('#loader-he').hide();
				});

			});

			$('#level_program').change(function(){
				var he=$(this).val();
				var id=$('#tahun').val();
				$('#loader-he').show();
				$('#datahariefeketif').load('<?=site_url()?>config/hariefektif/'+id+'/'+he,function(){
					$('#loader-he').hide();
				});

			});
	});

	function edithe(bulan,tahun,level)
	{
		// $('#loader-he').show();
		$.ajax({
			url : '<?=site_url()?>config/hariefektifform/'+bulan+'/'+tahun+'/'+level,
			success : function(aa)
			{
				bootbox.confirm(aa, function(result) {
					if(result)
					{
						// var bl=$().
						$.ajax({
							url : '<?=site_url()?>config/hariefektifproses',
							type : 'POST',
							data : $('#simpanhariefektif').serialize(),
							success : function(a)
							{
								// alert(a);
								$('#loader-he').show();
								$('#datahariefeketif').load('<?=site_url()?>config/hariefektif/'+tahun,function(){
									$('#loader-he').hide();
								});
								tampilpesan(a);
							}
						});
					}
				});
			}
		});
	}
</script>
<style type="text/css">
	#hariefektif tr, #hariefektif td
	{
		font-size:11px;
		padding:2px 5px !important;
	}
</style>
