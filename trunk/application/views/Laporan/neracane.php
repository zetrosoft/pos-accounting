<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$path='application/views/laporan';
$fld="<input type='text' id='nm_agt' name='nm_agt' value='' style='width:200px' class='cari' title='Ketik nama anggota'>";
calender();
link_css('jquery.coolautosuggest.css','asset/css');
link_js('jquery.coolautosuggest.js','asset/js');
link_js('jquery.fixedheader.js,jquery_terbilang.js','asset/js,asset/js');
//,'','',",,,|,<input type='button' class='print' value='Cetak' id='cetak' title='Klik untuk print'>
link_js('neracane.js',$path.'/js');
panel_begin('Neraca');
panel_multi('neraca','block');
if($all_neraca!=''){
echo "<form name='frm_j' id='frm_j' method='post' action=''>";
echo "
<table id='period' style='border-collapse:collapse'>
	<tr><td width='90px'>Periode :</td>
    	<td width='20px'>&nbsp;</td>
        <td width='90px'>Per Tanggal</td>
        <td width='150px'><input type='text' id='tgl_start' name='tgl_start' class='w100' value='' /></td>
        <td style='border-right:2px dotted #FFF' width='15px'></td>
        <td width='50px' align='center'>Unit</td>
        <td width='30px' align='right'><input type='radio' name='unite' id='n-1' value='1'></td>
        <td width='50px'>KBR</td>
        <td width='30px' align='right'><input type='radio' name='unite' id='n-2' value='2'></td>
        <td width='50px'>USP</td>
        <td width='30px' align='right'><input type='radio' name='unite' id='n-3' value='3'></td>
        <td width='50px'>Gabungan</td>
        <td style='border-right:2px dotted #FFF' width='15px'></td>
        <td width='90px'><input type='button' id='oke' value='Proses'></td>
        <td width='100px'><input id='lokasi' name='lokasi' type='hidden' value='1'></td>
    </tr>
	<tr><td>&nbsp;</td>
    	<td><input type='checkbox' id='pembanding'></td>
        <td>Pembanding</td>
        <td><input type='text' id='tgl_banding' name='tgl_banding' class='w100' value='' /></td>
        <td style='border-right:2px dotted #FFF' width='15px'></td>
        <td colspan='7'>&nbsp;</td>
        <td colspan='3'>&nbsp;</td>
    </tr>
</table>
<hr />";
echo "</form>";	
}else{
	no_auth();
}
panel_multi_end();
panel_end();
loading_ajax();
?>
