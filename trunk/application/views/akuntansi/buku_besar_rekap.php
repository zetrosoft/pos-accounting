<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$zfm=new zetro_frmBuilder('asset/bin/zetro_akun.frm');
$zlb=new zetro_buildlist();
$zlb->config_file('asset/bin/zetro_akun.frm');
$path='application/views/akuntansi';
calender();
($p_bukubesar!='')?$oto_p='':$oto_p='none';
link_css('jquery.coolautosuggest.css','asset/css');
link_js('jquery.fixedheader.js,jquery.coolautosuggest.js','asset/js,asset/js');
link_js('buku_besar.js,jquery_terbilang.js',$path.'/js,asset/js');
panel_begin('Buku Besar','',',',",,,,<input type='button' class='print' style='display:$oto_p' value='Cetak' id='cetak' title='Klik untuk print'>");
panel_multi('bukubesar','block',false);
if($all_bukubesar!=''){
/*?><table id='xx' style='border-collapse:collapse' width='100%'>
<tr>
<td width='40%' class='border_r' valign="top"><?
*/echo "<form name='frm_j' id='frm_j' method='post' action=''>";
/*	 addText(array('Periode     ',"Per Tanggal",'Dari','s/d'),
	 		 array('',"<input type='radio' name='periode' id='pertgl' />",
			 		"<input type='text' id='tgl_start' class='w100' value='' />",
					"<input type='text' id='tgl_stop' class='w100' value='' />"));
*/	 addText(array('Periode     ',"Per Tahun  ",''),
	 		 array('',"<input type='radio' name='periode' id='pertahun' />  ",
			 		"<select id='tahun'></select>"));
	 addText(array('Klasifikasi    '),array("<select id='ID_Klas' class='s100'></select>"));
	 addText(array('Sub Klasifikasi'),array("<select id='ID_SubKlas' class='s100'></select>"));
	 addText(array('Departemen     '),array("<select id='ID_Dept' class='s100'></select>"));
	 addText(array('Perkiraan      '),array("<select id='ID_Agt' class='s100'></select>"));
	 addText(array(nbs(2),''),
	 		 array("<input type='button' id='oke' value='View'>",
			 	   "<input type='button' id='printer' class='' value='Print' alt='Print'>"));
echo "</form>\n";
/*?></td>
<td width='60%' valign="top"><?
*/echo "<div id='tgl' style='display:none'>";		   
		$zlb->section('bukubesar');
		$zlb->aksi(false);
		$zlb->Header('100%');
		$zlb->icon();
		echo "</tbody></table>\n
		</div>
		<div id='thn' style='display:none'>";
		$zlb->section('bukubesartahunan');
		$zlb->aksi(false);
		$zlb->Header('100%','bbTahunan');
		$zlb->icon();
		echo "</tbody></table></div>";
/*?>
</td></tr>
</table>
<?
*/}else{
	no_auth();
}
panel_multi_end();
panel_end();
loading_ajax();
terbilang();
?>
<input type='hidden' id='filper' value='' />
<script language="javascript">
$(document).ready(function(e) {
    	$('#ID_Klas').html("<? dropdown('Klasifikasi','ID','Klasifikasi','','');?>");
    	$('#ID_Dept').html("<? dropdown('mst_departemen','ID','Departemen','','');?>");

	unlock('#tgl_start,#tgl_stop,#tahun')
	unlock('#ID_Klas,#ID_SubKlas,#ID_Dept,#ID_Agt')
					$('div#tgl').hide();
					$('div#thn').show();
});
</script>