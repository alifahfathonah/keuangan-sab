<div class="tabbable">
	<ul class="nav nav-tabs" id="myTab">
	<?php
	// $kodeakun=($kodeakun==null ? 1 : $kodeakun);
	$cls='active';
	foreach ($d[0] as $k => $v) 
	{

		echo '<li class="'.$cls.'"><a href="#'.$v->kode_akun.'" data-toggle="tab">'.$v->kode_akun.'-'.$v->nama_akun.'</a></li>';
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
	foreach ($d[0] as $k => $v) 
	{

		// echo '<li class="'.$cls.'"><a href="#'.$v->kode_akun.'" data-toggle="tab">'.$v->kode_akun.'-'.$v->nama_akun.'</a></li>';
								# code...
		// $ix++;
	
	?>
		<div id="<?=$v->kode_akun?>" class="tab-pane fade in <?=$cls?>">
			<table class="table table-bordered table-hovered" style="width:100%;">
				<thead>
					<tr>
						<th style="text-align:center">Kode Akun</th>
						<th style="text-align:center">Kode Akun Aletrnatif</th>
						<th style="text-align:center">Nama Akun</th>
						<th style="text-align:center">Action</th>
					</tr>	
				</thead>
				<tbody>
				<?php
				if(isset($d[$v->kode_akun]))
				{

					if(count($d[$v->kode_akun])!=0)
					{
						// for($i=0;$i<count($d);$i++)
						$de=substr($v->kode_akun, 0,1);
						foreach ($da[$de] as $kk => $vv) {
							$pad=strlen(strtok($vv->kode_akun,'0'));
							echo '<tr>
							<td style="text-align:left;padding-left:'.($pad*12).'px !important;">'.($vv->kode_akun).'</td>
							<td style="text-align:center;width:100px">'.($vv->akun_alternatif).'</td>
							<td style="text-align:left;padding-left:'.($pad*12).'px !important">'.$vv->nama_akun.'</td>
							<td style="text-align:center">
							<a class="btn btn-info  btn-minier" href="#" onclick="edit(\''.$vv->kode_akun.'\')">
							<i class="fa fa-pencil"></i>  	                                            
							</a>
							<a class="btn btn-success  btn-minier" href="#" onclick="addakun(\''.$vv->kode_akun.'\')">
							<i class="glyphicon glyphicon-plus"></i>  	                                            
							</a>
							<button class="btn btn-danger btn-minier" type="button" onclick="hapus(\''.$vv->id.'\')">
							<i class="fa fa-trash"></i>
							</button>
							</td>
							</tr>';
						}
					}
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