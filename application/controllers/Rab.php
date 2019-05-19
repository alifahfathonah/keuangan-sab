<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Rab extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    function index()
    {
        
        $data=array(
			'title' => 'Rencana Anggaran Biaya',
			'isi' => 'isi/program/rab/index',
			'navbar' => 'layout/navbar',
			'footer' => 'layout/footer'
		);
        $this->load->view('index',$data);
    }
    function form($id)
    {
        $data['id']=$id;
        $data['tajaran']=$this->config->item('tajaran');
        $data['kegiatan']=$this->db->from('t_kegiatan')->where('flag','1')->order_by('sasaran_mutu_id')->get()->result();
        // $data['sasaranmutu']=$this->db->from('t_sasaran_mutu')->where('flag',1)->get()->result();
        $data['pic']=$this->db->from('t_guru')->where('status_tampil','t')->get()->result();
        $this->load->view('isi/program/rab/form',$data);
    }
    function data($tahunajaran)
    {
        $tahunajaran=str_replace('__',' / ',$tahunajaran);
        list($l1,$l2)=explode('/',$tahunajaran);
        $l1=trim($l1);
        $l2=trim($l2);
        $data['tajaran']=$this->config->item('tajaran');
        $kegiatan=$this->db->from('t_kegiatan')->where('flag',1)->get()->result();
        $s=$this->db->from('t_sasaran_mutu')->where('flag',1)->get()->result();

        $rab=$this->db->from('t_rab')->where('tahun_ajaran',$tahunajaran)->where('flag','1')->get()->result();
        
        $sm=array();
        foreach($s as $k => $v)
        {
            $sm[$v->id]=$v;
        }
        $data['sasaranmutu']=$sm;
        
        $kg=array();
        foreach($kegiatan as $k => $v)
        {
            $kg[$v->id]=$v;
        }
        $data['kegiatan']=$kg;

        $d_rab=array();
        foreach($rab as $r => $b)
        {
            $d_rab[$b->sasaran_mutu_id][]=$b;
        }
        $pic=$this->db->from('t_guru')->where('status_tampil','t')->get()->result();
        $data['pic']=$pic;
        $data['rab']=$d_rab;
        $data['tahunajaran']=$tahunajaran;
        
        
        $this->load->view('isi/program/rab/data',$data);
    }
    function proses($id)
    {
        // echo '<pre>';
        // print_r($_POST);
        // echo '</pre>';
        
        list($id_kg,$kg)=explode('::',$_POST['kegiatan']);
        
        $kegiatan=$this->db->from('t_kegiatan')->where('id',$id_kg)->get()->result();

        $pic=$id_pic='';
        foreach($_POST['pic'] as $kk => $vv)
        {
            list($i1,$i2)=explode('::',$vv);
            $pic.=$i2.',';
            $id_pic.=$i1.',';
        }
        $pic=substr($pic,0,-1);
        $id_pic=substr($id_pic,0,-1);
        $data['kegiatan']=$_POST['kegiatan'];
        $data['sasaran_mutu_id']=$kegiatan[0]->sasaran_mutu_id;
        $data['program_id']=$kegiatan[0]->program_id;
        $data['pic']=$pic;
        $data['pic_id']=$id_pic;
        $data['bulan']=$_POST['bulan'];
        $data['tahun']=$_POST['tahun'];
        $data['tahun_ajaran']=$_POST['tahun_ajaran'];
        $data['keterangan']=$_POST['keterangan'];
        $data['anggaran']=str_replace(array(',','.'),'',$_POST['anggaran']);
        $data['flag']='1';
        $data['updated_at']=date('Y-m-d H:i:s');
        if($id!=-1)
        {
            $this->db->where('id',$id);
			$c=$this->db->update('t_rab',$data);

			if($c)
				echo 'Data RAB Berhasil Di Edit';
			else
				echo 'Data RAB Gagal Di Edit';
        }
        else
        {
            $data['created_at']=date('Y-m-d H:i:s');
            $c=$this->db->insert('t_rab',$data);

			if($c)
				echo 'Data RAB Berhasil Di Simpan';
			else
				echo 'Data RAB Gagal Di Simpan';
        }
        redirect('rab','location');
    }
}