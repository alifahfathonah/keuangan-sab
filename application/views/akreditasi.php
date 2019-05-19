
<link rel="stylesheet" href="<?=base_url()?>assets/css/bootstrap.min.css" />
<link rel="stylesheet" href="<?=base_url()?>assets/fonts/fonts.googleapis.com.css" />
<?php
    header("Content-Disposition: attachment; filename=Tagihan_".$tahun_ajaran1.".xls");
    header("Pragma: no-cache");
    header("Expires: 0");
?>
<?php
foreach($kelas_ta[$tahun_ajaran1] as $k=>$vv)
{
    foreach($vv as $kk=>$v)
    {
        if(isset($siswa[$tahun_ajaran1][$v->id_batch]))
        {
?>
    <legend><h2><?=$levelkelas[$k]->nama_level?> - <?=$v->nama_batch?> -Tahun Ajaran <?=$tahun_ajaran1?></h2></legend>

    <?php
    foreach($range_bulan1 as $idb => $vdb)
    {    
    ?>

    <h4>Tagihan Bulan : <?=getBulan($vdb)?> <?=$tahun_awal?></h4>
    <table class="table table-bordered table-striped" border="1" cellpadding="2" cellspacing="2" width="100%">
        <thead>
            <tr>
                <th style="width:20px;font-size:12px;" rowspan="2">No</th>
                <th style="width:80px;font-size:12px;" rowspan="2">NIS</th>
                <th style="width:150px;font-size:12px;" rowspan="2">Nama</th>
                <th colspan="<?=count($jns_lvl)?>" style="font-size:12px;text-align:center">Jenis Tagihan</th>
                <th rowspan="2" style="width:80px;font-size:12px;">Total</th>
            </tr>
            <tr>
            <?php
                foreach($jns_lvl as $kl=>$vl)
                {
                ?>
                    <th style="width:80px;font-size:12px;text-align:center"><?=$vl?></th>
                <?php
                }
            ?>
            </tr>
        </thead>
        <tbody>
        <?php
        $no=1;
            $total=0;
            $jumlah=array();
            foreach($siswa[$tahun_ajaran1][$v->id_batch] as $nis=>$val)
            {
                $nis_siswa=str_replace('.','_',$val->nis);
            ?>
                <tr>
                    <td style="text-align:center;width:20px;font-size:12px;"><?=$no?></td>
                    <td style="text-align:center;width:80px;font-size:12px;"><?=$nis?></td>
                    <td style="text-align:left;width:150px;font-size:12px;"><?=$val->nama_murid?></td>
                    <?php
                        $subtotal=0;
                        
                        foreach($jns_lvl as $kl=>$vl)
                        {
                            $jenis=strtolower(str_replace(' ','_',$vl));
                            if(isset($tagihan[$nis_siswa][$tahun_ajaran1][$tahun_awal][$vdb][$jenis]))
                            {
                                $d=$tagihan[$nis_siswa][$tahun_ajaran1][$tahun_awal][$vdb][$jenis];
                                $jlh=$d->wajib_bayar;
                            }
                            else
                            {
                                $jlh=0;
                            }

                            if($jenis=='du/investasi')
                            {
                                $jtag=0;
                                if(isset($tagihan[$nis_siswa][$tahun_ajaran1][$tahun_inves][7]))
                                {

                                    foreach($tagihan[$nis_siswa][$tahun_ajaran1][$tahun_inves][7] as $ktag=>$vtag)
                                    {
                                        $jtag+=$vtag->wajib_bayar;
                                    }
                                    $jlh=$jtag;
                                }
                                else
                                    $jlh=0;
                            }

                            $jumlah[$jenis][]=$jlh;
                            $subtotal+=$jlh;

                        ?>
                            <td style="width:80px;font-size:12px;text-align:right"><?=($jlh)?></td>
                        <?php
                        }
                        ?>
                    <td style="width:80px;font-size:12px;text-align:right"><?=($subtotal)?></td>
                </tr>
            <?php
                $total+=$subtotal;
                $no++;
            }
        
        ?>
        <tr>
            <th colspan="3" style="text-align:right;font-size:12px;">Jumlah</th>
            <?php
                foreach($jns_lvl as $kl=>$vl)
                {
                    $jenis=strtolower(str_replace(' ','_',$vl));
                ?>
                    <th style="width:80px;font-size:12px;text-align:right"><?=(array_sum($jumlah[$jenis]))?></th>
                <?php
                }
            ?>
            <th style="width:80px;font-size:12px;text-align:right"><?=($total)?></th>
        </tr>
        </tbody>
    </table>
    <?php
    }
    ?>
    <hr>
<?php
        }
    }
}
?>