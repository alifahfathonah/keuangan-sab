<form id="edittabungan" style="width:100% !important" class="form-horizontal" action="" method="post">
				
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
												if($v->id==$det->siswa_id)
												{
													echo '<option value="'.$v->nis.'__'.$v->id.'__'.$v->nama_siswa.'__'.$dSiswa->id_batch.'" selected="selected">'.$v->nama_murid.' ('.$dSiswa->nama_batch.')</option>';
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
							<?php
								if($id!=-1)
								{
									$tgl=strtok($det->tanggal, ' ');
								}
								else
									$tgl=date('Y-m-d');
							?>
								<div class="input-group" style="width:100px !important;">
									<input  id="tanggal_transaksi_edit" name="tanggal" type="text" data-date-format="yyyy-mm-dd" style="width:110px !important;" placeholder="Tgl Transaksi" oninvalid="this.setCustomValidity('Tanggal Transaksi Harus Diisi')"  value="<?=$tgl?>"/>
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
								<?php
								if($id!=-1)
								{
									$jenis=strtolower($det->jenis);
								}
								?>
									<option value=""></option>
									<option value="Setor" <?=($id!=-1 ? ($jenis=='setor' ? 'selected="selected"' : ''):'')?>>Setor</option>
									<option value="Sampah" <?=($id!=-1 ? ($jenis=='sampah' ? 'selected="selected"' : ''):'')?>>Tabungan Sampah</option>
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
								<input type="text" name="jumlah" class="" id="jumlah" style="width:30% !important;text-align: right;" required placeholder="0" value="<?=($id!=-1 ? $det->jumlah : '')?>">
								<div id="pesanjumlah" style="font-size: 9px;color:red;font-style: italic;display: none;"></div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Penyetor/Penarik</label>
							<div class="col-sm-9">
								<input type="text" name="penyetor" class="" id="penyetor" required placeholder=""  value="<?=($id!=-1 ? $det->penyetor_penarik : '')?>" style="width:50% !important;">
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Keterangan</label>
							<div class="col-sm-9">
								<textarea class="span12" name="keterangan" style="width:90%"><?=($id!=-1 ? $det->keterangan : '')?></textarea>
							</div>
						</div>
						
				

				<div class="hr hr-24"></div>
</form>
<script type="text/javascript">
	$('#tanggal_transaksi_edit').datepicker({
		autoclose: true,
		todayHighlight: true
	});
</script>