<div class="tabbable">
	<ul class="nav nav-tabs" id="myTab">
	<?php
	// $kodeakun=($kodeakun==null ? 1 : $kodeakun);
	$cls='active';
	foreach ($jenis[0] as $k => $v) 
	{
		list($idj,$jns)=explode('__', $v);
		echo '<li class="'.$cls.'"><a href="#'.str_replace(' ', '', $jns).'" data-toggle="tab">'.$jns.'</a></li>';
		$cls='';						# code...
		// $ix++;
	}
	?>
		<!-- <li class="active">
			<a data-toggle="tab" href="#home">
				Home
			</a>
		</li> -->
	</ul>
	<div class="tab-content">
	<?php
	$cls='active';
	foreach ($jenis[0] as $k => $v) 
	{
		list($idj,$jns)=explode('__', $v);
		$jn=str_replace(' ', '', $jns);
	?>
		<div id="<?=str_replace(' ', '', $jns)?>" class="tab-pane fade in <?=$cls?>">
			<table id="simple-table" class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th class="center">No</th>
						<th>Jenis Penerimaan</th>
						<th>Kategori</th>
						<th>Level</th>
						<th>Jumlah</th>
						<th>Kode Akun</th>
						<th></th>
					</tr>
				</thead>

				<tbody>
				<?php
				$no=1;
				$totaljenisgroup=$this->config->item('totaljenisgroup');
				// echo '<pre>';
				// print_r($totaljenisgroup);
				// echo '</pre>';
				foreach ($d[$jn][0] as $k => $v) 
				{
					if(isset($totaljenisgroup[$v->level][$v->id]))
					{
						$total=array_sum($totaljenisgroup[$v->level][$v->id]);
						// echo '<pre>';
						// print_r($totaljenisgroup[$v->level][$v->id]);
						// echo '</pre>';
						// $total=0;
					}
					else
					{
						// if($v->jumlah)
						$total=$v->jumlah;
					}
					// $total=sum_array($totaljenisgroup[$vv->level][$vv->id_parent]);
					
				?>
					<tr>
						<td style="text-align:center;font-weight: bold;color:red;font-size: 15px !important;"><?=$no;?></td>
						<td style="text-align:left;font-weight: bold;color:red;font-size: 15px !important;"><?=$v->jenis;?></td>
						<td style="text-align:left;font-weight: bold;color:red;font-size: 15px !important;"><?=($v->kategori);?></td>
						<td style="text-align:center;font-weight: bold;color:red;font-size: 12px !important;"><?=strtoupper(str_replace('_', '-', $v->level));?></td>
						<td style="text-align:right;font-weight: bold;color:red;font-size: 15px !important;"><?=number_format($total);?></td>
						<td style="text-align:left;font-weight: bold;color:red;font-size: 15px !important;"><?=($v->kodeakun);?></td>
						<td style="text-align:right;width:100px !important">
							<a class="btn btn-info  btn-minier" href="#" onclick="edit(<?=$v->id?>)">
								<i class="fa fa-pencil"></i>  	                                            
							</a>
							<a class="btn btn-success  btn-minier" href="#" onclick="addjenis(<?=$v->id?>)">
								<i class="glyphicon glyphicon-plus"></i>  	                                            
							</a>
							<button class="btn btn-danger btn-minier" type="button" onclick="hapus(<?=$v->id?>)">
								<i class="fa fa-trash"></i>
							</button>
						</td>
					</tr>
				<?php
					if(isset($ddd[$v->id]))
					{	
						$sub='a';

						foreach ($ddd[$v->id] as $kv => $vv) 
						{
							# code...


				?>
						<tr>
							<td style="text-align:right"><?=$sub;?></td>
							<td style="text-align:left;padding-left:20px;" class="blue"><?=$vv->jenis;?></td>
							<td style="text-align:left" class="blue"><?=($vv->kategori);?></td>
							<td style="text-align:center;font-size: 12px !important;" class="blue"><?=strtoupper(str_replace('_', '-', $vv->level));?></td>
							<td style="text-align:right" class="blue"><?=number_format($vv->jumlah);?></td>
							<td style="text-align:left" class="blue"><?=($vv->kodeakun);?></td>
							<td style="text-align:right">
								<a class="btn btn-info  btn-minier" href="#" onclick="edit(<?=$vv->id?>)">
									<i class="fa fa-pencil"></i>  	                                            
								</a>
								<!-- <a class="btn btn-success  btn-minier" href="#" onclick="addjenis(<?=$vv->id?>)">
									<i class="glyphicon glyphicon-plus"></i>  	                                            
								</a> -->
								<button class="btn btn-danger btn-minier" type="button" onclick="hapus(<?=$vv->id?>)">
									<i class="fa fa-trash"></i>
								</button>
							</td>
						</tr>
				<?php	
							$sub++;
						}
					}
					
					
					$no++;
				}
				?>
				</tbody>
			</table>
		</div>
	<?php
		$cls='';
	}
	?>
	</div>
</div>

