<?php
$zfm=new zetro_frmBuilder('asset/bin/zetro_inv.frm');
$zlb=new zetro_buildlist();
$zlb->config_file('asset/bin/zetro_inv.frm');
$path='application/views/laporan';
link_css('autosuggest.css','asset/css');
link_js('jquery.fixedheader.js,lap_stock.js,auto_sugest.js,jquery_terbilang.js','asset/js,'.$path.'/js,asset/js,asset/js');
panel_begin('Lap.Stock');
panel_multi('stocklist','block');
if($all_stocklist!=''){
$fld="<input type='hidden' id='section' name='section' value='lapjuallist'>";
$fld.="<input type='hidden' id='lap' name='lap' value='stock'>";
$fld.="<input type='hidden' id='optional' name='optional' value='stock'>";
	$zfm->Addinput($fld);
	echo "Select Filter of list :";
	$zfm->AddBarisKosong();
	$zfm->Start_form(true,'frm2');
	$zfm->BuildForm('stoklist filter',true,'50%');
	$zfm->BuildFormButton('Process','filter','button',2);
	echo "<hr>";
	//<font style='color:#000; font-size:medium'><u>List Obat Filter by :<span id='nmj'></span><span id='kat'></span><span id='gol'></span></u></font>";
		$zlb->section('stoklistview');
		$zlb->aksi(false);
		$zlb->Header('100%');
		echo "</tbody></table>";
}else{ no_auth();}
panel_multi_end();
panel_multi('dataexpire');
if($all_dataexpire!=''){
$fld2="<input type='hidden' id='section' name='section' value='lapjuallist'>";
$fld2.="<input type='hidden' id='lap' name='lap' value='expired'>";
$fld2.="<input type='hidden' id='optional' name='optional' value=''>";
	$zfm->Addinput($fld2);
	$zfm->AddBarisKosong();
	$zfm->Start_form(true,'frm1');
	$zfm->BuildForm('stoklist filter',true,'50%');
	$zfm->BuildFormButton('Process','expired','button',2);
}else{ no_auth();}
panel_multi_end();
panel_multi('stocklimit');
if($all_stocklimit!=''){
$fld3="<input type='hidden' id='section' name='section' value='lapjuallist'>";
$fld3.="<input type='hidden' id='lap' name='lap' value='stocklimit'>";
$fld3.="<input type='hidden' id='optional' name='optional' value=''>";
	$zfm->Addinput($fld3);
	$zfm->AddBarisKosong();
	$zfm->Start_form(true,'frm3');
	$zfm->BuildForm('stoklist filter',true,'50%');
	$zfm->BuildFormButton('Process','limit','button',2);
}else{ no_auth();}
panel_multi_end();
panel_end();
auto_sugest();
?>
<script language="javascript">
	$(document).ready(function(e) {
    //$('#v_stocklist table#ListTable').fixedHeader({width:700,height:350})
    });
</script>