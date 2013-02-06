<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Neraca extends CI_Controller{
	
	 function __construct()
	  {
		parent::__construct();
		$this->load->model("inv_model");
		$this->load->model("report_model");
		$this->load->helper("print_report");
		$this->load->model("akun_model");
		$this->load->model("neraca_model");
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
		$this->zetro_auth->menu_id(array('rekaplaporan'));
		$this->list_data($this->zetro_auth->auth());
		$this->View('laporan/lap_faktur');
	}
	
	function neraca_index(){
		$this->zetro_auth->menu_id(array('neraca'));
		$this->list_data($this->zetro_auth->auth());
		$this->View('laporan/neracane');
	}
	function neraca_lajur(){
		$this->zetro_auth->menu_id(array('neracalajur'));
		$this->list_data($this->zetro_auth->auth());
		$this->View('laporan/neraca_lajur_bener');
	}
	function rekap_simpanan(){
		$this->zetro_auth->menu_id(array('neraca__rekap_simpanan'));
		$this->list_data($this->zetro_auth->auth());
		$this->View('laporan/neraca_lajur');
	}
	function neraca_lajur_data(){
		//bukan neraca lajur tetapi laporan rekap simpanan anggota per departemen
		$data=array();$n=0;
		$periode=tglToSql($_POST['periode']);
		$this->neraca_model->neraca_unit();
		$data=$this->neraca_model->get_rekap_data($periode);
		//return $data;
		foreach($data as $row){
			$saldo=0;$n++;
			echo tr().td($n,'center').td($row->ID_Dept);
			for ($i=1;$i<=3;$i++){
				$field=str_replace('. ','_',rdb("jenis_simpanan",'Jenis','Jenis',"where ID='".$i."'"));
				echo td(number_format($row->$field,2),'right');
				$saldo=($saldo+$row->$field);
			}
			
			echo td(number_format($saldo,2),'right')._tr();	
		}
	}
	function get_data_nc_lajur(){
		//neraca lajur simpanan anggota per departemen
		$datax	=array();$n=0;$saldo=0;
		$periode=empty($_POST['tgl_start'])?'':tglToSql($_POST['tgl_start']);
	   $tgl_stop=empty($_POST['tgl_stop'])?$periode:tglToSql($_POST['tgl_stop']);
		$id_dept=$_POST['id_dept'];
		$ID_Stat=empty($_POST['stat_agt'])?'':$_POST['stat_agt'];
		$akun	=empty($_POST['akun'])?'':$_POST['akun'];
		$tahun	=empty($_POST['tahun'])?'':$_POST['tahun'];
		$filter	=$_POST['filterby'];
		$where =" and ID_Dept='".$id_dept."'";
		$where.=($akun=='')?'':" and ID_Simpanan='".$akun."'";
		$where.=($filter=='thn')?" and Tahun='".$tahun."'":" and (Tanggal between '".$periode."' and '".$tgl_stop."')"; 
		$prdd=($filter=='thn')? $tahun.'1231':$tgl_stop;
		$this->neraca_model->neraca_unit();
		$datax=$this->neraca_model->get_nc_lajure($prdd,$where);

		foreach($datax as $r){
			$n++;
			$saldoawal=rdb("perkiraan",'SaldoAwal','sum(SaldoAwal) as SaldoAwal',"where ID_Agt='".$r->ID_Agt."' and ID_Dept='".$r->ID_Dept."' and ID_Simpanan='".$r->ID_Simpanan."'");
			$kode=rdb('klasifikasi','Kode','Kode',"where ID='".$r->ID_Klas."'");
			$kode.=rdb('sub_klasifikasi','Kode','Kode',"where ID='".$r->ID_SubKlas."'");
			$kode.=rdb('unit_jurnal','Kode','Kode',"where ID='".$r->ID_Dept."'");
			$kode.=rdb('mst_departemen','Kode','Kode',"where ID='".$r->ID_Unit."'");
			$kode.=rdb('mst_anggota','No_Perkiraan','No_Perkiraan',"where ID='".$r->ID_Agt."'");
			$simp=rdb('jenis_simpanan','Jenis','Jenis',"where ID='".$r->ID_Simpanan."'");
			$saldo=($r->ID_Calc=='2')?($r->Kredit-$r->Debet):($r->Debet-$r->Kredit);
			echo tr().td($n,'center').
					  td($kode,'center').
					  td(rdb('mst_anggota','Nama','Nama',"where ID='".$r->ID_Agt."'")." - ".$simp,"left' nowrap").
					  td(number_format($saldoawal),'right').
					  td(number_format($r->Debet,2),'right').
					  td(number_format($r->Kredit,2),'right').
					  td(number_format($saldoawal+$saldo,2),'right');
			echo _tr();		  
					 	
		}/**/
	}
	
	function print_neraca_lajur(){
		$data=array();
		$tgl_start	=($this->input->post('tgl_start')=='')?''		:$this->input->post('tgl_start');
		$periode	=($this->input->post('tgl_stop')=='')?$tgl_start:$this->input->post('tgl_stop');
		$id_dept	=$this->input->post('ID_Dept');
		$ID_Stat	=($this->input->post('ID_Stat')=='')?''			:$this->input->post('ID_Stat');
		$akun		=($this->input->post('ID_Perkiraan')=='')?''	:$this->input->post('ID_Perkiraan');
		$tahun		=($this->input->post('tahun')=='')?''			:$this->input->post('tahun');
		$filter		=$this->input->post('filper');
		$where 		=" and ID_Dept='".$id_dept."'";
		$where		.=($akun=='')?'':" and ID_Simpanan='".$akun."'";
		$where		.=($filter=='thn')?" and Tahun='".$tahun."'":" and (Tanggal between '".tglToSql($tgl_start)."' and '".tglToSql($periode)."')"; 
		$prdd=($filter=='thn')? $tahun.'1231':tglToSql($periode);
		$data['dept']=rdb('mst_departemen','Departemen','Departemen',"where ID='".$id_dept."'");
		$data['tanggal']=($filter=='thn')?$tahun: $tgl_start.' s/d '.$periode;
		$this->neraca_model->neraca_unit();
		$data['temp_rec']=$this->neraca_model->get_nc_lajure($prdd,$where);
		$this->zetro_auth->menu_id(array('trans_beli'));
		$this->list_data($data);
		$this->View("laporan/neraca_lajur_print");
		
	}
	function print_lap_pdf(){
		$data['tanggal']=$this->input->post('tgl_start');
		$periode=tglToSql($this->input->post('tgl_start'));
		$this->neraca_model->neraca_unit();
		$data['temp_rec']=$this->neraca_model->get_rekap_data($periode);
		$this->zetro_auth->menu_id(array('trans_beli'));
		$this->list_data($data);
		$this->View("laporan/rekap_simpanan_print");
	
	}
	function print_neraca(){
		$data['unit']		=$this->input->post('unite');
		$data['periode']	=$this->input->post('tgl_start');
		$data['pembanding']	=$this->input->post('tgl_banding');
		$data['users']		=$this->session->userdata('userid');
		$unite				=$this->input->post('unite');
		($unite!=3)?$unite	=rdb("unit_jurnal",'Unit','Unit',"where ID='".$unite."'"):$unite='';
		$unte				=$this->input->post('unite');
		$periode			=tglToSql($this->input->post('tgl_start'));
		$data['awal']		=getPrevDays($periode,365);
		$awal				=getPrevDays($periode,365);
		$this->neraca_model->neraca_unit($unte);
		$this->neraca_model->build_data($periode);
		$this->neraca_model->tmp_balance();
		$this->neraca_model->generate_shu($awal,$periode,$unte);
		//$data['temp_rec']	=$this->neraca_model->neraca_kalkulasi($periode,$unite);
		$this->zetro_auth->menu_id(array('trans_beli'));
		$this->list_data($data);
		($this->input->post('tgl_banding')=='')?
		$this->View("laporan/neraca_print"):
		$this->View("laporan/neraca_print_banding");
	}
	function print_neraca_gabungan(){
		$data['periode']	=$this->input->post('tgl_start');
		$data['pembanding']	=$this->input->post('tgl_banding');
		$data['users']		=$this->session->userdata('userid');
		$unte				=$this->input->post('unite');
		$periode			=tglToSql($this->input->post('tgl_start'));
		$data['awal']		=getPrevDays($periode,365);
		$awal				=getPrevDays($periode,365);
		$this->neraca_model->neraca_unit();
		$this->neraca_model->build_data($periode);
		$this->neraca_model->tmp_balance();
		$this->neraca_model->generate_shu($awal,$periode,$unte);
		$this->neraca_model->periode($periode);
		$this->neraca_model->generate_data('1');
		$this->neraca_model->generate_data('2');
		//$data['temp_rec']	=$this->neraca_model->neraca_kalkulasi($periode,$unite);
		$this->zetro_auth->menu_id(array('trans_beli'));
		$this->list_data($data);
		$this->View("laporan/neraca_print_gabung");
	}
	function shu(){
		$this->zetro_auth->menu_id(array('sisahasilusaha'));
		$this->list_data($this->zetro_auth->auth());
		$this->View('laporan/shu');
	}
	
	function print_shu(){
		$data['unit']		=$this->input->post('unite');
		$data['periode']	=$this->input->post('tgl_start');
		$data['akhir']		=$this->input->post('tgl_stop');
		$data['users']		=$this->session->userdata('userid');
		$periode			=tglToSql($this->input->post('tgl_stop'));
		$this->neraca_model->neraca_unit();
		$this->neraca_model->build_data($periode);
		$this->zetro_auth->menu_id(array('trans_beli'));
		$this->list_data($data);
		($this->input->post('unite')==3)?
		$this->View("laporan/shu_print_gabungan"):
		$this->View("laporan/shu_print");
		
	}
	function graph_shu(){
		//$this->neraca_model->data_grap_shu();
		$this->zetro_auth->menu_id(array('grafikshu'));
		$this->list_data($this->zetro_auth->auth());
		$this->View('laporan/shu_graph');
	}
	function graph_shu_data(){
		$thn=(date('Y')-6);
		$this->neraca_model->neraca_unit();
		$this->neraca_model->data_grap_shu($thn);
	}
	
//generate data for grafik
	function data_XML(){
		$n=0;$x=0;
		$user=$this->session->userdata('userid');
		$xml=fopen(base_url()."application/log/".$user.'_graph.xml','wb');
		fwrite($xml,"<graph caption='".$this->judul."' xAxisName='".$this->xAxis."' yAxisName='".$this->yAxis."' numberPrefix='' showvalues='1'  numDivLines='4' formatNumberScale='0' decimalPrecision='0' anchorSides='10' anchorRadius='3' anchorBorderColor='00990'>\r\n");
		foreach($this->datasec as $sec=>$par_tip){
			fwrite($xml,"<set name='".$sec.'\' value=\''.$par_tip."'/>\r\n");
			$n++;
		}
		fwrite($xml,"</graph>\r\n");
	}
	
	
	function _judul_grafik($judul=''){
		$this->judul=$judul;
	}
	function _judul_axis($xAxis='',$yAxis=''){
		$this->xAxis=$xAxis;
		$this->yAxis=$yAxis;
	}
	function _data_cat($datacat){
		if(is_array($datacat)){
			 $this->datacat=$datacat;
		}else{
			return false;
		}
	}
	function _data_sec($datasec){
		if(is_array($datasec)){
			$this->datasec=$datasec;
		}else{
			return false;
		}			
	}
	function rekap_simpanan_dept(){
		$this->zetro_auth->menu_id(array('rekappiutangbarang'));
		$this->list_data($this->zetro_auth->auth());
		$this->View('laporan/rekap_simpanan_dept');
	}
	
	function get_rkp_simpan_dept(){
		$data=array();$n=0;
		$bulan=$this->input->post('bln');
		$tahun=$this->input->post('thn');
		$jumHari = cal_days_in_month(CAL_GREGORIAN,$bulan,$tahun);
		$bulan=(strlen($bulan)==1)?'0'.$bulan:$bulan;
		$periode=$tahun.'-'.$bulan.'-'.$jumHari;
		$where2="where year(p.Tanggal) <'".$tahun."'";
		//$where="where month(p.Tanggal)='".$bulan."'";
		$where ="where year(p.Tanggal)='".$tahun."'";
		$where.=($this->input->post('ID_Dept')=='')?"and p.ID_Dept<>'0'":" and p.ID_Dept='".$this->input->post('ID_Dept')."'";
		$where.=($this->input->post('ID_Simpanan')=='')?"and p.ID_Simpanan<>'0'":" and p.ID_Simpanan='".$this->input->post('ID_Simpanan')."'";
		$where2.=($this->input->post('ID_Dept')=='')?"and p.ID_Dept<>'0'":" and p.ID_Dept='".$this->input->post('ID_Dept')."'";
		$where2.=($this->input->post('ID_Simpanan')=='')?"and p.ID_Simpanan<>'0'":" and p.ID_Simpanan='".$this->input->post('ID_Simpanan')."'";
		$groupby="group by month(p.Tanggal),p.ID_Simpanan";
		$groupby2="group by p.ID_Simpanan";
		//kirim dalam bentuk pdf
		$this->neraca_model->neraca_unit();
		$data['temp_rec']	=$this->neraca_model->get_rekap_dept($periode,$where,$groupby);
		$data['saldoawal']	=$this->neraca_model->get_saldo_awal($where2,$groupby2);
		$data['bulan']		=rdb('mst_bulan','Bulan','Bulan',"where ID='".(int)$bulan."'");
		$data['tahun']		=$tahun;
		$data['Dept']		=rdb('mst_departemen','Departemen','Departemen',"where ID='".$this->input->post('ID_Dept')."'");
		$data['simp']		=rdb('jenis_simpanan','Jenis','Jenis',"where ID='".$this->input->post('ID_Simpanan')."'");
		$this->zetro_auth->menu_id(array('trans_beli'));
		$this->list_data($data);
		$this->View("laporan/rekap_simpanan_dept_print");
		//$this->output->enable_profiler();
	}
	function rekap_departemen(){
		
	}
}