<?php
if($menu=='tagihan')
{
?>
<div class="pull-left" style="margin-bottom:5px;" >
	<button class="btn btn-xs btn-success" type="button" onclick="aktifkantagihan(<?=$id?>)"><i class="fa fa-check-circle"></i> Aktifkan Tagihan</button>
</div>
<div class="pull-right" style="margin-bottom:5px;" >
	<button class="btn btn-xs btn-success" type="button" onclick="downloadsiswa(<?=$id?>)"><i class="fa fa-download"></i> Unduh Data Siswa</button>
	<button class="btn btn-xs btn-primary" type="button" onclick=getdatatagihan()><i class="fa fa-refresh"></i> Refresh</button>
</div>
<?php 
}
?>
<table id="simple-table" class="table table-striped table-bordered table-hover">
	<thead>
		<tr>
			<!-- <th class="center">No</th> -->
			<th <?=($menu=='tagihan' ? 'rowspan="2"' : '')?> class="center">No</th>
			<th <?=($menu=='tagihan' ? 'rowspan="2"' : '')?> class="center">Nama Siswa</th>
		<?php
		$he=$this->config->item('hari_efektif');
		// $t_sebelum=$this->config->item('tagihan_sebelum');
		$t_sebelum=$this->config->item('tagihan_sebelum');
		$trans_bayar=$this->config->item('trans_bayar');
		$trans_bayar_jenis=$this->config->item('trans_bayar_jenis');
		$tsb=$this->config->item('tsb');
		if($menu=='tagihan')
		{
			// echo $batch->kategori.'<br>';
			$where='id_parent=0';
			// $where='(level like "'.$batch->kategori.'" OR level="all") and id_parent=0';
			$penerimaan=$this->db->from('t_jenis_penerimaan')->where($where)->where('status_tampil','t')->group_by('jenis')->order_by('jenis')->get()->result();
			$penerimaan2=$this->db->from('t_jenis_penerimaan')->where('status_tampil','t')->order_by('jenis')->get()->result();
			echo '
				<th rowspan="2">Hari Efektif Catering</th>
				<th rowspan="2">Hari Efektif Jemputan</th>
				<th colspan="'.(count($penerimaan)+2).'" class="center">Tagihan</th>

				</tr>';
			echo '<tr>';
			$data_terima=$d_terima=$data_all=array();
			$sub_data=array();
			foreach ($penerimaan2 as $k => $v)
			{
				if($v->id_parent>0)
				{
					$sub_data[$v->id_parent][str_replace(' ', '', $v->jenis)]=$v->jumlah;
				}
				// echo $v->jenis.':'.$v->level.'<br>';
				// if($v->jenis=='SPP')
				// {
				// 	echo $v->level.'<br>';
				// }

				if(strpos($v->level,"sd")!==false)
					$data_terima[strtolower($v->jenis)]["sd"]=$v;
				else if(strpos($v->level,"sm")!==false)
					$data_terima[strtolower($v->jenis)]["sm"]=$v;
				else
					$data_terima[strtolower($v->jenis)]["$v->level"]=$v;

				// $dterima=
				$d_terima[strtolower($v->jenis)][$v->level]=$v;
				$data_all[strtolower($v->jenis)][$v->id_parent][]=$v;
				// echo $v->level.'<br>';
			}
			// echo '<pre>';
			// print_r($penerimaan);
			// echo '</pre>';
			foreach ($penerimaan as $k => $v)
			{
				$ck='&nbsp;';
				if(strtolower($v->jenis)!='spp' && strtolower($v->jenis)!='investasi')
				{
					$ck='<input type="checkbox" name="ceksemua" id="ceksemua_'.$v->id.'" onChange="pilihsemua('.$v->id.',\''.strtolower(str_replace(' ', '_', $v->jenis)).'\')">';
				}
				else if(strtolower($v->jenis)=='investasi')
					$ck='';


				if (strtolower($v->jenis)!='investasi' && strtolower($v->jenis)!='biaya seleksi')
				{

					echo '<th class="center" style="width:120px !important;">
						<div style="float:left;width:20px !important">'.$ck.'</div>';
					echo '<div style="float:right;width:80% !important">'.$v->jenis.'</div>';
					echo '</th>';
				}

			}
			echo '<th style="width:120px !important;">DU <br>'.$tahun_ajaran.'</th>';
			if(count($inves2)!=0)
			{
				echo '<th style="width:100px !important;">DU<br>'.$tahun_ajaran_baru.'</th>';
			}
			// echo '<th style="width:90px !important;">Investasi</th>';
			echo '<th style="width:90px !important;">Tunggakan</th>';
			echo '</tr>';
		?>

		<?php
		}
		else
		{
		?>
				<th>Nama Panggilan</th>
				<th>Kelamin</th>
				<th>Alamat</th>
				<th style="width:100px"></th>
		</tr>
		<?php
		}
		?>
	</thead>

	<tbody>
	<?php
	// echo '<pre>';
	// 					print_r($data_terima);
	// 					echo '</pre>';
	$no=1;
	$tabseb=array();
	foreach ($d as $k => $v)
	{
		// echo '<pre>';
		// print_r($tsb[$v->nis][$v->tahun_ajaran]);
		// echo '</pre>';
		if(isset($tsb[$v->nis]))
		{
			if(isset($tsb[$v->nis][$v->tahun_ajaran]))
			{
				unset($tsb[$v->nis][$v->tahun_ajaran][7]['Asuransi']);
				unset($tsb[$v->nis][$v->tahun_ajaran][7]['Program Pembelajaran']);
				unset($tsb[$v->nis][$v->tahun_ajaran][7]['Iuran Komite']);
				unset($tsb[$v->nis][$v->tahun_ajaran][7]['Biaya Seleksi']);
				unset($tsb[$v->nis][$v->tahun_ajaran][7]['Investasi Pendidikan']);
				unset($tsb[$v->nis][$v->tahun_ajaran][7]['Seragam Outbound']);
				unset($tsb[$v->nis][$v->tahun_ajaran][7]);
				$tabseb=$tsb[$v->nis][$v->tahun_ajaran];
			}
			else
				$tabseb=array();
		}
		else
			$tabseb=array();
			
		echo '<tr>';
		echo '<td class="center">'.$no.'</td>';
		echo '<td class="left">'.ucwords(strtolower($v->nama_murid)).'</td>';
		if($menu=='tagihan')
		{
			// echo '<pre>';
			// print_r($tagihannn);
			// echo '</pre>';
			echo '<td style="text-align:center">'.$hari_efektif_catering.' hari</td>';
			echo '<td style="text-align:center">'.$hari_efektif_jemputan.' hari</td>';
			$jumlah=$jumlah_jp_club='n/a';
			$dicek=$dicekclub='';
			$subtotal=$subtotal2=0;
			foreach ($penerimaan as $kk => $vv)
			{
				$dicek='';
				$ilangin_chk=0;
				$ck='&nbsp;';
				$jumlah=$jumlah_jp_club='n/a';
				$jnss=strtolower($vv->jenis);
				$jnss2=str_replace(' ', '_', $vv->jenis);
				$dicek=$dicekclub='';
				$sub=0;
				$chk_box='';
				// if(isset($tagihan[$vv->id][$v->nis]))
				// echo $jnss.'<br>';
				if (strtolower($vv->jenis)!='investasi' && strtolower($vv->jenis)!='biaya seleksi')
				{
					if(isset($tagihannn[$jnss][$v->nis]))
					{	
							$dicek=$dicekclub='checked="checked"';
							$status_dobel=0;
							$ck_dobel=array();
							// $tagih=$tagihan[$vv->id][$v->nis];
							$tagih=$tagihannn[$jnss][$v->nis];
							$b_jns=$tagih->id_jenis_penerimaan.'__'.$jnss2;
							
							// $jumlah=$jumlah_jp_club='';
							
							$sub=$tagih->sisa_bayar;
							if($sub==0)
							{
								if(isset($trans_bayar[$v->nis][$tagih->id_jenis_penerimaan][$tagih->tahun_ajaran][$tagih->bulan][$tagih->tahun]))
								{
									$tgl_byr=$trans_bayar[$v->nis][$tagih->id_jenis_penerimaan][$tagih->tahun_ajaran][$tagih->bulan][$tagih->tahun];
									$jumlah=$jumlah_jp_club='<small style="color:blue">'.date('d-m-Y', strtotime($tgl_byr->tanggal_transaksi)).'</small>';
									$ilangin_chk=1;
								}	
							}
							else
							{
								// echo 'sana';
								$jumlah=$jumlah_jp_club='<input type="text" id="tagih" name="tagih['.str_replace('.','_',$v->nis).']['.$b_jns.']" value="'.number_format($tagih->sisa_bayar).'" style="text-align:right;background:#ccf7c8;width:90%;float:right;color:black">';
								
								if(isset($trans_bayar_jenis[$v->nis][strtolower($jnss2)][$tagih->tahun_ajaran][$tagih->bulan][$tagih->tahun]))
								{
									$tgl_byr2=$trans_bayar_jenis[$v->nis][strtolower($jnss2)][$tagih->tahun_ajaran][$tagih->bulan][$tagih->tahun];
									if($tagih->sisa_bayar>0)
									{
										$jumlah=$jumlah_jp_club='<input type="text" id="in_tagih_'.$tagih->id_jenis_penerimaan.'_'.str_replace('.','_',$v->nis).'_'.$tagih->id_tagihan.'" name="tagih['.str_replace('.','_',$v->nis).']['.$b_jns.']" value="'.number_format($tagih->sisa_bayar).'" style="text-align:right;background:yellow;width:90%;float:right;color:black">';
										
										$chk_box='<input type="checkbox" checked="checked" name="name_tagihan['.$tagih->id_jenis_penerimaan.']" id="ck_tagih_'.$tagih->id_jenis_penerimaan.'_'.str_replace('.','_',$v->nis).'_'.$tagih->id_tagihan.'" class="name_tagihan_'.$tagih->id_jenis_penerimaan.'" alt="'.str_replace('.','_',$v->nis).'" onChange="nolkan(\''.$tagih->id_tagihan.'\',\''.$tagih->id_jenis_penerimaan.'\',\''.str_replace('.','_',$v->nis).'\')" style="height:21px;">';
										$ilangin_chk=2;
									}
									else
									{
										$jumlah='<small style="color:blue">'.date('d-m-Y', strtotime($tgl_byr2->tanggal_transaksi)).'</small>';
										$jumlah_jp_club=$jumlah;
										$ilangin_chk=1;
									}
									
									$tagih=$tagihan[$tgl_byr2->penerimaan_id][$v->nis];
									
								}
								// $jumlah=$jumlah_jp_club='<input type="text" id="tagih" name="tagih['.str_replace('.','_',$v->nis).']['.$b_jns.']" value="'.number_format($tagih->sisa_bayar).'" style="text-align:right;background:#ccf7c8;width:90%;float:right;color:black">';
							}
							$subtotal+=$sub;
							if(count($tagihan2[$jnss][$v->nis])>1)
							{
								foreach($tagihan2[$jnss][$v->nis] as $kt => $vt)
								{
									if($vt->sisa_bayar!=0)
									{
										if($bulan==$vt->bulan)
										{
											if($vt->id_tagihan!=$tagih->id_tagihan)
											{
												$b_jns=$vt->id_jenis_penerimaan.'__'.$jnss2;
												$jumlah.='<input type="text" id="in_tagih_'.$vt->id_jenis_penerimaan.'_'.$kt.'_'.str_replace('.','_',$v->nis).'" name="tagih['.str_replace('.','_',$v->nis).']['.$b_jns.']" value="'.number_format($vt->sisa_bayar).'" style="text-align:right;background:aliceblue;width:90%;float:right;color:black;border:1px solid #000">';
												$jumlah_jp_club=$jumlah;
												$status_dobel=1;
												
												$ck_dobel[$vt->id_tagihan]='<input type="checkbox" checked="checked" name="name_tagihan['.$vt->id_jenis_penerimaan.']" id="ck_tagih_'.$vt->id_jenis_penerimaan.'_'.$kt.'_'.str_replace('.','_',$v->nis).'" class="name_tagihan_'.$vt->id_jenis_penerimaan.'" alt="'.str_replace('.','_',$v->nis).'" onChange="hapusTagihan(\''.$vt->id_tagihan.'\',\''.$vt->id_jenis_penerimaan.'\',\''.$kt.'\',\''.str_replace('.','_',$v->nis).'\')" style="height:21px;">';

												$subtotal+=$vt->sisa_bayar;
											}
										}
									}
								}
								//$dicek=$dicekclub='checked="checked"';
							}
						// }
						
						
					}

					else if(strtolower($vv->jenis)=='investasi' || strtolower($vv->jenis)=='biaya seleksi')
					{
						$dicek=$dicekclub='';
					}
					else if(strtolower($vv->jenis)=='spp')
					{
						$dicek=$dicekclub='';
						// echo $vv->id.'|'.$v->id.'<br>';
						$pendamping=$this->config->item('tpendamping');
						// echo '<pre>';
						// print_r($tpendaftaran);
						// echo '</pre>';
						if(isset($pendamping[$v->nis]))
						{
							$biayapendamping=$pendamping[$v->nis]->biaya;
						}
						else
							$biayapendamping=0;

						if(isset($tpotongan[$v->tahun_ajaran]["$v->nama_murid"]["SPP"]))
						{
							$pt=$tpotongan[$v->tahun_ajaran]["$v->nama_murid"]["SPP"];
							// if($pt->persen!=0)
							// {
							// 	$p
							// }
							if($pt->biaya==0)
								$potongan=-1;
							else
								$potongan=$pt->biaya;
							// echo '<pre>';
							// print_r($tpotongan[$v->tahun_ajaran]);
							// echo '</pre>';
						}
						else
							$potongan=0;


						// echo $potongan;
						if($potongan==0)
						{
							if(isset($tpendaftaran[$v->tahun_ajaran][$v->id_level][$v->id]))
							{
								$spp=0;
								$f=$tpendaftaran[$v->tahun_ajaran][$v->id_level][$v->id];
								$dk=explode(',', $f->jenis_penerimaan);
								$jh=explode(',', $f->jumlah);
								foreach ($dk as $kd => $vd)
								{
									if(strtolower($vd)=='spp')
									{
										$spp=$jh[$kd];
									}
								}
								$ada=1;
							}
							else
							{
								$spp=0;
								$ada=0;
							}
						}
						else
							$spp=$potongan;
						// echo $batch->kategori.'<br>';
						// if($batch->kategori=='pg')
						// {
						// echo $spp;
							if($spp==0)
							{
							
								if($batch->kategori=='sd')
								{
									if($batch->level >=1 && $batch->level<=3)
										$spp=$d_terima[strtolower($vv->jenis)]['sd1_3']->jumlah;
									else if($batch->level>=4 && $batch->level<=6)
										$spp=$d_terima[strtolower($vv->jenis)]['sd'.$batch->level]->jumlah;
									else
										$spp=$data_terima[strtolower($vv->jenis)][$batch->kategori]->jumlah;
								}
								else
									$spp=$data_terima[strtolower($vv->jenis)][$batch->kategori]->jumlah;
							}
							$spp_p=($spp==-1 ? 0 : $spp);
							$vv_jumlah=$spp_p + $biayapendamping;
						// }

						// if($bulan==7)
						// {

						// }
						// else
							$jumlah='<input type="text" id="tagih" name="tagih['.str_replace('.','_',$v->nis).']['.$vv->id.'__'.$jnss2.']" value="'.number_format($vv_jumlah).'" style="text-align:right;background:#f7c8c8;width:90%;float:right;color:black">';
							$subtotal2+=$vv_jumlah;
					}
					else if(strpos($jnss, 'jemputan')!==false)
					{
						$dicek=$dicekclub='';
						if(isset($d_jemputan[$v->nis]))
						{
							$datajarak=$this->db->from('t_data_jemputan')->where('nis',$v->nis)->where('status_tampil','t')->get()->result();

							if(count($datajarak)!=0)
							{
								$getjarak=$this->db->from('t_jarak_jemputan')->where('status_tampil','t')->where('jarak',$datajarak[0]->jarak)->get()->result();
								if(count($getjarak)!=0)
								{
									$jarak=$datajarak[0]->jarak;
									$jlh=$getjarak[0]->biaya;
								}
								else
								{
									$jarak=$jlh=0;
								}

								if(strcmp($jnss, 'jemputan club')==0)
								{
									if($datajarak[0]->jemputan_club=='t')
									{
										$jmpt_club=1;
										$dicekclub='checked="checked"';
									}
									else
									{
										$jmpt_club=-1;
										$dicekclub='';
										//echo $jmpt_club;
									}
								}
								else
								{
									$jmpt_club=0;
									$dicekclub='';
								}
							}
							else
							{
								$jmpt_club=0;
								$jarak=$jlh=0;
								$dicekclub='';
							}

							
							if($jmpt_club==1)
							{
								$prsn_jmp=persen_jemputan($hari_efektif_jemputan,$datajarak[0]->status);
								$vv_jumlah = ($prsn_jmp/100) * $jlh;
								// if()
								//$vv_jumlah=0;
								$jjlh=pembulatan($vv_jumlah);
								$jumlah_jp_club='<input id="tagih" type="text" name="tagih['.str_replace('.','_',$v->nis).']['.$vv->id.'__'.$jnss2.']" value="'.number_format( pembulatan(round( $vv_jumlah , -2 )) , 0 , '.' , ',' ).'" style="text-align:right;background:#f7c8c8;width:90%;float:right;color:black">';
								$subtotal2+=pembulatan(round($jjlh,-2));
								$dicek='checked="checked"';
								$jumlah='<input id="tagih" type="text" name="tagih['.str_replace('.','_',$v->nis).']['.$vv->id.'__'.$jnss2.']" value="'.number_format( pembulatan(round( $vv_jumlah , -2 )) , 0 , '.' , ',' ).'" style="text-align:right;background:#f7c8c8;width:90%;float:right;color:black">';
							}
							else if($jmpt_club==0)
							{
								$prsn_jmp=persen_jemputan($hari_efektif_jemputan,$datajarak[0]->status);
								$vv_jumlah = ($prsn_jmp/100) * $jlh;
								// if()
								//$vv_jumlah=0;
								$jjlh=pembulatan($vv_jumlah);
								$jumlah_jp_club='n/a';
								// echo $jumlah_jp_club;
								$subtotal2+=pembulatan(round($jjlh,-2));
								$dicek='checked="checked"';
								$jumlah='<input id="tagih" type="text" name="tagih['.str_replace('.','_',$v->nis).']['.$vv->id.'__'.$jnss2.']" value="'.number_format( pembulatan(round( $vv_jumlah , -2 )) , 0 , '.' , ',' ).'" style="text-align:right;background:#f7c8c8;width:90%;float:right;color:black">';
							}
							else
							{
								$dicek='';
								$jumlah='n/a';
							}

							

							// $subtotal2+=pembulatan(round($jjlh,-2));
						}
					}
					else if(strpos($jnss, 'catering')!==false)
					{
						$dicek=$dicekclub='';
						$vv_jumlah=0;
						if(isset($d_catering[$v->nis]))
						{
							// if($batch->kategori=='pg')
							// {
								// $vv_jumlah=$data_terima["$vv->jenis"]["pg"]->jumlah;
								// echo '<pre>';
								// print_r($batch);
								// echo '</pre>';
								if($batch->kategori=='sd')
								{
									if($batch->level >=1 && $batch->level<=3)
										$vv_jumlah=$d_terima[strtolower($vv->jenis)]['sd1_3']->jumlah;
									else if($batch->level >=4 && $batch->level<=6)
										$vv_jumlah=$d_terima[strtolower($vv->jenis)]['sd4_6']->jumlah;
									else
										$vv_jumlah=$data_terima[strtolower($vv->jenis)][$batch->kategori]->jumlah;
								}
								else
									$vv_jumlah=$data_terima[strtolower($vv->jenis)][$batch->kategori]->jumlah;

								$vv_jumlah=$vv_jumlah * $hari_efektif_catering;
							// }
							$dicek='checked="checked"';
							// $vv_jumlah=0;
							$jumlah='<input id="tagih" type="text" name="tagih['.str_replace('.','_',$v->nis).']['.$vv->id.'__'.$jnss2.']" value="'.number_format($vv_jumlah).'" style="text-align:right;background:#f7c8c8;width:90%;float:right;color:black">';
							$subtotal2+=$vv_jumlah;
						}
					}
					else if($jnss=='club')
					{
						
						if(isset($d_club[$v->nis]))
						{
							// echo '<pre>';
							// print_r($d_club[$v->nis]);
							// echo '</pre>';
							$dicek='checked="checked"';
							$jumlah='';
							$sbb=0;
							foreach ($d_club[$v->nis] as $kcl => $vcl)
							{
								$getidclub=explode(',', $vcl->id_club);
								if(count($getidclub)>1)
								{
									foreach ($getidclub as $ki => $vi)
									{
										# code...
										// echo $vv->id.'-';
										$vv_jumlah=$t_club[$vi]->biaya;
										$nama_club=$t_club[$vi]->nama_club;
										$jumlah.='<div style="font-size:9px;">'.$nama_club.'</div><input id="tagih" type="text" name="tagihclub['.str_replace('.','_',$v->nis).']['.$vv->id.'__'.$jnss2.']['.$vi.'__'.str_replace(' ', '_',$nama_club).']" value="'.number_format($vv_jumlah).'" style="text-align:right;background:#f7c8c8;width:90%;float:right;color:black;margin-bottom:2px !important"><br>';
										$sbb+=$vv_jumlah;
									}
								}
								else
								{
									$idclub=$vcl->id_club;
									$vv_jumlah=$t_club[$idclub]->biaya;
									$nama_club=$t_club[$idclub]->nama_club;
									$jumlah.='<div style="font-size:9px;">'.$nama_club.'</div><input id="tagih" type="text" name="tagihclub['.str_replace('.','_',$v->nis).']['.$vv->id.'__'.$jnss2.']['.$idclub.'__'.str_replace(' ', '_',$nama_club).']" value="'.number_format($vv_jumlah).'" style="text-align:right;background:#f7c8c8;width:90%;float:right;color:black;margin-bottom:2px !important"><br>';
									$sbb+=$vv_jumlah;
								}

							}
							$subtotal2+=$sbb;
							// $jumlah='';
							// foreach ($idclub as $ki => $vi)
							// {
							// 	$vv_jumlah=$t_club[$vi]->biaya;
							// 	$nama_club=$t_club[$vi]->nama_club;
							// 	$jumlah.='<input id="tagih" type="text" name="tagihclub['.$v->nis.']['.$vv->id.'__'.$jnss2.']['.$vi.'__'.str_replace(' ', '_',$nama_club).']" value="'.number_format($vv_jumlah).'" style="text-align:right;background:#f7c8c8;width:90%;float:right;color:black;margin-bottom:2px !important"><br>';
							// }
						}
						else
							$dicek=$dicekclub='';
					}

					// if(strtolower($vv->jenis)!='spp' && strtolower($vv->jenis)!='investasi')
					if(strtolower($vv->jenis)!='investasi')
					{
						if(strcmp(strtolower($vv->jenis), 'jemputan club') == 0)
						{
							$ck='<input type="checkbox" '.$dicekclub.' name="name_tagihan['.$vv->id.']" id="name_tagihan_'.$vv->id.'_'.str_replace('.','_',$v->nis).'" class="name_tagihan_'.$vv->id.'" alt="'.str_replace('.','_',$v->nis).'" onChange="cekTagihan(\''.str_replace('.','_',$v->nis).'\','.$vv->id.',\''.strtolower(str_replace(' ', '_', $vv->jenis)).'\')" style="height:21px;">';
							// $ck='<input type="checkbox" '.$dicekclub.' name="name_tagihan['.$vv->id.']" id="name_tagihan_'.$vv->id.'_'.$v->nis.'" class="name_tagihan_'.$vv->id.'" alt="'.$v->nis.'" onChange="cekTagihan(\''.$v->nis.'\','.$vv->id.',\''.strtolower(str_replace(' ', '_', $vv->jenis)).'\')">';

							$jumlah=$jumlah_jp_club;
							
						}
						else
						{

							// $ck='3';
							$ck='<input type="checkbox" '.$dicek.' name="name_tagihan['.$vv->id.']" id="name_tagihan_'.$vv->id.'_'.str_replace('.','_',$v->nis).'" class="name_tagihan_'.$vv->id.'" alt="'.str_replace('.','_',$v->nis).'" onChange="cekTagihan(\''.str_replace('.','_',$v->nis).'\','.$vv->id.',\''.strtolower(str_replace(' ', '_', $vv->jenis)).'\')" style="height:21px;">';
							// $ck='<input type="checkbox" '.$dicek.' name="name_tagihan['.$vv->id.']" id="name_tagihan_'.$vv->id.'_'.$v->nis.'" class="name_tagihan_'.$vv->id.'" alt="'.$v->nis.'" onChange="cekTagihan(\''.$v->nis.'\','.$vv->id.',\''.strtolower(str_replace(' ', '_', $vv->jenis)).'\')">';
						}
							
						if($ilangin_chk==1)
							$ck='<div style="height:21px;">&nbsp;</div>';
						else if($ilangin_chk==2)
							$ck=$chk_box;

							if(isset($tagihan2[strtolower($vv->jenis)][$v->nis]))
							{
								if(count($tagihan2[strtolower($vv->jenis)][$v->nis])>1)
								{
									foreach($tagihan2[strtolower($vv->jenis)][$v->nis] as $kt => $vt)
									{
										if(isset($ck_dobel[$vt->id_tagihan]))
										{
											// $ck.='<input type="checkbox" checked="checked" name="name_tagihan['.$vt->id_jenis_penerimaan.']" id="name_tagihan_'.$vt->id_jenis_penerimaan.'_'.str_replace('.','_',$v->nis).'" class="name_tagihan_'.$vt->id_jenis_penerimaan.'" alt="'.str_replace('.','_',$v->nis).'" onChange="cekTagihan(\''.str_replace('.','_',$v->nis).'\','.$vt->id_jenis_penerimaan.',\''.strtolower(str_replace(' ', '_', $vt->jenis)).'\')" style="height:21px;">';
											$ck.=$ck_dobel[$vt->id_tagihan];
										}
										// else
										// {
										// 	$ck.='<div style="height:21px;">&nbsp;</div>';
										// }
									}
								}
								else
								{
									$ck=$ck;
								}
							}
							else
							{
								$ck=$ck;
							}
						
					}
					else if(strtolower($vv->jenis)=='investasi' || strtolower($vv->jenis)!='biaya seleksi')
						$ck='<div style="height:21px;">&nbsp;</div>';


						
					if(strtolower($vv->jenis)!='investasi' && strtolower($vv->jenis)!='biaya seleksi')
					{
						echo '<td class="right" style="text-align:right;width:120px !important">
							<div style="float:left;width:15px !important">'.$ck.'</div>';
						echo '<div style="float:right;width:80% !important" class="input_'.$vv->id.'" alt="'.str_replace('.','_',$v->nis).'" id="input_'.str_replace('.','_',$v->nis).'_'.$vv->id.'">'.$jumlah.'</div>';
						echo '</td>';
						
					}
				}
			
			}
			
			if($batch->kategori=='sd')
			{
				$get_id_jenis=$this->db->from('t_jenis_penerimaan')->where('level',$batch->kategori)->where('jenis','Program Pembelajaran')->order_by('id','desc')->get()->result();
			}
			elseif($batch->kategori=='pg')
			{
				$get_id_jenis=$this->db->from('t_jenis_penerimaan')->like('level','pg_')->where('jenis','Program Pembelajaran')->order_by('id','desc')->get()->result();
			}
			else
			{
				$get_id_jenis=$this->db->from('t_jenis_penerimaan')->where('level',$batch->kategori)->where('jenis','Program Pembelajaran')->order_by('id','desc')->get()->result();

			}
			
			// echo 'ßßpre>';
			// print_r($get_id_jenis);
			// echo '</pre>';
			if(count($get_id_jenis)!=0)
			{
				$id_jns=$get_id_jenis[0];
				$idinves=$id_jns->id;
			}
			else
			{
				$idinves=-1;
			}	
			
			$tgk_inves=0;

			if(isset($inves2[$v->nis]))
			{
				// echo '<pre>';
				// print_r($inves[$tahun_inves][$idinves][$v->nis]);
				// echo '</pre>';
				$color='#ccf7c8';
				$jlh_inves=array_sum($inves2[$v->nis]);
				$tgk_inves=1;
			}

			if(isset($inves[$tahun_inves][$idinves][$v->nis]))
			{
				// echo '<pre>';
				// print_r($inves[$tahun_inves][$idinves][$v->nis]);
				// echo '</pre>';
				$color='#ccf7c8';
				$jlh_inves=$inves[$tahun_inves][$idinves][$v->nis]->sisa_bayar;
				$tgk_inves=1;
			}
			else
			{
				$jlh_inves=0;
				$color='#f7c8c8';
			}
			echo '<td style="width:120px !important">
				<input id="tagih" type="text" name="tagih['.str_replace('.','_',$v->nis).']['.$idinves.'__ProgrammPembelajaran]" value="'.number_format($jlh_inves).'" style="text-align:right;background:'.$color.';width:90%;float:right;color:black;width:80% !important">
			</td>';	

			if(isset($inves2[$v->nis]))
			{

				if(count($inves2[$v->nis])!=0)
				{
					echo '<td style="width:100px !important;text-align:right"><a href="javascript:detailinves(\''.$v->nis.'\',\''.$tahun_ajaran_baru.'\')">'.number_format(array_sum($inves2[$v->nis]),0,',','.').'</a></td>';
				}
			}
			else
				echo '<td style="width:90px !important"></td>';	
			
			//----investasi tagihan
			// if(isset($inv_data[$batch->kategori]))
			// {
			// 	// $jlh_investasi=isset($inves[$tahun_inves][$idinves][$v->nis]) ? $jlh_inves=$inves[$tahun_inves][$idinves][$v->nis]->sisa_bayar : 0;
			// 	$invs=$inv_data[$batch->kategori];
			// 	$id_inves=$invs->id;
			// 	$color='#f7c8c8';
				
			// 	if(isset($inves[$tahun][$id_inves][$v->nis]))
			// 	{
			// 		$jlh_investasi=$inves[$tahun][$id_inves][$v->nis]->sisa_bayar;
			// 		$color='#ccf7c8';
			// 	}
			// 	else
			// 		$jlh_investasi=0;
				
			// 	echo '<td style="width:90px !important">aa
			// 		<input id="tagih" type="text" name="tagih['.str_replace('.','_',$v->nis).']['.$id_inves.'__Investasi]" value="'.number_format($jlh_investasi).'" style="text-align:right;background:'.$color.';width:90%;float:right;color:black;width:80% !important">
			// 	</td>';	
			// }
			// else
			// 	echo '<td style="width:90px !important"></td>';	
			//---- end
			// echo '<pre>';
			// print_r($t_sebelum[$v->nis][$v->tahun_ajaran][$bulan]);
			// echo '</pre>';
				// $jlhtunggakan=array_sum($tsb[$v->nis][$v->tahun_ajaran][$bulan][$vv->jenis]);
				// if($subtotal==0)
				// 	$jlhtunggakan=$subtotal2;
				// else
				//	$jlhtunggakan=$subtotal;
			if(count($tabseb)!=0)
			{
				if($bulan>=7 && $bulan<=12)
				{
					for($i=$bulan;$i<=12;$i++)
					{
						unset($tabseb[$i]);
					}
				}
				else if($bulan>=1 && $bulan<7)
				{
					for($i=$bulan;$i<=6;$i++)
					{
						unset($tabseb[$i]);
					}
				}

				$jtg=($tgk_inves==0 ? 0 : $jlh_inves);
				
				// echo '<pre>';
				// print_r($tabseb);
				// echo '</pre>';
				foreach($tabseb as $kt => $vt)
				{
					$jtg+=array_sum($vt);
				}
				$jlhtunggakan=$jtg;
				// $jlhtunggakan=0;
				// if($subtotal==0)
				// 	$jlhtunggakan=$jlhtunggakan+$subtotal2;
				// else
				// 	$jlhtunggakan=$jlhtunggakan+$subtotal;
				$jlhtunggakan+=$subtotal;
			}
			else	
				$jlhtunggakan=0;

			if(isset($inves2[$v->nis]))
			{
				$jlhtunggakan+=array_sum($inves2[$v->nis]);
			}

			//echo '<td></td>';
			echo '<td style="text-align:right;"><a href="javascript:detailtunggakan(\''.$v->nis.'\',\''.$v->tahun_ajaran.'\')">'.number_format($jlhtunggakan,0,',','.').'</a></td>';
			// echo '<td class="center">

			// 	<button class="btn btn-xs btn-danger" onclick="hapustagihan(\''.$v->id.'\')">
			// 		<i class="ace-icon fa fa-trash-o bigger-120"></i>
			// 	</button>
			// </td>';
			// echo '</tr>';
		}
		else
		{
			echo '<td class="left">'.$v->nama_panggilan.'</td>';
			echo '<td class="left">'.($v->jenis_kelamin=='1' || $v->jenis_kelamin=='L' ? 'Laki-laki' : ($v->jenis_kelamin=='0' || $v->jenis_kelamin=='P' ? 'Perempuan' : '')).'</td>';
			echo '<td class="left">'.($v->alamat).'</td>';
			echo '<td class="center">

				<button class="btn btn-xs btn-danger" onclick="hapusbatchsiswa(\''.$v->id_tbs.'\',\''.$id.'\')">
					<i class="ace-icon fa fa-trash-o bigger-120"></i>
				</button>
			</td>';
		}
		echo '</tr>';
		$no++;
	}
	?>
	</tbody>
</table>
<style type="text/css">
	#bulan_chosen, #tahun_chosen
	{
		width:140px !important;
	}
	.table td
	{
		padding:5px 3px 2px 3px !important;
	}
</style>
<script type="text/javascript">
	jQuery(function($){
		$('input#tagih').each(function(a){
			$(this).keyup(function(){
				// alert('a');
				$(this).formatCurrency({symbol:''})
			});
		});

				if(!ace.vars['touch']) {
					$('.chosen-select').chosen({allow_single_deselect:true});
					//resize the chosen on window resize

					$(window)
					.off('resize.chosen')
					.on('resize.chosen', function() {
						$('.chosen-select').each(function() {
							 var $this = $(this);
							 $this.next().css({'width': $this.parent().width()});
						})
					}).trigger('resize.chosen');
					//resize chosen on sidebar collapse/expand
					$(document).on('settings.ace.chosen', function(e, event_name, event_val) {
						if(event_name != 'sidebar_collapsed') return;
						$('.chosen-select').each(function() {
							 var $this = $(this);
							 $this.next().css({'width': $this.parent().width()});
						})
					});


					$('#chosen-multiple-style .btn').on('click', function(e){
						var target = $(this).find('input[type=radio]');
						var which = parseInt(target.val());
						if(which == 2) $('#form-field-select-4').addClass('tag-input-style');
						 else $('#form-field-select-4').removeClass('tag-input-style');
					});
				}
	});
	function aktifkantagihan(idbatch)
	{
		var bulan=$('#bulan').val();
		var tahun=$('#tahun').val();
		bootbox.confirm("<h3>Yakin Ingin Mengaktifkan Tagihan ini ? </h3>", function(result) {
			if(result) 
			{
				$.ajax({
					url : '<?=site_url()?>kelas/aktifkantagihan/'+idbatch+'/'+bulan+'/'+tahun,
					success : function(a)
					{
						getdatatagihan();
					}
				});
			}
		});
			
		
	}
	function detailinves(nis,tahunajaran)
	{
		bootbox.hideAll()
		var ta=tahunajaran.replace('/','_');
		$.ajax({
			url : '<?php echo site_url();?>kelas/tagihaninvesdetail/'+nis+'/'+ta,
			success : function(a)
			{
				bootbox.alert({
					size : "large",
					message : a,
					title : "Detail Tagihan DU "+tahunajaran,
					callback: function(){

					}
				});
			}
		});
	}
	function editdu(idtagihan,tahunajaran,nis)
	{
		var nominal=$('#editnominal').val();
		$.ajax({
			url : '<?=site_url()?>kelas/edittagihaninves/'+idtagihan,
			type : 'POST',
			data : {nilai : nominal},
			success:function(){
				getdatatagihan();
				detailinves(nis,tahunajaran);
			}
		});
		
	}
	function hapusdu(idtagihan,tahunajaran,nis)
	{
		$.ajax({
			url : '<?=site_url()?>kelas/hapustagihaninves/'+idtagihan,
			success:function(){
				detailinves(nis,tahunajaran);
				getdatatagihan();
			}
		});
		
	}
	function hapusTagihan(idtagihan,idjenis,kt,nis)
	{
		$.ajax({
		    url : '<?=site_url()?>penerimaan/hapuso_one_tagihan/'+idtagihan,
		    success : function(a)
		    {
				$('#ck_tagih_'+idjenis+'_'+kt+'_'+nis).hide();
				$('#in_tagih_'+idjenis+'_'+kt+'_'+nis).hide();
		    }
		});
	}

	function updateTagihan(idtagihan,idjenis,nis)
	{
		$.ajax({
		    url : '<?=site_url()?>penerimaan/update_one_tagihan/'+idtagihan,
		    success : function(a)
		    {
				$('#ck_tagih_'+idjenis+'_'+nis+'_'+idtagihan).hide();
				$('#in_tagih_'+idjenis+'_'+nis+'_'+idtagihan).hide();
				getdatatagihan();
		    }
		});
	}
	function nolkan(idtagihan,idjenis,nis)
	{
		$.ajax({
		    url : '<?=site_url()?>penerimaan/nolkan/'+idtagihan,
		    success : function(a)
		    {
				$('#ck_tagih_'+idjenis+'_'+nis+'_'+idtagihan).hide();
				$('#in_tagih_'+idjenis+'_'+nis+'_'+idtagihan).hide();
				getdatatagihan();
		    }
		});
	}
	function cekTagihan(nis,id,jenis)
	{
		var s=$('input#name_tagihan_'+id+'_'+nis);
		//alert(jenis.indexOf('jemputan'));
		if(s.is(':checked'))
		{

		    if(jenis=='catering' )
		    {
		  		// alert(nis+'--'+jenis+'--`'+id);
		    	var bulan=$('#bulan').val();
		    	var tahun=$('#tahun').val();
		    	$('div#input_'+nis+'_'+id).load('<?=site_url()?>penerimaan/formtagihan/'+jenis+'/'+bulan+'/'+tahun+'/'+nis+'__<?=$batch->id_batch?>/'+id);
		    }
		    else if(jenis=='club' )
		    {
		   // alert(nis+'--'+jenis);
		    	var bulan=$('#bulan').val();
		    	var tahun=$('#tahun').val();
		    	$('div#input_'+nis+'_'+id).load('<?=site_url()?>penerimaan/formtagihan/'+jenis+'/'+bulan+'/'+tahun+'/'+nis+'__<?=$batch->id_batch?>/'+id);
		    }
		    else if(jenis=='spp' )
		    {
		   // alert(nis+'--'+jenis);
		    	var bulan=$('#bulan').val();
		    	var tahun=$('#tahun').val();
		    	$('div#input_'+nis+'_'+id).load('<?=site_url()?>penerimaan/formtagihan/'+jenis+'/'+bulan+'/'+tahun+'/'+nis+'__<?=$batch->id_batch?>/'+id);
		    }
		    else if(jenis=='jemputan' || (jenis.indexOf('jemputan')>=0))
		    {
		   // alert(nis+'--'+jenis);
		    	var bulan=$('#bulan').val();
		    	var tahun=$('#tahun').val();
		    	$('div#input_'+nis+'_'+id).load('<?=site_url()?>penerimaan/formtagihan/'+jenis+'/'+bulan+'/'+tahun+'/'+nis+'__<?=$batch->id_batch?>/'+id);
		    }
		}
		else
		{
			var bulan=$('#bulan').val();
		    var tahun=$('#tahun').val();
			if(jenis=='catering' || (jenis.indexOf('jemputan')>=0) || jenis=='club' || jenis=='spp')
		    {
		    	$('div#input_'+nis+'_'+id).text('n/a');
		    	$.ajax({
		    		url : '<?=site_url()?>penerimaan/hapusdatatagihan/'+jenis+'/'+bulan+'/'+tahun+'/'+nis+'__<?=$batch->id_batch?>/'+id,
		    		success : function(a)
		    		{

		    		}
		    	});
		    }
		}

	}

	function pilihsemua(id,jenis)
	{
		var bulan=$('#bulan').val();
		var tahun=$('#tahun').val();

		var s=$('input#ceksemua_'+id);
		if(s.is(':checked'))
		{
			var cek=true;
			var cekk=1;
		}
		else
		{
			var cek=false;
			var cekk=0;
		}

		$('input.name_tagihan_'+id).each(function(a)
		{
			$(this).prop('checked',cek);
			var nis=$(this).attr('alt');
			// if(cek)
			if(cek)
				$('div#input_'+nis+'_'+id).load('<?=site_url()?>penerimaan/formtagihan/'+jenis+'/'+bulan+'/'+tahun+'/'+nis+'__<?=$batch->id_batch?>/'+id);
			else
				$('div#input_'+nis+'_'+id).text('n/a');

		});
	}

	function detailtunggakan(nis,tahun_ajaran)
	{
		bootbox.alert("<h3>Yakin Ingin Menghapus Data ini ?? </h3>");
	}

	function downloadsiswa(id)
	{
		var tahun=$('#tahun').val();
		var bulan=$('#bulan').val();
		window.open(
			'<?=site_url()?>kelas/downloadsiswa/'+id+'/'+tahun+'/'+bulan,
			'_blank'
		);
		// location.href='<?=site_url()?>kelas/downloadsiswa/'+id+'/'+tahun+'/'+bulan;
	}
</script>
<style>
.table th,.table td
{
	font-size:11px !important;
}
</style>