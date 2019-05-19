<form id="simpanjarak" style="width:100% !important" class="form-horizontal" action="<?=site_url()?>penerimaan/jenisproses/<?=$id?>" method="post">
				
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Jenis Penerimaan</label>
							<div class="col-sm-9">
								<input type="text" name="jenis" class="span6 typeahead" id="jenis" style="width:100%;" required value="<?=($id!=-1 ? ($child!="" ? $idp : $d->row('jenis')) : '')?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Kategori</label>
							<div class="col-sm-9">
								<select  data-rel="chosen" class="col-xs-12 col-sm-8 chosen-select" name="kategori" data-placeholder="Kategori">
									<option value="sekolah" <?=($id!=-1 ? ($d->row('kategori')=='sekolah' ? "selected='selected'"  : '') : '')?>>Dana Sekolah</option>
									<option value="non-sekolah" <?=($id!=-1 ? ($d->row('kategori')=='non-sekolah' ? "selected='selected'"  : '') : '')?>>Dana Non Sekolah</option>
									<!-- <option value="investasi">Dana Investasi</option> -->
								</select>
									
								</div>
								<input type="hidden" name="id_parent" value="<?=($id!=-1 ? ($child!="" ? $id : $d->row('id_parent')) : $id_parent)?>">
								<input type="hidden" name="child" value="<?=($id!=-1 ? $child : '')?>">
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Level</label>
							<div class="col-sm-9">
								<select  data-rel="chosen" class="col-xs-12 col-sm-8 chosen-select" name="level" data-placeholder="Level">
									<option value="nolevel" <?=($id!=-1 ? ($d->row('level')=='nolevel' ? "selected='selected'"  : '') : '')?>>No Level</option>
									<option value="all" <?=($id!=-1 ? ($d->row('level')=='all' ? "selected='selected'"  : '') : '')?>>Semua Level</option>
									<option value="pg_baru" <?=($id!=-1 ? ($d->row('level')=='pg_baru' ? "selected='selected'"  : '') : '')?>>PG Baru</option>
									<option value="tk_baru" <?=($id!=-1 ? ($d->row('level')=='tk_baru' ? "selected='selected'"  : '') : '')?>>TK Baru</option>
									<option value="sd_baru" <?=($id!=-1 ? ($d->row('level')=='sd_baru' ? "selected='selected'"  : '') : '')?>>SD Baru</option>
									<option value="sd_baru_non_sab" <?=($id!=-1 ? ($d->row('level')=='sd_baru_non_sab' ? "selected='selected'"  : '') : '')?>>SD Baru Non SAB</option>
									<option value="pg" <?=($id!=-1 ? ($d->row('level')=='pg' ? "selected='selected'"  : '') : '')?>>PG</option>
									<option value="tk" <?=($id!=-1 ? ($d->row('level')=='tk' ? "selected='selected'"  : '') : '')?>>TK</option>
									<option value="sd" <?=($id!=-1 ? ($d->row('level')=='sd' ? "selected='selected'"  : '') : '')?>>SD</option>
									<option value="sd1_3" <?=($id!=-1 ? ($d->row('level')=='sd1_3' ? "selected='selected'"  : '') : '')?>>SD Kelas 1-3</option>
									<option value="sd4_5" <?=($id!=-1 ? ($d->row('level')=='sd4_5' ? "selected='selected'"  : '') : '')?>>SD Kelas 4-5</option>
									<option value="sd4_6" <?=($id!=-1 ? ($d->row('level')=='sd4_6' ? "selected='selected'"  : '') : '')?>>SD Kelas 4-6</option>
									<option value="sd4" <?=($id!=-1 ? ($d->row('level')=='sd4' ? "selected='selected'"  : '') : '')?>>SD Kelas 4</option>
									<option value="sd5" <?=($id!=-1 ? ($d->row('level')=='sd5' ? "selected='selected'"  : '') : '')?>>SD Kelas 5</option>
									<option value="sd6" <?=($id!=-1 ? ($d->row('level')=='sd6' ? "selected='selected'"  : '') : '')?>>SD Kelas 6</option>
									<option value="sm" <?=($id!=-1 ? ($d->row('level')=='sm' ? "selected='selected'"  : '') : '')?>>SM</option>
									<option value="sm_sab" <?=($id!=-1 ? ($d->row('level')=='sm_sab' ? "selected='selected'"  : '') : '')?>>SM SAB</option>
									<option value="sm_non_sab" <?=($id!=-1 ? ($d->row('level')=='sm_non_sab' ? "selected='selected'"  : '') : '')?>>SM Non SAB</option>
									<option value="sm-x" <?=($id!=-1 ? ($d->row('level')=='sm-x' ? "selected='selected'"  : '') : '')?>>SM-X</option>
									<!-- <option value="investasi">Dana Investasi</option> -->
								</select>
									
								</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Biaya</label>
							<div class="col-sm-9">
								<input type="text" name="jumlah" class="span6 typeahead" id="biaya" style="width:100%;" required value="<?=($id!=-1 ? ($child!="" ? $idp : $d->row('jumlah')) : '0')?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Kode Akun Terkait</label>
							<div class="col-sm-9">
								<select name="kodeakun" id="kodeakun" class="col-xs-12 col-sm-8 chosen-select">
									<option value=""></option>
									<?php
									$ajaran=$this->db->from('t_akun')->where('status_tampil','t')->order_by('kode_akun asc')->get();
									$ka=array();
									foreach ($ajaran->result() as $k => $v) 
									{
										$l=strtok($v->kode_akun, '0');
										$ln=strlen($l);
										if($id==-1)
											echo '<option value="'.$v->akun_alternatif.'-'.$v->kode_akun.'-'.$v->nama_akun.'" style="padding-left:'.($ln*10).'px;">'.$v->akun_alternatif.'-'.$v->kode_akun.' - '.$v->nama_akun.'</option>';
										else
										{
											if(($v->akun_alternatif.'-'.$v->kode_akun.'-'.$v->nama_akun)==$d->row('kodeakun'))
												echo '<option selected="selected" value="'.$d->row('kodeakun').'">'.$v->akun_alternatif.' | '.$v->kode_akun.' | '.$v->nama_akun.'</option>';
											else
												echo '<option value="'.$v->akun_alternatif.'-'.$v->kode_akun.'-'.$v->nama_akun.'">'.$v->akun_alternatif.'-'.$v->kode_akun.' - '.$v->nama_akun.'</option>';
										}
										
									}
									?>
								</select>
							</div>
						</div>
						<div class="clearfix form-actions">
					<div class="col-md-offset-3 col-md-9">
						<button class="btn btn-info" id="simpan" type="button">
							
							<?=(($id!=-1 && $child=='') ? '<i class="ace-icon fa fa-pencil bigger-110"></i> Edit' : '<i class="ace-icon fa fa-check bigger-110"></i> Simpan')?>
						</button>
						<?php
						if($id!=-1 && $child=='')
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
	#kodeakun_chosen
	{
		width:100% !important;
	}
	input
	{
		font-size:11px !important;
	}
</style>
<script type="text/javascript">
	$('#baru').on('click',function(){
		$('#form').load('<?=site_url()?>penerimaan/jenisform/-1');
	});
	$('.chosen-select').chosen({allow_single_deselect:true});
	$("#simpan").on(ace.click_event, function() {
				bootbox.confirm("<h3>Apakah Data Jenis Penerimaan ini sudah Benar </h3>", function(result) {
					if(result) 
					{
						$.ajax({
							url : '<?=site_url()?>penerimaan/jenisproses/<?=$id?>',
							type : 'POST',
							data : $('#simpanjarak').serialize(),
							success : function(a)
							{
								// alert(a);
								tampilpesan(a);
								$('#data').load('<?=site_url()?>penerimaan/jenisdata');
								$('#form').load('<?=site_url()?>penerimaan/jenisform/-1');
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