<form class="form-horizontal" role="form" id="simpanjarak">
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Nama Bank </label>

		<div class="col-sm-9">
			<input type="text" id="nama_bank" name="nama_bank" placeholder="Nama Bank" class="col-xs-12 col-sm-12" value="<?=($id!=-1 ? ($d->row('nama_bank')) : '')?>"/>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Nomor Rekening </label>

		<div class="col-sm-9">
			<input type="text" id="no_rekening" name="no_rekening" placeholder="Nomor Rekening" class="col-xs-12 col-sm-12" value="<?=($id!=-1 ? ($d->row('no_rekening')) : '')?>"/>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Nama Rekening </label>

		<div class="col-sm-9">
			<input type="text" id="nama_rekening" name="nama_rekening" placeholder="Nama Rekening" class="col-xs-12 col-sm-12" value="<?=($id!=-1 ? ($d->row('nama_rekening')) : '')?>"/>
		</div>
	</div>	
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Kode Akun Terkait</label>
		<div class="col-sm-9">
			<select name="kode_akun" id="kodeakun" class="col-xs-12 col-sm-12 chosen-select">
				<option value=""></option>
				<?php
				$ajaran=$this->db->from('t_akun')->where('status_tampil','t')->order_by('kode_akun asc')->get();
				$ka=array();
				foreach ($ajaran->result() as $k => $v) 
				{
					$l=strtok($v->kode_akun, '0');
					$ln=strlen($l);
					if($id==-1)
						echo '<option value="'.$v->kode_akun.'" style="padding-left:'.($ln*10).'px;">'.$v->kode_akun.' - '.$v->nama_akun.'</option>';
					else
					{
						if($v->kode_akun==$d->row('kodeakun'))
							echo '<option selected="selected" value="'.$d->row('kodeakun').'" style="padding-left:'.($ln*10).'px;">'.$v->kode_akun.' | '.$v->nama_akun.'</option>';
						else
							echo '<option value="'.$v->kode_akun.'" style="padding-left:'.($ln*10).'px;">'.$v->kode_akun.' - '.$v->nama_akun.'</option>';
					}
					
				}
				?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Saldo </label>

		<div class="col-sm-9">
			<input type="text" id="saldo" name="saldo" placeholder="Saldo" class="col-xs-12 col-sm-12" value="<?=($id!=-1 ? ($d->row('saldo')) : '')?>"/>
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
	$('.chosen-select').chosen({allow_single_deselect:true});
	$('#baru').on('click',function(){
		$('#form').load('<?=site_url()?>config/bankform/-1');
	});
	$("#simpan").on(ace.click_event, function() {
				bootbox.confirm("<h3>Apakah Data Bank ini sudah Benar </h3>", function(result) {
					if(result) 
					{
						$.ajax({
							url : '<?=site_url()?>config/bankproses/<?=$id?>',
							type : 'POST',
							data : $('#simpanjarak').serialize(),
							success : function(a)
							{
								// alert(a);
								tampilpesan(a);
								$('#data').load('<?=site_url()?>config/bankdata');
								$('#form').load('<?=site_url()?>config/bankform/-1');
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