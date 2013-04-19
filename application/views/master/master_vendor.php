<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$zfm=new zetro_frmBuilder('asset/bin/zetro_master.frm');
$zlb=new zetro_buildlist();
$zlb->config_file('asset/bin/zetro_master.frm');
$path='application/views/master';
link_js('master_vendor.js',$path.'/js');
link_js('jquery.fixedheader.js','asset/js');
panel_begin('Pemasok');
panel_multi('tambahpemasok','none',false);
if($all_tambahpemasok!=''){
	$zfm->AddBarisKosong(true);
	$zfm->Start_form(true,'frm1');
	$zfm->BuildForm('produsen',true,'50%');
	$zfm->BuildFormButton('Simpan','vendor');
}else{
	no_auth();
}
echo "<table id='xx' width='50%'><tbody></tbody></table>";
panel_multi_end();
panel_multi('listpemasok','block',false);
if($all_listpemasok!=''){
addText(array('Nama Vendor :',''),
	   array('<input type="text" id="finde" class="cari w100">',
	   '<input type="button" id="oke" value="Cari">'));
		$zlb->section('produsen');
		$zlb->aksi(($e_listpemasok!='')?true:false);
		$zlb->icon('deleted');
		$zlb->Header('100%');
		echo "</tbody></table>";
}else{
	no_auth();
}
panel_multi_end();
panel_end();
popup_start('v_detail','Transaksi Pemasok :<span id="nmp"></span>',750,550);
		$zlb->section('detailtransvendor');
		$zlb->aksi(false);
		$zlb->icon('deleted');
		$zlb->Header('100%','vend_detail');
		echo "</tbody></table>";
popup_end();
auto_sugest();

?>
