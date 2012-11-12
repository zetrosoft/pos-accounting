<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Report extends CI_Controller
{
	 function __construct()
	  {
		parent::__construct();
		$this->load->model("report_model");
		$this->load->model("kasir_model");
		$this->load->helper("print_report");
		$this->load->model("control_model");
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
	//Laporan Pembelian
	function beli(){
		$this->zetro_auth->menu_id(array('rekappembelian'));
		$this->list_data($this->zetro_auth->auth());
		$this->View('laporan/transaksi/lap_beli');

	}
	function lap_pembelian(){
		$data=array();$where='';
		$data['dari']=$this->input->post('dari_tgl');
		$data['sampai']=$this->input->post('sampai_tgl');
		$where=empty($_POST['sampai_tgl'])?
			   "where p.Tanggal='".tglToSql($_POST['dari_tgl'])."'":
			   "where p.Tanggal between '".tglToSql($_POST['dari_tgl'])."' and '".tglToSql($_POST['sampai_tgl'])."'";
		$where.=" and p.ID_Jenis='".$this->input->post('jenis_beli')."' /*and p.ID_Pemasok!='0'*/";
		$group="group by p.Tanggal,v.Nama";
		$data['id_jenis']=rdb('inv_pembelian_jenis','Jenis_Beli','Jenis_Beli',"Where ID='".$this->input->post('jenis_beli')."'");
		$data['temp_rec']=$this->kasir_model->rekap_trans_beli($where,$group);
		
		$this->zetro_auth->menu_id(array('trans_beli'));
		$this->list_data($data);
		$this->View("laporan/transaksi/lap_beli_print");
	  
	}
	//Laporan penjualan
	function penjualan(){
		$this->zetro_auth->menu_id(array('rekappenjualantunai'));
		$this->list_data($this->zetro_auth->auth());
		$this->View('laporan/transaksi/lap_jual');

	}
	function lap_penjualan(){
		$data=array();$where='';
		$where=empty($_POST['sampai_tgl'])?
			   "where p.Tanggal='".tglToSql($_POST['dari_tgl'])."'":
			   "where p.Tanggal between '".tglToSql($_POST['dari_tgl'])."' and '".tglToSql($_POST['sampai_tgl'])."'";
		$where.=($this->input->post('kategori')=='')?'':" and b.ID_Kategori='".$this->input->post('kategori')."'";
		$where.=($this->input->post('id_jenis')=='')?'':" and b.ID_Jenis='".$this->input->post('id_jenis')."'";
		$where.=" and p.ID_Jenis='".$this->input->post('jenis_beli')."'";
		$group="group by concat(dt.harga,dt.ID_Barang)";
		$ordby="order by trim(b.Nama_Barang)";
		$data['dari']		=$this->input->post('dari_tgl');
		$data['sampai']		=($this->input->post('sampai_tgl')=='')?$this->input->post('dari_tgl'):$this->input->post('sampai_tgl');
		$data['Kategori']	=($this->input->post('kategori')=='')?'All':rdb('inv_barang_kategori','Kategori','Kategori',"where ID='".$this->input->post('kategori')."'");
		$data['Jenis']		=($this->input->post('id_jenis')=='')?'All':rdb('inv_barang_jenis','JenisBarang','JenisBarang',"where ID='".$this->input->post('id_jenis')."'");
		$data['judul']		=rdb('inv_penjualan_jenis','Jenis_Jual','Jenis_Jual',"where ID='".$this->input->post('jenis_beli')."'");
		$data['temp_rec']=$this->kasir_model->rekap_trans_jual($where,$group,$ordby);
		
		$this->zetro_auth->menu_id(array('trans_beli'));
		$this->list_data($data);
		$this->View("laporan/transaksi/lap_jual_print");
	  
	}
	function barang_kredit(){
		$this->zetro_auth->menu_id(array('rekapbarangkredit'));
		$this->list_data($this->zetro_auth->auth());
		$this->View('laporan/transaksi/lap_jual_kredit');

	}
	function penjualan_kredit(){
		$this->zetro_auth->menu_id(array('rekappenjualankredit'));
		$this->list_data($this->zetro_auth->auth());
		$this->View('laporan/transaksi/lap_kreditur');

	}
	function lap_kreditur(){
		$data=array();$where='';
		$where=empty($_POST['sampai_tgl'])?
			   "where p.Tanggal='".tglToSql($_POST['dari_tgl'])."'":
			   "where p.Tanggal between '".tglToSql($_POST['dari_tgl'])."' and '".tglToSql($_POST['sampai_tgl'])."'";
		$where.=($this->input->post('departemen')=='')?'':" and a.ID_Dept='".$this->input->post('departemen')."'";
		$where.=($this->input->post('cicilan')=='')?'':" and b.Cicilan='".$this->input->post('cicilan')."'";
		$where.=" and p.ID_Jenis='".$this->input->post('jenis_beli')."'";
		$group="group by concat(p.ID_Anggota)";
		$ordby="order by trim(a.Nama)";
		$data['dari']		=$this->input->post('dari_tgl');
		$data['sampai']		=($this->input->post('sampai_tgl')=='')?$this->input->post('dari_tgl'):$this->input->post('sampai_tgl');
		$data['Kategori']	=($this->input->post('departemen')=='')?'All':rdb('mst_departemen','Departemen','Departemen',"where ID='".$this->input->post('departemen')."'");
		$data['Jenis']		=($this->input->post('cicilan')=='')?'All':$this->input->post('cicilan');
		$data['judul']		=rdb('inv_penjualan_jenis','Jenis_Jual','Jenis_Jual',"where ID='".$this->input->post('jenis_beli')."'");
		$data['temp_rec']=$this->kasir_model->rekap_kreditur($where,$group,$ordby);
		
		$this->zetro_auth->menu_id(array('trans_beli'));
		$this->list_data($data);
		$this->View("laporan/transaksi/lap_kreditur_print");
	}
	//===============tagihan kredit
	function tagihan_kredit(){
		$this->zetro_auth->menu_id(array('tagihankredit'));
		$this->list_data($this->zetro_auth->auth());
		$this->View('laporan/transaksi/lap_kreditur_tagihan');

	}
	function lap_tagihan_kreditur(){
		$data=array();$where='';
		$where=empty($_POST['sampai_tgl'])?
			   "where p.Tanggal='".tglToSql($_POST['dari_tgl'])."'":
			   "where p.Tanggal between '".tglToSql($_POST['dari_tgl'])."' and '".tglToSql($_POST['sampai_tgl'])."'";
		$where.=($this->input->post('departemen')=='')?'':" and a.ID_Dept='".$this->input->post('departemen')."'";
		$where.=($this->input->post('cicilan')=='')?'':" and b.Cicilan='".$this->input->post('cicilan')."'";
		$where.=" and p.ID_Jenis='".$this->input->post('jenis_beli')."'";
		$group="group by concat(p.ID_Anggota)";
		$ordby="order by trim(a.Nama)";
		$data['dari']		=$this->input->post('dari_tgl');
		$data['sampai']		=($this->input->post('sampai_tgl')=='')?$this->input->post('dari_tgl'):$this->input->post('sampai_tgl');
		$data['Kategori']	=($this->input->post('departemen')=='')?'All':rdb('mst_departemen','Departemen','Departemen',"where ID='".$this->input->post('departemen')."'");
		$data['Jenis']		=($this->input->post('cicilan')=='')?'All':$this->input->post('cicilan');
		$data['judul']		=rdb('inv_penjualan_jenis','Jenis_Jual','Jenis_Jual',"where ID='".$this->input->post('jenis_beli')."'");
		$data['temp_rec']=$this->kasir_model->rekap_kreditur($where,$group,$ordby);
		
		$this->zetro_auth->menu_id(array('trans_beli'));
		$this->list_data($data);
		$this->View("laporan/transaksi/lap_kreditur_tagihan_print");
	}
	//=============================menu file anggota
	function inv_anggota(){
		$this->zetro_auth->menu_id(array('pinjamanbarang','detailkredit'));
		$this->list_data($this->zetro_auth->auth());
		$this->View('member/member_pinjaman_barang');
	}
	
	function get_kreditur(){
	$data=array();$n=0;
		if(!empty($_POST['id_dept']) ||
		   !empty($_POST['cari'])){
			if(!empty($_POST['id_dept']) &&
				empty($_POST['cari'])){   
				$where= empty($_POST['id_dept'])?'':"where b.ID_dept='".$_POST['id_dept']."'";
				$where.=empty($_POST['id_stat'])?'':" and ID_Aktif='".$_POST['id_stat']."'";
				}
			if(!empty($_POST['cari'])){
				$where="where b.Nama like '".$_POST['cari']."%'";
			}
		$orderby=' group by p.ID_Anggota order by b.Nama';
		$data=$this->kasir_model->get_kreditur($where,$orderby);
		foreach($data as $r){
			$n++;
			echo tr('xx\' onclick="detail(\''.$r->ID.'\',\''.$r->ID_Anggota.'\');" attr=\'ax').td($n,'center').
					  td($r->Departemen).
					  td($r->NIP).
					  td($r->Nama).
					  td($r->Keaktifan).
					  _tr();	
		}
		}else{
		 echo tr().td('Silahkan pilih departemen terlebih dahulu','kotak \' colspan=\'5')._tr();
		}
	}
	function detail_kreditur(){
		$data=array();$n=0;
		$ID=$_POST['ID'];
		$ID_Agt=$_POST['ID_Agt'];
		$data['Agt']=rdb('mst_anggota','Nama','Nama',"where ID='".$_POST['ID_Agt']."'");
		$data['Dept']=rdb('mst_departemen','Departemen','Departemen',"where ID='".
					 rdb('mst_anggota','ID_Dept','ID_Dept',"where ID='".$_POST['ID_Agt']."'")."'");
		$data['ID_Agt']=$ID_Agt;
		$this->load->view('member/member_pinjaman_barang_detail',$data);	
	}
	function show_detail_kreditur_trans(){
	$data=array();$n=0;$total=0;
	$ID_Agt=$_POST['ID_Agt'];
	$data=$this->kasir_model->get_trans_jual_kreditur($ID_Agt);
		foreach($data as $r){
			$n++;
			echo tr().td($n,'center').
					  td(tglfromSql($r->Tanggal),'center').
					  td($r->Nomor).
					  td($r->Nama_Barang).
					  td(number_format($r->Jumlah,2),'right').
					  td($r->Satuan).
					  td(number_format(($r->Jumlah*$r->Harga),2),'right').
				_tr();
				$total=($total+($r->Jumlah*$r->Harga));
		}
		echo tr().td('<b>Total</b>','right\' colspan=\'6','kotak list_genap').td('<b>'.number_format($total,2).'</b>','right')._tr();
	}

	function show_detail_kreditur_jurnal(){
	$data=array();$nx=0;$debet=0;$kredit=0;
	$ID_Agt=$_POST['ID_Agt'];
	$data=$this->kasir_model->get_trans_jurnal($ID_Agt);
		foreach($data as $rx){
			$nx++;
			echo tr().td($nx,'center').
					  td(tglfromSql($rx->Tanggal),'center').
					  td($rx->Nomor).
					  td($rx->Keterangan).
					  td(number_format($rx->Debet,2),'right').
					  td(number_format(($rx->Kredit),2),'right').
				_tr();
			$debet	=($debet+$rx->Debet);
			$kredit	=($kredit+$rx->Kredit);
		}
		echo tr().td('<b>Total</b>','right\' colspan=\'4','kotak list_genap').
			td('<b>'.number_format($debet,2).'</b>','right','kotak list_genap').
			td('<b>'.number_format($kredit,2).'</b>','right','kotak list_genap')._tr().
			tr().td('<b>Balance</b>','right\' colspan=\'5','kotak list_ganjil').
			td('<b>'.number_format(((int)$debet-(int)$kredit),2).'</b>','right','kotak list_genap')._tr();
	}

}
?>
