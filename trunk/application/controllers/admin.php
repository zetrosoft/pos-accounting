<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin extends CI_Controller {
  public $tc;
  public $zn;
  public $zc;
  public $zm;
    function  __construct() {
        parent::__construct();
        $this->load->model('Admin_model');
		$this->zc='asset/bin/zetro_config.dll';
		$this->zm='asset/bin/zetro_menu.dll';
	}
    function index() {
		if($this->session->userdata('login')!=TRUE){
			$this->cek_db_user();
		}else{
		$data['login']=$this->session->userdata('login');
				$this->load->view('admin/header');
				$this->load->view('admin/home',$data);
				$this->load->view('admin/footer');
		}
	}
	function about(){
		$data['serial']=(no_ser()==addCopy())? 
		  substr(chunk_split(strtoupper(md5(hash('sha1',no_ser()))),4,'-'),0,-1):"Demo Version";
			$this->load->view('admin/header');
			$this->load->view('admin/about',$data);
			$this->load->view('admin/footer');
	}
	function todo(){
		$data=array();
		$c=fopen('application/third_party/todo.dll','r');
		$data['content']=fread($c,10240);
		fclose($c);
			$this->load->view('admin/header');
			$this->load->view('admin/todolist',$data);
			$this->load->view('admin/footer');
	}
	//
	function simpan_todo(){
		$isi=$_POST['todo'];
		$c=fopen("application/third_party/todo.dll",'wb');
		fwrite($c,base64_encode($isi)."\n\r");
		fclose($c);	
	}
	//fungsi proses login
	function process_login() {

        $this->form_validation->set_rules('username', 'username', 'required|xss_clean');
        $this->form_validation->set_rules('password', 'password', 'required|xss_clean');
        $this->form_validation->set_error_delimiters('', '<br/>');
		//if (no_ser()==addCopy()){
			if ($this->form_validation->run() == TRUE) 
			{
				$username = $this->input->post('username');
				$password = $this->input->post('password');
				$login_data = $this->Admin_model->cek_user_login($username, $password);
				if ($login_data->num_rows()==1){
					foreach($login_data->result_array() as $lgn){
						$session_data = array(
							'userid' => $lgn['userid'],
							'username' => $lgn['username'],
							'idlevel' => $lgn['idlevel'],
							'login' => TRUE
						);
					}
					$this->session->set_userdata($session_data);
					//redirect('admin/index');
					$this->index();
				}else{
					$data['error']="Username or password incorrect please try again";
					$this->load->view('admin/header');
					$this->load->view('admin/login',$data);
					$this->load->view('admin/footer');
				}
			}else{
				$this->logout();
			}
/*        }else{
					$data['error']="It's ilegal copy, please contact via email to : contact@smarthome-kanz.com and put this code in your email \nKode : ".no_ser();
					$this->load->view('admin/header');
					$this->load->view('admin/login',$data);
					$this->load->view('admin/footer');
		}
*/        
    }
    function dashboard() {
        $this->check_logged_in();
        $this->load->view('dashboard');
    }

    function logout() {
        $data = array
            (
            'userid' => 0,
            'username' => 0,
            'type' => 0,
			'idlevel'=>0,
            'login' => FALSE
        );
        $this->session->sess_destroy();
        $this->session->unset_userdata($data);
        redirect('admin/index');
    }

    public function check_logged_in() {
        if ($this->session->userdata('login') != TRUE) {
            redirect('admin/login', 'refresh');
            exit();
        }
    }

    public function is_logged_in() {
        if ($this->session->userdata('logged_in') == TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
	
	function nama_file($menu){
		$this->menu=$menu;
	}
	
	function nama_tabel($content){
		$this->content=$content;	
	}
	function nbulan($bulan){
		$this->bulan=nBulan(round($bulan));
	}
	function ntahun($thn){
		$this->tahun=$thn;
	}
	function ngrid($list,$jn_trans='',$field=''){
		$this->grid=$list;
		$this->jn_trans=$jn_trans;
		$this->field=$field;
	}
	//proces autocreate database core ==>user,userlevel,useroto
	function cek_db_user(){
		$create_db="CREATE DATABASE IF NOT EXISTS `".$this->zetro_manager->rContent("Server","dbname",$this->zc)."`";
		mysql_query($create_db);
		//$this->db->select('*');
		$query="show tables in ".$this->zetro_manager->rContent("Server","dbname",$this->zc)." like 'users'";
		$rs=mysql_query($query)or die(mysql_error());
		if (!mysql_num_rows($rs)){
			$sql="Create table if not exists `users` (
				 `userid` VARCHAR(50) NULL DEFAULT NULL,
				 `username` VARCHAR(200) NULL DEFAULT NULL,
				 `password` VARCHAR(200) NULL DEFAULT NULL,
				 `idlevel` VARCHAR(50) NULL DEFAULT NULL,
				 `active` ENUM('Y','N') NULL DEFAULT 'Y',
				 `createdate` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
				 PRIMARY KEY (`userid`)
				 )
				 COLLATE='latin1_swedish_ci'
				 ENGINE=InnoDb";
			mysql_query($sql);
				  
		}
		$sql="select * from users";
		$r=mysql_query($sql) or die(mysql_error());
		if(!mysql_num_rows($r)){
			//tampilkan form untuk membuat user superuser
			$this->load->view('admin/header');
			$this->load->view('admin/admin_user');
			$this->load->view('admin/footer');
		}else{
		$data=array();
		$data['login']=$this->session->userdata('login');
		$data['serial']=(no_ser()==addCopy())? 
		  substr(chunk_split(strtoupper(no_ser()),4,'-'),0,-1):"";
			if($this->session->userdata('login')==true){
				$this->Admin_model->create_useroto();
				$this->load->view('admin/header');
				$this->load->view('admin/home',$data);
				$this->load->view('admin/footer');
			}else{
				$this->load->view('admin/header');
				$this->load->view('admin/login',$data);
				$this->load->view('admin/footer');
			}
		}
	}
	function process_userfirst(){
        $this->form_validation->set_rules('username', 'username', 'required|xss_clean');
        $this->form_validation->set_rules('password', 'password', 'required|xss_clean');
        $this->form_validation->set_error_delimiters('', '<br/>');
		$data=array();$lvl=array();
        if ($this->form_validation->run() == TRUE) 
		{
            $data['userid'] = $this->input->post('username');
			$data['username']=$this->input->post('username');
            $data['password'] = md5( $this->input->post('password'));
			$data['idlevel']='1';
			$this->Admin_model->simpan_data('users',$data);
			$this->Admin_model->user_level();
			$lvl["nmlevel"]="Super User";
			$this->Admin_model->simpan_data('user_level',$lvl);
			redirect ('Admin/index');
		}else{
			redirect ('Admin/index');
		}
	}
	
	function showlevel(){
		$data=array();$datax=array();$n=1;
		$hasil=$this->Admin_model->show_list('user_level',"where idlevel!='1'");
		foreach ($hasil->result_array() as $rw){
		echo "<tr class='xx' id='".$rw['idlevel']."'>\n
				<td class='kotak' align='center' >$n</td>\n
				<td class='kotak' title='Click for select' id='pilih' abbr='a-".$rw['idlevel']."'>".$rw['nmlevel']."</td>\n
				<td class='kotak xy' align='center' abbr='".$rw['idlevel']."' id='hps' title='click for delete'><b>X</b></td>\n
				</tr>\n";
			$n++;
		}
	}

	function userlevel(){
		$data=array();$datax=array();$n=0;
		$datax['nmlevel']=ucwords($_POST['nmlevel']);
		$this->Admin_model->simpan_data('user_level',$datax);
		$hasil=$this->Admin_model->show_list('user_level',"where idlevel!='1'");
		foreach ($hasil->result_array() as $rw){
			$n++;
		echo "<tr class='xx' id='".$rw['idlevel']."'>\n
				<td class='kotak' align='center' >$n</td>\n
				<td class='kotak' title='Click for select' id='pilih' abbr='a-".$rw['idlevel']."'>".$rw['nmlevel']."</td>\n
				<td class='kotak xy' align='center' abbr='".$rw['idlevel']."' id='hps' title='click for delete'><b>X</b></td>\n
				</tr>\n";
		}
	}
	function dropdown_usr(){
		echo dropdown('users','userid','username',"where idlevel<>'1' order by username",$this->session->userdata('userid'));
	}
	
	function masuk(){
		$data=array();
		$data['menus']=$_GET['id'];
		$sesmenu=array('menus'=>$_GET['id']);
		$this->session->set_userdata($sesmenu);
			$this->load->view('admin/header',$data);
			$this->load->view('admin/dashboard',$data);
			$this->load->view('admin/footer');
	}
	function validity(){
		$txt=$_POST['ns'];
		$mac=substr(chunk_split(strtoupper(md5(hash('sha1',no_ser()))),4,'-'),0,-1);
		if(str_replace('-','',$mac)==str_replace('-','',$txt)){
			 w_ser(no_ser());
			 echo "Aktifasi berhasil. terima kasih atas kerjasamanya";
		}else{
			echo  "Serial Number yang ada masukan salah Salah";
		}
	}
	function validity_ok(){
		$data=array('version' =>'');
		$this->session->unset_userdata($data);
	}
	
	function help()
	{
		header("Location :".base_url()."asset/help");
	}
}
?>
