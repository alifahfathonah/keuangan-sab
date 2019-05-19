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
										Kelas
										<small>
											<i class="ace-icon fa fa-angle-double-right"></i>
											Data Kelas
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
							
						</div>
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->

			<?=$this->load->view($footer,'',TRUE)?>