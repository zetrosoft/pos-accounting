<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$zfm=new zetro_frmBuilder('asset/bin/zetro_akun.frm');
$zlb=new zetro_buildlist();
$zlb->config_file('asset/bin/zetro_akun.frm');
$path='application/views/akuntansi';
link_js('jquery.fixedheader.js,departemen.js','asset/js,'.$path.'/js');
panel_begin('Departemen');
panel_multi('departemen','block',false);
if($all_departement!=''){
$fld="<input type='hidden' id='ID_A' name='ID_A' value=''>";
	$zfm->Addinput($fld);
	$zfm->AddBarisKosong(false);
	$zfm->Start_form(true,'frm1');
	$zfm->BuildForm('Departemen',true,'50%');
	$zfm->BuildFormButton('Simpan','klasifikasi');
	
		$zlb->section('Departemen');
		$zlb->aksi(true);
		$zlb->Header('100%');
		$zlb->icon();
		echo "</tbody></table>";
}else{
	no_auth();
}
panel_multi_end();
panel_end();


?>
