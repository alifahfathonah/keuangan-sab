<form class="form-horizontal" role="form" id="simpanjarak">
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Kelas </label>

		<div class="col-sm-9">
			<select name="id_level" id="id_level" class="col-xs-3 col-sm-8 chosen-select">
				<option value=""></option>
				<?php
				$kelas=$this->db->from('t_level_kelas')->where('status_tampil','t')->order_by('kategori asc, level asc')->get();
				foreach ($kelas->result() as $k => $v)
				{
					if($id==-1)
						echo '<option value="'.$v->id_level.'">'.$v->nama_level.'</option>';
					else
					{
						if($v->id_level==$d->row('id_level'))
							echo '<option selected="selected" value="'.$d->row('id_level').'">'.$v->nama_level.'</option>';
						else
							echo '<option value="'.$v->id_level.'">'.$v->nama_level.'</option>';
					}
				}
				?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Nama Kelas </label>

		<div class="col-sm-9">
			<input type="text" id="nama_batch" name="nama_batch" placeholder="Nama Kelas" class="col-xs-12 col-sm-12" value="<?=($id!=-1 ? ($d->row('nama_batch')) : '')?>"/>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Wali Kelas </label>

		<div class="col-sm-9">
			<input type="text" id="wali_kelas" name="wali_kelas" placeholder="Wali Kelas" class="col-xs-12 col-sm-12" value="<?=($id!=-1 ? ($d->row('wali_kelas')) : '')?>"/>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tahun Ajaran </label>

		<div class="col-sm-9">
			<select name="tahun_ajaran" id="tahun_ajaran" class="col-xs-12 col-sm-8 chosen-select">
				<option value=""></option>
				<?php
				$ajaran=$this->db->from('t_ajaran')->where('status_tampil','t')->order_by('tahun_ajaran desc')->get();
				foreach ($ajaran->result() as $k => $v)
				{
					if($id==-1)
						echo '<option value="'.$v->tahun_ajaran.'">'.$v->tahun_ajaran.'</option>';
					else
					{
						if($v->tahun_ajaran==$d->row('tahun_ajaran'))
							echo '<option selected="selected" value="'.$d->row('tahun_ajaran').'">'.$v->tahun_ajaran.'</option>';
						else
							echo '<option value="'.$v->tahun_ajaran.'">'.$v->tahun_ajaran.'</option>';
					}

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
	#id_level_chosen,#tahun_ajaran_chosen
	{
		width:100% !important;
	}
</style>
<?php
	$gu=$this->config->item('tguru');
	$nguru='';
	foreach ($gu as $k => $v)
	{
		$nguru.='"'.$v->nama_guru.'",';
	}
	$nguru=substr($nguru, 0,-1);
	// echo
?>
<script type="text/javascript">
	// $('#simpan').click(function(){

	// 	var c=confirm('Apakah Data Jarak Jemputan ini sudah Benar ??');
	// 	if(c)
	// 	{
	//
	// 	}
	// });

			var tag_input = $('#wali_kelas');
				try{
					tag_input.tag(
					  {
						placeholder:tag_input.attr('placeholder'),
						//enable typeahead by specifying the source array
						source: [<?=$nguru?>],//defined in ace.js >> ace.enable_search_ahead
						/**
						//or fetch data from database, fetch those that match "query"
						source: function(query, process) {
						  $.ajax({url: 'remote_source.php?q='+encodeURIComponent(query)})
						  .done(function(result_items){
							process(result_items);
						  });
						}
						*/
					  }
					)

					//programmatically add a new
				}
				catch(e) {
					//display a textarea for old IE, because it doesn't support this plugin or another one I tried!
					tag_input.after('<textarea id="'+tag_input.attr('id')+'" name="'+tag_input.attr('name')+'" rows="3">'+tag_input.val()+'</textarea>').remove();
					//$('#form-field-tags').autosize({append: "\n"});
				}
	$('.chosen-select').chosen({allow_single_deselect:true});
	$('#baru').on('click',function(){
		$('#loader-form').show();
		$('#form').load('<?=site_url()?>kelas/batchform/-1',function(){
			$('#loader-hide').show();

		});
	});
	$("#simpan").on(ace.click_event, function() {
				bootbox.confirm("<h3>Apakah Data Batch Kelas ini sudah Benar </h3>", function(result) {
					if(result)
					{
						$.ajax({
							url : '<?=site_url()?>kelas/batchproses/<?=$id?>',
							type : 'POST',
							data : $('#simpanjarak').serialize(),
							success : function(a)
							{
								// alert(a);
								tampilpesan(a);
								$('#loader-data').show();
								$('#loader-datanon').show();
								$('#loader-form').show();
								$('#data').load('<?=site_url()?>kelas/batchdata/t',function(){
									$('#loader-data').hide();
								});
								$('#datanonaktif').load('<?=site_url()?>kelas/batchdata/f',function(){
									$('#loader-datanon').hide();
								});
								$('#form').load('<?=site_url()?>kelas/batchform/-1',function(){
									$('#loader-form').hide();
								});
								//$('.nav-tabs a[href="#home"]').tab('show');
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
