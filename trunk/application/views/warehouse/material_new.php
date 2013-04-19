<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$zfm=new zetro_frmBuilder('asset/bin/zetro_inv.frm');
$zlb=new zetro_buildlist();
$zlb->config_file('asset/bin/zetro_inv.frm');
$section='Barang';
$path='application/views/warehouse';

link_css('jquery.coolautosuggest.css','asset/css');
link_js('jquery.coolautosuggest.js,jquery_terbilang.js','asset/js,asset/js');
link_js('jquery.fixedheader.js,material_new.js','asset/js,'.$path.'/js');
panel_begin('Tambah Barang');
panel_multi('tambahbarang','block',false);
if($c_tambahbarang!=''){
	$zfm->AddBarisKosong(true);
	$zfm->Start_form(true,'frm1');
	$zfm->BuildForm($section,true,'70%');
	$zfm->BuildFormButton('Simpan','add');
}else{
	no_auth();
}
panel_multi_end();
echo "<div id='status' style='width:99%; border:1px solid #DDDDD'></div>";
panel_end();
terbilang();
?>
<input type='hidden' id='id_kategori' value=''>
<input type='hidden' id='id_jenis' value=''>
<input type='hidden' id='id_satuan' value=''>
