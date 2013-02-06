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

addText(array('Periode    :','Per Tanggal','s/d'),
		array("<input type='radio' name='periode' id='pertgl' value='tgl'/>",
			  "<input type='text' id='tgl_start' name='tgl_start' class='w100' value='' />",
			  "<input type='text' id='tgl_stop' name='tgl_stop' class='w100' value='' />"));
addText(array(nbs(2),'Per Tahun  ',''),
		array("<input type='radio' name='periode' id='pertahun' value='thn' />",
			  "<select id='tahun' name='tahun'></select>",
			  ""));
addText(array('Departemen  '.nbs()),array("<select id='ID_Dept' name='ID_Dept'  class='S100'></select>"));
addText(array('Perkiraan   '.nbs()),array("<select id='ID_Perkiraan' name='ID_Perkiraan' class='S100'></select>"));
addText(array('Status Anggota    '),array("<select id='ID_Stat' name='ID_Stat' class='S100'>
		<option value=''>Semua</option>
		<option value='1'>Aktif</option>
		<option value='13'>Aktif + Non Aktif</option>
		</select><input type='hidden' id='filper' value='' name='filper' />"));
addText(array(nbs(3)),array("<input type='button' id='oke' value='Process'>"));
echo "</form>";	

		//$zlb->section('Neraca Lajur');
		//$zlb->aksi(false);
		//$zlb->Header('99%');
		//$zlb->icon();
		//echo "</tbody></table>";

}else{
	no_auth();
}
panel_multi_end();
panel_end();
?>
<script language="javascript">
$(document).ready(function(e) {
    $('#ID_Dept').html("<? dropdown("mst_departemen",'ID','Departemen',"where ID not in('0','1') order by Kode") ?>");
	$('#ID_Perkiraan').html("<option value=''>Semua</option><? dropdown('jenis_simpanan','ID','Jenis',"order by ID");?>");
});
</script>