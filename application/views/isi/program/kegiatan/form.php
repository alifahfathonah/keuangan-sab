<form class="form-horizontal" role="form" id="simpanjarak">

	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Program </label>

		<div class="col-sm-9">
			<select name="program_id" id="program_id" style="width:50%;float:left" data-rel="chosen" class="col-xs-12 col-sm-8 chosen-select">
                <option value=""></option>
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
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Sasaran Mutu </label>

		<div class="col-sm-9" id="sasaran_mutu_select">
			<select id="sasaran_mutu" name="sasaran_mutu"  data-rel="chosen" class="col-xs-12 col-sm-8 chosen-select">
                <option value="">--Pilih--</option>
				<?php		
				foreach ($sasaranmutu as $k => $v) 
				{
					if($id!=-1)
					{
						if($d->row('sasaran_mutu_id')==$v->id)
							echo '<option selected="selected" value="'.$d->row('sasaran_mutu_id').'::'.$v->sasaran_mutu.'">'.ucwords($v->sasaran_mutu).'</option>';
						else
							echo '<option value="'.$v->id.'::'.$v->sasaran_mutu.'">'.ucwords($v->sasaran_mutu).'</option>';
					}
					else
						echo '<option value="'.$v->id.'::'.$v->sasaran_mutu.'">'.ucwords($v->sasaran_mutu).'</option>';
				}
				?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Nama Kegiatan </label>

		<div class="col-sm-9">
			<textarea name="kegiatan" class="col-xs-12 col-sm-12"><?=($id!=-1 ? ($d->row('kegiatan')) : '')?></textarea>
		</div>
	</div>
    <!-- <div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Kode Akun </label>

		<div class="col-sm-9">
			<select id="kode_akun" name="kode_akun"  data-rel="chosen" class="col-xs-12 col-sm-8 chosen-select">
                <option value="">--Pilih--</option>
				<?php		
				// foreach ($kodeakun as $k => $v) 
				// {
				// 	if($id!=-1)
				// 	{
				// 		if($d->row('kode_akun')==$v->akun_alternatif)
				// 			echo '<option selected="selected" value="'.$d->row('kode_akun').'::'.$v->nama_akun.'">'.$v->akun_alternatif.' - '.ucwords($v->nama_akun).'</option>';
				// 		else
				// 			echo '<option value="'.$v->akun_alternatif.'::'.$v->nama_akun.'">'.$v->akun_alternatif.' - '.ucwords($v->nama_akun).'</option>';
				// 	}
				// 	else
				// 		echo '<option value="'.$v->akun_alternatif.'::'.$v->nama_akun.'">'.$v->akun_alternatif.' - '.ucwords($v->nama_akun).'</option>';
				// }
				?>
			</select>
		</div>
	</div> -->
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
</form>
<style type="text/css">
	.form-group label
	{
		font-size:10px !important;
	}
    #sasaran_mutu_chosen,#program_id_chosen,#kode_akun_chosen
	{
		width:100% !important;
	}
    #bulan_chosen,#tahun_chosen,#tahun_ajaran_chosen
	{
		width:30% !important;
	}
</style>

<script type="text/javascript">
	$('.chosen-select').chosen({allow_single_deselect:true});
    $('input#saldo').keyup(function(){
				// alert('a');
		$(this).formatCurrency({symbol:''})
	});

	$('#program_id').change(function(){
		var id=$(this).val();
		$('#sasaran_mutu_select').load('<?=site_url()?>sasaranmutu/byprogram/'+id,function(){
			$('.chosen-select').chosen({allow_single_deselect:true});
		});
	});
	$('#baru').on('click',function(){
		// $('#form').load('<?=site_url()?>program/bankform/-1');
		edit(-1);
	});
	$("#simpan").on(ace.click_event, function() {
				bootbox.confirm("<h3>Apakah Data Kegiatan ini sudah Benar </h3>", function(result) {
					if(result) 
					{
						$.ajax({
							url : '<?=site_url()?>kegiatan/proses/<?=$id?>',
							type : 'POST',
							data : $('#simpanjarak').serialize(),
							success : function(a)
							{
								// alert(a);
								tampilpesan(a);
								// $('#data').load('<?=site_url()?>config/bankdata');
								// $('#form').load('<?=site_url()?>config/bankform/-1');
								data(-1);
								edit(-1);
							}
						});
					}
				});
	});
</script>
