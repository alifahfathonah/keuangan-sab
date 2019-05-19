								<div class="" style="margin-top:10px">
									<div id="user-profile-2" class="user-profile">
										<div class="tabbable">
											<ul class="nav nav-tabs padding-18">
												<li class="active">
													<a data-toggle="tab" href="#home">
														<i class="green ace-icon glyphicon glyphicon-signal"></i>
														&nbsp;
													</a>
												</li>

												<li>
													<a data-toggle="tab" href="#pictures">
														<i class="orange ace-icon fa fa-users bigger-120"></i>
														Pendaftaran Siswa Baru
													</a>
												</li>
												<li>
													<a data-toggle="tab" href="#du">
														<i class="blue ace-icon fa fa-users bigger-120"></i>
														Daftar Ulang Siswa Lama
													</a>
												</li>

											</ul>

											<div class="tab-content no-border padding-24">
												<div id="home" class="tab-pane in active">
													<div class="row">
														<div class="col-xs-12 col-sm-12 center">
															<span class="profile-picture">
																<!-- <img class="editable img-responsive" alt="Alex's Avatar" id="avatar2" src="assets/avatars/profile-pic.jpg" /> -->
																<img class="editable img-responsive" alt="Logo Sekolah Alam Bogor" id="avatar2" src="assets/img/logo.png" />
															</span>

															<div class="space space-4"></div>

															<a href="#" class="btn btn-sm btn-block btn-success">
																<!-- <i class="ace-icon fa fa-plus-circle bigger-120"></i> -->
																<span class="bigger-110">Sekolah Alam Bogor</span>
															</a>

															<!-- <a href="#" class="btn btn-sm btn-block btn-primary">
																<i class="ace-icon fa fa-envelope-o bigger-110"></i>
																<span class="bigger-110">Send a message</span>
															</a> -->
														</div><!-- /.col -->

													</div><!-- /.row -->

													<!-- <div class="space-12"></div> -->


												</div><!-- /#home -->

												<div id="pictures" class="tab-pane">
													<center>
														<div id="loader-baru"><img src="<?=base_url()?>assets/img/loading-bl-blue.gif"></div>
													</center>
													<div class="col-sm-12" id="baru"></div><!-- /.col -->
													<!-- <div class="space-12"></div> -->
												</div><!-- /#feed -->


												<div id="du" class="tab-pane">
													<center>
														<div id="loader-du"><img src="<?=base_url()?>assets/img/loading-bl-blue.gif"></div>
													</center>
													<div class="col-sm-12" id="dus"></div><!-- /.col -->
													<!-- <div class="space-12"></div> -->
												</div><!-- /#pictures -->
											</div>
										</div>
									</div>
								</div>
<script type="text/javascript">
	$('#loader-baru').show();
	$('#loader-du').show();
	$('#baru').load('<?=site_url()?>penerimaan/pendftaran/baru/-1',function(){
		$('#loader-baru').hide();
	});
	$('#dus').load('<?=site_url()?>penerimaan/pendftaran/du/-1',function(){
		$('#loader-du').hide();
	});
</script>
