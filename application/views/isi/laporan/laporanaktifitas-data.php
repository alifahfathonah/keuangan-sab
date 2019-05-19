<div class="row">
	<div class="col-xs-6">
	</div>
	<div class="col-xs-6">
		<div class="pull-right" style="margin-bottom:5px;">
			<button class="btn btn-xs btn-success" onclick="downloadlaporanaktifitas()"><i class="fa fa-download"></i> Unduh Laporan Aktivitas</button>
			<button class="btn btn-xs btn-primary" onclick="reloadlaporanaktifitas()"><i class="fa fa-refresh"></i> Refresh</button>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xs-12">
        <h2>Laporan Aktifitas</h2>
        <table id="simple-table" class="table table-bordered table-hover" style="width:50%">
			
			<tbody>
			<tr>
				<th colspan="2" class="text-left">PENDAPATAN</th>
			</tr>
			<?php
			$total_pen=0;
			ksort($kode_akun);
			$jlh=0;
			$akun_penyusutan=array();
			foreach($kode_akun as $k => $v)
			{
				$fs=substr($v->akun_alternatif,0,1);
				if(strpos(strtolower($v->nama_akun),'perlengkapan')!==false || strpos(strtolower($v->nama_akun),'bangunan')!==false)
				{
					$akun_penyusutan[$v->akun_alternatif]=$v;
				}
				if($fs=='A' && $v->akun_alt_parent=='0')
				{
					if(strpos(strtolower($v->nama_akun),'piutang')===false && strpos(strtolower($v->nama_akun),'pinjaman')===false)
					{
						if(isset($trans['sekolah'][$v->akun_alternatif][$tahunajaran]))
							$jlh=array_sum($trans['sekolah'][$v->akun_alternatif][$tahunajaran]);
						else 
							$jlh=0;
						
						echo '<tr>';
						echo '<td class="text-left" style="padding-left:30px;">'.$v->nama_akun.'</td>';
						echo '<td class="text-right">'.number_format($jlh,0,',','.').'</td>';
						echo '</tr>';
						$total_pen+=$jlh;
					}
				}
			}
			
			?>
			<tr>
				<th class="text-center" style="background-color:#eee;">Total Pendapatan</th>
				<th class="text-right" style="background-color:#eee;"><?=number_format($total_pen,0,',','.')?></th>
			</tr>
			<tr>
				<th class="text-left" colspan="2">&nbsp;</th>
			</tr>
			<tr>
				<th colspan="2" class="text-left">PENGELUARAN</th>
			</tr>
			<?php
			$total_peng=0;
			$total_tanah=0;
			foreach($kode_akun as $k => $v)
			{
				$fs=substr($v->akun_alternatif,0,1);
				if($fs=='B' && $v->akun_alt_parent=='0')
				{
					// if(strpos(strtolower($v->nama_akun),'piutang')===false && strpos(strtolower($v->nama_akun),'pinjaman')===false)
					// {
						if(isset($trans['sekolah'][$v->akun_alternatif][$tahunajaran]))
							$jlh=array_sum($trans['sekolah'][$v->akun_alternatif][$tahunajaran]);
						else 
							$jlh=0;
						
						echo '<tr>';
						echo '<td class="text-left" style="padding-left:30px;">'.$v->nama_akun.'</td>';
						echo '<td class="text-right">'.number_format($jlh,0,',','.').'</td>';
						echo '</tr>';
						$total_peng+=$jlh;
					// }
				}
				elseif($fs=='D' && $v->akun_alt_parent=='0')
				{
					if(strpos(strtolower($v->nama_akun),'utang')===false )
					{
						if(isset($trans['sekolah'][$v->akun_alternatif][$tahunajaran]))
							$jlh=array_sum($trans['sekolah'][$v->akun_alternatif][$tahunajaran]);
						else 
							$jlh=0;
						
						echo '<tr>';
						echo '<td class="text-left" style="padding-left:30px;">'.$v->nama_akun.'</td>';
						echo '<td class="text-right">'.number_format($jlh,0,',','.').'</td>';
						echo '</tr>';
						$total_peng+=$jlh;
					}
				}
				if(strpos(strtolower($v->nama_akun),'tanah')!==false )
				{
					if(isset($trans['sekolah'][$v->akun_alternatif][$tahunajaran]))
						$total_tanah=array_sum($trans['sekolah'][$v->akun_alternatif][$tahunajaran]);
					else 
						$total_tanah=0;
				}
			}
			$bangunan=$peralatan=0;
			foreach($tsaldoakun as $kt => $vt)
			{
				if(count($akun_penyusutan)!=0)
				{
					if(isset($akun_penyusutan[$kt]))
					{
						// echo '<pre>';
						// print_r($vt['2018']);
						// echo '</pre>';
						foreach($vt as $ii => $vv)
						{
							$total=0;
							foreach($vv as $b => $vb)
							{
								if($b>=7 && $ii==$th1)
								{
									$total+=$vb;
								}
								elseif($b<=6 && $ii==$th2)
								{
									$total+=$vb;
								}
								if(strpos(strtolower($akun_penyusutan[$kt]->nama_akun),'perlengkapan')!==false)
								{
									$peralatan=$total;
								}
								elseif(strpos(strtolower($akun_penyusutan[$kt]->nama_akun),'bangunan')!==false)
								{
									$bangunan=$total;
								}
							}
							
						}
					}
				}
			}
			$t_nrc_alat=$t_nrc_bg=$t_nrc_tanah=$t_aktiva=0;
			foreach($t_neraca_saldo as $kt => $vtt)
			{
				if(count($akun_penyusutan)!=0)
				{
					if(isset($akun_penyusutan[$kt]))
					{
						if(strpos(strtolower($akun_penyusutan[$kt]->nama_akun),'perlengkapan')!==false)
						{
							$t_nrc_alat=isset($vt[$th1][7]) ? $vt[$th1][7] : 0;
						}
						elseif(strpos(strtolower($akun_penyusutan[$kt]->nama_akun),'bangunan')!==false)
						{
							$t_nrc_bg=isset($vt[$th1][7]) ? $vt[$th1][7] : 0;
						}
					}
				}
				if(isset($kode_akun[$kt]))
				{
					if(strpos(strtolower($kode_akun[$kt]->nama_akun),'tanah')!==false)
					{
						$t_nrc_tanah=isset($vt[$th1][7]) ? $vt[$th1][7] : 0;
					}
				}
				if($kt==-2)
				{
					$t_aktiva=isset($vt[$th1][7]) ? $vt[$th1][7] : 0;
				}
				// echo '<pre>';
				// print_r($vt);
				// echo '</pre>';
			}
			// echo $t_nrc_alat;
			$peralatan=(0.5) * ($peralatan+$t_nrc_alat);
			$bangunan=(0.2) * ($bangunan+$t_nrc_bg);
			$total_peng=$total_peng+$peralatan+$bangunan;
			$tanah=0.05*($total_tanah+$t_nrc_tanah);
			// echo $total_tanah.'-'.$t_nrc_tanah;
			echo '<tr>';
			echo '<td class="text-left" style="padding-left:30px;">Beban Penyusutan Perlengkapan ( 50% )</td>';
			echo '<td class="text-right">'.number_format($peralatan,0,',','.').'</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td class="text-left" style="padding-left:30px;">Beban Penyusutan Bangunan ( 20% )</td>';
			echo '<td class="text-right">'.number_format($bangunan,0,',','.').'</td>';
			echo '</tr>';
			?>
			<tr>
				<th class="text-center" style="background-color:#eee;">Total Pengeluaran</th>
				<th class="text-right" style="background-color:#eee;"><?=number_format($total_peng,0,',','.')?></th>
			</tr>
			<tr>
				<th class="text-center" colspan="2">&nbsp;</th>
			</tr>
			<tr>
				<th class="text-center" style="background-color:#eee;">KENAIKAN AKTIVA BERSIH</th>
				<th class="text-right" style="background-color:#eee;"><?=number_format(($total_pen-$total_peng),0,',','.')?></th>
			</tr>
			<tr>
				<th class="text-center" colspan="2">&nbsp;</th>
			</tr>
			<tr>
				<th class="text-center" style="background-color:#eee;">Kenaikan Nilai Aset (tanah) per 30 Juni <?=$th2?></th>
				<th class="text-right" style="background-color:#eee;"><?=number_format(($tanah),0,',','.')?></th>
			</tr>
			<tr>
				<th class="text-center" style="background-color:#eee;">Aktiva Bersih per 1 Juli <?=$th1?></th>
				<th class="text-right" style="background-color:#eee;"><?=number_format(($t_aktiva),0,',','.')?></th>
			</tr>
			<tr>
				<th class="text-center" style="background-color:#eee;">TOTAL AKTIVA BERSIH PER 30 JUNI <?=$th2?></th>
				<th class="text-right" style="background-color:#eee;"><?=number_format(($t_aktiva+$tanah),0,',','.')?></th>
			</tr>
			</tbody>
        </table>
    </div>
</div>
<style>
    th,td
    {
        font-size:9.5px !important;
    }
</style>