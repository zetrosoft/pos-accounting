<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$zfm=new zetro_frmBuilder('asset/bin/zetro_master.frm');
$zlb=new zetro_buildlist();
$zlb->config_file('asset/bin/zetro_master.frm');
$path='application/views/master';
link_js('jquery.fixedheader.js,master_tools.js,jquery_terbilang.js','asset/js,'.$path.'/js,asset/js');
panel_begin('Tools');
panel_multi('settingneraca','block',false);
if($all_settingneraca!=''){
		$zlb->section('neraca');
		$zlb->aksi(false);
		$zlb->icon();
		$zlb->sub_total(false);
		$zlb->sub_total_field('stock,blokstok');
		$zlb->Header('100%');
		$n=0;
		foreach($head as $lh){
			$n++;
			echo "<tr class='xx' onClick=\"show_detail('".$lh->ID."');\" id='c-".$lh->ID."'>
				  <td class='kotak' align='center'>$n</td>
				  <td class='kotak'>".$lh->Header2."</td>
				  <td class='kotak'>".$lh->Jenis1."</td>
				  </tr>\n";
		}
	echo "</body></table><hr>\n";
		$zlb->section('subneraca');
		$zlb->aksi(false);
		$zlb->icon();
		$zlb->sub_total(false);
		$zlb->sub_total_field('stock,blokstok');
		$zlb->Header('100%','SubTable');
	echo "</body></table>\n";
}else{
	no_auth();
}
panel_multi_end();
panel_end();
auto_sugest();

?>
