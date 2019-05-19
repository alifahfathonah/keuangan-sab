	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Tanggal Transaksi </label>

		<div class="col-sm-9">
			<div class="input-group" style="width:100px !important;">
				<input  id="tanggal_transaksi" name="tanggal_transaksi" type="text" data-date-format="dd-mm-yyyy" style="width:110px !important;" placeholder="Tgl Transaksi" oninvalid="this.setCustomValidity('Tanggal Transaksi Harus Diisi')"  value="<?=(date("d-m-Y"))?>"/>
				<span class="input-group-addon">
				<i class="fa fa-calendar bigger-110"></i>
				</span>
			</div>
		</div>
	</div>
<table id="simple-table" class="table table-striped table-bordered table-hover">
	<thead>
		<tr>
			<th class="center">No</th>
			<th class="center">Jenis Pengeluaran</th>
			<th class="center">Nama Penerima</th>
			<th class="center">Keterangan</th>
			<th class="center">Bank Asal</th>
			<th class="center">Bank Tujuan</th>
			<th class="center">Nominal</th>
		</tr>
		<tr>
		</tr>
	</thead>
	<tbody>
	<?php
	$dbank='<option value="">-Pilih Bank-</option>';
	// echo '<pre>';
	// print_r($bank);
	// echo '</pre>';
	foreach ($bank as $k => $v) 
	{
		$dbank.='<option value="'.$v->id_bank.'__'.str_replace(' ', '_', $v->nama_bank).'">'.$v->nama_bank.' ['.$v->no_rekening.']</option>';
	}

	for ($i=0; $i <10 ; $i++) 
	{ 
	?>
		<tr>
			<td class="center"><?=($i+1)?></td>
			<td class="left" style="width:200px;">
				<select class="col-xs-12 col-sm-8 chosen-select frm" id="jenis" name="jenis[<?=$i?>]" data-placeholder="Pilih Jenis Pengeluaran" >
					<option></option>
					<?
						foreach($jenis as $k => $v)
						{
							echo '<option value="'.$v->id.'__'.$v->jenis.'">'.$v->jenis.'</option>';
						}
					?>
				</select>
			</td>
			<td class="center">
			<input name="penerima[<?=$i?>]" id="penerima<?=$i?>" class="nom" type="text" style="float:right;text-align:left !important;width:95%;font-size:11px !important;" placeholder='Nama Penerima'>
			</td>
			<td class="left" style="width:250px">
			<input name="keterangan[<?=$i?>]" id="keterangan<?=$i?>" class="nom" type="text" style="float:right;text-align:left !important;width:95%;font-size:11px !important;" placeholder='Keterangan'>
			</t>
			<td class="" style="width:250px;">
				<select class="col-xs-12 col-sm-12 chosen-select frm" name="bankasal[<?=$i?>]" id="bankasal<?=$i?>" style="width:95%"><?=$dbank?></select>
			</td>
			<td class="center" style="width:150px;">
				<input name="banktujuan[<?=$i?>]" id="banktujuan<?=$i?>" type="text" style="float:left;text-align:left !important;width:95%;font-size:11px !important;" placeholder="Nama Bank-No.Rek">
			</td>
			<td class="center" style="width:150px;">
				<input name="nominal[<?=$i?>]" id="nominal<?=$i?>" class="nom" type="text" style="float:right;text-align:right !important;width:95%;font-size:11px !important;" placeholder='0'>
			</td>
		</tr>
	<?php
	}
	?>
	</tbody>
</table>
	<div class="clearfix form-actions">
		<div class="col-md-offset-3 col-md-9">
			<button class="btn btn-info" id="simpantrbank" type="button">
				
				<i class="ace-icon fa fa-check bigger-110"></i> Simpan Transaksi
			</button>
			&nbsp; &nbsp; &nbsp;
		</div>
	</div>


<style type="text/css">
	#siswaa_chosen
	{
		width:95% !important;
		font-size:11px !important;
	}
	label
	{
		font-size:11px !important;
	}
</style>
<script type="text/javascript">
	$('.chosen-select').chosen({allow_single_deselect:true});



	$('input.nom').each(function(a){
		// alert(a);
		$(this).keyup(function(){

			$(this).formatCurrency({symbol:''});
		});
	});
	$('#simpantrbank').on(ace.click_event, function() {
				bootbox.confirm("<h3>Apakah Data Transaksi Bank ini sudah Benar </h3>", function(result) {
					if(result) 
					{
						$('form#simpanpengeluaranbank').submit();

					}
				});
			});
</script>