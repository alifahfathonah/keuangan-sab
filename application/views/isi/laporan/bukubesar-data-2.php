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
            // foreach($v as $ik => $iv)
            // {
            //     if($iv->status=='keluar')
            //     {
            //         $dbt=0;
            //         $krd=$iv->jumlah;
            //     }
            //     else
            //     {
            //         $krd=0;
            //         $dbt=$iv->jumlah;
            //     }
            // foreach($v as $kv=>$vv)
            // {
                $saldodebit+=$v->debit;
                $saldokredit+=$v->kredit;
            // }
            // }
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
            $saldo=0;
            if($val!=-1)
            {
                foreach($trans as $k => $v)
                {
                    
                    // $v=$vv[0];
                    $debit=$v->debit;
                    $kredit=$v->kredit;
                    $saldo= ($saldo + ($debit-$kredit));
                    ?>
                        <tr>
                            <td style="text-align:center"><?=($no++)?></td>
                            <td style="text-align:center"><?=tgl_indo2($v->tanggal)?></td>
                            <td style="text-align:left"><?=$v->keterangan?></td>
                            <td style="text-align:center"></td>
                            <td style="text-align:right"><?=number_format($debit,0,',','.')?></td>
                            <td style="text-align:right"><?=number_format($kredit,0,',','.')?></td>
                            <td style="text-align:right"><?=number_format($saldo,0,',','.')?></td>
                        </tr>
            <?php
                    
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
                <th class="text-right"><?=number_format($saldo,0,',','.')?></th>
            </tr>
            </tbody>
        </table>
    </div>
</div>