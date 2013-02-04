<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Class name: Inventory controller
version : 1.0
Author : Iswan Putera
*/

class Stock extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model("Admin_model");
		$this->load->model("inv_model");
		$this->load->library('zetro_auth');
		$this->load->model("report_model");
		$this->load->helper("print_report");
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
	function index(){
		$this->zetro_auth->menu_id(array('stockoverview','liststock'));
		$this->list_data($this->zetro_auth->auth());
		$this->View('inventory/material_stock');
	}
	function stock_barang(){
		$this->zetro_auth->menu_id(array('liststock'));
		$this->list_data($this->zetro_auth->auth());
		$this->View('warehouse/material_stocklist');
	}

	function list_stock(){
		$data=array();$n=0;
		$id=$_POST['nm_barang'];
		$data=$this->inv_model->get_detail_stock($id);
		foreach($data as $row){
			$n++;
			echo tr().td($n,'center').td($row->batch,'center').td(number_format($row->stock,2),'right').
				td(number_format($row->blokstok,2),'right').td(rdb('inv_barang_satuan','Satuan','Satuan',"where ID='".$row->nm_satuan."'"),'center').
				td($row->expired,'center').
				_tr();	
		}
	}
	
	function get_bacth(){
		$data=array();
		$id=$_POST['id_barang'];
		$data=$this->inv_model->get_detail_stocked($id,'desc');	
		echo (count($data)>0)?json_encode($data[0]):'{"batch":""}';
	}
	function list_filtered(){
		$nmj=array(); $data='';$valfld='';$n=0;
		$section=$_POST['section'];
		$kat	=empty($_POST['nm_kategori'])?'':$_POST['nm_kategori'];
		$stat	=empty($_POST['stat_barang'])?'':$_POST['stat_barang'];
		$cari	=empty($_POST['nam_barang'])?'':$_POST['nam_barang'];
		if($kat=='' && $stat==''){
			$where='';
		}else if($stat=='' && $kat!=''){
			$where="where ID_Kategori='$kat'";
		}else if($kat=='' && $stat!=''){
			$where="where Status='$stat'";
		}else{
			$where="where ID_Kategori='$kat' and Status='$stat'";
		}
		if($cari!='' && $where !=''){
			$where .= " and Nama_Barang like '".$cari."%'";
		}else if($cari!='' && $where ==''){
			$where ="where Nama_Barang like '".$cari."%'";
		}
		//echo $where;
		if($kat!='' || $cari!=''){
		$nmj=$this->inv_model->set_stock($where);
			foreach ($nmj as $row){
				$n++;
				echo tr().td($n,'center').td($row->Kode).td($row->Nama_Barang).
					td($row->Satuan).td(number_format($row->stock,0),'right').td($row->Status);
				echo ($section=='stoklistview')?
					td("<img src='".base_url()."asset/images/editor.png' onclick=\"edited('".$row->ID."');\"",'center'):'';
				echo _tr();
			}
		}else{
			echo tr().td('Data terlalu besar untuk ditampilkan pilih dulu Katgeori','left\' colspan=\'7')._tr();
		}
	}
	function get_material_stock(){
		$data=array();$stok=0;$sat='';
		$id_material=$_POST['id_material'];
		$data=$this->inv_model->get_total_stock($id_material);
		foreach($data as $r){
			$stok	=$r->stock;
			$sat	=$r->satuan;
			
		}
		($stok=='')?'0':$stok;
		echo json_encode($data[0]);
	}
	function data_hgb(){
		$data=array();
		$nm_barang=$_POST['nm_barang'];
		$this->zetro_auth->frm_filename('asset/bin/zetro_inv.frm');
		$data=$this->zetro_auth->show_data_field('stokoverview','inv_material',"where nm_barang='$nm_barang'");
		echo json_encode($data);	
	}
	function _filename(){
		$this->zetro_buildlist->config_file('asset/bin/zetro_inv.frm');
		$this->zetro_buildlist->aksi();
		$this->zetro_buildlist->icon();
	}
	
	function counting(){
		$this->zetro_auth->menu_id(array('countsheet','adjust'));
		$this->list_data($this->zetro_auth->auth());
		$this->View('inventory/material_opname');
	}
	function countsheet_prn(){
		$data=array();
		$data['bln']=date('F');
		$data['thn']=date('Y');
		$nmj=array(); $datax='';$valfld='';
		if ($this->input->post('ID_jenis')!='') $nmj['nm_jenis']=$this->input->post('nm_jenis');
		if ($this->input->post('ID_kategori')!='')$nmj['nm_kategori']=$this->input->post('nm_kategori');
		//if ($this->input->post('nm_golongan')!='')$nmj['nm_golongan']=$this->input->post('nm_golongan');
		foreach(array_keys($nmj) as $nfield){
			$datax .=$nfield.",";	
		}
		foreach(array_values($nmj) as $valfield){
			$valfld .=$valfield;
		}
		$datax=substr($datax,0,(strlen($datax)-1));
		!empty($datax)?$where="where concat($datax)='$valfld'":$where='';
		$data['temp_rec']=$this->inv_model->set_stock($where);
		$this->zetro_auth->menu_id(array('trans_beli'));
		$this->list_data($data);
		$this->View("inventory/countsheet_print");
	}
	function get_stock(){
		$data=array();$n=0;
		$ktg=($_POST['kategori']=='null')?7:$_POST['kategori'];
		$where=empty($_POST['kategori'])?'':"where im.ID_Kategori='".$ktg."'";
		$where.=(empty($_POST['stat']) || $_POST['stat']=='stoked')?'':" and Status='".$_POST['stat']."'";
		$where.=($_POST['stat']=='stoked')?" and ms.Stock <>'0'":'';
				
		$data=$this->report_model->stock_list($where,'stock');
		foreach($data as $r){
			$n++;
			echo tr('xx\' ondblclick="images_click(\''.$r->ID.':'.$r->batch.'\',\'edit\');"').td($n,'center').
					  td($r->Kode).
					  td($r->Nama_Barang).
					  td(rdb('inv_barang_kategori','Kategori','Kategori',"where ID='".$r->ID_Kategori."'")).
					  td(number_format($r->stock,2),'right').
					  td(rdb('inv_barang_satuan','Satuan','Satuan',"where ID='".$r->ID_Satuan."'")).
					  td(number_format($r->harga_beli,2),'right').
					  td($r->Status).
					  td(img_aksi($r->ID.':'.$r->batch),'center').
				 _tr();	 
		}
	}
	function print_stock(){
		$data=array();$n=0;
		$where=($this->input->post('Kategori')=='')?'':"where im.ID_Kategori='".$this->input->post('Kategori')."'";
		$where.=($this->input->post('Stat')=='' || $this->input->post('Stat')=='stoked')?'':" and Status='".$this->input->post('Stat')."'";
		$where.=($this->input->post('Stat')=='stoked')?" and ms.Stock <>'0'":'';
				
		$data['kategori']=rdb('inv_barang_kategori','Kategori','Kategori',"where ID='".$this->input->post('Kategori')."'");
		$data['status']	 =$this->input->post('Stat');
		$data['temp_rec']=$this->report_model->stock_list($where,'stock');
			$this->zetro_auth->menu_id(array('trans_beli'));
			$this->list_data($data);
			$this->View("laporan/transaksi/lap_stock_print");
/**/	}
	function edit_stock(){
		$data=array();
		$id=explode(':',$_POST['ID']);
		$where=($id[1]=='')?"where im.ID='".$id[0]."'":"where im.ID='".$id[0]."' and batch='".$id[1]."'";
		$data=$this->report_model->stock_list($where,'edit');
		echo json_encode($data[0]);
	}
	function update_adjust(){
		$data=array();
		$ID		=$_POST['id'];
		$batch	=$_POST['batch'];
		$stock	=$_POST['stock'];
		$cek=rdb('inv_material_stok','id_barang','id_barang',"where id_barang='".$ID."' and batch='".$batch."'");
		if($cek!=''){
			$this->Admin_model->upd_data('inv_material_stok',"set stock='".$stock."'","where id_barang='".$ID."' and batch='".$batch."'");
		}else{
			$data['id_barang']	=$_POST['id'];
			$data['nm_barang']	=rdb('inv_barang','Nama_Barang','Nama_Barang',"where ID='".$ID."'");
			$data['batch']		=date('yz').'-'.rand(0,9);
			$data['stock']		=$stock;
			$data['nm_satuan']	=rdb('inv_barang','ID_Satuan','ID_Satuan',"where ID='".$ID."'");
			$data['harga_beli']	=$_POST['harga'];
			$data['created_by']	=$this->session->userdata('userid');
			$this->Admin_model->replace_data('inv_material_stok',$data);
		}
	}
}