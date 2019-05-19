<table id="simple-table" class="table table-striped table-bordered table-hover">
    <thead>
    <?php
    if($jTrans=='penerimaan')
    {
    ?>
        <tr>
            <th class="center">No</th>
            <th class="center">Tanggal</th>
            <th class="center">Nama Siswa</th>
            <th class="center">Kelas</th>
            <th class="center">Jenis Penerimaan</th>
            <th class="center">Jumlah</th>
            <th class="center">Keterangan</th>
            <th class="center"></th>
        </tr>
    <?php
    }
    else
    {
    ?>
        <tr>
            <th class="center">No</th>
            <th class="center">Tanggal</th>
            <th class="center">Jenis Pengeluaran</th>
            <th class="center">Penerima</th>
            <th class="center">Jumlah</th>
            <th class="center">Keterangan</th>
            <th class="center"></th>
        </tr>
    <?php
    }
    ?>
    </thead>
    <tbody>
    <?php
    $no=1;
    $total=0;
    foreach ($trans as $k => $v) 
    {
    	$sis=$kls='';
    	foreach ($v as $ks => $vs) 
    	{
            // echo '<pre>';
            // print_r($vs);
            // echo '</pre>';
            if($jTrans=='penerimaan')
            {
                $idd=key($vs);
                list($nis,$nama,$batch_id)=explode('__', $ks);

                // $kelas='<div style="padding:2px 5px 10px 5px;border-bottom:1px #ddd dotted;">'.strtoupper($batch[$batch_id]->kategori).' : '.$batch[$batch_id]->nama_batch.'</div>';
                if(isset($batch[$batch_id]))
                    $kelas=strtoupper($batch[$batch_id]->kategori).' : '.$batch[$batch_id]->nama_batch;
                else
                {
                    $vbs=$this->config->item('tpendaftaran3');
                    //$kelas=$vbs[$vs[$idd]->tahun_ajaran][$vs[$idd]->nis]->kelas .' - '.$vs[$idd]->tahun_ajaran;
                    // print_r($vs);
                    $kelas='';
                }
                // $nama='<div style="padding:2px 5px 10px 5px;border-bottom:1px #ddd dotted;">'.str_replace('_', ' ', $nama).'</div>';
                $nama=str_replace('_', ' ', $nama);
                // $nama=$ks;
                // $sis.=$nama;
                // $kls.=$kelas;
                $jenis='';
                $jlh='';
                foreach ($vs as $jns => $vik) 
                {
                    foreach($vik as $ik => $vjns)
                    {
                        $period=getBulanSingkat($vjns->bulan_tagihan).' '.$vjns->tahun_tagihan;
                        if(strpos(strtolower($vjns->jenis), 'investasi')!==false)
                        $period=$vjns->tahun_tagihan;
                        
                        $jenis.='<div style="width:50%;float:left;">'.$vjns->jenis.'</div><div style="float:right;width:49%"> : '.$period.'</div>';
                        $jlh.=number_format($vjns->jumlah).'<br>';
                        $total+=$vjns->jumlah;
                    }
                }
                
                echo '<tr>';
                echo '<td style="text-align:center">'.$no.'</td>';
                echo '<td style="text-align:center">'.tgl_indo($k).'</td>';
                echo '<td style="text-align:left">'.$nama.'</td>';
                echo '<td style="text-align:center">'.$kelas.'</td>';
                echo '<td style="text-align:left;width:300px !important">'.$jenis.'</td>';
                echo '<td style="text-align:right">'.$jlh.'</td>';
                echo '<td style="text-align:left"></td>';
                echo '<td style="text-align:center">
                    <a class="btn btn-info  btn-minier" href="#" onclick="edit(\''.$vs[$idd][0]->id_trans.'\')">
                        <i class="fa fa-pencil"></i>                                                
                    </a>
                    <button class="btn btn-danger btn-minier" type="button" onclick="hapus(\''.$vs[$idd][0]->id_trans.'\')">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>';
                echo '</tr>';
            }
            else
            {
                list($idjenis,$njenis)=explode('__', $ks);
                $pen=$jlhkeluar='';
                foreach ($vs as $kdt => $vdt) 
                {
                    $pen.=$vdt->penerima.'<br>';
                    $jlhkeluar.=number_format($vdt->jumlah,0,',','.').'<br>';
                    $total+=$vdt->jumlah;
                }
                $idd=key($vs);
                echo '<tr>';
                echo '<td style="text-align:center">'.$no.'</td>';
                echo '<td style="text-align:center">'.tgl_indo($k).'</td>';
                echo '<td style="text-align:left;width:200px !important">'.$njenis.'</td>';
                echo '<td style="text-align:left;width:200px !important">'.$pen.'</td>';
                echo '<td style="text-align:right">'.$jlhkeluar.'</td>';
                echo '<td style="text-align:left"></td>';
                echo '<td style="text-align:center">
                    <a class="btn btn-info  btn-minier" href="#" onclick="edit(\''.$vs[$idd]->id_trans.'\')">
                        <i class="fa fa-pencil"></i>                                                
                    </a>
                    <button class="btn btn-danger btn-minier" type="button" onclick="hapus(\''.$vs[$idd]->id_trans.'\')">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>';
                echo '</tr>'; 
            }
            $no++;
        }

    }
    // echo '<pre>';
    // print_r($trans);
    // echo '</pre>';
    ?>
    </tbody>
    <thead>
    <?php
    if($jTrans=='penerimaan')
    {
    ?>
        <tr>
            <th class="right" style="text-align: right" colspan="5">TOTAL</th>
            <th class="right" style="text-align: right" ><?=number_format($total,0,',','.')?></th>
            <th class="center"></th>
            <th class="center"></th>
        </tr>
    <?php
    }
    else
    {
    ?>
        <tr>
            <th class="right" style="text-align: right" colspan="4">TOTAL</th>
            <th class="right" style="text-align: right"><?=number_format($total,0,',','.')?></th>
            <th class="center"></th>
            <th class="center"></th>
        </tr>
    <?php  
    }
    ?>
    </thead>
</table>
<style type="text/css">
    table td
    {
        font-size:11px !important;
    }
</style>