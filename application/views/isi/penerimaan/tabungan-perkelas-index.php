<div class="main-container" id="main-container">
			<script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>

			<?=$this->load->view('layout/top-menu','',TRUE)?>

			<div class="main-content">
				<div class="main-content-inner">
					<div class="page-content">
						<div class="row">
							<form id="simpantabungankelas" style="width:100% !important" class="form-horizontal" action="" method="post">
							<div class="col-xs-7">
								<div class="page-header">
									<h1>
										Penerimaan
										<small>
											<i class="ace-icon fa fa-angle-double-right"></i>
											Data Tabungan Per Kelas
										</small>
									</h1>
								</div><!-- /.page-header -->	
								<div class="row">
									<div class="col-xs-12">
										<!-- PAGE CONTENT BEGINS -->

												<div style="border:1px solid #999;float:right;margin-bottom:5px;">
													<select class="chosen-select" id="kelas" name="kelas" data-placeholder="Data Kelas" >
													<option value=""></option>
													<option value="all">Semua Kelas</option>
													<?php								
														$tahun_ajaran=gettahunajaranbybulan(date('n'),date('Y'));	
														if(count($vbk)!=0)
														{
															foreach ($vbk as $k => $v) 
															{
																// $dSiswa=$vbs[$v->nis];
																if($v->tahun_ajaran==$tahun_ajaran)
																	echo '<option value="'.$v->id_batch.'">'.$v->nama_level.' - '.$v->nama_batch.'</option>';
															}
														}
													?>
													</select>			
													
												
											</div>
											
										<div id="data" style="width:100%;float:left;"></div>
										<!-- PAGE CONTENT ENDS -->
									</div><!-- /.col -->
								</div><!-- /.row -->			
							</div>
							<div class="col-xs-5" style="float:right">
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
										<div id="form"></div>
									</div><!-- /.col -->
								</div><!-- /.col -->

							</div>
						</div>
						</form>
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->

			<?=$this->load->view($footer,'',TRUE)?>
<script type="text/javascript">
	jQuery(function($){
		$('.chosen-select').chosen({allow_single_deselect:true}); 
		$('#data').load('<?=site_url()?>penerimaan/tabunganperkelasdata');
		$('#form').load('<?=site_url()?>penerimaan/tabunganperkelasform/-1');
		$('#kelas').change(function(){
			var id=$(this).val();
			$('#data').load('<?=site_url()?>penerimaan/tabunganperkelasdata/'+id);
		});
	});

	function edit(id)
	{
		$('#form').load('<?=site_url()?>penerimaan/tabunganperkelasform/'+id);
	}

	function hapus(id)
	{
		bootbox.confirm("<h3>Yakin Ingin Menghapus Data ini ?? </h3>", function(result) {
					if(result) 
					{
						$.ajax({
							url : '<?=site_url()?>penerimaan/tabunganperkelashapus/'+id,
							success : function(a)
							{
								// alert(a);
								tampilpesan(a);
								$('#data').load('<?=site_url()?>penerimaan/tabunganperkelasdata');
								$('#form').load('<?=site_url()?>penerimaan/tabunganperkelasform/-1');
							}
						});
					}
				});
	}

	function detailtabungan(id)
	{
		$.ajax({
			url : '<?=site_url()?>penerimaan/tabungandetail/'+id,
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