<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//
//Class name: Penjualan controller
//version : 1.0
//Author : Iswan Putera

class Penjualan extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model("Admin_model");
		$this->load->model("inv_model");
		$this->load->model("kasir_model");
		$this->load->library('zetro_auth');
		$this->load->library('zetro_slip');
		$this->load->model("report_model");
		$this->load->helper("print_report");
	}
	
	function Header(){ 
	// load header
		$this->load->view('admin/header');	
	}
	
	function Footer(){
	//load footer
		$this->load->view('admin/footer');	
	}
	function list_data($data){
	//membentuk data array untuk dikirim saat load view
		$this->data=$data;
	}
	function View($view){
		$this->Header();
		$this->zetro_auth->view($view);
		$this->load->view($view,$this->data);	
		$this->Footer();
	}
	//tampilan awal ketika menu input pembelian di klik
	function index(){
		$data=array();
		$this->zetro_auth->menu_id(array('penjualan__index'));
		$this->list_data($this->zetro_auth->auth());
		$this->hapus_resep_kosong();
		$this->View('penjualan/material_jual');
	}
	// pejualan dengan resep untuk apotik
	function resep_std(){
		$data=array();
		$this->zetro_auth->menu_id(array('penjualan__resep_std'));
		$this->list_data($this->zetro_auth->auth());
		$this->View('penjualan/material_jual_resep');
	}
	//generate nomor transaksi otomatis
	function nomor_transaksi(){
		$tipe=$_POST['tipe'];
		$nomor=$this->Admin_model->penomoran($tipe);
		echo $nomor;	
	}
	//generate nomor faktur penjualan
	function nomor_faktur(){
		$faktur=date('Ymd')."-".rand(1000,9999);
		echo $faktur;	
	}
	
	function hapus_resep_kosong(){
	//hapus data resep yang stock nya kosong dan sudah expire 
	$this->inv_model->hapus_resep_kosong();
		
	}
	
	function get_satuan(){
		$data=array();
		$nm_barang=$_POST['nm_barang'];
		$rsp=$_POST['rsp'];
		$expired=$this->Admin_model->show_single_field('inv_material_stok','expired',"where nm_barang='$nm_barang' order by min(expired)");
		$harga=$this->Admin_model->show_single_field('inv_material_stok','harga_beli',"where nm_barang='$nm_barang' and expired='$expired'");
		$margin=1;//$this->Admin_model->show_single_field('inv_material','margin_jual',"where nm_barang='$nm_barang'");
		$uom=$this->Admin_model->show_single_field('inv_material','nm_satuan',"where nm_barang='$nm_barang'");
		($rsp=='n')?
			$satuan=$this->Admin_model->show_single_field('inv_material','nm_satuan',"where nm_barang='$nm_barang'"):
			$satuan=$this->Admin_model->show_single_field('inv_konversi','sat_beli',"where nm_barang='$nm_barang' order by min(isi_konversi)");
		($satuan=='')?
			$data['satuan']=$this->Admin_model->show_single_field('inv_material','nm_satuan',"where nm_barang='$nm_barang'"):
			$data['satuan']=$satuan;
			$isikonv=$this->Admin_model->show_single_field('inv_konversi','isi_konversi',"where nm_barang='$nm_barang' and sat_beli='$satuan'");
		($uom!=$satuan)?$harga=($harga*$isikonv):$harga=$harga;
		$data['expired']=tglfromSql($expired);
		$data['stock']=$this->Admin_model->show_single_field('inv_material_stok','stock',"where nm_barang='$nm_barang' and expired='$expired'");
		$data['harga_jual']=(($harga*$margin/100)+$harga);
		echo json_encode($data);
	}
	//simpan data header transaksi
	function set_header_trans(){
		$data=array();$datax=array();
		$cek_nourut	=rdb('inv_penjualan','NoUrut','NoUrut',"where NoUrut='".$_POST['no_trans']."'");
		$data['NoUrut']		=$_POST['no_trans'];
		$data['Tanggal']	=tgltoSql($_POST['tanggal']);
		$data['Nomor']		=$_POST['faktur'];
		$data['ID_Anggota']	=empty($_POST['member'])?'0':$_POST['member'];
		$data['ID_Jenis']	=$_POST['cbayar'];
		$data['Bulan']		=substr($_POST['tanggal'],3,2);
		$data['Tahun']		=substr($_POST['tanggal'],6,4);
		$data['Total']		=empty($_POST['total'])?'0':$_POST['total'];
		$data['cicilan']	=empty($_POST['cicilan'])?'0':$_POST['cicilan'];
		if($cek_nourut==''){
		$this->Admin_model->replace_data('inv_penjualan',$data);
		}
		//update nomor transaksi	
		$datax['nomor']		=$_POST['no_trans'];
		$datax['jenis_transaksi']='GI';
		$this->Admin_model->replace_data('nomor_transaksi',$datax);
	}
	function update_header_trans(){
		$data=array();
		$no_trans	=$_POST['no_trans'];
		$ID_Jenis	=$_POST['id_jenis'];
		$TotalHg	=empty($_POST['total'])?'0':$_POST['total'];
		$Tanggal	=$_POST['tanggal'];
		$id_anggota	=empty($_POST['id_anggota'])?'0':$_POST['id_anggota'];
		$cicilan	=empty($_POST['cicilan'])?'0'	:$_POST['cicilan'];
		$nogiro		=empty($_POST['nogiro'])?'0'	:strtoupper($_POST['nogiro']);
		$n_bank		=empty($_POST['n_bank'])?''		:strtoupper(addslashes($_POST['n_bank']));
		$tgl_giro	=empty($_POST['tgl_giro'])?'0000-00-00'	:tgltoSql($_POST['tgl_giro']);
		$this->Admin_model->upd_data('inv_penjualan',"set ID_Jenis='$ID_Jenis', ID_Anggota='$id_anggota', Total='".$TotalHg."', Cicilan='".$cicilan."',ID_Post='".$nogiro."', Deskripsi='".$n_bank."', Tgl_Cicilan='".$tgl_giro."'",
									 "where NoUrut='".$no_trans."' and	Tanggal='".tgltoSql($Tanggal)."'");
		$this->no_transaksi($no_trans);
		$this->tanggal($Tanggal);
		if($TotalHg!='0'){
			if($ID_Jenis=='2' && $id_anggota!=''){
				$this->process_to_jurnal($id_anggota,$TotalHg);
			}else if($ID_Jenis=='3' && $id_anggota!=''){
				$ket='Retur Barang Kredit';	
				$this->process_to_jurnal($id_anggota,$TotalHg,$ket);
			}
		}
	}

	function set_detail_trans(){
		$data=array();
		$cekstatus=array();$countdata=0;
		//get ID from header trans
		$data['Keterangan']	=$_POST['no_trans'];
		$data['ID_Jual']	=rdb('inv_penjualan','ID','ID',"where NoUrut='".$_POST['no_trans']."' and Tanggal='".tgltoSql($_POST['tanggal'])."'");
		$data['ID_Barang']	=rdb('inv_barang','ID','ID',"where Nama_Barang='".$_POST['nm_barang']."'");
		$data['ID_Jenis']	=$_POST['cbayar'];
		$data['Jumlah']		=$_POST['jml_trans'];
		$data['Harga']		=$_POST['harga_jual'];
		$data['Tanggal']	=tgltoSql($_POST['tanggal']);
		$data['Bulan']		=$_POST['no_id'];
		$data['batch']		=empty($_POST['batch'])?'0':$_POST['batch'];
		$data['ID_Satuan']	=rdb('inv_barang','ID_Satuan','ID_Satuan',"where Nama_Barang='".$_POST['nm_barang']."'");
		$countdata=rdb('inv_penjualan_detail','ID','ID',"where Bulan='".$_POST['no_id']."' and Keterangan='".$_POST['no_trans']."' and Tanggal='".tgltoSql($_POST['tanggal'])."'");
		//$this->inv_model->total_record('inv_penjualan_detail',"where ID_Jual='$id_jual'",'id_jual');
		if($countdata==''){
				$this->Admin_model->replace_data('inv_penjualan_detail',$data);
		}else{
			$data['ID']=$countdata;
			$this->Admin_model->simpan_update('inv_penjualan_detail',$data,'ID');
		}
	}
	//simpan pembayaran	
	function simpan_bayar(){
		$data=array();
		$data['no_transaksi']	=$_POST['no_transaksi'];
		$data['total_belanja']	=$_POST['total_belanja'];
		$data['ppn']			=empty($_POST['ppn'])?'0':$_POST['ppn'];	
		$data['total_bayar']	=empty($_POST['total_bayar'])?'0':$_POST['total_bayar'];	
		$data['jml_dibayar']	=empty($_POST['dibayar'])?'0':$_POST['dibayar'];	
		$data['kembalian']		=empty($_POST['kembalian'])?'0':$_POST['kembalian'];
		//$data['terbilang']		=$_POST['terbilang'];
		$data['created_by']	=$this->session->userdata('userid');
		//$this->update_material_stock($_POST['no_transaksi'],tgltoSql($_POST['tanggal']));//update stock
		
		$this->Admin_model->replace_data('inv_pembayaran',$data);
		//$this->Admin_model->hps_data('inv_material',"where nm_barang='".$_POST[
		echo $_POST['no_transaksi'];
	}
	function update_stock_return(){
		$ntran	=$_POST['no_trans'];
		$tgl	=tglToSql($_POST['tanggal']);
		$this->return_stock($ntran,$tgl);
		echo '';
	}
	//update data stok material setelah di lakukan transaksi
	//transaksi penjualan
	function update_material_stock($ntran='',$tgl=''){
		$data=array();$first_stock=0;$end_stock=0;$datax=array();$hgb=0;$bath='';
		$ntran	=$_POST['no_trans'];
		$tgl	=tglToSql($_POST['tanggal']);
		$data=$this->Admin_model->show_list('inv_penjualan_detail',"where ID_Jual='".rdb('inv_penjualan','ID','ID',"where NoUrut='".$ntran."' and Tanggal='". $tgl."'")."'");
		$id_br=rdb('inv_penjualan_detail','ID_Barang','ID_Barang',"where ID_Jual='".rdb('inv_penjualan','ID','ID',"where NoUrut='".$ntran."' and Tanggal='". $tgl."'")."'");
		foreach($data as $r){
		$bt='';
		$bath=$this->inv_model->get_detail_stocked($id_br,'desc');
			foreach($bath as $w){
				$bt=$w->batch;
			}
			$jumlah=empty($_POST['jumlah'])?$r->Jumlah:$_POST['jumlah'];
			$hgb=rdb('inv_material_stok','harga_beli','harga_beli',"where id_barang='".$r->ID_Barang."' and batch='".$bt."'");
			$first_stock=rdb('inv_material_stok','stock','stock',"where id_barang='".$r->ID_Barang."' and batch='".$bt."'");
			$end_stock=($first_stock-abs($jumlah));
			$end_stock=($end_stock<0)? 0:$end_stock;
			$datax['id_barang']	=$r->ID_Barang;
			$datax['nm_barang']	=addslashes(rdb('inv_barang','Nama_Barang','Nama_Barang',"where ID='".$r->ID_Barang."'"));
			$datax['batch']		=$bt;
			$datax['stock']		=$end_stock;
			$datax['harga_beli']=empty($hgb)?'0':$hgb;
			$datax['nm_satuan'] =rdb('inv_barang','ID_Satuan','ID_Satuan',"where ID='".$r->ID_Barang."'");
			$this->Admin_model->replace_data('inv_material_stok',$datax);
		}
		 echo ($first_stock-$r->Jumlah);
	}
	
	
	function return_stock($ntran,$tgl){
		$data=array();$first_stock=0;$end_stock=0;$datax=array();$hgb=0;
		$id_jual=rdb('inv_penjualan','ID','ID',"where NoUrut='".$ntran."' and Tanggal='". $tgl."'");
		$data=$this->Admin_model->show_list('inv_penjualan_detail',"where ID_Jual='".$id_jual."'");
		//print_r($data);
		foreach($data as $r){
			$hgb=rdb('inv_material_stok','harga_beli','harga_beli',"where id_barang='".$r->ID_Barang."' and batch='".$r->Batch."'");
			$first_stock=rdb('inv_material_stok','stock','stock',"where id_barang='".$r->ID_Barang."' and batch='".$r->Batch."'");
			$end_stock=($first_stock+(abs($r->Jumlah)));
			$datax['id_barang']	=$r->ID_Barang;
			$datax['nm_barang']	=addslashes(rdb('inv_barang','Nama_Barang','Nama_Barang',"where ID='".$r->ID_Barang."'"));
			$datax['batch']		=$r->Batch;
			$datax['stock']		=$end_stock;
			$datax['harga_beli']=empty($hgb)?'0':$hgb;
			$datax['nm_satuan'] =rdb('inv_barang','ID_Satuan','ID_Satuan',"where ID='".$r->ID_Barang."'");
			$this->Admin_model->replace_data('inv_material_stok',$datax);
		}
	}
	function transaski_kas(){
		//pembayaran return material diambil dari uang kas toko
		$data=array();
		$data['id_trans']	=$_POST['no_trans'];
		$data['id_kas']		='KAS TOKO';	
	}
	function batal_transaksi(){
		//$this->return_stock($_POST['no_trans'],tgltoSql($_POST['tanggal']));
		$this->Admin_model->hps_data('inv_penjualan',"where NoUrut='".$_POST['no_trans']."' and Tanggal='".tgltoSql($_POST['tanggal'])."'");	
	}
	function get_total_trans(){
		$no_trans=@$_POST['no_trans'];
		$table=$_POST['table'];
		$where="where no_transaksi='$no_trans' and jenis_transaksi='GI'";
		
		$row_count=$this->inv_model->total_record($table,$where);
		echo $row_count;
	}
	//adjust stock barang di table inv_material
	function update_adjust(){
		$nm_barang=$_POST['nm_barang'];
		$stock=$_POST['stock'];
		$this->Admin_model->upd_data('inv_material','stock',"where nm_barang='".$nm_barang."'");
	}

	function _filename(){
		//configurasi data untuk generate form & list
		$this->zetro_buildlist->config_file('asset/bin/zetro_beli.frm');
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
	
	//proses print slip penjualan
	//create data text for print to dotmatrix
	function no_transaksi($no_trans=''){
		$this->no_trans=$no_trans;
	}
	function tanggal($tgl=''){
		$this->tgl=$tgl;
	}
	function redir(){
		redirect('penjualan/index');
	}
	//print slip besar format 1/2 kertas A4
	function print_slip(){
		$this->zetro_slip->path=$this->session->userdata('userid');
		$this->zetro_slip->modele('wb');
		$this->zetro_slip->newline();
		$this->no_transaksi($_POST['no_transaksi']);
		$this->tanggal(tgltoSql($_POST['tanggal']));
		$this->zetro_slip->content($this->struk_header());
		$this->zetro_slip->create_file();
		$this->re_print();
		//$this->index();
	}
	function re_print_slip(){
		$this->zetro_slip->path=$this->session->userdata('userid');
		$this->zetro_slip->modele('wb');
		$this->zetro_slip->newline();
		$notrans=$_POST['no_transaksi'];
		$tanggal=tglToSql($_POST['tanggal']);
		$this->no_transaksi($notrans);
		$this->tanggal($tanggal);
		$this->zetro_slip->content($this->struk_header());
		$this->zetro_slip->create_file();
		$this->re_print();
	}
	function struk_header(){
		$data=array();
		$slip="S L I P  P E N J U A L A N";
		$no_trans=$this->no_trans;
		$nfile	='asset/bin/zetro_config.dll';
		$coy	=$this->zetro_manager->rContent('InfoCo','Name',$nfile);	
		$address=$this->zetro_manager->rContent('InfoCo','Address',$nfile);
		$city	=$this->zetro_manager->rContent('InfoCo','Kota',$nfile);
		$phone	=$this->zetro_manager->rContent('InfoCo','Telp',$nfile);
		$fax	=$this->zetro_manager->rContent('InfoCo','Fax',$nfile);
		$tgl	=rdb('inv_penjualan','Tanggal','Tanggal',"where NoUrut='".$no_trans."' and Tanggal='".$this->tgl."'");
		$Jenis	=rdb('inv_penjualan','ID_Jenis','ID_Jenis',"where NoUrut='".$no_trans."' and Tanggal='".$this->tgl."'");
		$nJenis	=rdb('inv_penjualan_jenis','Jenis_Jual','Jenis_Jual',"where ID='".$Jenis."'");
		$no_faktur=rdb('inv_penjualan','Nomor','Nomor',"where NoUrut='".$no_trans."' and Tanggal='".$this->tgl."'");
		$isine	=array(
					sepasi(((80-(strlen($slip)+6))/2)).'** '.$slip.' **'.newline(),
					sepasi(80).newline(),
					$coy.sepasi((79-strlen($coy)-strlen('Tanggal :'.tglfromSql($tgl)))).'Tanggal :'.tglfromSql($tgl).newline(),
					$address.sepasi((79-strlen($address)-strlen('No. Faktur :'.$no_faktur))).'No. Faktur :'.$no_faktur.newline(),
					$phone.sepasi((79-strlen($phone)-strlen('Pembelian :'.$nJenis)-(10-strlen($nJenis)))).'Pembelian :'.$nJenis.newline(),
					str_repeat('-',79).newline(),
					'| No.|'.sepasi(((32-strlen('Nama Barang'))/2)).'Nama Barang'.sepasi(((32-strlen('Nama Barang'))/2)).
					'|'.sepasi(((10-strlen('Banyaknya'))/2)).'Banyaknya'.sepasi((((10-strlen('Banyaknya'))/2)-1)).'|'.
					sepasi(((14-strlen('Harga Satuan'))/2)).'Harga Satuan'.sepasi((((14-strlen('Harga Satuan'))/2)-1)).'|'.
					sepasi(((18-strlen('Total Harga'))/2)).'Total Harga'.sepasi((((17-strlen('Total Harga'))/2)-1)).'|'.newline(),
					str_repeat('-',79).newline(),
					$this->isi_slip(),
					($Jenis==1)?$this->struk_data_footer():$this->struk_data_footer_kredit()
					);
		return $isine;			
	}
	function isi_slip(){
		$data=array();$content="";$n=0;
		$this->inv_model->tabel('inv_penjualan_rekap');
		$data=$this->kasir_model->get_trans_jual($this->no_trans,$this->tgl);
		 foreach($data as $row){
			 $n++;
			 $satuan=rdb('inv_barang_satuan','Satuan','Satuan',"where ID='".
			 		 rdb('inv_barang','ID_Satuan','ID_Satuan',"where ID='".$row->ID_Barang."'")."'");
			$nama_barang=rdb('inv_barang','Nama_Barang','Nama_Barang',"where ID='".$row->ID_Barang."'");
			$content .=sepasi(((6-strlen($n))/2)).$n.sepasi(3).substr($nama_barang,0,31).sepasi((32-strlen($nama_barang))).
					 sepasi((8-strlen($row->Jumlah)-strlen($satuan))).round($row->Jumlah,0).sepasi(1).$satuan.
					 sepasi((13-strlen(number_format($row->Harga)))).number_format($row->Harga).
					 sepasi((16-strlen(number_format(($row->Jumlah *$row->Harga),2)))).number_format(($row->Jumlah *$row->Harga),2).newline();
		 }
		 if($n<8){
			 $content .=newline((8-$n));
		 }
		 return $content;
		 
	}
	function struk_data_footer(){
		$data=array();$bawah="";
		$nama=rdb('mst_anggota','Nama','Nama',"where ID='".rdb('inv_penjualan','ID_Anggota','ID_Anggota',"where NoUrut='".$this->no_trans."' and Tanggal='".$this->tgl."'")."'");
		$urut=rdb('mst_anggota','NoUrut','NoUrut',"where ID='".rdb('inv_penjualan','ID_Anggota','ID_Anggota',"where NoUrut='".$this->no_trans."' and Tanggal='".$this->tgl."'")."'");
		$alm =rdb('mst_departemen','Departemen','Departemen',"where ID='".
				rdb('mst_anggota','Nama','Nama',"where ID='".
				rdb('inv_penjualan','ID_Anggota','ID_Anggota',"where NoUrut='".$this->no_trans."' and Tanggal='".$this->tgl."'")."'")."'");
		$this->inv_model->tabel('inv_pembayaran');
		$data=$this->inv_model->show_list_1where('no_transaksi',$this->no_trans);
			foreach($data->result() as $row){
				$bawah=str_repeat('-',79).newline().
				sepasi((61-strlen('Sub Total'))).'Sub Total :'.sepasi((14-strlen(number_format($row->total_belanja,2)))).number_format($row->total_belanja,2).newline(2).
				sepasi((61-strlen('PPN 10%'))).'PPN 10%:'.sepasi((14-strlen(number_format($row->ppn,2)))).number_format($row->ppn,2).newline().
				sepasi(61).str_repeat('-',18).'+'.newline().
				sepasi((61-strlen('Total'))).'Total :'.sepasi((14-strlen(number_format($row->total_bayar,2)))).number_format($row->total_bayar,2).newline(2).
				sepasi((61-strlen('Cash'))).'Cash :'.sepasi((14-strlen(number_format($row->jml_dibayar,2)))).number_format($row->jml_dibayar,2).newline(2).
				sepasi(61).str_repeat('-',17).'-'.newline().
				sepasi((61-strlen('Kembali'))).'Kembali :'.sepasi((14-strlen(number_format($row->kembalian,2)))).number_format($row->kembalian,2).newline(2).
				str_repeat('-',79).newline().'Terima Kasih.'.newline();
				
/*				'No. Anggota'.sepasi((14-strlen('No.Anggota'))).':'.$urut.newline().
				'Nama Anggota'.sepasi((14-strlen('Nama Anggota'))).':'.$nama.newline().
				'Departemen'.sepasi((16-strlen('Departemen'))).':'.$alm.newline(2);
*/			}
		return $bawah;
	}
	function struk_data_footer_kredit(){
		$data=array();$bawah="";
		$nama=rdb('mst_anggota','Nama','Nama',"where ID='".rdb('inv_penjualan','ID_Anggota','ID_Anggota',"where NoUrut='".$this->no_trans."' and Tanggal='".$this->tgl."'")."'");
		$urut=rdb('mst_anggota','No_Agt','No_Agt',"where ID='".rdb('inv_penjualan','ID_Anggota','ID_Anggota',"where NoUrut='".$this->no_trans."' and Tanggal='".$this->tgl."'")."'");
		$alm =rdb('mst_departemen','Departemen','Departemen',"where ID='".
				rdb('mst_anggota','ID_Dept','ID_Dept',"where ID='".
				rdb('inv_penjualan','ID_Anggota','ID_Anggota',"where NoUrut='".$this->no_trans."' and Tanggal='".$this->tgl."'")."'")."'");
		$ncby=rdb('inv_penjualan_jenis','Jenis_Jual','Jenis_Jual',"where ID='".rdb('inv_penjualan','ID_Jenis','ID_Jenis',"where NoUrut='".$this->no_trans."' and Tanggal='".$this->tgl."'")."'");
		$bank=rdb('inv_penjualan','Deskripsi','Deskripsi',"where NoUrut='".$this->no_trans."' and Tanggal='".$this->tgl."'");
		$rek =rdb('inv_penjualan','ID_Post','ID_Post',"where NoUrut='".$this->no_trans."' and Tanggal='".$this->tgl."'");
		$tgir=rdb('inv_penjualan','Tgl_Cicilan','Tgl_Cicilan',"where NoUrut='".$this->no_trans."' and Tanggal='".$this->tgl."'");
		$this->inv_model->tabel('inv_pembayaran');
		$data=$this->inv_model->show_list_1where('no_transaksi',$this->no_trans);
			foreach($data->result() as $row){
				$bawah=str_repeat('-',79).newline().
				sepasi((61-strlen('Sub Total'))).'Sub Total :'.sepasi((14-strlen(number_format($row->total_belanja,2)))).number_format($row->total_belanja,2).newline(2).
				sepasi((61-strlen('PPN 10%'))).'PPN 10% :'.sepasi((14-strlen(number_format($row->ppn,2)))).number_format($row->ppn,2).newline().
				sepasi(61).str_repeat('-',18).'+'.newline().
				sepasi((61-strlen('Total'))).'Total :'.sepasi((14-strlen(number_format($row->total_bayar,2)))).number_format($row->total_bayar,2).newline(2).
				sepasi((61-strlen('Uang Muka'))).'Uang Muka :'.sepasi((14-strlen(number_format($row->jml_dibayar,2)))).number_format($row->jml_dibayar,2).newline(2).
				sepasi(61).str_repeat('-',17).'-'.newline().
				sepasi((61-strlen('Sisa'))).'Sisa :'.sepasi((14-strlen(number_format($row->kembalian,2)))).number_format($row->kembalian,2).newline(2).
				str_repeat('-',79).newline().
				'No. Anggota'.sepasi((14-strlen('No.Anggota :'))).':'.$urut.newline().
				'Nama Anggota'.sepasi((14-strlen('Nama Anggota :'))).' :'.$nama.newline().
				'Departemen'.sepasi((14-strlen('Departemen :'))).' :'.$alm.newline(1);
			}
		return $bawah;
	}
	//print struk kecil
	function print_slip_kecil(){
		$this->zetro_slip->modele('wb');
		$this->zetro_slip->path=$this->session->userdata('userid');
		$this->zetro_slip->newline();
		$this->no_transaksi($_POST['no_transaksi']);
		$this->tanggal(tgltoSql($_POST['tanggal']));
		$this->zetro_slip->content($this->struk_header_kecil());
		$this->zetro_slip->create_file();
		//$this->re_print();
		//$this->index();
	}
	function struk_header_kecil(){
		$data=array();
		$no_trans=$this->no_trans;
		$nfile	='asset/bin/zetro_config.dll';
		$coy	=$this->zetro_manager->rContent('InfoCo','Name',$nfile);	
		$address=$this->zetro_manager->rContent('InfoCo','Address',$nfile);
		$city	=$this->zetro_manager->rContent('InfoCo','Kota',$nfile);
		$phone	=$this->zetro_manager->rContent('InfoCo','Telp',$nfile);
		$fax	=$this->zetro_manager->rContent('InfoCo','Fax',$nfile);
		$tgl	=rdb('inv_penjualan','Tanggal','Tanggal',"where NoUrut='".$no_trans."' and Tanggal='".$this->tgl."'");
		$Jenis	=rdb('inv_penjualan','ID_Jenis','ID_Jenis',"where NoUrut='".$no_trans."' and Tanggal='".$this->tgl."'");
		$nJenis	=rdb('inv_penjualan_jenis','Jenis_Jual','Jenis_Jual',"where ID='".$Jenis."'");
		$no_faktur=rdb('inv_penjualan','Nomor','Nomor',"where NoUrut='".$no_trans."' and Tanggal='".$this->tgl."'");
		//$data	=$this->Admin_model->show_list('detail_transaksi',"where no_transaksi='$no_trans'");
		$isine	=array(
					sepasi(((40-(strlen($coy)+6))/2)).'** '.$coy.' **'.newline(),
					sepasi(((40-((strlen($address)+strlen(substr($city,0,-5)))))/2)).$address.' '.substr($city,0,-5).newline(),
					sepasi(((40-((strlen($phone))))/2)).$phone.newline(),
					sepasi(((40-((strlen($fax))))/2)).$fax.newline(),
					str_repeat('-',40).newline(),
					$this->isi_slip_kecil(),
					($Jenis==1)?$this->struk_data_footer_kecil():$this->struk_data_footer_kecil_kredit()
					);
		return $isine;			
	}
	function isi_slip_kecil(){
		$data=array();$content="";$n=0;
		$this->inv_model->tabel('inv_penjualan_rekap');
		$data=$this->kasir_model->get_trans_jual($this->no_trans,$this->tgl);
		 foreach($data as $row){
			 $n++;
			 $satuan=rdb('inv_barang_satuan','Satuan','Satuan',"where ID='".
			 		 rdb('inv_barang','ID_Satuan','ID_Satuan',"where ID='".$row->ID_Barang."'")."'");
			$nama_barang=rdb('inv_barang','Nama_Barang','Nama_Barang',"where ID='".$row->ID_Barang."'");
			$content .=$nama_barang.newline().
					 sepasi((5-strlen($row->Jumlah))).round($row->Jumlah,0).
					 sepasi((8-strlen($satuan))).$satuan.
					 sepasi((12-strlen(number_format($row->Harga)))).number_format($row->Harga).
					 sepasi((15-strlen(number_format(($row->Jumlah *$row->Harga),2)))).number_format(($row->Jumlah *$row->Harga),2).newline();
		 }
		 if($n<5){
			 $content .=newline((5-$n));
		 }
		 return $content;
		 
	}
	function struk_data_footer_kecil(){
		$data=array();$bawah="";$x=0;
		$nama=rdb('mst_anggota','Nama','Nama',"where ID='".rdb('inv_penjualan','ID_Anggota','ID_Anggota',"where NoUrut='".$this->no_trans."' and Tanggal='".$this->tgl."'")."'");
		$urut=rdb('mst_anggota','NoUrut','NoUrut',"where ID='".rdb('inv_penjualan','ID_Anggota','ID_Anggota',"where NoUrut='".$this->no_trans."' and Tanggal='".$this->tgl."'")."'");
		$alm =rdb('mst_departemen','Departemen','Departemen',"where ID='".
				rdb('mst_anggota','Nama','Nama',"where ID='".
				rdb('inv_penjualan','ID_Anggota','ID_Anggota',"where NoUrut='".$this->no_trans."' and Tanggal='".$this->tgl."'")."'")."'");
		$this->inv_model->tabel('inv_pembayaran');
		$data=$this->inv_model->show_list_1where('no_transaksi',$this->no_trans);
			foreach($data->result() as $row){
				$bawah=str_repeat('-',40).newline().
				'Sub Total'.sepasi((31-strlen(number_format($row->total_belanja,2)))).number_format($row->total_belanja,2).newline(2).
				'PPN 10%'.sepasi((33-strlen(number_format($row->ppn,2)))).number_format($row->ppn,2).newline().
				str_repeat('-',40).newline().
				'Total'.sepasi((35-strlen(number_format($row->total_bayar,2)))).number_format($row->total_bayar,2).newline(2).
				'Cash'.sepasi((36-strlen(number_format($row->jml_dibayar,2)))).number_format($row->jml_dibayar,2).newline().
				'Kembali'.sepasi((33-strlen(number_format($row->kembalian,2)))).number_format($row->kembalian,2).newline(2).
				str_repeat('-',40).newline().
				'Kasir :'.$row->created_by.' '.$row->doc_date.newline().
				'Doc No:'.$row->no_transaksi.newline(2).
				'Terima Kasih '.newline().
				str_repeat('-',40).newline(2)."Info Promo :".newline();
				$data=$this->Admin_model->show_list('mst_promo',"where dari_tgl <='".$this->tgl."' and sampai_tgl >='".$this->tgl."' order by ID");
				foreach($data as $r){
					$bawah .=chunk_split($r->Keterangan,40,newline()).newline();
				}
			}
		return $bawah;
	}
	function struk_data_footer_kecil_kredit(){
		$data=array();$bawah="";$x=0;
		$nama=rdb('mst_anggota','Nama','Nama',"where ID='".rdb('inv_penjualan','ID_Anggota','ID_Anggota',"where NoUrut='".$this->no_trans."' and Tanggal='".$this->tgl."'")."'");
		$urut=rdb('mst_anggota','No_Agt','No_Agt',"where ID='".rdb('inv_penjualan','ID_Anggota','ID_Anggota',"where NoUrut='".$this->no_trans."' and Tanggal='".$this->tgl."'")."'");
		$alm =rdb('mst_departemen','Title','Title',"where ID='".
				rdb('mst_anggota','ID_Dept','ID_Dept',"where ID='".
				rdb('inv_penjualan','ID_Anggota','ID_Anggota',"where NoUrut='".$this->no_trans."' and Tanggal='".$this->tgl."'")."'")."'");
		$ncby=rdb('inv_penjualan_jenis','Jenis_Jual','Jenis_Jual',"where ID='".rdb('inv_penjualan','ID_Jenis','ID_Jenis',"where NoUrut='".$this->no_trans."' and Tanggal='".$this->tgl."'")."'");
		$bank=rdb('inv_penjualan','Deskripsi','Deskripsi',"where NoUrut='".$this->no_trans."' and Tanggal='".$this->tgl."'");
		$rek =rdb('inv_penjualan','ID_Post','ID_Post',"where NoUrut='".$this->no_trans."' and Tanggal='".$this->tgl."'");
		$tgir=rdb('inv_penjualan','Tgl_Cicilan','Tgl_Cicilan',"where NoUrut='".$this->no_trans."' and Tanggal='".$this->tgl."'");
		$this->inv_model->tabel('inv_pembayaran');
		$data=$this->inv_model->show_list_1where('no_transaksi',$this->no_trans);
			foreach($data->result() as $row){
				$bawah=str_repeat('-',40).newline().
				'Sub Total'.sepasi((31-strlen(number_format($row->total_belanja,2)))).number_format($row->total_belanja,2).newline(2).
				'PPN 10%'.sepasi((33-strlen(number_format($row->ppn,2)))).number_format($row->ppn,2).newline().
				str_repeat('-',40).newline().
				'Total'.sepasi((35-strlen(number_format($row->total_bayar,2)))).number_format($row->total_bayar,2).newline(2).
				'Uang Muka'.sepasi((31-strlen(number_format($row->jml_dibayar,2)))).number_format($row->jml_dibayar,2).newline().
				'Saldo'.sepasi((35-strlen(number_format($row->kembalian,2)))).number_format($row->kembalian,2).newline(2).
				str_repeat('-',40).newline().
				'Kasir :'.$row->created_by.' '.$row->doc_date.newline().
				'Doc No:'.$row->no_transaksi.newline(2).
				'Terima Kasih '.newline().
				str_repeat('-',40).newline().
				'No. Anggota'.sepasi((14-strlen('No.Anggota :'))).':'.$urut.newline().
				'Nama Anggota'.sepasi((14-strlen('Nama Anggota :'))).' :'.$nama.newline().
				'Departemen'.sepasi((14-strlen('Departemen :'))).' :'.$alm.newline(1).
				str_repeat('-',40).newline(2)."Info Promo :".newline();
				$data=$this->Admin_model->show_list('mst_promo',"where dari_tgl <='".$this->tgl."' and sampai_tgl >='".$this->tgl."' order by ID");
				foreach($data as $r){
					$bawah .=chunk_split($r->Keterangan,'40',newline()).newline();
				}
			}
		return $bawah;
	}
	function promo(){
		$data=array();$text='Info : ';
		$data=$this->Admin_model->show_list('mst_promo',"where dari_tgl <='".$this->tgl."' and sampai_tgl >='".$this->tgl."' order by ID");
		foreach($data as $r){
			$text .=$r->Keterangan.newline();
		}
		$cek=chunk_split($text,'36','<br>');
		return $cek;
	}
	function re_print(){
		system("print c:\\app\\".$this->session->userdata('userid')."_slip.txt");
		system("close");
	}
	//simpan komposisi resep
	function stock_resep(){
		$data=array();
		$data['nm_barang']=strtoupper($_POST['nm_barang']);
		$data['batch']=str_replace('-','',tgltoSql($_POST['batch']));
		$data['expired']=tgltoSql($_POST['expired']);
		$data['stock']=$_POST['stock'];
		$data['blokstok']=$_POST['blokstok'];
		$data['nm_satuan']=$_POST['nm_satuan'];
		$data['harga_beli']=$_POST['harga_beli'];
		$data['created_by']	=$this->session->userdata('userid');
		print_r($data);
		$this->Admin_model->replace_data('inv_material_stok',$data);
	}
	//return penjualan
	
	function return_jual(){
		$data=array();
		$this->zetro_auth->menu_id(array('returnjual'));
		$this->list_data($this->zetro_auth->auth());
		$this->View('penjualan/material_jual_return');
	}
	function get_transaksi(){
		$data=array();
		$no_transaksi=$_POST['no_transaksi'];
		$this->inv_model->tabel('detail_transaksi');
		$data['tgl_transaksi']=tglfromSql($this->Admin_model->show_single_field('detail_transaksi','tgl_transaksi',"where no_transaksi='$no_transaksi'"));
		$data['faktur_transaksi']=$this->Admin_model->show_single_field('detail_transaksi','faktur_transaksi',"where no_transaksi='$no_transaksi'");
		$data['nm_nasabah']=$this->Admin_model->show_single_field('detail_transaksi','nm_produsen',"where no_transaksi='$no_transaksi'");
			echo json_encode($data);
	}
	function get_detail_transaksi(){
		$datax=array();
		$nm_barang=$_POST['nm_barang'];
		$no_transaksi=$_POST['no_transaksi'];
		$this->inv_model->tabel('detail_transaksi');
		$datax=$this->inv_model->detail_transaksi($no_transaksi,$nm_barang);
		echo json_encode($datax[0]);
	}
	function process_to_jurnal($id_anggota,$total,$ket=''){
	/* membuat data untuk diposting dalam jurnal
	  simpan penjualan barang secara kredit
	  inputnya adalah ID anggota yng melakukan pembelian secara kredit
	  dapatkan ID_Perkiraan dari table perkiraan based on ID_Anggota
	  extract data perkiraan menjadi klass, sub klass dan jenis simpanan dalam hal ini
	  jenis simpanan adalah barang [id:4]
	  data yang dihasilkan akan ditampung di table transaksi_temp
	*/ 
		$data=array();$akun='';
		//get ID_perkiraan
		$akun=rdb('perkiraan','ID','ID',"where ID_Agt='$id_anggota' and ID_Simpanan='4'");
		if($akun==''){
			//update database perkiraan
			$this->_update_perkiraan($id_anggota,'4');	
		}
		$data['ID_Perkiraan']	=rdb('perkiraan','ID','ID',"where ID_Agt='$id_anggota' and ID_Simpanan='4'");
		$data['ID_Unit']		=rdb('jenis_simpanan','ID_Unit','ID_Unit',"where ID='4'");
		$data['ID_Klas']		=rdb('jenis_simpanan','ID_Klasifikasi','ID_Klasifikasi',"where ID='4'");
		$data['ID_SubKlas']		=rdb('jenis_simpanan','ID_SubKlas','ID_SubKlas',"where ID='4'");
		$data['ID_Dept']		=($id_anggota=='0')?'0':rdb('mst_anggota','ID_Dept','ID_Dept',"where ID='".$id_anggota."'");
		if($ket==''){
			$data['Debet']		=$total;//rdb('inv_penjualan','Total','Total',"where ID_Anggota='".$id_anggota."' and NoUrut='".$this->no_trans."'");
		}else{
			$data['Kredit']		=$total;
		}
		$data['Keterangan']		=($ket=='')?'Kredit barang toko no. Faktur: '.rdb('inv_penjualan','Nomor','Nomor',"where NoUrut='".$this->no_trans."'"):$ket;
		$data['tanggal']		=tgltoSql($this->tgl);
		$data['ID_Bulan']		=substr($this->tgl,3,2);
		$data['Tahun']			=substr($this->tgl,6,4);
		$data['created_by']		=$this->session->userdata('userid');
		//print_r($data);
		 $this->Admin_model->replace_data('transaksi_temp',$data);
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
	function get_bank(){
		$data=array();
		$str	=$_GET['str'];
		$limit	=$_GET['limit'];
		$fld	=rdb('mst_anggota','Nama','Nama',"where ID='".$_GET['fld']."'");
		$data=$this->inv_model->get_bank($str);
		echo json_encode($data);	
	}
	
	function get_no_transaction(){
		$data=array();
		$tgl=empty($_POST['tanggal'])?date('Ymd'):tglToSql($_POST['tanggal']);
		$data=$this->Admin_model->show_list('inv_penjualan',"where Tanggal ='".$tgl."'");
		echo "<option value=''>--pilih no faktur--</option>";
		foreach($data as $r){
		 echo "<option value='".$r->NoUrut."'>".$r->Nomor."</option>";
		}
	}
}
?>