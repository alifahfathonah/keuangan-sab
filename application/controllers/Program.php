<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Program extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    function index()
    {
        
        $data=array(
			'title' => 'Data Program ',
			'isi' => 'isi/program/jenis/index',
			'navbar' => 'layout/navbar',
			'footer' => 'layout/footer'
		);
        $this->load->view('index',$data);
    }
    function programform($id=-1)
    {
        $guru=$this->db->from('t_guru')->where('status_tampil','t')->get()->result();
        $data['leader'] = $guru;
        $data['d'] = array();
		$data['id'] = $id;
		$data['kodeakun']=$this->config->item('takun');
        if($id!=-1)
        {
            $d=$this->db->from('t_program')->where('id',$id)->get();
            $data['d']=$d;
        }
        $this->load->view('isi/program/jenis/form',$data);
    }
    function programdata()
	{
		$d=$this->db->from('t_program')->where('flag','1')->order_by('program')->get();
		$data['d']=$d->result();
		$this->load->view('isi/program/jenis/data',$data);
	}
    function programproses($id)
	{
		if(!empty($_POST))
		{
			// print_r($_POST);
			// $data=$_POST;
            $data['flag']='1';
            $data['program']=$_POST['program'];
            $leader=$_POST['leader_id'];
            list($id_ld,$ld)=explode('__',$leader);
            $data['nama_leader']=$ld;
            $data['leader_id']=$id_ld;
            $data['kode_akun']=$_POST['kode_akun'];
            
            $data['updated_at']=date('Y-m-d H:i:s');
			if($id!=-1)
			{
				// unset($data['id_bank']);
				$this->db->where('id',$id);
				$c=$this->db->update('t_program',$data);

				if($c)
					echo 'Data Bank Berhasil Di Edit';
				else
					echo 'Data Bank Gagal Di Edit';

			}
			else
			{
				$data['created_at']=date('Y-m-d H:i:s');
				$c=$this->db->insert('t_program',$data);

				if($c)
					echo 'Data Bank Berhasil Di Simpan';
				else
					echo 'Data Bank Gagal Di Simpan';
			}
		}
		else
			echo 'Data Bank Gagal Di Simpan';
    }
    
    function programhapus($id)
    {
        $this->db->query('update t_program set flag="0" where id="'.$id.'"');
		echo 'Data Program Berhasil Di Hapus';
    }
}