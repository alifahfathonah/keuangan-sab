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
										Kegiatan
										<small>
											<i class="ace-icon fa fa-angle-double-right"></i>
											Data 
										</small>
									</h1>
								</div><!-- /.page-header -->

								<div class="row">
									<div class="col-xs-7 pull-right">
										<div class="pull-right">Sasaran Mutu</div>
										<select id="sasaran_mutu" name="sasaran_mutu"  data-rel="chosen" class="col-xs-8 col-sm-8 col-md-8 chosen-select">
											<option value="0">--Pilih--</option>
											<?php		
											foreach ($sasaranmutu as $k => $v) 
											{
												if($id!=-1)
												{
													if($id==$v->id)
														echo '<option selected="selected" value="'.$id.'">'.ucwords($v->sasaran_mutu).'</option>';
													else
														echo '<option value="'.$v->id.'">'.ucwords($v->sasaran_mutu).'</option>';
												}
												else
													echo '<option value="'.$v->id.'">'.ucwords($v->sasaran_mutu).'</option>';
											}
											?>
										</select>
									</div>
									<div class="col-xs-12">

										<!-- PAGE CONTENT BEGINS -->
										<center>
											<div id="loader-data" style="position:absolute;width:100%"><img src="<?=base_url()?>assets/img/loading-bl-blue.gif" style="margin:0 auto !important"></div>
										</center>
										<div id="data" style="margin-top:10px;width:100%;"></div>
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
											<div id="loader-form" style="position:absolute;width:100%"><img src="<?=base_url()?>assets/img/loading-bl-blue.gif" style="margin:0 auto !important"></div>
										</center>
										<div id="form" style="margin-top:10px;width:95%;position:absolute;z-index:100">

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
		// $('#data').load('<?=site_url()?>kegiatan/data',function(){
		// 	$('#loader-data').hide();
		// });
		data('<?=$id?>')
		edit(-1);
		$('#sasaran_mutu').on('change',function(){
			var id=$(this).val();
			if(id==0)
				data(-1);
			else
				data(id);
			$('#loader-form').hide();
		});
	});
	// function form(id)
	// {
	// 	$('#form').load('<?=site_url()?>kegiatan/form/'+id,function(){
	// 		$('#loader-form').hide();
    //          $('.chosen-select').chosen({allow_single_deselect:true});
	// 	});
	// }
	function data(id)
	{
		$('#data').css('opacity','0.2');
		$('#loader-form').show();
		$('#data').load('<?=site_url()?>kegiatan/data/'+id,function(){
			$('#loader-data').hide();
			$('#data').css('opacity','1.0');
		});
	}
	function edit(id)
	{
		$('#loader-form').show();
		$('#form').css('opacity','0.2');
		$('#form').load('<?=site_url()?>kegiatan/form/'+id,function(){
			$('#loader-form').hide();
			$('#form').css('opacity','1.0');
             $('.chosen-select').chosen({allow_single_deselect:true});
		});
	}

	function hapus(id)
	{
		bootbox.confirm("<h3>Yakin Ingin Menghapus Data ini ?? </h3>", function(result) {
					if(result)
					{
						$.ajax({
							url : '<?=site_url()?>kegiatan/hapus/'+id,
							success : function(a)
							{
								// alert(a);
								tampilpesan(a);
								$('#loader-data').show();
								$('#loader-form').show();
								load(-1);
								edit(-1);
							}
						});
					}
				});
	}
</script>
