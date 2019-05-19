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
										 Tagihan
										<small>
											<i class="ace-icon fa fa-angle-double-right"></i>
											Kirim Tagihan
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
										<div id="form"></div>
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
		$('#loader-data').show();
		$('#loader-form').show();
		$('#data').load('<?=site_url()?>tagihan/data/-1',function(){
			$('#loader-data').hide();
		});
		$('#form').load('<?=site_url()?>tagihan/form/-1',function(){
			$('#loader-form').hide();
		});
	});
</script>