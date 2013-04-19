<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$zfm=new zetro_frmBuilder('asset/bin/zetro_member.frm');
$zlb=new zetro_buildlist();
$zlb->config_file('asset/bin/zetro_member.frm');
$path='application/views/laporan';
$fld="<input type='text' id='nm_agt' name='nm_agt' value='' style='width:200px' class='cari' title='Ketik nama anggota'>";
link_css('jquery.coolautosuggest.css','asset/css');
link_js('jquery.coolautosuggest.js','asset/js');
link_js('jquery.fixedheader.js,jquery_terbilang.js','asset/js,asset/js');
link_js('rekap_simpanan.js',$path.'/js');
panel_begin('Laporan','frm1','Rekap Simpanan sampai dengan : <b>'.date('d F Y')."</b>",",,,|,<input type='button' class='print' value='Cetak' id='cetak' title='Klik untuk print'>");
panel_multi('simpanananggota','block');
if($all_laporan__rekap_simpanan!=''){
	echo "<table id='ListTable' width='98%' style='border-collapse:collapse'>
		<thead>\n
		<tr class='headere' align='center'>\n
		<th width='5%' class='kotak'>No.</th>
		<th width='20%' class='kotak'>Departemen</th>\n";
		foreach($simpanan->result() as $jn){
			echo "<th width='10%' class='kotak'>".$jn->Jenis."</th>\n";
		}
	echo "<th width='12%' class='kotak'>Total</th></tr></thead>\n<tbody>\n";
	echo "</tbody></table>\n";
}else{
	no_auth();
}
panel_multi_end();
panel_end();

?>