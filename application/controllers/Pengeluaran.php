<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once('Main.php');
class Pengeluaran extends Main {

	public function index()
	{
		// $data['d']=$this->load->view('index.html');
		$data=array(
			'title' => 'Pengeluaran ',
			'isi' => 'isi/pengeluaran/index',
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
			'title' => 'Pengeluaran : Jenis Pengeluaran',
			'isi' => 'isi/pengeluaran/jenis-index',
			'navbar' => 'layout/navbar',
			'footer' => 'layout/footer'
		);
		$this->load->view('index',$data);
	}
	function jenisdata()
	{
		$d=$this->db->from('t_jenis_pengeluaran')->where('status_tampil','t')->order_by('jenis')->get();
		$data['d']=$d;
		$this->load->view('isi/pengeluaran/jenis-data',$data);
	}
	function jenisform($id=-1,$child=null)
	{
		$data['id_parent']=0;
		$data['child']='';
		if($id!=-1)
		{
			$d=$this->db->from('t_jenis_pengeluaran')->where('id',$id)->get();
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
		$this->load->view('isi/pengeluaran/jenis-form',$data);
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
				$c=$this->db->update('t_jenis_pengeluaran',$data);
				
				if($c)
					echo 'Data Jenis Pengeluaran Berhasil Di Edit';
				else
					echo 'Data Jenis Pengeluaran Gagal Di Edit';

			}
			else
			{
				$c=$this->db->insert('t_jenis_pengeluaran',$data);
				
				if($c)
					echo 'Data Jenis Pengeluaran Berhasil Di Simpan';
				else
					echo 'Data Jenis Pengeluaran Gagal Di Simpan';
			}	
		}
		else
			echo 'Data Jenis Pengeluaran Gagal Di Simpan';
	}
	function jenishapus($id)
	{
		$this->db->query('update t_jenis_pengeluaran set status_tampil="f" where id="'.$id.'"');
		echo 'Data Jenis Pengeluaran Berhasil Di Hapus';
	}
//-----------------------------------------------------------------------

	public function tagihan()
	{
		// $data['d']=$this->load->view('index.html');
		$data=array(
			'title' => 'Pengeluaran : Data Tagihan',
			'isi' => 'isi/pengeluaran/tagihan-index',
			'navbar' => 'layout/navbar',
			'footer' => 'layout/footer'
		);
		$this->load->view('index',$data);
	}
	function tagihandata()
	{
		$this->load->view('isi/pengeluaran/tagihan-data');
	}
//-----------------------------------------------------------------------
}