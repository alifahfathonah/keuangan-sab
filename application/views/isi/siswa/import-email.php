<div class="main-container" id="main-container">
			<script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>

			<?=$this->load->view('layout/top-menu','',TRUE)?>

			<div class="main-content">
				<div class="main-content-inner">
					<div class="page-content">
						<div class="row">
							<div class="col-xs-9">
								<div class="page-header">
									<h1>
										 Import 
										<small>
											<i class="ace-icon fa fa-angle-double-right"></i>
											Data Email
										</small>
									</h1>
								</div><!-- /.page-header -->

								<div class="row">
									<div class="col-xs-12">
										<!-- PAGE CONTENT BEGINS -->
										<center>
											<div id="loader-data"><img src="<?=base_url()?>assets/img/loading-bl-blue.gif"></div>
										</center>
										<div id="data"></div>
										<!-- PAGE CONTENT ENDS -->
									</div><!-- /.col -->
								</div><!-- /.row -->

							</div>
							<div class="col-xs-3" style="float:right">
								<div class="page-header">
									<h1>
										<small>
											<i class="ace-icon fa fa-angle-double-right"></i>
											Form
										</small>
									</h1>

								</div><!-- /.col -->
								<div class="row">
									<div class="col-xs-12">
										<center>
											<div id="loader-form"><img src="<?=base_url()?>assets/img/loading-bl-blue.gif"></div>
										</center>
										<div id="form">
											<form class="form-horizontal" method="post" role="form" id="importemail" action="<?=site_url()?>siswa/importemail" enctype="multipart/form-data">
												<div class="form-group">
													<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Upload XLS File </label>

													<div class="col-sm-9">
														<input type="file" id="file" name="file" placeholder="Level" class="col-xs-12 col-sm-12" />
													</div>
												</div>

												
												
												<div class="clearfix form-actions">
													<div class="col-md-offset-3 col-md-9">
														<button class="btn btn-info" id="simpan" type="button">			
															<i class="ace-icon fa fa-check bigger-110"></i> OK
														</button>
														
													</div>
												</div>

												<div class="hr hr-24"></div>
											</form>
										</div>
									</div><!-- /.col -->
								</div><!-- /.col -->

							</div>
						</div>
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->

			<?=$this->load->view($footer,'',TRUE)?>
<script>
    jQuery(function($){
		$('#loader-data').hide();
		$('#loader-form').hide();
		// $('#data').load('<?=site_url()?>tagihan/data/-1',function(){
		// 	$('#loader-data').hide();
		// });
		// $('#form').load('<?=site_url()?>tagihan/form/-1',function(){
		// 	$('#loader-form').hide();
		// });
	});
</script>