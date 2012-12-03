<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$zfm=new zetro_frmBuilder('asset/bin/zetro_master.frm');
$zlb=new zetro_buildlist();
$zlb->config_file('asset/bin/zetro_master.frm');
$path='application/views/master';
link_js('master_backup.js',$path.'/js');
panel_begin('Back Up Database');
panel_multi('backupdatabase','block',false);
if($this->session->userdata('idlevel')<='2'){
	echo "<font color='#000000'>
		  Backup data Transaksi  :<br>
		  1. Akuntansi (meliputi :simpanan, pinjaman dan setoran).<br>
		  2. Inventory (meliputi :Data Barang, penerimaan, penjualan tunai, penjualan kredit).<br>
		  
		  </font><hr>";
	addText(array('Periode','Bulan','s/d','Tahun',''),
			array('',
				  '<select id="dari_bln" name="dari_bln"></select>',
				  '<select id="sampai_bln" name="sampai_bln"></select>',
				  '<select id="thn" name="thn"></select>',
 				  '<input type="button" id="proses" value="Process Back up">'));
// browse file
	echo tabel('80%')."<thead>".tr('list_genap').td('List Backup File','left\' colspan=\'4\' id=\'jdl').
				_tr();
	echo tr('headere').th('No','center','5%').th('Nama File','55%').th('File Size','15%').th('Date Created','25%')._tr();
	echo "</thead><tbody>";
	echo _tabel(true);	
}else{
	no_auth();
}
panel_multi_end();
panel_end();
?>