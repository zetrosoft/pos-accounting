<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$zfm=new zetro_frmBuilder('asset/bin/zetro_member.frm');
$zlb=new zetro_buildlist();
$zlb->config_file('asset/bin/zetro_member.frm');
$path='application/views/member';
link_css('jquery.coolautosuggest.css','asset/css');
link_js('jquery.coolautosuggest.js,auto_sugest.js','asset/js,asset/js');
link_js('jquery.fixedheader.js,jquery_terbilang.js,member_pinjaman.js','asset/js,asset/js,'.$path.'/js');
panel_begin('Pinjaman');
panel_multi('pinjaman');
if($all_pinjaman!=''){
$fld="<input type='hidden' value='' id='ID_Perkiraan'>";
	$zfm->Addinput($fld);
	$zfm->AddBarisKosong();
	$zfm->Start_form(true,'frm1');
	$zfm->BuildForm('pinjaman',true,'60%');
	$zfm->BuildFormButton('Simpan','pinjaman');
}else{
	no_auth();
}
panel_multi_end();
panel_multi('setoranpinjaman','block');
if($all_setoranpinjaman!=''){
$fld="<input type='hidden' value='' id='ID_Perkiraane'>";
	$zfm->Addinput($fld);
	$zfm->AddBarisKosong();
	$zfm->Start_form(true,'frm2');
	$zfm->BuildForm('setoranpinjaman',false,'60%');
	//$zfm->BuildFormButton('Simpan','setoran');
	echo "$fld.<br><hr/><div id='dat_pinjm' style='width:70%;display:none;padding:5px;'>";
	echo "<table id='dat_simp' width='100%' style='border-collapse:collapse'>";
	echo "<thead><tr class='headere' align='center'>
				<th class='kotak' width='5%'>&nbsp;</th>
				<th class='kotak' width='30%'>Cicilan Ke </th>
				<th class='kotak' width='15%'>Besarnya</th>
				<th class='kotak' width='15%'>Saldo</th>
				<th class='kotak' width='20%'>Keterangan</th>
				</tr></thead><tbody>";

	echo "</tbody></table></div>";
}else{
	no_auth();
}
panel_multi_end();
panel_end();
echo "<div id='kekata' class='infox'></div><input type='hidden' id='baris' value=''>";
inline_edit('frm2');
?>	