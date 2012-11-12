<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Class name: Master Data
version : 1.0
Author : Iswan Putera
*/

class Master extends CI_Controller {
	public $userid;
	function __construct(){
		parent::__construct();
		$this->load->model("Admin_model");
		$this->load->model("control_model");
		$this->load->model("akun_model");
		$this->load->model("purch_model");
		$this->load->library("zetro_auth");
		$this->userid=$this->session->userdata('idlevel');
	}
	
	function Header(){
		$this->load->view('admin/header');	
	}
	
	function Footer(){
		$this->load->view('admin/footer');	
	}
	function list_data($data){
		$this->data=$data;
	}
	function View($view){
		$this->Header();
		//$this->zetro_auth->view($view);
		$this->load->view($view,$this->data);	
		$this->Footer();
	}
	function tools(){
		$datax=$this->akun_model->get_neraca_head("='0'");
		$data=$this->akun_model->get_neraca_head();
		$this->zetro_auth->menu_id(array('settingshu','settingneraca'));
		$this->list_data($this->zetro_auth->auth(array('head','shu'),array($data,$datax)));
		$this->View('master/master_tools');
	}
	function shu(){
		$datax=$this->akun_model->get_neraca_head("='0'");
		$data=$this->akun_model->get_neraca_head();
		$this->zetro_auth->menu_id(array('komponenshu'));
		$this->list_data($this->zetro_auth->auth(array('head','shu'),array($data,$datax)));
		$this->View('master/master_shu');
	}
	function kas_harian(){
		$this->zetro_auth->menu_id(array('kas_harian','kas_keluar'));
		$this->list_data($this->zetro_auth->auth());
		$this->View('master/master_kas_harian');
	}
	function vendor(){
		$this->zetro_auth->menu_id(array('addvendor','listvendor'));
		$this->list_data($this->zetro_auth->auth());
		$this->View('master/master_vendor');
	}
	function general(){
		$this->zetro_auth->menu_id(array('kas'));
		$this->list_data($this->zetro_auth->auth());
		$this->View('master/master_general');
	}
	
	function set_config_file($filename){
		$this->filename=$filename;
	}
	function simpan_kas(){
		$data=array();
		$data['id_kas']	=strtoupper($_POST['id_kas']);
		$data['nm_kas']	=strtoupper($_POST['nm_kas']);
		$data['sa_kas']	=($_POST['sa_kas']);
		$data['sl_kas']	=empty($_POST['sl_kas'])?0:$_POST['sl_kas'];
		$data['created_by']	=$this->session->userdata('userid');
			$this->Admin_model->replace_data('mst_kas',$data);
			$this->list_data_akun();
	}
	function simpan_kas_harian(){
		$data=array();$datax=array();
		$data['no_trans']=$_POST['no_trans'];
		$data['id_kas']	=strtoupper($_POST['id_kas']);
		$data['nm_kas']	=strtoupper($_POST['nm_kas']);
		$data['sa_kas']	=($_POST['sa_kas']);
		$data['tgl_kas']=tglToSql($_POST['tgl_kas']);
		$data['created_by']	=$this->session->userdata('userid');
			$this->Admin_model->replace_data('mst_kas_harian',$data);
		$datax['nomor']=$_POST['no_trans'];
		$datax['jenis_transaksi']	='D';
		$this->Admin_model->replace_data('nomor_transaksi',$datax);
		$this->list_kas_harian();
	}
	function simpan_kas_keluar(){
		$data=array();$datax=array();$sal_kas=0;$tot_trans=0;
		$sal_kas	=rdb('mst_kas_harian','saldo_kas','sum(sa_kas) as saldo_kas',"where tgl_kas='".tglToSql($_POST['tgl_transaksi'])."'");
		$tot_trans	=rdb('mst_kas_trans','jumlah','sum(jumlah) as jumlah',"where tgl_trans='".tglToSql($_POST['tgl_transaksi'])."'");
		$data['id_kas']		=strtoupper($_POST['akun_transaksi']);
		$data['id_trans']	=($_POST['no_transaksi']);
		$data['jumlah']		=$_POST['harga_beli'];
		$data['saldo_kas']	=($sal_kas-$tot_trans-$_POST['harga_beli']);
		$data['uraian_trans']=ucwords($_POST['ket_transaksi']);
		$data['tgl_trans']	=tglToSql($_POST['tgl_transaksi']);
		$data['created_by']	=$this->session->userdata('userid');
		//update nomor transaski
		$datax['nomor']		=$_POST['no_transaksi'];
		$datax['jenis_transaksi']	='D';
		//print_r($datax);
			$this->Admin_model->replace_data('nomor_transaksi',$datax);
			$this->Admin_model->replace_data('mst_kas_trans',$data);
			$this->list_kas_trans();
	}
	function get_datakas(){
		$data=array();
		$data=$this->Admin_model->show_single_field('mst_kas','id_kas',' order by id_kas');
		echo $data;

	}
	function get_datailkas(){
		$data=array();
		$data=$this->Admin_model->show_list('mst_kas');
		echo json_encode($data[0]);
	}	
	function _filename(){
		//configurasi data untuk generate form & list
		$this->zetro_buildlist->config_file('asset/bin/zetro_master.frm');
		$this->zetro_buildlist->aksi();
		$this->zetro_buildlist->icon();
	}
	function _generate_list($data,$section,$list_key='nm_barang',$icon='deleted',$aksi=true,$sub_total=false){
			//prepare table
			$this->_filename();
			$this->zetro_buildlist->aksi($aksi); 
			$this->zetro_buildlist->section($section);
			$this->zetro_buildlist->icon($icon);
			$this->zetro_buildlist->query($data);
			//bulid subtotal
			$this->zetro_buildlist->sub_total($sub_total);
			$this->zetro_buildlist->sub_total_kolom('4,5');
			$this->zetro_buildlist->sub_total_field('stock,blokstok');
			//show data in table
			$this->zetro_buildlist->list_data($section);
			$this->zetro_buildlist->BuildListData($list_key);
	}
	function list_kas_harian(){
		$data=array();	
		$data=array();$n=0;
		$data=$this->Admin_model->show_list('mst_kas_harian',"where month(tgl_kas)='".date('m')."' and year(tgl_kas)='".date('Y')."' order by id_kas");
		foreach($data as $r){
			$n++;
			echo tr().td($n,'center').td($r->no_trans,'center').
				 td(tglfromSql($r->tgl_kas),'center').
				 td($r->id_kas).td($r->nm_kas).td(number_format($r->sa_kas,2),'right').
				 //td("<img src='".base_url()."asset/images/no.png' onclick=\"image_click('".$r->no_trans."','del');\" >",'center').
				 _tr();
		}
	}
	function list_kas_trans(){
		$data=array();	
		$data=array();$n=0;
		$tanggal=tgltoSql($_POST['tanggal']);
		$data=$this->Admin_model->show_list('mst_kas_trans',"where tgl_trans='".$tanggal."' order by id_trans");
		foreach($data as $r){
			$n++;
			echo tr().td($n,'center').td($r->id_trans,'center').
				 td(tglfromSql($r->tgl_trans),'center').
				 td($r->id_kas).td($r->uraian_trans).
				 td(number_format($r->jumlah,2),'right').
				 td(number_format($r->saldo_kas,2),'right').
				 //td("<img src='".base_url()."asset/images/no.png' onclick=\"image_click('".$r->id_trans."','del');\" >",'center').
				 _tr();
		}
	}
	function list_data_akun(){
		$data=array();$n=0;
		$data=$this->Admin_model->show_list('mst_kas','order by id_kas');
		foreach($data as $r){
			$n++;
			echo tr().td($n,'center').
				 td($r->id_kas).td($r->nm_kas).td($r->sa_kas).
				 td("<img src='".base_url()."asset/images/no.png' onclick=\"image_click('".$r->id_kas."','del');\" >",'center').
				 _tr();
		}
	}
// seting shu dan neraca
	function get_subneraca(){
		$ID=$_POST['ID'];$n=0;
		$data=$this->akun_model->get_neraca_sub($ID);
		foreach($data as $row){
		$n++;	
			echo "<tr class='xx' align='center'>
				 <td class='kotak'>$n</td>
				 <td class='kotak' align='left'>".$row->SubJenis."</td>
				 <td class='kotak' align='left'>".$row->ID_Calc."</td>
				 <td class='kotak'>".$row->ID_KBR."</td>
				 <td class='kotak'>".$row->ID_USP."</td>
				 </tr>\n";
		}
		
	}
	function get_head_shu(){
		echo $data;	
	}
//vendor transaction
	function get_next_id(){
		$data=0;
		$data=$this->Admin_model->show_single_field('mst_anggota','ID',"where ID_Jenis='2' order by ID desc limit 1");
		$data=($data+1);
		if(strlen($data)==1){
			$data='000'.$data;
		}else if(strlen($data)==2){
			$data='00'.$data;
		}else if(strlen($data)==3){
			$data='0'.$data;
		}else if(strlen($data)>=4){
			$data=$data;
		}
		echo $data;
	}
  	
	function set_data_vendor(){
		$data=array();
		$data['ID']			=round($_POST['ID']);
		$data['Nama']		=addslashes(strtoupper($_POST['pemasok']));
		$data['Alamat']		=empty($_POST['alamat'])?'':ucwords(addslashes($_POST['alamat']));
		$data['Kota']		=empty($_POST['kota'])?'':ucwords($_POST['kota']);
		$data['Propinsi']	=empty($_POST['propinsi'])?'':ucwords($_POST['propinsi']);
		$data['Telepon']	=empty($_POST['telepon'])?'':$_POST['telepon'];
		$data['Faksimili']	=empty($_POST['faksimili'])?'':$_POST['faksimili'];
		$data['Status'] 	='aktif';
		$data['ID_Jenis']	='2';
		//print_r($data);
		$this->Admin_model->replace_data('mst_anggota',$data);
	}
	function list_vendor(){
		$data=array(); $n=0;
		$nama=empty($_POST['nama'])?$where="where ID_Jenis='2'":$where="where Nama like '%".$_POST['nama']."%' and ID_Jenis='2'";
		$data=$this->Admin_model->show_list('mst_anggota',$where.' order by Nama');
		foreach($data as $row){
			$n++;
			echo tr('xx\' onClick="_show_detail(\''.$row->ID.'\');" attr=\'ax').td($n,'center').td($row->ID,'center').td($row->Nama).
				 td($row->Alamat).td($row->Kota).td($row->Propinsi).
				 td($row->Telepon).td($row->Faksimili).td().
				 _tr();
		}
	}
	
	function vendor_detailed(){
		$data=array();$n=0;$total=0;
		$ID=$_POST['id'];
		$data=$this->purch_model->detail_trans_vendor("where p.ID_Pemasok='".$ID."' order by p.Tanggal limit 500");
		foreach($data as $r){
		 $n++;
		 echo tr().td($n,'center').
		 		   td(tglfromSql($r->Tanggal)).
				   td($r->Nomor).
				   td($r->Nama_Barang).
				   td(number_format($r->Jumlah,2),'right').
				   td($r->Satuan).
				   td(number_format(($r->Jumlah*$r->Harga_Beli),2),'right').
				  _tr();	
		$total=($total+($r->Jumlah*$r->Harga_Beli));
		}
		echo tr().td('<b>Total</b>','right\' colspan=\'6','kotak list_genap').td('<b>'.number_format($total,2).'</b>','right')._tr();
	}
}
