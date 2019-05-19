<?php
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=kelas_".$batch->nama_batch."_".getBulan($bulan)."_".$tahun.".xls");
    header("Pragma: no-cache");
    header("Expires: 0");

    $tahun_ajaran=$batch->tahun_ajaran;
    
    // if($batch->kategori=='sd')
	// {
    //     $get_id_jenis=$this->db->from('t_jenis_penerimaan')
    //             ->like('level',$batch->kategori)
    //             ->where('jenis','Program Pembelajaran')
    //             ->order_by('id','desc')->get()->result();
	// }
	// elseif($batch->kategori=='pg')
	// {
    //     $get_id_jenis=$this->db->from('t_jenis_penerimaan')
    //             ->like('level','pg_')
    //             ->where('jenis','Program Pembelajaran')
    //             ->order_by('id','desc')->get()->result();
	// }
	// else
	// {
    //     $get_id_jenis=$this->db->from('t_jenis_penerimaan')
    //             ->where('level',$batch->kategori)
    //             ->where('jenis','Program Pembelajaran')
    //             ->order_by('id','desc')->get()->result();
	// }
?>
Kelas : <?=$batch->nama_batch?>
<table border="1" cellpadding="2" cellspacing="2" width="100%">
    <tr>
        <th rowspan="2">No</th>
        <th rowspan="2">Nama Lengkap</th>
        <th rowspan="2">VA</th>
        <?php
        if(count($inves2)!=0)
		{
        ?>
            <th colspan="<?=(count($jenis)+2)?>">Bulan</th>
        <?php
        }
        else
        {
            echo '<th colspan="'.(count($jenis)).'">Bulan</th>';
        }
        ?>
        
        <th rowspan="2">Total</th>
    </tr>
    <tr>
    <?php
        foreach($jenis as $k => $v)
        {
            if($v!='investasi')
            {
                echo '<th>'.ucwords($v).'</th>';
            }
        }
        echo '<th style="width:100px !important;">DU<br>'.$tahun_ajaran.'</th>';
        if(count($inves2)!=0)
		{
            echo '<th style="width:100px !important;">DU<br>'.$tahun_ajaran_baru.'</th>';
		}
        echo '<th style="width:100px !important;">Investasi</th>';
    ?>
    </tr>
    
    <?php
        $no=1;
        // echo '<pre>';
        // print_r($data[]);
        // echo '</pre>';
        foreach($data as $kd => $vd)
        {
            $total=0;
            echo '<tr>';
            echo '<td align="center">'.$no.'</td>';
            echo '<td>'.ucwords(strtolower($vd->nama_murid)).'</td>';
            echo '<td align="center">'.(($vd->no_virtual_account=='NULL') ? '' : $vd->no_virtual_account).'</td>';
            foreach($jenis as $k => $v)
            {
                if($v=='investasi')
                {
                    $thn=trim(strtok($tahun_ajaran,'/'));
                    if(isset($tagihan[$vd->nis][$tahun_ajaran][$thn][7]['program_pembelajaran']))
                    {
                        $tag=$tagihan[$vd->nis][$tahun_ajaran][$thn][7]['program_pembelajaran'];
                        echo '<td align="right">'.$tag->sisa_bayar.'</td>';
                        $total+=$tag->sisa_bayar;
                    }
                    else
                    {
                        echo '<td align="right">0</td>';
                        $total+=0;
                    }
                }
                else
                {
                    if(isset($tagihan[$vd->nis][$tahun_ajaran][$tahun][$bulan][strtolower(str_replace(' ','_',$v))]))
                    {
                        $tag=$tagihan[$vd->nis][$tahun_ajaran][$tahun][$bulan][strtolower(str_replace(' ','_',$v))];
                        echo '<td align="right">'.$tag->sisa_bayar.'</td>';
                        $total+=$tag->sisa_bayar;
                    }
                    else
                    {
                        echo '<td align="right">0</td>';
                        $total+=0;
                    }
                }

            }
            if(isset($inves2[$vd->nis]))
			{

				if(count($inves2[$vd->nis])!=0)
				{
                    echo '<td style="width:100px !important;text-align:right">'.array_sum($inves2[$vd->nis]).'</td>';
                    $total+=array_sum($inves2[$vd->nis]);
                }
                else
                {
                    $total+=0;
                    echo '<td style="width:100px !important;text-align:right">'.$total.'</td>';
                }
            }
            else
            {
                $total+=0;
                echo '<td style="width:100px !important;text-align:right">'.$total.'</td>';
            }
            echo '<td style="width:100px !important;text-align:right">0</td>';
            echo '<td align="right">'.$total.'</td>';
            echo '</tr>';
            $no++;
        }
    ?>
</table>