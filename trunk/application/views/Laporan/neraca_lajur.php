<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$zfm=new zetro_frmBuilder('asset/bin/zetro_neraca.frm');
$zlb=new zetro_buildlist();
$zlb->config_file('asset/bin/zetro_neraca.frm');
$path='application/views/laporan';
$fld="<input type='text' id='nm_agt' name='nm_agt' value='' style='width:200px' class='cari' title='Ketik nama anggota'>";
calender();
link_css('jquery.coolautosuggest.css','asset/css');
link_js('jquery.coolautosuggest.js','asset/js');
link_js('jquery.fixedheader.js,jquery_terbilang.js','asset/js,asset/js');
link_js('neraca_lajur.js',$path.'/js');
panel_begin('Rekapitulasi','','',",,,,<input type='button' class='print' value='Cetak' id='cetak' title='Klik untuk print'>");
panel_multi('rekapsimpanan','block');
if($all_laporan__rekap_simpanan!=''){
echo "<form name='frm_j' id='frm_j' method='post' action=''>";
echo "
<table id='period' style='border-collapse:collapse'>
	<tr><td width='90px'>Periode :</td>
    	<td width='20px'><input type='radio' name='periode' id='pertgl' /></td>
        <td width='90px'>Tanggal</td>
        <td width='150px'><input type='text' id='tgl_start' name='tgl_start' class='w100' value='' /></td>
        <td style='border-right:2px dotted #FFF' width='15px'></td>
        <td width='90px'><input type='button' id='oke' value='OK'></td>
        <td width='250px'>&nbsp;</td>
    </tr>
	<!--tr><td>&nbsp;</td>
    	<td><input type='radio' name='periode' id='pertahun' /></td>
        <td>Tahun</td>
        <td><select id='tahun'></select></td>
        <td style='border-right:2px dotted #FFF' width='15px'></td>
        <td></td>
        <td >&nbsp;</td>
    </tr-->
</table>
<hr />";
echo "</form>";	
		echo tabel();
		echo "<thead>";
		echo tr().th('','100%');/*
			th('No','5%').
			th('Departemen','25%');
		for ($i=1;$i<=3;$i++){
			echo th(rdb("jenis_simpanan",'Jenis','Jenis',"where ID='".$i."'"),'10%');
		}
		echo th('Total','10%');*/
		echo _tr()."</thead><tbody>";/**/
		echo _tabel(true);
}else{
	no_auth();
}
panel_multi_end();
panel_end();
?>
<input type='hidden' id='filper' value='' />