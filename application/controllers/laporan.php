<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Laporan extends CI_Controller{
	
	 function __construct()
	  {
		parent::__construct();
		$this->load->model("inv_model");
		$this->load->model("report_model");
		$this->load->helper("print_report");
		$this->load->model("akun_model");
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
	function faktur(){
		$this->zetro_auth->menu_id(array('faktur'));
		$this->list_data($this->zetro_auth->auth());
		$this->View('laporan/lap_faktur');
	}
	
	function rekap_simpanan(){
		$this->zetro_auth->menu_id(array('laporan__rekap_simpanan'));
		$data=$this->akun_model->get_simpanan_name();
		$this->list_data($this->zetro_auth->auth(array('simpanan'),array($data)));
		//print_r($this->zetro_auth->auth(array('simpanan'),array($data)));
		$this->View('laporan/rekap_simpanan');
	}
	
	function get_rekap_simpanan(){
	 $n		=0;
	 $dept	=array();
	 $ID_Dept=$_POST['dept'];
	 $dept	=$this->akun_model->get_departemen(" and ID_Dept='".$ID_Dept."'");
		foreach($dept->result() as $row){
			$n++;$hasil-array();
			echo "<tr class='xx' id='".$row->ID."'>
				 <td class='kotak' align='center'>$n</td>
				 <td class='kotak'>".$row->Departemen."</td>";
					$data=$this->akun_model->get_simpanan_name();
					$hasile=0;
					foreach($data->result() as $sim){
					$hasil=$this->akun_model->get_value_simpanan($row->ID,$sim->ID);
					 echo "<td class='kotak' align='right' id='".$sim->ID."'>".number_format($hasile,2)."</td>";
					$hasile =($hasile+(int)$hasile);
					}
					echo "<td class='kotak'>".number_format($hasile,2)."</td>
				 </tr>\n";
				 
		}
		//print_r($hasil->result());	
	}
	function get_data_simpanan(){
		$ID_Dept	=$this->akun_model->get_departemen();
		$data		=$this->akun_model->get_data_simpanan('17');
		$dataw		=$this->akun_model->get_data_simpanan('18');
		$datak		=$this->akun_model->get_data_simpanan('19');
		$i=0;
		$simp_khusus	=0;
		$simp_pokok		=0;
		$simp_wajib		=0;
		$total_dept		=0;
		$t_simp_khusus	=0;
		$t_simp_pokok	=0;
		$t_simp_wajib	=0;
		$grand_total	=0;
		foreach($data as $dept){
			$i++;
			$simp_pokok	=(($dept->KR+$dept->SA)-$dept->DB);
			$simp_wajib	=(($dataw[($i-1)]->KR+$dataw[($i-1)]->SA)-$dataw[($i-1)]->DB);
			$simp_khusus=(($datak[($i-1)]->KR+$datak[($i-1)]->SA)-$datak[($i-1)]->DB);
			$total_dept=($simp_pokok+$simp_wajib+$simp_khusus);
			
			echo "<tr class='xx' id='".$dept->ID_Dept."'>
				<td class='kotak' align='center'>".$i."</td>	
				<td class='kotak' align='left'>".rdb('mst_departemen','departemen','departemen',"where ID='".$dept->ID_Dept."'")."</td>	
				<td class='kotak' align='right'>".number_format($simp_pokok,2)."</td>	
				<td class='kotak' align='right'>".number_format($simp_wajib,2)."</td>	
				<td class='kotak' align='right'>".number_format($simp_khusus,2)."</td>	
				<td class='kotak' align='right'>".number_format($total_dept,2)."</td>	
				</tr>\n";
			$t_simp_pokok	=($t_simp_pokok+(($dept->KR+$dept->SA)-$dept->DB));
			$t_simp_wajib	=($t_simp_wajib+(($dataw[($i-1)]->KR+$dataw[($i-1)]->SA)-$dataw[($i-1)]->DB));
			$t_simp_khusus	=($t_simp_khusus+(($datak[($i-1)]->KR+$datak[($i-1)]->SA)-$datak[($i-1)]->DB));
			$grand_total	=($t_simp_pokok+$t_simp_wajib+$t_simp_khusus);
			
		}
		echo "<tr class='list_genap'>
			 <td colspan='2' class='kotak'>TOTAL</td>
				<td class='kotak' align='right'>".number_format($t_simp_pokok,2)."</td>	
				<td class='kotak' align='right'>".number_format($t_simp_wajib,2)."</td>	
				<td class='kotak' align='right'>".number_format($t_simp_khusus,2)."</td>	
				<td class='kotak' align='right'>".number_format($grand_total,2)."</td>
				</tr>";	
	}
	function print_lap_pdf(){
		$data['tanggal']=date('d F Y');
		$data['temp_rec']=$this->akun_model->get_data_simpanan('17');
		$data['tmp_sp']	=$this->akun_model->get_data_simpanan('18');
		$data['tmp_khs']=$this->akun_model->get_data_simpanan('19');
		$this->zetro_auth->menu_id(array('trans_beli'));
		$this->list_data($data);
		$this->View("laporan/rekap_simpanan_print");
	
	}
	function last_no_transaksi(){
		$data=$this->Admin_model->penomoran('GI');
		echo $data;	
	}
	function print_faktur(){
		$data=array();
		$no_trans=$this->input->post('no_transaksi');
		$data['nm_nasabah']	=$this->Admin_model->show_single_field("detail_transaksi",'nm_produsen',"where no_transaksi='$no_trans'");
		$data['alamat']		=$this->Admin_model->show_single_field("mst_pelanggan",'alm_pelanggan',"where nm_pelanggan='".$this->Admin_model->show_single_field("detail_transaksi",'nm_produsen',"where no_transaksi='$no_trans'")."'");
		$data['telp']		=$this->Admin_model->show_single_field("mst_pelanggan",'telp_pelanggan',"where nm_pelanggan='".$this->Admin_model->show_single_field("detail_transaksi",'nm_produsen',"where no_transaksi='$no_trans'")."'");
		$data['temp_rec']	=$this->report_model->laporan_faktur($no_trans);
		$data['terbilang']	=$this->Admin_model->show_single_field('bayar_transaksi',"terbilang","where no_transaksi='$no_trans'");
		$this->zetro_auth->menu_id(array('trans_beli'));
		$this->list_data($data);
		$this->View("laporan/lap_".$this->input->post('lap')."_print");
	}

}


?>
