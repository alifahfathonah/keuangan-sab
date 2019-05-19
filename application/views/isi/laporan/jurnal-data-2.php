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
		<table id="simple-table" class="table table-bordered table-hover">
			<thead>

				<tr>
					<th>No</th>
					<th>Tanggal</th>
					<th>Keterangan</th>
					<th>Ref</th>
					<th>Kode Akun</th>
					<th>Debet</th>
					<th>Kredit</th>
					<!-- <th>Saldo</th> -->
				</tr>
			</thead>
			<tbody>
				
			<?php
			$no=1;
			// echo $date;
            $saldo=$saldodebet=$saldokredit=0;
            $no=1;
            foreach($trans as $k => $v)
            {
            ?>
            <tr>
                <td class="text-center" rowspan="<?=count($v)?>" style="vertical-align:top;"><?=($no++)?></td>
                <td class="text-center" rowspan="<?=count($v)?>" style="vertical-align:top;"><?=(tgl_indo2($v[0]->tanggal))?></td>
                <td class="text-left"><?=($v[0]->keterangan)?></td>
                <td class="text-center"></td>
                <td class="text-center"><?=$v[0]->kode_akun?></td>
                <td class="text-right"><?=number_format($v[0]->debit,0,',','.')?></td>
                <td class="text-right"><?=number_format($v[0]->kredit,0,',','.')?></td>
            </tr>
            
            <?php
                $saldodebet+=$v[0]->debit;
                $saldokredit+=$v[0]->kredit;
                foreach($v as $kk => $vv)
                {
                    if($kk>0)
                    {
            ?>
                        <tr>
                            <td class="text-left"><?=($vv->keterangan)?></td>
                            <td class="text-center"></td>
                            <td class="text-center"><?=$vv->kode_akun?></td>
                            <td class="text-right"><?=number_format($vv->debit,0,',','.')?></td>
                            <td class="text-right"><?=number_format($vv->kredit,0,',','.')?></td>
                        </tr>        
            <?php
                        $saldodebet+=$vv->debit;
                        $saldokredit+=$vv->kredit;
                    }
                }
                
            }
            ?>
            </tbody>
			<thead>
				<tr>
					<th colspan="5">&nbsp;</th>
					<th style="text-align: right"><?=number_format($saldodebet,0,',','.')?></th>
					<th style="text-align: right"><?=number_format($saldokredit,0,',','.')?></th>
					<!-- <th style="text-align: right"><?=number_format(($saldodebet-$saldokredit),0,',','.')?></th> -->
				</tr>
				
			</thead>
		</table>
	</div>
</div>