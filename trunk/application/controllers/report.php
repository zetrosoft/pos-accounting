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
	function lap_penjualan_show(){
		$data=array();$where='';$n=0;$harga=0;
		$where=empty($_POST['sampai_tgl'])?
			   "where p.Tanggal='".tglToSql($_POST['dari_tgl'])."'":
			   "where p.Tanggal between '".tglToSql($_POST['dari_tgl'])."' and '".tglToSql($_POST['sampai_tgl'])."'";
		$where.=($this->input->post('kategori')=='')?'':" and b.ID_Kategori='".$this->input->post('kategori')."'";
		$where.=($this->input->post('id_jenis')=='')?'':" and b.ID_Jenis='".$this->input->post('id_jenis')."'";
		$where.=" and p.ID_Jenis='1'";
		$group="group by concat(dt.harga,dt.ID_Barang)";
		$ordby="order by trim(b.Nama_Barang)";
		$data=$this->kasir_model->rekap_trans_jual($where,$group,$ordby);
		foreach($data as $r){
			$n++;
			echo tr().td($n,'center').
				 td($r->Nama_Barang).
				 td($r->Kode).
				 td($r->Jumlah,'right').
				 td(number_format($r->Harga,2),'right').
				 td($r->Satuan,'center').
				 td(number_format(($r->Jumlah*$r->Harga),2),'right').
				 td(($r->ID_Post=='0')?'unposting':'Posting').
				 _tr();
			$harga	=($harga+($r->Jumlah*$r->Harga));
		}
		echo tr('xx list_genap').td('<b>T O T A L </b>','right\' colspan=\'6').
			 td('<b>'.number_format($harga,2).'</b>','right').
			 td('&nbsp;').
			 _tr();
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
	function lap_jual_posting(){
		$data=array();$total=0;$ide='';
		$where=empty($_POST['sampai_tgl'])?
			   "where p.Tanggal='".tglToSql($_POST['dari_tgl'])."'":
			   "where p.Tanggal between '".tglToSql($_POST['dari_tgl'])."' and '".tglToSql($_POST['sampai_tgl'])."'";
		$where.=($this->input->post('kategori')=='')?'':" and b.ID_Kategori='".$this->input->post('kategori')."'";
		$where.=($this->input->post('id_jenis')=='')?'':" and b.ID_Jenis='".$this->input->post('id_jenis')."'";
		$where.=" and p.ID_Jenis='1' and p.ID_Post='0'";
		$group="group by concat(dt.harga,dt.ID_Barang)";
		$ordby="order by trim(b.Nama_Barang)";
		$ID_Jurnal=rdb('jurnal','ID','ID',"where Nomor='".$_POST['id_jurnal']."'");
		$data=$this->kasir_model->rekap_trans_jual($where,$group,$ordby);
		foreach($data as $r){
			$ide="'".$r->ID."',".$ide;
			$total=($total+($r->Jumlah*$r->Harga));
		}
			//jurnal akun Kas KBR (2)
			$ket=rdb('jurnal','Keterangan','Keterangan',"where ID='".$ID_Jurnal."'");
			  $sql="insert into transaksi (ID_Jurnal,ID_Perkiraan,ID_Dept,Debet,Kredit,Keterangan,urutan) values('".
			  		$ID_Jurnal."','2','1','".$total."','0','".$ket."','1')";
			//jurnal akun penjualan barang [41333]
			$ket=rdb('jurnal','Keterangan','Keterangan',"where ID='".$ID_Jurnal."'");
			  $sql2="insert into transaksi (ID_Jurnal,ID_Perkiraan,ID_Dept,Debet,Kredit,Keterangan,urutan) values('".
			  		$ID_Jurnal."','4133','1','0','".$total."','".$ket."','2')";
			//execute query
			mysql_query($sql2) or die(mysql_error());
			mysql_query($sql) or die(mysql_error());
			$this->Admin_model->upd_data('inv_penjualan',"set ID_Post='1'","where ID in(".substr($ide,0,-1).")");
	}
	
	//transaksi kredit
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
	function lap_tagihan_print(){
		$data=array();$where='';$n=0;$harga=0;
		$dari_tgl=$_POST['dari_tgl'];
		$sampai_tgl=empty($_POST['sampai_tgl'])?$dari_tgl:$_POST['sampai_tgl'];
		$departemen=empty($_POST['departemen'])?'':$_POST['departemen'];
		
		$where=empty($_POST['sampai_tgl'])?
			   "where p.Tanggal='".tglToSql($_POST['dari_tgl'])."'":
			   "where p.Tanggal between '".tglToSql($_POST['dari_tgl'])."' and '".tglToSql($_POST['sampai_tgl'])."'";
		$where.=($_POST['departemen']=='')?'':" and a.ID_Dept='".$_POST['departemen']."'";
		$where.=($_POST['cicilan']=='')?'':" and b.Cicilan='".$_POST['cicilan']."'";
		$where.=" and p.ID_Jenis!='1'";//.$this->input->post('jenis_beli')."'";
		$group="group by concat(p.ID_Anggota)";
		$ordby="order by trim(a.Nama)";
		$data=$this->kasir_model->rekap_kreditur($where,$group,$ordby);
		foreach($data as $r){
			$n++;
			echo tr().td($n,'center').td($r->Nama).
				 td(rdb('mst_departemen','Departemen','Departemen',"where ID='".$r->ID_Dept."'")).
				 td($r->Cicilan,'center').
				 td(number_format($r->Total,2),'right').
				 td(rdb('inv_posting_status','PostStatus','PostStatus',"where ID='".$r->ID_Post,'center'."'")).
				 _tr();
			$harga	=($harga+($r->Total));
		}
		echo tr('xx list_genap').td('<b>T O T A L </b>','right\' colspan=\'4').
			 td('<b>'.number_format($harga,2).'</b>','right').
			 td('&nbsp;').
			 _tr();
	}
	function lap_tagihan_kreditur(){
		$data=array();$where='';
		$where=empty($_POST['sampai_tgl'])?
			   "where p.Tanggal='".tglToSql($_POST['dari_tgl'])."'":
			   "where p.Tanggal between '".tglToSql($_POST['dari_tgl'])."' and '".tglToSql($_POST['sampai_tgl'])."'";
		$where.=($this->input->post('departemen')=='')?'':" and a.ID_Dept='".$this->input->post('departemen')."'";
		$where.=($this->input->post('cicilan')=='')?'':" and b.Cicilan='".$this->input->post('cicilan')."'";
		$where.=" and p.ID_Jenis!='1'";//.$this->input->post('jenis_beli')."'";
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
	function jual_kredit_posting(){
		$data=array();$where='';$akun='';$t_debt=0;$t_kred=0;$n=0;
		$dari_tgl=$_POST['dari_tgl'];
		$sampai_tgl=empty($_POST['sampai_tgl'])?$dari_tgl:$_POST['sampai_tgl'];
		$departemen=empty($_POST['departemen'])?'':$_POST['departemen'];
		
		$where=empty($_POST['sampai_tgl'])?
			   "where p.Tanggal='".tglToSql($_POST['dari_tgl'])."'":
			   "where p.Tanggal between '".tglToSql($_POST['dari_tgl'])."' and '".tglToSql($_POST['sampai_tgl'])."'";
		$where.=($_POST['departemen']=='')?'':" and a.ID_Dept='".$_POST['departemen']."'";
		//$where.=($this->input->post('cicilan')=='')?'':" and b.Cicilan='".$this->input->post('cicilan')."'";
		$where.=" and p.ID_Jenis!='1' and ID_Post='0'";//.$this->input->post('jenis_beli')."'";
		$group="group by concat(p.ID_Anggota)";
		$ordby="order by trim(a.Nama)";
		$ID_Jurnal=rdb('jurnal','ID','ID',"where Nomor='".$_POST['id_jurnal']."'");
		$data=$this->kasir_model->rekap_kreditur($where,$group,$ordby);
		foreach($data as $r){
			$n++;
			$akun=rdb('perkiraan','ID','ID',"where ID_Agt='".$r->ID_Anggota."' and ID_Simpanan='4'");
				$kred=0;$debt=0;
				if($akun==''){
					//update database perkiraan jika data akun belum ada
					$this->_update_perkiraan($r->ID_Anggota,'4');	
				}
			//lakukan posting penjualan secara kredit
			if($r->ID_Jenis!='1'){
				$debt=($r->ID_Jenis=='2')?$r->Total:'0';
				$kred=($r->ID_Jenis=='3')?$r->Total:'0';
			  $sql="insert into transaksi (ID_Jurnal,ID_Perkiraan,ID_Dept,Debet,Kredit,Keterangan,urutan) values('".
			  		$ID_Jurnal."','".$akun."','".$r->ID_Dept."','".$debt."','".$kred."','".$r->Nomor."','".($n+1)."')";

			  mysql_query($sql) or die(mysql_error());
			  $this->Admin_model->upd_data('inv_penjualan',"set ID_Post='1'","where ID='".$r->ID."'");
			$t_debt=($t_debt+$debt);
			$t_kred=($t_kred+$kred);
			}
		}
		//posting akun tandingan Penjualan barang(KBR) ID 4133
			$ket=rdb('jurnal','Keterangan','Keterangan',"where ID='".$ID_Jurnal."'");
			  $sql2="insert into transaksi (ID_Jurnal,ID_Perkiraan,ID_Dept,Debet,Kredit,Keterangan,urutan) values('".
			  		$ID_Jurnal."','4133','1','0','".($t_debt-$t_kred)."','".$ket."','1')";
			mysql_query($sql2) or die(mysql_error());
	}
	
	function _update_perkiraan($ID_Agt,$ID_Simpanan){
		$datax=array();
		$datax['ID_Unit']		=rdb('jenis_simpanan','ID_Unit','ID_Unit',"where ID='4'");
		$datax['ID_Klas']		=rdb('jenis_simpanan','ID_Klasifikasi','ID_Klasifikasi',"where ID='4'");
		$datax['ID_SubKlas']	=rdb('jenis_simpanan','ID_SubKlas','ID_SubKlas',"where ID='4'");
		$datax['ID_Dept']		=rdb('mst_anggota','ID_Dept','ID_Dept',"where ID='".$ID_Agt."'");
		$datax['ID_Simpanan']	=$ID_Simpanan;
		$datax['ID_Agt']		=$ID_Agt;
		$datax['ID_Calc']		=rdb('jenis_simpanan','ID_Calc','ID_Calc',"where ID='4'");
		$datax['ID_Laporan']	=rdb('jenis_simpanan','ID_Laporan','ID_Laporan',"where ID='4'");
		$datax['ID_LapDetail']	=rdb('jenis_simpanan','ID_LapDetail','ID_LapDetail',"where ID='4'");
		echo $this->Admin_model->replace_data('perkiraan',$datax);
		//print_r($datax);
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
