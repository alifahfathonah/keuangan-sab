<form id="simpanjarak" style="width:100% !important" class="form-horizontal" action="<?=site_url()?>config/akunproses/<?=$id?>" method="post">
				
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Kode Akun</label>
							<div class="col-sm-9">
								<input type="text" name="kode_akun" class="span6 typeahead" id="kode_akun" style="width:100%;" required value="<?=($id!=-1 ? ($child!="" ? $idp : $d->row('kode_akun')) : '')?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Nama Akun</label>
							<div class="col-sm-9">
									<input type="text" name="nama_akun" class="span6 typeahead" id="nama_akun" style="width:100%;" required  value="<?=($id!=-1 ? ($child!="" ? "" : $d->row('nama_akun')) : '')?>" placeholder="<?=($child!="" ? $d->row('nama_akun') : "")?>">
									
								</div>
								<input type="hidden" name="id_parent" value="<?=($id!=-1 ? ($child!="" ? $id : $d->row('id_parent')) : $id_parent)?>">
								<input type="hidden" name="child" value="<?=($id!=-1 ? $child : '')?>">
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Kode Akun Alternatif</label>
							<div class="col-sm-9">
									<input type="text" name="akun_alternatif" class="span6 typeahead" id="akun_alternatif" style="width:100%;" required  value="<?=($id!=-1 ? $d->row('akun_alternatif') : '')?>">
									
								</div>
								<input type="hidden" name="id_parent" value="<?=($id!=-1 ? ($child!="" ? $id : $d->row('id_parent')) : $id_parent)?>">
								<input type="hidden" name="child" value="<?=($id!=-1 ? $child : '')?>">
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
</style>
<script type="text/javascript">
	$('#baru').on('click',function(){
		$('#form').load('<?=site_url()?>config/akunform/-1');
	});
	$('#kode_akun').blur(function(){
		var id=$(this).val();
		$.ajax({
			url : '<?=site_url()?>config/cekakun/'+id,
			success : function(a)
			{
				if(a==1)
				{
					var psn='Kode Akun Sudah Ada';
					tampilpesan(psn);
					$('#kode_akun').val('');
					$('#nama_akun').val('');
					$('#kode_akun').focus();
				}
			}
		});
	});
	$("#simpan").on(ace.click_event, function() {
				bootbox.confirm("<h3>Apakah Kode Akun ini sudah Benar </h3>", function(result) {
					if(result) 
					{
						$.ajax({
							url : '<?=site_url()?>config/akunproses/<?=$id?>',
							type : 'POST',
							data : $('#simpanjarak').serialize(),
							success : function(a)
							{
								// alert(a);
								tampilpesan(a);
								$('#data').load('<?=site_url()?>config/akundata');
								$('#form').load('<?=site_url()?>config/akunform/-1');
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