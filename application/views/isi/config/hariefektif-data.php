<table id="hariefektif" class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th class="center" rowspan="2">Bulan</th>
						<th class="center" rowspan="2">Level Program</th>
						<th class="center" colspan="2">Jumlah Hari</th>
						<th class="center" rowspan="2">
							<button class="btn btn-xs btn-success" onclick="edithe('<?=date('n')?>','<?=date('Y')?>','-1')">
								<i class="fa fa-plus-square" style="cursor:pointer;" ></i>
							</button>
						</th>
					</tr>
					<tr>
						<th class="center">Catering</th>
						<th class="center">Jemputan</th>
					</tr>
				</thead>
				<tbody>

		<?php
		for($i=1;$i<=12;$i++)
		{
			$edit='';
			$hapus='';
			if(isset($dt[$tahun][$i]))
			{
				$level=$jlh_catering=$jlh_jemputan='';
				$icon='';
				foreach($dt[$tahun][$i] as $k =>$vv)
				{			
					foreach($vv as $kk =>$v)
					{
						$jlh_catering.=$dhe[$tahun][$i][$k]['catering'].' Hari<br>';
						$jlh_jemputan.=$dhe[$tahun][$i][$k]['jemputan'].' Hari<br>';
						$level.=$v->program.' : '.$v->level.'<br>';
						$levl=$v->program.'__'.$v->level;
						$edit='<i class="fa fa-edit blue" style="cursor:pointer;" onclick="edithe(\''.$i.'\',\''.$tahun.'\',\''.$levl.'\')"></i>';
						//$hapus='<i class="fa fa-trash red"  style="cursor:pointer;" onclick="hapushe(\''.$i.'\',\''.$tahun.'\',\''.$levl.'\')"></i>';
						$icon.=$edit.'<br>';
					}
				}
			}
			else
			{
				$level='';
				$jlh_catering=$jlh_jemputan='';
				$levl='';
				$edit='<i class="fa fa-edit blue" style="cursor:pointer;" onclick="edithe(\''.$i.'\',\''.$tahun.'\',\''.$levl.'\')"></i>';
				// $hapus='<i class="fa fa-trash red"  style="cursor:pointer;" onclick="hapushe(\''.$i.'\',\''.$tahun.'\',\''.$levl.'\')"></i>';
				$icon=$edit;
			}

			if($jlh_catering=='')
				$jlh_catering='';
				
			if($jlh_jemputan=='')
				$jlh_jemputan='';


				echo '<tr>
							<td class="blue">'.getBulanSingkat($i).' '.$tahun.'</td>
							<td style="text-align:level" class="blue">'.$level.'</td>
							<td style="text-align:center" class="green">'.$jlh_catering.'</td>
							<td style="text-align:center" class="green">'.$jlh_jemputan.'</td>
							<td style="text-align:center">
								'.$icon.'
							</td>
						</tr>';
			// else
				// print_r($he);
		}
		?>
		</tbody>
</table>
