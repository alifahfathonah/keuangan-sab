<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once('Main.php');
class Siswa extends Main {
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
			'title' => 'Siswa',
			'isi' => 'isi/siswa/index',
			'navbar' => 'layout/navbar',
			'footer' => 'layout/footer'
		);
		$this->load->view('index',$data);
	}

	function data($search='null')
	{
		$data['d']=$dd=array();
		$this->load->library('pagination');
		if($search=='null')
		{
			$where='status_tampil="t"';
		}
		else
		{
			$search=str_replace('%20', ' ', $search);
			$where='status_tampil="t" and (nama_murid like "%'.$search.'%" OR nis like "%'.$search.'%")';
		}
	
		$d=$this->db->from('v_siswa')->where($where)->get()->result();

		$config['per_page'] = 10;
		$urisegment=4;
		$config['base_url'] = site_url().'siswa/data/'.$search;
		$config['uri_segment'] = $urisegment; 
		
		$config['class_js']=$data['class_js'] = 'halsiswa'; 
		$query=$d;
		$jumlah=count($d);
		$config['total_rows'] = $jumlah;
		$this->pagination->initialize($config);
		$data['num']=$config['per_page'];
		$data['offset']=$config['uri_segment'];
		$data['hal']=$data['offset']=$this->uri->segment($urisegment);
		if (!$data['offset'])
		{
			$data['offset']=0;
		}
		$data['num'] = $config['per_page'];
		$data['search'] = $search;
		
		$dd=$this->db->from('v_siswa')->where($where)->limit($data['num'],$data['offset'])->get()->result();
		$data['dd']=$dd;
		$this->load->view('isi/siswa/data',$data);
	}
	
	function datava($search='null')
	{
		$data['d']=$dd=array();
		$this->load->library('pagination');
		if($search=='null')
		{
			$where='status_tampil="t"';
		}
		else
		{
			$search=str_replace('%20', ' ', $search);
			$where='status_tampil="t" and no_virtual_account like "%'.$search.'%"';
		}
	
		$d=$this->db->from('v_siswa')->where($where)->get()->result();

		$config['per_page'] = 10;
		$urisegment=4;
		$config['base_url'] = site_url().'siswa/data/'.$search;
		$config['uri_segment'] = $urisegment; 
		
		$config['class_js']=$data['class_js'] = 'halsiswa'; 
		$query=$d;
		$jumlah=count($d);
		$config['total_rows'] = $jumlah;
		$this->pagination->initialize($config);
		$data['num']=$config['per_page'];
		$data['offset']=$config['uri_segment'];
		$data['hal']=$data['offset']=$this->uri->segment($urisegment);
		if (!$data['offset'])
		{
			$data['offset']=0;
		}
		$data['num'] = $config['per_page'];
		$data['search'] = $search;
		
		$dd=$this->db->from('v_siswa')->where($where)->limit($data['num'],$data['offset'])->get()->result();
		$data['dd']=$dd;
		$this->load->view('isi/siswa/data',$data);
	}

	function form($id=-1)
	{
		// $data['id']=$id;
		$prop=$this->db->from('kelurahan')->where('status_tampil','1')->where('propinsi','0')->get();

		$dd=array();
		if($id!=-1)
		{
			$dd=$this->db->from('v_siswa')->where('status_tampil','t')->where('id',$id)->get()->result();
		}
		$data=array(
			'title' => 'Form '.($id==-1 ? 'Tambah' : 'Edit').' Siswa',
			'isi' => 'isi/siswa/form',
			'navbar' => 'layout/navbar',
			'prop' => $prop->result(),
			'footer' => 'layout/footer',
			'dd'=>$dd,
			'id'=>$id
		);
		$this->load->view('index',$data);
	}
	function proses($id=-1)
	{
		if(!empty($_POST))
		{
			if(empty($_POST['tanggal_lahir']))
				list($tgl,$bln,$thn)=explode('-', date('d-m-Y'));
			else
				list($tgl,$bln,$thn)=explode('-', $_POST['tanggal_lahir']);
			$data=$_POST;
			$data['tanggal_lahir']=$thn.'-'.$bln.'-'.$tgl;
			$data['alamat']=$data['alamat'];

			// echo '<pre>';
			// print_r($data);
			// echo '</pre>';
			if($id!=-1)
			{
			// $data['id']=$id;
				unset($data['id']);
				$this->db->where('id',$id);
				$this->db->update('t_siswa',$data);
			}
			else
			{
				$this->db->insert('t_siswa',$data);
				$id=$this->db->insert_id();
			}
			$this->session->set_flashdata('pesan','Data Siswa Berhasil Ditambah');
			redirect('siswa/form/'.$id,'location');
		}
	}

	function siswahapus($id)
	{
		$d['status_tampil']='i';
		$this->db->where('id',$id);
		$this->db->update('t_siswa',$d);
		// $this->session->set_flashdata('pesan','Data Siswa Berhasil Ditambah');
		echo 'Data Siswa Berhasil Di Hapus';
	}

	function importdata()
	{
		echo '<form action="'.site_url().'siswa/importdata" method="post" enctype="multipart/form-data">';
		echo '<input type="file" name="file"><input type="submit">';
		echo '</form>';

		if(!empty($_FILES['file']))
		{
			// echo '<pre>';
			// print_r($_FILES);
			// echo '</pre>';
			$file=read_file($_FILES['file']['tmp_name']);
			$f=explode("\n", $file);
			$dd=array();
			foreach ($f as $k => $v) 
			{
				if($v!='')
				{
					if($k!=0)
					{
						$tm=$tggl='';
						list($no,$nama,$panggilan,$kelamin,$nis,$nisn,$ttl,$alamat,$ayah,$telpa,$ibu,$telpi)=explode(';', $v);
						//echo $nama.'|'.$nis.'<br>';
						if($ttl!='')
						{
							list($tm,$tl)=explode(',', $ttl);
							$tggl=tanggal($tl);
						}

						$d['nama_murid']=$nama;
						$d['nama_panggilan']=$panggilan;
						$d['jenis_kelamin']=$kelamin;
						$d['tempat_lahir']=$tm;
						$d['tanggal_lahir']=$tggl;
						// $d['tanggal_lahir']=$ttl;
						$d['kebangsaan']="Indonesia";
						$d['kewarganegaraan']="Indonesia";
						$d['agama']="Islam";
						$d['alamat']=$alamat;
						$d['nis']=($nis=='' ? generate_id() : $nis);
						$d['nisn']=($nisn=='' ? '' : $nisn);
						$d['nama_ayah']=$ayah;
						$d['hp_ayah']=$telpa;
						$d['nama_ibu']=$ibu;
						$d['hp_ibu']=$telpi;
						$dd[]=$d;
					}
				}
			}
			// echo '<pre>';
			// print_r($dd);
			// echo '</pre>';
			$this->db->insert_batch('t_siswa', $dd);
		}
	}

	function simpanemail($ids)
	{
		$email=$_POST['email'];
		//echo $email;
		if($ids!=-1)
		{
			$data['email_ayah']=$email;
			$this->db->where('id',$ids);
			$c=$this->db->update('t_siswa',$data);
			if($c)
				echo 1;
			else
				echo 0;
		}
	}

	function importemail()
	{
		$data=array(
			'title' => 'Siswa',
			'isi' => 'isi/siswa/import-email',
			'navbar' => 'layout/navbar',
			'footer' => 'layout/footer'
		);
		$this->load->view('index',$data);
	}

	function importemailpost()
	{
		if(!empty($_FILES['file']))
        {
            $data=$_POST;
            $file=$_FILES['file']['tmp_name'];
            $objPHPExcel = PHPExcel_IOFactory::load($file);
            
            $totalsheet=$objPHPExcel->getAllSheets();
            $sheetNames = $objPHPExcel->getSheetNames();
            $sheetCount = $objPHPExcel->getSheetCount();
            
            $data['sis']=$siswa;
            $max=[];
            for($i = 0;$i<$sheetCount;$i++)
            {
                $cell_collection = $objPHPExcel->setActiveSheetIndex($i)->getCellCollection();
                $arr_data=$data_value=[];
                //echo count($cell_collection);
                foreach ($cell_collection as $cell) {
                    $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
                    $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                    $dv = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                    $type=PHPExcel_Cell_DataType::dataTypeForValue($dv);
                    if($type=='f')
                    {
                        $data_value=$objPHPExcel->getActiveSheet()->getCell($cell)->getOldCalculatedValue();
                    }
                    else
                    {
                        $data_value=$dv;
                    }
                    $arr_data[$row][$column] = $data_value;
                    // echo $row.'-';
                }

                // echo '<br>'.$i;
                // echo '<br>';
                // $data['header'][$sheetNames[$i]] = $header;
                $data['values'][trim($sheetNames[$i])] = $arr_data;
                $data['kelas'][$i] = trim($sheetNames[$i]);
            }
        }
	}

	function datakeluarga($jns,$id)
	{
		$data['jns']=$jns;
		$data['id']=$id;
		$dd=array();
		$dd=$this->db->from('v_siswa')->where('status_tampil','t')->where('id',$id)->get()->result();
		$data['dd']=$dd;
		
		if($jns=='ayah')
		{
			$this->load->view('isi/siswa/form-data-ayah',$data);
		}
		elseif($jns=='ibu')
		{
			$this->load->view('isi/siswa/form-data-ibu',$data);
		}
		elseif($jns=='wali')
		{
			$this->load->view('isi/siswa/form-data-wali',$data);
		}
		elseif($jns=='saudara')
		{
			$this->load->view('isi/siswa/form-data-saudara',$data);
		}
	}

	function simpandatakeluarga($jns,$id)
	{
		// echo '<pre>';
		// print_r($_POST);
		// echo '</pre>';
		$this->db->where('id',$id);
		$this->db->update('t_siswa',$_POST);
		$this->session->set_flashdata('pesan','Data '.ucwords($jns).' Berhasil Di Ubah');
		redirect('siswa/form/'.$id,'location');
	}
	function getsiswabaru()
	{
		// $url='http://mobile.sekolahalambogor.id/siswabaru.php';
		$url='siswa_baru.txt';
		$file=file_get_contents($url);
		$f=json_decode($file);
		$sis=$this->config->item('nsiswalower');
		// echo '<pre>';
		// print_r($f);
		// echo '</pre>';
		$data=array();
		$ada=0;
		foreach($f as $k => $v)
		{
			if(isset($sis[trim(strtolower($v->nama))]))
			{
				echo '<b>ADA</b> -- : '.$sis[trim(strtolower($v->nama))]->nisn.':'.$v->nama.'<br> ';
				$ada++;
			}
			$nis=abs(crc32(sha1(md5(rand()))));
			$data['nama_murid']=$v->nama;
			$data['nama_panggilan']=$v->nama_panggilan;
			$data['alamat']=$v->alamat;
			$data['nama_ayah']=$v->namaayah;
			$data['email']=$v->emailayah;
			$data['nama_ibu']=$v->namaibu;
			$data['email_ibu']=$v->emailibu;
			$data['nis']=$nis;
			$data['nisn']=$nis;
		}
		echo $ada;
		// file_put_contents('siswa_baru.txt',$file);
	}
	
}
