<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Class name: User Control
version : 1.0
Author : Iswan Putera
*/

class Controlpanel extends CI_Controller {
	public $userid;
	function __construct(){
		parent::__construct();
		$this->load->model("Admin_model");
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
	function userlist(){
		$this->zetro_auth->menu_id(array('adduser','listuser','authorisation'));
		$this->list_data($this->zetro_auth->auth());
		$this->View('controlpanel/userlist');

	}
	function change_password(){
		$this->zetro_auth->menu_id(array('adduser','listuser','authorisation'));
		$this->list_data($this->zetro_auth->auth());
		$this->View('controlpanel/change_password');
	}
	function get_data_menu(){
		$nmgrp=empty($_POST['nm_group'])?$this->session->userdata('idlevel'):$_POST['nm_group'];
		$section=$_POST['section'];
		$this->set_config_file('asset/bin/zetro_menu.dll');
		$jml_sec=$this->zetro_manager->Count($section,$this->filename);	
		for ($i=1;$i<=$jml_sec;$i++){
			$mnu=explode('|',$this->zetro_manager->rContent($section,"$i",$this->filename));
			$jml_sub=$this->zetro_manager->Count($mnu[0],$this->filename);
			($jml_sub>0)?$warna="bgcolor='#89E0EA'":$warna='';
		if($mnu[1]!="x"){
		 	echo "<tr id='".$mnu[0]."' align='center' class='xx'>
		  		<td class='kotak' align='left' $warna;><img src='".base_url()."asset/images/bullet2.png'>&nbsp;".$mnu[0]."</td>\n";
			echo ($jml_sub==0)? 
			   "<td class='kotak'><input type='checkbox' id='c-".str_replace('/','__',$mnu[1])."' value='c-".$mnu[1]."' onclick=\"mnu_onClick('c','".str_replace('/','__',$mnu[1])."');\"".$this->control_model->cek_oto_x('c',$mnu[1],$nmgrp)." ".$this->zetro_auth->lock('c','authorisation')." ".$this->un_required($mnu[3],'c')."></td>\n
				<td class='kotak'><input type='checkbox' id='e-".str_replace('/','__',$mnu[1])."' value='e-".$mnu[1]."' onclick=\"mnu_onClick('e','".str_replace('/','__',$mnu[1])."');\"".$this->control_model->cek_oto_x('e',$mnu[1],$nmgrp)." ".$this->zetro_auth->lock('c','authorisation')." ".$this->un_required($mnu[3],'e')."></td>\n
				<td class='kotak'><input type='checkbox' id='v-".str_replace('/','__',$mnu[1])."' value='v-".$mnu[1]."' onclick=\"mnu_onClick('v','".str_replace('/','__',$mnu[1])."');\"".$this->control_model->cek_oto_x('v',$mnu[1],$nmgrp)." ".$this->zetro_auth->lock('c','authorisation')." ".$this->un_required($mnu[3],'v')."></td>\n
				<td class='kotak'><input type='checkbox' id='p-".str_replace('/','__',$mnu[1])."' value='p-".$mnu[1]."' onclick=\"mnu_onClick('p','".str_replace('/','__',$mnu[1])."');\"".$this->control_model->cek_oto_x('p',$mnu[1],$nmgrp)." ".$this->zetro_auth->lock('c','authorisation')." ".$this->un_required($mnu[3],'p')."></td>\n":
				"<td class='kotak' colspan='4' $warna;>&nbsp;</td>\n";
			echo "</tr>\n";
		}
			if($jml_sub>0){
				for ($z=1;$z<=$jml_sub;$z++){
					$sub_mnu=explode('|',$this->zetro_manager->rContent($mnu[0],"$z",$this->filename));
					echo "<tr id='".$mnu[0]."' class='".$sub_mnu[0]." xx' align='center'>
						  <td class='kotak' align='left'>".str_repeat('&nbsp;',5).
						  "<img src='".base_url()."asset/images/16/clipboard_16.png'>&nbsp;".$sub_mnu[0]."</td>\n
						  <td class='kotak'><input type='checkbox' id='c-".str_replace('/','__',$sub_mnu[1])."' value='c-".$mnu[1]."' onclick=\"mnu_onClick('c','".str_replace('/','__',$sub_mnu[1])."');\"".$this->control_model->cek_oto_x('c',$sub_mnu[1],$nmgrp)." ".$this->zetro_auth->lock('c','authorisation')." ".$this->un_required($sub_mnu[3],'c')."></td>\n
						  <td class='kotak'><input type='checkbox' id='e-".str_replace('/','__',$sub_mnu[1])."' value='e-".$mnu[1]."' onclick=\"mnu_onClick('e','".str_replace('/','__',$sub_mnu[1])."');\"".$this->control_model->cek_oto_x('e',$sub_mnu[1],$nmgrp)." ".$this->zetro_auth->lock('c','authorisation')." ".$this->un_required($sub_mnu[3],'e')."></td>\n
						  <td class='kotak'><input type='checkbox' id='v-".str_replace('/','__',$sub_mnu[1])."' value='v-".$mnu[1]."' onclick=\"mnu_onClick('v','".str_replace('/','__',$sub_mnu[1])."');\"".$this->control_model->cek_oto_x('v',$sub_mnu[1],$nmgrp)." ".$this->zetro_auth->lock('c','authorisation')." ".$this->un_required($sub_mnu[3],'v')."></td>\n
						  <td class='kotak'><input type='checkbox' id='p-".str_replace('/','__',$sub_mnu[1])."' value='p-".$mnu[1]."' onclick=\"mnu_onClick('p','".str_replace('/','__',$sub_mnu[1])."');\"".$this->control_model->cek_oto_x('p',$sub_mnu[1],$nmgrp)." ".$this->zetro_auth->lock('c','authorisation')." ".$this->un_required($sub_mnu[3],'p')."></td>\n
						  </tr>\n";
					}
			}
		}
	}
	
	function set_config_file($filename){
		$this->filename=$filename;
	}
	
	function cek_oto($field,$menu,$userid=''){
		($userid=='')?
		$this->control_model->userid=$this->userid:
		$this->control_model->userid=$userid;
		$datax=$this->control_model->cek_oto($field,str_replace('/','__',$menu));
		return $datax;
	}
	function lock($field,$menu,$visibiliti){
		if($this->userid!='1'){
		return($this->cek_oto($field,$menu,$this->userid)=='')? " disabled='disabled'":'';	
		}
	}
	
	function un_required($idmenu,$field){
		$datax=false;
		$datax=strpos($idmenu,$field);
		return($datax==true)?'':" disabled='disabled'";
	}	
		
	function get_userid(){
		$str=addslashes($_POST['str']);
		$induk=$_POST['induk'];
		$fld='userid';
		$this->control_model->tabel('users');
		$this->control_model->field($fld);
		$datax=$this->control_model->auto_sugest($str);
		if($datax->num_rows>0){
			echo "<ul>";
				foreach ($datax->result() as $lst){
					echo '<li onclick="suggest_click(\''.$lst->$fld.'\',\'userid\',\''.$induk.'\');">'.$lst->$fld."</li>";
				}
			echo "</ul>";
		}		
	}
	
	function simpan_newuser(){
		$data=array();
		$data['userid']=$_POST['userid'];
		$data['username']=$_POST['username'];	
		$data['idlevel']=$_POST['idlevel'];	
		$data['password']=md5($_POST['password']);	
		$data['active']='Y';
		$this->Admin_model->replace_data('users',$data); //insert data mode replace if exists
		//add new user to list 
		$this->get_userlist();
	}
	function get_userlist(){
		$this->zetro_buildlist->config_file('asset/bin/zetro_user.frm');
		$btn=($this->cek_oto('e','listuser')=='')? false:true;
			$sql2="select * from users where userid !='superuser' order by userid";
			$this->zetro_buildlist->deskripsi('user_level','nmlevel','idlevel');
			$this->zetro_buildlist->section('userlist');
			$this->zetro_buildlist->aksi($btn);
			$this->zetro_buildlist->icon();
			$this->zetro_buildlist->query($sql2);
			$this->zetro_buildlist->list_data('userlist');
			$this->zetro_buildlist->BuildListData('userid');
	}
	function hapus_user(){
		$userid=$_POST['userid'];
		$this->control_model->hapus_table('users','userid',$userid);	
	}
	
	function simpan_newlevel(){
		$data=array();
		$data['nmlevel']=$_POST['nmlevel'];	
		$this->Admin_model->replace_data('user_level',$data);
		$pilih=$this->Admin_model->show_single_field('user_level','idlevel',"order by idlevel");
		dropdown('user_level','idlevel','nmlevel',"where idlevel!='1' order by nmlevel",$pilih);
	}
	
	function get_datauser(){
		$data=array();
		$userid=$_POST['userid'];
		$data['username']=$this->Admin_model->show_single_field('users','username',"where userid='$userid'");
		$data['idlevel'] =$this->Admin_model->show_single_field('users','idlevel',"where userid='$userid'");
		echo json_encode($data);
	}
	function set_userupdate(){
		$data=array();
		$data['username']=$_POST["username"];
		$data['idlevel']=$_POST["idlevel"];
			$this->Admin_model->update_table('users','userid',$_POST["userid"],$data);
			$this->get_userlist();
	}
	//change password
	function cek_password(){
		$old_pwd=$_POST['old_pwd'];
		$data=$this->Admin_model->cek_pwd();
		echo (md5($old_pwd)==$data)?'OK':'NO';
	}
	function update_password(){
		$data=array();$datax='0';
		$data['password']=md5($_POST["new_pwd"]);
		$datax=$this->Admin_model->update_table('users','userid',$this->session->userdata('userid'),$data);
		echo $datax;	
	}
	//authorisation update
	function useroto_update(){
		$data	=array();
		$field	=$_POST['idfld'];
		$stat	=$_POST['stat'];
		$idmenu	=$_POST['idmenu'];
		$uid	=$_POST['userid'];
		$data['userid']	=$_POST['userid'];
		$data['idmenu']	=$_POST['idmenu'];
		$data[$field]	=$stat;
		//cek data apakah sudah terdapat di db user oto
		//jika belum create new dan jika sudah update field
		/*$this->Admin_model->replace_data('useroto',$data);*/
		$cekk=$this->Admin_model->field_exists('useroto',"where idmenu='$idmenu' and userid='$uid'","idmenu");
		($cekk!='')?
		$this->Admin_model->upd_data('useroto',"set $field='$stat'","where idmenu='$idmenu' and userid='$uid'"):
		$this->Admin_model->simpan_data('useroto',$data); 
		//echo $cekk."//".$_POST['idmenu'];	
		//print_r($data);
	}
	
}
?>
