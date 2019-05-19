<table id="simple-table" class="table table-striped table-bordered table-hover">
	<thead>
		<tr>
			<!-- <th class="center">No</th> -->
			<th>Level Kelas</th>
			<th>Nama Kelas</th>
			<th>Kategori</th>
			<th>Kapasitas</th>
			<th></th>
		</tr>
	</thead>

	<tbody>
	<?php
	$no=1;
	foreach ($d->result() as $k => $v) 
	{
	?>
		<tr>
			<!--<td style="text-align:center"></td>-->
			<td style="text-align:center;width:100px"><?=$v->level;?></td>
			<td style="text-align:left"><?=($v->nama_level);?></td>
			<td style="text-align:center"><?=(strtoupper($v->kategori))?></td>
			<td style="text-align:center"><?=number_format($v->kapasitas);?></td>
			<td style="text-align:center">
				<button class="btn btn-primary btn-minier" type="button" onclick="edit('<?=$v->id_level?>')">
					<i class="fa fa-pencil"></i>
				</button>				
				<button class="btn btn-danger btn-minier" type="button" onclick="hapus('<?=$v->id_level?>')">
					<i class="fa fa-trash"></i>
				</button>
			</td>
		</tr>
	<?php
		$no++;
	}
	?>
	</tbody>
</table>