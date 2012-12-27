<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$zfm=new zetro_frmBuilder('asset/bin/zetro_master.frm');
$zlb=new zetro_buildlist();
$zlb->config_file('asset/bin/zetro_master.frm');
$path='application/views/master';
calender();
link_js('master_promo.js',$path.'/js');
link_js('jquery.fixedheader.js','asset/js');
panel_begin('Info Promo');
panel_multi('informasipromo','block',false);
if($all_informasipromo!=''){
	$zfm->AddBarisKosong(false);
	$zfm->Start_form(true,'frm1');
	$zfm->BuildForm('promo',true,'70%');
	$zfm->BuildFormButton('Simpan','vendor');
	echo "<hr>";
		$zlb->section('promo');
		$zlb->aksi(true);
		$zlb->icon();
		$zlb->Header('100%');
		echo "</tbody></table>";

}else{
	no_auth();
}
panel_multi_end();
popup_start('v_detail','Edit Data');
	$txt="<input type='hidden' id='p_id' value=''/>";
	$zfm->Addinput($txt);
	$zfm->AddBarisKosong(true);
	$zfm->Start_form(true,'frm2');
	$zfm->BuildForm('promo',true,'100%');
	$zfm->BuildFormButton('Simpan','promo');
popup_end();
panel_end();

?>

