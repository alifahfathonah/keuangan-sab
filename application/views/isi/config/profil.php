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
								Config
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Data Profil Sistem
								</small>
							</h1>
						</div><!-- /.page-header -->

						<div class="row">
							<div class="col-xs-12">
								<form class="form-horizontal" role="form" id="simpanprofil">
								<?php
								foreach ($d->result() as $k => $v) 
								{
									# code...
									$key=str_replace('_', ' ', $v->key);
									if($v->key!='logo')
									{

								?>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> <?=ucwords($key)?> </label>

										<div class="col-sm-9">
											<input type="text" id="<?=$v->key?>" name="<?=$v->key?>" placeholder="" class="col-xs-12 col-sm-4" value="<?=$v->value?>"/>
										</div>
									</div>
								<?php
									}
									else
									{
								?>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> <?=ucwords($key)?> </label>
										<div class="col-sm-3">
											<div class="input-group">
												<input readonly class="form-control input-mask-product" type="text" id="logos">
												<input readonly class="form-control input-mask-product" type="hidden" id="logo" name="logo">
												<span class="input-group-addon" style="cursor:pointer" onclick="BrowseServer( 'Images:/', 'fileInput' );">
													<i class="ace-icon fa fa-upload"></i>
												</span>
											</div>
										</div>	
									</div>	
								<?php		
									}
								}
								?>	
									
									<div class="clearfix form-actions">
										<div class="col-md-offset-3 col-md-9">
											<button class="btn btn-info" id="simpan" type="button">
											Simpan
											</button>
											&nbsp; &nbsp; &nbsp;
										</div>
									</div>

									<div class="hr hr-24"></div>
								</form>
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->

			<?=$this->load->view($footer,'',TRUE)?>
<script type="text/javascript">
			$("#simpan").on(ace.click_event, function() {
				bootbox.confirm("<h3>Apakah Data Profil ini sudah Benar? </h3>", function(result) {
					if(result) 
					{
						$.ajax({
							url : '<?=site_url()?>config/profilproses',
							type : 'POST',
							data : $('#simpanprofil').serialize(),
							success : function(a)
							{
								// alert(a);
								tampilpesan(a);
								location.href="<?=site_url()?>config/profil"
							}
						});
					}
				});
	});
</script>
<script type="text/javascript" src="<?=base_url()?>assets/ckfinder/ckfinder.js"></script>
<script type="text/javascript">
// This is a check for the CKEditor class. If not defined, the paths must be checked.
function BrowseServer( startupPath, functionData )
{
	var finder = new CKFinder();
	finder.basePath = '<?=base_url()?>assets/ckfinder/';
	finder.startupPath = startupPath;
	finder.selectActionFunction = SetFileField;
	finder.selectActionData = functionData;
	finder.removePlugins = 'basket';
	// finder.selectThumbnailActionFunction = ShowThumbnails;
	finder.popup();
}

function SetFileField( fileUrl, data )
{
	// alert(fileUrl);
	var f_name=fileUrl.split('/');
	var fn=f_name[(f_name.length)-1];
	// $('#logo').val(fileUrl);
	document.getElementById( 'logos' ).value = fn;
	document.getElementById( 'logo' ).value = fileUrl;
	//document.getElementById( 'thumbnails' ).innerHTML ='<img src="' + fileUrl + '" />';
	// alert(fn);
}
</script>