<div class="row">
	<div class="col-xs-6">
		<button class="btn btn-xs btn-success" onclick="jurnalnonsekolah('<?=$jenis?>','<?=$date?>')"><i class="fa fa-file"></i> Jurnal Non Sekolah</button>
		<button class="btn btn-xs btn-primary" onclick="jurnalsekolah('<?=$jenis?>','<?=$date?>')"><i class="fa fa-file"></i> Jurnal Sekolah</button>
	</div>
	<div class="col-xs-6">
		<div class="pull-right" style="margin-bottom:5px;">
			<button class="btn btn-xs btn-success" onclick="downloadjurnal('<?=$jenis?>')"><i class="fa fa-download"></i> Unduh Data Jurnal</button>
			<button class="btn btn-xs btn-primary" onclick="reloadjurnal('<?=$jenis?>','<?=$date?>','<?=$j_lap?>')"><i class="fa fa-refresh"></i> Refresh</button>
		</div>
	</div>
	<div class="col-xs-12">
		<h2><?=$j_lap==-1 ? '' : 'Jurnal '.($j_lap=='non' ? 'Non Sekolah' : 'Sekolah')?></h2>
		<table id="simple-table" class="table table-striped table-bordered table-hover">
			<thead>

				<tr>
					<th>No</th>
					<th>Tanggal</th>
					<th>Keterangan</th>
					<th>Kode Akun</th>
					<th>Debet</th>
					<th>Kredit</th>
					<th>Saldo</th>
				</tr>
				<?php
				if(isset($bulan))
				{
				?>
				<tr>
					<th colspan="6" class="text-right">Saldo Akhir Bulan <?=getBulan($bulan)?> <?=$tahun?></th>
					<th class="text-right">Saldo</th>
				</tr>
				<?php
				}
				?>
			</thead>
			<tbody>
				
			<?php
			$no=1;
			// echo $date;
			$saldo=$saldodebet=$saldokredit=0;
			foreach ($trans as $k => $v) 
			{
				//
				if($v->status=='keluar')
				{
					
					list($k1,$k2)=explode('||',$v->keterangan);
					list($kdakunalt,$kdakun,$nmakun)=explode('-',$k1);
					$ket=$nmakun.'<br>&nbsp;&nbsp;'.$k2;
					$kode_akun=$kdakunalt;
					//$date=$v->tanggal_transaksi;
					$iconedit='<i onclick="editjurnal(\''.$v->id.'\',\''.$v->id_trans.'\',\''.$v->status.'\',\''.$date.'\',\'-1\',\''.$v->jumlah.'\',\''.$v->total.'\',\'-1\')" class="fa fa-edit blue" style="cursor:pointer;display:none" id="edit-icon"></i>';
					$iconhapus='<i onclick="hapusjurnal(\''.$v->id.'\',\''.$v->id_trans.'\',\'keluar\',\''.$date.'\',\'-1\',\''.$v->jumlah.'\',\''.$v->total.'\',\'-1\')" class="fa fa-trash red" style="cursor:pointer;display:none" id="hapus-icon"></i>';
				}
				else
				{
					$nis=trim(str_replace('.','_',trim($v->nis)));
					// if(isset($siswa))
					
					//$date=$v->tanggal_transaksi;
					if(isset($tpenerimaan[$v->penerimaan_id]))
					{
						if($v->status_transaksi!='3-Lainnya')
						{
							if(isset($v->jenis))
							{
								$s=$siswa[$nis];
								$t=$tpenerimaan[$v->penerimaan_id];
								$kode_akun=$t->kodeakun;
								if($v->jenis=="Program Pembelajaran")
									$ket=ucwords(strtolower($s->nama_murid)).' - DU/Investasi '.$v->tahun_tagihan;
								else
									$ket=ucwords(strtolower($s->nama_murid)).' - '.$v->jenis.' '.getBulan($v->bulan_tagihan).' '.$v->tahun_tagihan;
							}
							else
							{
								$ket=$v->ket;
								$kode_akun='';
							}
							$iconedit='<i onclick="editjurnal(\''.$v->id.'\',\''.$v->id_trans.'\',\''.$v->status.'\',\''.$date.'\',\''.$v->nis.'\',\''.$v->jumlah.'\',\''.$v->total.'\',\''.$v->penerimaan_id.'\')" class="fa fa-edit blue" style="cursor:pointer;display:none" id="edit-icon"></i>';
							$iconhapus='<i onclick="hapusjurnal(\''.$v->id.'\',\''.$v->id_trans.'\',\''.$jenis.'\',\''.$date.'\',\''.$v->nis.'\',\''.$v->jumlah.'\',\''.$v->total.'\',\''.$v->penerimaan_id.'\')" class="fa fa-trash red" style="cursor:pointer;display:none" id="hapus-icon"></i>';
						
						}
						else
						{
							$ket=$v->ket;
							$kode_akun='';
							$iconedit='<i onclick="editjurnal(\''.$v->id.'\',\''.$v->id_trans.'\',\''.$v->status.'\',\''.$date.'\',\'-1\',\''.$v->jumlah.'\',\''.$v->total.'\',\'-1\')" class="fa fa-edit blue" style="cursor:pointer;display:none" id="edit-icon"></i>';
							$iconhapus='<i onclick="hapusjurnal(\''.$v->id.'\',\''.$v->id_trans.'\',\'lain\',\''.$date.'\',\'-1\',\''.$v->jumlah.'\',\''.$v->total.'\',\'-1\')" class="fa fa-trash red" style="cursor:pointer;display:none" id="hapus-icon"></i>';
						}
					}
					else
					{
						list($idakun,$kdakun,$kdakunalt,$nmakun)=explode('_',$v->keterangan);
						$kode_akun=$kdakunalt;
						$ket=$v->ket;
						$iconedit='<i onclick="editjurnal(\''.$v->id.'\',\''.$v->id_trans.'\',\''.$v->status.'\',\''.$date.'\',\'-1\',\''.$v->jumlah.'\',\''.$v->total.'\',\'-1\')" class="fa fa-edit blue" style="cursor:pointer;display:none" id="edit-icon"></i>';
						$iconhapus='<i onclick="hapusjurnal(\''.$v->id.'\',\''.$v->id_trans.'\',\'lain\',\''.$date.'\',\'-1\',\''.$v->jumlah.'\',\''.$v->total.'\',\'-1\')" class="fa fa-trash red" style="cursor:pointer;display:none" id="hapus-icon"></i>';
					}
				}	

				$debet=($v->status=='terima' ? $v->jumlah:0);
				$kredit=($v->status=='keluar' ? $v->jumlah:0);
				$saldo+=($debet-$kredit);
				$saldodebet+=($debet);
				$saldokredit+=($kredit);
				echo '<tr>';
				echo '<td>'.$no.'</td>';
				echo '<td style="text-align:center">'.tgl_indo2($v->tanggal_transaksi).'</td>';
				echo '<td style="text-align:left">
					'.$iconedit.' '.$iconhapus.'&nbsp;&nbsp;'.$ket.'
					</td>';
				echo '<td style="text-align:center">'.strtok($kode_akun,'-').'</td>';
				echo '<td style="text-align:right">'.number_format($debet,0,',','.').'</td>';
				echo '<td style="text-align:right">'.number_format($kredit,0,',','.').'</td>';
				echo '<td style="text-align:right">'.number_format($saldo,0,',','.').'</td>';
				echo '</tr>';
				echo '<input type="hidden" name="akun" id="akun_'.$v->status.'_'.$v->id.'" value="'.strtok($kode_akun,'-').'">';
				echo '<input type="hidden" name="akun" id="ket_'.$v->status.'_'.$v->id.'" value="'.$ket.'">';
				$no++;
			}
			?>
			</tbody>
			<thead>
				<tr>
					<th colspan="4">&nbsp;</th>
					<th style="text-align: right"><?=number_format($saldodebet,0,',','.')?></th>
					<th style="text-align: right"><?=number_format($saldokredit,0,',','.')?></th>
					<th style="text-align: right"><?=number_format(($saldodebet-$saldokredit),0,',','.')?></th>
				</tr>
				<?php
				if(isset($bulan))
				{
				?>
				<tr>
					<th colspan="5" class="text-right">SALDO AKHIR BULAN <?=strtoupper(getBulan($bulan))?></th>
					<th style="text-align: right" colspan="2"><?=number_format(($saldodebet-$saldokredit),0,',','.')?></th>
				</tr>
				<?php
				}
				?>
			</thead>
		</table>
	</div>
</div>
<script>
	function hapusjurnal(id,id_trans,jenis,date,nis,jumlah,total,id_jenis)
	{
		// reloadjurnal(jenis,date)
			bootbox.confirm("<h3>Yakin Data Jurnal Ini ingin Dihapus ?</h3>", function(result) {
			if(result)
			{
				$.ajax({
					url : '<?=site_url()?>laporan/hapusjurnal/'+id+'/'+id_trans+'/'+jenis+'/'+date+'/'+nis+'/'+jumlah+'/'+total+'/'+id_jenis,
					type : 'POST',
					success : function(a){
						if(a==1)
						{
							reloadjurnal('<?=$jenis?>','<?=strtok($date,' ')?>','<?=$j_lap?>');
						}
						else
						{

						}
					}
				});		
			}
		});
	}
	function editjurnal(id,id_trans,status,date,nis,jumlah,total,id_jenis)
	{
		var kode_akun=$('#akun_'+status+'_'+id).val();
		$.ajax({
			url : '<?=site_url()?>laporan/jurnaledit/'+kode_akun+'/'+id_trans+'/'+id+'/'+status+'/'+jumlah+'/'+id_jenis+'/'+total,
			type : 'POST',
			data : { ket : $('#ket_'+status+'_'+id).val() },
			success : function(a){
				bootbox.confirm(a, function(result) {
					if(result)
					{
						$.ajax({
							url : '<?=site_url()?>laporan/jurnaleditproses/'+id+'/'+id_trans,
							type : 'POST',
							data : $('form#simpanjurnal').serialize(),
							success : function(a)
							{
								reloadjurnal('<?=$jenis?>','<?=strtok($date,' ')?>','<?=$j_lap?>');
							}
						});
					}
				});
			}
		});
	}
</script>