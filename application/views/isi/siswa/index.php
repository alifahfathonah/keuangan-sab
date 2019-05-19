<div class="main-container" id="main-container">
			<script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>

			<?=$this->load->view('layout/top-menu','',TRUE)?>

			<div class="main-content">
				<div class="main-content-inner">
					<div class="page-content">

						<div class="page-header">
							<h1>
								<?=$title?>
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Data Siswa
								</small>
							</h1>
						</div><!-- /.page-header -->

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<div style="border:1px solid #999;float:right;margin-bottom:5px;">
									<form class="navbar-form navbar-left form-search" role="search" style="padding:4px !important;margin:0px !important;">
										<div class="form-group">
											<input type="text" id="cariva" placeholder="Cari Virtual Account" style="width:200px" />
										</div>

										<button type="button" class="btn btn-mini btn-info2">
											<i class="ace-icon fa fa-search icon-only bigger-110"></i>
										</button>
									</form>
									<form class="navbar-form navbar-left form-search" role="search" style="padding:4px !important;margin:0px !important;margin-left:10px;">
										<div class="form-group">
											<input type="text" id="cari" placeholder="Cari NIS atau Nama Siswa" style="width:200px" />
										</div>

										<button type="button" class="btn btn-mini btn-info2">
											<i class="ace-icon fa fa-search icon-only bigger-110"></i>
										</button>
									</form>
								</div>
								<center>
									<div id="loader-data"><img src="<?=base_url()?>assets/img/loading-bl-blue.gif"></div>
								</center>
								<div id="data"></div>
								<!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->

			<?=$this->load->view($footer,'',TRUE)?>
<script type="text/javascript">
	// jQuery(function($){
		$('#loader-data').show();
		$('#data').load('<?=site_url()?>siswa/data/null',function(){
			$('#loader-data').hide();
		});
		$('#cari').keyup(function(){
			$('#loader-data').show();
			var v=$(this).val().replace(/ /g,'%20');
			$('#data').load('<?=site_url()?>siswa/data/'+v,function(){
				$('#loader-data').hide();
			});
		});
		
		$('#cariva').keyup(function(){
			$('#loader-data').show();
			var v=$(this).val().replace(/ /g,'%20');
			$('#data').load('<?=site_url()?>siswa/datava/'+v,function(){
				$('#loader-data').hide();
			});
		});
	// });
</script>
