<form id="simpanjurnal" style="width:100% !important" class="form-horizontal" action="<?=site_url()?>laporan/jurnaleditproses/<?=$id?>" method="post">
				
					<div class="form-group">
                        <input type="hidden" name="status" value="<?=$status?>">
                        <input type="hidden" name="total" value="<?=$total?>">
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Kode Akun</label>
							<div class="col-sm-9">
								<select  data-rel="chosen" class="chosen-select form-control tag-input-style" name="kodeakun" id="kodeakun" data-placeholder="Kode Akun">
									<option value=""></option>		
                                    <?php
                                    foreach($akun as $k => $v)
                                    {
                                        if($v->akun_alternatif==$kodeakun)
                                        {
                                            echo '<option value="'.$kodeakun.'-'.$v->kode_akun.'-'.$v->nama_akun.'" selected="selected">'.$kodeakun.' - '.$v->nama_akun.'</option>';
                                        }
                                        else
                                            echo '<option value="'.$v->akun_alternatif.'-'.$v->kode_akun.'-'.$v->nama_akun.'">'.$v->akun_alternatif.' - '.$v->nama_akun.'</option>';
                                    }
                                    ?>			
								</select>
							</div>
								
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Tanggal</label>
							<div class="col-sm-9">
								<input type="text" name="tanggal" class="" id="tanggal" style="width:30% !important;" required placeholder="Tanggal" value="<?=($id!=-1 ? date('d-m-Y', strtotime($tanggal)) : '')?>">
							</div>
						</div>
						
                        <input type="hidden" name="jlhlama" value="<?=$jumlah?>">
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Jumlah</label>
							<div class="col-sm-9">
								<input type="text" name="jumlah" class="" id="jumlah" style="width:30% !important;" required placeholder="Jumlah" value="<?=($id!=-1 ? $jumlah : '')?>">
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Keterangan</label>
							<div class="col-sm-9">
								<textarea class="span12" name="keterangan" style="width:90%"><?=($id!=-1 ? $keterangan : '')?></textarea>
							</div>
						</div>
</form>
<script>
$('.chosen-select').chosen({allow_single_deselect:true});
$('#tanggal').datepicker({
		autoclose: true,
		todayHighlight: true,
        format : 'dd-mm-yyyy',
	});
</script>
<style type="text/css">
	#kodeakun_chosen
	{
		width:340px !important;
	}
</style>