<form class="form-horizontal" role="form" id="simpanjarak">
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Jarak (m) </label>

		<div class="col-sm-9">
			<input type="text" id="jarak" name="jarak" placeholder="Jarak (dalam meter)" class="col-xs-12 col-sm-12" value="<?=($id!=-1 ? number_format($d->row('jarak')) : '')?>"/>
		</div>
	</div>	
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tarif </label>

		<div class="col-sm-9">
			<input type="text" id="tarif" name="tarif" placeholder="Tarif (Rp)" class="col-xs-12 col-sm-12" value="<?=($id!=-1 ? number_format($d->row('biaya')) : '')?>"/>
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
<script type="text/javascript">
	// $('#simpan').click(function(){

	// 	var c=confirm('Apakah Data Jarak Jemputan ini sudah Benar ??');
	// 	if(c)
	// 	{
	// 		
	// 	}
	// });
	$('#baru').on('click',function(){
		$('#form').load('<?=site_url()?>config/jarakform/-1');
	});
	$("#simpan").on(ace.click_event, function() {
				bootbox.confirm("<h3>Apakah Data Jarak Jemputan ini sudah Benar </h3>", function(result) {
					if(result) 
					{
						$.ajax({
							url : '<?=site_url()?>config/jarakproses/<?=$id?>',
							type : 'POST',
							data : $('#simpanjarak').serialize(),
							success : function(a)
							{
								// alert(a);
								tampilpesan(a);
								$('#data').load('<?=site_url()?>config/jarakdata');
								$('#form').load('<?=site_url()?>config/jarakform/-1');
							}
						});
					}
				});
	});
	$('input#tarif, input#jarak').keyup(function(){
				// alert('a');
				$(this).formatCurrency({symbol:''})
			});
</script>