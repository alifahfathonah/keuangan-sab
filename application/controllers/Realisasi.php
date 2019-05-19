<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Realisasi extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    function index()
    {
        $program=$this->db->from('t_program')->where('flag',1)->get()->result();
        $data=array(
			'title' => 'Realisasi Anggaran Biaya Program',
			'isi' => 'isi/program/realisasi/index',
			'navbar' => 'layout/navbar',
			'program' => $program,
			'footer' => 'layout/footer'
		);
        $this->load->view('index',$data);
    }

    function data($bulan,$tahun,$program_id)
    {
        if($program_id==-1)
            $prog=$this->db->from('t_program')->where('flag',1)->get()->result();
        else
            $prog=$this->db->from('t_program')->where('id',$program_id)->where('flag',1)->get()->result();

        $kegiatan=$this->db->from('t_kegiatan')->where('flag',1)->get()->result();
        $s=$this->db->from('t_sasaran_mutu')->where('flag',1)->get()->result();

        $rab=$this->db->from('t_rab')->where('tahun',$tahun)->where('bulan',$bulan)->where('flag','1')->get()->result();
        $data['program_id']=$program_id;
        $data['program']=$prog;
        $data['bulan']=$bulan;
        $data['tahun']=$tahun;
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
        $tahunajaran='';
        foreach($rab as $r => $b)
        {
            $d_rab[$b->sasaran_mutu_id][]=$b;
            $tahunajaran=$b->tahun_ajaran;
        }

        $data['rab']=$d_rab;
        $data['tahunajaran']=$tahunajaran;
        $this->load->view('isi/program/realisasi/data',$data);
    }
}