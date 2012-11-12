<?php
$zfm=new zetro_frmBuilder('asset/bin/zetro_inv.frm');
$zlb=new zetro_buildlist();
$section='Barang';
$zlb->config_file('asset/bin/zetro_inv.frm');
$path='application/views/inventory';
link_js('material_inv.js',$path.'/js');
tab_select('');
panel_begin('Kategori Barang');
panel_multi('kategoribarang','block',false);
if($all_kategoribarang!=''){
	$zfm->AddBarisKosong(true);
	$zfm->Start_form(true,'frm2');
	$zfm->BuildForm('Kategori',true,'50%');
	$zfm->BuildFormButton('Simpan','kat');
	echo "<hr/>";
	$sql2="select * from inv_barang_kategori order by Kategori";
		$zlb->section('Kategori');
		$zlb->aksi(($e_kategoribarang!='')?false:false);
		$zlb->icon('deleted');
		$zlb->query($sql2);
		$zlb->Header('50%');
		$zlb->sub_total(false);
		$zlb->sub_total_field('stock,blokstok');
		$zlb->list_data('Kategori');
		$zlb->BuildListData('Kategori');
		echo "</tbody></table>";
}else{
	no_auth();
}
panel_multi_end();
/*panel_multi('jenisbarang','none',false);
if($all_jenis!=''){
	$zfm->AddBarisKosong(true);
	$zfm->Start_form(true,'frm1');
	$zfm->BuildForm('Jenis',true,'50%');
	$zfm->BuildFormButton('Simpan','jenis');
	echo "<hr/>";
	$sql2="select * from inv_barang_jenis order by JenisBarang";
		$zlb->section('Jenis');
		$zlb->aksi(($e_jenis!='')?true:false);
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
panel_multi('golongan');
if($all_golongan!=''){
	$zfm->AddBarisKosong(true);
	$zfm->Start_form(true,'frm3');
	$zfm->BuildForm('Golongan',true,'50%');
	$zfm->BuildFormButton('Simpan','subkat');
	echo "<hr/>";
	$sql2="select * from inv_golongan order by nm_golongan";
		$zlb->section('Golongan');
		$zlb->aksi(($e_golongan!='')?true:false);
		$zlb->icon('deleted');
		$zlb->query($sql2);
		$zlb->Header('50%');
		$zlb->sub_total(false);
		$zlb->sub_total_field('stock,blokstok');
		$zlb->list_data('Kategori');
		$zlb->BuildListData('nm_golongan');
		echo "</tbody></table>";
}else{
	no_auth();
}
panel_multi_end();
*/panel_end();

?>