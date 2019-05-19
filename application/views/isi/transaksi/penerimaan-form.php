
<div class="row">
	<div class="col-xs-6">
		<div class="form-group" style="margin-bottom:0px;">
			<label class="col-sm-3 control-label no-padding-right" for="form-field-1">No. Kwitansi&nbsp;&nbsp;</label>

			<div class="col-sm-9" style="padding-top:5px;font-weight:bold;margin-left:0px;">
				<span class="input-icon">
				<?php
				$idt=date('dmyHi').substr(abs(crc32(md5(sha1(rand())))),0,4);
				?>
					: <?=$idt?><input type="hidden" name="idt" value="<?=$idt?>">
				</span>
			</div>
		</div>
		
		<div class="form-group" style="margin-bottom:3px;">
			<label class="col-sm-3 control-label no-padding-right">Dari&nbsp;&nbsp;<i class="icon-envelope"></i></label>

			<div class="col-sm-9">
				<span class="input-icon">
					<input type="text" placeholder="Dari" class="frm" id="dari" name="dari" style="padding-left:10px;background:#fff;font-size:11px;">		
				</span>
			</div>
		</div>
		<div class="form-group" style="margin-bottom:3px;">
			<label class="col-sm-3 control-label no-padding-right">Telepon&nbsp;&nbsp;<i class="icon-phone"></i></label>

			<div class="col-sm-9">
				<span class="input-icon">
					<input type="text" class="frm" placeholder="Telepon" id="telepon" name="telepon" style="padding-left:10px;background:#fff;font-size:11px;">		
				</span>
			</div>
		</div>
	</div>
	<div class="col-xs-6">
		<div class="form-group" style="margin-bottom:0px;">
			<label class="col-sm-3 control-label no-padding-right" >Tanggal&nbsp;&nbsp;</label>

			<div class="col-sm-9" style="padding-top:5px;font-weight:bold;margin-left:0px;">
				<span class="input-icon">
					<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-calendar bigger-110"></i>
							</span>
							<input type="text" class="form-control" placeholder="Tanggal" id="tgltrans" name="tgltrans" style="padding-left:10px;background:#fff;font-size:11px;width:100px" value="<?=date('d-m-Y')?>">		
					</div>
					
				</span>
			</div>
		</div>
		
		<div class="form-group" style="margin-bottom:3px;">
			<label class="col-sm-3 control-label no-padding-right">Jenis Penerimaan&nbsp;&nbsp;<i class="icon-shopping-cart"></i></label>

			<div class="col-sm-9">
				<span class="input-icon">
					<select class="col-xs-12 col-sm-8 chosen-select frm" id="jenis" data-placeholder="Pilih Jenis Penerimaan" >
						<option></option>
						<?php
						foreach($jenis as $k => $v)
						{
							echo '<option value="'.$v->id.'_'.$v->kode_akun.'_'.$v->akun_alternatif.'_'.$v->nama_akun.'">'.$v->akun_alternatif.' - '.$v->nama_akun.'</option>';
						}
						?>
					</select>
				</span>
			</div>
		</div>
		<div class="form-group" style="margin-bottom:3px;">
			<label class="col-sm-3 control-label no-padding-right">Jumlah&nbsp;&nbsp;<i class="icon-shopping-cart"></i></label>

			<div class="col-sm-9">
				<span class="input-icon">
					<input type="text" min="0" placeholder="Jumlah" class="frm nom" id="jumlah" name="jumlah" style="padding-left:10px;background:#fff;width:80%;font-size:11px;">
				</span>
			</div>
		</div>
		<div class="form-group" style="margin-bottom:3px;">
			<label class="col-sm-3 control-label no-padding-right">Keterangan</label>

			<div class="col-sm-9">
					<input type="text" min="0" placeholder="keterangan" class="frm" id="keterangan" name="keterangan" style="padding-left:10px;background:#fff;width:80%;font-size:11px;">	<button class="btn btn-primary btn-mini" id="btnAdd" type="button">Tambah</button>	
			</div>
		</div>
		
	</div>
	
</div>
<div style="border-top:1px dotted #ddd;">
	<table id="sample-table-2" class="table table-striped table-bordered table-hover" style="margin-top:5px;">
		<thead>
			<tr>
				<th style="width:20px">No</th>
				<th style="width:250px">Jenis Penerimaan</th>
				<th>Dari</th>
				<th>Keterangan</th>
				<th style="width:150px;">Jumlah</th>
				<!-- <th style="width:150px;">Subtotal</th> -->
				<th style="width:70px">Aksi</th>
			</tr>
		</thead>
		<tbody id="detailtr">

		</tbody>
		<thead>
			<tr>
				<th colspan="2" style="text-align:right;">
				</th>
				<th style="text-align:right;" colspan="3">
				<!-- 	<div>
						SUBTOTAL &nbsp;&nbsp;
						<input type="text" readonly placeholder="0" id="subtotal" name="subtotal" style="padding-left:10px;background:#fff !important;font-size:11px;text-align:right;margin-bottom:3px;width:150px;">
					</div> -->
					
					<div>
						Total &nbsp;&nbsp;
						<input type="text" readonly="" placeholder="0" id="total" name="total" style="padding-left:10px;background:#fff ;font-size:20px;text-align:right;width:150px;margin-bottom:3px;">
					</div>
				</th>
				<th style="text-align:center;vertical-align:bottom;padding-bottom:11px;"> 
					<button class="btn btn-mini btn-primary" type="button" id="submitlain"><i class="icon icon-save"></i>Simpan</button>
				</th>
			</tr>
		</thead>
	</table>
</div>
						
<style type="text/css">
	#jenis_chosen
	{
		width:400px !important;
	}
    .frm
    {
        width:400px !important;
    }
</style>
<script type="text/javascript">
function Add()
{
	var jumlah=$('#jumlah').val();
	var keterangan=$('#keterangan').val();
	// alert(service);
	var jenis=$('#jenis').val();
	var penerima=$('#dari').val();
	var i=$('#detailtr tr').length;
	if(jenis=='')
	{
		alert('Data Jenis Belum Dipilih !!!');
	}
	else if(jumlah=='')
	{
		alert('Jumlah Pengeluaran Belum Diisi !!!');
	}	
	else if(penerima=='')
	{
		alert('Nama Penerima Belum Diisi !!!');
	}
	else
	{

		var ss=jenis.replace(/%20/g,' ');
		ss=jenis.split('_');
		// var tot = 'Rp. '+numeral(total).format('0,0');
		var subtotal=jumlah;
		// var jenis_satuan=ss[4];
		$('#detailtr').append(
			"<tr>"+
			"<td>"+(i+1)+"</td>"+
			"<td>"+ss[2]+" "+ss[3]+"<input type='hidden' name='jenis[]' value='"+jenis+"'></td>"+
			"<td>"+penerima+"<input type='hidden' name='dari[]' value='"+penerima+"'></td>"+
			"<td>"+keterangan+"<input type='hidden' name='ket[]' value='"+keterangan+"'></td>"+
			//"<td>"+numeral(ss[2]).format('0,0')+"<input type='hidden' name='jenispengeluaran[]' value='"+jenis+"'></td>"+
			"<td style='text-align:right;width:200px;' id='tot'>"+numeral(jumlah).format('0,0')+"<input type='hidden' name='jlh[]' value='"+jumlah+"'></td>"+
			// "<td style='text-align:right;width:200px;' id='subt'>"+numeral(subtotal).format('0,0')+"<input type='hidden' name='subtotal[]' value='"+subtotal+"'></td>"+
			"<td><button class='btn btn-xs btn-danger btnDelete' type='button'><i class='fa fa-trash'></i></button></td></tr>");
		// i++;
		$('.btnDelete').bind("click",Delete);
		calculateTable('tot');

        $('#jenis').val('').trigger('chosen:updated');
	}
}
function Delete()
{
	var par = $(this).parent().parent();
	par.remove();
	calculateTable('tot');
}
function calculateTable(id)
{
	// var total=parseFloat($('#total').val().replace(',',''));
	var total=0;
	$('td#'+id).each(function(a){
		var n=parseFloat(($(this).text()).replace(/,/g,''));
		total+=n;
	});
	
	
	$('#total').val(numeral(total).format('0,0'));
	$('#bayar').focus();
	$('.frm').each(function(a){
		$(this).val('');
	});
}
jQuery(function($){

    $('input.nom').each(function(a){
		// alert(a);
		$(this).keyup(function(){

			$(this).formatCurrency({symbol:''});
		});
	});
	$('#btnAdd').bind('click',Add);
	$('#tgltrans').datepicker({
		format : 'dd-mm-yyyy',
		autoclose:true
	}).on('changeDate', function(ev){
		// alert(ev.format());
		$(this).val(ev.format());
	});;
});
</script>