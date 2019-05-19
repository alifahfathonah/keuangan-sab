<h5>
    <div class="row">
        <div class="col-xs-2">Departemen/Program</div>
        <div class="col-xs-5">: <?=($program_id==-1 ? '-Silahkan Pilih Program Terlebih Dahulu-' : $program[0]->program)?></div>
    </div>
    <div class="row">
        <div class="col-xs-2">Tahun Ajaran</div>
        <div class="col-xs-5">: <?=$tahunajaran?></div>
    </div>
</h5>
<table id="tableBank" class="table table-striped table-bordered table-hover" style="width:99% !important;">
	<thead>
		<tr>
            <th rowspan="2">Sasaran Mutu</th>
      		<th rowspan="2" class="center">No</th>
			<th rowspan="2">Rencana Kegiatan</th>
			<th rowspan="2">PIC</th>
			<th class="text-center" colspan="3"><?=getBulan($bulan)?><br><?=$tahun?></th>
			<th rowspan="2">Keterangan</th>
		</tr>
        <tr>
            <th class="text-center">RAB</th>
            <th class="text-center">Realisasi</th>
            <th class="text-center">Selisih</th>
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
            list($kegiatan_id,$nm_kegiatan)=explode('::',$drab[0]->kegiatan_id);
    ?>
        <tr>
			<td style="text-align:left;width:130px;" rowspan="<?=count($rab[$vv->id])?>"><?=$vv->sasaran_mutu?></td>
            <td style="text-align:center"><?=$no?></td>
            <td style="text-align:left"><?=$kegiatan[$kegiatan_id]->kegiatan?></td>
            <td style="text-align:left"><?=$drab[0]->pic_id  !=0 ? $drab[0]->pic : '-'?></td>
            <td style="text-align:right;width:100px;">0</td>
            <td style="text-align:right;width:100px;">0</td>
            <td style="text-align:right;width:100px;">0</td>
            <td style="text-align:left"><?=$drab[0]->keterangan?></td>
        </tr>
        <?php
        $no++;
        foreach($drab as $dr => $vd)
        {
            if($dr>0)
            {
                list($kegiatan_id,$nm_kegiatan)=explode('::',$vd->kegiatan_id);
                echo '<tr>';
        ?>
                <td style="text-align:center"><?=$no?></td>
                <td style="text-align:left"><?=$kegiatan[$kegiatan_id]->kegiatan?></td>
                <td style="text-align:left"><?=$vd->pic_id !=0 ? $vd->pic : '-'?></td>
                <td class="text-right">0</td>    
                <td class="text-right">0</td>    
                <td class="text-right">0</td>    
        <?php
                
                
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
            <th class="text-right">0</th>
            <th class="text-right">0</th>
            <th class="text-right">0</th>
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