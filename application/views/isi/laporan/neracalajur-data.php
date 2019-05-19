<div class="row">
	<div class="col-xs-6">
		<!-- <button class="btn btn-xs btn-success" onclick="neracalajurnonsekolah('<?=$date?>')"><i class="fa fa-file"></i> Neraca Lajur Non Sekolah</button>
		<button class="btn btn-xs btn-primary" onclick="neracalajursekolah('<?=$date?>')"><i class="fa fa-file"></i> Neraca Lajur Sekolah</button> -->
	</div>
	<div class="col-xs-6">
		<div class="pull-right" style="margin-bottom:5px;">
			<button class="btn btn-xs btn-success" onclick="downloadneracalajur()"><i class="fa fa-download"></i> Unduh Neraca Lajur</button>
			<button class="btn btn-xs btn-primary" onclick="reloadneracalajur()"><i class="fa fa-refresh"></i> Refresh</button>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xs-12">
        <h2><?=$j_lap==-1 ? '' : 'Neraca Lajur '.($j_lap=='non' ? 'Non Sekolah' : 'Sekolah')?></h2>
        <table id="simple-table" class="table table-bordered table-hover" style="width:100%">
			<thead>
				<tr>
					<th style="text-align:center" rowspan="2">Kode</th>
					<th style="text-align:center" rowspan="2">Nama Akun</th>
                    <?php
                    foreach($header as $s => $vs)
                    {
                        echo '<th style="text-align:center" colspan="2">'.$vs.'</th>';
                    }
                    ?>
				</tr>
                <tr>
                <?php
                    foreach($header as $s => $vs)
                    {
                        echo '<th style="text-align:center;width:80px;">Debet</th>';
                        echo '<th style="text-align:center;width:80px;">Kredit</th>';
                    }
                ?>
                </tr>
			</thead>
			<tbody>
			<?php
			$jumlah_debit=$jumlah_kredit=array();
			$_total_d=array();
			$_total_k=array();
			$labarugi_d=array();
			$labarugi_k=array();
			if(strtolower($j_lap)=='sekolah')
			{
			?>
				<tr>
					<td style="text-align:center">&nbsp;</td>
					<td style="text-align:left">KAS</td>
                    <?php
                    foreach($header as $s => $vs)
                    {
						if($s==0)
						{
							$kas=(isset($neraca_awal['-1'][$th1][7]) ? $neraca_awal['-1'][$th1][7] : 0);
							if($kas>0)
							{
								$kas_debit=$kas;
								$kas_kredit=0;
							}
							else
							{
								$kas_debit=0;
								$kas_kredit=$kas;
							}
							// $kas_debit=$th1;
							// $kas_kredit=$th2;
							echo '<td style="text-align:right">'.number_format($kas_debit,0,',','.').'</td>';
							echo '<td style="text-align:right">'.number_format($kas_kredit,0,',','.').'</td>';
							$jumlah_debit[$s][]=$kas_debit;
							$jumlah_kredit[$s][]=$kas_kredit;
						}
						elseif($s==1)
						{
							echo '<td style="text-align:right">'.number_format($kas_pen,0,',','.').'</td>';
							echo '<td style="text-align:right">'.number_format($kas_peng,0,',','.').'</td>';
							$jumlah_debit[$s][]=$kas_pen;
							$jumlah_kredit[$s][]=$kas_peng;
						}
						elseif($s==2)
						{
							$neracasaldo=$kas_debit+$kas_pen-$kas_peng;
							if($neracasaldo<0)
							{
								$n_debit='(<i>'.number_format(abs($neracasaldo),0,',','.').'</i>)';
							}
							else
								$n_debit=number_format($neracasaldo,0,',','.');

							echo '<td style="text-align:right">'.$n_debit.'</td>';
							echo '<td style="text-align:right">0</td>';
							$jumlah_debit[$s][]=$neracasaldo;
							$jumlah_kredit[$s][]=0;
						}
						elseif($s==4)
						{
							$stlh_penyesuaian=$neracasaldo;
							if($stlh_penyesuaian<0)
							{
								$n_debit='(<i>'.number_format(abs($stlh_penyesuaian),0,',','.').'</i>)';
							}
							else
								$n_debit=number_format($stlh_penyesuaian,0,',','.');

							echo '<td style="text-align:right">'.$n_debit.'</td>';
							echo '<td style="text-align:right">0</td>';
							$jumlah_debit[$s][]=$stlh_penyesuaian;
							$jumlah_kredit[$s][]=0;
							$_total_d[$s][]=$stlh_penyesuaian;
							$_total_k[$s][]=0;
						}
						elseif($s==6)
						{
							$penutupan=$stlh_penyesuaian;
							if($penutupan<0)
							{
								$n_debit='(<i>'.number_format(abs($penutupan),0,',','.').'</i>)';
							}
							else
								$n_debit=number_format($penutupan,0,',','.');

							echo '<td style="text-align:right">'.$n_debit.'</td>';
							echo '<td style="text-align:right">0</td>';
							$jumlah_debit[$s][]=$penutupan;
							$jumlah_kredit[$s][]=0;
							$_total_d[$s][]=$penutupan;
							$_total_k[$s][]=0;
							$saldo_penutup['debit'][-1]=$penutupan;
							$saldo_penutup['kredit'][-1]=0;
						}
						else
						{
							echo '<td style="text-align:right">0</td>';
							echo '<td style="text-align:right">0</td>';
							$jumlah_debit[$s][]=0;
							$jumlah_kredit[$s][]=0;
						}
						
                    }
                    ?>
				</tr>
				<?php
					
					foreach($k_akun as $k =>$v)
					{
						if(strpos($v->akun_alternatif,'C')!==false)
						{
							if(strtolower($v->nama_akun)=='piutang')
							{
								$debit=$piutang_k;
								$kredit=$piutang_d;
							}
							else if(strpos(strtolower($v->nama_akun),'perlengkapan')!==false || strpos(strtolower($v->nama_akun),'peralatan')!==false)
							{
								$debit=$perlengkapan_k;
								$kredit=$perlengkapan_d;

								
							}
							else if(strpos(strtolower($v->nama_akun),'bangunan')!==false)
							{
								$debit=$bangunan_k;
								$kredit=$bangunan_d;
							}
							else if(strtolower($v->nama_akun)=='tanah')
							{
								$debit=$tanah_k;
								$kredit=$tanah_d;
							}
							else if(strpos(strtolower($v->nama_akun),'beban sewa')!==false)
							{
								$debit=$sewa_k;
								$kredit=$sewa_d;
							}
							else
							{
								$debit=0;
								$kredit=0;
							}
					?>
						<tr>
							<td style="text-align:center"><?=$v->akun_alternatif?></td>
							<td style="text-align:left"><?=$v->nama_akun?></td>
							<?php
							foreach($header as $s => $vs)
							{
								
								if($s==0)
								{
									$n=(isset($neraca_awal[$v->akun_alternatif][$th1][7]) ? $neraca_awal[$v->akun_alternatif][$th1][7] : 0);
									if($n>0)
									{
										$n_debit=$n;
										$n_kredit=0;
									}
									else
									{
										$n_debit=0;
										$n_kredit=$n;
									}
									echo '<td style="text-align:right">'.number_format($n_debit,0,',','.').'</td>';
									echo '<td style="text-align:right">'.number_format($n_kredit,0,',','.').'</td>';
									$jumlah_debit[$s][$v->akun_alternatif]=$n_debit;
									$jumlah_kredit[$s][$v->akun_alternatif]=$n_kredit;
								}
								elseif($s==1)
								{
									echo '<td style="text-align:right">'.number_format($debit,0,',','.').'</td>';
									echo '<td style="text-align:right">'.number_format($kredit,0,',','.').'</td>';
									$jumlah_debit[$s][$v->akun_alternatif]=$debit;
									$jumlah_kredit[$s][$v->akun_alternatif]=$kredit;
								}
								elseif($s==2)
								{
									$neracasaldo=$n_debit+$debit-$kredit;
									if($neracasaldo<0)
									{
										$n_debit='(<i>'.number_format(abs($neracasaldo),0,',','.').'</i>)';
									}
									else
										$n_debit=number_format($neracasaldo,0,',','.');

									echo '<td style="text-align:right">'.$n_debit.'</td>';
									echo '<td style="text-align:right">0</td>';
									$jumlah_debit[$s][]=$neracasaldo;
									$jumlah_kredit[$s][]=0;
								}
								elseif($s==3)
								{
									if(strpos(strtolower($v->nama_akun),'perlengkapan')!==false || strpos(strtolower($v->nama_akun),'peralatan')!==false)
									{
										$penyusutan_kredit=(0.5 * $neracasaldo);
										$n_debit=0;
										if($penyusutan_kredit<0)
										{
											$n_kredit='(<i>'.number_format(abs($penyusutan_kredit),0,',','.').'</i>)';
										}
										else
											$n_kredit=number_format($penyusutan_kredit,0,',','.');
										
										echo '<td style="text-align:right">0</td>';
										echo '<td style="text-align:right">'.$n_kredit.'</td>';
										$jumlah_debit[$s][]=0;
										$jumlah_kredit[$s][]=$penyusutan_kredit;
										$_total_k[$s][]=$penyusutan_kredit;
										$penyusutan_perlengkapan[$s]=$penyusutan_kredit;
									}
									elseif(strpos(strtolower($v->nama_akun),'bangunan')!==false)
									{
										$penyusutan_kredit=(0.2 * $neracasaldo);
										$n_debit=0;
										if($penyusutan_kredit<0)
										{
											$n_kredit='(<i>'.number_format(abs($penyusutan_kredit),0,',','.').'</i>)';
										}
										else
											$n_kredit=number_format($penyusutan_kredit,0,',','.');
										
										echo '<td style="text-align:right">0</td>';
										echo '<td style="text-align:right">'.$n_kredit.'</td>';
										$jumlah_debit[$s][]=0;
										$jumlah_kredit[$s][]=$penyusutan_kredit;
										$_total_k[$s][]=$penyusutan_kredit;
										$penyusutan_bangunan[$s]=$penyusutan_kredit;
									}
									elseif(strpos(strtolower($v->nama_akun),'tanah')!==false)
									{
										$penyusutan_kredit=(0.05 * $neracasaldo);
										$n_debit=0;
										if($penyusutan_kredit<0)
										{
											$n_kredit='(<i>'.number_format(abs($penyusutan_kredit),0,',','.').'</i>)';
										}
										else
											$n_kredit=number_format($penyusutan_kredit,0,',','.');
										
										echo '<td style="text-align:right">'.$n_kredit.'</td>';
										echo '<td style="text-align:right">0</td>';
										$jumlah_debit[$s][]=$penyusutan_kredit;
										$jumlah_kredit[$s][]=0;
										$_total_d[$s][]=$penyusutan_kredit;
										$aktiva_penyusutan[$s]=$penyusutan_kredit;
									}
									else
									{
										echo '<td style="text-align:right">0</td>';
										echo '<td style="text-align:right">0</td>';
										$jumlah_debit[$s][$v->akun_alternatif]=0;
										$jumlah_kredit[$s][$v->akun_alternatif]=0;
									}
								}
								elseif($s==4)
								{
									if(strpos(strtolower($v->nama_akun),'perlengkapan')!==false || strpos(strtolower($v->nama_akun),'peralatan')!==false)
									{
										$stlh_penyusutan_kredit=$neracasaldo+$n_debit-$penyusutan_kredit;
										$n_kredit=0;
										if($stlh_penyusutan_kredit<0)
										{
											$n_debit='(<i>'.number_format(abs($stlh_penyusutan_kredit),0,',','.').'</i>)';
										}
										else
											$n_debit=number_format($stlh_penyusutan_kredit,0,',','.');
										
										echo '<td style="text-align:right">'.$n_debit.'</td>';
										echo '<td style="text-align:right">0</td>';
										$jumlah_debit[$s][]=0;
										$jumlah_kredit[$s][]=$stlh_penyusutan_kredit;
										$_total_k[$s][]=0;
										$penyusutan_perlengkapan[$s]=$stlh_penyusutan_kredit;
										$_total_d[$s][]=$stlh_penyusutan_kredit;

									}
									elseif(strpos(strtolower($v->nama_akun),'bangunan')!==false)
									{
										$stlh_penyusutan_kredit=$neracasaldo+$n_debit-$penyusutan_kredit;
										$n_kredit=0;
										if($stlh_penyusutan_kredit<0)
										{
											$n_debit='(<i>'.number_format(abs($stlh_penyusutan_kredit),0,',','.').'</i>)';
										}
										else
											$n_debit=number_format($stlh_penyusutan_kredit,0,',','.');
										
										echo '<td style="text-align:right">'.$n_debit.'</td>';
										echo '<td style="text-align:right">0</td>';
										$jumlah_debit[$s][]=0;
										$jumlah_kredit[$s][]=$stlh_penyusutan_kredit;
										$_total_k[$s][]=0;
										$penyusutan_bangunan[$s]=$stlh_penyusutan_kredit;
										$_total_d[$s][]=$stlh_penyusutan_kredit;
									}
									elseif(strpos(strtolower($v->nama_akun),'tanah')!==false)
									{
										$stlh_penyusutan_kredit=$neracasaldo+$n_debit-$penyusutan_kredit;
										$n_kredit=0;
										if($stlh_penyusutan_kredit<0)
										{
											$n_debit='(<i>'.number_format(abs($stlh_penyusutan_kredit),0,',','.').'</i>)';
										}
										else
											$n_debit=number_format($stlh_penyusutan_kredit,0,',','.');
										
										echo '<td style="text-align:right">'.$n_debit.'</td>';
										echo '<td style="text-align:right">0</td>';
										$jumlah_debit[$s][]=$stlh_penyusutan_kredit;
										$jumlah_kredit[$s][]=0;
										$_total_d[$s][]=$stlh_penyusutan_kredit;
										$aktiva_penyusutan[$s]=$stlh_penyusutan_kredit;
										$_total_k[$s][]=0;
									}
									else
									{
										$stlh_penyusutan_kredit=$neracasaldo;
										$n_kredit=0;
										if($stlh_penyusutan_kredit<0)
										{
											$n_debit='(<i>'.number_format(abs($stlh_penyusutan_kredit),0,',','.').'</i>)';
										}
										else
											$n_debit=number_format($stlh_penyusutan_kredit,0,',','.');
										
										echo '<td style="text-align:right">'.$n_debit.'</td>';
										echo '<td style="text-align:right">0</td>';
										$jumlah_debit[$s][]=$stlh_penyusutan_kredit;
										$jumlah_kredit[$s][]=0;
										$_total_d[$s][]=$stlh_penyusutan_kredit;
										$aktiva_penyusutan[$s]=$stlh_penyusutan_kredit;
										$_total_k[$s][]=0;
									}
									
								}

								elseif($s==6)
								{
									if(strpos(strtolower($v->nama_akun),'perlengkapan')!==false || strpos(strtolower($v->nama_akun),'peralatan')!==false)
									{
										$penutupan=$stlh_penyusutan_kredit;
										$n_kredit=0;
										if($penutupan<0)
										{
											$n_debit='(<i>'.number_format(abs($stlh_penyusutan_kredit),0,',','.').'</i>)';
										}
										else
											$n_debit=number_format($penutupan,0,',','.');
										
										echo '<td style="text-align:right">'.$n_debit.'</td>';
										echo '<td style="text-align:right">0</td>';
										$jumlah_debit[$s][]=0;
										$jumlah_kredit[$s][]=$penutupan;
										$_total_k[$s][]=0;
										$_total_d[$s][]=$penutupan;
										$penyusutan_perlengkapan[$s]=$penutupan;
										$saldo_penutup['kredit'][$v->akun_alternatif]=0;
										$saldo_penutup['debit'][$v->akun_alternatif]=$penutupan;
									}
									elseif(strpos(strtolower($v->nama_akun),'bangunan')!==false)
									{
										$penutupan=$stlh_penyusutan_kredit;
										$n_kredit=0;
										if($penutupan<0)
										{
											$n_debit='(<i>'.number_format(abs($penutupan),0,',','.').'</i>)';
										}
										else
											$n_debit=number_format($penutupan,0,',','.');
										
										echo '<td style="text-align:right">'.$n_debit.'</td>';
										echo '<td style="text-align:right">0</td>';
										$jumlah_debit[$s][]=0;
										$jumlah_kredit[$s][]=$penutupan;
										$_total_k[$s][]=0;
										$_total_d[$s][]=$penutupan;
										$penyusutan_bangunan[$s]=$penutupan;
										$saldo_penutup['kredit'][$v->akun_alternatif]=0;
										$saldo_penutup['debit'][$v->akun_alternatif]=$penutupan;
									}
									elseif(strpos(strtolower($v->nama_akun),'tanah')!==false)
									{
										$penutupan=$stlh_penyusutan_kredit;
										$n_kredit=0;
										if($penutupan<0)
										{
											$n_debit='(<i>'.number_format(abs($penutupan),0,',','.').'</i>)';
										}
										else
											$n_debit=number_format($penutupan,0,',','.');
										
										echo '<td style="text-align:right">'.$n_debit.'</td>';
										echo '<td style="text-align:right">0</td>';
										$jumlah_debit[$s][]=$penutupan;
										$jumlah_kredit[$s][]=0;
										$_total_d[$s][]=$penutupan;
										$aktiva_penyusutan[$s]=$penutupan;
										$_total_k[$s][]=0;
										$saldo_penutup['kredit'][$v->akun_alternatif]=0;
										$saldo_penutup['debit'][$v->akun_alternatif]=$penutupan;
									}
									else
									{
										$penutupan=$stlh_penyusutan_kredit;
										$n_kredit=0;
										if($penutupan<0)
										{
											$n_debit='(<i>'.number_format(abs($penutupan),0,',','.').'</i>)';
										}
										else
											$n_debit=number_format($penutupan,0,',','.');
										
										echo '<td style="text-align:right">'.$n_debit.'</td>';
										echo '<td style="text-align:right">0</td>';
										$jumlah_debit[$s][]=$penutupan;
										$jumlah_kredit[$s][]=0;
										$_total_d[$s][]=$penutupan;
										$_total_k[$s][]=0;
										$aktiva_penyusutan[$s]=$penutupan;
										$saldo_penutup['kredit'][$v->akun_alternatif]=0;
										$saldo_penutup['debit'][$v->akun_alternatif]=$penutupan;
									}
									
									
								}
								else
								{
									echo '<td style="text-align:right">0</td>';
									echo '<td style="text-align:right">0</td>';
									$jumlah_debit[$s][$v->akun_alternatif]=0;
									$jumlah_kredit[$s][$v->akun_alternatif]=0;
								}
								
							}
							?>
						</tr>	
				<?php
						}
				}
				?>
				<tr>
					<td style="text-align:center">&nbsp;</td>
					<td style="text-align:left">Sewa Dibayar Dimuka</td>
                    <?php
                    foreach($header as $s => $vs)
                    {
						$kode_akun_alt='D200';
						if($s==0)
						{
							$n=(isset($neraca_awal[$kode_akun_alt][$th1][7]) ? $neraca_awal[$kode_akun_alt][$th1][7] : 0);
							if($n>0)
							{
								$n_debit=$n;
								$n_kredit=0;
							}
							else
							{
								$n_debit=0;
								$n_kredit=$n;
							}
							echo '<td style="text-align:right">'.number_format($n_debit,0,',','.').'</td>';
							echo '<td style="text-align:right">'.number_format($n_kredit,0,',','.').'</td>';
							$jumlah_debit[$s][]=$n_debit;
							$jumlah_kredit[$s][]=$n_kredit;
						}
						elseif($s==1)
						{
							echo '<td style="text-align:right">'.number_format($sewa_k,0,',','.').'</td>';
							echo '<td style="text-align:right">'.number_format($sewa_d,0,',','.').'</td>';
							$jumlah_debit[$s][]=$sewa_k;
							$jumlah_kredit[$s][]=$sewa_d;
						}
						elseif($s==2)
						{
							$neracasaldo=$n_debit+$sewa_k-$sewa_d;
							if($neracasaldo<0)
							{
								$n_debit='(<i>'.number_format(abs($neracasaldo),0,',','.').'</i>)';
							}
							else
								$n_debit=number_format($neracasaldo,0,',','.');
							echo '<td style="text-align:right">'.$n_debit.'</td>';
							echo '<td style="text-align:right">0</td>';
							$jumlah_debit[$s][]=$neracasaldo;
							$jumlah_kredit[$s][]=0;
						}
						elseif($s==4)
						{
							$neracasaldoo=$neracasaldo;
							if($neracasaldoo<0)
							{
								$n_debit='(<i>'.number_format(abs($neracasaldoo),0,',','.').'</i>)';
							}
							else
								$n_debit=number_format($neracasaldoo,0,',','.');
							echo '<td style="text-align:right">'.$n_debit.'</td>';
							echo '<td style="text-align:right">0</td>';
							$jumlah_debit[$s][]=$neracasaldoo;
							$jumlah_kredit[$s][]=0;
						}
						elseif($s==6)
						{
							$penutupan=$neracasaldoo;
							if($penutupan<0)
							{
								$n_debit='(<i>'.number_format(abs($penutupan),0,',','.').'</i>)';
							}
							else
								$n_debit=number_format($penutupan,0,',','.');
							echo '<td style="text-align:right">'.$n_debit.'</td>';
							echo '<td style="text-align:right">0</td>';
							$jumlah_debit[$s][]=$penutupan;
							$jumlah_kredit[$s][]=0;
							$_total_k[$s][]=0;
							$_total_d[$s][]=$penutupan;
							$saldo_penutup['kredit']['D200']=0;
							$saldo_penutup['debit']['D200']=$penutupan;
						}
						else
						{
							echo '<td style="text-align:right">0</td>';
							echo '<td style="text-align:right">0</td>';
							$jumlah_debit[$s][$kode_akun_alt]=0;
							$jumlah_kredit[$s][$kode_akun_alt]=0;
						}
                       
                    }
                    ?>
				</tr>
				<tr>
					<td style="text-align:center">&nbsp;</td>
					<td style="text-align:left">Utang</td>
                    <?php
                    foreach($header as $s => $vs)
                    {
						if($s==0)
						{
							$n=(isset($neraca_awal['D100'][$th1][7]) ? $neraca_awal['D100'][$th1][7] : 0);
							if($n<0)
							{
								$n_kredit='(<i>'.number_format(abs($n),0,',','.').'</i>)';
							}
							else
								$n_kredit=number_format($n,0,',','.');

							echo '<td style="text-align:right">'.number_format(0,0,',','.').'</td>';
							echo '<td style="text-align:right">'.$n_kredit.'</td>';
							$jumlah_debit[$s][]=0;
							$jumlah_kredit[$s][]=$n;
						}
						elseif($s==1)
						{
							echo '<td style="text-align:right">'.number_format($utang_k,0,',','.').'</td>';
							echo '<td style="text-align:right">'.number_format($utang_d,0,',','.').'</td>';
							$jumlah_debit[$s][]=$utang_k;
							$jumlah_kredit[$s][]=$utang_d;
						}
						elseif($s==2)
						{
							$neracasaldo=$n-$utang_k+$utang_d;
							if($neracasaldo<0)
							{
								$n_kredit='(<i>'.number_format(abs($neracasaldo),0,',','.').'</i>)';
							}
							else
								$n_kredit=number_format($neracasaldo,0,',','.');
							echo '<td style="text-align:right">0</td>';
							echo '<td style="text-align:right">'.$n_kredit.'</td>';
							$jumlah_debit[$s][]=0;
							$jumlah_kredit[$s][]=$neracasaldo;
						}
						elseif($s==4)
						{
							$neracasaldo=$n-$utang_k+$utang_d;
							if($neracasaldo<0)
							{
								$n_kredit='(<i>'.number_format(abs($neracasaldo),0,',','.').'</i>)';
							}
							else
								$n_kredit=number_format($neracasaldo,0,',','.');
							echo '<td style="text-align:right">0</td>';
							echo '<td style="text-align:right">'.$n_kredit.'</td>';
							$jumlah_debit[$s][]=0;
							$jumlah_kredit[$s][]=$neracasaldo;
							$_total_k[$s][]=$neracasaldo;
						}
						elseif($s==6)
						{
							$penutupan=$neracasaldo;
							if($penutupan<0)
							{
								$n_kredit='(<i>'.number_format(abs($penutupan),0,',','.').'</i>)';
							}
							else
								$n_kredit=number_format($penutupan,0,',','.');
							echo '<td style="text-align:right">0</td>';
							echo '<td style="text-align:right">'.$n_kredit.'</td>';
							$jumlah_debit[$s][]=0;
							$jumlah_kredit[$s][]=$penutupan;
							$_total_k[$s][]=$penutupan;
							$saldo_penutup['debit']['D100']=0;
							$saldo_penutup['kredit']['D100']=$penutupan;
						}
						else
						{
							echo '<td style="text-align:right">0</td>';
							echo '<td style="text-align:right">0</td>';
							$jumlah_debit[$s][$v->akun_alternatif]=0;
							$jumlah_kredit[$s][$v->akun_alternatif]=0;
						}
						
                    }
                    ?>
				</tr>
				<tr>
					<td style="text-align:center">&nbsp;</td>
					<td style="text-align:left">Aktiva Bersih</td>
                    <?php
                    foreach($header as $s => $vs)
                    {
						if($s==0 )
						{
							$n=(isset($neraca_awal['-2'][$th1][7]) ? $neraca_awal['-2'][$th1][7] :0);
							if($n<0)
							{
								$n_kredit='(<i>'.number_format(abs($n),0,',','.').'</i>)';
							}
							else
								$n_kredit=number_format($n,0,',','.');

							echo '<td style="text-align:right">'.number_format(0,0,',','.').'</td>';
							echo '<td style="text-align:right">'.$n_kredit.'</td>';
							$jumlah_debit[$s]['-2']=0;
							$jumlah_kredit[$s]['-2']=$n;
						}
						elseif($s==2 )
						{

							echo '<td style="text-align:right">'.number_format(0,0,',','.').'</td>';
							echo '<td style="text-align:right">'.$n_kredit.'</td>';
							$jumlah_debit[$s]['-2']=0;
							$jumlah_kredit[$s]['-2']=$n;
						}
						elseif($s==3)
						{
							if(isset($aktiva_penyusutan[$s]))
							{
								echo '<td style="text-align:right">'.number_format(0,0,',','.').'</td>';
								echo '<td style="text-align:right">'.number_format($aktiva_penyusutan[$s],0,',','.').'</td>';
								$jumlah_debit[$s]['-2']=0;
								$jumlah_kredit[$s]['-2']=$aktiva_penyusutan[$s];
								$_total_k[$s][]=$aktiva_penyusutan[$s];
								$ak_peyusutan=$aktiva_penyusutan[$s];
							}
							else
							{
								echo '<td style="text-align:right">'.number_format(0,0,',','.').'</td>';
								echo '<td style="text-align:right">'.$n_kredit.'</td>';
								$jumlah_debit[$s]['-2']=0;
								$jumlah_kredit[$s]['-2']=$n;
							}
						}
						elseif($s==4)
						{
							if(isset($ak_peyusutan))
							{
								$stlh_peny=$n+$ak_peyusutan;
								echo '<td style="text-align:right">'.number_format(0,0,',','.').'</td>';
								echo '<td style="text-align:right">'.number_format($stlh_peny,0,',','.').'</td>';
								$jumlah_debit[$s]['-2']=0;
								$jumlah_kredit[$s]['-2']=$stlh_peny;
								$_total_k[$s][]=$stlh_peny;
							}
							else
							{
								echo '<td style="text-align:right">'.number_format(0,0,',','.').'</td>';
								echo '<td style="text-align:right">'.$n_kredit.'</td>';
								$jumlah_debit[$s]['-2']=0;
								$jumlah_kredit[$s]['-2']=$n;
							}
						}
						elseif($s==6)
						{
							if(isset($ak_peyusutan))
							{
								$penutpan=$stlh_peny;
								echo '<td style="text-align:right">'.number_format(0,0,',','.').'</td>';
								echo '<td style="text-align:right">'.number_format($penutpan,0,',','.').'</td>';
								$jumlah_debit[$s]['-2']=0;
								$jumlah_kredit[$s]['-2']=$penutpan;
								$_total_k[$s][]=$penutpan;

								$saldo_penutup['debit'][-2]=0;
								$saldo_penutup['kredit'][-2]=$penutpan;
							}
							else
							{
								echo '<td style="text-align:right">'.number_format(0,0,',','.').'</td>';
								echo '<td style="text-align:right">'.$n_kredit.'</td>';
								$jumlah_debit[$s]['-2']=0;
								$jumlah_kredit[$s]['-2']=$n;
							}
						}
						else
						{

							echo '<td style="text-align:right">0</td>';
							echo '<td style="text-align:right">0</td>';
							$jumlah_debit[$s][$v->akun_alternatif]=0;
							$jumlah_kredit[$s][$v->akun_alternatif]=0;
						}
					}
                    ?>
				</tr>
				<tr>
					<th colspan="<?=((count($header)*2)+2)?>">&nbsp;</th>
				</tr>
				<?php
					foreach($k_akun as $k =>$v)
					{
						if(strpos($v->akun_alternatif,'C')===false && strpos($v->akun_alternatif,'D100')===false)
						{
							if(strpos(strtolower($v->nama_akun),'pinjaman')===false && strpos(strtolower($v->nama_akun),'piutang')===false)
							{
					?>
						<tr>
							<td style="text-align:center"><?=$v->akun_alternatif?></td>
							<td style="text-align:left"><?=$v->nama_akun?></td>
							<?php
							foreach($header as $s => $vs)
							{

								if(strpos(strtolower($v->nama_akun),'pembiayaan fasilitas')!==false)
								{
									$debit=$pemb_fasilitas_k;
									$kredit=$pemb_fasilitas_d;
								}	
								elseif(strpos(strtolower($v->nama_akun),'pembiayaan pendidikan tahunan')!==false)
								{
									$debit=$pemb_pendidikan_k;
									$kredit=$pemb_pendidikan_d;
								}	
								elseif(strpos(strtolower($v->nama_akun),'pembiayaan pendidikan bulanan')!==false)
								{
									$debit=$pemb_pendidikan_bulanan_k;
									$kredit=$pemb_pendidikan_bulanan_d;
								}	
								elseif(strpos(strtolower($v->nama_akun),'sumbangan lain')!==false)
								{
									$debit=$pemb_lain_k;
									$kredit=$pemb_lain_d;
								}	
								elseif(strpos(strtolower($v->nama_akun),'belanja gaji')!==false)
								{
									$debit=$gaji_k;
									$kredit=$gaji_d;
								}	
								elseif(strpos(strtolower($v->nama_akun),'divisi pendidikan')!==false)
								{
									$debit=$div_pendidikan_k;
									$kredit=$div_pendidikan_d;
								}	
								elseif(strpos(strtolower($v->nama_akun),'divisi operasional')!==false)
								{
									$debit=$div_operasional_k;
									$kredit=$div_operasional_d;
								}	
								elseif(strpos(strtolower($v->nama_akun),'biaya utilitas')!==false)
								{
									$debit=$biaya_utilitas_k;
									$kredit=$biaya_utilitas_d;
								}	
								elseif(strpos(strtolower($v->nama_akun),'beban sewa')!==false)
								{
									$debit=$beban_sewa_k;
									$kredit=$beban_sewa_d;
								}	
								elseif(strpos(strtolower($v->nama_akun),'dana sosial')!==false)
								{
									$debit=$dana_sosial_k;
									$kredit=$dana_sosial_d;
								}	
								else
								{
									$debit=0;
									$kredit=0;
								}
								if($s==1)
								{
									echo '<td style="text-align:right">'.number_format($debit,0,',','.').'</td>';
									echo '<td style="text-align:right">'.number_format($kredit,0,',','.').'</td>';
									$jumlah_debit[$s][$v->akun_alternatif]=$debit;
									$jumlah_kredit[$s][$v->akun_alternatif]=$kredit;
								}
								elseif($s==2)
								{
									echo '<td style="text-align:right">'.number_format($debit,0,',','.').'</td>';
									echo '<td style="text-align:right">'.number_format($kredit,0,',','.').'</td>';
									$jumlah_debit[$s][$v->akun_alternatif]=$debit;
									$jumlah_kredit[$s][$v->akun_alternatif]=$kredit;
								}
								elseif($s==4)
								{
									echo '<td style="text-align:right">'.number_format($debit,0,',','.').'</td>';
									echo '<td style="text-align:right">'.number_format($kredit,0,',','.').'</td>';
									$jumlah_debit[$s][$v->akun_alternatif]=$debit;
									$jumlah_kredit[$s][$v->akun_alternatif]=$kredit;
									$_total_d[$s][$v->akun_alternatif]=$debit;
									$_total_k[$s][$v->akun_alternatif]=$kredit;
								}
								elseif($s==5)
								{
									echo '<td style="text-align:right">'.number_format($debit,0,',','.').'</td>';
									echo '<td style="text-align:right">'.number_format($kredit,0,',','.').'</td>';
									$jumlah_debit[$s][$v->akun_alternatif]=$debit;
									$jumlah_kredit[$s][$v->akun_alternatif]=$kredit;
									$labarugi_d[$s][$v->akun_alternatif]=$debit;
									$labarugi_k[$s][$v->akun_alternatif]=$kredit;
								}
								else
								{
									echo '<td style="text-align:right">0</td>';
									echo '<td style="text-align:right">0</td>';
									$jumlah_debit[$s][$v->akun_alternatif]=0;
									$jumlah_kredit[$s][$v->akun_alternatif]=0;
								}
								
								
							}
							?>
						</tr>	
				<?php
							}
						}
				}
				?>
				<tr>
					<th style="background:#ddd;border:1px solid #aaa">&nbsp;</th>
					<th style="background:#ddd;border:1px solid #aaa">&nbsp;</th>
					<?php
                    foreach($header as $s => $vs)
                    {
						if($s<3)
						{

							$subtotaldebit=array_sum($jumlah_debit[$s]);
							$subtotalkredit=array_sum($jumlah_kredit[$s]);
							echo '<th style="text-align:right;background:#ddd;border:1px solid #aaa">'.number_format($subtotaldebit,0,',','.').'</th>';
							echo '<th style="text-align:right;background:#ddd;border:1px solid #aaa">'.number_format($subtotalkredit,0,',','.').'</th>';
						}
						else
						{
							echo '<th style="text-align:right;background:#ddd;border:1px solid #aaa"></th>';
							echo '<th style="text-align:right;background:#ddd;border:1px solid #aaa"></th>';
						}
					}
                    ?>
				</tr>
				<tr>
					<td style="text-align:center">&nbsp;</td>
					<td style="text-align:left">Beban Penyusutan Perlengkapan (50%)</td>
                    <?php
					
                    foreach($header as $s => $vs)
                    {
						if($s==3)
						{
							if(isset($penyusutan_perlengkapan[$s]))
							{
								$beban=$penyusutan_perlengkapan[$s];
								echo '<td style="text-align:right">'.number_format($beban,0,',','.').'</td>';
								echo '<td style="text-align:right">0</td>';
								$_total_d[$s][]=$susut_peralatan=$beban;
								$_total_k[$s][]=0;
							}
							else
							{
								echo '<td style="text-align:right">0</td>';
								echo '<td style="text-align:right">0</td>';
								$_total_d[$s][]=0;
								$_total_k[$s][]=0;
							}
						}
						elseif($s==4)
						{
							if(isset($susut_peralatan))
							{
								echo '<td style="text-align:right">'.number_format($susut_peralatan,0,',','.').'</td>';
								echo '<td style="text-align:right">0</td>';
								$_total_d[$s][]=$susut_peralatan;
								$_total_k[$s][]=0;
							}
							else
							{
								echo '<td style="text-align:right">0</td>';
								echo '<td style="text-align:right">0</td>';
								$_total_d[$s][]=0;
								$_total_k[$s][]=0;
							}
						}
						elseif($s==5)
						{
							if(isset($susut_peralatan))
							{
								echo '<td style="text-align:right">'.number_format($susut_peralatan,0,',','.').'</td>';
								echo '<td style="text-align:right">0</td>';
								$_total_d[$s][]=$susut_peralatan;
								$_total_k[$s][]=0;
								$labarugi_d[$s][]=$susut_peralatan;
								$labarugi_k[$s][]=0;

							}
							else
							{
								echo '<td style="text-align:right">0</td>';
								echo '<td style="text-align:right">0</td>';
								$_total_d[$s][]=0;
								$_total_k[$s][]=0;
								$labarugi_d[$s][]=0;
								$labarugi_k[$s][]=0;

							}
						}
						else
						{
							echo '<td style="text-align:right"></td>';
							echo '<td style="text-align:right"></td>';
							$_total_d[$s][]=0;
							$_total_k[$s][]=0;
						}
                    }
                    ?>
				</tr>
				<tr>
					<td style="text-align:center">&nbsp;</td>
					<td style="text-align:left">Beban Penyusutan Bangunan (20%)</td>
                    <?php
                    foreach($header as $s => $vs)
                    {
						if($s==3)
						{
							if(isset($penyusutan_bangunan[$s]))
							{
								$beban_bg=$penyusutan_bangunan[$s];
								echo '<td style="text-align:right">'.number_format($beban_bg,0,',','.').'</td>';
								echo '<td style="text-align:right">0</td>';
								$_total_d[$s][]=$susut_bangunan=$beban_bg;
								$_total_k[$s][]=0;
							}
							else
							{
								echo '<td style="text-align:right">0</td>';
								echo '<td style="text-align:right">0</td>';
								$_total_d[$s][]=0;
								$_total_k[$s][]=0;
							}
						}
						elseif($s==4)
						{
							if(isset($susut_bangunan))
							{
								echo '<td style="text-align:right">'.number_format($susut_bangunan,0,',','.').'</td>';
								echo '<td style="text-align:right">0</td>';
								$_total_d[$s][]=$susut_bangunan;
								$_total_k[$s][]=0;
							}
							else
							{
								echo '<td style="text-align:right">0</td>';
								echo '<td style="text-align:right">0</td>';
								$_total_d[$s][]=0;
								$_total_k[$s][]=0;
							}
						}
						elseif($s==5)
						{
							if(isset($susut_bangunan))
							{
								echo '<td style="text-align:right">'.number_format($susut_bangunan,0,',','.').'</td>';
								echo '<td style="text-align:right">0</td>';
								$_total_d[$s][]=$susut_bangunan;
								$_total_k[$s][]=0;
								$labarugi_d[$s][]=$susut_bangunan;
								$labarugi_k[$s][]=0;
							}
							else
							{
								echo '<td style="text-align:right">0</td>';
								echo '<td style="text-align:right">0</td>';
								$_total_d[$s][]=0;
								$_total_k[$s][]=0;
								$labarugi_d[$s][]=0;
								$labarugi_k[$s][]=0;
								
							}
						}
						else
						{

							echo '<td style="text-align:right""></td>';
							echo '<td style="text-align:right""></td>';
							$_total_d[$s][]=0;
							$_total_k[$s][]=0;
						}
                    }
                    ?>
				</tr>
				<tr>
					<th style="background:#ccc;border:1px solid #aaa">&nbsp;</th>
					<th style="background:#ccc;border:1px solid #aaa">&nbsp;</th>
					<?php
                    foreach($header as $s => $vs)
                    {
						if($s>=3)
						{
							$totd=array_sum($_total_d[$s]);
							$totk=array_sum($_total_k[$s]);
							echo '<th style="text-align:right;background:#ccc;border:1px solid #aaa" id="div_total_d_'.$s.'">'.number_format($totd,0,',','.').'</th>';
							echo '<th style="text-align:right;background:#ccc;border:1px solid #aaa" id="div_total_k_'.$s.'">'.number_format($totk,0,',','.').'</th>';
						}
						else
						{
							echo '<th style="text-align:right;background:#ccc;border:1px solid #aaa" ></th>';
							echo '<th style="text-align:right;background:#ccc;border:1px solid #aaa" ></th>';
						}
                    }
                    ?>
				</tr>
				<tr>
					<th>&nbsp;</th>
					<th>LABA BERSIH</th>
					<?php
                    foreach($header as $s => $vs)
                    {
						if($s<5)
						{

							echo '<th style="text-align:right"></th>';
							echo '<th style="text-align:right"></th>';
						}
						elseif($s==5)
						{
							$labarugid=array_sum($labarugi_d[$s]);
							$labarugik=array_sum($labarugi_k[$s]);
							echo '<th style="text-align:right;background:#ccc;border:1px solid #aaa">'.number_format($labarugid,0,',','.').'</th>';
							echo '<th style="text-align:right;background:#ccc;border:1px solid #aaa">'.number_format($labarugik,0,',','.').'</th>';

							if(($labarugid-$labarugik)>=0)
							{
								echo '<input type="hidden" id="labarugi_kredit" value="'.number_format((abs($labarugid-$labarugik)),0,',','.').'">';
								echo '<input type="hidden" id="labarugi_debit" value="'.number_format(0,0,',','.').'">';
							}
							else
							{
								echo '<input type="hidden" id="labarugi_kredit" value="'.number_format(0,0,',','.').'">';
								echo '<input type="hidden" id="labarugi_debit" value="'.number_format(abs($labarugid-$labarugik),0,',','.').'">';
							}
						}
						elseif($s==6)
						{
							$labarugid=0;
							$labarugik=0;
							echo '<th style="text-align:right;background:#ccc;border:1px solid #aaa">'.number_format($labarugid,0,',','.').'</th>';
							echo '<th style="text-align:right;background:#ccc;border:1px solid #aaa">'.number_format($labarugik,0,',','.').'</th>';
						}
                    }
                    ?>
				</tr>
				
				<tr>
					<th>&nbsp;</th>
					<th>&nbsp;</th>
					<?php
                    foreach($header as $s => $vs)
                    {
						if($s<=2)
						{
							$jlhd=array_sum($jumlah_debit[$s]);
							$jlhk=array_sum($jumlah_kredit[$s]);
							$selisih=$jlhd-$jlhk;
							echo '<th style="text-align:center" colspan="2">'.number_format($selisih,0,',','.').'</th>';
							
						}
						elseif($s==3 || $s==4)
						{
							$jlhd=array_sum($_total_d[$s]);
							$jlhk=array_sum($_total_k[$s]);
							$selisih=$jlhd-$jlhk;
							echo '<th style="text-align:center" colspan="2">'.number_format($selisih,0,',','.').'</th>';
							
						}
						else if($s==6)
						{
							$jlhd=array_sum($_total_d[$s]);
							$jlhk=array_sum($_total_k[$s]);
							$selisih=$jlhd-$jlhk;
							echo '<th style="text-align:center" colspan="2">'.number_format($selisih,0,',','.').'</th>';
							
						}
						else
						{
							echo '<th style="text-align:center" colspan="2"></th>';
						}
                    }
                    ?>
				</tr>
			<?php
			}
			foreach($saldo_penutup as $jns=>$v)
			{
				if($jns=='debit')
				{
					
					foreach($v as $idx=>$val)
					{
						$saldo=$val - ($saldo_penutup['kredit'][$idx]);
						// echo $idx.'-'.$saldo.'<br>';
						// echo '<pre>';
						// print_r($val);
						// echo '</pre>';
						$cek=$this->db->from('t_saldo_awal_neraca')->where('tahun_ajaran',$tahunajaran)->where('kode_akun_alt',$idx)->get()->result();
						if(count($cek)!=0)
						{
							$this->db->set('jumlah',$saldo);
							$this->db->set('bulan',7);
							$this->db->set('kode_akun_alt',$idx);
							$this->db->set('tahun',$th2);
							$this->db->set('updated_at',date('Y-m-d H:i:s'));
							$this->db->where('id',$cek[0]->id);
							$this->db->update('t_saldo_awal_neraca');
						}
						else
						{
							$insert['jumlah']=$saldo;
							$insert['bulan']=7;
							$insert['tahun']=$th2;
							$insert['tahun_ajaran']=$tahunajaran;
							$insert['kode_akun_alt']=$idx;
							$insert['created_at']=date('Y-m-d H:i:s');
							$insert['updated_at']=date('Y-m-d H:i:s');
							$this->db->insert('t_saldo_awal_neraca',$insert);
						}
					}
				}
			}
			?>
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
<script>
	$(document).ready(function(){
		var lb_d=$('#labarugi_debit').val();
		var lb_k=$('#labarugi_kredit').val();
		$('#div_total_d_5').text(lb_d);
		$('#div_total_k_5').text(lb_k);
	});
</script>