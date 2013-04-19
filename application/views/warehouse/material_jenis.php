<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$zfm=new zetro_frmBuilder('asset/bin/zetro_inv.frm');
$zlb=new zetro_buildlist();
$section='Barang';
$zlb->config_file('asset/bin/zetro_inv.frm');
$path='application/views/inventory';
link_js('material_inv.js',$path.'/js');
tab_select('');
panel_begin('Jenis Barang');
panel_multi('jenisbarang','block',false);
if($all_jenisbarang!=''){
	$zfm->AddBarisKosong(true);
	$zfm->Start_form(true,'frm1');
	$zfm->BuildForm('Jenis',true,'50%');
	$zfm->BuildFormButton('Simpan','jenis');
	echo "<hr/>";
	$sql2="select * from inv_barang_jenis order by JenisBarang";
		$zlb->section('Jenis');
		$zlb->aksi(($e_jenisbarang!='')?false:false);
		$zlb->icon('deleted');
		$zlb->query($sql2);
		$zlb->sub_total(false);
		$zlb->sub_total_field('stock,blokstok');
		$zlb->Header('50%');
		$zlb->list_data('Jenis');
		$zlb->BuildListData('JenisBarang');
		echo "</tbody></table>";
}else{
	no_auth();
}
panel_multi_end();
panel_end();
?>
<script language="javascript">
$(document).ready(function(e) {
    	$('#jenisbarang').removeClass('tab_button');
		$('#jenisbarang').addClass('tab_select');

});

</script>