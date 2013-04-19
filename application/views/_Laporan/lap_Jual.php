<?php
$zfm=new zetro_frmBuilder('asset/bin/zetro_beli.frm');
$zlb=new zetro_buildlist();
$zlb->config_file('asset/bin/zetro_beli.frm');
$path='application/views/laporan';
$printer="<img src='".base_url()."asset/images/print.png' id='printsheet' class='menux' style='display:none' title='Print report'>";
link_css('autosuggest.css','asset/css');
link_js('auto_sugest.js,lap_jual.js,jquery.fixedheader.js','asset/js,'.$path.'/js,asset/js');
panel_begin('Lap.Penjualan','',','.$printer);
panel_multi('transaksipenjualan','block');
$fld="<input type='hidden' id='jtran' name='jtran' value=''>";
$fld.="<input type='hidden' id='section' name='section' value='lapjuallist'>";
$fld.="<input type='hidden' id='lap' name='lap' value='jual'>";
$fld.="<input type='hidden' id='optional' name='optional' value=''>";
if($all_trans_jual!=''){
	$zfm->Addinput($fld);
	$zfm->AddBarisKosong(false);
	$zfm->Start_form(true,'frm1');
	$zfm->BuildForm('lapjual',true,'60%');
	$zfm->BuildFormButton('Process','filter','button',2);
}else{
	no_auth();
}
panel_multi_end();
$fld2="<input type='hidden' id='jtran' name='jtran' value=''>";
$fld2.="<input type='hidden' id='section' name='section' value='lapjuallist'>";
$fld2.="<input type='hidden' id='lap' name='lap' value='resep'>";
$fld2.="<input type='hidden' id='optional' name='optional' value=''>";
panel_multi('transaksiresep');
if($all_trans_resep!=''){
	$zfm->Addinput($fld2);
	$zfm->AddBarisKosong(false);
	$zfm->Start_form(true,'frm2');
	$zfm->BuildForm('lapjualresep',true,'60%');
	$zfm->BuildFormButton('Process','resep','button',2);
}else{
	no_auth();
}
panel_multi_end();
$fld3="<input type='hidden' id='jtran' name='jtran' value=''>";
$fld3.="<input type='hidden' id='section' name='section' value='lapjuallist'>";
$fld3.="<input type='hidden' id='lap' name='lap' value='topjual'>";
$fld3.="<input type='hidden' id='optional' name='optional' value=''>";
panel_multi('toppenjualan');
if($all_trans_top!=''){
	$zfm->Addinput($fld3);
	$zfm->AddBarisKosong(true);
	$zfm->Start_form(true,'frm3');
	$zfm->BuildForm('lapjualtop',true,'60%');
	$zfm->BuildFormButton('Process','topjual','button',2);
}else{
	no_auth();
}
panel_multi_end();
auto_sugest();
panel_end();
?>
<script language="javascript">
$(document).ready(function(e) {
    $('#printsheet').click(function(){
		$('#frm1').attr('action','print_laporan');
		document.frm1.submit();
		//document.location.href='http://localhost/apotek/index.php/report/countsheet';
	})
});
</script>