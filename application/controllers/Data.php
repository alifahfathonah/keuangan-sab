<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data extends CI_Controller {


	public function tagihan()
	{
        $bulan_awal=2;
        $data['tahun_awal']=$tahun_awal=2018;
        $data['range_bulan1']=$range_bulan1=[2,3,4,5,6];
		$bulan_akhir=9;
        $data['tahun_akhir']=$tahun_akhir=2018;
        $data['range_bulan2']=$range_bulan2=[7,8,9];
        $data['tahun_ajaran1']=gettahunajaranbybulan($bulan_awal,$tahun_awal);
        $data['tahun_ajaran2']=gettahunajaranbybulan($bulan_akhir,$tahun_akhir);
        // $data['jns_lvl']=$this->config->item('jenispenerimaan');
        $data['jns_lvl']=array('Catering','Club','Jemputan','Jemputan Club','SPP','DU/Investasi');
        $data['tagihan']=$tagihan=$this->config->item('ttagihanbybulanjenis');
        $data['kelas_ta']=$this->config->item('kelas_ta');
        $data['levelkelas']=$this->config->item('levelkelas');

        $vbs=$this->db->from('v_batch_siswa')->order_by('nama_murid asc,id_tbs desc')->get();
        $siswa=array();
        foreach($vbs->result() as $k => $v)
        {
           $siswa[$v->tahun_ajaran][$v->id_batch][$v->nisn]=$v;
        }
        $vbs->free_result();
        $data['siswa']=$siswa;
        $data['tahun_inves']=2017;
        $this->load->view('akreditasi',$data);
        // $tagihan1=$this->db->from('v_tagihan_siswa')->where('tahun_ajaran',$tahun_ajaran1)->get()->result();
        // $tagihan2=$this->db->from('v_tagihan_siswa')->where('tahun_ajaran',$tahun_ajaran2)->get()->result();

    }
	public function tagihan2()
	{
        $bulan_awal=9;
        $data['tahun_awal']=$tahun_awal=2018;
        $data['range_bulan1']=$range_bulan1=[7,8,9];
		$bulan_akhir=9;
        $data['tahun_akhir']=$tahun_akhir=2018;
        $data['range_bulan2']=$range_bulan2=[7,8,9];
        $data['tahun_ajaran1']=gettahunajaranbybulan($bulan_awal,$tahun_awal);
        $data['tahun_ajaran2']=gettahunajaranbybulan($bulan_akhir,$tahun_akhir);
        // $data['jns_lvl']=$this->config->item('jenispenerimaan');
        $data['jns_lvl']=array('Catering','Club','Jemputan','Jemputan Club','SPP','DU/Investasi');
        $data['tagihan']=$tagihan=$this->config->item('ttagihanbybulanjenis');
        $data['kelas_ta']=$this->config->item('kelas_ta');
        $data['levelkelas']=$this->config->item('levelkelas');

        $vbs=$this->db->from('v_batch_siswa')->order_by('nama_murid asc,id_tbs desc')->get();
        $siswa=array();
        foreach($vbs->result() as $k => $v)
        {
           $siswa[$v->tahun_ajaran][$v->id_batch][$v->nisn]=$v;
        }
        $vbs->free_result();
        $data['siswa']=$siswa;
        $data['tahun_inves']=2018;
        $this->load->view('akreditasi',$data);
        // $tagihan1=$this->db->from('v_tagihan_siswa')->where('tahun_ajaran',$tahun_ajaran1)->get()->result();
        // $tagihan2=$this->db->from('v_tagihan_siswa')->where('tahun_ajaran',$tahun_ajaran2)->get()->result();

    }
}