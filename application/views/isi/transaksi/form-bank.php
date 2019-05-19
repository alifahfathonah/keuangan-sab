<!--<?=site_url()?>transaksi/process/1-Bank-->
<form class="form-horizontal" role="form" id="simpantransaksibank" action="<?=site_url()?>transaksi/process/1-Bank" method="post">

	<legend>Form Transanksi Bank</legend>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Tanggal Transaksi </label>

		<div class="col-sm-9">
			<div class="input-group" style="width:100px !important;">
				<input  id="tanggal_transaksi_bank" name="tanggal_transaksi" type="text" data-date-format="dd-mm-yyyy" style="width:110px !important;" placeholder="Tgl Transaksi" oninvalid="this.setCustomValidity('Tanggal Transaksi Harus Diisi')"  value="<?=(date("d-m-Y"))?>"/>
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
			<th class="center">Nama Siswa</th>
			<th class="center">Tahun Ajaran</th>
			<th class="center">Persiapan</th>
			<th class="center">Jumlah Tagihan</th>
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

	for ($i=0; $i <5 ; $i++)
	{
	?>
		<tr>
			<td class="center" style="width:30px"><?=($i+1)?></td>
			<td class="left" style="width:200px;">
				<select name="siswaa[<?=$i?>]" id="siswaa" class="siswaa_<?=$i?> col-xs-12 col-sm-12 chosen-select" onchange="getkelas(this.value,<?=$i?>)" data-rel="chosen">
					<option value="">-Pilih Nama Siswa-</option>
					<?php
					foreach ($siswa as $k => $v)
					{
						echo '<option value="'.$v->id.'__'.$v->nis.'__'.str_replace(' ', '%20', $v->nama_murid).'">'.$v->nama_murid.'</option>';
					}
					?>
				</select>
			</td>
			<td class="center" style="width:150px"><div id="kelas_<?=$i?>"></div></td>
			<td class="text-center">
				<select name="persiapan[<?=$i?>]" id="persiapan<?=$i?>">
					<option value="0">Tidak</option>
					<option value="1">Ya</option>
				</select>
			</td>
			<td class="left" style="width:250px"><div id="tagihan_<?=$i?>"></div></t>
			<td class="center" style="width:150px;">
				<input name="bankasal[<?=$i?>]" id="bankasal<?=$i?>" type="text" style="float:left;text-align:left !important;width:95%;font-size:11px !important;"></td>
			<td class="center" style="width:150px;">
				<select name="banktujuan[<?=$i?>]" id="banktujuan<?=$i?>" style="width:95%"><?=$dbank?></select>
			</td>
			<td class="center" style="width:150px;">

				<input name="nominal[<?=$i?>]" id="nominal<?=$i?>" class="nom" type="text" style="float:right;text-align:right !important;width:95%;font-size:11px !important;" placeholder='0'></td>
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

	<div class="hr hr-24"></div>
</form>
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
	$('#tanggal_transaksi_bank').datepicker({
		autoclose: true,
		todayHighlight: true
	});
	function getkelas(nis,id)
	{
		// var nis=$(this).val();
		// alert(id);
		$('div#kelas_'+id).load('<?=site_url()?>kelas/getkelasbynis/'+nis+'/0/'+id,function(a){
			var dkls=$('#dkelas').val();
			// if(dkls=='')
			// {
			// 	$('#tagihan_'+id).load('<?=site_url()?>transaksi/tagihan/'+nis+'/null/0');
			// }
			// else
			// {
				dkls=dkls.replace(/\//g,'::');
				dkls=dkls.replace(/ /g,'%20');
				// var dkelas=dkls.split('__');
				// var dd=$('#dkelas').val();
				// var idkelassiswa=dkelas[0];
				// var batch_id=dkelas[1];
				$('#tagihan_'+id).load('<?=site_url()?>transaksi/tagihan/'+nis+'/'+dkls+'/0');
			//}
		});
	}

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
						// $('form#simpantransaksibank').submit();
						$.ajax({
							url : '<?=site_url()?>transaksi/process/1-Bank',
							type : 'POST',
							data : $('#simpantransaksibank').serialize(),
							success : function(a){
								window.open(
									'<?=site_url()?>transaksi/cetakkwitansi/'+a,
									'_blank'
								);
								location.href='<?=site_url()?>transaksi/penerimaan';
							}
						});
					}
				});
			});
</script>
