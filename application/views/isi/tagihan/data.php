<form action="<?=site_url()?>tagihan/kirim" method="post">
    
    <ul class="nav nav-tabs">
        <?php
        if(count($kelas)==0)
        {
        ?>
            <li class="active"><a data-toggle="tab" href="#home">Home</a></li>
        <?php
        }
        else
        {
            $i=0;
            foreach($kelas as $k => $v)
            {
                $active='';
                if($i==0)
                    $active='class="active"';
        ?>
            <li <?=$active?>><a data-toggle="tab" href="#<?=$k?>"><?=strtoupper($v)?></a></li>
        <?php
                $i++;
            }
            echo '<li class="pull-right"><a data-toggle="tab" href="#kirim"><i class="fa fa-envelope"></i>  Kirim Email</a></li>';
        }
        ?>
        
    </ul>

    <div class="tab-content">
        
    
        <input type="hidden" name="bulan" value="<?=(isset($bulan) ? $bulan : date('n'))?>">
        <input type="hidden" name="tahun" value="<?=(isset($tahun) ? $tahun : date('Y'))?>">
        <?php
        if(count($kelas)==0)
        {
        ?>
            <div id="home" class="tab-pane fade in active">
                <h3>DATA TAGIHAN</h3>
                <p>Silahkan Upload File Excel Di Form Sebelah Kanan</p>
            </div>
        <?php
        }
        else
        {
            $i=0;
            foreach($kelas as $k => $v)
            {
                echo '<input type="hidden" name="kelas[]" value="'.str_replace(' ','_',$v).'">';
                $active='';
                if($i==0)
                    $active="active";
        ?>
            <input type="hidden" name="level" value="<?=$level?>">
            <div id="<?=$k?>" class="tab-pane fade in <?=$active?>">
                <h3><?=$level?> : <?=strtoupper($v)?></h3>
                    
                    <table id="" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="center" rowspan="2" style="width:40px;">
                                    <input type="checkbox" id="pilih" value="<?=$k?>">
                                </th>
                                <th class="center" rowspan="2" style="width:20px;">No</th>
                                <th rowspan="2">Email Orang Tua</th>
                                <th rowspan="2">Nama</th>
                                <th rowspan="2">VA</th>
                                <th colspan="6">Tagihan Bulan <?=getBulan($bulan)?> <?=$tahun?></th>
                                <th rowspan="2">Total</th>
                            </tr>
                            <tr>
                            <?php
                            foreach($values[$v][3] as $kk => $vv)
                            {
                                if($vv!='' && strtolower($vv)!='total')
                                {
                                    echo '<th>'.$vv.'</th>';
                                }
                            }
                            ?>
                            </tr>
                        </thead>

                        <tbody>
                        <?php
                        $no=1;
                        foreach($values[$v] as $dk => $vk)
                        {
                            
                            if($dk>3 && isset($vk['A']))
                            {
                                if($vk['A']!=null || $vk['A']!='')
                                {
                                    echo '<tr>';
                                    $val=$vk['B'];
                                    
                                    if(isset($sis[strtolower(trim($val))]))
                                    {
                                        $namasiswa='<span style="color:blue;">'.ucwords(strtolower($val)).'</span>';
                                        $nis=strtolower($sis[strtolower(trim($val))]->nama_murid);
                                        echo '<input type="hidden" name="nama['.str_replace(' ','_',$v).']['.$no.']" value="'.$val.'">';
                                        $dt=$sis[strtolower(trim($val))];
                                        $email=$sis[strtolower(trim($val))]->email_ayah.'<br>'.$sis[strtolower(trim($val))]->email_ibu;
                                        $email=str_replace('/','<br>',$email);
                                        echo '<input type="hidden" name="email['.str_replace(' ','_',$v).']['.$no.']" value="'.strtolower($sis[strtolower(trim($val))]->email_ayah.';'.$sis[strtolower(trim($val))]->email_ibu).'">';
                                        if($sis[strtolower(trim($val))]->email_ayah=='' && $sis[strtolower(trim($val))]->email_ibu=='')
                                        {
                                            $email='<input type="email" name="email['.str_replace(' ','_',$v).']['.$no.']" style="width:90%;font-size:11px;" id="email_'.str_replace(' ','',$v).'_'.$dk.'">&nbsp;&nbsp;<i class="fa fa-save" style="cursor:pointer" onclick="simpanemail(\''.$dt->id.'\',\''.str_replace(' ','',$v).'\',\''.$dk.'\')"></i>';
                                        }
                                    }
                                    else
                                    {
                                        $nis=strtolower($vk['B']);
                                        echo '<input type="hidden" name="nama['.str_replace(' ','_',$v).']['.$no.']" value="'.$vk['B'].'">';

                                        // $nn=$sis[strtolower(trim($val))]->nama_murid;
                                        // echo $nn.'<br>'.$val;
                                        $namasiswa='<button class="btn btn-xs btn-primary"><i class="fa fa-save"></i>  '.ucwords(strtolower($val)).'</button>';
                                        $color='style="color:red;"';
                                        $email='<input type="email" name="email['.str_replace(' ','_',$v).']['.$no.']" style="width:90%;font-size:11px;" id="email_'.str_replace(' ','',$v).'_'.$dk.'">&nbsp;&nbsp;<i class="fa fa-save" style="cursor:pointer" onclick="simpanemail(-1,\''.str_replace(' ','',$v).'\',\''.$dk.'\')"></i>';
                                    }

                                    echo '<td class="text-center"><input type="checkbox" id="p_pilih_'.$k.'" name="p_email['.str_replace(' ','_',$v).']['.$no.']"></td>';
                                    echo '<td class="text-center">'.$vk['A'].'</td>';
                                    echo '<td class="text-left">
                                        <span id="dataemail_'.str_replace(' ','',$v).'_'.$dk.'"></span>'.$email.'
                                        </td>';
                                    echo '<td class="text-left">'.$namasiswa.'</td>';
                                    echo '<td class="text-center">'.$vk['C'].'
                                            <input type="hidden" name="va['.str_replace(' ','_',$v).']['.$no.']" value="'.$vk['C'].'">
                                        </td>';
                                    echo '<td class="text-right">
                                            <input type="text" name="spp['.str_replace(' ','_',$v).']['.$no.']" id="'.str_replace(' ','',$v).'_'.$dk.'" value="'.(isset($vk['G']) ? number_format($vk['D'],0,'.',',') : 0).'" style="width:80px;font-size:11px;" class="jumlah text-right" onkeyup="hitung(\''.str_replace(' ','',$v).'\',\''.$dk.'\',this.value)">
                                        </td>';
                                    echo '<td class="text-right">
                                            <input type="text" name="catering['.str_replace(' ','_',$v).']['.$no.']" id="'.str_replace(' ','',$v).'_'.$dk.'" value="'.(isset($vk['G']) ? number_format($vk['E'],0,'.',',') : 0).'" style="width:80px;font-size:11px;" class="jumlah text-right" onkeyup="hitung(\''.str_replace(' ','',$v).'\',\''.$dk.'\',this.value)">
                                        </td>';
                                    echo '<td class="text-right">
                                            <input type="text" name="jemputan['.str_replace(' ','_',$v).']['.$no.']" id="'.str_replace(' ','',$v).'_'.$dk.'" value="'.(isset($vk['G']) ? number_format($vk['F'],0,'.',',') : 0).'" style="width:80px;font-size:11px;" class="jumlah text-right" onkeyup="hitung(\''.str_replace(' ','',$v).'\',\''.$dk.'\',this.value)">
                                        </td>';
                                    echo '<td class="text-right">
                                            <input type="text" name="jemputan_club['.str_replace(' ','_',$v).']['.$no.']" id="'.str_replace(' ','',$v).'_'.$dk.'" value="'.(isset($vk['G']) ? number_format($vk['G'],0,'.',',') : 0).'" style="width:80px;font-size:11px;" class="jumlah text-right" onkeyup="hitung(\''.str_replace(' ','',$v).'\',\''.$dk.'\',this.value)">
                                        </td>';
                                    echo '<td class="text-right">
                                            <input type="text" name="club['.str_replace(' ','_',$v).']['.$no.']" id="'.str_replace(' ','',$v).'_'.$dk.'" value="'.(isset($vk['G']) ? number_format($vk['H'],0,'.',',') : 0).'" style="width:80px;font-size:11px;" class="jumlah text-right" onkeyup="hitung(\''.str_replace(' ','',$v).'\',\''.$dk.'\',this.value)">
                                        </td>';
                                    echo '<td class="text-right">
                                            <input type="text" name="investasi['.str_replace(' ','_',$v).']['.$no.']" id="'.str_replace(' ','',$v).'_'.$dk.'" value="'.(isset($vk['G']) ? number_format($vk['I'],0,'.',',') : 0).'" style="width:80px;font-size:11px;" class="jumlah text-right" onkeyup="hitung(\''.str_replace(' ','',$v).'\',\''.$dk.'\',this.value)">
                                        </td>';
                                    echo '<td class="text-right">
                                            <input type="text" name="total['.str_replace(' ','_',$v).']['.$no.']" id="total_'.str_replace(' ','',$v).'_'.$dk.'" value="'.(isset($vk['G']) ? number_format($vk['J'],0,'.',',') : 0).'" readonly style="width:80px;font-size:11px;" class="text-right">
                                        </td>';
                            
                                        
                                    echo '</tr>';
                                    $no++;
                                }
                            }
                        }
                        ?>
                        </tbody>
                    </table>
            </div>
        <?php
                $i++;
            }
        }
        ?>
        <div id="kirim" class="tab-pane fade in">
            <center>
            <h1>PERHATIAN</h1>
                <BR>
            <h4>Apakah Data Tagihan Yang akan dikirim Sudah Benar Semua?
                <BR>
                <BR>
                Dan Apakah Benar ingin mengirim BroadCast Email Ke Seluruh Data Siswa ??

            </h4>
            <div class="clearfix form-actions" style="">
                <div class="col-md-12">
                    <button class="btn btn-info" id="kirimemail" type="submit">			
                        <i class="ace-icon fa fa-check bigger-110"></i> YA, KIRIM EMAIL
                    </button>
                    
                </div>
            </div>
            </center>
        </div>
    </div>
    
</form>
    
    <style>
    table td
    {
        font-size:11px !important;
    }
    </style>
    <script>
    function hitung(level,id, val)
    {
        //$('#'+level+'_'+id).formatCurrency({symbol:''})
        var total=0;
        var sub=val.replace(/,/g,'');
        $('input#'+level+'_'+id).each(function(a){
            var n=$(this).val();
            //alert(n);
            n=parseInt(n.replace(/,/g,''));
            total+=n;
        });    
        $('input#total_'+level+'_'+id).val(total);
        $('input#total_'+level+'_'+id).formatCurrency({symbol:''});
    }
    function simpanemail(ids,level,id)
    {
        //alert(id+'--'+val);
        var mail=$('#email_'+level+'_'+id);
        //var mail=$('#email_'+id);
        $.ajax({
            url : '<?=site_url()?>siswa/simpanemail/'+ids,
            type:'POST',
            data:{email:mail.val()},
            success : function(a){
                //$('span#dataemail_'+level+'_'+id).text(a);
                if(a==1)
                    mail.css({'border':'1px solid green'});
                else
                    mail.css({'border':'1px solid red'});
            }
        });
    }
    
    $('input#pilih').each(function(a){
        $(this).click(function () {
            var id=$(this).val();
            $('input#p_pilih_'+id).not(this).prop('checked', this.checked);
        });
    });
    $('input.jumlah').each(function(a){
        $(this).keyup(function(){
            $(this).formatCurrency({symbol:''})
        });
    });
    </script>