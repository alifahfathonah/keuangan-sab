<table id="tablepotongan" class="table table-striped table-bordered table-hover" style="width:100%">
	<thead>
		<tr>
			<th class="center">No</th>
			<th>Jenis Tagihan</th>
			<th>Wajib Bayar</th>
			<th>Tanggal Bayar</th>
			<th>Sisa Bayar</th>
			<th>Edit Nominal</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
    <?php
    $no=1;
    foreach($tagihan as $jns=>$v)
    {
    ?>
        <tr>
            <td class="text-center"><?=$no?></td>
            <td class="text-left"><?=$v->jenis?></td>
            <td class="text-right"><?=number_format($v->wajib_bayar,0,',','.')?></td>
            <td class="text-right"></td>
            <td class="text-right"><?=number_format($v->sisa_bayar,0,',','.')?></td>
            <td class="text-right"><input type="text" name="editnominal" id="editnominal" class="form-control text-right"></td>

            <td class="text-center">
                <a href="javascript:editdu('<?=$v->id_tagihan?>','<?=$tahunajaran_o?>','<?=$nis_o?>')" class="btn btn-xs btn-success"><i class="fa fa-save"></i></a>
                <a href="javascript:hapusdu('<?=$v->id_tagihan?>','<?=$tahunajaran_o?>','<?=$nis_o?>')" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>
            </td>
        </tr>    
    <?php
            $no++;
    }
    ?>
    </tbody>
</table>