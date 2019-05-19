<form class="form-horizontal" role="form" id="simpanjarak">
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Nama Program </label>

		<div class="col-sm-9">
			<input type="text" id="program" name="program" placeholder="Nama Program" class="col-xs-12 col-sm-12" value="<?=($id!=-1 ? ($d->row('program')) : '')?>"/>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Leader </label>

		<div class="col-sm-9">
			<select name="leader_id" data-rel="chosen" class="col-xs-12 col-sm-12 col-md-12 chosen-select">
                <option value="">--Pilih Leader--</option>
				<?php		
				foreach ($leader as $k => $v) 
				{
					if($id!=-1)
					{
						if($d->row('leader_id')==$v->id_guru)
							echo '<option selected="selected" value="'.$d->row('leader_id').'__'.$v->nama_guru.'">'.ucwords($v->nama_guru).'</option>';
						else
							echo '<option value="'.$v->id_guru.'__'.$v->nama_guru.'">'.ucwords($v->nama_guru).'</option>';
					}
					else
						echo '<option value="'.$v->id_guru.'__'.$v->nama_guru.'">'.ucwords($v->nama_guru).'</option>';
				}
				?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Kode Akun </label>

		<div class="col-sm-9">
			<select id="kode_akun" name="kode_akun"  data-rel="chosen" class="col-xs-12 col-sm-12 chosen-select">
                <option value="">--Pilih--</option>
				<?php		
				foreach ($kodeakun as $k => $v) 
				{
					if($id!=-1)
					{
						if($d->row('kode_akun')==$v->akun_alternatif)
							echo '<option selected="selected" value="'.$d->row('kode_akun').'::'.$v->nama_akun.'">'.$v->akun_alternatif.' - '.ucwords($v->nama_akun).'</option>';
						else
							echo '<option value="'.$v->akun_alternatif.'::'.$v->nama_akun.'">'.$v->akun_alternatif.' - '.ucwords($v->nama_akun).'</option>';
					}
					else
						echo '<option value="'.$v->akun_alternatif.'::'.$v->nama_akun.'">'.$v->akun_alternatif.' - '.ucwords($v->nama_akun).'</option>';
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
				bootbox.confirm("<h3>Apakah Data Program ini sudah Benar </h3>", function(result) {
					if(result) 
					{
						$.ajax({
							url : '<?=site_url()?>program/programproses/<?=$id?>',
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