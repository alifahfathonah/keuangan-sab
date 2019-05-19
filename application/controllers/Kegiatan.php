<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Kegiatan extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    function index($id=-1)
    {
        $sasaran_mutu=$this->db->from('t_sasaran_mutu')->where('flag','1')->get()->result();
        $data=array(
			'title' => 'Data Kegiatan',
			'isi' => 'isi/program/kegiatan/index',
			'navbar' => 'layout/navbar',
            'footer' => 'layout/footer',
            'sasaranmutu' => $sasaran_mutu,
            'id' => $id
		);
        $this->load->view('index',$data);
    }
    function form($id=-1)
    {
        $program=$this->db->from('t_program')->where('flag','1')->get()->result();
        $sasaran_mutu=$this->db->from('t_sasaran_mutu')->where('flag','1')->get()->result();
        $data['program'] = $program;
        $data['sasaranmutu'] = $sasaran_mutu;
        $data['d'] = array();
        $data['id'] = $id;
        $data['kodeakun']=$this->config->item('takun');
        if($id!=-1)
        {
            $d=$this->db->from('t_kegiatan')->where('id',$id)->get();
            $data['d']=$d;
        }
        $this->load->view('isi/program/kegiatan/form',$data);
    }
    function data($id=-1)
	{
        $prog=$this->db->from('t_program')->where('flag','1')->get()->result();
        $program=array();
        foreach($prog as $k=>$v)
        {
            $program[$v->id]=$v;
        }
        $data['kodeakun']=$this->config->item('takun');
        $sasaranmutu=$this->db->from('t_sasaran_mutu')->where('flag','1')->order_by('sasaran_mutu')->get()->result();
        $sm=array();
        foreach($sasaranmutu as $k=>$v)
        {
            $sm[$v->id]=$v;
        }
        $data['sasaranmutu'] = $sm;
        $data['program'] = $program;
        if($id==-1)
		    $data['d']=$this->db->from('t_kegiatan')->where('flag','1')->order_by('sasaran_mutu_id','asc')->get()->result();
        else   
            $data['d']=$this->db->from('t_kegiatan')->where('sasaran_mutu_id',$id)->where('flag','1')->order_by('sasaran_mutu_id','asc')->get()->result();
		$this->load->view('isi/program/kegiatan/data',$data);
	}
    function proses($id)
	{
		if(!empty($_POST))
		{
			// print_r($_POST);
			// $data=$_POST;
            $data['flag']='1';
            list($id_sm,$sm)=explode('::',$_POST['sasaran_mutu']);
            // list($kd_akun,$nm_akun)=explode('::',$_POST['kode_akun']);
            // $data['kode_akun']=$kd_akun;
            $data['kegiatan']=$_POST['kegiatan'];
            $data['program_id']=$_POST['program_id'];
            $data['sasaran_mutu_id']=$id_sm; 
            $data['updated_at']=date('Y-m-d H:i:s');
			if($id!=-1)
			{
				// unset($data['id_bank']);
				$this->db->where('id',$id);
				$c=$this->db->update('t_kegiatan',$data);

				if($c)
					echo 'Data Kegiatan Berhasil Di Edit';
				else
					echo 'Data Kegiatan Gagal Di Edit';

			}
			else
			{
                $data['created_at']=date('Y-m-d H:i:s');
				$c=$this->db->insert('t_kegiatan',$data);

				if($c)
					echo 'Data Kegiatan Berhasil Di Simpan';
				else
					echo 'Data Kegiatan Gagal Di Simpan';
			}
		}
		else
			echo 'Data Kegiatan Gagal Di Simpan';
    }
    
    function hapus($id)
    {
        $this->db->query('update t_sasaran_mutu set flag="0" where id="'.$id.'"');
		echo 'Data Sasaran Mutu Berhasil Di Hapus';
    }

    function byprogram($id)
    {
        $program=$this->db->from('t_program')->where('id',$id)->get()->result();
        $byid=$this->db->from('t_kegiatan')->where('program_id',$id)->get()->result();
        $akun=$this->config->item('takun');

        echo '<div>';
        if(count($byid)==0)
        {
        echo '<span class="input-icon">
				<select class="col-xs-12 col-sm-12 chosen-select frm" id="jenis" data-placeholder="Pilih Program Pengeluaran">
                <option value="">--Pilih--</option>';
            $jenis=$this->db->from('t_jenis_pengeluaran')->where('status_tampil','t')->get()->result();
            foreach($jenis as $k => $v)
			{
				echo '<option value="'.$v->id.'__'.$v->jenis.'__'.$v->kodeakun.'">'.$v->jenis.'</option>';
			}
        }
        else
        {
            echo '<input type="hidden" id="program_id" value="'.$program[0]->program.'">';
             echo '<span class="input-icon">
				<select class="col-xs-12 col-sm-12 chosen-select frm" id="jenis" data-placeholder="Pilih Program Pengeluaran" onchange="cekkegiatan(this.value)">
                <option value="">--Pilih--</option>';
       
            $k_akun=strtok($program[0]->kode_akun,'::');
            $kode_akun=$akun[$k_akun];
            foreach($byid as $k => $v)
            {
                //'.$v->id.'__'.$v->jenis.'__'.$v->kodeakun.'
                echo '<option value="'.$v->id.'__'.$v->kegiatan.'__'.$kode_akun->akun_alternatif.'-'.$kode_akun->kode_akun.'-'.$kode_akun->nama_akun.'">'.ucwords($v->kegiatan).'</option>';
            }
        }
        echo '</select></span>';
        echo '</div>';
    }
}