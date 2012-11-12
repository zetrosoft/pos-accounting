<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$zfm=new zetro_frmBuilder('asset/bin/zetro_member.frm');
$zlb=new zetro_buildlist();
$zn=new zetro_manager();
$section='listanggota';
$zlb->config_file('asset/bin/zetro_member.frm');
$path='application/views/member';
$dept="<select id='dept' name='dept'></select>";
$stat="<select id='stat' name='stat'>
		<option value='all' selected>Semua</option>
		<option value='1'>Aktif</option>
		<option Value='2'>Non Aktif</option>
		<option Value='3'>Keluar</option>
		</select>";
link_css('style.css','asset/js');
link_js('jquery.fcbkcomplete.js','asset/js');
link_js('jquery.fixedheader.js,member_list.js','asset/js,'.$path.'/js');
panel_begin('Keanggotaan','','Department :,'.$dept.', &nbsp;&nbsp;Keaktifan :'.$stat,",Total Data : <span id='td'></span>");
panel_multi('daftaranggota','block');
if($all_daftaranggota!=''){
addText(array('Susun Urutan ','','Cari Berdasarkan Nama :'),
		array(
			  "<select id='urutan'>
				<option value='no_Agt' selected='selected'>No Anggota</option>
				<option value='Nama'>Nama Anggota</option>
				<option value='NIP'>NIP Anggota</option>
				<option value='id_Dept'>Department</option>
				<option value='status_anggota'>Keaktifan</option>
				</select>",
			  "<input type='button' value='Go' id='gon'>",
			  "<div style='border:1px solid #DDD; background:#FFF'>
			  <input type='text' id='carix' value='' style='border:none'>
			  <img src='".base_url()."asset/img/Icon_210.ico' id='cari' style='cursor:pointer'></div>"));
	$n=0;
		$zlb->section($section);
		$zlb->aksi(false);
		$zlb->Header('100%');
		$zlb->icon();
		echo "</tbody></table>";
}else{
	no_auth();
}
panel_multi_end();
loading_ajax();
popup_full();
?>
<input type='hidden' id='ordby' value='' class='w100'/>
<input type='hidden' id='totdata' value='<?=(!empty($list))?count($list):0;?>' />
<input type='hidden' id='otor' value='<?=$all_daftaranggota;?>' />
<script language="javascript">
	$(document).ready(function(e) {
		$('#dept').html("<option value='all'>Semua</option>");
        $('#dept').append("<? dropdown('mst_departemen','id','departemen',"order by Kode");?>")
		$('#dept').val('').select();
    });
</script>
