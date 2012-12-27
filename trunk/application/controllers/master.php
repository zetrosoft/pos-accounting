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
		$this->load->helper('directory');
		$this->load->helper('file');
		$this->load->helper('date');
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
		$datax=$this->akun_model->get_neraca_head("='0' order by ID_Head");
		$data=$this->akun_model->get_neraca_head();
		$this->zetro_auth->menu_id(array('master__tools','settingneraca'));
		$this->list_data($this->zetro_auth->auth(array('head','shu'),array($data,$datax)));
		$this->View('master/master_tools');
	}
	function shu(){
		$datax=$this->akun_model->get_neraca_head("='0' order by ID");
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
		$this->zetro_auth->menu_id(array('tambahpemasok','listpemasok'));
		$this->list_data($this->zetro_auth->auth());
		$this->View('master/master_vendor');
	}
	function general(){
		$this->zetro_auth->menu_id(array('dataakun','datageneral'));
		$this->list_data($this->zetro_auth->auth());
		$this->View('master/master_general');
	}
	function promo(){
		$this->create_table_promo();
		$this->zetro_auth->menu_id(array('informasipromo'));
		$this->list_data($this->zetro_auth->auth());
		$this->View('master/master_promo');
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
				 <td class='kotak' align='center'>".img_aksi('S-'.$row->ID.'-'.$ID,true)."</td>
				 </tr>\n";
		}
		
	}
	function set_head_shu(){
		$data=array();
		$data['ID']		=empty($_POST['ID'])?'':$_POST['ID'];
		$data['ID_Calc']=$_POST['ID_Calc'];
		$data['ID_KBR']	=$_POST['ID_KBR'];
		$data['ID_USP']	=$_POST['ID_USP'];
		$data['Jenis']	=strtoupper($_POST['jenis']);
		$data['Jenis1']	=$_POST['jenis'];
		$data['ID_Head']=$_POST['ID_Head'];
		$this->Admin_model->replace_data('lap_jenis',$data);
	}
	function del_head_shu(){
		$ID=$_POST['ID'];
		$this->Admin_model->hps_data('lap_jenis',"where ID='$ID'");
	}
	function get_head_shu(){
		$data=array();
		$ID=$_POST['ID'];
		$data=$this->akun_model->get_lap_jenis($ID);
		echo json_encode($data[0]);
	}
	function set_sub_shu(){
		$data=array();
		$data['ID']		=empty($_POST['ID'])?'':$_POST['ID'];
		$data['ID_Calc']=$_POST['ID_Calc'];
		$data['ID_KBR']	=$_POST['ID_KBR'];
		$data['ID_USP']	=$_POST['ID_USP'];
		$data['SubJenis']=$_POST['jenis'];
		$data['ID_Jenis']=$_POST['ID_Jenis'];
		$data['ID_Lap']	=$_POST['ID_Lap'];
		$data['ID_Post']='0';
		$data['NoUrut'] ='1';
		$this->Admin_model->replace_data('lap_subjenis',$data);
		echo $_POST['ID_Jenis'];
	}
	function del_sub_shu(){
		$ID=$_POST['ID'];
		$this->Admin_model->hps_data('lap_subjenis',"where ID='$ID'");
	}
	function get_subjenis_shu(){
		$data=array();
		$ID=$_POST['ID'];
		$data=$this->akun_model->get_lap_subjenis($ID);
		echo json_encode($data[0]);
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
	
	function backup(){
		$this->zetro_auth->menu_id(array('master__backup'));
		$this->list_data($this->zetro_auth->auth());
		$this->View('master/master_backup');
	}
	
  
  function back_up_db(){
  $ccyymmdd = date("Ymd");
  $tabel=$_POST['Tabel'];
  $bln=$_POST['bln'];
  $end_bln=empty($_POST['s_bln'])?$_POST['bln']:$_POST['s_bln'];
  $thn=$_POST['thn'];
  $jenis=$_POST['jenis'];
  if ($jenis=='acc'){
  $file = fopen("asset\\backup_db\\accounting_".nBulan($bln).'_'.nBulan($end_bln).'_'.$thn.".sql.dll","w+");
	$where="where (ID_Bulan between '".$bln."' and '".$end_bln."') and Tahun='".$thn."'";
 	$line_count = $this->create_backup_sql($file,'jurnal',$where);
	$line_count = $this->backup_akun($file,'transaksi',$where);
  }else{
	  $where="where (month(Tanggal) between '".$bln."' and '".$end_bln."') and year(Tanggal)='".$thn."'";
	  $file = fopen("asset\\backup_db\\inventory_".nBulan($bln).'_'.nBulan($end_bln).'_'.$thn.".sql.dll","w+");
	  	$line_count = $this->create_backup_sql($file,'inv_pembelian',$where);
		$line_count = $this->backup_akun($file,'inv_pembelian_detail',$where);
	  	$line_count = $this->create_backup_sql($file,'inv_penjualan',$where);
		$line_count = $this->backup_akun($file,'inv_penjualan_detail',$where);
  }
  fclose($file);
  echo " : [<i>Backup table $tabel berhasil total data : ".number_format($line_count,0)."</i>]";

  }
  function create_backup_sql($file,$tabel,$where='') {
    $line_count = 0;
    $sql_string = NULL;
      $table_name = $tabel;
      $table_query = mysql_query("SELECT * FROM `$table_name` $where");
      $num_fields = mysql_num_fields($table_query);
      while ($fetch_row = mysql_fetch_array($table_query)) {
        $sql_string .= "REPLACE INTO $table_name VALUES(";
        $first = TRUE;
        for ($field_count=1;$field_count<=$num_fields;$field_count++){
          if (TRUE == $first) {
            $sql_string .= "'".mysql_real_escape_string($fetch_row[($field_count - 1)])."'";
            $first = FALSE;            
          } else {
            $sql_string .= ", '".mysql_real_escape_string($fetch_row[($field_count - 1)])."'";
          }
        }
        $sql_string .= ");\n\r";
        if ($sql_string != ""){
          $line_count = $this->write_backup_sql($file,$sql_string,$line_count);        
        }
        $sql_string = NULL;
      }    
//    }
    return $line_count;
  }
 function backup_akun($file,$tabel,$where){
    $line_count = 0;$fld='';$tabel2='';
    $sql_string = NULL;
	if($tabel=='transaksi'){
		$fld='ID_Jurnal';
		$tabel2='jurnal';
	}else if($tabel=='inv_pembelian_detail'){
		$fld='ID_Beli';
		$tabel2='inv_pembelian';
	}else if($tabel=='inv_penjualan_detail'){
		$fld='ID_Jual';
		$tabel2='inv_penjualan';
	}
	 $sql="select ID from $tabel2 $where";
	 $rs=mysql_query($sql) or die(mysql_error());
	 while ($r=mysql_fetch_object($rs)){
		  $table_query = mysql_query("SELECT * FROM $tabel where $fld='".$r->ID."'");
		  $num_fields = mysql_num_fields($table_query);
		  while ($fetch_row = mysql_fetch_array($table_query)) {
			$sql_string .= "REPLACE INTO $tabel VALUES(";
			$first = TRUE;
			for ($field_count=1;$field_count<=$num_fields;$field_count++){
			  if (TRUE == $first) {
				$sql_string .= "'".mysql_real_escape_string($fetch_row[($field_count - 1)])."'";
				$first = FALSE;            
			  } else {
				$sql_string .= ", '".mysql_real_escape_string($fetch_row[($field_count - 1)])."'";
			  }
			}
			$sql_string .= ");";
			if ($sql_string != ""){
			  $line_count = $this->write_backup_sql($file,$sql_string,$line_count);        
			}
			$sql_string = NULL;
		  }    
    }
    return $line_count;
 }

  function write_backup_sql($file, $string_in, $line_count) { 
    fwrite($file, $string_in);
    return ++$line_count;
  }
  
  function read_dir(){
	$map= get_filenames("./asset/backup_db",false,true);
	$x=0;$tgl=array();
	sort($map);
	reset($map);
	foreach($map as $index=> $n){
		if(!preg_match("/\.sql.dll$/", $n)) continue;
		$x++;
		$ukuran=filesize("asset/backup_db/".$n);
		$sise=($ukuran < 10240)?number_format(($ukuran/1024),2)." Kb":number_format(($ukuran/(1024*1000)),2)." Mb";
		$tgl=get_file_info("asset/backup_db/".$n);
		echo tr().td($x,'center').td($n."</a>").td($sise,'right').
				  td(date('d-m-Y H:i:s',($tgl['date'])),'center').
				  td("<a href='".base_url()."asset/backup_db/".$n."'>
				  		<img src='".base_url()."asset/images/6.png' title='Download file backup'></a>")._tr();
		clearstatcache();
	}
  }
  function download_file(){
	 $fname=$_POST['fname'];
	header("Content-Type: application");
	header("Content-Disposition: attachment; filename=\"$fname\"");
	header('Pragma: no-cache');
	echo "<script language='javascript'>
		document.location.reload()
		</scrip>";
	//echo file_get_contents("asset/backup_db/".$fname);
  
  }
  //promo yang akan di cetak distruk
  
  function list_promo(){
	$data=array();$n=0;
	$data=$this->Admin_model->show_list('mst_promo',"order by sampai_tgl desc");
	$cek_oto=$this->zetro_auth->cek_oto('c','informasipromo');
	if($data){
		foreach($data as $r){
			$n++;
			echo tr().td($n,'center').
				 td($r->Judul).
				 td(tglfromSql($r->Dari_tgl),'center').
				 td(tglfromSql($r->Sampai_tgl),'center').
				 td($r->Keterangan).
				 td(($cek_oto!='')?img_aksi($r->ID,'del',false):$r->Sratus_promo,'center').
				_tr();	
		}
	}else{
	 echo tr().td('No Data found','left\' colspan=\'6')._tr();	
	}
  }
  function set_promo(){
	 $data=array();
	 $data['ID']=empty($_POST['id'])?'0':$_POST['id'];
	 $data['Judul']=ucwords(addslashes($_POST['judul']));
	 $data['Dari_tgl']=tgltoSql($_POST['dari']);
	 $data['Sampai_tgl']=empty($_POST['sampai'])?tgltoSql($_POST['dari']):tglToSql($_POST['sampai']);
	 $data['Keterangan']=ucwords(addslashes($_POST['keterangan']));
	 $this->Admin_model->replace_data('mst_promo',$data);
  }
  function edit_promo(){
	  $data=array();
		$id=$_POST['id'];
		$data= $this->Admin_model->show_list('mst_promo',"where ID='".$id."'");
		echo json_encode($data[0]);
  }
  
  function hapus_promo(){
	$id=$_POST['id'];
	$this->Admin_model->hps_data('mst_promo',"where ID='".$id."'");  
  }
  function create_table_promo(){
		$sql="CREATE TABLE IF NOt EXISTS `mst_promo` (
			`ID` INT(10) NULL AUTO_INCREMENT,
			`Judul` VARCHAR(150) NULL,
			`Dari_tgl` DATE NULL,
			`Sampai_tgl` DATE NULL,
			`Keterangan` TEXT NULL,
			`Status_promo` ENUM('Y','N') NULL DEFAULT 'Y',
			PRIMARY KEY (`ID`)
		)
		COLLATE='latin1_swedish_ci'
		ENGINE=MyISAM;";
		mysql_query($sql) or die(mysql_error());
  }
}
