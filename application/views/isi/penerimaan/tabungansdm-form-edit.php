<form id="simpantabunganproses" style="width:100% !important" class="form-horizontal" method="post">
				
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
												if($det->id_sdm==$v->id_guru)
												{
													echo '<option value="'.$det->id_sdm.'" selected="selected">'.$v->nama_guru;
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
									<option value="<?=$det->no_tabungan_rekening?>" selected="selected"><?=$det->no_tabungan_rekening?></option>
									
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
								<select name="jenistabungan" id="jenistabungan" class="col-xs-12 col-sm-8" data-placeholder="Jenis Tabungan">
									<option value=""></option>
									<?php
									$jenis=strtolower($det->jenis);
									?>
									<option value="Setor" <?=($id!=-1 ? ($jenis=='setor' ? 'selected="selected"' : ''):'')?>>Setor</option>
									<option value="Tarik" <?=($id!=-1 ? ($jenis=='tarik' ? 'selected="selected"' : ''):'')?>>Tarik</option>
									<option value="Infak" <?=($id!=-1 ? ($jenis=='infak' ? 'selected="selected"' : ''):'')?>>Infak</option>
									
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
								<input type="text" name="jumlah" class="" id="jumlah" style="width:30% !important;text-align: right;" required placeholder="0" value="<?=number_format($det->jumlah,0,',','.')?>">
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
								<textarea class="span12" name="keterangan" style="width:90%"><?=($id!=-1 ? $det->keterangan : '')?></textarea>
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