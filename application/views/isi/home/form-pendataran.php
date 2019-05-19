	<form id="simpanpendaftaran<?=$jenis?>" style="width:100% !important" class="form-horizontal" action="<?=site_url()?>penerimaan/pendaftaranproses/<?=$jenis?>/<?=$id?>" method="post">

					<div class="form-group">

						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Nama Siswa</label>
							<div class="col-sm-9">
								<select  data-rel="chosen" class="chosen-select form-control tag-input-style span12" multiple="" name="siswa[]" id="siswa_<?=$jenis?>" data-placeholder="Nama Siswa" style="width:100% !important">
									<option value=""></option>
									<?php

									if(count($siswa)!=0)
									{
										foreach ($siswa as $k => $v)
										{
											if($id!=-1)
											{
												if($d[0]->nis==$v->nis)
												{
													echo '<option value="'.$v->id.'__'.$v->nis.'__'.str_replace(' ', '%20', $v->nama_murid).'" selected="selected">'.$v->nama_murid.'</option>';
												}
												// else
											}
											else
											{
												// if(in_array($v->nis, $dd))
												// 	continue;

												echo '<option value="'.$v->id.'__'.$v->nis.'__'.str_replace(' ', '%20',$v->nama_murid).'">'.$v->nama_murid.'</option>';
											}
										}
									}
									?>
								</select>

								</div>

						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Kelas</label>
							<div class="col-sm-9">
								<select name="kelas" id="kelas_<?=$jenis?>" onchange="ambiljenis('<?=$jenis?>')" class="chosen-select form-control tag-input-style span12" data-placeholder="Kelas">
									<option value=""></option>
									<?php
									if(count($levelkelas)!=0)
									{
										foreach ($levelkelas as $k => $v)
										{
											echo '<option value="'.str_replace(' ', '%20', $v->level.'__'.$v->id_level.'__'.$v->nama_level.'__'.$v->kategori).'">'.$v->nama_level.'</option>';
										}
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Tahun Ajaran</label>
							<div class="col-sm-9">
								<select name="tahunajaran" id="tahunajaran_<?=$jenis?>" class="chosen-select form-control tag-input-style span12" data-placeholder="Tahun Ajaran">
									<option value=""></option>
									<?php
									if(count($ajaran)!=0)
									{
										foreach ($ajaran as $k => $v)
										{
											echo '<option value="'.$v->id_ajaran.'__'.$v->tahun_ajaran.'">'.$v->tahun_ajaran.'</option>';
										}
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Lulusan SAB</label>
							<div class="col-sm-9">
								<select name="sab" id="sab_<?=$jenis?>" onchange="ambiljenis('<?=$jenis?>')" class="chosen-select form-control tag-input-style span12" data-placeholder="Lulusan SAB">
									<!-- <option value=""></option> -->
									<option value="ya" selected="selected">Ya</option>
									<option value="tidak">Tidak</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Investasi</label>
							<div class="col-sm-9" id="d_inves_<?=$jenis?>">
								<select name="investasi" id="investasi_<?=$jenis?>" class="chosen-select form-control tag-input-style span12" multiple="multiple" data-placeholder="Data Investasi">
									<option value=""></option>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Keterangan</label>
							<div class="col-sm-9">
								<textarea class="span5" name="keterangan" style="width:90%"><?=($id!=-1 ? $d[0]->keterangan : '')?></textarea>
							</div>
						</div>

				<div class="clearfix form-actions">
					<div class="col-md-offset-3 col-md-9">
						<button class="btn btn-info" id="simpan_<?=$jenis?>" type="button">

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

			</div>
				<div class="hr hr-24"></div>
</form>
<style type="text/css">
	.form-group label
	{
		font-size:10px !important;
	}
	#siswa_<?=$jenis?>_chosen
	{
		width: 90% !important;
	}
	#sab_<?=$jenis?>_chosen,#kelas_<?=$jenis?>_chosen,#idcatering_<?=$jenis?>_chosen,#tahunajaran_<?=$jenis?>_chosen,#investasi_<?=$jenis?>_chosen
	{
		width:50% !important;
	}
	input
	{
		font-size:11px !important;
	}
</style>
<script type="text/javascript">
function ambiljenis(jenis)
{
	var val=$('#kelas_'+jenis).val();
	var sab=$('#sab_'+jenis).val();
	var siswa=$('#siswa_'+jenis).val();

	$('#d_inves_'+jenis).load('<?=site_url()?>penerimaan/jenisgroup/'+sab+'/'+jenis+'/'+val+'/'+siswa,function(){
		$('#investasi_'+jenis).chosen({allow_single_deselect:true});
	});
	// alert(val);
}
	$('.chosen-select').chosen({allow_single_deselect:true});
	$("#simpan_<?=$jenis?>").on(ace.click_event, function() {
				bootbox.confirm("<h3>Apakah Data yang Diinputkan ini sudah Benar </h3>", function(result) {
					if(result)
					{
						 // $('#simpanpendaftaran<?=$jenis?>').submit();
						$.ajax({
							url : '<?=site_url()?>penerimaan/pendaftaranproses/<?=$jenis?>/<?=$id?>',
							type : 'POST',
							data : $('#simpanpendaftaran<?=$jenis?>').serialize(),
							success : function(a)
							{
								// alert(a);
								tampilpesan(a);
								// $('#data').load('<?=site_url()?>penerimaan/cateringdata');
								$('#loader-<?=$jenis?>').show();
								$('#<?=$jenis?>').load('<?=site_url()?>penerimaan/pendftaran/<?=$jenis?>/<?=$id?>',function(){
									$('#loader-<?=$jenis?>').hide();

								});
								// $('#form').load('<?=site_url()?>penerimaan/pendftaran/<?=$jenis?>/<?=$id?>');
							}
						});
					}
				});
	});

</script>
