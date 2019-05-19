<div class="main-container" id="main-container">
			<script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>

			<?php echo $this->load->view('layout/top-menu','',TRUE);?>

			<div class="main-content">
				<div class="main-content-inner">
					<div class="page-content">
						<div class="row">
							<div class="col-xs-12 col-lg-8 col-md-8">
								<div class="page-header">
									<h1>
										Penerimaan
										<small>
											<i class="ace-icon fa fa-angle-double-right"></i>
											Data Tabungan Siswa
										</small>
									</h1>
								</div><!-- /.page-header -->

								<div class="row">
									<div class="col-xs-12">
										<!-- PAGE CONTENT BEGINS -->

												<!-- <div style="border:1px solid #999;float:right;margin-bottom:5px;">
													<select class="chosen-select" id="siswa" name="siswa" data-placeholder="Data Siswa" >
													<option value=""></option>
													<?php
														if(count($dd)!=0)
														{
															foreach ($dd as $k => $v)
															{
																$dSiswa=$vbs[$v->nis];
																echo '<option value="'.$v->id.'">'.$v->nama_murid.' ('.$dSiswa->nama_batch.')</option>';
															}
														}
													?>
													</select>


											</div> -->
											<center>
												<div id="loader-data"><img src="<?php echo base_url();?>assets/img/loading-bl-blue.gif"></div>
											</center>
										<div id="data" style="width:100%;float:left;"></div>
										<!-- PAGE CONTENT ENDS -->
									</div><!-- /.col -->
								</div><!-- /.row -->

							</div>
							<div class="col-xs-12 col-lg-4 col-md-4" style="float:right">
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
											<div id="loader-form"><img src="<?php echo base_url();?>assets/img/loading-bl-blue.gif"></div>
										</center>
										<div id="form"></div>
									</div><!-- /.col -->
								</div><!-- /.col -->

							</div>
						</div>
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->

			<?php echo $this->load->view($footer,'',TRUE);?>
<script type="text/javascript">
	jQuery(function($){
		$('.chosen-select').chosen({allow_single_deselect:true});

		$('#loader-data').show();
		$('#loader-form').show();
		$('#data').load('<?php echo site_url();?>penerimaan/tabungandata',function(){
			$('#loader-data').hide();
		});
		$('#form').load('<?php echo site_url();?>penerimaan/tabunganform/-1',function(){
			$('#loader-form').hide();
		});
		$('#siswa').change(function(){
			var id=$(this).val();
			$('#loader-data').show();
			$('#data').load('<?php echo site_url();?>penerimaan/tabungandata/'+id,function(){
				$('#loader-data').hide();
			});
		});
	});
	function edit(id)
	{
		$('#loader-form').show();
		$('#form').load('<?php echo site_url();?>penerimaan/tabunganform/'+id,function(){
			$('#loader-form').hide();
		});
	}

	function hapus(id)
	{
		bootbox.confirm("<h3>Yakin Ingin Menghapus Data Siswa ini ?? </h3>", function(result) {
					if(result)
					{
						$.ajax({
							url : '<?php echo site_url();?>penerimaan/tabunganhapus/'+id,
							success : function(a)
							{
								// alert(a);
								tampilpesan(a);
								$('#loader-data').show();
								$('#loader-form').show();
								$('#data').load('<?php echo site_url();?>penerimaan/tabungandata',function(){
									$('#loader-data').hide();
								});
								$('#form').load('<?php echo site_url();?>penerimaan/tabunganform/-1',function(){
									$('#loader-form').hide();
								});
							}
						});
					}
				});
	}

	function detailtabungan(id)
	{
		$.ajax({
			url : '<?php echo site_url();?>penerimaan/tabungandetail/'+id,
			success : function(a)
			{
				bootbox.alert({
					size : "large",
					message : a,
					title : "Detail Tabungan",
					callback: function(){}
				});
			}
		});

	}
</script>
<style type="text/css">
	#siswa_chosen
	{
		width:350px !important;
	}
	</style>
