<?php
$zfm=new zetro_frmBuilder('asset/bin/zetro_beli.frm');
$zlb=new zetro_buildlist();
$zlb->config_file('asset/bin/zetro_beli.frm');
$path='application/views/laporan';
$printer="<img src='".base_url()."asset/images/print.png' id='printsheet' class='menux' style='display:none' title='Print report'>";
link_css('autosuggest.css','asset/css');
link_js('auto_sugest.js,lap_beli.js,jquery.fixedheader.js','asset/js,'.$path.'/js,asset/js');
panel_begin('Lap.Pembelian','',','.$printer);
panel_multi('tranpembelian','block');
if($all_trans_beli!=''){
$fld="<input type='hidden' id='jtran' name='jtran' value=''>";
$fld.="<input type='hidden' id='section' name='section' value='lapbelilist'>";
$fld.="<input type='hidden' id='lap' name='lap' value='beli'>";
$fld.="<input type='hidden' id='optional' name='optional' value=''>";
	$zfm->Addinput($fld);
	$zfm->AddBarisKosong(false);
	$zfm->Start_form(true,'frm1');
	$zfm->BuildForm('lapbeli',true,'60%');
	$zfm->BuildFormButton('Process','filter','button',2);
	echo "<hr>";
		$zlb->section('lapbelilist');
		$zlb->aksi(false);
		$zlb->Header('100%');
	echo "</tbody></table>";
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