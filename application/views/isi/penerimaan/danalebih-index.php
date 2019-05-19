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
										Penerimaan
										<small>
											<i class="ace-icon fa fa-angle-double-right"></i>
											Data Dana Lebih Siswa
										</small>
									</h1>
								</div><!-- /.page-header -->

								<div class="row">
									<div class="col-xs-12">
										<!-- PAGE CONTENT BEGINS -->

											
												<!-- <div style="float:right;margin-bottom:5px;">
													<select class="chosen-select" id="kelas" name="kelas" data-placeholder="Data Kelas">
													<option value=""></option>
													<?php
														$kelas=$this->config->item('vbatchkelas');
														if(count($kelas)!=0)
														{
															foreach ($kelas as $k => $v)
															{
																echo '<option value="'.$v->id_batch.'__'.str_replace(' ', '%20', $v->nama_batch).'">'.$v->nama_batch.'</option>';
															}
														}
													?>
													</select>


											</div> -->
											<center>
												<div id="loader-data"><img src="<?=base_url()?>assets/img/loading-bl-blue.gif"></div>
											</center>
										<div id="data" style="width:100%;float:left;"></div>
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
										<div id="form"></div>
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
		$('.chosen-select').chosen({allow_single_deselect:true});
		$('#loader-data').show();
		$('#loader-form').show();
		$('#data').load('<?=site_url()?>penerimaan/danalebihdata',function(){
			$('#loader-data').hide();
		});
		$('#form').load('<?=site_url()?>penerimaan/danalebihform/-1',function(){
			$('#loader-form').hide();
		});
		$('#catering').change(function(){
			var id=$(this).val();
			var kelasid=$('#kelas').val();

			$('#data').load('<?=site_url()?>penerimaan/danalebihdata/'+id,function(){
				$('#loader-data').hide();
			});
		});

		$('#kelas').change(function(){
			var kelasid=$(this).val();
			var id=$('#catering').val();
			$('#loader-data').show();
			$('#data').load('<?=site_url()?>penerimaan/danalebihdata/'+id,function(){

				$('#loader-data').hide();
			});
		});
	});
	function edit(id)
	{
		$('#loader-form').show();
		$('#form').load('<?=site_url()?>penerimaan/danalebihform/'+id,function(){

			$('#loader-form').hide();
		});
	}
	function hapus(id)
	{
		bootbox.confirm("<h3>Yakin Ingin Menghapus Data Dana Lebih Siswa ini ?? </h3>", function(result) {
					if(result)
					{
						$.ajax({
							url : '<?=site_url()?>penerimaan/danalebihhapus/'+id,
							success : function(a)
							{
								// alert(a);
								tampilpesan(a);
								$('#loader-data').show();
								$('#loader-form').show();
								$('#data').load('<?=site_url()?>penerimaan/danalebihdata',function(){
									$('#loader-data').hide();
								});
								$('#form').load('<?=site_url()?>penerimaan/danalebihform/-1',function(){
									$('#loader-form').hide();
								});
							}
						});
					}
				});
	}
</script>
<style type="text/css">
	#catering_chosen
	{
		width:240px !important;
	}
	</style>
