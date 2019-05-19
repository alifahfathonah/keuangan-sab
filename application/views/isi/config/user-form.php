<form class="form-horizontal" role="form" id="simpanjarak">
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Nama User </label>

		<div class="col-sm-9">
			<input type="text" id="nama_user" name="nama_user" placeholder="Nama User" class="col-xs-12 col-sm-12" value="<?=($id!=-1 ? ($d->row('nama_user')) : '')?>"/>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Alamat </label>

		<div class="col-sm-9">
			<input type="text" id="alamat" name="alamat" placeholder="Alamat" class="col-xs-12 col-sm-12" value="<?=($id!=-1 ? ($d->row('alamat')) : '')?>"/>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Telp </label>

		<div class="col-sm-9">
			<input type="text" id="telp" name="telp" placeholder="Telepon / HP" class="col-xs-12 col-sm-12" value="<?=($id!=-1 ? ($d->row('telp')) : '')?>"/>
		</div>
	</div>	
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Email </label>

		<div class="col-sm-9">
			<input type="email" id="email" name="email" placeholder="Email" class="col-xs-12 col-sm-12" value="<?=($id!=-1 ? ($d->row('email')) : '')?>"/>
		</div>
	</div>	
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Username </label>

		<div class="col-sm-9">
			<input type="text" id="username" name="username" placeholder="Username" class="col-xs-12 col-sm-12" value="<?=($id!=-1 ? ($d->row('username')) : '')?>"/>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Password </label>

		<div class="col-sm-9">
			<input type="text" id="password" name="password" placeholder="Kosongkan Bila Tidak Diganti" class="col-xs-12 col-sm-12" value=""/>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Level </label>

		<div class="col-sm-9">
			<select name="id_level" id="level" class="col-xs-12 col-sm-8" data-rel="chosen">
				<option></option>
				<?
				$lvl=$this->db->from('t_level')->where('status_tampil','t')->order_by('level','asc')->get();
				foreach ($lvl->result() as $k => $v) 
				{
					if($id!=-1)
					{
						if($d->row('id_level')==$v->id_level)
							echo '<option selected="selected" value="'.$d->row('id_level').'">'.$v->level.'</option>';
						else
							echo '<option value="'.$v->id_level.'">'.$v->level.'</option>';
					}
					else
						echo '<option value="'.$v->id_level.'">'.$v->level.'</option>';
				}
				?>
			</select>
			<!-- <input type="text" id="password" name="password" placeholder="Kosongkan Bila Tidak Diganti"  value=""/> -->
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
		$('#form').load('<?=site_url()?>config/userform/-1');
	});
	$("#simpan").on(ace.click_event, function() {
				bootbox.confirm("<h3>Apakah Data User ini sudah Benar </h3>", function(result) {
					if(result) 
					{
						$.ajax({
							url : '<?=site_url()?>config/userproses/<?=$id?>',
							type : 'POST',
							data : $('#simpanjarak').serialize(),
							success : function(a)
							{
								// alert(a);
								tampilpesan(a);
								$('#data').load('<?=site_url()?>config/userdata');
								$('#form').load('<?=site_url()?>config/userform/-1');
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