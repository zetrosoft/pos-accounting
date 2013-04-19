<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$zfm=new zetro_frmBuilder('asset/bin/zetro_master.frm');
$zlb=new zetro_buildlist();
$zlb->config_file('asset/bin/zetro_master.frm');
$path='application/views/master';
link_js('jquery.fixedheader.js,master_tools.js,jquery_terbilang.js','asset/js,'.$path.'/js,asset/js');
panel_begin('Setting SHU');
panel_multi('komponenshu','block',false);
if($all_komponenshu!=''){
	addText(array('',''),array("","<input type='button' id='addHead' value='Add Jenis SHU'>"));
		$zlb->section('shu');
		$zlb->aksi(true);
		$zlb->icon();
		$zlb->Header('100%','HeadSHU');
		$n=0;
		foreach($shu as $sh){
			$n++;
			echo "<tr class='xx' id='c-".$sh->ID."'>
				  <td class='kotak' align='center'>$n</td>
				  <td class='kotak' onClick=\"show_detail_shu('".$sh->ID."-".$sh->ID_Calc."');\">".$sh->Jenis1."</td>
				  <td class='kotak' onClick=\"show_detail_shu('".$sh->ID."-".$sh->ID_Calc."');\">".$sh->Header2."</td>
				  <td class='kotak' align='center'>".img_aksi('H-'.$sh->ID,true)."</td>
				  </tr>\n";
		}
	echo "</body></table><hr>\n";
	addText(array('',''),array("","<input type='button' id='addSub' value='Add Sub Jenis SHU'>"));
		$zlb->section('subneraca');
		$zlb->aksi(true);
		$zlb->icon();
		$zlb->sub_total(false);
		$zlb->sub_total_field('stock,blokstok');
		$zlb->Header('100%','SubSHU');
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
	$zfm->BuildForm('subshu',true,'100%');
	$zfm->BuildFormButton('Simpan','addsub');
	echo "<i><font color='#000000'> *) Di isi dengan angka 1 jika Ya, 0 jika Tidak</font></i>";
popup_end();
panel_end();
?>
<input type='hidden' id='aktif' value='' />
<input type='hidden' id='calc' value='' />
<script language='javascript'>
$(document).ready(function(e) {
    	$('#komponenshu').removeClass('tab_button');
		$('#komponenshu').addClass('tab_select');

});
</script>