	<form id="simpanjarak" style="width:100% !important" class="form-horizontal" action="<?=site_url()?>penerimaan/clubproses/<?=$id?>" method="post">
				
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
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Nama Club</label>
							<div class="col-sm-9">
								<select name="club[]" id="idclub" class="chosen-select form-control tag-input-style" data-placeholder="Data Club" multiple>
									<option value=""></option>
									<?php
									$club=$this->db->from('t_club')->where('status_tampil','t')->order_by('nama_club')->get()->result();
									if(count($club)!=0)
									{
										//print_r($d);
										$d_club=array();
										if($id!=-1)
										{
											$d_club=explode(',', $d[0]->id_club);
										}

										foreach ($club as $k => $v) 
										{
											if($id!=-1)
											{
												if(in_array($v->id_club, $d_club))
													echo '<option selected="selected" value="'.$v->id_club.'__'.$v->nama_club.'">'.$v->nama_club.'</option>';
												else
													echo '<option value="'.$v->id_club.'__'.$v->nama_club.'">'.$v->nama_club.'</option>';
											}
											else
												echo '<option value="'.$v->id_club.'__'.$v->nama_club.'">'.$v->nama_club.'</option>';
										}
									}
									?>
								</select>
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
	#siswa_chosen,#idclub_chosen
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
		$('#form').load('<?=site_url()?>penerimaan/clubform/-1');
	});
	$('.chosen-select').chosen({allow_single_deselect:true});
	$("#simpan").on(ace.click_event, function() {
				bootbox.confirm("<h3>Apakah Data Club Siswa ini sudah Benar </h3>", function(result) {
					if(result) 
					{
						$.ajax({
							url : '<?=site_url()?>penerimaan/clubproses/<?=$id?>',
							type : 'POST',
							data : $('#simpanjarak').serialize(),
							success : function(a)
							{
								// alert(a);
								tampilpesan(a);
								$('#data').load('<?=site_url()?>penerimaan/clubdata');
								$('#form').load('<?=site_url()?>penerimaan/clubform/-1');
							}
						});
					}
				});
	});

</script>