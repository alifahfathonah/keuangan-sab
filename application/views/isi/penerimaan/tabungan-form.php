<form id="simpanjarak" style="width:100% !important" class="form-horizontal" action="<?=site_url()?>penerimaan/tabunganproses/<?=$id?>" method="post">
				
					<div class="form-group">

						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Nama Siswa</label>
							<div class="col-sm-9">
								<select  class="chosen-select" name="siswa" id="siswaa" data-placeholder="Nama Siswa">
									<option value=""></option>
									<?php
									// $siswa=$this->db->from('t_siswa')->where('status_tampil','t')->order_by('nama_murid')->get()->result();
									if(count($d)!=0)
									{
										foreach ($d as $k => $v) 
										{
											
											$dSiswa=$vbs[$v->nis];
											if($id!=-1)
											{
												if($d->row('nis')==$v->nis)
												{
													echo '<option value="'.$d->row('nis').'__'.$d->row('id').'__'.$d->row('nama_siswa').'__'.$dSiswa->id_batch.'" selected="selected">'.$v->nama_murid.' ('.$dSiswa->nama_batch.')</option>';
													break;
												}
												else
													echo '<option value="'.$v->nis.'__'.$v->id.'__'.$v->nama_murid.'__'.$dSiswa->id_batch.'">'.$v->nama_murid.' ('.$dSiswa->nama_batch.')</option>';
											}
											else
												echo '<option value="'.$v->nis.'__'.$v->id.'__'.$v->nama_murid.'__'.$dSiswa->id_batch.'">'.$v->nama_murid.' ('.$dSiswa->nama_batch.')</option>';
											
										}
									}
									?>
								</select>
								<div id="pesansiswa" style="font-size: 9px;color:red;font-style: italic; display: none;">asd</div>
								</div>
								
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Tanggal</label>

							<div class="col-sm-9">
								<div class="input-group" style="width:100px !important;">
									<input  id="tanggal_transaksi" name="tanggal" type="text" data-date-format="yyyy-mm-dd" style="width:110px !important;" placeholder="Tgl Transaksi" oninvalid="this.setCustomValidity('Tanggal Transaksi Harus Diisi')"  value="<?=(date("Y-m-d"))?>"/>
									<span class="input-group-addon">
									<i class="fa fa-calendar bigger-110"></i>
									</span>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Jenis Tabungan</label>
							<div class="col-sm-9">
								<select name="jenistabungan" id="jenistabungan" class="col-xs-12 col-sm-8 chosen-select" data-placeholder="Jenis Tabungan">
									<option value=""></option>
									<option value="Setor">Setor</option>
									<option value="Sampah">Tabungan Sampah</option>
									<option value="Tarik">Tarik</option>
									<option value="Infak">Infak</option>
									
								</select>
								<div id="pesanjenistabungan" style="font-size: 9px;color:red;font-style: italic;display: none;"></div>
							</div>
						</div>
						<!-- <div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Kelas</label>
							<div class="col-sm-9">
								<select name="kelas" id="kelas" class="col-xs-12 col-sm-8 chosen-select" data-placeholder="Kelas">
									<option value=""></option>
									
								</select>
							</div>
						</div> -->
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Jumlah</label>
							<div class="col-sm-9">
								<input type="text" name="jumlah" class="" id="jumlah" style="width:30% !important;text-align: right;" required placeholder="0" value="">
								<div id="pesanjumlah" style="font-size: 9px;color:red;font-style: italic;display: none;"></div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Penyetor/Penarik</label>
							<div class="col-sm-9">
								<input type="text" name="penyetor" class="" id="penyetor" required placeholder="">
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Keterangan</label>
							<div class="col-sm-9">
								<textarea class="span12" name="keterangan" style="width:90%"><?=($id!=-1 ? $d->row('keterangan') : '')?></textarea>
							</div>
						</div>
						
				<div class="clearfix form-actions">
					<div class="col-md-offset-3 col-md-9">
						<button class="btn btn-info" id="simpan" type="button">
							
							<?=(($id!=-1 ) ? '<i class="ace-icon fa fa-pencil bigger-110"></i> Edit' : '<i class="ace-icon fa fa-check bigger-110"></i> Simpan')?>
						</button>
						<?php
						if($id!=-1 )
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
	#siswaa_chosen,#iddriver_chosen
	{
		width:90% !important;
	}
	input
	{
		font-size:11px !important;
	}
</style>
<script type="text/javascript">
	$('#baru').on('click',function(){
		$('#form').load('<?=site_url()?>penerimaan/tabunganform/-1');
	});
	$('#tanggal_transaksi').datepicker({
		autoclose: true,
		todayHighlight: true
	});
	$('.chosen-select').chosen({allow_single_deselect:true});
	$("#simpan").on(ace.click_event, function() {
		var siswa =$('#siswaa').val();
		var jenistabungan=$('#jenistabungan').val();
		var jumlah=$('#jumlah').val();
		if(siswa=='')
		{
			// alert(siswa);
			$('#pesansiswa').css({'display':'block'});
			$('#pesansiswa').text('Nama Siswa Belum Dipilih');
			setInterval(function(){ $('#pesansiswa').css({'display':'none'}); }, 3000);
		}
		else if(jenistabungan=='')
		{
			$('#pesanjenistabungan').css({'display':'block'});
			$('#pesanjenistabungan').text('Jenis Tabungan Belum Dipilih');
			setInterval(function(){ $('#pesanjenistabungan').css({'display':'none'}); }, 3000);
		}
		else if(jumlah=='')
		{
			// alert('kosong');
			$('#pesanjumlah').css({'display':'block'});
			$('#pesanjumlah').text('Jumlah Belum Diisi');
			setInterval(function(){ $('#pesanjumlah').css({'display':'none'}); }, 3000);
		}
		else
		{
				bootbox.confirm("<h3>Apakah Data Tabungan Siswa ini sudah Benar </h3>", function(result) {
					if(result) 
					{
						$.ajax({
							url : '<?=site_url()?>penerimaan/tabunganproses/<?=$id?>',
							type : 'POST',
							data : $('#simpanjarak').serialize(),
							success : function(a)
							{
								// alert(a);
								tampilpesan(a);
								$('#data').load('<?=site_url()?>penerimaan/tabungandata');
								$('#form').load('<?=site_url()?>penerimaan/tabunganform/-1');
							}
						});
					}
				});
			}
	});
	$('input#jumlah').keyup(function(){
				// alert('a');
				$(this).formatCurrency({symbol:''})
			});
</script>