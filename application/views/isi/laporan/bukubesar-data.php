<div class="row">
	<div class="col-xs-6">
		<!-- <button class="btn btn-xs btn-success" onclick="bukubesarnonsekolah('<?=$jenis?>','<?=$date?>')"><i class="fa fa-file"></i> bukubesar Non Sekolah</button>
		<button class="btn btn-xs btn-primary" onclick="bukubesarsekolah('<?=$jenis?>','<?=$date?>')"><i class="fa fa-file"></i> bukubesar Sekolah</button> -->
	</div>
	<div class="col-xs-6">
		<div class="pull-right" style="margin-bottom:5px;">
			<button class="btn btn-xs btn-success" onclick="downloadbukubesar('<?=$jenis?>')"><i class="fa fa-download"></i> Unduh Data Buku Besar</button>
			<button class="btn btn-xs btn-primary" onclick="reloadbukubesar('<?=$jenis?>','<?=$date?>')"><i class="fa fa-refresh"></i> Refresh</button>
		</div>
	</div>
    <?php
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
	<div class="col-xs-12">
        <div class="row">
            <div class="col-xs-1">Kode Akun</div>
            <div class="col-xs-5">: <?=($val != '-1' ? $val : '')?></div>
            <div class="col-xs-2">&nbsp;</div>
            <div class="col-xs-2">Bulan</div>
            <div class="col-xs-2">: <?=($bulan!='' ? getBulan($bulan) : '')?></div>
        </div>
        <div class="row">
            <div class="col-xs-1">Nama Akun</div>
            <div class="col-xs-5">: <?=(isset($takun[$val]) ? $takun[$val]->nama_akun : '')?></div>
            <div class="col-xs-2">&nbsp;</div>
            <div class="col-xs-2">Tahun</div>
            <div class="col-xs-2">: <?=$tahun?></div>
        </div>
        <div class="row" style="font-weight:bold;">
            <div class="col-xs-8">&nbsp;</div>
            <div class="col-xs-2" style="font-weight:bold !important;">Saldo Akhir Debit</div>
            <div class="col-xs-2" style="font-weight:bold !important;">: <?=number_format($saldodebit,0,',','.')?></div>
        </div>
        <div class="row" style="font-weight:bold;">
            <div class="col-xs-8">&nbsp;</div>
            <div class="col-xs-2" style="font-weight:bold !important;">Saldo Akhir Kredit</div>
            <div class="col-xs-2" style="font-weight:bold !important;">: <?=number_format($saldokredit,0,',','.')?></div>
        </div>
		<table id="simple-table" class="table table-striped table-bordered table-hover" style="width:100%">
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
                            $sal = '<i>('.number_format(abs($saldo),0,',','.').')</i>';
                        else
                            $sal = number_format($saldo,0,',','.');
                        echo '<tr>';
                        echo '<td class="text-center">'.$no.'</td>';
                        echo '<td class="text-center">'.tgl_indo2($k).'</td>';
                        echo '<td class="text-left">'.($ket).'</td>';
                        echo '<td class="text-left"></td>';
                        echo '<td class="text-right">'.number_format($debit,0,',','.').'</td>';
                        echo '<td class="text-right">'.number_format($kredit,0,',','.').'</td>';
                        echo '<td class="text-right">'.$sal.'</td>';
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
                <th colspan="4" class="text-right">SALDO AKHIR</th>
                <th class="text-right"><?=number_format($saldodebit,0,',','.')?></th>
                <th class="text-right"><?=number_format($saldokredit,0,',','.')?></th>
                <th class="text-right"><?=$sal?></th>
            </tr>
            </tbody>
        </table>
    </div>
</div>