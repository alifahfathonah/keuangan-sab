<form class="form-horizontal" role="form" id="simpanjarak">
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Level </label>

		<div class="col-sm-9">
			<input type="text" id="level" name="level" placeholder="Level" class="col-xs-12 col-sm-12" value="<?=($id!=-1 ? ($d->row('level')) : '')?>"/>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Nama Level </label>

		<div class="col-sm-9">
			<input type="text" id="nama_level" name="nama_level" placeholder="Nama Level" class="col-xs-12 col-sm-12" value="<?=($id!=-1 ? ($d->row('nama_level')) : '')?>"/>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Kategori </label>

		<div class="col-sm-9">
			<select name="kategori" id="kategori" class="col-xs-12 col-sm-8" data-rel="chosen">
				<option value=""></option>
				<optgroup label="Pre School">
					<option value="pg">Play Group</option>
					<option value="tk">TK</option>
				</optgroup>
				<option value="sd">SD</option>
				<option value="sm">SM</option>
				<option value="sm-x">SM X</option>
			</select>
			<!-- <input type="text" id="password" name="password" placeholder="Kosongkan Bila Tidak Diganti"  value=""/> -->
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Kapasitas </label>

		<div class="col-sm-9">
			<input type="text" id="kapasitas" name="kapasitas" placeholder="Kapasitas" class="col-xs-12 col-sm-12" value="<?=($id!=-1 ? ($d->row('kapasitas')) : '')?>"/>
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
		$('#form').load('<?=site_url()?>kelas/levelform/-1');
	});
	$("#simpan").on(ace.click_event, function() {
				bootbox.confirm("<h3>Apakah Data Level Kelas ini sudah Benar </h3>", function(result) {
					if(result) 
					{
						$.ajax({
							url : '<?=site_url()?>kelas/levelproses/<?=$id?>',
							type : 'POST',
							data : $('#simpanjarak').serialize(),
							success : function(a)
							{
								// alert(a);
								tampilpesan(a);
								$('#data').load('<?=site_url()?>kelas/leveldata');
								$('#form').load('<?=site_url()?>kelas/levelform/-1');
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