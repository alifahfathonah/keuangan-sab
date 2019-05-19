<form id="simpanjarak" style="width:100% !important" class="form-horizontal" action="<?=site_url()?>penerimaan/tabunganproses/<?=$id?>" method="post">
				
					<div class="form-group">

						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Nama SDM</label>
							<div class="col-sm-9">
								<select  class="chosen-select" name="id_guru" id="siswaa" data-placeholder="Nama SDM">
									<option value=""></option>
									<?php
									// $siswa=$this->db->from('t_siswa')->where('status_tampil','t')->order_by('nama_murid')->get()->result();
									if(count($d)!=0)
									{
										foreach ($d as $k => $v) 
										{
											
											if($id!=-1)
											{
												if($d->row('id_guru')==$v->id_guru)
												{
													echo '<option value="'.$d->row('id_guru').'" selected="selected">'.$v->nama_guru;
													break;
												}
												else
													echo '<option value="'.$v->id_guru.'">'.$v->nama_guru.' </option>';
											}
											else
												echo '<option value="'.$v->id_guru.'">'.$v->nama_guru.' </option>';
											
										}
									}
									?>
								</select>
								<div id="pesansiswa" style="font-size: 9px;color:red;font-style: italic; display: none;"></div>
								</div>
								
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Nomor Rekening</label>
							<div class="col-sm-9">
								<select name="no_rekening_tabungan" id="no_rekening_tabungan" class="col-xs-12 col-sm-8" data-placeholder="Nomor Rekening">
									<option value=""></option>
									<option value="0">Input No Rekening Baru</option>
								</select>
                                <input type="hidden" name="no_rekening_baru" class="col-xs-12 col-sm-8" id="no_rekening_baru" placeholder="Input Nomor Rekening Baru">
								<div id="pesanjenistabungan" style="font-size: 9px;color:red;font-style: italic;display: none;"></div>
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

						<!-- <div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Penyetor/Penarik</label>
							<div class="col-sm-9">
							</div>
						</div> -->
								<input type="hidden" name="penyetor" class="" id="penyetor" required placeholder="">
						
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
<?php
	$no=date('Ymd');
	$norek=abs(crc32($no.rand()));
	$norek=$no.'-'.substr($norek,0,5);
?>
<script type="text/javascript">
    $('#no_rekening_tabungan').change(function(){
        var id=$(this).val();
        if(id==0)
        {
            //alert(id);
            $('input#no_rekening_baru').prop('type','text');
            $('input#no_rekening_baru').val('<?=$norek?>');
        }
        else
            $('input#no_rekening_baru').prop('type','hidden');
    });
    $('#siswaa').change(function(){
        var id=$(this).val();
        $('#no_rekening_tabungan').children('option:not(:first)').remove();
         $.ajax({
                url : '<?=site_url()?>penerimaan/cekkoderek/'+id,
                success : function(a){
                    //no_rekening_tabungan
                    //alert(a);
					var norek=a.split(',');
                    if(norek.length!=0)
                    {
                        for(var i=0; i<norek.length; i++)
                        {
                            $('#no_rekening_tabungan').append('<option value="'+norek[i]+'" selected="selected">'+norek[i]+'</option>');
                        }
                    }
                    else
                        $('#no_rekening_tabungan').append('<option value="'+a+'" selected="selected">'+a+'</option>');
                    
                    $('#no_rekening_tabungan').append('<option value="0">Input No Rekening Baru</option>');
                }
            });
    });
	$('#baru').on('click',function(){
		$('#form').load('<?=site_url()?>penerimaan/tabungansdmform/-1');
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
			$('#pesansiswa').text('Nama SDM Belum Dipilih');
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
				bootbox.confirm("<h3>Apakah Data Tabungan SDM ini sudah Benar </h3>", function(result) {
					if(result) 
					{
						$.ajax({
							url : '<?=site_url()?>penerimaan/tabungansdmproses/<?=$id?>',
							type : 'POST',
							data : $('#simpanjarak').serialize(),
							success : function(a)
							{
								// alert(a);
								tampilpesan(a);
								$('#data').load('<?=site_url()?>penerimaan/tabungansdmdata');
								$('#form').load('<?=site_url()?>penerimaan/tabungansdmform/-1');
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