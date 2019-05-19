<form class="form-horizontal" method="post" role="form" id="simpantagihan" action="<?=site_url()?>tagihan/proses/<?=$id?>" enctype="multipart/form-data">
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Upload XLS File </label>

		<div class="col-sm-9">
			<input type="file" id="file" name="file" placeholder="Level" class="col-xs-12 col-sm-12" />
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Level </label>

		<div class="col-sm-5">
			<select name="level" id="level" class="col-xs-12 col-sm-8" data-rel="chosen">
                <option value="PG">PG</option>
                <option value="TK">TK</option>
                <option value="SD">SD</option>
                <option value="SM">SM</option>
			</select>
			<!-- <input type="text" id="password" name="password" placeholder="Kosongkan Bila Tidak Diganti"  value=""/> -->
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Bulan </label>

		<div class="col-sm-5">
			<select name="bulan" id="bulan" class="col-xs-12 col-sm-8" data-rel="chosen">
            <?php
                for($i=1;$i<=12;$i++)
                {
                    if(date('m')==$i)
                        echo '<option value="'.$i.'" selected="selected">'.getBulan($i).'</option>';
                    else
                        echo '<option value="'.$i.'" >'.getBulan($i).'</option>';
                }
            ?>
			</select>
			<!-- <input type="text" id="password" name="password" placeholder="Kosongkan Bila Tidak Diganti"  value=""/> -->
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tahun </label>

		<div class="col-sm-3">
			<select name="tahun" id="tahun" class="col-xs-12 col-sm-8" data-rel="chosen">
            <?php
                for($i=(date('Y')-3);$i<=date(Y);$i++)
                {
                    if(date('Y')==$i)
                        echo '<option value="'.$i.'" selected="selected">'.($i).'</option>';
                    else
                        echo '<option value="'.$i.'" >'.($i).'</option>';
                }
            ?>
			</select>
			<!-- <input type="text" id="password" name="password" placeholder="Kosongkan Bila Tidak Diganti"  value=""/> -->
		</div>
	</div>
	
	<div class="clearfix form-actions">
		<div class="col-md-offset-3 col-md-9">
			<button class="btn btn-info" id="simpan" type="button">			
				<i class="ace-icon fa fa-check bigger-110"></i> OK
			</button>
			
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
	
	$("#simpan").on(ace.click_event, function() {
            // $('#simpantagihan').submit();
				bootbox.confirm("<h3>Apakah Yakin ingin memproses Data ini? </h3>", function(result) {
					if(result) 
					{
                        var form = new FormData($("#simpantagihan")[0]);
						$.ajax({
							url : '<?=site_url()?>tagihan/proses/<?=$id?>',
							type : 'POST',
							data : form,
                            processData: false,
                            contentType: false,
							success : function(a)
							{
								// alert(a);
								//tampilpesan(a);
								// $('#data').load('<?=site_url()?>tagihan/data/<?=$id?>');
                                $('#data').html(a);
								$('#form').load('<?=site_url()?>tagihan/form/<?=$id?>');
							}
						});
					}
				});
	});
	
</script>