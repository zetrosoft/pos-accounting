<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
panel_multi('stockoverview','block',false);
if($v_stockoverview!=''){
	$zfm->AddBarisKosong(true);
	$zfm->Start_form(true,'frm1');
	$zfm->BuildForm('stokoverview',false,'50%');
	echo "<hr>";
		$zlb->section('stokoverlist');
		$zlb->aksi(false);
		$zlb->icon();
		$zlb->Header('60%','stoked');
	echo "</tbody></table>";
}else{ no_auth();}
panel_multi_end();

?>