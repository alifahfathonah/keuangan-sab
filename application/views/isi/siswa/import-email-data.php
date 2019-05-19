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
                $active='';
                if($i==0)
                    $active="active";
        ?>
            <div id="<?=$k?>" class="tab-pane fade in <?=$active?>">
                <h3><?=$level?> : <?=strtoupper($v)?></h3>
                    
                    <table id="" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="center" rowspan="2" style="width:20px;">No</th>
                                <th rowspan="2">Nama Siswa</th>
                                <th rowspan="2">Email Ayah</th>
                                <th rowspan="2">EMail Ibu</th>
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
                                    
                                    
                                    echo '<td class="text-center">'.$vk['A'].'</td>';
                                    echo '<td class="text-left">'.$vk['B'].'</td>';
                                    echo '<td class="text-left">'.$vk['C'].'</td>';
                                    echo '<td class="text-left">'.$vk['D'].'</td>';     
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
       
    </div>
    
</form>
    
    <style>
    table td
    {
        font-size:11px !important;
    }
    </style>
    <script>
 
    // function simpanemail(ids,level,id)
    // {
    //     //alert(id+'--'+val);
    //     var mail=$('#email_'+level+'_'+id);
    //     //var mail=$('#email_'+id);
    //     $.ajax({
    //         url : '<?=site_url()?>siswa/simpanemail/'+ids,
    //         type:'POST',
    //         data:{email:mail.val()},
    //         success : function(a){
    //             //$('span#dataemail_'+level+'_'+id).text(a);
    //             if(a==1)
    //                 mail.css({'border':'1px solid green'});
    //             else
    //                 mail.css({'border':'1px solid red'});
    //         }
    //     });
    // }
    
    $('input.jumlah').each(function(a){
        $(this).keyup(function(){
            $(this).formatCurrency({symbol:''})
        });
    });
    </script>