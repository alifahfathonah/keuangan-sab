<h3>Kelas : <?=strtoupper($batch->kategori).' - '.$batch->nama_batch?></h3>
<table id="simple-table" class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <!-- <th class="center">No</th> -->
            <th rowspan="2" class="center">No</th>
            <th rowspan="2" class="center">Nama Siswa</th>
        <?php
        $he=$this->config->item('hari_efektif');


        // $where='(level="'.$batch->kategori.'" OR level="all" OR jenis like "investasi") and id_parent=0 and jenis not like "biaya seleksi"';
        // $penerimaan=$this->db->from('t_jenis_penerimaan')->where($where)->where('status_tampil','t')->group_by('jenis')->order_by('jenis')->get()->result();
        $penerimaan=$this->config->item('jenispenerimaan');
        // $trans=$this->config->item('v_transaksi');
        // $penerimaan2=$this->db->from('t_jenis_penerimaan')->where('status_tampil','t')->order_by('jenis')->get()->result();
        echo '
            <th rowspan="2">Hari Efektif</th>
            <th colspan="'.(count($penerimaan)-1).'" class="center">Tagihan</th>

            <th rowspan="2">Total Tagihan</th>
            </tr>';
        echo '<tr>';
        $data_terima=array();
        $sub_data=array();
        // foreach ($penerimaan2 as $k => $v)
        // {
        //  if($v->id_parent>0)
        //  {
        //      $sub_data[$v->id_parent][str_replace(' ', '', $v->jenis)]=$v->jumlah;
        //  }
        //      $data_terima["$v->jenis"]["$v->level"]=$v;
        // }
        foreach ($penerimaan as $k => $v)
        {
            if($v!='Investasi')
            {

                echo '<th class="center" style="width:130px !important">
                        <div style="width:100%;float:left">'.ucwords($v).'</div>

                    </th>';
            }
        }

        echo '</tr>';
        ?>
    </thead>
    <tbody>
    <?php
    // echo '<pre>';
    // print_r($tagihan);
    // echo '</pre>';
    $no=1;
    foreach ($d as $k => $v)
    {
        echo '<tr>';
        echo '<td class="center">'.$no.'</td>';
        echo '<td class="left">'.ucwords(strtolower($v->nama_murid)).'</td>';
        echo '<td style="text-align:center">'.$hari_efektif.' hari</td>';
    	$totaltagihan=0;
    	$jth=0;
        foreach ($penerimaan as $kk => $vv)
        {
	          $tglbayar='-';
	    	    $jumlah=$color_bayar='';
            $jenis_p=strtolower($vv);
            // $jenis_p=strtok($vv->jenis, ' ');
            // if(strpos($jenis_p, needle))
            // if($bulan==7 && $jenis_p==)
            if(isset($tagihan[$jenis_p][$v->nis]))
            {
                // echo '<pre>';
                // print_r($tagihan[$jenis_p][$v->nis]);
                // echo '</pre>';
            	if(count($tagihan[$jenis_p][$v->nis])==1)
            	{
            		  $n_club='';
                	if(isset($trans[$vv][$v->nis][$tahun][$bulan]))
                	{
                		$idx=key($trans[$vv][$v->nis][$tahun][$bulan]);
                		//if(count($trans[$kk][$tahun][$bulan][$v->nis])==1)
                		//{
	                	$tglbayar=tbt($trans[$vv][$v->nis][$tahun][$bulan][$idx]->tanggal_transaksi);
	                	$color_bayar='green';
	                	$jlh=($tagihan[$jenis_p][$v->nis][0]->sudah_bayar);
	                	$jlh=number_format($jlh);
	                	$jth=0;
                	}
                	else
                	{
                    $color_bayar='red';
                    $tglbayar='';
                    $jth=$jlh=($tagihan[$jenis_p][$v->nis][0]->wajib_bayar)-($tagihan[$jenis_p][$v->nis][0]->sudah_bayar);
                    $jlh=number_format($jlh);
                  }

                  //   if($jlh=='0')
                  //   {
                		// $color_bayar='green';
                  //   }

            		if(strtolower($vv)=='club')
            		{
            			$idc=explode(':', $tagihan[$jenis_p][$v->nis][0]->keterangan);
	            		$idnclub=strtok($idc[1],'__');
	            		$n_club=$t_club[$idnclub];
	            		$n_club='<div style="text-align:left;font-size:9px;" class="blue">'.$n_club->nama_club.'</div>';


            		}
              	$jumlah=$n_club.'<span class="'.$color_bayar.'">'.($jlh).'</span>';
              	$totaltagihan+=$jth;
              }
            	else
	            {
            		// if(strtolower($vv->jenis)=='club')
            		$jumlah=$tglbayar=$color_bayar='';
	            	foreach ($tagihan[$jenis_p][$v->nis] as $kt => $vt)
	            	{
	            		# code...
	            		$idc=explode(':', $vt->keterangan);
                  // print_r($idc[0];

                  if(count($idc)>1)
                  {
                    $idnclub=strtok($idc[1],'__');
  	            		$n_club=$t_club[$idnclub];
                    if(isset($trans[$kk][$tahun][$bulan][$v->nis][$idnclub]))
                    {
                      $tb=$trans[$kk][$tahun][$bulan][$v->nis][$idnclub]->tanggal_transaksi;
                      $tglbayar.='<div style="text-align:left;font-size:9px;" class="">&nbsp;</div>'.tbt($tb).'<br>';
                      $color_bayar='green';
                      $jlhh=($vt->sudah_bayar);
                      $namaclub=$n_club->nama_club;
                    }
                    else
                    {
                      $n_club=$namaclub='';
                    }

                  }
                  else
                  {
                    $n_club=$namaclub='';
                    // $tglbayar='<div style="text-align:left;font-size:9px;" class="">&nbsp;</div>-<br>';
                    $color_bayar='red';
                    $jlhh=($vt->wajib_bayar)-($vt->sudah_bayar);
                  }

	            		$jumlah='<div style="text-align:left;font-size:9px;" class="blue">'.$namaclub.'</div><span class="'.$color_bayar.'">'.number_format($jlhh).'</span><br>';
	                		// $tglbayar.=
	            		$totaltagihan+=$vt->sisa_bayar;
	            	}
	            }
	            $jlhlain='';
	            $tglbayarlain='';
            }
            else
            {

              $jlhlain='';
	            $tglbayarlain='';
              $jumlah='';
            }
            //   $tglbayar='--';

            // $jumlah='';
            if(strpos(strtolower($vv),'investasi')!==false)
            {
            	// echo $
            //     if(isset($inves[$tahun][$vv->id][$v->nis]))
            //     {
            //     	if($bulan>=7 && $bulan<=12)
            //     	{
            //     		$thn=$tahun;
            //     	}
            //     	else
            //     	{
            //     		$thn=$tahun-1;
            //     	}
            //     	if(isset($transinves[$vv->id][$thn][$v->nis]))
            //     	{
            //     		// $color_bayar='';
	           //      	$color_bayar='<span class="red">'.number_format($inves[$thn][$vv->id][$v->nis]->wajib_bayar - $inves[$thn][$vv->id][$v->nis]->sudah_bayar).'</span>';
            //     		foreach ($transinves[$vv->id][$thn][$v->nis] as $kc => $vc)
            //     		{	# code...
	           //      		$color_bayar.='<br><span class="green">'.number_format($vc->jumlah).'</span>';
	           //      		$tglbayar.='<br>'.tbt($vc->tanggal_transaksi);
            //     		}
	           //      	$totaltagihan+=$inves[$thn][$vv->id][$v->nis]->sisa_bayar;
            //     	}
            //     	else
            //     	{
            //     	// echo '<pre>';
            //     	// print_r($transinves[$vv->id][$thn][$v->nis]);
            //     	// echo '</pre>';
            //     		if(isset($inves[$thn]))
            //     		{

	           //      		$jj=$inves[$thn][$vv->id][$v->nis];
	           //      		$color_bayar='<span class="red">'.number_format($jj->sisa_bayar).'</span>';
	           //      		$tglbayar='-';
		          //       	$totaltagihan+=$jj->sisa_bayar;
            //     		}
            //     	}

            //     	if(isset($inves[$thn]))
            //     	{
            //         	$jumlah=$color_bayar;
            //         	//$totaltagihan+=$inves[$thn][$vv->id][$v->nis]->sisa_bayar;
            //     	}
            //         else
            //         {
            //         	//$jumlah=0;
            //         	//$totaltagihan+=0;
            //         }
            //     }

            }
            else
            {
            	// break;
                // $totaltagihan+=0;
                // $jumlah='<span class="red">'.number_format(0).'</span>';
                // $tglbayar='';
                // $jumlah=number_format(0);
            }

            if($vv!='Investasi')
            {

                echo '<td class="right" style="text-align:right">
                        <div style="width:100%;float:left">'.($jumlah).'<br>'.$tglbayar.'</div>
                    </td>';
            }
        }
        echo '<td style="text-align:right;font-weight:bold;">'.number_format($totaltagihan).'</td>';
        echo '</tr>';
        $no++;
    }
    ?>
    </tbody>
</table>
<style type="text/css">
	table th, table td
	{
		font-size: 10px !important;
	}
</style>
