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
		$TotalHg	=$_POST['total'];
		$Tanggal	=$_POST['tanggal'];
		$id_anggota	=empty($_POST['id_anggota'])?'':$_POST['id_anggota'];
		$cicilan	=empty($_POST['cicilan'])?'0':$_POST['cicilan'];
		$this->Admin_model->upd_data('inv_penjualan',"set ID_Jenis='$ID_Jenis', ID_Anggota='$id_anggota', Total='".$TotalHg."', Cicilan='".$cicilan."'","where NoUrut='".$no_trans."' and	Tanggal='".tgltoSql($Tanggal)."'");
		$this->no_transaksi($no_trans);
		$this->tanggal($Tanggal);
		if($ID_Jenis=='2' && $id_anggota!=''){
			$this->process_to_jurnal($id_anggota,$TotalHg);
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
		$data['Tahun']		=empty($_POST['batch'])?'0':$_POST['batch'];
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
		$data['ppn']			=$_POST['ppn'];	
		$data['total_bayar']	=$_POST['total_bayar'];	
		$data['jml_dibayar']	=$_POST['dibayar'];	
		$data['kembalian']		=$_POST['kembalian'];
		//$data['terbilang']		=$_POST['terbilang'];
		$data['created_by']	=$this->session->userdata('userid');
		$this->update_material_stock($_POST['no_transaksi'],tgltoSql($_POST['tanggal']));//update stock
		
		$this->Admin_model->replace_data('inv_pembayaran',$data);
		//$this->Admin_model->hps_data('inv_material',"where nm_barang='".$_POST[
		echo $_POST['no_transaksi'];
	}
	//update data stok material setelah di lakukan transaksi
	//transaksi penjualan
	function update_material_stock($ntran,$tgl){
		$data=array();$first_stock=0;$end_stock=0;$datax=array();$hgb=0;
		$data=$this->Admin_model->show_list('inv_penjualan_detail',"where ID_Jual='".rdb('inv_penjualan','ID','ID',"where NoUrut='".$ntran."' and Tanggal='". $tgl."'")."'");
		//print_r($data);
		foreach($data as $r){
			$hgb=rdb('inv_material_stok','harga_beli','harga_beli',"where id_barang='".$r->ID_Barang."' and batch='".$r->Tahun."'");
			$first_stock=rdb('inv_material_stok','stock','stock',"where id_barang='".$r->ID_Barang."' and batch='".$r->Tahun."'");
			$end_stock=($first_stock-$r->Jumlah);
			$datax['id_barang']	=$r->ID_Barang;
			$datax['nm_barang']	=rdb('inv_barang','Nama_Barang','Nama_Barang',"where ID='".$r->ID_Barang."'");
			$datax['batch']		=$r->Tahun;
			$datax['stock']		=$end_stock;
			$datax['harga_beli']=empty($hgb)?'0':$hgb;
			$datax['nm_satuan'] =rdb('inv_barang','ID_Satuan','ID_Satuan',"where ID='".$r->ID_Barang."'");
			$this->Admin_model->replace_data('inv_material_stok',$datax);
		}
	}

	function batal_transaksi(){
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
	function no_transaksi($no_trans){
		$this->no_trans=$no_trans;
	}
	function tanggal($tgl){
		$this->tgl=$tgl;
	}
	function redir(){
		redirect('penjualan/index');
	}
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
		$no_faktur=rdb('inv_penjualan','Nomor','Nomor',"where NoUrut='".$no_trans."' and Tanggal='".$this->tgl."'");
		//$data	=$this->Admin_model->show_list('detail_transaksi',"where no_transaksi='$no_trans'");
		$isine	=array(
					sepasi(((80-(strlen($slip)+6))/2)).'** '.$slip.' **'.newline(),
					sepasi(80).newline(),
					$coy.sepasi((79-strlen($coy)-strlen('Tanggal :'.tglfromSql($tgl))-3)).'Tanggal :'.tglfromSql($tgl).newline(),
					$address.sepasi((79-strlen($address)-strlen('No. Faktur :'.$no_faktur))).'No. Faktur :'.$no_faktur.newline(),
					$phone.newline(),
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
		$this->inv_model->tabel('inv_pembayaran');
		$data=$this->inv_model->show_list_1where('no_transaksi',$this->no_trans);
			foreach($data->result() as $row){
				$bawah=str_repeat('-',79).newline().
				sepasi((61-strlen('Sub Total'))).'Sub Total :'.sepasi((14-strlen(number_format($row->total_belanja,2)))).number_format($row->total_belanja,2).newline(2).
				sepasi((61-strlen('PPN 10%'))).'PPN 10% :'.sepasi((14-strlen(number_format($row->ppn,2)))).number_format($row->ppn,2).newline().
				sepasi(61).str_repeat('-',18).'+'.newline().
				sepasi((61-strlen('Total'))).'Total :'.sepasi((14-strlen(number_format($row->total_bayar,2)))).number_format($row->total_bayar,2).newline(2).
				sepasi((61-strlen('Cash'))).'Cash :'.sepasi((14-strlen(number_format($row->jml_dibayar,2)))).number_format($row->jml_dibayar,2).newline(2).
				sepasi((61-strlen('Kembali'))).'Kembali :'.sepasi((14-strlen(number_format($row->kembalian,2)))).number_format($row->kembalian,2).newline(2).
				str_repeat('-',79).newline().
				'Nama Anggota'.sepasi((14-strlen('Nama Anggota'))).':'.$nama.newline().
				'Deptement'.sepasi((16-strlen('Departement'))).':'.newline(2);
			}
		return $bawah;
	}
	function struk_data_footer_kredit(){
		$data=array();$bawah="";
		$nama=rdb('mst_anggota','Nama','Nama',"where ID='".rdb('inv_penjualan','ID_Anggota','ID_Anggota',"where NoUrut='".$this->no_trans."' and Tanggal='".$this->tgl."'")."'");
		$this->inv_model->tabel('inv_pembayaran');
		$data=$this->inv_model->show_list_1where('no_transaksi',$this->no_trans);
			foreach($data->result() as $row){
				$bawah=str_repeat('-',40).newline().
				'Sub Total'.sepasi((31-strlen(number_format($row->total_belanja,2)))).number_format($row->total_belanja,2).newline(2).
				'PPN 10%'.sepasi((33-strlen(number_format($row->ppn,2)))).number_format($row->ppn,2).newline().
				str_repeat('-',40).newline().
				'Total'.sepasi((35-strlen(number_format($row->total_bayar,2)))).number_format($row->total_bayar,2).newline(2).
				'Uang Muka'.sepasi((31-strlen(number_format($row->jml_dibayar,2)))).number_format($row->jml_dibayar,2).newline().
				'Sisa '.sepasi((35-strlen(number_format($row->kembalian,2)))).number_format($row->kembalian,2).newline(2).
				str_repeat('-',40).newline().
				'Kasir :'.$row->created_by.' '.$row->doc_date.newline().
				'Doc No:'.$row->no_transaksi.newline(2);
			}
		return $bawah;
	}
	function re_print(){
		system("print ".$this->session->userdata('userid')."_slip.txt");
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
		$this->zetro_auth->menu_id(array('penjualan__return_jual'));
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
	function get_material(){
		$datax=array();
		$str=addslashes($_POST['str']);
		$induk=$_POST['induk'];
		$fld='nm_barang';
		$this->inv_model->tabel('detail_transaksi');
		$datax=$this->inv_model->get_material('no_transaksi',$str);
			echo "<ul>";
				foreach ($datax as $lst){
					echo '<li onclick="suggest_click(\''.$lst.'\',\''.$fld.'\',\''.$induk.'\');">'.$lst."</li>";
				}
			echo "</ul>";
	}
	function get_detail_transaksi(){
		$datax=array();
		$nm_barang=$_POST['nm_barang'];
		$no_transaksi=$_POST['no_transaksi'];
		$this->inv_model->tabel('detail_transaksi');
		$datax=$this->inv_model->detail_transaksi($no_transaksi,$nm_barang);
		echo json_encode($datax[0]);
	}
	function process_to_jurnal($id_anggota,$total){
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
			_update_perkiraan($id_anggota,'4');	
		}
		$data['ID_Perkiraan']	=rdb('perkiraan','ID','ID',"where ID_Agt='$id_anggota' and ID_Simpanan='4'");
		$data['ID_Unit']		=rdb('jenis_simpanan','ID_Unit','ID_Unit',"where ID='4'");
		$data['ID_Klas']		=rdb('jenis_simpanan','ID_Klasifikasi','ID_Klasifikasi',"where ID='4'");
		$data['ID_SubKlas']		=rdb('jenis_simpanan','ID_SubKlas','ID_SubKlas',"where ID='4'");
		$data['ID_Dept']		=rdb('mst_anggota','ID_Dept','ID_Dept',"where ID='".$id_anggota."'");
		$data['Debet']			=$total;//rdb('inv_penjualan','Total','Total',"where ID_Anggota='".$id_anggota."' and NoUrut='".$this->no_trans."'");
		$data['Keterangan']		='Kredit barang toko no. Faktur: '.rdb('inv_penjualan','Nomor','Nomor',"where NoUrut='".$this->no_trans."'");
		$data['tanggal']		=tgltoSql($this->tgl);
		$data['ID_Bulan']		=substr($this->tgl,3,2);
		$data['Tahun']			=substr($this->tgl,6,4);
		$data['created_by']		=$this->session->userdata('userid');
		//print_r($data);
		 $this->Admin_model->replace_data('transaksi_temp',$data);
	}
	//updata table perkiraan jika anggota belum masuk di data perkiraan
	function _update_perkiraan($ID_Agt,$ID_Simpanan){
		$datax=array();
		$datax['ID_Unit']		=rdb('jenis_simpanan','ID_Unit','ID_Unit',"where ID='4'");
		$datax['ID_Klas']		=rdb('jenis_simpanan','ID_Klasifikasi','ID_Klasifikasi',"where ID='4'");
		$datax['ID_SubKlas']		=rdb('jenis_simpanan','ID_SubKlas','ID_SubKlas',"where ID='4'");
		$datax['ID_Dept']		=rdb('mst_anggota','ID_Dept','ID_Dept',"where ID='".$ID_Agt."'");
		$datax['ID_Simpanan']	=$ID_Simpanan;
		$datax['ID_Agt']			=$ID_Agt;
		$datax['ID_Calc']		=rdb('jenis_simpanan','ID_Calc','ID_Unit',"where ID='4'");
		$datax['ID_Laporan']		=rdb('jenis_simpanan','ID_Laporan','ID_Laporan',"where ID='4'");
		$datax['ID_LapDetail']	=rdb('jenis_simpanan','ID_LapDetail','ID_LapDetail',"where ID='4'");
		echo $this->Admin_model->replace_data('perkiraan',$datax);
		//print_r($datax);
	}
	
}
?>