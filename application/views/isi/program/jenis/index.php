<div class="main-container" id="main-container">
			<script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>

			<?=$this->load->view('layout/top-menu','',TRUE)?>

			<div class="main-content">
				<div class="main-content-inner">
					<div class="page-content">
						<div class="row">
							<div class="col-xs-8">
								<div class="page-header">
									<h1>
										Data Program
										<small>
											<i class="ace-icon fa fa-angle-double-right"></i>
											Data 
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
		// $('#loader-form').show();
		// $('#data').load('<?=site_url()?>program/programdata',function(){
		// 	$('#loader-data').hide();
		// });
		data()
		edit(-1);
       
	});
	// function form(id)
	// {
	// 	$('#form').load('<?=site_url()?>program/programform/'+id,function(){
	// 		$('#loader-form').hide();
    //          $('.chosen-select').chosen({allow_single_deselect:true});
	// 	});
	// }
	function data()
	{
		$('#loader-form').show();
		$('#data').load('<?=site_url()?>program/programdata',function(){
			$('#loader-data').hide();
		});
	}
	function edit(id)
	{
		$('#loader-form').show();
		$('#form').load('<?=site_url()?>program/programform/'+id,function(){
			$('#loader-form').hide();
             $('.chosen-select').chosen({allow_single_deselect:true});
		});
	}

	function hapus(id)
	{
		bootbox.confirm("<h3>Yakin Ingin Menghapus Data ini ?? </h3>", function(result) {
					if(result)
					{
						$.ajax({
							url : '<?=site_url()?>program/programhapus/'+id,
							success : function(a)
							{
								// alert(a);
								tampilpesan(a);
								data();
								edit(-1);
							}
						});
					}
				});
	}
</script>
