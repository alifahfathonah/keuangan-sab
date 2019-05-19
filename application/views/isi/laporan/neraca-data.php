<div class="row">
	<div class="col-xs-6">
	</div>
	<div class="col-xs-6">
		<div class="pull-right" style="margin-bottom:5px;">
			<button class="btn btn-xs btn-success" onclick="downloadneraca()"><i class="fa fa-download"></i> Unduh Laporan Aktivitas</button>
			<button class="btn btn-xs btn-primary" onclick="reloadneraca()"><i class="fa fa-refresh"></i> Refresh</button>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xs-12">
        <h2>Laporan Posisi Keuangan</h2>
        <table id="simple-table" class="table table-bordered table-hover" style="width:50%">
            <tbody>
                <tr>
                    <th colspan="3" class="text-left">AKTIVA</th>
                </tr>
                <?php
                $jlh=0;
                foreach($t_neraca_saldo['aktiva'] as $k=>$v)
                {
                    if(isset($neraca_saldo[$v->kode_akun_alt]))
                    {
                        // echo '<pre>';
                        // print_r($neraca_saldo[$v->kode_akun_alt]);
                        // echo '</pre>';
                        // $saldo=0;
                        $saldo=$neraca_saldo[$v->kode_akun_alt][$th2][7];
                    }
                    else
                        $saldo=0;
                    echo '<tr>';
                    echo '<td style="padding-left:30px;">'.$v->nama_akun.'</td>';
                    echo '<td class="text-right">'.number_format($saldo,0,',','.').'</td>';
                    echo '<td></td>';
                    echo '</tr>';
                    $jlh+=$saldo;
                }
                ?>
                <tr>
                    <th class="text-left">TOTAL AKTIVA</th>
                    <th class="text-left"></th>
                    <th class="text-right"><?=number_format($jlh,0,',','.')?></th>
                </tr>
                <tr>
                    <th colspan="3" class="text-left" style="background-color:#eee;">&nbsp;</th>
                </tr>
                <tr>
                    <th colspan="2" class="text-left">KEWAJIBAN & AKTIVA BERSIH</th>
                    <th class="text-right"></th>
                </tr>
                <?php
                echo '</tr>';
                $utang=abs($neraca_saldo['D100'][$th2][7]);
                $kewajiban=abs($neraca_saldo['-2'][$th2][7]);
                $total=($utang+$kewajiban);
                echo '<tr>';
                    echo '<td style="padding-left:30px;">Kewajiban</td>';
                    echo '<td></td>';
                    echo '<td></td>';
                echo '</tr>';
                echo '<tr>';
                    echo '<td style="padding-left:30px;">Utang per 30 Juni '.$th1.'</td>';
                    echo '<td class="text-right">'.number_format($utang,0,',','.').'</td>';
                    echo '<td></td>';
                echo '</tr>';
                
                echo '<tr>';
                    echo '<td style="padding-left:30px;font-weight:bold">Total Kewajiban</td>';
                    echo '<td></td>';
                    echo '<td class="text-right">'.number_format($utang,0,',','.').'</td>';
                
                ?>
                <tr>
                    <th colspan="3" class="text-left">&nbsp;</th>
                </tr>
                <?php
                echo '<tr>';
                    echo '<td style="padding-left:30px;">Aktiva Bersih</td>';
                    echo '<td></td>';
                    echo '<td></td>';
                echo '</tr>';
                echo '<tr>';
                    echo '<td style="padding-left:30px;">Aktiva Bersih per 30 Juni '.$th1.'</td>';
                    echo '<td class="text-right">'.number_format($kewajiban,0,',','.').'</td>';
                    echo '<td></td>';
                echo '</tr>';
                
                echo '<tr>';
                    echo '<td style="padding-left:30px;font-weight:bold">Total Aktiva Bersih</td>';
                    echo '<td></td>';
                    echo '<td class="text-right">'.number_format($kewajiban,0,',','.').'</td>';
                echo '</tr>';
                ?>
                <tr>
                    <th colspan="3" class="text-left" style="background-color:#eee;">&nbsp;</th>
                </tr>
                <tr>
                    <th colspan="2" class="text-left">TOTAL KEWAJIBAN & AKTIVA BERSIH</th>
                    <th class="text-right"><?=number_format($total,0,',','.')?></th>
                </tr>
            </tbody>
        </table>
    </div>
</div>