	<form id="simpanjarak" style="width:100% !important" class="form-horizontal" action="<?=site_url()?>penerimaan/potonganproses/<?=$id?>" method="post">
				
					<div class="form-group">

						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Nama Siswa</label>
							<div class="col-sm-9">
								<select  data-rel="chosen" class="chosen-select" name="siswa" id="siswa" data-placeholder="Nama Siswa">
									<option value=""></option>
									<?php
									$siswa=$this->db->from('t_siswa')->where('status_tampil','t')->order_by('nama_murid')->get()->result();
									if(count($siswa)!=0)
									{
										foreach ($siswa as $k => $v) 
										{
											if($id!=-1)
											{
												if($d[0]->nis==$v->nis)
												{
													echo '<option value="'.$v->nis.'__'.$v->nama_murid.'" selected="selected">'.$v->nama_murid.'</option>';
												}
												// else
											}
											else
											{
												// if(in_array($v->nis, $dd))
												// 	continue;
												
												echo '<option value="'.$v->nis.'__'.$v->nama_murid.'">'.$v->nama_murid.'</option>';
											}
										}
									}
									?>
								</select>
									
								</div>
								
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Nama potongan</label>
							<div class="col-sm-9">
								<select name="jenis" id="jenis" class="col-xs-12 col-sm-8 chosen-select" data-placeholder="Jenis Potongan">
									<option value=""></option>
									<?php
									
									if(count($jenis)!=0)
									{
										//print_r($d);
										foreach ($jenis[0] as $k => $v) 
										{
											list($idjn,$nmjn)=explode('__', $v);
											if($id!=-1)
											{
												if($nmjn==$d[0]->jenis_potongan)
													echo '<option selected="selected" value="'.$d[0]->jenis_id.'__'.$d[0]->jenis_potongan.'">'.$d[0]->jenis_potongan.'</option>';
												else
													echo '<option value="'.$v.'">'.$nmjn.'-'.$d[0]->jenis_id.'__'.$d[0]->jenis_potongan.'</option>';
											}
											else
												echo '<option value="'.$v.'">'.$nmjn.'</option>';
										}
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Tahun Ajaran</label>
							<div class="col-sm-9">
								<select name="tahun_ajaran" id="tahunajaran" class="chosen-select form-control tag-input-style span12" data-placeholder="Tahun Ajaran">
									<option value=""></option>
									<?php
									$ajaran=$this->config->item('tajaran');
									if(count($ajaran)!=0)
									{
										foreach ($ajaran as $k => $v) 
										{
											if($id!=-1)
											{
												if($v->tahun_ajaran==$d[0]->tahun_ajaran)
													echo '<option selected="selected" value="'.$v->id_ajaran.'__'.$d[0]->tahun_ajaran.'">'.$d[0]->tahun_ajaran.'</option>';
												else
													echo '<option value="'.$v->id_ajaran.'__'.$v->tahun_ajaran.'">'.$v->tahun_ajaran.'</option>';
											}
											else
												echo '<option value="'.$v->id_ajaran.'__'.$v->tahun_ajaran.'">'.$v->tahun_ajaran.'</option>';
										}
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Potongan (Jumlah)</label>
							<div class="col-sm-9">
								<input type="text" class="span12" name="biaya" id="biaya" style="width:90%" value="<?=($id!=-1 ? number_format($d[0]->biaya,0) : '')?>">
							</div>
						</div>						
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Potongan (%)</label>
							<div class="col-sm-2">
								<input type="text" placeholder="%" class="span12" name="persen" id="persen" style="width:90%" value="<?=($id!=-1 ? number_format($d[0]->persen,0).' % ' : '')?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Keterangan</label>
							<div class="col-sm-9">
								<textarea class="span12" name="keterangan" style="width:90%"><?=($id!=-1 ? $d[0]->keterangan : '')?></textarea>
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
	#siswa_chosen,#idclub_chosen,#tahunajaran_chosen
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
		$('#form').load('<?=site_url()?>penerimaan/potonganform/-1');
	});
	$('.chosen-select').chosen({allow_single_deselect:true});
	$("#simpan").on(ace.click_event, function() {
		var jenis=$('#potongan').val();
				bootbox.confirm("<h3>Apakah Data Potongan Siswa ini sudah Benar </h3>", function(result) {
					if(result) 
					{
						$.ajax({
							url : '<?=site_url()?>penerimaan/potonganproses/<?=$id?>',
							type : 'POST',
							data : $('#simpanjarak').serialize(),
							success : function(a)
							{
								// alert(a);
								tampilpesan(a);
								$('#data').load('<?=site_url()?>penerimaan/potongandata/'+jenis);
								$('#form').load('<?=site_url()?>penerimaan/potonganform/-1');
							}
						});
					}
				});
	});
	$('input#biaya').keyup(function(){
				// alert('a');
				$(this).formatCurrency({symbol:''})
			});
</script>