<form class="form-horizontal" role="form" id="simpanjarak">
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Nama Club </label>

		<div class="col-sm-9">
			<input type="text" id="nama_club" name="nama_club" placeholder="Nama CLub" class="col-xs-12 col-sm-12" value="<?=($id!=-1 ? ($d->row('nama_club')) : '')?>"/>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Penanggung Jawab </label>

		<div class="col-sm-9">
			<input type="text" id="nama_club" name="penanggung_jawab" placeholder="Penanggung Jawab" class="col-xs-12 col-sm-12" value="<?=($id!=-1 ? ($d->row('penanggung_jawab')) : '')?>"/>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Email PJ </label>

		<div class="col-sm-9">
			<input type="email" id="nama_club" name="email_pj" placeholder="Email" class="col-xs-12 col-sm-12" value="<?=($id!=-1 ? ($d->row('email_pj')) : '')?>"/>
		</div>
	</div>	
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Telp PJ </label>

		<div class="col-sm-9">
			<input type="email" id="nama_club" name="telp_pj" placeholder="telp" class="col-xs-12 col-sm-12" value="<?=($id!=-1 ? ($d->row('telp_pj')) : '')?>"/>
		</div>
	</div>	
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Biaya Club </label>

		<div class="col-sm-9">
			<input type="text" id="biaya" name="biaya" placeholder="Biaya (Rp)" class="col-xs-12 col-sm-12" value="<?=($id!=-1 ? number_format($d->row('biaya')) : '')?>"/>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Jawal </label>

		<div class="col-sm-9">
			<select name="hari" style="width:50%;float:left">
				<?php
				$hari=array('ahad','senin','selasa','rabu','kamis','jumat','sabtu');
				foreach ($hari as $k => $v) 
				{
					if($id!=-1)
					{
						if($d->row('hari')==$v)
							echo '<option selected="selected" value="'.$d->row('hari').'">'.ucwords($d->row('hari')).'</option>';
						else
							echo '<option value="'.$v.'">'.ucwords($v).'</option>';
					}
					else
						echo '<option value="'.$v.'">'.ucwords($v).'</option>';
				}
				?>
				</select>
				&nbsp;&nbsp;
				<select name="waktu" style="width:45%;float:left;margin-left:5px;">
				<?php
				$waktu=array('08.00','08.30','09.00','09.30','10.00','10.30','11.00','11.30','12.00','12.30','13.00','13.30','14.00','14.30','15.00','15.30','16.00','16.30','17.00','17.30',);
				foreach ($waktu as $k => $v) 
				{
					if($id!=-1)
					{
						if($d->row('waktu')==$v)
							echo '<option selected="selected" value="'.$d->row('waktu').'">'.$d->row('waktu').'</option>';
						else
							echo '<option value="'.$v.'">'.$v.'</option>';
					}
					else
						echo '<option value="'.$v.'">'.$v.'</option>';
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
		$('#form').load('<?=site_url()?>config/clubform/-1');
	});
	$("#simpan").on(ace.click_event, function() {
				bootbox.confirm("<h3>Apakah Data Club ini sudah Benar </h3>", function(result) {
					if(result) 
					{
						$.ajax({
							url : '<?=site_url()?>config/clubproses/<?=$id?>',
							type : 'POST',
							data : $('#simpanjarak').serialize(),
							success : function(a)
							{
								// alert(a);
								tampilpesan(a);
								$('#data').load('<?=site_url()?>config/clubdata');
								$('#form').load('<?=site_url()?>config/clubform/-1');
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