<table id="simple-table" class="table table-striped table-bordered table-hover">
	<thead>
		<tr>
			<th class="center">No</th>
			<th>Jenis Pengeluaran</th>
			<th>Kategori</th>
			<th>Jumlah</th>
			<th>Kode Akun</th>
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
			<td style="text-align:center"><?=$no;?></td>
			<td style="text-align:left"><?=$v->jenis;?></td>
			<td style="text-align:left"><?=($v->kategori);?></td>
			<td style="text-align:right"><?=number_format($v->jumlah);?></td>
			<td style="text-align:left"><?=($v->kodeakun);?></td>
			<td style="text-align:center">
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
		$no++;
	}
	?>
	</tbody>
</table>