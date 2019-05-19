<form class="form-horizontal" role="form" id="simpanjarak">
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tahun Ajaran </label>

		<div class="col-sm-9">
			<input type="text" id="tahun_ajaran" name="tahun_ajaran" placeholder="XXXX / YYYY" class="col-xs-12 col-sm-12" value="<?=($id!=-1 ? ($d->row('tahun_ajaran')) : '')?>"/>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Awal Tahun Ajaran </label>

		<div class="col-sm-9">
			<input type="text" id="bulan_awal" name="bulan_awal" placeholder="Bulan" class="col-xs-12 col-sm-12" value="<?=($id!=-1 ? (ucwords($d->row('bulan_awal'))) : '')?>"/>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Akhir Tahun Ajaran </label>

		<div class="col-sm-9">
			<input type="text" id="bulan_akhir" name="bulan_akhir" placeholder="Bulan" class="col-xs-12 col-sm-12" value="<?=($id!=-1 ? (ucwords($d->row('bulan_akhir'))) : '')?>"/>
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
	$.mask.definitions['~']='[+-]';
	$('#tahun_ajaran').mask('9999 / 9999');

	$('#baru').on('click',function(){
		$('#form').load('<?=site_url()?>config/ajaranform/-1');
	});
	$("#simpan").on(ace.click_event, function() {
				bootbox.confirm("<h3>Apakah Data Tahun Ajaran ini sudah Benar </h3>", function(result) {
					if(result) 
					{
						$.ajax({
							url : '<?=site_url()?>config/ajaranproses/<?=$id?>',
							type : 'POST',
							data : $('#simpanjarak').serialize(),
							success : function(a)
							{
								// alert(a);
								tampilpesan(a);
								$('#data').load('<?=site_url()?>config/ajarandata');
								$('#form').load('<?=site_url()?>config/ajaranform/-1');
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