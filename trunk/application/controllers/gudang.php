<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Class name: gudang controller
version : 1.0
Author : Iswan Putera
*/

class Gudang extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->model("Admin_model");
		$this->load->model("inv_model");
		$this->load->model("kasir_model");
		$this->load->helper("print_report");
		$this->load->library('zetro_auth');
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
		$this->zetro_auth->view($view);
		$this->load->view($view,$this->data);	
		$this->Footer();
	}
	//tampilkan view
	function index(){
		//tampiklan view tambah barang
		//$this->inv_model->auto_data();
		$this->zetro_auth->menu_id(array('tambahbarang'));
		$this->list_data($this->zetro_auth->auth());
		$this->View('warehouse/material_new');

	}
	
	function list_barang(){
		//tampilkan view list barang
		//$this->inv_model->auto_data();
		$this->zetro_auth->menu_id(array('list'));
		$this->list_data($this->zetro_auth->auth());
		$this->View('inventory/material_list');
	}
	
	function kategori(){
		//tampilkan view kategori barang
		//$this->inv_model->auto_data();
		$this->zetro_auth->menu_id(array('kategoribarang'));
		$this->list_data($this->zetro_auth->auth());
		$this->View('inventory/master_inv');
	}
	function jenis(){
		//tampilkan view jenis barang
		//$this->inv_model->auto_data();
		$this->zetro_auth->menu_id(array('jenisbarang'));
		$this->list_data($this->zetro_auth->auth());
		$this->View('warehouse/material_jenis');
	}
	function satuan(){
		//tampilkan view satuan barang
		//$this->inv_model->auto_data();
		$this->zetro_auth->menu_id(array('satuanbarang'));
		$this->list_data($this->zetro_auth->auth());
		$this->View('warehouse/material_satuan');
	}
	function konversi(){
		//tampilkan view konversi satusn
		//$this->inv_model->auto_data();
		$this->zetro_auth->menu_id(array('konversisatuan'));
		$this->list_data($this->zetro_auth->auth());
		$this->View('warehouse/material_konversi');
	}
	
	function pemakaian(){
		$this->zetro_auth->menu_id(array('addpemakaian','listpemakaian'));
		$this->list_data($this->zetro_auth->auth());
		$this->View('warehouse/material_mutasi');
	}
	function set_pemakaian(){
		$data=array();
		$data['ID_Jenis']=$_POST['id_jenis'];
		$data['Tanggal']=tglToSql($_POST['tanggal']);
		$data['Bulan']	=substr($_POST['tanggal'],3,2);
		$data['Tahun']	=substr($_POST['tanggal'],6,4);
		$data['ID_Barang']=$_POST['id_barang'];
		$data['Jumlah']	=$_POST['jumlah'];
		$data['Harga']	=$_POST['harga'];
		$data['Keterangan']=empty($_POST['keterangan'])?'':$_POST['keterangan'];
		$this->Admin_model->replace_data('z_inv_pemakaian',$data);
	}
	
	function get_pemakaian(){
		$data=array();$n=0;
		$dari=tglToSql($_POST['dari_tgl']);
		$sampai=empty($_POST['sampai_tgl'])?$dari:tglToSql($_POST['sampai_tgl']);
		$where=empty($_POST['sampai_tgl'])? "where Tanggal='".$dari."'":
			   "where Tanggal between '".$dari."' and '".$sampai."'";
		$where.=" and ID_Jenis='".$_POST['id_jenis']."'";
		$where.=" order by Tanggal";
		$data=$this->Admin_model->show_list('z_inv_pemakaian',$where);
		foreach($data as $r){
			$n++;
			echo tr().td($n,'center').td(tglfromSql($r->Tanggal),'center').
				 td(rdb('inv_barang','Kode','Kode',"where ID='".$r->ID_Barang."'")).	
				 td(rdb('inv_barang','Nama_Barang','Nama_Barang',"where ID='".$r->ID_Barang."'")).	
				 td(rdb('inv_barang_satuan','Satuan','Satuan',"where ID='".rdb('inv_barang','ID_Satuan','ID_Satuan',"where ID='".$r->ID_Barang."'")."'")).
				 td(number_format($r->Jumlah,2),'right').
				 td(number_format($r->Harga,2),'right').
				 td(number_format(($r->Jumlah*$r->Harga),2),'right').
				 td($r->Keterangan).
				 td(img_aksi($r->ID,true),'center').
				_tr();
		}
	}
	function print_pemakaian(){
		$data	=array();
		$dari	=$this->input->post('dari_tgl');
		$sampai	=($this->input->post('sampai_tgl')=='')?$dari:$this->input->post('sampai_tgl');
		$where	=($this->input->post('sampai_tgl')=='')? "where Tanggal='".tglToSql($dari)."'":
			  	 "where Tanggal between '".tglToSql($dari)."' and '".tglToSql($sampai)."'";
		$where.=" and ID_Jenis='1'";
		$where	.=" order by Tanggal";
		$data['dari']		=$dari;
		$data['sampai']		=$sampai;
		$data['temp_rec']	=$this->Admin_model->show_list('z_inv_pemakaian',$where);
			$this->zetro_auth->menu_id(array('trans_beli'));
			$this->list_data($data);
			$this->View("laporan/transaksi/lap_mutasi_print");

	}
	function print_rusak(){
		$data	=array();
		$dari	=$this->input->post('dari_tgl');
		$sampai	=($this->input->post('sampai_tgl')=='')?$dari:$this->input->post('sampai_tgl');
		$where	=($this->input->post('sampai_tgl')=='')? "where Tanggal='".tglToSql($dari)."'":
			  	 "where Tanggal between '".tglToSql($dari)."' and '".tglToSql($sampai)."'";
		$where.=" and ID_Jenis in('2','3')";
		$where	.=" order by Tanggal";
		$data['dari']		=$dari;
		$data['sampai']		=$sampai;
		$data['temp_rec']	=$this->Admin_model->show_list('z_inv_pemakaian',$where);
			$this->zetro_auth->menu_id(array('trans_beli'));
			$this->list_data($data);
			$this->View("laporan/transaksi/lap_mutasi_print");

	}
	function edit_pemakaian(){
		$data=array();
		$id=$_POST['id'];
		$data=$this->kasir_model->edit_pemakaian("where zp.ID='".$id."'");
		echo json_encode($data[0]);
	}
	function update_pemakaian(){
		$id		=$_POST['id'];
		$jml	=$_POST['jumlah'];
		$harga	=empty($_POST['harga'])?0:$_POST['harga'];
		$ketera	=empty($_POST['keterangan'])?'':$_POST['keterangan'];
		$jml_existing=rdb('z_inv_pemakaian','Jumlah','Jumlah',"where ID='".$id."'");
		$this->Admin_model->upd_data('z_inv_pemakaian',"set Jumlah='".$jml."', harga='".$harga."', Keterangan='".$ketera."'","where ID='".$id."'");	
		echo ((int)$jml-$jml_existing);
	}
	function delete_pemakaian(){
		$id=$_POST['id'];$jml=0;
		$jml=rdb('z_inv_pemakaian','Jumlah','Jumlah',"where ID='".$id."'");
		$this->Admin_model->hps_data('z_inv_pemakaian',"where ID='".$id."'");
		echo $jml;
	}
	//rusak atau hilang
	function rusak(){
		$this->zetro_auth->menu_id(array('addbarangrusak','listbarangrusak'));
		$this->list_data($this->zetro_auth->auth());
		$this->View('warehouse/material_rusak');
	}
	//prosess auto suggest
	function update_stock(){
		$bt='';$existing_stock=0;$new_stock=0;
		$id=$_POST['id_barang'];
		$jml=$_POST['jumlah'];
		$ret=empty($_POST['ret'])?'':$_POST['ret'];
		$bath=$this->inv_model->get_detail_stocked($id,'desc',$ret);
			foreach($bath as $w){
				$bt=$w->batch;
			}
		$existing_stock=rdb('inv_material_stok','stock','stock',"where id_barang='".$id."' and batch='".$bt."'");
		$new_stock=($ret=='2')?($existing_stock+abs((int)$jml)):($existing_stock-abs((int)$jml));
		$new_stock=($new_stock<0)?0:$new_stock;
		$this->Admin_model->upd_data('inv_material_stok',"set stock='".$new_stock."'","where id_barang='".$id."' and batch='".$bt."'");
		echo ($ret=='2')?'':($existing_stock-(int)$jml);
	}
	function get_kategori(){
		$data=array();
		$str	=$_GET['str'];
		$limit	=$_GET['limit'];
		$data	=$this->inv_model->get_kategori($str,$limit);
		echo json_encode($data);
	}

	function get_jenis(){
		$data=array();
		$str	=$_GET['str'];
		$limit	=$_GET['limit'];
		$data	=$this->inv_model->get_jenis($str,$limit);
		echo json_encode($data);
	}
	function get_satuan(){
		$data=array();
		$str	=$_GET['str'];
		$limit	=$_GET['limit'];
		$data	=$this->inv_model->get_satuan($str,$limit);
		echo json_encode($data);
	}



}