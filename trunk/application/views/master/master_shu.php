<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$zfm=new zetro_frmBuilder('asset/bin/zetro_master.frm');
$zlb=new zetro_buildlist();
$zlb->config_file('asset/bin/zetro_master.frm');
$path='application/views/master';
link_js('jquery.fixedheader.js,master_tools.js,jquery_terbilang.js','asset/js,'.$path.'/js,asset/js');
panel_begin('Setting SHU');
panel_multi('komponenshu','block',false);
if($all_komponenshu!=''){
		$zlb->section('shu');
		$zlb->aksi(false);
		$zlb->icon();
		$zlb->Header('100%','HeadSHU');
		$n=0;
		foreach($shu as $sh){
			$n++;
			echo "<tr class='xx' onClick=\"show_detail_shu('".$sh->ID."');\" id='c-".$sh->ID."'>
				  <td class='kotak'>$n</td>
				  <td class='kotak'>".$sh->Jenis1."</td>
				  <td class='kotak'>".$sh->Header2."</td>
				  </tr>\n";
		}
	echo "</body></table><hr>\n";
		$zlb->section('subneraca');
		$zlb->aksi(false);
		$zlb->icon();
		$zlb->sub_total(false);
		$zlb->sub_total_field('stock,blokstok');
		$zlb->Header('100%','SubSHU');
	echo "</body></table>\n";
}else{
	no_auth();
}
panel_multi_end();

?>
<script language='javascript'>
$(document).ready(function(e) {
    	$('#komponenshu').removeClass('tab_button');
		$('#komponenshu').addClass('tab_select');

});
</script>