<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$zfm=new zetro_frmBuilder('asset/bin/zetro_master.frm');
$zlb=new zetro_buildlist();
$zlb->config_file('asset/bin/zetro_master.frm');
$path='application/views/master';
link_js('jquery.fixedheader.js,master_neraca.js,jquery_terbilang.js','asset/js,'.$path.'/js,asset/js');
panel_begin('Tools');
panel_multi('settingneraca','block',false);
if($all_settingneraca!=''){
	addText(array('',''),array("","<input type='button' id='addHead' value='Add Jenis Neraca'>"));
		$zlb->section('neraca');
		$zlb->aksi(true);
		$zlb->icon();
		$zlb->sub_total(false);
		$zlb->sub_total_field('stock,blokstok');
		$zlb->Header('100%');
		$n=0;
		foreach($head as $lh){
			$n++;
			echo "<tr class='xx' id='c-".$lh->ID."'>
				  <td class='kotak' align='center'>$n</td>
				  <td class='kotak' onClick=\"show_detail('".$lh->ID."');\">".$lh->Header2."</td>
				  <td class='kotak' onClick=\"show_detail('".$lh->ID."');\">".$lh->Jenis1."</td>
				  <td class='kotak' align='center'>".img_aksi('H-'.$lh->ID,true)."</td>
				  </tr>\n";
		}
	echo "</body></table><hr>\n";
	addText(array('',''),array("","<input type='button' id='addSub' value='Add Sub Jenis Neraca'>"));
		$zlb->section('subneraca');
		$zlb->aksi(true);
		$zlb->icon();
		$zlb->Header('100%','SubTable');
	echo "</body></table>\n";
}else{
	no_auth();
}
panel_multi_end();
popup_start('headshu','Add Jenis SHU','500','300');
$fld="<input type='hidden' id='ID' val=''/>";
	$zfm->Addinput($fld);
	$zfm->AddBarisKosong(true);
	$zfm->Start_form(true,'frm1');
	$zfm->BuildForm('shuhead',true,'100%');
	$zfm->BuildFormButton('Simpan','add');
	echo "<i><font color='#000000'> *) Di isi dengan angka 1 jika Ya, 0 jika Tidak</font></i>";
popup_end();
popup_start('subshu','Add Sub Jenis SHU','500','350');
$fld="<input type='hidden' id='ID_Sub' val=''/>";
	$zfm->Addinput($fld);
	$zfm->AddBarisKosong(true);
	$zfm->Start_form(true,'frm2');
	$zfm->BuildForm('subsubneraca',true,'100%');
	$zfm->BuildFormButton('Simpan','addsub');
	echo "<i><font color='#000000'> *) Di isi dengan angka 1 jika Ya, 0 jika Tidak</font></i>";
popup_end();
panel_end();
auto_sugest();
?>
<input type='hidden' id='aktif' value='' />
<input type='hidden' id='calc' value='' />

