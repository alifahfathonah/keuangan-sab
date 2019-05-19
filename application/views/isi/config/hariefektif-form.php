<form class="form-horizontal" role="form" id="simpanhariefektif">
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Bulan </label>

		<div class="col-sm-5">
			<select name="bulan" id="bulan" class="col-xs-12 col-sm-8" data-rel="chosen">
				<option value=""></option>
				<?php
				for ($i=1; $i<= 12 ; $i++)
				{
					if($bulan==$i)
						echo '<option selected="selected" value="'.$bulan.'">'.getBulan($bulan).'</option>';
					else
						echo '<option value="'.$i.'">'.getBulan($i).'</option>';
				}
				?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tahun </label>

		<div class="col-sm-5">
			<select name="tahun" id="tahun" class="col-xs-12 col-sm-8" data-rel="chosen">
				<option value=""></option>
				<?php
				for ($i=(date('Y')-5); $i<= (date('Y')+1) ; $i++)
				{
					if($tahun==$i)
						echo '<option selected="selected" value="'.$i.'">'.($i).'</option>';
					else
						echo '<option value="'.$i.'">'.($i).'</option>';
				}
				?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Level Program </label>

		<div class="col-sm-5">
			<select name="level_program" id="level_program" class="col-xs-12 col-sm-8" data-rel="chosen">
				<option value=""></option>
				<?php
				$level=array(
						'PS' => array('PG','TKA','TKB'),
						'SD' => array('Kelas 1','Kelas 2','Kelas 3','Kelas 4','Kelas 5','Kelas 6'),
						'SM' => array('Kelas 7','Kelas 8','Kelas 9')
				);
				foreach ($level as $k => $v)
				{
					echo '<optgroup label="'.$k.'">';
					foreach ($v as $kk => $vv)
					{
						if(count($det)!=0)
						{
							if($k==$det[0]->program && $vv==$det[0]->level)
								echo '<option value="'.$det[0]->program.'__'.$det[0]->level.'" selected="selected">'.$vv.'</option>';
							else
								echo '<option value="'.$k.'__'.$vv.'">'.$vv.'</option>';
						}
						else
						{
							if($k==$pro && $vv==$lv)
								echo '<option value="'.$pro.'__'.$lv.'" selected="selected">'.$vv.'</option>';
							else
								echo '<option value="'.$k.'__'.$vv.'">'.$vv.'</option>';
						}
					}
					echo '</optgroup>';
				}
				?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Jumlah Hari Catering</label>

		<div class="col-sm-2">
			<input type="text" id="jumlah_hari" name="jumlah_hari" placeholder="Jumlah Hari" class="col-xs-12 col-sm-12" value="<?=($tahun!=-1 ? ($d) : '')?>"/>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Jumlah Hari Jemputan</label>

		<div class="col-sm-2">
			<input type="text" id="jumlah_hari_jemputan" name="jumlah_hari_jemputan" placeholder="Jumlah Hari" class="col-xs-12 col-sm-12" value="<?=($tahun!=-1 ? ($d_jemputan) : '')?>"/>
		</div>
	</div>
	


	<div class="hr hr-24"></div>
</form>
