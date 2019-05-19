<form id="simpanjarak" style="width:100% !important" class="form-horizontal" action="<?=site_url()?>penerimaan/jemputanproses/<?=$id?>" method="post">
				
					<div class="form-group">

						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Nama Siswa</label>
							<div class="col-sm-9">
								<select  data-rel="chosen" multiple="" class="chosen-select form-control tag-input-style" name="siswa[]" id="siswa" data-placeholder="Nama Siswa">
									<option value=""></option>
									<?php
									$siswa=$this->db->from('t_siswa')->where('status_tampil','t')->order_by('nama_murid')->get()->result();
									if(count($siswa)!=0)
									{
										foreach ($siswa as $k => $v) 
										{
											
											
											if($id!=-1)
											{
												if($d->row('nis')==$v->nis)
												{
													echo '<option value="'.$d->row('nis').'__'.$d->row('nama_siswa').'" selected="selected">'.$v->nama_murid.'</option>';
													break;
												}
												else
													echo '<option value="'.$v->nis.'__'.$v->nama_murid.'">'.$v->nama_murid.'</option>';
											}
											else
											{
												if(in_array($v->nis, $dd))
													continue;

												echo '<option value="'.$v->nis.'__'.$v->nama_murid.'">'.$v->nama_murid.'</option>';
											}
										}
									}
									?>
								</select>
									
								</div>
								
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Nama Driver</label>
							<div class="col-sm-9">
								<select name="driver" id="iddriver" class="col-xs-12 col-sm-8 chosen-select" data-placeholder="Data Driver">
									<option value=""></option>
									<?php
									$driver=$this->db->from('t_supir')->where('status_tampil','t')->order_by('nama_supir')->get()->result();
									if(count($driver)!=0)
									{
										foreach ($driver as $k => $v) 
										{
											if($id!=-1)
											{
												if($d->row('id_driver')==$v->id_supir)
													echo '<option selected="selected" value="'.$d->row('id_driver').'__'.$d->row('nama_driver').'">'.$v->nama_supir.'</option>';
												else
													echo '<option value="'.$v->id_supir.'__'.$v->nama_supir.'">'.$v->nama_supir.'</option>';
											}
											else
												echo '<option value="'.$v->id_supir.'__'.$v->nama_supir.'">'.$v->nama_supir.'</option>';
										}
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Jarak Rumah</label>
							<div class="col-sm-9">
								<input type="text" name="jarak" class="" id="jarak" style="width:30% !important;" required placeholder="Dalam Meter" value="<?=($id!=-1 ? $d->row('jarak') : '')?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Jemputan</label>
							<div class="col-sm-9">
								<select name="status" id="status" class="col-xs-12 col-sm-8 chosen-select" data-placeholder="Jemputan">
									<option value=""></option>
									<option value="pulang-pergi" <?=($id!=-1 ? ($d->row('status')=='pulang-pergi' ? 'selected="selected"' : '') : '')?>>Pulang Pergi</option>
									<option value="pulang" <?=($id!=-1 ? ($d->row('status')=='pulang' ? 'selected="selected"' : '') : '')?>>Pulang Saja</option>
									<option value="pergi" <?=($id!=-1 ? ($d->row('status')=='pergi' ? 'selected="selected"' : '') : '')?>>Pergi Saja</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Jemputan Club</label>
							<div class="col-sm-9">
								<select name="jemputan_club" id="jemputan_club" class="col-xs-12 col-sm-8 chosen-select" data-placeholder="Jemputan Club">
									<option value=""></option>
									<option value="t" <?=($id!=-1 ? ($d->row('jemputan_club')=='t' ? 'selected="selected"' : '') : '')?>>Ikut</option>
									<option value="f" <?=($id!=-1 ? ($d->row('jemputan_club')=='f' ? 'selected="selected"' : '') : '')?>>Tidak Ikut</option>

								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Keterangan</label>
							<div class="col-sm-9">
								<textarea class="span12" name="keterangan" style="width:90%"><?=($id!=-1 ? $d->row('keterangan') : '')?></textarea>
							</div>
						</div>
						
				<div class="clearfix form-actions">
					<div class="col-md-offset-3 col-md-9">
						<button class="btn btn-info" id="simpan" type="button">
							
							<?=(($id!=-1 ) ? '<i class="ace-icon fa fa-pencil bigger-110"></i> Edit' : '<i class="ace-icon fa fa-check bigger-110"></i> Simpan')?>
						</button>
						<?php
						if($id!=-1 )
						{
						?>
						<button class="btn btn-primary" id="baru" type="button">
							<i class="ace-icon fa fa-check bigger-110"></i>
							Baru
						</button>
						<?php
						}
						?>
						&nbsp; &nbsp; &nbsp;
					</div>
				</div>

				<div class="hr hr-24"></div>
</form>
<style type="text/css">
	.form-group label
	{
		font-size:10px !important;
	}
	#siswa_chosen,#iddriver_chosen
	{
		width:90% !important;
	}
	input
	{
		font-size:11px !important;
	}
</style>
<script type="text/javascript">
	$('#baru').on('click',function(){
		$('#form').load('<?=site_url()?>penerimaan/jemputanform/-1');
	});
	$('.chosen-select').chosen({allow_single_deselect:true});
	$("#simpan").on(ace.click_event, function() {
				bootbox.confirm("<h3>Apakah Data Jemputan Siswa ini sudah Benar </h3>", function(result) {
					if(result) 
					{
						$.ajax({
							url : '<?=site_url()?>penerimaan/jemputanproses/<?=$id?>',
							type : 'POST',
							data : $('#simpanjarak').serialize(),
							success : function(a)
							{
								// alert(a);
								var iddriver=$('#driver').val();
								tampilpesan(a);
								if(iddriver=="")
									$('#data').load('<?=site_url()?>penerimaan/jemputandata');
								else
									$('#data').load('<?=site_url()?>penerimaan/jemputandata/'+iddriver);
								
								$('#form').load('<?=site_url()?>penerimaan/jemputanform/-1');
							}
						});
					}
				});
	});
	$('input#jarak').keyup(function(){
				// alert('a');
				$(this).formatCurrency({symbol:''})
			});
</script>