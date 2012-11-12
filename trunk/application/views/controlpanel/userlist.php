<?php
$zfm=new zetro_frmBuilder('asset/bin/zetro_user.frm');
$zlb=new zetro_buildlist();
$zlb->config_file('asset/bin/zetro_user.frm');
$path='application/views/controlpanel';
link_css('autosuggest.css','asset/css');
link_js('auto_sugest.js,zetro_number.js,userlist.js','asset/js,asset/js,'.$path.'/js');
tab_select('');
panel_begin('User Account');
panel_multi('adduser','none',false);
if($all_adduser!=''){
($e_adduser==''||$c_adduser=='')?$btn=false:$btn=true;
	$zfm->AddBarisKosong(true);
	$zfm->Start_form(true,'frm1');
	$zfm->BuildForm('userlist',$btn,'70%');
	if($btn==true) $zfm->BuildFormButton('Simpan','userlist');
}else{ no_auth();}
panel_multi_end();
//tab user list
panel_multi('listuser','block',false);
if($v_listuser!=''){
($e_listuser=='')?$btn=false:$btn=true;
	$sql2="select * from users where userid !='superuser' order by userid";
	$zlb->deskripsi('user_level','nmlevel','idlevel');
		$zlb->section('userlist');
		$zlb->aksi($btn);
		$zlb->icon();
		$zlb->query($sql2);
		$zlb->Header('80%');
		$zlb->list_data('userlist');
		$zlb->BuildListData('userid');
		echo "</tbody></table>\n";
}else{no_auth();}
panel_multi_end();
//tab user autorisation
panel_multi('authorisation','none',false);
//form select group
if($all_authorisation!=''){
	$zfm->AddBarisKosong(false);
	$zfm->Start_form(true,'frm2');
	$zfm->BuildForm('usergroup',false,'40%');
	echo "<hr/>\n";
	tab_head(base64_decode($this->session->userdata('menus')));
	echo "<table id='usrmenu' style='border-collapse:collapse' width='70%'>\n
		 <thead>
		 <tr class='header' align='center'>
		 <th class='kotak' width='30%'>Menu Name</th>
		 <th class='kotak' width='8%'>Input</th>
		 <th class='kotak' width='8%'>Edit</th>
		 <th class='kotak' width='8%'>View</th>
		 <th class='kotak' width='8%'>Print</th>
		 </tr></thead><tbody>\n
		 </tbody></table>\n";
	tab_head_end();
}else{
	no_auth();
}
panel_multi_end();
auto_sugest();
panel_end();
popup_start('adduserlevel','User Level',350);
($e_adduser==''||$c_adduser=='')?$btn=false:$btn=true;
	$zfm->AddBarisKosong(true);
	$zfm->Start_form(true,'frm3');
	$zfm->BuildForm('addlevel',$btn,'100%');
	if($btn==true) $zfm->BuildFormButton('Simpan','addlevel');
popup_end();
popup_start('edituser','Edit User profile');
($e_adduser==''||$c_adduser=='')?$btn=false:$btn=true;
	$zfm->AddBarisKosong(true);
	$zfm->Start_form(true,'frm4');
	$zfm->BuildForm('userlist',$btn,'90%');
	if($btn==true) $zfm->BuildFormButton('Simpan','edited');
popup_end();
($c_authorisation=='' && $this->session->userdata('idlevel')!='1')? $view='disabled':$view='';
?>
<input type='hidden' id='otor' value='<?=$view;?>' />
<input type='hidden' id='uea' value='<?=$this->session->userdata('idlevel');?>' />


