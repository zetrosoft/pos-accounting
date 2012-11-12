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
link_js('neraca_lajur_bener.js',$path.'/js');
panel_begin('Neraca Lajur','','',",,,,<input type='button' class='print' value='Cetak' id='cetak' title='Klik untuk print'>");
panel_multi('neracalajur','block',false);
if($all_neracalajur!=''){
echo "<form name='frm_j' id='frm_j' method='post' action=''>";
echo "
<table id='period' style='border-collapse:collapse'>
	<tr><td width='70px'>Periode :</td>
    	<td width='20px'><input type='radio' name='periode' id='pertgl' value='tgl'/></td>
        <td width='70px'>Per Tanggal</td>
        <td width='100px'><input type='text' id='tgl_start' name='tgl_start' class='w100' value='' /></td>
        <td width='20px'>s/d</td>
        <td width='100px'><input type='text' id='tgl_stop' name='tgl_stop' class='w100' value='' /></td>
        <td style='border-right:2px dotted #FFF' width='15px'></td>
        <td width='10px'>&nbsp;</td>
        <td width='80px'>Departemen</td>
        <td width='220px'><select id='ID_Dept' name='ID_Dept'  class='S100'>";
		dropdown("mst_departemen",'ID','Departemen',"where ID not in('0','1') order by Kode");
	echo "</select></td>
        <td width='5px'>&nbsp;</td>
        <td width='90px'>Status Anggota</td>
        <td width='150px'><select id='ID_Stat' name='ID_Stat' class='S100'>
		<option value=''>Semua</option>
		<option value='1'>Aktif</option>
		<option value='13'>Aktif + Non Aktif</option>
		</select></td>
    </tr>
	<tr><td>&nbsp;</td>
    	<td><input type='radio' name='periode' id='pertahun' value='thn' /></td>
        <td>Per Tahun</td>
        <td><select id='tahun' name='tahun'></select></td>
        <td>&nbsp;</td>
        <td><input type='button' id='oke' value='OK'></td>
        <td style='border-right:2px dotted #FFF' width='15px'></td>
        <td >&nbsp;</td>
        <td >Perkiraan</td>
        <td colspan='4'><select id='ID_Perkiraan' name='ID_Perkiraan' class='S100'>
		<option value=''>Semua</option>";
		dropdown('jenis_simpanan','ID','Jenis',"order by ID");
		echo "</select><input type='hidden' id='filper' value='' name='filper' /></td>
    </tr>
</table>
<hr />";

echo "</form>";	
		$zlb->section('Neraca Lajur');
		$zlb->aksi(false);
		$zlb->Header('99%');
		$zlb->icon();
		echo "</tbody></table>";

}else{
	no_auth();
}
panel_multi_end();
panel_end();
?>
