<?php
    header("Content-Disposition: attachment; filename=Arus_Kas_".($j_lap==-1 ? '' : ($j_lap=='non' ? 'Non Sekolah' : 'Sekolah'))."_TA_".$date.".xls");
    header("Pragma: no-cache");
    header("Expires: 0");
?>
        <h2><?=$j_lap==-1 ? 'Arus Kas' : 'Arus Kas '.($j_lap=='non' ? 'Non Sekolah' : 'Sekolah')?></h2>
        <table id="simple-table" class="table table-striped table-bordered table-hover" border="1" cellpadding="2" cellspacing="2" width="100%">
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
            if(isset($kodeakun[$kat]))
            {
                foreach($kodeakun[$kat] as $kkd => $vkd)
                {
                    $subbulan=array();
                    foreach($vkd as $ikd => $vd)
                    {
                        echo '<tr>';
                        echo '<td>'.$vd->nama_akun.'</td>';
                        echo '<td>'.$vd->akun_alternatif.'</td>';
                        $kdalt=$vd->akun_alternatif;
                        
                        foreach($semester as $s => $vs)
                        {
                            $subtotal=0;
                            foreach($vs as $k => $v)
                            {
                                if($v>=7 && $v<=12)
                                    $thn=$thn1;
                                else
                                    $thn=$thn2;

                                if(isset($trans[$thn][$v][$kdalt]))
                                {
                                    $jlh=array_sum($trans[$thn][$v][$kdalt]);
                                }
                                else
                                    $jlh=0;

                                $subbulan[$kkd][$v][]=$jlh;    
                                $subtotal+=$jlh;    
                                echo '<td style="text-align:right">'.($jlh).'</td>';
                            }                    
                        }
                        echo '<td style="text-align:right;background:#eee;">'.($subtotal).'</td>';
                        echo '</tr>';
                    }

                    echo '<tr>';
                    echo '<td colspan="2" style="background:#eee;border:1px solid #888;text-align:right"><b>TOTAL '.strtoupper($kkd).'</b></td>';
                    $sub_total=0;
                    foreach($semester as $s => $vs)
                    {
                        foreach($vs as $k => $v)
                        {
                            $sub=array_sum($subbulan[$kkd][$v]);
                            echo '<td style="background:#eee;border:1px solid #888;text-align:right">'.($sub).'</td>';
                            $sub_total+=$sub;
                        }                    
                    }
                    echo '<td style="background:#eee;border:1px solid #888;text-align:right">'.($sub_total).'</td>';
                    echo '</tr>';
                }
            }

            ?>
            </tbody>
        </table>