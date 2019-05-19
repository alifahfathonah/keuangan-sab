<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sasaranmutu extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    function index()
    {
        
        $data=array(
			'title' => 'Data Sasaran Mutu ',
			'isi' => 'isi/program/sasaran-mutu/index',
			'navbar' => 'layout/navbar',
			'footer' => 'layout/footer'
		);
        $this->load->view('index',$data);
    }
    function form($id=-1)
    {
        $data['tajaran']=$this->config->item('tajaran');
        $program=$this->db->from('t_program')->where('flag','1')->get()->result();
        $data['program'] = $program;
        $data['d'] = array();
        $data['id'] = $id;
        if($id!=-1)
        {
            $d=$this->db->from('t_sasaran_mutu')->where('id',$id)->get();
            $data['d']=$d;
        }
        $this->load->view('isi/program/sasaran-mutu/form',$data);
    }
    function data()
	{
        $d=$this->db->from('t_sasaran_mutu')->where('flag','1')->order_by('sasaran_mutu')->get();
        $prog=$this->db->from('t_program')->where('flag','1')->get()->result();
        $program=array();
        foreach($prog as $k=>$v)
        {
            $program[$v->id]=$v;
        }
        $data['program'] = $program;
		$data['d']=$d->result();
		$this->load->view('isi/program/sasaran-mutu/data',$data);
	}
    function proses($id)
	{
		if(!empty($_POST))
		{
			// print_r($_POST);
			// $data=$_POST;
            $data['flag']='1';
            $data['sasaran_mutu']=$_POST['sasaran_mutu'];
            $data['program_id']=$_POST['program_id'];
            $data['program_id']=$_POST['program_id'];
            $data['tahun_ajaran']=$_POST['tahun_ajaran'];
            
            $data['updated_at']=date('Y-m-d H:i:s');
			if($id!=-1)
			{
				// unset($data['id_bank']);
				$this->db->where('id',$id);
				$c=$this->db->update('t_sasaran_mutu',$data);

				if($c)
					echo 'Data Sasaran Mutu Berhasil Di Edit';
				else
					echo 'Data Sasaran Mutu Gagal Di Edit';

			}
			else
			{
                $data['created_at']=date('Y-m-d H:i:s');
				$c=$this->db->insert('t_sasaran_mutu',$data);

				if($c)
					echo 'Data Sasaran Mutu Berhasil Di Simpan';
				else
					echo 'Data Sasaran Mutu Gagal Di Simpan';
			}
		}
		else
			echo 'Data Sasaran Mutu Gagal Di Simpan';
    }
    
    function hapus($id)
    {
        $this->db->query('update t_sasaran_mutu set flag="0" where id="'.$id.'"');
		echo 'Data Sasaran Mutu Berhasil Di Hapus';
    }

    function byprogram($id)
    {
        $byid=$this->db->from('t_sasaran_mutu')->where('program_id',$id)->get()->result();
        echo '<select id="sasaran_mutu" name="sasaran_mutu"  data-rel="chosen" class="col-xs-12 col-sm-8 chosen-select">
                <option value="">--Pilih--</option>';
        foreach($byid as $k => $v)
        {
            echo '<option value="'.$v->id.'::'.$v->sasaran_mutu.'">'.ucwords($v->sasaran_mutu).'</option>';
        }
        echo '</select>';
    }
}