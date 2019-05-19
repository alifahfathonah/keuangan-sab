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
										Pengeluaran
										<small>
											<i class="ace-icon fa fa-angle-double-right"></i>
											Data Tagihan
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
														Tagihan
													</a>
												</li>
											</ul>

											<div class="tab-content" style="min-height:400px !important;">
												<div id="home3" class="tab-pane in active">
													
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
	#siswa_chosen
	{
		width:100% !important;
	}
	label
	{
		font-size:11px !important;
	}
</style>