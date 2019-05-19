
<div class="row">
	<div class="col-xs-12">

		<form class="form-horizontal" role="form" id="datasiswa">
			<div class="row">
				<div class="col-xs-9">
					<div class="form-group" style="margin-bottom: 3px;">
						<label class="col-sm-2 control-label no-padding-top" for="form-field-1" style="text-align:right"> Nama Siswa </label>
						<div class="col-sm-10" style="padding-top:2px;font-weight: bold;">
						:&nbsp;&nbsp;&nbsp;<?=$nama?>
						</div>
					</div>
					<div class="form-group" style="margin-bottom: 3px;">
						<label class="col-sm-2 control-label no-padding-top" for="form-field-1" style="text-align:right"> Kelas </label>
						<div class="col-sm-10" style="padding-top:2px;font-weight: bold;">
						:&nbsp;&nbsp;&nbsp;<?=$kelas?>
						</div>
					</div>
					<div class="form-group" style="margin-bottom: 3px;">
						<label class="col-sm-2 control-label no-padding-top" for="form-field-1" style="text-align:right"> Tahun Ajaran </label>
						<div class="col-sm-10" style="padding-top:2px;font-weight: bold;">
						:&nbsp;&nbsp;&nbsp;<?=$tahun_ajaran?>
						</div>
					</div>
					<div class="form-group" style="margin-bottom: 3px;">
						<label class="col-sm-2 control-label no-padding-top" for="form-field-1" style="text-align:right"> Data Pembayaran</label>
						<div class="col-sm-10" style="padding-top:2px;font-weight: bold;">
						:&nbsp;
						</div>
					</div>
				</div>
				<div class="col-xs-3">
					<a href="javascript:reload()" class="btn btn-app btn-success pull-right">
						<i class="ace-icon fa fa-refresh bigger-230"></i>
						Reload
					</a>
				</div>
			</div>
			
			<div class="form-group" style="margin-bottom: 3px;">
				<div class="col-sm-12" style="padding-top:2px;">
					<table id="simple-table" class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th class="center">No</th>
								<th class="center">Jenis Tagihan</th>
								<th class="center">Keterangan</th>
								<th class="center">Jumlah Tagihan</th>
								<th class="center">Pembayaran</th>
								<th class="center">Sisa Tagihan</th>
								
							</tr>
						</thead>
						<tbody>
						<?php
						$no=1;
						
						$jumlah=0;
						// echo '<pre>';
						// print_r($trans);
						// echo '</pre>';
						$jlh=$byr=$sisa=0;
						foreach ($jenis_p as $kv => $v)
						{
							$t='';
							if($v[0]->jenis=='Program Pembelajaran')
							{
								$jenis='DU/Investasi';
								$inv=1;
							}
							else
							{
								$jenis=$v[0]->jenis;
								$inv=0;
							}
							
							$ket=$t_jlh=$t_tgh=$t_byr=$t_sisa='';
							
							foreach($v as $idx => $vl)
							{
								if($inv==1)
								{
									$ket.='Tahun '.$vl->tahun.'<hr>';
									$bln=7;
									$thn=trim(strtok($tahun_ajaran,'/'));
								}
								else
								{
									$ket.=getBulanSingkat($vl->bulan).' '.$vl->tahun.'<hr>';
									$bln=$vl->bulan;
									$thn=$vl->tahun;
								}
								$t_jlh.=number_format($vl->wajib_bayar,0,',','.').'<hr>';
								$t_sisa.=number_format($vl->sisa_bayar,0,',','.').'<hr>';
								$jlh+=$vl->wajib_bayar;
								$sisa+=$vl->sisa_bayar;
								if(isset($trans[$v[0]->id_jenis_penerimaan][$tahun_ajaran][$bln][$thn]))
								{
									$tr=$trans[$v[0]->id_jenis_penerimaan][$tahun_ajaran][$bln][$thn];
									foreach($tr as $itr => $vtr)
									{
										if($vtr->jumlah!=0)
										{
											$t_byr.='Tgl : '.date('d-m-Y',strtotime($vtr->tanggal_transaksi)).' [ <span style="color:blue">Rp. '.number_format($vtr->jumlah,0, ',','.').'</span>]<hr>';
											$byr+=$vtr->jumlah;
										}
										else
										{
											$t_byr.='';
											$byr+=0;
										}
									}
								}
								else
								{
									$byr+=0;
									$t_byr.='<br>';
								}

							}

							echo '<tr>';
							echo '<td>'.$no.'</td>';
							echo '<td>'.$jenis.'</td>';
							echo '<td>'.$ket.'</td>';
							echo '<td style="text-align:right">'.$t_jlh.'</td>';
							echo '<td style="text-align:right">'.$t_byr.'</td>';
							echo '<td style="text-align:right">'.$t_sisa.'</td>';
							
							echo '</tr>';
							$no++;
						}
						//$jumlah+=1000000;
						?>
							<!-- <tr>
								<td><?=$no?></td>
								<td>Tunggakan Tahun Sebelunya</td>
								<td style="text-align:right">1.000.000</td>
								<td></td>
								<td  style="text-align:right"><?=$jumlah?></td>
								<td></td>
							</tr> -->
						</tbody>
						<thead>
							<tr>
								<th class="center" ></th>
								<th></th>
								<th style="text-align:right"></th>
								<th style="text-align:right"><b><?=number_format($jlh,0,',','.')?></b></th>
								<th style="text-align:right"><b><?=number_format($byr,0,',','.')?></b></th>
								<th style="text-align:right"><b><?=number_format($sisa,0,',','.')?></b></th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</form>

	</div><!-- /.col -->
</div>
<style>
hr{

	margin-top: 5px !important;
    margin-bottom: 5px !important;
    border: 0;
    border-top: 1px solid #eee;
}
</style>
