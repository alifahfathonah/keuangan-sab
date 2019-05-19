<form class="form-horizontal" role="form" id="simpanjarak">
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Nama Catering </label>

		<div class="col-sm-9">
			<input type="text" id="nama_catering" name="nama_catering" placeholder="Nama Catering" class="col-xs-12 col-sm-12" value="<?=($id!=-1 ? ($d->row('nama_catering')) : '')?>"/>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Penanggung Jawab </label>

		<div class="col-sm-9">
			<input type="text" id="penanggung_jawab" name="penanggung_jawab" placeholder="Penanggung Jawab" class="col-xs-12 col-sm-12" value="<?=($id!=-1 ? ($d->row('penanggung_jawab')) : '')?>"/>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Email PJ </label>

		<div class="col-sm-9">
			<input type="email" id="email_pj" name="email_pj" placeholder="Email" class="col-xs-12 col-sm-12" value="<?=($id!=-1 ? ($d->row('email_pj')) : '')?>"/>
		</div>
	</div>	
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Telp PJ </label>

		<div class="col-sm-9">
			<input type="email" id="telp_pj" name="telp_pj" placeholder="telp" class="col-xs-12 col-sm-12" value="<?=($id!=-1 ? ($d->row('telp_pj')) : '')?>"/>
		</div>
	</div>	
	<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Alamat</label>
							<div class="col-sm-9">
								<textarea class="span12" name="alamat" style="width:90%"><?=($id!=-1 ? $d->row('alamat') : '')?></textarea>
							</div>
	</div>
	<div class="clearfix form-actions">
		<div class="col-md-offset-3 col-md-9">
			<button class="btn btn-info" id="simpan" type="button">
				
				<?=($id!=-1 ? '<i class="ace-icon fa fa-pencil bigger-110"></i> Edit' : '<i class="ace-icon fa fa-check bigger-110"></i> Simpan')?>
			</button>
			<?php
			if($id!=-1)
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
	// $('#simpan').click(function(){

	// 	var c=confirm('Apakah Data Jarak Jemputan ini sudah Benar ??');
	// 	if(c)
	// 	{
	// 		
	// 	}
	// });
	$('#baru').on('click',function(){
		$('#form').load('<?=site_url()?>config/cateringform/-1');
	});
	$("#simpan").on(ace.click_event, function() {
				bootbox.confirm("<h3>Apakah Data Club ini sudah Benar </h3>", function(result) {
					if(result) 
					{
						$.ajax({
							url : '<?=site_url()?>config/cateringproses/<?=$id?>',
							type : 'POST',
							data : $('#simpanjarak').serialize(),
							success : function(a)
							{
								// alert(a);
								tampilpesan(a);
								$('#data').load('<?=site_url()?>config/cateringdata');
								$('#form').load('<?=site_url()?>config/cateringform/-1');
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