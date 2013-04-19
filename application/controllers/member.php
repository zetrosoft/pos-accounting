<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//class member

class Member extends CI_Controller{
	
	function __construct(){
		parent::__construct();
		$this->load->model("Admin_model");
		$this->load->model("member_model");
		$this->load->model('inv_model');	
		$this->load->library("zetro_auth");
		$this->load->helper("print_report");
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
	function index(){
		$this->zetro_auth->menu_id(array('anggotabaru','auploadphoto'));
		$this->list_data($this->zetro_auth->auth());
		$this->View('member/member_view');
	}
	function member_list(){
		empty($_POST['id_dept'])?$where='':$where="where ID_Dept='".$_POST['id_dept']."'";
		empty($_POST['ordby'])? $ordby='order by noUrut':$ordby='order by '.$_POST['ordby'];
		$datax=$this->Admin_model->show_list('mst_anggota',$where.' '.$ordby);
		$this->zetro_auth->menu_id(array('member__member_list'));//array('list'),array($datax))
		$this->list_data($this->zetro_auth->auth());
		$this->View('member/member_list');
	}
	function filter_by(){
		$datax=array();$n=0;
		(empty($_POST['id_dept'])||$_POST['id_dept']=='all')?$where="where id_jenis='1'":$where="where ID_Jenis='1' and ID_Dept='".$_POST['id_dept']."'";
		(empty($_POST['ordby']) || $_POST['ordby']=='undefined')? $ordby='order by Nama':$ordby='order by '.str_replace('-',',',$_POST['ordby']);
		(empty($_POST['stat'])||$_POST['stat']=='all')? $where .='':
					 $where .=" and id_Aktif='".$_POST['stat']."'";
		 empty($_POST['searchby'])? $where .='':$where .=" and Nama like '%".$_POST['searchby']."%'";
		 echo $where.$ordby;
		$datax=$this->Admin_model->show_list('mst_anggota',$where.' '.$ordby);
		//print_r($datax);
		if(count($datax)>0){
			foreach($datax as $row){
			$n++;//title='Double click for detail view' ondblclick=\"show_member_detail('".$row->ID."');\
			echo "<tr onclick='' class='xx' ondblclick=\"images_click('".$row->ID."','edit');\">
				 <td width='5%' class='kotak' align='center'>$n</td>
				 <td width='10%' class='kotak' align='center'>".$row->No_Agt."</td>
				 <td width='15%' class='kotak' nowrap>".rdb('mst_departemen','Departemen','',"where ID='".$row->ID_Dept."'")."</td>
				 <td width='10%' class='kotak'>".$row->NIP."</td>
				 <td width='40%' class='kotak'>".$row->Nama."</td>
				 <td width='10%' class='kotak' >".substr($this->zetro_manager->rContent("Sex",$row->ID_Kelamin,"asset/bin/zetro_member.frm"),2,10)."</td>
				 <td width='8%' class='kotak'>".rdb('Keaktifan','Keaktifan','Keaktifan',"where ID='".$row->ID_Aktif."'")."</td>
				 <td width='8%' class='kotak' align='center'>".img_aksi($row->ID)."</td>
				</tr>";
			}
		}else{
			echo "<tr><td colspan='7' class='kotak'>
			<img src='".base_url()."asset/images/16/warning_16.png'> &nbsp;No Database found in &quot;departement or keaktifan&quot; selected, please try again </td></tr>";
		}
			//echo $data['list']=count($datax);
	}
	function set_anggota(){
		//table mst_anggota
		$data=array();
		$data['ID']			=empty($_POST['idne'])?'':$_POST['idne'];
		$data['No_Agt']		=$_POST['No_Agt'];
		$data['NoUrut']		=$_POST['No_Agt'];
		$data['ID_Dept']	=$_POST['ID_Dept'];
		$data['NIP']		=$_POST['NIP'];
		$data['Nama']		=addslashes($_POST['Nama']);
		$data['ID_Kelamin']	=$_POST['ID_Kelamin'];
		$data['Alamat']		=$_POST['Alamat'];
		$data['Kota']		=addslashes(ucwords($_POST['Kota']));
		$data['Propinsi']	=addslashes(ucwords($_POST['Propinsi']));
		$data['Telepon']	=$_POST['Telepon'];
		$data['Faksimili']	=$_POST['Faksimili'];
		$data['ID_Aktif']	=empty($_POST['ID_Aktif'])?'1':$_POST['ID_Aktif'];
		$data['ID_Jenis']	='1';
		$data['PhotoLink']	=empty($_POST['Photolink'])?'':$_POST['Photolink'];
		$data['TanggalMasuk']=empty($_POST['TanggalMasuk'])?'0000-00-00':tgltoSql($_POST['TanggalMasuk']);
		$data['TanggalKeluar']=empty($_POST['TanggalKeluar'])?'0000-00-00':tgltoSql($_POST['TanggalKeluar']);
		echo ($this->Admin_model->replace_data('mst_anggota',$data))?"Data berhasil di update":"Ada kesalahan data please check";
	}
	function get_nomor_anggota(){
		echo $this->member_model->nomor_anggota();	
	}
	function get_anggota(){
		$arr=array();
		$str	=$_GET['str'];
		$limit	=$_GET['limit'];
		$ID_Dept=empty($_GET['dept'])?'':$_GET['dept'];
		$datax=$this->member_model->get_anggota($str,$limit,$ID_Dept);
		echo json_encode($datax);	
	}
	function get_kota(){
		$arr=array();
		$str=$_GET['str'];
		$datax=$this->member_model->get_kota($str);
		echo json_encode($datax);	
	}
	function get_propinsi(){
		$arr=array();
		$str=$_GET['str'];
		$datax=$this->member_model->get_propinsi($str);
		echo json_encode($datax);	
	}
	
	function do_upload()
	{	//upload foto anggota to uploads/member
		$datax=array();
		($this->input->post('NIP')!='')?$nip="(".$this->input->post('NIP').")":$nip="";
		$config['allowed_types'] = 'pdf|gif|jpg|png';
		$config['upload_path'] ='./uploads/member';
		$config['file_name']=str_replace(".",'_',$this->input->post('Nama')).$nip;
		$config['max_size']	= '0';
		$config['max_width']  = '0';
		$config['max_height']  = '0';
		$config['overwrite']=true;
		
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if ( ! $this->upload->do_upload('PhotoLink'))
		{
			$this->zetro_auth->menu_id(array('anggotabaru','auploadphoto'));
			$data=$this->zetro_auth->auth(array('upload_data','panel','d_photo','error','nama','nip'),
					array($this->upload->data(),'uploadphoto','block',$this->upload->display_errors(),$this->input->post('Nama'),$this->input->post('NIP')));
			$this->Header();
			$this->load->view('member/member_view', $data);
			$this->Footer();
		}
		else
		{
			$this->zetro_auth->menu_id(array('anggotabaru','auploadphoto'));
			$data=$this->zetro_auth->auth(array('upload_data','panel','d_photo','error','nama','nip','nourut'),
					array($this->upload->data(),'uploadphoto','block',$this->upload->display_errors(),$this->input->post('Nama'),$this->input->post('NIP'),$this->input->post('no_agt')));
			$this->Header();
			$this->load->view('member/member_view', $data);
			$this->Footer();
		}
	}
	function simpan_photo(){
		$no_anggota=$_POST['nourut'];
		$photo_anggota=$_POST['gambar'];
		$this->Admin_model->upd_data('mst_anggota',"set PhotoLink='".$photo_anggota."'","where NoUrut='$no_anggota'");
		echo "Tersimpan";
	}
	
	function field_orderby(){
		$data=$this->member_model->show_field('mst_anggota');
		echo json_encode($data);
	}
	function get_nama_simpanan(){
		$data=$this->member_model->jenis_simpanan($_POST['id']);
		echo $data;	
	}
	function member_detail(){
	$data=array();
	$no_anggota				=$_POST['no_anggota'];
	$data['kunci']			=$no_anggota;
	$data['no_anggota']		=$this->Admin_model->show_single_field('mst_anggota','No_Agt',"where ID='".$no_anggota."'");
	$data['nm_anggota']		=$this->Admin_model->show_single_field('mst_anggota','Nama',"where ID='".$no_anggota."'");
	$data['id_department']	=rdb('mst_departemen','Departemen','Departemen',"where ID='".
							$this->Admin_model->show_single_field('mst_anggota','ID_Dept',"where ID='".$no_anggota."'")."'");
	$data['transaksi']=$this->member_model->summary_member_data($no_anggota);
	$this->load->view('member/member_detail',$data);
	}
	function member_detail_trans(){
		$n=0;$total_debet=0;$total_kredit=0;$saldoAwal=0;
		$ID_Agt		=$_POST['ID_Agt'];
		$ID_Jenis	=$_POST['ID_Jenis'];
		$saldoAwal	=rdb('perkiraan','SaldoAwal','SaldoAwal',"Where ID_Agt='".$ID_Agt."' and ID_Simpanan='".$ID_Jenis."'");
		$data=$this->member_model->detail_member_data($ID_Agt,$ID_Jenis);
		echo  "<tr class='xx list_genap'>
			  <td class='kotak'>&nbsp;</td>
			  <td class='kotak' colspan='4'>Saldo Awal</td>
			  <td class='kotak' align='right'>".number_format($saldoAwal,2)."</td></tr>";
		foreach($data->result() as $trn){
			$n++;
			echo "<tr class='xx' align='center'>
				  <td class='kotak'>$n</td>
				  <td class='kotak'>".tglfromSql($trn->Tanggal)."</td>
				  <td class='kotak'>".$trn->Nomor."</td>
				  <td class='kotak' align='left'>".$trn->Keterangan."</td>
				  <td class='kotak' align='right'>".number_format($trn->Debet,2)."</td>
				  <td class='kotak' align='right'>".number_format($trn->Kredit,2)."</td>
				  </tr>";
				  $total_debet +=$trn->Debet;
				  $total_kredit +=$trn->Kredit;
		};
		echo "<tr class='xx'>
			  <td class='kotak list_genap' colspan='4' align='right'>TOTAL &nbsp;&nbsp;</td>
			  <td class='kotak list_genap' align='right'><b>".number_format($total_debet,2)."</b></td>
			  <td class='kotak list_genap' align='right'><b>".number_format(($total_kredit+$saldoAwal),2)."</b></td>
			  </tr>";
	}
	function member_biodata(){
		$datax=array();
		$no_anggota	=$_POST['no_anggota'];
		$data=$this->member_model->biodata_member($no_anggota);
		foreach($data->result() as $rr){
			$datax=$rr;
		}
		echo json_encode($datax);
	}
	function member_print(){
		$data=array();
		$n=0;$total_debet=0;$total_kredit=0;
		$ID_Agt		=$_POST['ID_Agt'];
		$ID_Jenis	=$_POST['ID_Jenis'];
		$data['nama']	=$_POST['nm_angg'];
		$data['dept']	=$_POST['nm_dept'];
		$data['jsimp']	=rdb('jenis_simpanan','jenis','jenis',"where ID='".$ID_Jenis."'");
		$data['ID_Calc']=rdb('jenis_simpanan','ID_Calc','ID_Calc',"where ID='".$ID_Jenis."'");
		$data['temp_rec']=$this->member_model->detail_member_data($ID_Agt,$ID_Jenis);
		$this->zetro_auth->menu_id(array('trans_beli'));
		$this->list_data($data);
		$this->View("member/member_print");
	}
	//simpanan anggota
	
	function member_saving(){
		$this->zetro_auth->menu_id(array('simpananpokok','simpananwajib','simpanankhusus'));
		$this->list_data($this->zetro_auth->auth());
		$this->View('member/member_simpanan');
	}
	//API untuk data di web site
	function api_anggota(){
		//ambil data anggota
		$data=array();
		$nomor_anggota=$_POST['nama'];
		$data=$this->member_model->get_api_member($nomor_anggota);
		$dumy[0]=array('Nama'=>'nothing');
		echo empty($data)?json_encode($dumy[0]):json_encode($data[0]);	
	}
	
	function update_hp_anggota(){
		$id=$_POST['id_agt'];
		$hp=$_POST['no_hp'];
		$this->Admin_model->upd_data('mst_anggota',"set Telepon='".$hp."'","where ID='".$id."'");
		echo $this->Admin_model->show_single_field('mst_anggota','ID_Dept',"where ID='".$id."'");
	}
	function api_data_simpanan(){
		$data=array();$total=0;
		$id=$_POST['id_agt'];
		$where=" and js.ID not in('4','5')";
		$data=$this->member_model->summary_member_data($id,$where);
		echo "<ul>";
		foreach($data->result() as $r){
		echo ($r->ID=='1')?
		"<li class='li-class'>".tabel().tr().td($r->Jenis.str_repeat(' ',15),'left\' width=\'30%').td(':','center\' width=\'5%').td(number_format($r->SaldoAwal,2),'right\' width=\'40%').td('','right\' width=\'24%')._tr()._tabel()."</li>":	
		"<li class='li-class'>".tabel().tr().td($r->Jenis.str_repeat(' ',15),'left\' width=\'30%').td(':','center\' width=\'5%').td(number_format($r->SaldoAkhir,2),'right\' width=\'40%').td('','right\' width=\'24%')._tr()._tabel()."</li>";	
		$total=($r->SaldoAwal+$r->SaldoAkhir);
		}
		echo"<hr>
		<li class='li-class'>".tabel().tr().td('<b>Total</b>','left\' width=\'30%').td(':','center\' width=\'5%').td(number_format($total,2),'right\' width=\'40%').td('','right\' width=\'24%')._tr()._tabel()."</li>";	
		echo "</ul>";
	}
}
?>