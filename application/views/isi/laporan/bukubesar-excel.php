    <?php
        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=BukuBesar_".($val != '-1' ? $val : '')."_".getBulan($bulan)."_".$tahun.".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        $saldodebit=$saldokredit=0;
        foreach($trans as $k => $v)
        {
            foreach($v as $ik => $iv)
            {
                if($iv->status=='keluar')
                {
                    $dbt=0;
                    $krd=$iv->jumlah;
                }
                else
                {
                    $krd=0;
                    $dbt=$iv->jumlah;
                }
                $saldodebit+=$dbt;
                $saldokredit+=$krd;
            }
        }
    ?>
        <table id="simple-table" class="table table-striped table-bordered table-hover" border="0" cellpadding="2" cellspacing="2" width="100%">
            <thead>
				<tr>
					<th style="text-align:left;width:10%">Kode Akun</th>
					<th style="text-align:left;width:40%">: <?=($val != '-1' ? $val : '')?></th>
					<th style="text-align:left;"></th>
					<th style="text-align:left;"></th>
					<th style="text-align:left;width:30%">Bulan</th>
					<th style="text-align:left;">:</th>
					<th style="text-align:left;width:20%"><?=($bulan!='' ? getBulan($bulan) : '')?></th>
				</tr>
				<tr>
					<th style="text-align:left;width:10%">Nama Akun</th>
					<th style="text-align:left;width:40%">: <?=(isset($takun[$val]) ? $takun[$val]->nama_akun : '')?></th>
                    <th style="text-align:left;"></th>
					<th style="text-align:left;"></th>
					<th style="text-align:left;width:30%">Tahun</th>
					<th style="text-align:left;">:</th>
					<th style="text-align:left;width:20%"><?=$tahun?></th>
				</tr>
				<tr>
					<th style="text-align:center;width:10%">&nbsp;</th>
					<th style="text-align:center;width:40%">&nbsp; </th>
                    <th style="text-align:left;"></th>
					<th style="text-align:left;"></th>
					<th style="text-align:left;width:30%">Saldo Akhir Debit</th>
					<th style="text-align:left;">:</th>
					<th style="text-align:left;width:20%"><?=($saldodebit)?></th>
				</tr>
				<tr>
					<th style="text-align:center;width:10%">&nbsp;</th>
					<th style="text-align:center;width:40%">&nbsp; </th>
                    <th style="text-align:left;"></th>
					<th style="text-align:left;"></th>
					<th style="text-align:left;width:30%">Saldo Akhir Kredit</th>
					<th style="text-align:left;">:</th>
					<th style="text-align:left;width:20%"><?=($saldokredit)?></th>
				</tr>
			</thead>
        </table>
        <table id="simple-table" class="table table-striped table-bordered table-hover" border="1" cellpadding="2" cellspacing="2" width="100%">
			<thead>
				<tr>
					<th style="text-align:center">No</th>
					<th style="text-align:center">Tanggal</th>
					<th style="text-align:center">Keterangan</th>
					<th style="text-align:center">No Ref</th>
					<th style="text-align:center">Debet</th>
					<th style="text-align:center">Kredit</th>
					<th style="text-align:center">Saldo</th>
				</tr>
			</thead>
			<tbody>
            <?php
                $no=1;
                $sal='';
                if($val!=-1)
                {

                    $saldo=0;
                    foreach($trans as $k => $v)
                    {
                        foreach($v as $ik => $iv)
                        {
                            $nis=str_replace('.','_',$iv->nis);
                            if(isset($sis[$nis]))
                            {
                                $s=$sis[$nis];
                                if(isset($tpenerimaan[$iv->id_jns]))
                                {
                                    $jn=$tpenerimaan[$iv->id_jns];
                                    if(isset($iv->bulan_tagihan))
                                        $jns=$jn->jenis.' '.getBulanSingkat($iv->bulan_tagihan).' '.$iv->tahun_tagihan;
                                    else
                                        $jns=$jn->jenis;
                                }
                                else
                                    $jns='';
                                
                                $nm=ucwords(strtolower($s->nama_murid));
                                $ketsis=$nm.' - '.$jns;
                            }
                            else
                            {
                                $ketsis=$iv->keterangan;
                            }
                            if(is_null($iv->keterangan))
                            {
                                $ket=$ketsis;
                            }
                            else
                            {
                                $ket=trim($iv->ket);
                            }

                            if($iv->status=='keluar')
                            {
                                //B101-61100-Gaji Pokok/Honor/Pesangon/Apresiasi||uang lembur satpam 1 jan
                                list($ket_ak,$ket_tr)=explode('||',$iv->keterangan);
                                $ket=ucwords(strtolower($ket_tr));
                                $debit=0;
                                $kredit=$iv->jumlah;
                            }
                            else
                            {
                                $ket=$ket;
                                $debit=$iv->jumlah;
                                $kredit=0;
                            }
                            $saldo+=($debit-$kredit);
                            if($saldo<0)
                                $sal = '<i>('.(abs($saldo)).')</i>';
                            else
                                $sal = ($saldo);
                            echo '<tr>';
                            echo '<td class="text-center" style="text-align:center">'.$no.'</td>';
                            echo '<td class="text-center" style="text-align:center">'.tgl_indo2($k).'</td>';
                            echo '<td class="text-left" style="text-align:left">'.($ket).'</td>';
                            echo '<td class="text-left"></td>';
                            echo '<td class="text-right" style="text-align:right">'.($debit).'</td>';
                            echo '<td class="text-right" style="text-align:right">'.($kredit).'</td>';
                            echo '<td class="text-right" style="text-align:right">'.$sal.'</td>';
                            echo '</tr>';
                            $no++;
                        }
                    }
                }
                else
                {
                    echo '<tr><td colspan="7" class="text-center"><i>Silahkan Pilih Kode Akun</i></td></tr>';
                }
                ?>
                <tr>
                    <th colspan="4" class="text-right" style="text-align:right">SALDO AKHIR</th>
                    <th class="text-right" style="text-align:right"><?=($saldodebit)?></th>
                    <th class="text-right" style="text-align:right"><?=($saldokredit)?></th>
                    <th class="text-right" style="text-align:right"><?=$sal?></th>
                </tr>
                </tbody>
        </table>