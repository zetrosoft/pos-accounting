<?php
$zfm=new zetro_frmBuilder('asset/bin/zetro_member.frm');
$zlb=new zetro_buildlist();
$section='Barang';
$zlb->config_file('asset/bin/zetro_member.frm');
$path='application/views/member';
link_css('jquery.coolautosuggest.css','asset/css');
link_js('jquery.coolautosuggest.js,member.js','asset/js,'.$path.'/js');
link_js('ajaxupload.js','asset/js');
!empty($panel)?$panel=$panel:$panel='';
tab_select($panel);
panel_begin('Registrasi');
panel_multi('anggotabaru','block',false);
if($all_anggotabaru!=''){
	$zfm->AddBarisKosong(true);
	$zfm->Start_form(true,'frm1');
	$zfm->BuildForm('registrasi',true,'50%');
	$zfm->BuildFormButton('Simpan','registrasi');
}else{
	no_auth();
}
panel_multi_end();
panel_multi('uploadphoto','none',false);
if($all_auploadphoto!=''){
!empty($upload_data['file_name'])?$img=$upload_data['file_name']:$img='images.jpg';
!empty($d_photo)?$dv=$d_photo:$dv='none';
!empty($nourut)?$nourut=$nourut:$nourut='';
!empty($nama)?$nama=$nama:$nama='';
!empty($nip)?$nip=$nip:$nip='';
$fld="<input type='hidden' id='gambar' name='gambar' value='$img'>";
$fld.="<input type='hidden' id='nourut' name='nourut'  name='nourut' value='$nourut'>";
$fld.="<input type='hidden' id='namane' name='namane' value='$nama'>";
$fld.="<input type='hidden' id='nipe'  name='nipe' value='$nip'>";
	echo "<table width='100%'>
		<tr valign='top'><td width='45%'>";
	echo form_open_multipart('member/do_upload',"id='frm2' name='frm2'");
	$zfm->Addinput("");
	$zfm->AddBarisKosong(true);
	$zfm->Start_form(false,'frm2');
	$zfm->BuildForm('upload',true,'100%');
	$zfm->BuildFormButton('Upload','upload','submit');
	echo $fld."</form></td><td width='55%'>";
	?><div align='center' id='photo' style='width:98%; height:100%;border:0px solid #F90; display:<?=$dv;?>'>
    	<? echo (empty($error))? "<img id='thumb' src='".base_url()."uploads/member/$img' style='max-width:550px; max-height:400px'/>":$error;
		?>
        <p><input type="button" id='s_photo' value='Simpan' />
        <input type="button" id='c_photo' value='Cancel' /></p><p></p>
        </div>
		<?
        
	echo "</td></tr></table>";
}else{
	no_auth();
}
panel_multi_end();
panel_end();
auto_sugest();

?>