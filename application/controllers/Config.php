<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once('Main.php');
class Config extends Main {

	public function index()
	{
		// $data['d']=$this->load->view('index.html');
		$data=array(
			'title' => 'Config ',
			'isi' => 'isi/siswa/index',
			'navbar' => 'layout/navbar',
			'footer' => 'layout/footer'
		);
		$this->load->view('index',$data);
	}
//-----------------------------------------------------------------------
//---------- Jarak jemputan ---------------------------------

	public function jarakjemputan()
	{
		// $data['d']=$this->load->view('index.html');
		$data=array(
			'title' => 'Config : Jarak Jemputan',
			'isi' => 'isi/config/jarak-index',
			'navbar' => 'layout/navbar',
			'footer' => 'layout/footer'
		);
		$this->load->view('index',$data);
	}
	function jarakdata()
	{
		$d=$this->db->from('t_jarak_jemputan')->where('status_tampil','t')->order_by('jarak')->get();
		$data['d']=$d;
		$this->load->view('isi/config/jarak-data',$data);
	}
	function jarakform($id=-1)
	{
		if($id!=-1)
		{
			$d=$this->db->from('t_jarak_jemputan')->where('id_jarak',$id)->get();
			$data['d']=$d;
		}
		$data['id']=$id;
		$this->load->view('isi/config/jarak-form',$data);
	}
	function jarakproses($id=-1)
	{
		if(!empty($_POST))
		{
			// print_r($_POST);
			$data['jarak']=$jarak=str_replace(',', '', $_POST['jarak']);
			$data['biaya']=$tarif=str_replace(',', '', $_POST['tarif']);
			$data['jarakpp']=$jarak*40;
			$data['status_tampil']='t';

			if($id!=-1)
			{
				$this->db->where('id_jarak',$id);
				$c=$this->db->update('t_jarak_jemputan',$data);

				if($c)
					echo 'Data Jarak Jemputan Berhasil Di Edit';
				else
					echo 'Data Jarak Jemputan Gagal Di Edit';

			}
			else
			{
				$c=$this->db->insert('t_jarak_jemputan',$data);

				if($c)
					echo 'Data Jarak Jemputan Berhasil Di Simpan';
				else
					echo 'Data Jarak Jemputan Gagal Di Simpan';
			}
		}
		else
			echo 'Data Jarak Jemputan Gagal Di Simpan';
	}
	function jarakhapus($id)
	{
		$this->db->query('update t_jarak_jemputan set status_tampil="f" where id_jarak="'.$id.'"');
		echo 'Data Jarak Jemputan Berhasil Di Hapus';
	}
//-----------------------------------------------------------------------
//---------------Club
	public function club()
	{
		// $data['d']=$this->load->view('index.html');
		$data=array(
			'title' => 'Config : Data Club',
			'isi' => 'isi/config/club-index',
			'navbar' => 'layout/navbar',
			'footer' => 'layout/footer'
		);
		$this->load->view('index',$data);
	}
	function clubdata()
	{
		$d=$this->db->from('t_club')->where('status_tampil','t')->order_by('nama_club')->get();
		$data['d']=$d;
		$this->load->view('isi/config/club-data',$data);
	}
	function clubform($id=-1)
	{
		if($id!=-1)
		{
			$d=$this->db->from('t_club')->where('id_club',$id)->get();
			$data['d']=$d;
		}
		$data['id']=$id;
		$this->load->view('isi/config/club-form',$data);
	}
	function clubproses($id=-1)
	{
		if(!empty($_POST))
		{
			// print_r($_POST);
			$data['nama_club']=$_POST['nama_club'];
			$data['penanggung_jawab']=$_POST['penanggung_jawab'];
			$data['hari']=$_POST['hari'];
			$data['waktu']=$_POST['waktu'];
			$data['biaya']=str_replace(',', '', $_POST['biaya']);
			$data['telp_pj']=$_POST['telp_pj'];
			$data['email_pj']=$_POST['email_pj'];
			$data['status_tampil']='t';

			if($id!=-1)
			{
				$this->db->where('id_club',$id);
				$c=$this->db->update('t_club',$data);

				if($c)
					echo 'Data Club Berhasil Di Edit';
				else
					echo 'Data Club Gagal Di Edit';

			}
			else
			{
				$c=$this->db->insert('t_club',$data);

				if($c)
					echo 'Data Club Berhasil Di Simpan';
				else
					echo 'Data Club Gagal Di Simpan';
			}
		}
		else
			echo 'Data Club Gagal Di Simpan';
	}
	function clubhapus($id)
	{
		$this->db->query('update t_club set status_tampil="f" where id_club="'.$id.'"');
		echo 'Data Club Berhasil Di Hapus';
	}
//-----------------------------------------------------------------------

//---------------Bank
	public function bank()
	{
		// $data['d']=$this->load->view('index.html');
		$data=array(
			'title' => 'Config',
			'isi' => 'isi/config/bank-index',
			'navbar' => 'layout/navbar',
			'footer' => 'layout/footer'
		);
		$this->load->view('index',$data);
	}
	function bankdata()
	{
		$d=$this->db->from('t_bank')->where('status_tampil','t')->order_by('nama_bank')->get();
		$data['d']=$d;
		$this->load->view('isi/config/bank-data',$data);
	}
	function bankform($id=-1)
	{
		if($id!=-1)
		{
			$d=$this->db->from('t_bank')->where('id_bank',$id)->get();
			$data['d']=$d;
		}
		$data['id']=$id;
		$this->load->view('isi/config/bank-form',$data);
	}
	function bankproses($id=-1)
	{
		if(!empty($_POST))
		{
			// print_r($_POST);
			$data=$_POST;
			$data['status_tampil']='t';
			$data['saldo']=str_replace(',','',$_POST['saldo']);
			// $data['kode_akun']=$data['kodeakun'];
			if($id!=-1)
			{
				// unset($data['id_bank']);
				$this->db->where('id_bank',$id);
				$c=$this->db->update('t_bank',$data);

				if($c)
					echo 'Data Bank Berhasil Di Edit';
				else
					echo 'Data Bank Gagal Di Edit';

				$rekkoran['id_bank']=$id;
				$rekkoran['nama_bank']=$data['nama_bank'];
				$rekkoran['tanggal']=date('Y-m-d H:i:s');
				$rekkoran['kat']='masuk';
				// $rekkoran['kode_akun']=$data['kode_akun'];
				$rekkoran['keterangan']='Update Saldo Bank';
				$rekkoran['jumlah']=$data['saldo'];
				$rekkoran['status_tampil']='t';
				$this->db->insert('t_bank_rekening_koran',$rekkoran);

			}
			else
			{
				$c=$this->db->insert('t_bank',$data);

				if($c)
					echo 'Data Bank Berhasil Di Simpan';
				else
					echo 'Data Bank Gagal Di Simpan';
				$idref=$this->db->insert_id();

				$rekkoran['id_bank']=$idref;
				$rekkoran['nama_bank']=$data['nama_bank'];
				$rekkoran['tanggal']=date('Y-m-d H:i:s');
				$rekkoran['kat']='masuk';
				$rekkoran['keterangan']='Input Saldo Awal';
				$rekkoran['jumlah']=$data['saldo'];
				$rekkoran['status_tampil']='t';
				$this->db->insert('t_bank_rekening_koran',$rekkoran);
			}
		}
		else
			echo 'Data Bank Gagal Di Simpan';
	}
	function bankhapus($id)
	{
		$this->db->query('update t_bank set status_tampil="f" where id_bank="'.$id.'"');
		echo 'Data Bank Berhasil Di Hapus';
	}

	//---------------Guru
	public function guru()
	{
		// $data['d']=$this->load->view('index.html');
		$data=array(
			'title' => 'Config',
			'isi' => 'isi/config/guru-index',
			'navbar' => 'layout/navbar',
			'footer' => 'layout/footer'
		);
		$this->load->view('index',$data);
	}
	function gurudata()
	{
		$d=$this->db->from('t_guru')->where('status_tampil','t')->order_by('nama_guru')->get();
		$data['d']=$d;
		$this->load->view('isi/config/guru-data',$data);
	}
	function guruform($id=-1)
	{
		if($id!=-1)
		{
			$d=$this->db->from('t_guru')->where('id_guru',$id)->get();
			$data['d']=$d;
		}
		$data['id']=$id;
		$this->load->view('isi/config/guru-form',$data);
	}
	function guruproses($id=-1)
	{
		if(!empty($_POST))
		{
			// print_r($_POST);
			$data=$_POST;
			$data['status_tampil']='t';

			if($id!=-1)
			{
				// unset($data['id_bank']);
				$this->db->where('id_guru',$id);
				$c=$this->db->update('t_guru',$data);

				if($c)
					echo 'Data Guru Berhasil Di Edit';
				else
					echo 'Data Guru Gagal Di Edit';

			}
			else
			{
				$c=$this->db->insert('t_guru',$data);

				if($c)
					echo 'Data Guru Berhasil Di Simpan';
				else
					echo 'Data Guru Gagal Di Simpan';
			}
		}
		else
			echo 'Data Guru Gagal Di Simpan';
	}
	function guruhapus($id)
	{
		$this->db->query('update t_guru set status_tampil="f" where id_guru="'.$id.'"');
		echo 'Data Guru Berhasil Di Hapus';
	}
//-----------------------------------------------------------------------

//---------------Catering
	public function catering()
	{
		// $data['d']=$this->load->view('index.html');
		$data=array(
			'title' => 'Config : Data Vendor Catering',
			'isi' => 'isi/config/catering-index',
			'navbar' => 'layout/navbar',
			'footer' => 'layout/footer'
		);
		$this->load->view('index',$data);
	}
	function cateringdata()
	{
		$d=$this->db->from('t_catering')->where('status_tampil','t')->order_by('nama_catering')->get();
		$data['d']=$d;
		$this->load->view('isi/config/catering-data',$data);
	}
	function cateringform($id=-1)
	{
		if($id!=-1)
		{
			$d=$this->db->from('t_catering')->where('id_catering',$id)->get();
			$data['d']=$d;
		}
		$data['id']=$id;
		$this->load->view('isi/config/catering-form',$data);
	}
	function cateringproses($id=-1)
	{
		if(!empty($_POST))
		{
			// print_r($_POST);
			$data=$_POST;
			$data['status_tampil']='t';

			if($id!=-1)
			{
				unset($data['id']);
				$this->db->where('id_catering',$id);
				$c=$this->db->update('t_catering',$data);

				if($c)
					echo 'Data Vendor Catering Berhasil Di Edit';
				else
					echo 'Data Vendir Catering Gagal Di Edit';

			}
			else
			{
				$c=$this->db->insert('t_catering',$data);

				if($c)
					echo 'Data Vendor Catering Berhasil Di Simpan';
				else
					echo 'Data Vendir Catering Gagal Di Simpan';
			}
		}
		else
			echo 'Data Vendor Catering Gagal Di Simpan';
	}
	function cateringhapus($id)
	{
		$this->db->query('update t_catering set status_tampil="f" where id_catering="'.$id.'"');
		echo 'Data Vendor Catering Berhasil Di Hapus';
	}
//-----------------------------------------------------------------------
//---------------Club
	public function supir()
	{
		// $data['d']=$this->load->view('index.html');
		$data=array(
			'title' => 'Config : Data Supir',
			'isi' => 'isi/config/supir-index',
			'navbar' => 'layout/navbar',
			'footer' => 'layout/footer'
		);
		$this->load->view('index',$data);
	}
	function supirdata()
	{
		$d=$this->db->from('t_supir')->where('status_tampil','t')->order_by('nama_supir')->get();
		$data['d']=$d;
		$this->load->view('isi/config/supir-data',$data);
	}
	function supirform($id=-1)
	{
		if($id!=-1)
		{
			$d=$this->db->from('t_supir')->where('id_supir',$id)->get();
			$data['d']=$d;
		}
		$data['id']=$id;
		$this->load->view('isi/config/supir-form',$data);
	}
	function supirproses($id=-1)
	{
		if(!empty($_POST))
		{
			// print_r($_POST);
			$data['nama_supir']=$_POST['nama_supir'];
			$data['alamat']=$_POST['alamat'];
			$data['telp']=$_POST['telp'];
			$data['email']=$_POST['email'];
			$data['jenis_mobil']=$_POST['jenis_mobil'];
			$data['no_plat']=$_POST['no_plat'];
			$data['status_tampil']='t';

			if($id!=-1)
			{
				$this->db->where('id_supir',$id);
				$c=$this->db->update('t_supir',$data);

				if($c)
					echo 'Data Supir Berhasil Di Edit';
				else
					echo 'Data Supir Gagal Di Edit';

			}
			else
			{
				$c=$this->db->insert('t_supir',$data);

				if($c)
					echo 'Data Supir Berhasil Di Simpan';
				else
					echo 'Data Supir Gagal Di Simpan';
			}
		}
		else
			echo 'Data Supir Gagal Di Simpan';
	}
	function supirhapus($id)
	{
		$this->db->query('update t_supir set status_tampil="f" where id_supir="'.$id.'"');
		echo 'Data Supir Berhasil Di Hapus';
	}
//-----------------------------------------------------------------------

//-----------------------------------------------------------------------
//---------------User
	public function user()
	{
		// $data['d']=$this->load->view('index.html');
		$data=array(
			'title' => 'Config : Data User',
			'isi' => 'isi/config/user-index',
			'navbar' => 'layout/navbar',
			'footer' => 'layout/footer'
		);
		$this->load->view('index',$data);
	}
	function userdata()
	{
		$d=$this->db->from('t_user')->where('status_tampil','t')->order_by('nama_user')->get();
		$data['d']=$d;
		$this->load->view('isi/config/user-data',$data);
	}
	function userform($id=-1)
	{
		if($id!=-1)
		{
			$d=$this->db->from('t_user')->where('id_user',$id)->get();
			$data['d']=$d;
		}
		$data['id']=$id;
		$this->load->view('isi/config/user-form',$data);
	}
	function userproses($id=-1)
	{
		if(!empty($_POST))
		{
			// print_r($_POST);
			$data['nama_user']=$_POST['nama_user'];
			$data['alamat']=$_POST['alamat'];
			$data['telp']=$_POST['telp'];
			$data['email']=$_POST['email'];
			$data['username']=$_POST['username'];
			$data['password']=sha1(md5($_POST['password']));
			$data['id_level']=$_POST['id_level'];
			$data['status_tampil']='t';

			if($id!=-1)
			{
				// $cc=$this->db->from('t_user')->where('id_user',$id)->get();
				if($_POST['password']=='')
					unset($data['password']);
					// $data['password']=$cc->row('password');

				$this->db->where('id_user',$id);
				$c=$this->db->update('t_user',$data);

				if($c)
					echo 'Data User Berhasil Di Edit';
				else
					echo 'Data User Gagal Di Edit';

			}
			else
			{
				$c=$this->db->insert('t_user',$data);

				if($c)
					echo 'Data User Berhasil Di Simpan';
				else
					echo 'Data User Gagal Di Simpan';
			}
		}
		else
			echo 'Data User Gagal Di Simpan';
	}
	function userhapus($id)
	{
		$this->db->query('update t_user set status_tampil="f" where id_user="'.$id.'"');
		echo 'Data User	 Berhasil Di Hapus';
	}
//-----------------------------------------------------------------------

//---------------Akun
	public function akun()
	{
		// $data['d']=$this->load->view('index.html');
		$data=array(
			'title' => 'Config : Data Kode Akun',
			'isi' => 'isi/config/akun-index',
			'navbar' => 'layout/navbar',
			'footer' => 'layout/footer'
		);
		$this->load->view('index',$data);
	}
	function akundata()
	{
		// $data['data']=$this->db->query('select * from t_kode_akun where id_parent=0 and status_tampil="t" order by kode_akun')
		$d=$this->db->from('t_akun')->where('status_tampil','t')->order_by('kode_akun')->get();
		$akun=array();
		foreach ($d->result() as $k => $v) {
			if(strpos($v->kode_akun,'0000')!==false)
			{
				$akun[$v->id_parent][$v->kode_akun]=$v;
			}
			else
			{
				$parent=strtok($v->kode_akun,'0');
				// echo $parent.'-';
				$ln=strlen($parent);
				if($ln==2)
					$idp=substr($parent,0,1).'0000';
				else if($ln==3)
					$idp=substr($parent,0,2).'000';
				else if($ln==4)
					$idp=substr($parent,0,3).'00';
				else if($ln==5)
					$idp=substr($parent,0,4).'0';
				else
					$idp=$parent;
				
				// echo $v->kode_akun.'-'.$ln.'-';
				// echo $idp.'<br>';
				$akun[$idp][$v->kode_akun]=$v;
			}
			$dakun[substr($v->kode_akun, 0,1)][$v->kode_akun]=$v;
		}
		$data['d']=$akun;
		$data['da']=$dakun;
		$this->load->view('isi/config/akun-data',$data);
	}
	function akunform($id=-1,$child=null)
	{
		$data['id_parent']=0;
		$data['child']='';
		if($id!=-1)
		{
			$d=$this->db->from('t_akun')->where('kode_akun',$id)->get();
			$data['d']=$d;
			if($child!=null)
			{
				// $ctot=strlen($id);
				$idp=strtok($id, '0');

				// $cidp=strlen($idp);
				// $data['id_parent']=(substr($d->row('id_parent'), 0,($cidp-1))*pow(10,$kali));
				$data['idp']=$idp;
				$data['child']='child';
				$data['id_parent']=$id;
			}
		}
		$data['id']=$id;
		$this->load->view('isi/config/akun-form',$data);
	}
	function akunproses($id=-1)
	{
		if(!empty($_POST))
		{
			// print_r($_POST);
			$data['kode_akun']=$_POST['kode_akun'];
			$data['nama_akun']=$_POST['nama_akun'];
			$data['akun_alternatif']=$_POST['akun_alternatif'];
			$data['id_parent']=$_POST['id_parent'];
			$child=$_POST['child'];
			$data['status_tampil']='t';
			// print_r($_POST);
			if($id!=-1 && $child=='')
			{
				$this->db->where('kode_akun',$id);
				$c=$this->db->update('t_akun',$data);

				if($c)
					echo 'Kode Akun Berhasil Di Edit';
				else
					echo 'Kode Akun Gagal Di Edit';

			}
			else
			{
				$c=$this->db->insert('t_akun',$data);

				if($c)
					echo 'Kode Akun Berhasil Di Simpan';
				else
					echo 'Kode Akun Gagal Di Simpan';
			}
		}
		else
			echo 'Kode Akun Gagal Di Simpan';
	}
	function akunhapus($id)
	{
		$this->db->query('update t_akun set status_tampil="f" where id="'.$id.'"');
		echo 'Kode Akun Berhasil Di Hapus';
	}
	function cekakun($id)
	{
		$cek=$this->db->from('t_akun')->where('kode_akun',$id)->where('status_tampil','t')->get();
		echo count($cek->result());
		// if($cek->num_rows!=0)
			// echo 'Kode Akun Sudah Pernah Diinput';
	}
//-----------------------------------------------------------------------
	public function profil()
	{
		// $data['d']=$this->load->view('index.html');
		$data=array(
			'title' => 'Config : Data Profil',
			'isi' => 'isi/config/profil',
			'navbar' => 'layout/navbar',
			'footer' => 'layout/footer'
		);
		$d=$this->db->from('t_profil')->order_by('id','asc')->get();
		$data['d']=$d;
		$this->load->view('index',$data);
	}

	function profilproses()
	{
		if(!empty($_POST))
		{
			foreach ($_POST as $k => $v)
			{
				if($k!='logo')
				{
					$data['value']=$v;
				}
				else
				{
					$lg=explode('assets', $v);
					$data['value']='/assets/'.$lg[1];
				}
				$this->db->update('t_profil', $data, array('key' => $k));

			}
			$this->session->set_flashdata('pesan','Data Profil Berhasil Di Perbaharui');
			echo 'Data Profil Berhasil Di Perbaharui';
		}
	}

//-----------------------------------------------------------------------
//---------------User
	public function tahunajaran()
	{
		// $data['d']=$this->load->view('index.html');
		$data=array(
			'title' => 'Config : Tahun Ajaran',
			'isi' => 'isi/config/ajaran-index',
			'navbar' => 'layout/navbar',
			'footer' => 'layout/footer'
		);
		$this->load->view('index',$data);
	}
	function ajarandata()
	{
		$d=$this->db->from('t_ajaran')->where('status_tampil','t')->order_by('tahun_ajaran desc')->get();
		$data['d']=$d;
		$this->load->view('isi/config/ajaran-data',$data);
	}
	function ajaranform($id=-1)
	{
		if($id!=-1)
		{
			$d=$this->db->from('t_ajaran')->where('id_ajaran',$id)->get();
			$data['d']=$d;
		}
		$data['id']=$id;
		$this->load->view('isi/config/ajaran-form',$data);
	}
	function ajaranproses($id=-1)
	{
		if(!empty($_POST))
		{
			// print_r($_POST);
			$data=$_POST;
			$data['status_tampil']='t';

			if($id!=-1)
			{
				$this->db->where('id_ajaran',$id);
				$c=$this->db->update('t_ajaran',$data);

				if($c)
					echo 'Data Tahun Ajaran Berhasil Di Edit';
				else
					echo 'Data Tahun Ajaran Gagal Di Edit';

			}
			else
			{
				$c=$this->db->insert('t_ajaran',$data);

				if($c)
					echo 'Data Tahun Ajaran Berhasil Di Simpan';
				else
					echo 'Data Tahun Ajaran Gagal Di Simpan';
			}
		}
		else
			echo 'Data Tahun Ajaran Gagal Di Simpan';
	}
	function ajaranhapus($id)
	{
		$this->db->query('update t_ajaran set status_tampil="f" where id_ajaran="'.$id.'"');
		echo 'Data Tahun Ajaran Berhasil Di Hapus';
	}

	//-------------------------------------------
	function getDaerah($idd,$kat)
	{
		list($id,$nama)=explode('__', str_replace('%20', ' ', $idd));
		$select='<select>';
		$wh=array('idparent'=>''.$id.'','status_tampil','1');
		$kodepos='';
		if($kat=='propinsi')
		{
			$select='<select class="chosen-select" id="kota" name="kota" data-placeholder="Choose a Country..." onchange="getdata(this.value,\'kabupaten\')">
						<option value="">Pilih Kota/Kabupaten</option>';
		}
		else if($kat=='kabupaten')
		{
			$select='<select class="chosen-select" id="kecamatan" name="kecamatan" data-placeholder="Choose a Country..." onchange="getdata(this.value,\'kecamatan\')">
						<option value="">Pilih Kecamatan</option>';
		}
		else if($kat=='kecamatan')
		{
			$select='<select class="chosen-select" id="kelurahan" name="kelurahan" data-placeholder="Choose a Country..." onchange="getdata(this.value,\'kelurahan\')">
						<option value="">Pilih Kelurahan</option>';
		}

		$data=$this->db->from('kelurahan')->where($wh)->order_by('nama','asc')->get()->result();
		if(count($data)!=0)
		{
			$s='';
			foreach ($data as $k => $v)
			{
				if($kat=='kelurahan')
					$kodepos=$v->kodepos.'-';
				$s.='<option value="'.$v->idnama.'__'.str_replace(' ', '%20', $v->nama).'">'.$kodepos.$v->nama.'</option>';
			}

			$select.=$s.'</select>';
		}
		echo $select;
	}
//---------------------------------------------------------------
	function hariefektif($tahun=null,$level=null)
	{
		if($tahun==null)
			$tahun=date('Y');

		$data['program']='';
		$data['levela']='';
		$level=str_replace('%20',' ',$level);

		$he=$this->db->from('t_hari_efektif')->where('status_tampil','t')->where('tahun',$tahun)->get()->result();
		if($level!=null && $level!=-1)
		{
			list($program,$level)=explode('__',$level);
			$he=$this->db->from('t_hari_efektif')
				->where('status_tampil','t')
				->where('tahun',$tahun)
				->where('level',$level)
				->where('program',$program)
				->get()->result();

			$data['program']=$program;
			$data['levela']=$level;
		}
		$dhe=$dt=$lp=$lvl=array();
		if(count($he)!=0)
		{
			foreach ($he as $k => $v)
			{
				$dt[$v->tahun][$v->bulan][$v->level][]=$v;
				$dhe[$v->tahun][$v->bulan][$v->level]['catering']=$v->jumlah_hari_catering;
				$dhe[$v->tahun][$v->bulan][$v->level]['jemputan']=$v->jumlah_hari_jemputan;
				if($v->level!=null)
				{
					$lp[$v->tahun][$v->bulan]=$v->program.' : '.$v->level;
					$lvl[$v->tahun][$v->bulan]=$v->program.'__'.$v->level;
				}
				else
				{

					$lp[$v->tahun][$v->bulan]='__';
					$lvl[$v->tahun][$v->bulan]='';
				}
			}
		}
		$data['dt']=$dt;
		$data['dhe']=$dhe;
		$data['lp']=$lp;
		$data['lvl']=$lvl;
		$data['tahun']=$tahun;
		$this->load->view('isi/config/hariefektif-data',$data);
	}

	function hariefektifform($bulan=-1,$tahun=-1,$level=-1)
	{
		if($bulan==-1)
			$bln=date('n');
		else
			$bln=$bulan;

		if($tahun==-1)
			$thn=date('Y');
		else
			$thn=$tahun;

		$data['tahun']=$thn;
		$data['bulan']=$bln;
		// $data['id']=$id;
		$d=20;
		$d_jemputan=20;
		$wh=array('tahun'=>$thn,'bulan'=>$bln,'status_tampil'=>'t');

		$data['pro']='';
		$data['lv']='';
		if($level!=-1)
		{
			list($program,$levelp)=explode('__',$level);
			$wh=array('tahun'=>$thn,'bulan'=>$bln,'status_tampil'=>'t','level'=>$levelp,'program'=>$program);
			$data['pro']=$program;
			$data['lv']=$levelp;
		}
		$he=$this->db->from('t_hari_efektif')->where($wh)->get()->result();
		if(count($he)!=0)
		{
			$d=$he[0]->jumlah_hari_catering;
			$d_jemputan=$he[0]->jumlah_hari_jemputan;
		}

		$data['d']=$d;
		$data['d_jemputan']=$d_jemputan;
		$data['det']=$he;
		$this->load->view('isi/config/hariefektif-form',$data);
	}

	function hariefektifproses()
	{
		$bulan=$_POST['bulan'];
		$tahun=$_POST['tahun'];
		$jumlah_hari=$_POST['jumlah_hari'];
		list($program,$level)=explode('__',$_POST['level_program']);
		$data=$_POST;
		$data['program']=$program;
		$data['level']=$level;
		$data['jumlah_hari_catering']=$_POST['jumlah_hari'];
		$data['jumlah_hari_jemputan']=$_POST['jumlah_hari_jemputan'];
		unset($data['level_program']);
		$wh=array('bulan'=>$bulan,'tahun'=>$tahun,'level'=>$level,'program'=>$program);
		$data['status_tampil']='t';
		$cek=$this->db->from('t_hari_efektif')->where($wh)->get()->result();
		if(count($cek)==0)
		{
			$x=$this->db->insert('t_hari_efektif',$data);
		}
		else
		{
			$this->db->where($wh);
			$x=$this->db->update('t_hari_efektif',$data);
		}
		if($x)
			echo 'Data Hari Efektif Berhasil Di Edit';
		else
			echo 'Data Hari Efektif Gagal Di Edit';
	}
//---------------------------------------------------------------
	function coba()
	{
		$link='http://www.nomor.net/_kodepos.php?_i=provinsi-kodepos&daerah=&jobs=&perhal=60&urut=&asc=000011111&sby=000000';
		$file=file_get_contents($link);
		file_put_contents('assets/link.txt', $file);
	}
}
