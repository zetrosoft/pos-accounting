<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//class name	: Simpanan
//version		: 1.0
//Author		: Iswan Putera

class Simpanan extends CI_Controller{
	
	function __construct(){
		parent::__construct();
		$this->load->model("Admin_model");
		$this->load->model("member_model");
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
		$this->load->view($view,$this->data);	
		$this->Footer();
	}
	//process transaksi simpanan anggota kredit maupun debit
	function t_simpanan(){
		$this->zetro_auth->menu_id(array('transaksisimpanan'));
		$this->list_data($this->zetro_auth->auth());
		$this->View('member/member_simpanan');
	}
	//teknik membercepat loading database mst_anggota dengan memasukan data yang di pilih
	//table copy
	function set_copy_agt(){
		$ID_Dept=$_POST['ID_Dept'];
		$ID_pinj=empty($_POST['ID_Pinj'])?'':$_POST['ID_Pinj'];
		echo $this->member_model->copy_agt($ID_Dept,$ID_pinj);	
	}
	//baca data setup simpanan wajib dan pokok anggota
	function get_jml_simpanan(){
		$ID=$_POST['ID'];
		$data=$this->member_model->jml_simpanan($ID);
		echo $data;
	}
	//simpan transaksi simpanan anggota
	function set_simpanan(){
		$data=array();
		$ID_Jenis		=$_POST['ID_Jenis'];
		$ID_Unit		=$_POST['ID_Unit'];
		$ID_Simpanan	=$_POST['ID_Simpanan'];
		$ID_Dept		=$_POST['ID_Dept'];
		$ID_Perkiraan	=$_POST['ID_Perkiraan'];
		$jumlah			=$_POST['jumlah'];
		$data['ID_Unit']	=$ID_Unit;
		$data['ID_Dept']	=$ID_Dept;
		$data['ID_Klas']	=rdb("jenis_simpanan",'ID_Klasifikasi','ID_Klasifikasi',"where ID='$ID_Simpanan'");
		$data['ID_SubKlas']	=rdb("jenis_simpanan",'ID_Klasifikasi','ID_Klasifikasi',"where ID='$ID_Simpanan'");
		$data['ID_Perkiraan']=rdb('perkiraan','ID','ID',"where ID_Agt='$ID_Perkiraan' and ID_Simpanan='$ID_Simpanan'");
		$data['Debet']		=($ID_Jenis==1)?$jumlah:0;
		$data['Kredit']		=($ID_Jenis==2)?$jumlah:0;
		$data['Keterangan']	=$_POST['keterangan'];
		$data['ID_Stat']	='0';
		$data['ID_Bulan']	=$_POST['ID_Bulan'];
		$data['Tahun']		=$_POST['Tahun'];
		$data['created_by']	=$this->session->userdata('userid');
		echo $this->Admin_model->replace_data('transaksi_temp',$data);
	}
	//simpan transaksi untuk pembayaran dengan cara potong gaji
	function set_potonggaji(){
		$ID_Jenis	=$_POST['ID_Jenis'];
		$ID_Agt		=$_POST['ID_Agt'];
		$ID_Simpanan=$_POST['ID_Simpanan'];
		$jumlah		=$_POST['jumlah'];
		//collect data to array
		$data['ID_Unit']	=rdb('perkiraan','ID_Unit','ID_Unit',"where ID_Agt='$ID_Agt'");
		$data['ID_Dept']	=rdb('perkiraan','ID_Dept','ID_Dept',"where ID_Agt='$ID_Agt'");
		$data['ID_Klas']	=rdb("jenis_simpanan",'ID_Klasifikasi','ID_Klasifikasi',"where ID='$ID_Simpanan'");
		$data['ID_SubKlas']	=rdb("jenis_simpanan",'ID_Klasifikasi','ID_Klasifikasi',"where ID='$ID_Simpanan'");
		$data['ID_Perkiraan']=rdb('perkiraan','ID','ID',"where ID_Agt='$ID_Agt' and ID_Simpanan='$ID_Simpanan'");
		$data['Debet']		=($ID_Jenis==1)?$jumlah:0;
		$data['Kredit']		=($ID_Jenis==2)?$jumlah:0;
		$data['Keterangan']	=$_POST['keterangan'];
		$data['ID_Stat']	='0';
		$data['ID_Bulan']	=$_POST['ID_Bulan'];
		$data['Tahun']		=$_POST['Tahun'];
		$data['created_by']	=$this->session->userdata('userid');
		echo $this->Admin_model->replace_data('transaksi_temp',$data);
			
	}
	//populate daftar anggota yang belum melakukan pembayaran di bulan yang dipilih
	function get_agt_blmbayar(){
		$data=array();$n=0;
		$ID_Dept	=$_POST['ID_Dept'];
		$ID_Simpanan=$_POST['ID_Simpanan'];
		$ID_Bulan	=$_POST['ID_Bulan'];
		$Tahun		=$_POST['Tahun'];		
		$data=$this->member_model->agt_blmbayar($ID_Dept,$ID_Simpanan,$ID_Bulan,$Tahun);
			foreach($data as $r){
				$n++;
				$kode='';
				$kode.=rdb('Klasifikasi','Kode','Kode',"where ID='".
					   rdb('perkiraan','ID_Klas','ID_Klas',"where ID_Agt='".$r->ID."' and ID_Simpanan='$ID_Simpanan'")."' ");
				$kode.=rdb('Sub_Klasifikasi','Kode','Kode',"where ID='".
					   rdb('perkiraan','ID_SubKlas','ID_SubKlas',"where ID_Agt='".$r->ID."' and ID_Simpanan='$ID_Simpanan'")."'");
				$kode.=rdb('unit_jurnal','Kode','Kode',"where ID='".
					   rdb('perkiraan','ID_Unit','ID_Unit',"where ID_Agt='".$r->ID."' and ID_Simpanan='$ID_Simpanan'")."'");
				$kode.=rdb('mst_departemen','Kode','Kode',"where ID='".$r->ID_Dept."'");
				$kode.=$r->No_Perkiraan;
				$jumlah=rdb('setup_simpanan','min_simpanan','min_simpanan',"where id_simpanan='$ID_Simpanan'");
				empty($jumlah)?$jumlah='0':$jumlah=$jumlah;
				($ID_Simpanan=='3')?
				$simp_khusus=rdb('transaksi_temp','Kredit','Kredit',"where ID_Perkiraan='".
							 rdb('perkiraan','ID','ID',"where ID_Agt='".$r->ID."'
							     and ID_Simpanan='$ID_Simpanan'")."' and concat(ID_Bulan,Tahun)='".$ID_Bulan.$Tahun."'"):
				$simp_khusus='0';
				echo "<tr class='xx' align='center'>
					  <td class='kotak'>$n</td>
					  <td class='kotak'>".$kode."</td>
					  <td class='kotak' align='left'>".$r->Nama."</td>
					  <td class='kotak' align='right'>";
					  ($ID_Simpanan!='3')?$enabl='':$enabl="disabled='disabled'";
					  echo ($ID_Simpanan!='3')?number_format($jumlah,2):
					  		"<input type='text' id='t-".$r->ID."' class='angka' value='$simp_khusus' onkeyup=\"simkh('".$r->ID."');\" onmouseout=\"lostfocus('".$r->ID."');\">";
					  echo "</td>
					  <td class='kotak'><input type='checkbox' id='n-".$r->ID."' onClick=\"bayar('".$r->ID."','".$jumlah."','".$ID_Simpanan."');\" $enabl></td>
					  </tr>";
			}
	}
	//transaksi pinjaman uang dan barang
	//pinjaman barang dari toko masuk pada class penjualan toko
	function t_pinjaman(){
		$this->zetro_auth->menu_id(array('pinjaman','setoranpinjaman'));
		$this->list_data($this->zetro_auth->auth());
		$this->View('member/member_pinjaman');
	}
	function set_pinjaman(){
		$data=array();$datax=array();
		//simpan ke table pinjaman
			$data['ID_Agt']		=$_POST['ID_Agt'];
			$data['ID_Bulan']	=$_POST['ID_Bulan'];
			$data['Tahun']		=$_POST['Tahun'];
			$data['ID_Unit']	=$_POST['ID_Unit'];
			$data['ID_Dept']	=$_POST['ID_Dept'];
			$data['pinjaman	']	=$_POST['Pinjaman'];
			$data['cicilan']	=$_POST['cicilan'];
			$data['cicilan_end']=$_POST['cicilan_end'];
			$data['lama_cicilan']=$_POST['lama_cicilan'];
			$data['cara_bayar']	=$_POST['cara_bayar'];
			$data['mulai_bayar']=$_POST['mulai_bayar'];
			$data['keterangan']	=$_POST['keterangan'];
				$data['created_by']	=$this->session->userdata('userid');
				echo $this->Admin_model->replace_data('pinjaman',$data);
			//simpan kredit to table transaksi_temp / jurnal temporary
			$datax['ID_Unit']	=$_POST['ID_Unit'];
			$datax['ID_Dept']	=$_POST['ID_Dept'];
			$datax['ID_Klas']	=rdb('perkiraan','ID_Klas','ID_Klas',"where ID_Agt='".$_POST['ID_Agt']."' and ID_Simpanan='".$_POST['ID_Pinjaman']."'");
			$datax['ID_SubKlas']=rdb('perkiraan','ID_SubKlas','ID_SubKlas',"where ID_Agt='".$_POST['ID_Agt']."' and ID_Simpanan='".$_POST['ID_Pinjaman']."'");
			$datax['ID_Perkiraan']=rdb('perkiraan','ID','ID',"where ID_Agt='".$_POST['ID_Agt']."' and ID_Simpanan='".$_POST['ID_Pinjaman']."'");
			$datax['Debet']		=$_POST['Pinjaman'];
			$datax['keterangan']=$_POST['keterangan'];
			$datax['ID_Bulan']	=$_POST['ID_Bulan'];
			$datax['Tahun']		=$_POST['Tahun'];
				$datax['created_by']	=$this->session->userdata('userid');
				echo $this->Admin_model->replace_data('transaksi_temp',$datax);
	}
	function get_total_pinjaman(){
		$data=array();
		$ID_Agt	=$_POST['ID_Agt'];
		$data=$this->member_model->total_pinjaman($ID_Agt);
		echo json_encode($data);
	}
	function set_bayar_pinjaman(){
		$data=array();$jml_bayar=0;
			$debet=rdb("pinjaman_bayar","Debet","sum(Debet) as Debet","where ID_Pinjaman='".$_POST['ID_Pinj']."'");
			//$kredit=rdb("pinjaman_bayar","sum(Kredit) as Kredit","Kredit","where ID_Pinjaman='".$_POST['ID_Pinj']."'");
			$data['ID_Pinjaman']=$_POST['ID_Pinj'];
			$data['ID_Agt']		=$_POST['ID_Agt'];
			$data['ID_Bulan']	=$_POST['ID_Bulan'];
			$data['Tahun']		=$_POST['Tahun'];
			$data['Kredit']		=$_POST['Kredit'];
			$data['Keterangan']	=$_POST['Keterangan'];
			$data['angs_ke']	=$_POST['angs_ke'];
			$data['saldo']		=($debet-$_POST['Kredit']);
			$data['created_by']	=$this->session->userdata('userid');
				echo $this->Admin_model->replace_data('pinjaman_bayar',$data);
				//update status pinjaman
				$this->Admin_model->upd_data('pinjaman',"set stat_pinjaman='".$_POST['angs_ke']."'","where ID='".$_POST['ID_Pinj']."'");
			//simpan kredit to table transaksi_temp / jurnal temporary
			//collect jumlah bayar;
			$jml_bayar=rdb('pinjaman_bayar','kredit','sum(kredit) as kredit',"where concat(year(doc_date),month(doc_date))='".date('Ym')."' and ID_Pinjaman='".$_POST['ID_Pinj']."'");
			$datax['ID_Unit']	=$_POST['ID_Unit'];
			$datax['ID_Dept']	=$_POST['ID_Dept'];
			$datax['ID_Klas']	=rdb('perkiraan','ID_Klas','ID_Klas',"where ID_Agt='".$_POST['ID_Agt']."' and ID_Simpanan='".$_POST['ID_Pinjaman']."'");
			$datax['ID_SubKlas']=rdb('perkiraan','ID_SubKlas','ID_SubKlas',"where ID_Agt='".$_POST['ID_Agt']."' and ID_Simpanan='".$_POST['ID_Pinjaman']."'");
			$datax['ID_Perkiraan']=rdb('perkiraan','ID','ID',"where ID_Agt='".$_POST['ID_Agt']."' and ID_Simpanan='".$_POST['ID_Pinjaman']."'");
			$datax['Kredit']	=$_POST['Kredit'];
			$datax['keterangan']=$_POST['Keterangan'];
			$datax['ID_Bulan']	=$_POST['ID_Bulan']."-".$_POST['angs_ke'];
			$datax['Tahun']		=$_POST['Tahun'];
				$datax['created_by']	=$this->session->userdata('userid');
				echo $this->Admin_model->replace_data('transaksi_temp',$datax);
	}
	function data_pinjaman(){
		$data=array();$detail=array();$n=0;$x=0;$stat='';$saldo=0;
		$ID_Agt=$_POST['ID_Agt'];$kredit=0;
		$data=$this->member_model->data_pinjaman($ID_Agt);
		if(is_array($data)){
			foreach ($data as $r){
				$n++;
				echo "<tr class='list_genap' id='n-".$r->ID."'>
					<td class='kotak' colspan='2'><b>$n.&nbsp;&nbsp;".$r->keterangan." ".nBulan($r->ID_Bulan)."-".$r->Tahun."</b></td>
					<td class='kotak'  align='right'><b>".number_format($r->pinjaman,2)."</b></td>
					<td class='kotak' colspan='2'>";
					echo (($r->lama_cicilan-$r->stat_pinjaman)==0)?'Lunas':"<input type='hidden' id='ID_Pinj' value='".$r->ID."'>";
					echo "</td>
					</tr>";
				if(($r->lama_cicilan-$r->stat_pinjaman)!=0){
					$detail=$this->member_model->data_setoran($ID_Agt,$r->ID);
					foreach($detail as $d){
						$x++;
						$kredit=($kredit+$d->Kredit);	
						$saldo=($r->pinjaman-($kredit));
					echo "<tr class='xx'>
						<td class='kotak' width='5%' align='center'>$x</td>
						<td class='kotak' width='30%'>Angsuran Ke $x</td>
						<td class='kotak' width='15%' align='right'>".number_format($d->Kredit,2)."<input type='hidden' class='w70 angka' value='".$d->Kredit."'></td>
						<td class='kotak' width='15%' align='right'>".number_format($saldo,2)."</td>
						<td class='kotak' width='20%'>".$d->doc_date."</td>
						</tr>";
						($d->Kredit==0)?$stat=number_format($d->Kredit,2) : $stat='';
					}
					for($i=($x+1);$i<=($r->lama_cicilan);$i++){
						($i==$r->lama_cicilan)? $cil=$r->cicilan_end:$cil=$r->cicilan;
						//($stat=='')?$stat="<img src='".base_url()."asset/img/checkout.gif' id='g-".$i."' onclick=\"bayar($i);\"":$stat=$stat;
					echo "<tr class='xx' id='r-".$i."'>
						<td class='kotak' width='5%' align='center'>$i</td>
						<td class='kotak' width='30%'>Angsuran Ke ".($i)."</td>
						<td class='kotak' width='15%' align='right'>".number_format($cil,2)."</td>
						<td class='kotak' width='15%' align='right'>&nbsp;</td>
						<td class='kotak' width='20%' align='right'>";
						echo ($stat=='')?"<img src='".base_url()."asset/img/checkout.gif' id='g-".$i."' onclick=\"bayar($i);\"":$stat;
						echo "</td>
						</tr>";
					}
				}
	
			}
		}
	}
	//list transaksi simpanan pinjaman dan setoran pinjaman
	
	function list_transaksi(){
		$this->zetro_auth->menu_id(array('listransaksi'));
		$this->list_data($this->zetro_auth->auth());
		$this->View('member/member_transaksi');
	}
	
	function get_transaksi(){
		$data=array();
		$ID_Dept	=empty($_POST['ID_Dept'])?''	:$_POST['ID_Dept'];
		$ID_Aktif	=empty($_POST['ID_Aktif'])?''	:$_POST['ID_Aktif'];
		$data=$this->member_model->get_transaksi($ID_Dept,$ID_Aktif);
		$n=0;$t_debet=0;$t_kredit=0;
		foreach($data as $r){
			$n++;
			echo "<tr class='xx' align='center'>
				  <td class='kotak'>$n</td>
				  <td class='kotak'>".tglfromSql(substr($r->Tanggal,0,10))."</td>
				  <td class='kotak'>".$r->Kode."</td>
				  <td class='kotak' align='left' nowrap>".$r->Perkiraan."</td>
				  <td class='kotak' align='right'>".number_format($r->Debet,2)."</td>
				  <td class='kotak' align='right'>".number_format($r->Kredit,2)."</td>
				  <td class='kotak' align='left' nowrap>".$r->Keterangan."</td>
				  <td class='kotak'>";
				  echo ($r->ID_Stat=='0')?
				  "<img title='hapus transaksi' src='".base_url()."asset/images/no.png' onclick=\"hapus('".$r->ID."');\">":
				  "<img title='sudah terjurnal' src='".base_url()."asset/images/5.png'>";
			echo "</td>
				  </tr>";
				$t_debet	=($t_debet+$r->Debet);
				$t_kredit	=($t_kredit+$r->Kredit);  
		}
		echo "<tr class='list_genap'>
			 <td class='kotak' colspan='4' align='right'>TOTAL</td>
			 <td class='kotak' align='right'><b>".number_format($t_debet,2)."</td>
			 <td class='kotak' align='right'><b>".number_format($t_kredit,2)."</td>
			 <td class='kotak' align='right'></td>
			 <td class='kotak' align='right'></td>
			 </tr>";
	}
	function hapus_transaksi(){
		$ID	=$_POST['ID'];
		$this->Admin_model->hps_data('transaksi_temp',"where ID='$ID'");	
	}
}
?>