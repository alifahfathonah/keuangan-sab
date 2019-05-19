
<table id="tableBank" class="table table-striped table-bordered table-hover" style="width:99% !important;">
	<thead>
		<tr>
            <th rowspan="2">Sasaran Mutu</th>
      		<th rowspan="2" class="center">No</th>
			<th rowspan="2">Rencana Kegiatan</th>
			<th rowspan="2">PIC</th>
			<th colspan="12" class="text-center">Bulan</th>
			<th rowspan="2">Keterangan</th>
		</tr>
        <tr>
            <?php
            $bulan=bulantahunajaran($tahunajaran);
            foreach($bulan as $t => $vb)
            {
                foreach($vb as $k => $b)
                {
                    echo '<th class="text-center" style="width:60px;">'.getBulanSingkat($b).'<br>'.$t.'</th>';
                }
            }
            ?>
        </tr>
	</thead>

	<tbody>
	<?php
    $no=1;
    $jumlah=array();
	foreach ($sasaranmutu as $kk => $vv) 
	{
        // $no=1;
        $drab=array();
        if(isset($rab[$vv->id]))
        {

            $drab=$rab[$vv->id];
        }

        if(count($drab)!=0)
        {
            list($kegiatan_id,$nm_kegiatan)=explode('::',$drab[0]->kegiatan);
    ?>
        <tr>
			<td style="text-align:left;width:130px;" rowspan="<?=count($rab[$vv->id])?>"><?=$vv->sasaran_mutu?></td>
            <td style="text-align:center"><?=$no?></td>
            <td style="text-align:left"><?=$kegiatan[$kegiatan_id]->kegiatan?></td>
            <td style="text-align:left"><?=$drab[0]->pic_id  !=0 ? $drab[0]->pic : '-'?></td>
            <?php
            foreach($bulan as $t => $vb)
            {
                foreach($vb as $k => $b)
                {
                    echo '<td class="text-right">'.(($b==$drab[0]->bulan && $t==$drab[0]->tahun )? number_format($drab[0]->anggaran,0,',','.') : '-').'</td>';
                    $jlh=(($b==$drab[0]->bulan && $t==$drab[0]->tahun )? $drab[0]->anggaran : 0);
                    $jumlah[$b][$no]=$jlh;
                }
            }
            ?>
            <td style="text-align:left"><?=$drab[0]->keterangan?></td>
        </tr>
        <?php
        $no++;
        foreach($drab as $dr => $vd)
        {
            if($dr>0)
            {
                list($kegiatan_id,$nm_kegiatan)=explode('::',$vd->kegiatan);
                echo '<tr>';
        ?>
                <td style="text-align:center"><?=$no?></td>
                <td style="text-align:left"><?=$kegiatan[$kegiatan_id]->kegiatan?></td>
                <td style="text-align:left"><?=$vd->pic_id !=0 ? $vd->pic : '-'?></td>

        <?php
                
                foreach($bulan as $t => $vb)
                {
                    foreach($vb as $k => $b)
                    {
                        echo '<td class="text-right">'.(($b==$vd->bulan && $t==$vd->tahun )? number_format($vd->anggaran,0,',','.') : '-').'</td>';

                        $jlh=(($b==$vd->bulan && $t==$vd->tahun )? $vd->anggaran : 0);
                        $jumlah[$b][$no]=$jlh;
                    }
                }

                echo '<td style="text-align:left">'.$vd->keterangan.'</td>';
                $no++;
                echo '</tr>';
            }
        }
        ?>
        
    <?php
        }
	}
	?>
	</tbody>
    <thead>
		<tr>
            <th colspan="4" class="text-right">Total</th>
            <?php
            $bulan=bulantahunajaran($tahunajaran);
            foreach($bulan as $t => $vb)
            {
                foreach($vb as $k => $b)
                {
                    $jlh=(isset($jumlah[$b]) ? array_sum($jumlah[$b]) : 0);
                    echo '<th class="text-right">'.number_format($jlh,0,',','.').'</th>';
                }
            }
            ?>
            <th></th>
        </tr>
	</thead>
</table>
<script type="text/javascript">
	
</script>
<style>
    th,td
    {
        font-size:10px !important;
    }
</style>