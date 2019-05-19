<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once('Main.php');
class Penerimaan extends Main {

	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('login')!='true')
		{
			redirect('login','location');
		}
	}
	public function index()
	{
		// $data['d']=$this->load->view('index.html');
		$data=array(
			'title' => 'Penerimaan ',
			'isi' => 'isi/penerimaan/index',
			'navbar' => 'layout/navbar',
			'footer' => 'layout/footer'
		);
		$this->load->view('index',$data);
	}
//-----------------------------------------------------------------------
//---------- Jarak jemputan ---------------------------------

	public function jenis()
	{
		// $data['d']=$this->load->view('index.html');
		$data=array(
			'title' => 'Penerimaan',
			'isi' => 'isi/penerimaan/jenis-index',
			'navbar' => 'layout/navbar',
			'footer' => 'layout/footer'
		);
		$this->load->view('index',$data);
	}
	function jenisdata()
	{
		$d=$this->db->from('t_jenis_penerimaan')->where('status_tampil','t')->order_by('jenis asc, level asc')->get();
		$dd=array();
		$jenis=array();
		foreach ($d->result() as $k => $v)
		{
			$jn=str_replace(' ', '', $v->jenis);
			$jenis[$v->id_parent][$v->jenis]=$v->id.'__'.$v->jenis;
			$dd[$jn][$v->id_parent][$v->id]=$v;
			$ddd[$v->id_parent][$v->id]=$v;
		}
		$data['d']=$dd;
		$data['ddd']=$ddd;
		$data['jenis']=$jenis;
		$this->load->view('isi/penerimaan/jenis-data',$data);
	}
	function jenisform($id=-1,$child=null)
	{
		$data['id_parent']=0;
		$data['child']='';
		if($id!=-1)
		{
			$d=$this->db->from('t_jenis_penerimaan')->where('id',$id)->get();
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
		$this->load->view('isi/penerimaan/jenis-form',$data);
	}
	function jenisproses($id=-1)
	{
		if(!empty($_POST))
		{
			// print_r($_POST);
			$data=$_POST;
			$child=$_POST['child'];
			$data['jumlah']=$jarak=str_replace(',', '', $_POST['jumlah']);
			$data['status_tampil']='t';
			unset($data['child']);
			if($id!=-1 && $child=='')
			{
				$this->db->where('id',$id);
				$c=$this->db->update('t_jenis_penerimaan',$data);

				if($c)
					echo 'Data Jenis Penerimaan Berhasil Di Edit';
				else
					echo 'Data Jenis Penerimaan Gagal Di Edit';

			}
			else
			{
				$c=$this->db->insert('t_jenis_penerimaan',$data);

				if($c)
					echo 'Data Jenis Penerimaan Berhasil Di Simpan';
				else
					echo 'Data Jenis Penerimaan Gagal Di Simpan';
			}
		}
		else
			echo 'Data Jenis Penerimaan Gagal Di Simpan';
	}
	function jenishapus($id)
	{
		$this->db->query('update t_jenis_penerimaan set status_tampil="f" where id="'.$id.'"');
		echo 'Data Jenis Penerimaan Berhasil Di Hapus';
	}
//-----------------------------------------------------------------------
	function formtagihan($jenis,$bulan,$tahun,$nis,$id)
	{
		$input_txt='';
		$he=$this->config->item('hari_efektif');
		list($nis,$batch_id)=explode('__', $nis);
		$pnr=$this->db->from('t_jenis_penerimaan')->where('status_tampil','t')->where('id',$id)->get()->result();
		if(count($pnr)!=0)
			$jlh=$pnr[0]->jumlah;
		else
			$jlh=0;


		if(is_array($he))
		{
			if(isset($he[$bulan][$tahun]))
			{
				$dhe=$he[$bulan][$tahun];
				$hari_efektif=$dhe->jumlah_hari;
			}
			else
				$hari_efektif=20;
		}
		else
			$hari_efektif=$he;

		if($jenis=='catering')
		{
			$jlh=$hari_efektif * $jlh;

		}
		else if($jenis=='club')
		{
			$tclub=$this->db->from('t_club')->where('status_tampil','t')->get()->result();
			$dtclub=array();
			foreach ($tclub as $k => $v)
			{
				$dtclub[$v->id_club]=$v;
			}
			$dclub=$this->db->from('t_data_club_siswa')->where('nis',$nis)->or_where('nis',str_replace('_','.',$nis))->where('status_tampil','t')->get()->result();

			if(count($dclub)!=0)
			{
				$in_tx='';
				$getidclub=explode(',', $dclub[0]->id_club);
				// $in_tx='';
				if(count($getidclub)>1)
				{

					foreach ($getidclub as $ki => $vi)
					{
						# code...
						// echo $vi.'-';
						$vv_jumlah=$dtclub[$vi]->biaya;
						$nama_club=$dtclub[$vi]->nama_club;
						$in_tx.='<div style="font-size:9px;">'.$nama_club.'</div><input id="tagih" type="text" name="tagihclub['.$nis.']['.$id.'__'.$jenis.']['.$vi.'__'.str_replace(' ', '_',$nama_club).']" value="'.number_format($vv_jumlah).'" style="text-align:right;background:#f7c8c8;width:90%;float:right;color:black;margin-bottom:2px !important"><br>';
					}
				}
				else
				{

					foreach ($dclub as $kdc => $vdc)
					{
						$idclub=$vdc->id_club;
						$vv_jumlah=$dtclub[$idclub]->biaya;
						$nama_club=$dtclub[$idclub]->nama_club;
						$in_tx.='<div style="font-size:9px;">'.$nama_club.'</div><input id="tagih" type="text" name="tagihclub['.$nis.']['.$id.'__'.$jenis.']['.$idclub.'__'.str_replace(' ', '_',$nama_club).']" value="'.number_format($vv_jumlah).'" style="text-align:right;background:#f7c8c8;width:90%;float:right;color:black;margin-bottom:2px !important"><br>';
						// echo ';';
					}
				}
				// 
				$input_txt=$in_tx;
			}
			else
				$jlh=0;

			$jlh=$hari_efektif * $jlh;
		}
		else if(strpos($jenis,'jemputan')!==false)
		{
			$datajarak=$this->db->from('t_data_jemputan')->where('status_tampil','t')->where('nis',$nis)->get()->result();
			if(count($datajarak)!=0)
			{
				$getjarak=$this->db->from('t_jarak_jemputan')->where('status_tampil','t')->where('jarak',$datajarak[0]->jarak)->get()->result();
				if(count($getjarak)!=0)
				{
					$jarak=$datajarak[0]->jarak;
					$jlh=$getjarak[0]->biaya;
					$jarakstatus=$datajarak[0]->status;
				}
				else
				{
					$jarak=$jlh=0;
					$jarakstatus='';
				}
			}
			else
			{
				$jarak=$jlh=0;
				$jarakstatus='';
			}

			$prsn_jmp=persen_jemputan($hari_efektif,$jarakstatus);
			$jlh = ($prsn_jmp/100) * $jlh;
			$jlh=pembulatan(round( $jlh , -2 ));
		}
		// else if(strcmp($jenis,'jemputan club')==0)
		// {
		// 	$datajarak=$this->db->from('t_data_jemputan')->where('nis',$nis)->get()->result();
		// 	if(count($datajarak)!=0)
		// 	{
		// 		if($datajarak[0]->jemputan_club=='t')
		// 		{
		// 			$getjarak=$this->db->from('t_jarak_jemputan')->where('status_tampil','t')->where('jarak',$datajarak[0]->jarak)->get()->result();
		// 			$jarak=$datajarak[0]->jarak;
		// 			$jlh=$getjarak[0]->biaya;
		// 		}
		// 		else
		// 		{
		// 			$jarak=$jlh=0;
		// 		}
		// 	}
		// 	else
		// 	{
		// 		$jarak=$jlh=0;
		// 	}

		// 	$prsn_jmp=persen_jemputan($hari_efektif,$datajarak[0]->status);
		// 	$jlh = ($prsn_jmp/100) * $jlh;
		// }

		$whtg=array('nis'=>$nis, 'id_jenis_penerimaan'=>$id,'bulan'=>$bulan,'tahun'=>$tahun);
		$cektagihan=$this->db->from('t_tagihan_siswa')->where($whtg)->get()->result();
		// $jnss=strtolower($jenis);
		$jnss2=str_replace(' ', '_', $jenis);
		if(count($cektagihan)!=0)
		{
			echo '<input type="text" name="tagih['.$nis.']['.$id.'__'.$jnss2.']" value="'.number_format($jlh).'" style="text-align:right;background:#ccf7c8;width:90%;float:right;color:black">';
		}
		else
		{
			if($input_txt=='')
				echo '<input type="text" name="tagih['.$nis.']['.$id.'__'.$jnss2.']" value="'.number_format($jlh).'" style="text-align:right;background:#f7c8c8;width:90%;float:right;color:black">';
			else
				echo $input_txt;
		}
	}
	//-----------------------------------------------

	public function datajemputan()
	{
		// $data['d']=$this->load->view('index.html');
		$data=array(
			'title' => 'Penerimaan',
			'isi' => 'isi/penerimaan/jemputan-index',
			'navbar' => 'layout/navbar',
			'footer' => 'layout/footer'
		);
		$this->load->view('index',$data);
	}
	function jemputandata($iddriver=null)
	{
		$iddriver=str_replace('%20', ' ', $iddriver);
		$wh=array('status_tampil'=>'t');
		if($iddriver!=null)
		{
			if($iddriver!='')
			{

				list($idd,$nmd)=explode('__', $iddriver);
				$wh=array('status_tampil'=>'t','id_driver'=>$idd);
			}
		}

		$d=$this->db->from('t_data_jemputan')->where($wh)->order_by('nama_siswa')->get();
		$data['d']=$d;
		$this->load->view('isi/penerimaan/jemputan-data',$data);
	}
	function jemputanform($id=-1)
	{

		$dd=$this->db->from('t_data_jemputan')->where('status_tampil','t')->get();
		$ds=array();
		foreach ($dd->result() as $k => $v)
		{
			$ds[$v->nis]=$v->nis;
		}
		$data['dd']=$ds;
		if($id!=-1)
		{
			$d=$this->db->from('t_data_jemputan')->where('id',$id)->get();
			$data['d']=$d;
		}
		$data['id']=$id;
		$this->load->view('isi/penerimaan/jemputan-form',$data);
	}
	function jemputanproses($id=-1)
	{
		if(!empty($_POST))
		{
			// print_r($_POST);
			//siswadriverjarakketerangan
			$data=$_POST;
			list($id_driver,$nama_driver)=explode('__', $_POST['driver']);
			foreach ($_POST['siswa'] as $ks => $vs)
			{
				list($nis,$nama_siswa)=explode('__', $vs);
				unset($data['siswa']);
				unset($data['driver']);
				$data['jarak']=str_replace(',', '', $data['jarak']);
				$data['nis']=$nis;
				$data['nama_siswa']=$nama_siswa;
				$data['id_driver']=$id_driver;
				$data['nama_driver']=$nama_driver;

				$data['status_tampil']='t';
				if($id!=-1)
				{
					$this->db->where('id',$id);
					$c=$this->db->update('t_data_jemputan',$data);

					if($c)
						$ps='Data Jemputan Siswa Berhasil Di Edit';
					else
						$ps= 'Data Jemputan Siswa Gagal Di Edit';

				}
				else
				{
					$c=$this->db->insert('t_data_jemputan',$data);

					if($c)
						$ps= 'Data Jemputan Siswa Berhasil Di Simpan';
					else
						$ps= 'Data Jemputan Siswa Gagal Di Simpan';
				}
			}
			echo $ps;
		}
		else
			echo 'Data Jemputan Siswa Gagal Di Simpan';
	}
	function jemputanhapus($id)
	{
		$this->db->query('update t_data_jemputan set status_tampil="f" where id="'.$id.'"');
		echo 'Data Jemputan Siswa Berhasil Di Hapus';
	}

	//-----------------------------------------------

	public function dataclub()
	{
		// $data['d']=$this->load->view('index.html');
		$data=array(
			'title' => 'Penerimaan',
			'isi' => 'isi/penerimaan/club-index',
			'navbar' => 'layout/navbar',
			'footer' => 'layout/footer'
		);
		$this->load->view('index',$data);
	}
	function clubdata($idclub=null)
	{
		$idclub=str_replace('%20', ' ', $idclub);
		$wh=array('status_tampil'=>'t');
		if($idclub!=null)
		{
			if($idclub!='')
			{

				list($idd,$nmd)=explode('__', $idclub);
				$wh=('status_tampil ="t" and nama_club like "%'.$nmd.'%"');
			}
		}

		$dd=$this->db->from('t_data_club_siswa')->where($wh)->order_by('nama_siswa')->get();
		// $d=array();
		// foreach ($dd->result() as $k => $v)
		// {
		// 	$d[$v->nis][]=$v;
		// }
		$data['d']=$dd->result();
		$this->load->view('isi/penerimaan/club-data',$data);
	}
	function clubform($id=-1)
	{

		$dd=$this->db->from('t_data_club_siswa')->where('status_tampil','t')->get();
		$ds=array();
		foreach ($dd->result() as $k => $v)
		{
			$ds[$v->nis]=$v->nis;
		}
		$data['dd']=$ds;
		if($id!=-1)
		{
			$d=$this->db->from('t_data_club_siswa')->where('id',$id)->get();
			$data['d']=$d->result();
		}
		$data['id']=$id;
		$this->load->view('isi/penerimaan/club-form',$data);
	}
	function clubproses($id=-1)
	{
		if(!empty($_POST))
		{
			// print_r($_POST);
			//siswadriverjarakketerangan
			$data=$_POST;
			foreach ($_POST['siswa'] as $ks => $vs)
			{
				# code...
				list($nis,$nama_siswa)=explode('__', $vs);
				$idc=$nmc='';
				foreach ($_POST['club'] as $kc => $vc)
				{
					list($id_club,$nama_club)=explode('__', $vc);
					$idc.=$id_club.',';
					$nmc.=$nama_club.',';
				}
				$idc=substr($idc, 0,-1);
				$nmc=substr($nmc, 0,-1);
				unset($data['siswa']);
				unset($data['club']);
				$data['nis']=$nis;
				$data['nama_siswa']=$nama_siswa;
				$data['id_club']=$idc;
				$data['nama_club']=$nmc;

				$data['status_tampil']='t';
				if($id!=-1)
				{
					$this->db->where('id',$id);
					$c=$this->db->update('t_data_club_siswa',$data);

					if($c)
						$ps='Data Club Siswa Berhasil Di Edit';
					else
						$ps='Data Club Siswa Gagal Di Edit';

				}
				else
				{
					$c=$this->db->insert('t_data_club_siswa',$data);

					if($c)
						$ps= 'Data Club Siswa Berhasil Di Simpan';
					else
						$ps= 'Data Club Siswa Gagal Di Simpan';
				}
			}
			echo $ps;
		}
		else
			echo 'Data Club Siswa Gagal Di Simpan';
	}
	function clubhapus($id)
	{
		$this->db->query('update t_data_club_siswa set status_tampil="f" where id="'.$id.'"');
		echo 'Data Club Siswa Berhasil Di Hapus';
	}

	//-----------------------------------------------
	//-----------------------------------------------

	public function pendamping()
	{
		// $data['d']=$this->load->view('index.html');
		$data=array(
			'title' => 'Penerimaan',
			'isi' => 'isi/penerimaan/pendamping-index',
			'navbar' => 'layout/navbar',
			'footer' => 'layout/footer'
		);
		$this->load->view('index',$data);
	}
	function pendampingdata($idpendamping=null)
	{
		$idpendamping=str_replace('%20', ' ', $idpendamping);
		$wh=array('status_tampil'=>'t');
		if($idpendamping!=null)
		{
			if($idpendamping!='')
			{
				list($idd,$nmd)=explode('__', $idpendamping);
				$wh=('status_tampil ="t" and nama_guru like "%'.$nmd.'%"');
			}
		}

		$dd=$this->db->from('t_data_pendamping')->where($wh)->order_by('nama_siswa')->get();
		// $d=array();
		// foreach ($dd->result() as $k => $v)
		// {
		// 	$d[$v->nis][]=$v;
		// }
		$data['d']=$dd->result();
		$this->load->view('isi/penerimaan/pendamping-data',$data);
	}
	function pendampingform($id=-1)
	{

		$dd=$this->db->from('t_data_pendamping')->where('status_tampil','t')->get();
		$ds=array();
		foreach ($dd->result() as $k => $v)
		{
			$ds[$v->nis]=$v->nis;
		}
		$data['dd']=$ds;
		if($id!=-1)
		{
			$d=$this->db->from('t_data_pendamping')->where('id',$id)->get();
			$data['d']=$d->result();
		}
		$data['id']=$id;
		$this->load->view('isi/penerimaan/pendamping-form',$data);
	}
	function pendampingproses($id=-1)
	{
		if(!empty($_POST))
		{
			// print_r($_POST);
			//siswadriverjarakketerangan
			$data=$_POST;
			list($nis,$nama_siswa)=explode('__', $_POST['siswa']);
			$idc=$nmc='';
			list($id_guru,$nama_guru)=explode('__', $_POST['guru']);
			unset($data['siswa']);
			unset($data['guru']);
			$data['nis']=$nis;
			$data['nama_siswa']=$nama_siswa;
			$data['id_guru']=$id_guru;
			$data['nama_guru']=$nama_guru;
			$data['biaya']=str_replace(',', '', $data['biaya']);

			$data['status_tampil']='t';
			if($id!=-1)
			{
				$this->db->where('id',$id);
				$c=$this->db->update('t_data_pendamping',$data);

				if($c)
					echo 'Data Pendamping Siswa Berhasil Di Edit';
				else
					echo 'Data Pendamping Siswa Gagal Di Edit';

			}
			else
			{
				$c=$this->db->insert('t_data_pendamping',$data);

				if($c)
					echo 'Data Pendamping Siswa Berhasil Di Simpan';
				else
					echo 'Data Pendamping Siswa Gagal Di Simpan';
			}
		}
		else
			echo 'Data Club Pendamping Gagal Di Simpan';
	}
	function pendampinghapus($id)
	{
		$this->db->query('update t_data_pendamping set status_tampil="f" where id="'.$id.'"');
		echo 'Data Pendamping Siswa Berhasil Di Hapus';
	}

	//-----------------------------------------------
	public function potongan()
	{
		// $data['d']=$this->load->view('index.html');
		$d=$this->db->from('t_jenis_penerimaan')->where('status_tampil','t')->order_by('jenis')->get();
		$dd2=array();
		$jenis=array();
		foreach ($d->result() as $k => $v)
		{
			$jn=str_replace(' ', '', $v->jenis);
			$jenis[$v->id_parent][$v->jenis]=$v->id.'__'.$v->jenis;
			$dd2[$jn][$v->id_parent][$v->id]=$v;
			$ddd[$v->id_parent][$v->id]=$v;
		}

		$data=array(
			'title' => 'Penerimaan',
			'isi' => 'isi/penerimaan/potongan-index',
			'navbar' => 'layout/navbar',
			'footer' => 'layout/footer',
			'jenis'=>$jenis,
			'd2'=>$dd2,
			'ddd'=>$ddd
		);

		$this->load->view('index',$data);
	}
	function potongandata($jenisid=null)
	{
		$jenisid=str_replace('%20', ' ', $jenisid);
		$wh=array('status_tampil'=>'t');
		if($jenisid!=null)
		{
			if($jenisid!='')
			{
				list($idj,$nmj)=explode('__', $jenisid);
				$wh=('status_tampil ="t" and jenis_potongan like "%'.$nmj.'%"');
			}
		}

		$dd=$this->db->from('t_data_potongan')->where($wh)->order_by('batch_id asc,nama_siswa asc, jenis_potongan')->get();
		// $d=array();
		// foreach ($dd->result() as $k => $v)
		// {
		// 	$d[$v->nis][]=$v;
		// }
		$data['d']=$dd->result();

		$this->load->view('isi/penerimaan/potongan-data',$data);
	}
	function potonganform($id=-1)
	{

		$dd=$this->db->from('t_data_potongan')->where('status_tampil','t')->get();
		$ds=array();
		foreach ($dd->result() as $k => $v)
		{
			$ds[$v->nis]=$v->nis;
		}
		$data['dd']=$ds;
		if($id!=-1)
		{
			$d=$this->db->from('t_data_potongan')->where('id',$id)->get();
			$data['d']=$d->result();
		}
		$data['id']=$id;

		$d=$this->db->from('t_jenis_penerimaan')->where('status_tampil','t')->order_by('jenis')->get();
		$dd2=array();
		$jenis=array();
		foreach ($d->result() as $k => $v)
		{
			$jn=str_replace(' ', '', $v->jenis);
			$jenis[$v->id_parent][$v->jenis]=$v->id.'__'.$v->jenis;
			$dd2[$jn][$v->id_parent][$v->id]=$v;
			$ddd[$v->id_parent][$v->id]=$v;
		}
		$data['d2']=$dd2;
		$data['ddd']=$ddd;
		$data['jenis']=$jenis;

		$this->load->view('isi/penerimaan/potongan-form',$data);
	}
	function potonganproses($id=-1)
	{
		if(!empty($_POST))
		{
			// print_r($_POST);
			//siswadriverjarakketerangan
			$data=$_POST;
			list($nis,$nama_siswa)=explode('__', $_POST['siswa']);
			$idc=$nmc='';
			list($idj,$nmj)=explode('__', $_POST['jenis']);
			unset($data['siswa']);
			unset($data['jenis']);
			$data['nis']=$nis;
			$data['nama_siswa']=$nama_siswa;
			$data['jenis_id']=$idj;
			$data['jenis_potongan']=$nmj;
			// $data['keterangan']=$nmj;
			$data['biaya']=$biaya=str_replace(',', '', $data['biaya']);
			$data['persen']=$persen=str_replace(',', '', $data['persen']);

			$datasiswa=$this->config->item('vbatchsiswa');

			if(isset($datasiswa[$nis]))
			{
				$dt_s=$datasiswa[$nis];
				$batch_id=$dt_s->id_batch;
				$nama_kelas=$dt_s->nama_batch;
				$tahun_ajaran=$dt_s->tahun_ajaran;

				$data['batch_id']=$batch_id;
				$data['nama_kelas']=$nama_kelas;
				$data['tahun_ajaran']=$tahun_ajaran;

				$whh='(tahun_ajaran="'.$tahun_ajaran.'" or batch_id="'.$batch_id.'") AND nis="'.$nis.'" AND jenis like "%'.$nmj.'%"';
			}
			else
			{
				list($idta,$tahun_ajaran)=explode('__', $_POST['tahun_ajaran']);
				$data['batch_id']='';
				$data['nama_kelas']='';
				$data['tahun_ajaran']=$tahun_ajaran;

				$whh='(tahun_ajaran="'.$tahun_ajaran.'") AND nis="'.$nis.'" AND jenis like "%'.$nmj.'%"';
			}

				$cektagihan=$this->db->from('v_tagihan_siswa')->where($whh)->get()->result();
				if(count($cektagihan)!=0)
				{
					if($persen==0)
					{
						// $sb=$cektagihan[0]->wajib_bayar - ($persen/100 * $cektagihan[0]->wajib_bayar);
						$sb=$biaya;
						$up['sisa_bayar']=$sb;
						$up['wajib_bayar']=$sb;
						foreach ($cektagihan as $k => $v)
						{
							$this->db->where('id_tagihan',$v->id_tagihan);
							$this->db->update('t_tagihan_siswa',$up);
							# code...
						}
					}
				}

			$data['status_tampil']='t';
			if($id!=-1)
			{
				list($idthn_aj,$nmth_aj)=explode('__',$_POST['tahun_ajaran']);
				$data['tahun_ajaran']=$nmth_aj;
				$this->db->where('id',$id);
				$c=$this->db->update('t_data_potongan',$data);

				if($c)
					echo 'Data Potongan Siswa Berhasil Di Edit';
				else
					echo 'Data Potongan Siswa Gagal Di Edit';

			}
			else
			{
				$c=$this->db->insert('t_data_potongan',$data);

				if($c)
					echo 'Data Potongan Siswa Berhasil Di Simpan';
				else
					echo 'Data Potongan Siswa Gagal Di Simpan';
			}
		}
		else
			echo 'Data Potongan Siswa Gagal Di Simpan';
	}
	function potonganhapus($id)
	{
		$this->db->query('update t_data_potongan set status_tampil="f" where id="'.$id.'"');
		echo 'Data Potongan Siswa Berhasil Di Hapus';
	}

	//-----------------------------------------------

	public function datacatering()
	{
		// $data['d']=$this->load->view('index.html');
		$data=array(
			'title' => 'Penerimaan',
			'isi' => 'isi/penerimaan/catering-index',
			'navbar' => 'layout/navbar',
			'footer' => 'layout/footer'
		);
		$this->load->view('index',$data);
	}
	function cateringdata($idcatering=null,$kelasid=null)
	{
		$idcatering=str_replace('%20', ' ', $idcatering);
		$kelasid=str_replace('%20', ' ', $kelasid);
		$wh=array('status_tampil'=>'t');
		if($idcatering!=null)
		{
			if($idcatering!='')
			{

				list($idd,$nmd)=explode('__', $idcatering);
				$wh=('status_tampil ="t" and nama_catering like "%'.$nmd.'%"');
			}
		}
		if($kelasid!=null)
		{
			if($kelasid!='')
			{

				list($idb,$nmb)=explode('__', $kelasid);
				$wh=('status_tampil ="t" and nama_catering like "%'.$nmd.'%"');
			}
		}

		$dd=$this->db->from('t_data_catering_siswa')->where($wh)->order_by('nama_siswa')->get();
		// $d=array();
		// foreach ($dd->result() as $k => $v)
		// {
		// 	$d[$v->nis][]=$v;
		// }
		$data['d']=$dd->result();
		$this->load->view('isi/penerimaan/catering-data',$data);
	}
	function cateringform($id=-1)
	{

		$dd=$this->db->from('t_data_catering_siswa')->where('status_tampil','t')->get();
		$ds=array();
		foreach ($dd->result() as $k => $v)
		{
			$ds[$v->nis]=$v->nis;
		}
		$data['dd']=$ds;
		if($id!=-1)
		{
			$d=$this->db->from('t_data_catering_siswa')->where('id',$id)->get();
			$data['d']=$d->result();
		}
		$data['id']=$id;
		$this->load->view('isi/penerimaan/catering-form',$data);
	}
	function cateringproses($id=-1)
	{
		if(!empty($_POST))
		{
			// print_r($_POST);
			//siswadriverjarakketerangan
			$data=$_POST;
			$ncatering=$data['catering'];
			foreach ($_POST['siswa'] as $ks => $vs)
			{
				list($nis,$nama_siswa)=explode('__', $vs);
				$idc=$nmc='';
				list($id_catering,$nama_catering)=explode('__', $ncatering);
				unset($data['siswa']);
				unset($data['catering']);
				$data['nis']=$nis;
				$data['nama_siswa']=$nama_siswa;
				$data['id_catering']=$id_catering;
				$data['nama_catering']=$nama_catering;

				$data['status_tampil']='t';
				if($id!=-1)
				{
					$this->db->where('id',$id);
					$c=$this->db->update('t_data_catering_siswa',$data);

					if($c)
						$ps='Data Catering Siswa Berhasil Di Edit';
					else
						$ps='Data Catering Siswa Gagal Di Edit';

				}
				else
				{
					$c=$this->db->insert('t_data_catering_siswa',$data);

					if($c)
						$ps='Data Catering Siswa Berhasil Di Simpan';
					else
						$ps='Data Catering Siswa Gagal Di Simpan';
				}
			}
			echo $ps;
		}
		else
			echo 'Data Catering Siswa Gagal Di Simpan';
	}
	function cateringhapus($id)
	{
		$this->db->query('update t_data_catering_siswa set status_tampil="f" where id="'.$id.'"');
		echo 'Data Catering Siswa Berhasil Di Hapus';
	}
	//--------------------------------------------------
	public function danalebih()
	{
		// $data['d']=$this->load->view('index.html');
		$data=array(
			'title' => 'Penerimaan',
			'isi' => 'isi/penerimaan/danalebih-index',
			'navbar' => 'layout/navbar',
			'footer' => 'layout/footer'
		);
		$this->load->view('index',$data);
	}
	function danalebihdata()
	{
		$sis=$this->config->item('nissiswa');
		$wh='dana_lebih != 0';
		$dd=$this->db->from('t_siswa_dana_lebih')->where($wh)->order_by('nis')->get();
		
		$data['d']=$dd->result();
		$data['sis']=$sis;
		$this->load->view('isi/penerimaan/danalebih-data',$data);
	}
	function danalebihform($id=-1)
	{
		$wh='dana_lebih != 0';
		$dd=$this->db->from('t_siswa_dana_lebih')->where($wh)->get();
		$ds=array();
		foreach ($dd->result() as $k => $v)
		{
			$ds[$v->nis]=$v->nis;
		}
		$data['dd']=$ds;
		if($id!=-1)
		{
			$d=$this->db->from('t_siswa_dana_lebih')->where('id_dana',$id)->get();
			$data['d']=$d->result();
		}
		$data['id']=$id;
		$this->load->view('isi/penerimaan/danalebih-form',$data);
	}
	function danalebihproses($id=-1)
	{
		if(!empty($_POST))
		{
			// print_r($_POST);
			//siswadriverjarakketerangan
			
				
				// if($id!=-1)
				// {
				// 	//$this->db->set('dana_lebih','dana_lebih+'.$data['dana_lebih'], FALSE);
				// 	$this->db->set('dana_lebih',$data['dana_lebih']);
				// 	$this->db->where('id_dana',$id);
				// 	$c=$this->db->update('t_siswa_dana_lebih');

				// 	if($c)
				// 		$ps='Data Dana Lebih Siswa Berhasil Di Edit';
				// 	else
				// 		$ps='Data Dana Lebih Siswa Gagal Di Edit';

				// }
				// else
				// {
					// $cek=$this->db->from('t_siswa_dana_lebih')->where('id_siswa',$idsiswa)->get()->result();
					// if(count($cek)!=0)
					// {
					// 	$this->db->set('dana_lebih','dana_lebih+'.$data['dana_lebih'], FALSE);
					// 	$this->db->where('id_dana',$cek[0]->id_dana);
					// 	$c=$this->db->update('t_siswa_dana_lebih');
					// }
					// else
					// {
						$data=$_POST;
						list($idsiswa,$nis,$nama_siswa)=explode('__', $data['siswa']);
						$idc=$nmc='';
						if($_POST['created_at']!='')
						{
							list($tg,$bl,$th)=explode('-',$_POST['created_at']);
							$tanggal=$th.'-'.$bl.'-'.$tg;
						}
						else
							$tanggal=date('Y-m-d H:i:s');

						$this->db->set('id_siswa',$idsiswa);
						$this->db->set('nis',$nis);
						$this->db->set('dana_lebih',$data['dana_lebih']);
						$this->db->set('created_at',$tanggal);
						$this->db->set('keterangan',$data['keterangan']);
						$c=$this->db->insert('t_siswa_dana_lebih');
					// }

					if($c)
						$ps='Data Dana Lebih Siswa Berhasil Di Simpan';
					else
						$ps='Data Dana Lebih Siswa Gagal Di Simpan';
				// }
			
			echo $ps;
		}
		else
			echo 'Data Dana Lebih Siswa Gagal Di Simpan';
	}
	function danalebihhapus($id)
	{
		$this->db->query('delete from t_siswa_dana_lebih where id_dana="'.$id.'"');
		echo 'Data Dana Lebih Siswa Berhasil Di Hapus';
	}
	//--------------------------------------------------
	function hapusdatatagihan($jenis,$bulan,$tahun,$nis,$id)
	{
		list($nis,$batch_id)=explode('__', $nis);
		$nis1=$nis;
		$nis2=str_replace('_','.',$nis);
		// $whr=array('id_jenis_penerimaan'=>$id,'nis'=>$nis,'bulan'=>$bulan,'tahun'=>$tahun);
		$whr='id_jenis_penerimaan='.$id.' and bulan='.$bulan.' and tahun='.$tahun.' and (nis="'.$nis1.'" or nis="'.$nis2.'")';
		// echo $whr;
		$tagihan=$this->db->from('t_tagihan_siswa')->where($whr)->get()->result();
		if(count($tagihan)!=0)
		{
			$this->db->where('id_tagihan',$tagihan[0]->id_tagihan);
			$this->db->delete('t_tagihan_siswa');
		}
	}
	function hapuso_one_tagihan($idtagihan)
	{
		$this->db->where('id_tagihan',$idtagihan);
		$this->db->delete('t_tagihan_siswa');
	}
	function update_one_tagihan($idtagihan)
	{
		$this->db->set('sisa_bayar',0);
		$this->db->where('id_tagihan',$idtagihan);
		$this->db->update('t_tagihan_siswa');
	}
	// {
	// 	echo '<pre>';
	// 	print_r($_POST);
	// 	echo '</pre>';
	// }
	function setDataTagihan($batch_id)
	{
		$jenispenerimaan=$this->db->from('t_jenis_penerimaan')->where('status_tampil','t')->get()->result();
		foreach ($jenispenerimaan as $kj => $vj)
		{
			$jenispn[$vj->id]=$vj;
		}
		$sss=$this->config->item('nissiswa2');
		$tagihan=$this->config->item('ttagihanbybulan');
		$tagihanbybulanclub=$this->config->item('ttagihanbybulanclub');
		
		
		// echo '<pre>';
		// print_r($_POST['tagihclub']);
		// echo '</pre>';
		$batch=$this->db->from('v_batch_kelas')->where('id_batch',$batch_id)->get()->result();
		$kat=$batch[0]->kategori;
		$data['tahun_ajaran']=$tahun_ajaran=$batch[0]->tahun_ajaran;
		$ins=$statusinves=0;
		if(!empty($_POST))
		{
			$data['bulan']=$bulan=$bln=$_POST['bulan'];
			$data['tahun']=$tahun=$thn=$_POST['tahun'];
			$data['batch_id']=$batch_id;
			$data['sudah_bayar']=0;
			$data['transaksi_id']='';
			if(isset($_POST['tagihclub']))
			{
				foreach($_POST['tagihclub'] as $iclub=>$vclub)
				{
					$nis=str_replace('.','_',$iclub);
					$data['nis']=$nis2=str_replace('_','.',$nis);
					if(isset($sss[$nis]))
					{
						$data['id_siswa']=$id_siswa=$sss[$nis]->id;
						foreach ($vclub as $kk => $vv)
						{
							if($kk!=0)
							{
								// echo $vv.'-';
								foreach($vv as $i_cl=>$v_cl)
								{

									$data['keterangan']='';
									//echo $kk.'<br>';
									list($idjenis,$jenisp)=explode('__', $kk);
									$jenisp=str_replace('mm','m ',$jenisp);
									$data['id_jenis_penerimaan']=$idjenis;
									$data['id_club']=$id_cl=strtok($i_cl,'__');
									$nominal=str_replace(',', '', $v_cl);
									if($nominal!=0)
									{
										$data['wajib_bayar']=$data['sisa_bayar']=$nominal;
										if(strtolower($jenisp)=='program pembelajaran')
										{
											$data['bulan']=$bulan=7;
											$data['tahun']=$tahun=trim(strtok($tahun_ajaran,'/'));
										}
										else if(strtolower($jenisp)=='investasi')
										{
											$data['bulan']=$bulan=7;
											$data['tahun']=$tahun=trim(strtok($tahun_ajaran,'/'));
										}
										else
										{

											$data['bulan']=$bulan=$bln;
											$data['tahun']=$tahun=$thn;
										}

										if(isset($tagihanbybulanclub[$nis][$tahun_ajaran][$tahun][$bulan][$idjenis][$id_cl]))
										{
											//echo 'Update : '.$jenisp;
											$tag=$tagitagihanbybulanclubhan[$nis][$tahun_ajaran][$tahun][$bulan][$idjenis][$id_cl];
											// echo key($tag);
											// if(key($tag)=='id_tagihan')
											if(key($tag)=='status_tagihan')
											{
												if($tag->sisa_bayar!=0)
												{
													// $data['ada']='update';
													// $data['wajib_bayar']=
													// $data['sisa_bayar']=$tag->sisa_bayar;
													
													$this->db->where('id_tagihan',$tag->id_tagihan);
													$this->db->update('t_tagihan_siswa',$data);
												}
												// else
												// 	$data['ada']='update-';
											}
											else
											{
												// $data['ada']=key($tag);
												// echo '<pre>';
												// print_r($tag);
												// echo '</pre>';
											}
										}
										else
										{
											// $data['ada']='insert';
											// echo '<pre>';
											// print_r($data);			
											// echo '</pre>';
											$wh_ct='nis="'.$nis2.'" and bulan="'.$bulan.'" and tahun="'.$tahun.'" and lower(jenis)="'.strtolower($jenisp).'" and id_club="'.$id_cl.'"';
											$cekjenistag=$this->db->from('v_tagihan_siswa')->where($wh_ct)->get()->result();
											if(count($cekjenistag)!=0)
											{
												if($cekjenistag[0]->sisa_bayar!=0)
												{
													// $data['ada']='update';
													// $data['wajib_bayar']=
													// $data['sisa_bayar']=$tag->sisa_bayar;
													
													$this->db->where('id_tagihan',$cekjenistag[0]->id_tagihan);
													$this->db->update('t_tagihan_siswa',$data);
												}
												// else
												// 	$data['ada']='update---';
											}
											else
											{
												// $data['ada']='insert';
												$this->db->insert('t_tagihan_siswa',$data);
											}
										}
										// echo '<pre>';
										// print_r($data);			
										// echo '</pre>';
									}
									// echo '<br>';
								}
							}
						}
					}
				}
			}
			foreach($_POST['tagih'] as $k_post => $v_post)
			{
				$nis=str_replace('.','_',$k_post);
				$data['nis']=$nis2=str_replace('_','.',$nis);
					//echo $nis.'-';
				if(isset($sss[$nis]))
				{

				
					$data['id_siswa']=$id_siswa=$sss[$nis]->id;
					// $data['nama_siswa']=$id_siswa=$sss[$nis]->nama_murid;
					
					foreach ($v_post as $kk => $vv)
					{
						if($kk!=0)
						{
							
							$data['keterangan']='';
							//echo $kk.'<br>';
							list($idjenis,$jenisp)=explode('__', $kk);
							$jenisp=str_replace('mm','m ',$jenisp);
							$data['id_jenis_penerimaan']=$idjenis;
							$nominal=str_replace(',', '', $vv);
							if($nominal!=0)
							{
								$data['wajib_bayar']=$data['sisa_bayar']=$nominal;
								if(strtolower($jenisp)=='program pembelajaran')
								{
									$data['bulan']=$bulan=7;
									$data['tahun']=$tahun=trim(strtok($tahun_ajaran,'/'));
								}
								else if(strtolower($jenisp)=='investasi')
								{
									$data['bulan']=$bulan=7;
									$data['tahun']=$tahun=trim(strtok($tahun_ajaran,'/'));
								}
								else
								{

									$data['bulan']=$bulan=$bln;
									$data['tahun']=$tahun=$thn;
								}

								if(isset($tagihan[$nis][$tahun_ajaran][$tahun][$bulan][$idjenis]))
								{
									//echo 'Update : '.$jenisp;
									$tag=$tagihan[$nis][$tahun_ajaran][$tahun][$bulan][$idjenis];
									// echo key($tag);
									// if(key($tag)=='id_tagihan')
									if(key($tag)=='status_tagihan')
									{
										if($tag->sisa_bayar!=0)
										{
											// $data['ada']='update';
											// $data['wajib_bayar']=
											// $data['sisa_bayar']=$tag->sisa_bayar;
											
											$this->db->where('id_tagihan',$tag->id_tagihan);
											$this->db->update('t_tagihan_siswa',$data);
										}
										// else
										// 	$data['ada']='update-';
									}
									else
									{
										// $data['ada']=key($tag);
										// echo '<pre>';
										// print_r($tag);
										// echo '</pre>';
									}
								}
								else
								{
									// $data['ada']='insert';
									// echo '<pre>';
									// print_r($data);			
									// echo '</pre>';
									$wh_ct='nis="'.$nis2.'" and bulan="'.$bulan.'" and tahun="'.$tahun.'" and lower(jenis)="'.strtolower($jenisp).'"';
									$cekjenistag=$this->db->from('v_tagihan_siswa')->where($wh_ct)->get()->result();
									if(count($cekjenistag)!=0)
									{
										if($cekjenistag[0]->sisa_bayar!=0)
										{
											// $data['ada']='update';
											// $data['wajib_bayar']=
											// $data['sisa_bayar']=$tag->sisa_bayar;
											
											$this->db->where('id_tagihan',$cekjenistag[0]->id_tagihan);
											$this->db->update('t_tagihan_siswa',$data);
										}
										// else
										// 	$data['ada']='update---';
									}
									else
									{
										// $data['ada']='insert';
										$this->db->insert('t_tagihan_siswa',$data);
									}
								}
								// echo '<pre>';
								// print_r($data);			
								// echo '</pre>';
								// echo '<br>';
							}
						}
						
					}
				}
			}
			echo 'Data Tagihan Berhasil Ditambahkan';
		}
		else
		{
			echo 'Data Tagihan Gagal Ditambahkan';
		}
	
		

	}
//--------------------------------------
	public function tabungan_per_kelas()
	{
		// $data['d']=$this->load->view('index.html');

		$data=array(
			'title' => 'Penerimaan',
			'isi' => 'isi/penerimaan/tabungan-perkelas-index',
			'navbar' => 'layout/navbar',
			'footer' => 'layout/footer'
		);
		$vbs=$this->config->item('vbatchsiswa');
		$vbk=$this->config->item('vbatchkelas');
		$d=$this->config->item('tsiswa');
		$data['vbs']=$vbs;
		$data['vbk']=$vbk;
		$data['dd']=$d;
		$this->load->view('index',$data);
	}
	function tabunganperkelasdata($id=-1)
	{
		$vbs=$this->config->item('vbatchsiswa');
		$vbsbk=$this->config->item('vbatchsiswabykelas');
		$tabungan=$this->config->item('tabungan');
		$d=$this->config->item('tsiswa');
		$data['vbs']=$vbs;

		if(isset($vbsbk[$id]))
			$data['vbsbk']=$vbsbk[$id];
		else
			$data['vbsbk']=array();

		if($id=='all')
		{
			$data['vbsbk']=$vbk=$this->config->item('vbatchkelas');
			foreach($vbk as $vk => $vv)
			{
				if(isset($vbsbk[$vv->id_batch]))
				{
					$jlh=0;
					foreach($vbsbk[$vv->id_batch] as $vb => $val)
					{
						if(isset($tabungan[$val->id]))
						{
							$tTab=$tabungan[$val->id];
							$jlh+=$tTab[0]->saldo;
						}	
						else
						{
							$jlh=0;
						}
					}
					$data['jlh'][$vv->id_batch]=$jlh;
				}
				else
					$data['jlh']=array();
			}
			// $data['data_sis']=$vbsbk;
		}

		$data['tabungan']=$tabungan;
		$data['d']=$d;
		$data['id']=$id;
		$this->load->view('isi/penerimaan/tabungan-perkelas-data',$data);
	}
	function tabunganperkelasdataform($id=-1)
	{
		$vbs=$this->config->item('vbatchsiswa');
		$vbsbk=$this->config->item('vbatchsiswabykelas');
		$tabungan=$this->config->item('tabungan');
		$d=$this->config->item('tsiswa');
		$data['vbs']=$vbs;

		if(isset($vbsbk[$id]))
			$data['vbsbk']=$vbsbk[$id];
		else
			$data['vbsbk']=array();

		$data['tabungan']=$tabungan;
		$data['d']=$d;
		$data['id']=$id;
		$this->load->view('isi/penerimaan/tabungan-perkelas-form-input',$data);
		# code...
	}
	function tabunganperkelasform($id=-1)
	{
		$vbs=$this->config->item('vbatchsiswa');
		$d=$this->config->item('tsiswa');
		$vbk=$this->config->item('vbatchkelas');
		$data['vbk']=$vbk;
		$data['vbs']=$vbs;
		$data['d']=$d;
		$data['id']=$id;
		if($id!=-1)
		{
			$det=$this->db->from('t_tabungan')->join('t_tabungan_detail','t_tabungan.id=t_tabungan_detail.tabungan_id')->order_by('t_tabungan_detail.tanggal desc')->where('id_det',$id)->get()->result();
			$data['det']=$det[0];
			$this->load->view('isi/penerimaan/tabungan-form-edit',$data);
		}
		else
			$this->load->view('isi/penerimaan/tabungan-perkelas-form',$data);
	}
	function tabunganperkelasproses($id=-1)
	{
		if(!empty($_POST))
		{
			$data=$_POST;
			$pesan='';
			foreach ($data['jumlah'] as $k => $v)
			{
				# code...
				if($v!=0)
				{

					$cektab=$this->db->from('t_tabungan')->where('siswa_id',$k)->get()->result();
					if(count($cektab)==0)
					{
						$ins['no_tabungan_rekening']=generaterekening();
						$ins['siswa_id']=$k;
						$ins['saldo']=0;
						$ins['ket']='';
						$ins['status_tampil']='t';
						$this->db->insert('t_tabungan',$ins);
						$idtab=$this->db->insert_id();
					}
					else
					{
						$idtab=$cektab[0]->id;
					}

					$jlh=str_replace(',', '', $v);
					$det['tabungan_id']=$idtab;
					$det['jumlah']=$jlh;
					$det['jenis']=$data['jenistabungan'];
					$det['penerima']=$this->session->userdata('namauser');
					$det['penyetor_penarik']=$data['penyetor'];
					$det['tanggal']=$data['tanggal'];
					$det['batch_id']=$data['kelas'];
					$det['status_tampil_det']='t';
					$det['keterangan']=$data['keterangan'];
					$this->db->insert('t_tabungan_detail',$det);

					if($data['jenistabungan']=='Tarik')
					{
						$this->db->set('saldo','saldo-'.$jlh, FALSE);
					}
					else
						$this->db->set('saldo','saldo+'.$jlh, FALSE);

					$this->db->set('last_update',date('Y-m-d H:i:s'));
					$this->db->where('id',$idtab);
					$this->db->update('t_tabungan');
					$this->mm->updatetabungan($k);
					$pesan= 'Data Tabungan Siswa Berhasil Di Simpan';
				}
				else
					$pesan= 'Data Tabungan Siswa Gagal Di Simpan';
			}
			echo $pesan;
			// echo '<pre>';
			// print_r($data);
			// echo '</pre>';
		}
	}
//Tabungan SDM
	function generaterekening()
	{
		$no=date('Ymd');
		$norek=abs(crc32($no.rand()));
		$norek=$no.'-'.substr($norek,0,5);
		return $norek;
	}
	function cekkoderek($idguru)
	{
		$cek=$this->db->from('t_tabungan_sdm')->where('id_sdm',$idguru)->get()->result();
		// echo '<pre>';
		// print_r($cek);
		// echo '</pre>';
		if(count($cek)!=0)
		{
			$norek='';
			foreach($cek as $k => $v)
			{
				$norek.=$v->no_tabungan_rekening.',';
			}
			$norek=substr($norek,0,-1);
		}
		else
			$norek=$this->generaterekening();

		echo $norek;
	}
	public function tabungansdm()
	{
		// $data['d']=$this->load->view('index.html');

		$data=array(
			'title' => 'Penerimaan',
			'isi' => 'isi/penerimaan/tabungansdm-index',
			'navbar' => 'layout/navbar',
			'footer' => 'layout/footer'
		);
		$this->load->view('index',$data);
	}
	function tabungansdmdata($id=-1)
	{
		//$tabungan=$this->config->item('tabungan');
		$tab=$this->db->from('t_tabungan_sdm')->get()->result();
		$tabungan=array();
		foreach($tab as $k => $v)
		{
			$tabungan[$v->id_sdm][]=$v;
		}
		$d=$this->config->item('tguru');
		$data['tabungan']=$tabungan;
		$data['d']=$d;
		$data['id']=$id;
		$this->load->view('isi/penerimaan/tabungansdm-data',$data);
	}
	function tabungansdmdetail($id=-1,$norek)
	{
		$data['id']=$id;
		$tab=$this->db->from('t_tabungan_sdm')
					->join('t_tabungan_sdm_detail','t_tabungan_sdm_detail.tabungan_id=t_tabungan_sdm.id')
					->where('t_tabungan_sdm.no_tabungan_rekening',$norek)->get()->result();

		$tabungan=array();
		foreach($tab as $k => $v)
		{
			$tabungan[$v->id_sdm][]=$v;
		}
		if(isset($tabungan[$id]))
		{

			$data['tabungan']=$tabungan[$id];
			$d=$this->config->item('tguru');
			$data['d']=$d[$id];
			$this->load->view('isi/penerimaan/tabungansdm-detail',$data);
		}
		else
			echo 'Data Tidak Ditemukan';
	}
	function tabungansdmform($id=-1)
	{
		$d=$this->config->item('tguru');
		$data['d']=$d;
		$data['id']=$id;
		if($id!=-1)
		{
			$det=$this->db->from('t_tabungan_sdm')->join('t_tabungan_sdm_detail','t_tabungan_sdm.id=t_tabungan_sdm_detail.tabungan_id')
					->order_by('t_tabungan_sdm_detail.tanggal desc')->where('id_det',$id)->get()->result();
			$data['det']=$det[0];
			$this->load->view('isi/penerimaan/tabungansdm-form-edit',$data);
		}
		else
			$this->load->view('isi/penerimaan/tabungansdm-form',$data);
	}

	function tabungansdmproses($id)
	{
		// echo '<pre>';
		// print_r($_POST);
		// echo '</pre>';
		if(!empty($_POST['no_rekening_baru']))
			$no_rek=$_POST['no_rekening_baru'];
		else
			$no_rek=$_POST['no_rekening_tabungan'];
		
		$cektab=$this->db->from('t_tabungan_sdm')->where('no_tabungan_rekening',$no_rek)->get()->result();

		if($id==-1)
		{

			if(count($cektab)!=0)
			{
				//$dettab=$this->db->from('t_tabungan_sdm_detail')->where('tabungan_id',$cektab[0]->id)->get()->result();
				
				$det['tabungan_id']=$idtab=$cektab[0]->id;
				$det['jumlah']=$jlh=str_replace(array(',','.'),'',$_POST['jumlah']);
				$det['jenis']=$_POST['jenistabungan'];
				$det['tanggal']=$_POST['tanggal'];
				$det['keterangan']=$_POST['keterangan'];
				$det['status_tampil_det']='t';
				$this->db->insert('t_tabungan_sdm_detail',$det);
				
				if($_POST['jenistabungan']=='Tarik')
				{
					$this->db->set('saldo',('saldo-'.$jlh), FALSE);
				}
				else					
				$this->db->set('saldo',('saldo+'.$jlh), FALSE);
				
				$this->db->set('last_update',date('Y-m-d H:i:s'));
				$this->db->where('id',$idtab);
				$this->db->update('t_tabungan_sdm');
				
				echo 'Data Tabungan SDM Berhasil Di Edit';
			}
			else
			{
				$data['no_tabungan_rekening']=$no_rek;
				$data['id_sdm']=$_POST['id_guru'];
				$data['saldo']=str_replace(array(',','.'),'',$_POST['jumlah']);
				$data['ket']=$_POST['keterangan'];
				$data['last_update']=date('Y-m-d H:i:s');
				$data['status_tampil']='t';
				$this->db->insert('t_tabungan_sdm',$data);
				
				$iddet=$this->db->insert_id();
				$det['tabungan_id']=$iddet;
				$det['jumlah']=str_replace(array(',','.'),'',$_POST['jumlah']);
				$det['jenis']=$_POST['jenistabungan'];
				$det['tanggal']=$_POST['tanggal'];
				$det['keterangan']=$_POST['keterangan'];
				$det['status_tampil_det']='f';
				$this->db->insert('t_tabungan_sdm_detail',$det);
				
				echo 'Data Tabungan SDM Berhasil Di Simpan';
			}
		}
		else
		{
				$data=$_POST;
				$idtab=$cektab[0]->id;
				$dett=$this->db->from('t_tabungan_sdm_detail')->where('tabungan_id',$idtab)->get()->result();

				$jlh=str_replace(',', '', $data['jumlah']);
				$det['tabungan_id']=$idtab;
				$det['jumlah']=$jlh;
				$det['jenis']=$data['jenistabungan'];
				$det['penerima']=$this->session->userdata('namauser');
				$det['penyetor_penarik']=$data['penyetor'];
				$det['tanggal']=$data['tanggal'];
				$det['status_tampil_det']='t';
				$det['keterangan']=$data['keterangan'];
				$this->db->where('id_det',$id);
				$this->db->update('t_tabungan_sdm_detail',$det);

				if($data['jenistabungan']=='Tarik')
				{
					$this->db->set('saldo',('saldo-'.$jlh.'-'.$dett[0]->jumlah), FALSE);
				}
				else
					$this->db->set('saldo',('saldo+'.$jlh.'-'.$dett[0]->jumlah), FALSE);

				$this->db->set('last_update',date('Y-m-d H:i:s'));
				$this->db->where('id',$idtab);
				$this->db->update('t_tabungan_sdm');

				echo 'Data Tabungan SDM Berhasil Di Edit';
		}
	}
	function tabungansdmhapus($id,$guru_id)
	{
		$cektab=$this->db->from('t_tabungan_sdm')->where('id_sdm',$guru_id)->get()->result();
		$dett=$this->db->from('t_tabungan_sdm_detail')->where('id_det',$id)->get()->result();
		$jumlah=$dett[0]->jumlah;
		$idtab=$cektab[0]->id;
		if(strtolower($dett[0]->jenis)=='tarik')
		{
			$this->db->set('saldo',('saldo+'.$dett[0]->jumlah), FALSE);
		}
		else
			$this->db->set('saldo',('saldo-'.$dett[0]->jumlah), FALSE);

		$this->db->set('last_update',date('Y-m-d H:i:s'));
		$this->db->where('id',$idtab);
		$this->db->update('t_tabungan_sdm');

		$this->db->query('delete from t_tabungan_sdm_detail where id_det="'.$id.'"');
		echo 'Data Tabungan SDM Berhasil Di Hapus';
	}
		//


	public function tabungan()
	{
		// $data['d']=$this->load->view('index.html');

		$data=array(
			'title' => 'Penerimaan',
			'isi' => 'isi/penerimaan/tabungan-index',
			'navbar' => 'layout/navbar',
			'footer' => 'layout/footer'
		);
		$vbs=$this->config->item('vbatchsiswa');
		$d=$this->config->item('tsiswa');
		$data['vbs']=$vbs;
		$data['dd']=$d;
		$this->load->view('index',$data);
	}
	function tabungandata($id=-1)
	{
		$vbs=$this->config->item('vbatchsiswa');
		$tabungan=$this->config->item('tabungan');
		$d=$this->config->item('tsiswa');
		$data['vbs']=$vbs;
		$data['tabungan']=$tabungan;
		$data['d']=$d;
		$data['id']=$id;
		$this->load->view('isi/penerimaan/tabungan-data',$data);
	}
	function tabungandetail($id=-1)
	{
		$data['id']=$id;
		$tabungan=$this->config->item('tabungan');
		if(isset($tabungan[$id]))
		{

			$data['tabungan']=$tabungan[$id];
			$d=$this->config->item('tsiswa');
			$data['d']=$d[$id];
			$vbs=$this->config->item('vbatchsiswa');
			$data['vbs']=$vbs;
			$this->load->view('isi/penerimaan/tabungan-detail',$data);
		}
		else
			echo 'Data Tidak Ditemukan';
	}
	function tabunganexcel($id=-1)
	{
		$data['id']=$id;
		$tabungan=$this->config->item('tabungan');
		if(isset($tabungan[$id]))
		{

			$data['tabungan']=$tabungan[$id];
			$d=$this->config->item('tsiswa');
			$data['d']=$d[$id];
			$vbs=$this->config->item('vbatchsiswa');
			$data['vbs']=$vbs;
			$this->load->view('isi/penerimaan/tabungan-excel',$data);
		}
		else
			echo 'Data Tidak Ditemukan';
	}
	function tabunganform($id=-1)
	{
		$vbs=$this->config->item('vbatchsiswa');
		$d=$this->config->item('tsiswa');
		$data['vbs']=$vbs;
		$data['d']=$d;
		$data['id']=$id;
		if($id!=-1)
		{
			$det=$this->db->from('t_tabungan')->join('t_tabungan_detail','t_tabungan.id=t_tabungan_detail.tabungan_id')->order_by('t_tabungan_detail.tanggal desc')->where('id_det',$id)->get()->result();
			$data['det']=$det[0];
			$this->load->view('isi/penerimaan/tabungan-form-edit',$data);
		}
		else
			$this->load->view('isi/penerimaan/tabungan-form',$data);
	}
	function tabunganproses($id=-1)
	{
		if(!empty($_POST))
		{
			$data=$_POST;
			list($nis,$idsiswa,$namasiswa,$idbatch)=explode('__', $data['siswa']);
			$cektab=$this->db->from('t_tabungan')->where('siswa_id',$idsiswa)->get()->result();
			if($id!=-1)
			{
				$idtab=$cektab[0]->id;
				$dett=$this->db->from('t_tabungan_detail')->where('id_det',$id)->get()->result();
				// echo $idtab.'-'.$id;
				// echo '<pre>';
				// print_r($cektab);
				// echo '</pre>';
				$jlh=str_replace(',', '', $data['jumlah']);
				$det['tabungan_id']=$idtab;
				$det['jumlah']=$jlh;
				$det['jenis']=$data['jenistabungan'];
				$det['penerima']=$this->session->userdata('namauser');
				$det['penyetor_penarik']=$data['penyetor'];
				$det['tanggal']=$data['tanggal'];
				$det['batch_id']=$idbatch;
				$det['status_tampil_det']='t';
				$det['keterangan']=$data['keterangan'];
				$this->db->where('id_det',$id);
				$this->db->update('t_tabungan_detail',$det);

				if($data['jenistabungan']=='Tarik')
				{
					$this->db->set('saldo',('saldo-'.$jlh.'-'.$dett[0]->jumlah), FALSE);
				}
				else
					$this->db->set('saldo',('saldo+'.$jlh.'-'.$dett[0]->jumlah), FALSE);

				$this->db->set('last_update',date('Y-m-d H:i:s'));
				$this->db->where('id',$idtab);
				$this->db->update('t_tabungan');
				$this->mm->updatetabungan($idsiswa);
				echo 'Data Tabungan Siswa Berhasil Di Edit';
			}
			else
			{
				if(count($cektab)==0)
				{
					$ins['no_tabungan_rekening']=generaterekening();
					$ins['siswa_id']=$idsiswa;
					$ins['saldo']=0;
					$ins['ket']='';
					$ins['status_tampil']='t';
					$this->db->insert('t_tabungan',$ins);
					$idtab=$this->db->insert_id();
				}
				else
				{
					$idtab=$cektab[0]->id;
				}

				$jlh=str_replace(',', '', $data['jumlah']);
				$det['tabungan_id']=$idtab;
				$det['jumlah']=$jlh;
				$det['jenis']=$data['jenistabungan'];
				$det['penerima']=$this->session->userdata('namauser');
				$det['penyetor_penarik']=$data['penyetor'];
				$det['tanggal']=$data['tanggal'];
				$det['batch_id']=$idbatch;
				$det['status_tampil_det']='t';
				$det['keterangan']=$data['keterangan'];
				$this->db->insert('t_tabungan_detail',$det);

				if($data['jenistabungan']=='Tarik')
				{
					$this->db->set('saldo','saldo-'.$jlh, FALSE);
				}
				else
					$this->db->set('saldo','saldo+'.$jlh, FALSE);

				$this->db->set('last_update',date('Y-m-d H:i:s'));
				$this->db->where('id',$idtab);
				$this->db->update('t_tabungan');
				$this->mm->updatetabungan($idsiswa);
				echo 'Data Tabungan Siswa Berhasil Di Simpan';
			}
		}
		else
			echo 'Data Tabungan Siswa Gagal Di Simpan';
	}
	function tabunganhapus($id,$siswa_id)
	{
		$cektab=$this->db->from('t_tabungan')->where('siswa_id',$siswa_id)->get()->result();
		$dett=$this->db->from('t_tabungan_detail')->where('id_det',$id)->get()->result();
		$jumlah=$dett[0]->jumlah;
		$idtab=$cektab[0]->id;
		if(strtolower($dett[0]->jenis)=='tarik')
		{
			$this->db->set('saldo',('saldo+'.$dett[0]->jumlah), FALSE);
		}
		else
			$this->db->set('saldo',('saldo-'.$dett[0]->jumlah), FALSE);

		$this->db->set('last_update',date('Y-m-d H:i:s'));
		$this->db->where('id',$idtab);
		$this->db->update('t_tabungan');

		$this->db->query('delete from t_tabungan_detail where id_det="'.$id.'"');
		echo 'Data Tabungan Siswa Berhasil Di Hapus';
	}
//-----------------------------------------------------------------------
	function pendftaran($jenis,$id=-1)
	{
		// echo '<pre>';
		// print_r($jenisgroup['pg']);
		// echo '</pre>';
		$levelkelas=$this->config->item('tlevelkelas');
		$siswa=$this->config->item('tsiswa');
		$ajaran=$this->config->item('tajaran');

		$data['levelkelas']=$levelkelas;
		$data['ajaran']=$ajaran;
		$data['siswa']=$siswa;
		$data['jenis']=$jenis;
		$data['id']=$id;
		$this->load->view('isi/home/form-pendataran',$data);
	}
	function pendaftaranproses($jenis,$id)
	{
		// echo '<pre>';
		// print_r($_POST);
		// echo '</pre>';
		$potongan=$this->config->item('tpotongan2');
		if(!empty($_POST))
		{
			$d=$_POST;
			list($idajaran,$tahun_ajaran)=explode('__', $d['tahunajaran']);
			$data['tahun_ajaran']=$tahun_ajaran;
			$data['kategori_daftar']=$jenis;

			list($level,$idlevel,$kelas,$kategori)=explode('__', str_replace('%20', ' ', $d['kelas']));
			$data['kelas']=$kelas;
			$data['level']=$level;
			$data['idlevel']=$idlevel;
			$data['kategori']=$kategori;


			$idpen=$jnspen=$jlh='';


			foreach ($d['investasi'] as $ki => $vi)
			{

				list($idp,$jnp,$jl)=explode('__', $vi);
				$idpen.=$idp.',';
				$jnspen.=$jnp.',';
				$jlh.=$jl.',';
			}
			$idpen=substr($idpen,0,-1);
			$jnspen=substr($jnspen,0,-1);
			$jlh=substr($jlh,0,-1);

			$data['id_penerimaan']=$idpen;
			$data['jenis_penerimaan']=$jnspen;
			$data['jumlah']=$jlh;

			foreach ($d['siswa'] as $k => $v)
			{
				$v=str_replace('%20', ' ', $v);
				list($idsiswa,$nis,$nama)=explode('__', $v);
				$data['nama_siswa']=$nama;
				$data['nis']=$nis;
				$data['id_siswa']=$idsiswa;
				$dpt=0;
				if(isset($potongan[$tahun_ajaran][$nis]))
				{
					$dapot=$potongan[$tahun_ajaran][$nis];
					$dpt=1;
				}
				$wh='nis="'.$nis.'" and tahun_ajaran="'.$tahun_ajaran.'" and idlevel="'.$idlevel.'"';
				$cek_daftar=$this->db->from('t_pendaftaran')->where($wh)->get()->result();
				if(count($cek_daftar)!=0)
				{
					$this->db->where('id',$cek_daftar[0]->id);
					$this->db->delete('t_pendaftaran');
				}

				foreach ($d['investasi'] as $ki => $vi)
				{
					list($idp,$jnp,$jl)=explode('__', $vi);
					$jenis_p=strtok($jnp, ' ');
					$sisa_bayar=0;

					if(count($cek_daftar)!=0)
					{
						$wh_del='nis="'.$nis.'" and tahun_ajaran="'.$tahun_ajaran.'" and id_jenis_penerimaan="'.$idp.'"';
						$this->db->where($wh_del);
						$this->db->delete('t_tagihan_siswa');
					}

					if($dpt!=0)
					{

						if(isset($datapot[$jenis_p]))
						{
							if($datapot[$jenis_p]->persen==0)
							{
								$sisa_bayar=$jl - ($datapot[$jenis_p]->persen/100 * $jl);
							}
							else
								$sisa_bayar=$datapot[$jenis_p]->biaya;
						}
						else
						{
							$sisa_bayar=$jl;
						}
					}
					else
					{
						$sisa_bayar=$jl;
					}

					$tg['wajib_bayar']=$sisa_bayar;
					$tg['bulan']=7;
					$tg['tahun']=trim(strtok($tahun_ajaran, '/'));
					$tg['id_jenis_penerimaan']=$idp;
					$tg['nis']=$nis;
					$tg['sudah_bayar']=0;
					$tg['sisa_bayar']=$sisa_bayar;
					$tg['tahun_ajaran']=$tahun_ajaran;
					$tg['id_siswa']=$idsiswa;
					$this->db->insert('t_tagihan_siswa',$tg);
				}
				// echo '<pre>';
				// print_r($data);
				$this->db->insert('t_pendaftaran',$data);
			}
			echo 'Data Sudah Berhasil Ditambahkan';
		}
	}
	function jenisgroup($sab,$jenis,$level=null,$siswa=null)
	{
		if($level!=null)
		{

			$jenisgroup=$this->config->item('jenisgroup');
			// echo '<pre>';
			// print_r($jenisgroup);
			// echo '</pre>';
			$biayaseleksi=array();
			foreach ($jenisgroup['all'][0] as $ka => $va)
			{
				if(strtolower($va->jenis)=='biaya seleksi')
				{
					$biayaseleksi=$va;
				}
			}
			// echo '<pre>';
			// echo '</pre>';
			$level=str_replace('%20', ' ', $level);
			list($l,$idl,$lv,$kt)=explode('__', $level);

			if($jenis=='baru')
			{
				if($kt=='pg')
				{
					$kt='pg_baru';
				}
				else if($kt=='tk')
				{
					$kt='tk_baru';
				}
				else if($kt=='sd')
				{
					if($sab=='ya')
						$kt='sd_baru';
					else
						$kt='sd_baru_non_sab';
				}
				else if($kt=='sm')
				{
					if($sab=='ya')
						$kt='sm_sab';
					else
						$kt='sm_non_sab';
				}
			}
			// echo $kt;
			// echo '<pre>';
			// // print_r($biayaseleksi);
			// print_r($jenisgroup[$kt]);
			// echo '</pre>';
			if(isset($jenisgroup[$kt]))
			{
				// list($)
				$data['jenisgroup']=$jenisgroup[$kt];
				$data['biayaseleksi']=$biayaseleksi;
				$data['jenis']=$jenis;
				$data['level']=$level;
				$data['siswa']=$siswa;
				$data['kt']=strtoupper($kt);
				$this->load->view('isi/home/jenisgroup',$data);
			}
		}
	}

	function nolkan($idtagihan)
	{
		$this->db->set('sisa_bayar',0);
		$this->db->where('id_tagihan',$idtagihan);
		$this->db->update('t_tagihan_siswa');
	}

	function hapusdataclub()
	{
		// echo '<pre>';
		// print_r($_POST);
		// echo '</pre>';
		
		if(isset($_POST['hapusdata']))
		{
			foreach($_POST['hapusdata'] as $k =>$v)
			{
				// echo $k.'-';
				$this->db->set('status_tampil','f');
				$this->db->where('id',$k);
				$this->db->update('t_data_club_siswa');
			}
			$this->session->set_flashdata('pesan','Data Club Siswa Berhasil Dihapus');
			redirect('penerimaan/dataclub','location');
		}
		else
		{
			$s=$this->db->from('t_data_club_siswa')->where('status_tampil','t')->get();
			foreach($s->result() as $k =>$v)
			{
				// echo $k.'-';
				$this->db->set('status_tampil','f');
				$this->db->where('id',$v->id);
				$this->db->update('t_data_club_siswa');
			}
			$s->free_result();
			$this->session->set_flashdata('pesan','Data Club Siswa Berhasil Dihapus');
			redirect('penerimaan/dataclub','location');
		}
	}
}
