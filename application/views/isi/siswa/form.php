<div class="main-container" id="main-container">
			<script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>

			<?=$this->load->view('layout/top-menu','',TRUE)?>

			<div class="main-content">
				<div class="main-content-inner">
					<div class="page-content">

						<!-- /.page-header -->

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<div class="row">
									<div class="col-xs-8">
										<div class="page-header">
											<h1>
											Siswa
												<small>
													<i class="ace-icon fa fa-angle-double-right"></i>
													
												<?=$title?>
												</small>
											</h1>
										</div>
										<form class="form-horizontal" role="form" action="<?=site_url()?>siswa/proses/<?=$id?>" method="POST">
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> NIS </label>

												<div class="col-sm-3">
													<input type="text" id="nis" placeholder="NIS" name="nis" class="col-xs-10 col-sm-7" value="<?=($id!=-1 ? $dd[0]->nis : '')?>"/>
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> NISN </label>

												<div class="col-sm-3">
													<input type="text" id="nisn" placeholder="NISN" name="nisn" class="col-xs-10 col-sm-7" value="<?=($id!=-1 ? $dd[0]->nisn : '')?>"/>
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Nomor Virtual Account </label>

												<div class="col-sm-3">
													<input type="text" id="no_virtual_account" placeholder="Nomor Virtual Account" name="no_virtual_account" class="col-xs-10 col-sm-7" value="<?=($id!=-1 ? $dd[0]->no_virtual_account : '')?>"/>
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Nama Lengkap </label>

												<div class="col-sm-9">
													<input type="text" id="nama_murid" placeholder="Nama Lengkap" name="nama_murid" class="col-xs-10 col-sm-7" required="" oninvalid="this.setCustomValidity('Nama Siswa Harus Diisi')" value="<?=($id!=-1 ? $dd[0]->nama_murid : '')?>"/>
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Nama Panggilan </label>

												<div class="col-sm-9">
													<input type="text" id="nama_panggilan" name="nama_panggilan" placeholder="Nama Panggilan" class="col-xs-10 col-sm-7" value="<?=($id!=-1 ? $dd[0]->nama_panggilan : '')?>" />
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tempat / Tanggal Lahir </label>

												<div class="col-sm-9">
													<input type="text" id="tempat_lahir" name="tempat_lahir" placeholder="Tempat Lahir" class="col-xs-10 col-sm-4" style="margin-right:5px !important;"  value="<?=($id!=-1 ? $dd[0]->tempat_lahir : '')?>" />
													<div class="input-group" style="width:100px !important;">
														<input  id="tanggal_lahir" name="tanggal_lahir" type="text" data-date-format="dd-mm-yyyy" style="width:110px !important;" placeholder="Tgl Lahir" oninvalid="this.setCustomValidity('Tanggal Lahir Harus Diisi')"  value="<?=($id!=-1 ? date("d-m-Y", strtotime($dd[0]->tanggal_lahir)) : '')?>"/>
														<span class="input-group-addon">
														<i class="fa fa-calendar bigger-110"></i>
														</span>
													</div>
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Kelamin </label>

												<div class="col-sm-2">
													<select class="chosen-select" id="jenis_kelamin" name="jenis_kelamin" data-placeholder="Jenis Kelamin">
														<option value="">&nbsp;</option>
														<option value="1" <?=($id==-1 ? '' : ($dd[0]->jenis_kelamin=='1' ? 'selected="selected"' :'' ))?>>Laki-laki</option>
														<option value="0" <?=($id==-1 ? '' : ($dd[0]->jenis_kelamin=='0' ? 'selected="selected"' :'' ))?>>Perempuan</option>

													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Alamat </label>

												<div class="col-sm-9">
													<input type="text" id="alamat" name="alamat" placeholder="Alamat" class="col-xs-10 col-sm-7" value="<?=($id!=-1 ? ($dd[0]->alamat) : '')?>" />
												</div>
											</div>
											
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Propinsi </label>

												<div class="col-sm-4">
													<select class="chosen-select" id="provinsi" name="provinsi" data-placeholder="Choose a Country..." onchange="getdata(this.value,'propinsi')">
														<option value="">Pilih Propinsi</option>
														<?php
														foreach ($prop as $k => $v) 
														{
															if($id!=-1)
															{
																if($dd[0]->provinsi!='')
																{
																	$propp=$v->idnama.'__'.str_replace(' ', '%20', $v->nama);
																	if($dd[0]->provinsi==$propp)
																	{
																		echo '<option selected="selected" value="'.$dd[0]->provinsi.'">'.$v->nama.'</option>';
																	}
																	else
																		echo '<option value="'.$v->idnama.'__'.str_replace(' ', '%20', $v->nama).'">'.$v->nama.'</option>';
																}
																else
																{
																	echo '<option value="'.$v->idnama.'__'.str_replace(' ', '%20', $v->nama).'">'.$v->nama.'</option>';	
																}
																
															}
															else
															{	
																echo '<option value="'.$v->idnama.'__'.str_replace(' ', '%20', $v->nama).'">'.$v->nama.'</option>';
															}
														}
														?>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Kota/Kabupaten </label>

												<div class="col-sm-4" id="datasubpropinsi">
													<select class="chosen-select" id="kota" name="kota" data-placeholder="Choose a Country..." onchange="getdata(this.value,'kabupaten')">
														<?php
														if($id!=-1)
														{
															if($dd[0]->provinsi!='')
															{

																list($idprop,$propp)=explode('__', $dd[0]->provinsi);
																// strtok(str, token)
																$wh=array('idparent'=>''.$idprop.'','status_tampil','1');
																$kab=$this->db->from('kelurahan')->where($wh)->order_by('nama','asc')->get()->result();
																// echo '<pre>';
																// print_r($idprop);
																// echo '</pre>';
																foreach ($kab as $k => $v) 
																{
																	if($dd[0]->kota!='')
																	{
																		$kota=$v->idnama.'__'.str_replace(' ', '%20', $v->nama);
																		if($dd[0]->kota==$kota)
																		{
																			echo '<option selected="selected" value="'.$dd[0]->kota.'">'.$v->nama.'</option>';
																		}
																		else
																			echo '<option value="'.$v->idnama.'__'.str_replace(' ', '%20', $v->nama).'">'.$v->nama.'</ption>';
																	}
																	else
																	{
																		echo '<option value="'.$v->idnama.'__'.str_replace(' ', '%20', $v->nama).'">'.$v->nama.'</ption>';
																	}
																}
															}
															else
															{
																echo '<option value="">--</option>';
															}
														}
														else
														{
														?>
															<option value="">--</option>
														<?php
														}
														?>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Kecamatan </label>

												<div class="col-sm-4" id="datasubkabupaten">
													<select class="chosen-select" id="kecamatan" name="kecamatan" data-placeholder="Choose a Country..." onchange="getdata(this.value,'kecamatan')">
														<?php
														if($id!=-1)
														{

															if($dd[0]->kota!='')
															{

																list($idkota,$kota)=explode('__', $dd[0]->kota);
																// strtok(str, token)
																$wh=array('idparent'=>''.$idkota.'','status_tampil','1');
																$kec=$this->db->from('kelurahan')->where($wh)->order_by('nama','asc')->get()->result();
																// echo '<pre>';
																// print_r($idprop);
																// echo '</pre>';
																foreach ($kec as $k => $v) 
																{
																	$kecm=$v->idnama.'__'.str_replace(' ', '%20', $v->nama);
																	if($dd[0]->kecamatan==$kecm)
																	{
																		echo '<option selected="selected" value="'.$dd[0]->kecamatan.'">'.$v->nama.'</option>';
																	}
																	else
																		echo '<option value="'.$v->idnama.'__'.str_replace(' ', '%20', $v->nama).'">'.$v->nama.'</ption>';
																}
															}
															else
															{
																echo '<option value="">--</option>';
															}
														}
														else
														{
														?>
															<option value="">--</option>
														<?php
														}
														?>
													</select>
												</div>
											</div>
											<div class="form-group" >
												<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Kelurahan </label>

												<div class="col-sm-4" id="datasubkecamatan">
													<select class="chosen-select" id="kelurahan" name="kelurahan" data-placeholder="Choose a Country..." >
														<?php
														if($id!=-1)
														{
															if($dd[0]->kecamatan!='')
															{
																list($idkec,$kec)=explode('__', $dd[0]->kecamatan);
																// strtok(str, token)
																$wh=array('idparent'=>''.$idkec.'','status_tampil','1');
																$kelr=$this->db->from('kelurahan')->where($wh)->order_by('nama','asc')->get()->result();
																// echo '<pre>';
																// print_r($idprop);
																// echo '</pre>';
																foreach ($kelr as $k => $v) 
																{
																	$kel=$v->idnama.'__'.str_replace(' ', '%20', $v->nama);
																	if($dd[0]->kelurahan==$kel)
																	{
																		echo '<option selected="selected" value="'.$dd[0]->kelurahan.'">'.$v->nama.'</option>';
																	}
																	else
																		echo '<option value="'.$v->idnama.'__'.str_replace(' ', '%20', $v->nama).'">'.$v->nama.'</ption>';
																}
															}
															else
															{
																echo '<option value="">--</option>';		
															}
														}
														else
														{
														?>
															<option value="">--</option>
														<?php
														}
														?>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Kode Pos</label>

												<div class="col-sm-9">
													<input type="text" id="kode_pos" name="kode_pos"  placeholder="Kode Pos" maxlength="5" class="col-xs-10 col-sm-1" value="<?=($id!=-1 ? $dd[0]->kode_pos : '')?>"/>
												</div>
											</div>

											<div class="clearfix form-actions">
												<div class="col-md-offset-3 col-md-9">
													<button class="btn btn-info" type="submit">
														<i class="ace-icon fa fa-check bigger-110"></i>
														Simpan Data
													</button>
													<?php
													if($id!=-1)
													{
													?>
													<a href="<?=site_url()?>siswa/form/-1" class="btn btn-info" type="submit">
														Tambah Baru
													</a>
													<?php
													}
													?>
												</div>
											</div>

											<div class="hr hr-24"></div>
										</form>
										
									</div>
									<div class="col-xs-4">
										<div class="page-header">
											<h1>
												Data Tambahan
											</h1>
										</div>
										<button class="btn btn-white btn-default btn-round" style="margin-bottom:5px;">
											<i class="ace-icon fa fa-exclamation-circle red2"></i>
										</button>
										<button class="btn btn-white btn-default btn-round" style="margin-bottom:5px;" onclick="datakeluarga('ayah',<?=$id?>)">
											<i class="ace-icon fa fa-user red2"></i>
											Data Ayah
										</button>							
										<br>	
										<button class="btn btn-white btn-default btn-round" style="margin-bottom:5px;">
											<i class="ace-icon fa fa-exclamation-circle red2"></i>
										</button>		
										<button class="btn btn-white btn-default btn-round"  style="margin-bottom:5px;" onclick="datakeluarga('ibu',<?=$id?>)">
											<i class="ace-icon fa fa-user blue"></i>
											Data Ibu
										</button>
										<br>	
										<button class="btn btn-white btn-default btn-round" style="margin-bottom:5px;">
											<i class="ace-icon fa fa-exclamation-circle red2"></i>
										</button>		
										<button class="btn btn-white btn-default btn-round" style="margin-bottom:5px;" onclick="datakeluarga('wali',<?=$id?>)">
											<i class="ace-icon fa fa-user red2"></i>
											Data Wali
										</button>
										<!-- <br>	
										<button class="btn btn-white btn-default btn-round" style="margin-bottom:5px;">
											<i class="ace-icon fa fa-exclamation-circle red2"></i>
										</button>		
										<button class="btn btn-white btn-default btn-round" style="margin-bottom:5px;" onclick="datakeluarga('saudara',<?=$id?>)">
											<i class="ace-icon fa fa-users blue"></i>
											Data Saudara
										</button>
										<br>	
										<button class="btn btn-white btn-default btn-round" style="margin-bottom:5px;">
											<i class="ace-icon fa fa-check-square-o green"></i>
										</button>		
										<button class="btn btn-white btn-default btn-round" style="margin-bottom:5px;">
											<i class="ace-icon fa fa-folder red"></i>
											Dokumen Siswa
										</button> -->
									</div>
								</div>
								<!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->

			<?=$this->load->view($footer,'',TRUE)?>
<style type="text/css">
	input
	{
		font-size: 10px !important;
	}
	label
	{
		font-size: 10px !important;
	}
	.form-group
	{
		margin-bottom: 2px !important;
	}
</style>
<script type="text/javascript">
	function datakeluarga(jns,id)
	{
		$.ajax({
			url : '<?=site_url()?>siswa/datakeluarga/'+jns+'/'+id,
			success : function(html)
			{
				bootbox.confirm(html, function(result) {
					if(result) 
					{
						$('#datakeluarga_'+jns).submit();
						// alert('ok');
						// $.ajax({
						// 	url : '<?=site_url()?>siswa/simpandatakeluarga/'+jns+'/'+id,
						// 		type : 'POST',
						// 		data : $('#datakeluarga_'+jns).serialize(),
						// 		success : function(a)
						// 		{
						// 					// alert(a);
						// 			// tampilpesan(a);
						// 			// $('#data').load('<?=site_url()?>config/ajarandata');
						// 			// $('#form').load('<?=site_url()?>config/ajaranform/-1');
						// 		}
						// 	});
					}
				});
			}
		});
		
	}
	function getdata(val,kat)
	{
		// alert(val+'--'+kat);
		$('#datasub'+kat).load('<?=site_url()?>config/getDaerah/'+val+'/'+kat,function(){
				if(!ace.vars['touch']) {
					$('.chosen-select').chosen({allow_single_deselect:true}); 
					//resize the chosen on window resize
			
					$(window)
					.off('resize.chosen')
					.on('resize.chosen', function() {
						$('.chosen-select').each(function() {
							 var $this = $(this);
							 $this.next().css({'width': $this.parent().width()});
						})
					}).trigger('resize.chosen');
					//resize chosen on sidebar collapse/expand
					$(document).on('settings.ace.chosen', function(e, event_name, event_val) {
						if(event_name != 'sidebar_collapsed') return;
						$('.chosen-select').each(function() {
							 var $this = $(this);
							 $this.next().css({'width': $this.parent().width()});
						})
					});
			
			
					$('#chosen-multiple-style .btn').on('click', function(e){
						var target = $(this).find('input[type=radio]');
						var which = parseInt(target.val());
						if(which == 2) $('#form-field-select-4').addClass('tag-input-style');
						 else $('#form-field-select-4').removeClass('tag-input-style');
					});
				}
		});
	}

	jQuery(function($){
				$('#tanggal_lahir').datepicker({
					autoclose: true,
					todayHighlight: true,
					
				});

				if(!ace.vars['touch']) {
					$('.chosen-select').chosen({allow_single_deselect:true}); 
					//resize the chosen on window resize
			
					$(window)
					.off('resize.chosen')
					.on('resize.chosen', function() {
						$('.chosen-select').each(function() {
							 var $this = $(this);
							 $this.next().css({'width': $this.parent().width()});
						})
					}).trigger('resize.chosen');
					//resize chosen on sidebar collapse/expand
					$(document).on('settings.ace.chosen', function(e, event_name, event_val) {
						if(event_name != 'sidebar_collapsed') return;
						$('.chosen-select').each(function() {
							 var $this = $(this);
							 $this.next().css({'width': $this.parent().width()});
						})
					});
			
			
					$('#chosen-multiple-style .btn').on('click', function(e){
						var target = $(this).find('input[type=radio]');
						var which = parseInt(target.val());
						if(which == 2) $('#form-field-select-4').addClass('tag-input-style');
						 else $('#form-field-select-4').removeClass('tag-input-style');
					});
				}
	});
</script>