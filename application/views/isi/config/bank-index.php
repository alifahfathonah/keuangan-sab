<div class="main-container" id="main-container">
			<script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>

			<?=$this->load->view('layout/top-menu','',TRUE)?>

			<div class="main-content">
				<div class="main-content-inner">
					<div class="page-content">
						<div class="row">
							<div class="col-xs-7">
								<div class="page-header">
									<h1>
										Config
										<small>
											<i class="ace-icon fa fa-angle-double-right"></i>
											Data Bank
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
							<div class="col-xs-4" style="float:right">
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

										</div>
									</div><!-- /.col -->
								</div><!-- /.col -->

							</div>
						</div>
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->

			<?=$this->load->view($footer,'',TRUE)?>
<script type="text/javascript">
	jQuery(function($){
		$('#loader-data').show();
		$('#loader-form').show();
		$('#data').load('<?=site_url()?>config/bankdata',function(){
			$('#loader-data').hide();
		});
		$('#form').load('<?=site_url()?>config/bankform/-1',function(){
			$('#loader-form').hide();
		});
	});
	function edit(id)
	{
		$('#loader-form').show();
		$('#form').load('<?=site_url()?>config/bankform/'+id,function(){
			$('#loader-form').hide();

		});
	}

	function hapus(id)
	{
		bootbox.confirm("<h3>Yakin Ingin Menghapus Data ini ?? </h3>", function(result) {
					if(result)
					{
						$.ajax({
							url : '<?=site_url()?>config/bankhapus/'+id,
							success : function(a)
							{
								// alert(a);
								tampilpesan(a);
								$('#loader-data').show();
								$('#loader-form').show();
								$('#data').load('<?=site_url()?>config/bankdata',function(){
									$('#loader-data').hide();
								});
								$('#form').load('<?=site_url()?>config/bankform/-1',function(){
									$('#loader-form').hide();
								});
							}
						});
					}
				});
	}
</script>
