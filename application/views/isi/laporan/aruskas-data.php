<div class="row">
	<div class="col-xs-6">
		<button class="btn btn-xs btn-success" onclick="aruskasnonsekolah('<?=$date?>')"><i class="fa fa-file"></i> Arus Kas Non Sekolah</button>
		<button class="btn btn-xs btn-primary" onclick="aruskassekolah('<?=$date?>')"><i class="fa fa-file"></i> Arus Kas Sekolah</button>
	</div>
	<div class="col-xs-6">
		<div class="pull-right" style="margin-bottom:5px;">
			<button class="btn btn-xs btn-success" onclick="downloadaruskas('<?=$j_lap?>','<?=$date?>')"><i class="fa fa-download"></i> Unduh Arus Kas</button>
			<button class="btn btn-xs btn-primary" onclick="reloadaruskas()"><i class="fa fa-refresh"></i> Refresh</button>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xs-12">
        <h2><?=$j_lap==-1 ? '' : 'Arus Kas '.($j_lap=='non' ? 'Non Sekolah' : 'Sekolah')?></h2>
        <table id="simple-table" class="table table-striped table-bordered table-hover" style="width:100%">
			<thead>
				<tr>
					<th style="text-align:center" rowspan="2">POS</th>
					<th style="text-align:center" rowspan="2">Kode</th>
                    <?php
                    foreach($semester as $s => $vs)
                    {
                        echo '<th style="text-align:center" colspan="'.count($vs).'">'.$s.'</th>';
                    }
                    ?>
					<th style="text-align:center" rowspan="2">Total</th>
				</tr>
                <tr>
                <?php
                // echo $tahun;
                    list($th1,$th2)=explode('/',$tahun);
                    $thn1=trim($th1);
                    $thn2=trim($th2);
                    foreach($semester as $s => $vs)
                    {
                        foreach($vs as $k => $v)
                        {
                            
                            if($v>=7 && $v<=12)
                                $thn=$thn1;
                            else
                                $thn=$thn2;

                            echo '<th style="text-align:center">'.getBulanSingkat($v).' '.$thn.'</th>';
                        }
                    }
                ?>
                </tr>
			</thead>
			<tbody>
            <?php
            // echo '<pre>';
            // print_r($kodeakun[$kat]);
            // echo '</pre>';
            if(isset($kodeakun[$kat]))
            {
                foreach($kodeakun[$kat] as $kkd => $vkd)
                {
                    $subbulan=array();
                    $subbulanh=array();
                    foreach($vkd as $ikd => $vd)
                    {
                            if($vd->akun_alt_parent=='0')
                            {
                                $st='style="background:#ddd;font-weight:bold;border:1px solid #999;color:green"';
                                $st2='style="color:green;font-weight:bold;"';
                                $st3='color:green;font-weight:bold;';
                            }
                            else
                                $st=$st2=$st3='';

                            echo '<tr>';
                            echo '<td '.$st.'>'.$vd->nama_akun.'</td>';
                            echo '<td '.$st.'>'.$vd->akun_alternatif.'</td>';
                            $kdalt=$vd->akun_alternatif;
                            
                            foreach($semester as $s => $vs)
                            {
                                $subtotal=$subtotalh=0;
                                foreach($vs as $k => $v)
                                {
                                    if($v>=7 && $v<=12)
                                        $thn=$thn1;
                                    else
                                        $thn=$thn2;

                                    if(isset($trans[$thn][$v][$kdalt]))
                                    {
                                        $jlh=array_sum($trans[$thn][$v][$kdalt]);
                                        $subbulan[$kkd][$v][]=$jlh;    
                                        $subtotal+=$jlh;   
                                    }
                                    else
                                    {
                                        $jlh=0;
                                        $subbulan[$kkd][$v][]=$jlh;    
                                        $subtotal+=$jlh;   
                                    }
                                    
                                    
                                    if(isset($total[$thn][$v][$kdalt]))
                                    {
                                        $jlh2=array_sum($total[$thn][$v][$kdalt]);
                                        $subbulanh[$kkd][$v][]=$jlh2;    
                                        $subtotalh+=$jlh2;  
                                    }
                                    else
                                    {
                                        $jlh2=0;
                                        $subbulanh[$kkd][$v][]=$jlh2;    
                                        $subtotalh+=$jlh2; 
                                    }
                                    // else
                                    // {
                                    //     $jlh=0;
                                    //     $subbulan[$kkd][$v][]=$jlh;    
                                    //     $subtotal+=$jlh;  
                                    // }

                                    if($vd->akun_alt_parent=='0')
                                    {
                                        echo '<td class="text-right" '.$st.'><a href="'.site_url().'laporan/bukubesar/'.$thn.'-'.$v.'/'.$kdalt.'" target="_blank" '.$st2.'>'.number_format($jlh2,0,',','.').'</a></td>';
                                    } 
                                    else
                                    {
                                        echo '<td class="text-right" '.$st.'><a href="'.site_url().'laporan/bukubesar/'.$thn.'-'.$v.'/'.$kdalt.'" target="_blank" '.$st2.'>'.number_format($jlh,0,',','.').'</a></td>';
                                    }   
                                }                
                            }
                            if($vd->akun_alt_parent=='0')
                            {
                                echo '<td style="text-align:right;background:#ddd;border:1px solid #999;'.$st3.'">'.number_format($subtotalh,0,',','.').'</td>';
                            }
                            else
                            {

                                echo '<td style="text-align:right;background:#ddd;border:1px solid #999;'.$st3.'">'.number_format($subtotal,0,',','.').'</td>';
                                echo '</tr>';
                            }
                        
                    }

                    echo '<tr>';
                    echo '<td colspan="2" style="background:#eee;border:1px solid #888;text-align:right"><b>TOTAL '.strtoupper($kkd).'</b></td>';
                    $sub_total=0;
                    foreach($semester as $s => $vs)
                    {
                        foreach($vs as $k => $v)
                        {
                            $sub=array_sum($subbulan[$kkd][$v]);
                            echo '<td style="background:#eee;border:1px solid #888;text-align:right">'.number_format($sub,0,',','.').'</td>';
                            $sub_total+=$sub;
                        }                    
                    }
                    echo '<td style="background:#eee;border:1px solid #888;text-align:right">'.number_format($sub_total,0,',','.').'</td>';
                    echo '</tr>';
                }
            }

            ?>
            </tbody>
        </table>
	</div>
</div>
<style>
    th,td
    {
        font-size:10px !important;
    }
</style>