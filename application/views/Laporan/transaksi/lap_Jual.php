<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$zfm=new zetro_frmBuilder('asset/bin/zetro_neraca.frm');
$zlb=new zetro_buildlist();
$zlb->config_file('asset/bin/zetro_neraca.frm');
$path='application/views/laporan/transaksi';
calender();
$posisi=$this->session->userdata('menus');
link_css('jquery.coolautosuggest.css','asset/css');
link_js('jquery.coolautosuggest.js','asset/js');
link_js('auto_sugest.js,lap_jual.js,jquery.fixedheader.js','asset/js,'.$path.'/js,asset/js');
panel_begin('Rekap Penjualan Tunai');
panel_multi('rekappenjualantunai','block',false);
if($all_rekappenjualantunai!=''){
	echo "<form id='frm1' name='frm1' method='post' action=''>";
	addText(array('Periode :',' s/d ',($posisi=='SW52TWVudQ==')?'Kategori':'',($posisi=='SW52TWVudQ==')?'Jenis':'',''),
	array("<input type='text' id='dari_tgl' name='dari_tgl' value=''>",
		  "<input type='text' id='sampai_tgl' name='sampai_tgl' value=''>",
		  ($posisi=='SW52TWVudQ==')? "<select id='kategori' name='kategori'></select>":"<select id='kategori' name='kategori'></select>",
		  ($posisi=='SW52TWVudQ==')? "<select id='id_jenis' name='id_jenis'></select>":"<select id='id_jenis' name='id_jenis'></select>",
		  ($posisi=='SW52TWVudQ==')?
		  "<input type='button' value='OK' id='okelah'/>":
		  "<input type='button' value='OK' id='view'/>
		   <input type='button' value='Print' id='okelah'/>
		  
		  <input type='hidden' value='1' id='jenis_beli' name='jenis_beli'/>"));
	echo "</form>";
	echo "</tbody></table>";
	echo "<table id='xx' width='100%'><tbody><tr><td>&nbsp;</td></tr></tbody></table>";
		$zlb->section('rekapjualtunai');
		$zlb->aksi(true);
		$zlb->Header('80%');
		$zlb->icon();
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
	$('#kategori').html("<option value='' selected>Semua</option><? dropdown('inv_barang_kategori','ID','Kategori','','');?>");
	$('#id_jenis').html("<option value='' selected>Semua</option><? dropdown('inv_barang_jenis','ID','JenisBarang','','');?>");
});
</script>