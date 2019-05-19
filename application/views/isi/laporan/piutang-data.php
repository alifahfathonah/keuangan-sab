
<div class="row">
	<div class="col-xs-12">

		<form class="form-horizontal" role="form" id="datasiswa">
			<div class="row">
				<div class="col-xs-9">
					&nbsp;
				</div>
				<div class="col-xs-3">
					<a href="javascript:reload(<?=$idta?>)" class="btn btn-app btn-success pull-right">
						<i class="ace-icon fa fa-refresh bigger-230"></i>
						Reload
					</a>
				</div>
			</div>
			
			<div class="form-group" style="margin-bottom: 3px;">
				<div class="col-sm-12" style="padding-top:2px;">
					<table id="simple-table" class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th class="center" rowspan="2">No</th>
								<th class="center" rowspan="2">Nama Siswa</th>
								<th class="center" colspan="<?=count($tag_jenis)?>">Keterangan</th>
								<th class="center" rowspan="2">Jumlah Piutang</th>
								
							</tr>
                            <tr>
                            <?php
                                $subtotal=array();
                                foreach($tag_jenis as $k=>$v)
                                {
                                    echo '<th>'.ucwords(str_replace('_',' ',$k)).'</th>';
                                    $subtotal[$k][]=0;
                                }
                            ?>
                            </tr>
						</thead>
						<tbody>
                        <?php
                        $no=1;
                        $total=0;
                        foreach($nissiswa2 as $k => $v)
                        {
                            echo '<tr>';
                            echo '<td class="text-center">'.$no.'</td>';
                            echo '<td class="text-left">'.$v->nama_murid.'</td>';

                            $nis=str_replace('.','_',$v->nis);
                            $row_total=0;
                            if(isset($piutang[$nis]))
                            {
                                foreach($tag_jenis as $k=>$v)
                                {
                                    $piu="";
                                    $pi=0;
                                    if(isset($piutang[$nis][$k]))
                                    {
                                            foreach($piutang[$nis][$k] as $kk=>$vv)
                                            {
                                                if($vv->status_tagihan==1)
                                                {
                                                    if($vv->sisa_bayar>0)
                                                        $pi+=$vv->sisa_bayar;  
                                                }
                                            }
                                            $subtotal[$k][$no]=$pi;
                                        $piu='';
                                    }
                                    else
                                        $piu='';

                                    $row_total+=$pi;
                                    echo '<td class="text-right">'.number_format($pi,0,',','.').'</td>';
                                }
                            }
                            else
                            {
                                foreach($tag_jenis as $k=>$v)
                                {
                                    echo '<td class="text-right">0</td>';
                                }
                                $row_total+=0;
                            }
                            echo '<td class="text-right">'.number_format($row_total,0,',','.').'</td>';
                            echo '</tr>';

                            $no++;
                        }
                        ?>
                        </tbody>
						<thead>
							<tr>
								<th class="center"></th>
								<th class="center"></th>
                                <?php
                                $grand_total=0;
                                foreach($tag_jenis as $k => $v)
                                {
                                ?>
								    <th class="text-right"><?=number_format(array_sum($subtotal[$k]),0,',','.')?></th>
                                <?php    
                                    $grand_total+=array_sum($subtotal[$k]);
                                }
                                ?>
								<th class="text-right"><?=number_format($grand_total,0,',','.')?></th>
								
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</form>

	</div><!-- /.col -->
</div>
<style>
hr{

	margin-top: 5px !important;
    margin-bottom: 5px !important;
    border: 0;
    border-top: 1px solid #eee;
}
    th,td
    {
        font-size:11px !important;
    }
</style>