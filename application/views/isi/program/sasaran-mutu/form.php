<form class="form-horizontal" role="form" id="simpanjarak">
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Sasaran Mutu </label>

		<div class="col-sm-9">
			<textarea name="sasaran_mutu" class="col-xs-12 col-sm-12"><?=($id!=-1 ? ($d->row('sasaran_mutu')) : '')?></textarea>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Program </label>

		<div class="col-sm-9">
			<select name="program_id" data-rel="chosen" class="col-xs-12 col-sm-12 col-md-12 chosen-select">
                <option value="">--Pilih Program--</option>
				<?php		
				foreach ($program as $k => $v) 
				{
					if($id!=-1)
					{
						if($d->row('program_id')==$v->id)
							echo '<option selected="selected" value="'.$d->row('program_id').'">'.ucwords($v->program).'</option>';
						else
							echo '<option value="'.$v->id.'">'.ucwords($v->program).'</option>';
					}
					else
						echo '<option value="'.$v->id.'">'.ucwords($v->program).'</option>';
				}
				?>
			</select>
			
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tahun Ajaran </label>

		<div class="col-sm-9">
			<select name="tahun_ajaran" id="tahun_ajaran"  data-rel="chosen" class="col-xs-9 col-sm-9 col-md-9 chosen-select">
                <option value="">--Tahun Ajaran--</option>
				<?php		
				foreach ($tajaran as $k => $v) 
				{
					if($id!=-1)
					{
						if($d->row('tahun_ajaran')==$v->tahun_ajaran)
							echo '<option selected="selected" value="'.$d->row('tahun_ajaran').'">'.ucwords($v->tahun_ajaran).'</option>';
						else
							echo '<option value="'.$v->tahun_ajaran.'">'.ucwords($v->tahun_ajaran).'</option>';
					}
					else
						echo '<option value="'.$v->tahun_ajaran.'">'.ucwords($v->tahun_ajaran).'</option>';
				}
				?>
			</select>
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
		// $('#form').load('<?=site_url()?>program/bankform/-1');
		edit(-1);
	});
	$("#simpan").on(ace.click_event, function() {
				bootbox.confirm("<h3>Apakah Data Sasaran Mutu ini sudah Benar </h3>", function(result) {
					if(result) 
					{
						$.ajax({
							url : '<?=site_url()?>sasaranmutu/proses/<?=$id?>',
							type : 'POST',
							data : $('#simpanjarak').serialize(),
							success : function(a)
							{
								// alert(a);
								tampilpesan(a);
								// $('#data').load('<?=site_url()?>config/bankdata');
								// $('#form').load('<?=site_url()?>config/bankform/-1');
								data();
								edit(-1);
							}
						});
					}
				});
	});
	$('input#saldo').keyup(function(){
				// alert('a');
				$(this).formatCurrency({symbol:''})
			});
</script>