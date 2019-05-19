<form class="form-horizontal" id="datakeluarga_wali" role="form" action="<?=site_url()?>siswa/simpandatakeluarga/<?=$jns?>/<?=$id?>" method="POST">
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Nama wali </label>

		<div class="col-sm-9">
			<input type="text" id="nis" placeholder="Nama Wali" name="nama_wali" class="col-xs-10 col-sm-7" value="<?=($id!=-1 ? $dd[0]->nama_wali : '')?>"/>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> No KTP wali </label>

		<div class="col-sm-9">
			<input type="text" id="ktp_wali" placeholder="No KTP" name="ktp_wali" class="col-xs-10 col-sm-7" value="<?=($id!=-1 ? $dd[0]->ktp_wali : '')?>"/>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> No HP wali </label>

		<div class="col-sm-9">
			<input type="text" id="hp_wali" placeholder="No HP wali" name="hp_wali" class="col-xs-10 col-sm-7"  value="<?=($id!=-1 ? $dd[0]->hp_wali : '')?>"/>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Email wali </label>

		<div class="col-sm-9">
			<input type="text" id="email_wali" name="email_wali" placeholder="Email wali" class="col-xs-10 col-sm-7" value="<?=($id!=-1 ? $dd[0]->email_wali : '')?>" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Hubungan Keluarga </label>

		<div class="col-sm-9">
			<input type="text" id="hub_wali_dengan_murid" name="hub_wali_dengan_murid" placeholder="Hubungan Keluarga" class="col-xs-10 col-sm-7" value="<?=($id!=-1 ? $dd[0]->hub_wali_dengan_murid : '')?>" />
		</div>
	</div>

	
</form>