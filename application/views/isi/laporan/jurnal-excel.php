<?php
header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=Jurnal_Penerimaan_".getBulan($bulan)."_".$tahun.".xls");
    header("Pragma: no-cache");
    header("Expires: 0");
?> 
Jurnal Penerimaan : <?=getBulan($bulan)." ".$tahun?>
    <table id="simple-table" class="table table-striped table-bordered table-hover" border="1" cellpadding="2" cellspacing="2" width="100%">
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
			</thead>
			<tbody>
			<?php
			$no=1;
			$siswa=$this->config->item('nissiswa2');
			$tpenerimaan=$this->config->item('tpenerimaan');
			$saldo=$saldodebet=$saldokredit=0;
			foreach ($trans as $k => $v) 
			{
				if($v->status=='keluar')
				{	
					list($k1,$k2)=explode('||',$v->keterangan);
					list($kdakunalt,$kdakun,$nmakun)=explode('-',$k1);
					$ket=$nmakun.'<br>&nbsp;&nbsp;'.$k2;
					$kode_akun=$kdakunalt;
				}
				else
				{		
					$s=$siswa[str_replace('.','_',$v->nis)];
					if(isset($tpenerimaan[$v->penerimaan_id]))
					{
						if($v->status_transaksi!='3-Lainnya')
						{
							if(isset($v->jenis))
							{
								
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
							}
						}
						else
						{
							$ket=$v->ket;
						}
					}
					else
					{
						list($idakun,$kdakun,$kdakunalt,$nmakun)=explode('_',$v->keterangan);
						$kode_akun=$kdakunalt;
						$ket=$v->ket;
					}
				}
				$debet=($v->status=='terima' ? $v->jumlah:0);
				$kredit=($v->status=='keluar' ? $v->jumlah:0);
				$saldo+=($debet-$kredit);
				$saldodebet+=($debet);
				$saldokredit+=($kredit);
				echo '<tr>';
				echo '<td>'.$no.'</td>';
				echo '<td style="text-align:center">'.tgl_indo($v->tanggal_transaksi).'</td>';
				echo '<td style="text-align:left">'.$ket.'</td>';
				echo '<td style="text-align:center">'.strtok($kode_akun,'-').'</td>';
				echo '<td style="text-align:right">'.($debet).'</td>';
				echo '<td style="text-align:right">'.($kredit).'</td>';
				echo '<td style="text-align:right">'.($saldo).'</td>';
				echo '</tr>';
				$no++;
			}
			?>
			</tbody>
			<thead>
				<tr>
					<th colspan="4">&nbsp;</th>
					<th style="text-align: right"><?=($saldodebet)?></th>
					<th style="text-align: right"><?=($saldokredit)?></th>
					<th style="text-align: right"><?=($saldo)?></th>
				</tr>
			</thead>
		</table>