<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$zfm=new zetro_frmBuilder('asset/bin/zetro_member.frm');
$zlb=new zetro_buildlist();
$zlb->config_file('asset/bin/zetro_member.frm');
link_js('jquery.fixedheader.js,zetro_number.js','asset/js,asset/js');
tab_head('Member Detail',"style='background:#333'");
panel_multi('memberdata');
echo "<table width='100%' border='0'>
	<tr valign='top'><td width='45%'>";
		$zfm->AddBarisKosong(false);
		$zfm->Start_form(true,'frm1');
		$zfm->BuildForm('registrasi',false,'100%');
echo "</td><td width='5%'>&nbsp;</td>
	 <td width='50%'>";
		$zfm->AddBarisKosong(false);
		$zfm->Start_form(true,'frm2');
		$zfm->BuildForm('biodata',false,'100%');
echo"<hr><div id='pic' style='height:350px; border:1px inset #FFF'>
	<img src='' id='photone' width='500px' height='350px'></div>";
echo "</td></tr>
	 </table>
		<hr>
		<div id='btn' style='width:90%; border:0px outset #CCC;padding:5px; padding-right:20px' align='right'>
		<input type='button' id='update_b' value='Update Data'>
		<input type='button' id='cetak_b' value='Cetak'>
		<input type='button' id='keluar_b' value='Tutup'></div>";
panel_multi_end();
panel_multi('membertrans','block',false);
addText(array('No. Anggota','Nama Lengkap','Department'),
		array("<input type='text' id='no_anggota' readonly value='$no_anggota'>",
			  "<input type='text' id='nm_anggota' readonly value='$nm_anggota'>",
			  "<input type='text' id='id_department' readonly value='$id_department' size='40'>"));
		$zlb->section('detail');
		$zlb->aksi(false);
		$zlb->Header('90%','detail_tbl');
		$zlb->icon();
		$n=0;
		foreach($transaksi->result() as $trn){
			$n++;
			echo "<tr class='xx' id='t-".$trn->ID."' align='center' onclick=\"get_detail_trans('".$trn->ID."');\">
				  <td class='kotak'>$n</td>
				  <td class='kotak'>".$trn->Kode."</td>
				  <td class='kotak' align='left'>".$trn->Jenis."</td>
				  <td class='kotak' align='right'>".number_format($trn->SaldoAwal,2)."</td>
				  <td class='kotak' align='right'>".number_format($trn->Debet,2)."</td>
				  <td class='kotak' align='right'>".number_format($trn->Kredit,2)."</td>
				  <td class='kotak' align='right'>".number_format($trn->SaldoAkhir,2)."</td>
				  </tr>";
		}
		echo "</tbody></table><hr>";
		echo "<div id='loading' style='display:none'>Loading data in progress ...please wait. &nbsp;<img src='".base_url()."asset/img/indicator.gif'></div>";
		echo "<div id='dtl_trans' style='display:none'>";
		echo "<p style='color:#000'>Detail transaksi <span id='dtl'></span> :</p>";
		$zlb->section('DetailTrans');
		$zlb->aksi(false);
		$zlb->Header('100%','trans_tbl');
		$zlb->icon();
		$n=0;
		echo "</tbody></table></div>
		<hr>
		<div id='btn' style='width:90%; border:0px outset #FFF;padding:5px; padding-right:20px' align='right'>
		<input type='button' id='cetak' value='Cetak'>
		<input type='button' id='keluar' value='Tutup'>
		<input type='hidden' id='kunci' value='$kunci' />
		<input type='hidden' id='kunci_cetak' value='' /></div>";
panel_multi_end();
tab_head_end();

?>
<script language="javascript">
$(document).ready(function(e) {
	$('#mm_detail table#tab tr td:not(#kosong)').click(function(){
		var id=$(this).attr('id');
				$('#mm_detail table#tab tr td#'+id).removeClass('tab_button');
				$('#mm_detail table#tab tr td#'+id).addClass('tab_select');
				$('#mm_detail table#tab tr td:not(#'+id+',.flt,.plt)').removeClass('tab_select');
				$('#mm_detail table#tab tr td:not(#'+id+',#kosong,.flt,.plt)').addClass('tab_button');
				$('#mm_detail span#v_'+id).show();
				$('#mm_detail span:not(#v_'+id+')').hide();
				if(id=='memberdata'){
					$.post('member_biodata',{'no_anggota':$('#kunci').val()},
						function(result){
							var obj=$.parseJSON(result);
							$('#frm1 #No_Agt')
								.val(obj.No_Agt)
								.attr('readonly','readonly')
							$('#frm1 #ID_Dept').val(obj.ID_Dept).select();
							$('#frm1 #NIP').val(obj.NIP);
							$('#frm1 #Nama').val(obj.Nama);
							$('#frm1 #ID_Kelamin').val(obj.ID_Kelamin).select();
							$('#frm1 #Alamat').val(obj.Alamat);
							$('#frm1 #Kota').val(obj.Kota);
							$('#frm1 #Propinsi').val(obj.Propinsi);
							$('#frm1 #Telepon').val(obj.Telepon);
							$('#frm1 #Faksimili').val(obj.Faksimili);
							$('#frm1 #ID_Aktif').val(obj.ID_Aktif).select();
							$('#frm2 #TanggalMasuk')
								.error(function(){})
								.val((obj.TanggalMasuk=='null')?'':tglFromSql(obj.TanggalMasuk))
								.attr('readonly','readonly')
							$('#frm2 #TanggalKeluar')
								.error(function(){	})
								.val((obj.TanggalKeluar=='null')?'':tglFromSql(obj.TanggalKeluar))
								.attr('readonly','readonly')
							$('img#photone')
								.error(function(e){
									$(this).attr('src','<?=base_url();?>uploads/member/no_photo.jpg')
								})
								.attr('src','<?=base_url();?>uploads/member/'+obj.PhotoLink)
						})
				}
					
	})
    //show simpanan pokok detail
	get_detail_trans('1');
	//create table scroll with header fix
	$('#detail_tbl').fixedHeader({width:(screen.width-50),height:150})

	$('#cetak').click(function(){
		var id=$('#kunci_cetak').val();
	})
	$('#keluar').click(function(){
		$('#mm_lock').hide();	
		$('#mm_detail').hide();
	})
	$('#keluar_b').click(function(){
		$('#mm_lock').hide();	
		$('#mm_detail').hide();
	})

});

function get_detail_trans(id){
	$('div#dtl_trans').hide();
	$.post('get_nama_simpanan',{'id':id},
		function(result){
			$('span#dtl').html('<strong>'+result+'</strong>');
		})
	$('#kunci_cetak').val(id);
	$('#loading').show();
	var k=$('#kunci').val();
	$.post('member_detail_trans',{
		'ID_Jenis'	:id,
		'ID_Agt'	:k
	},
		function(result){
			$('table#trans_tbl tbody').html(result);
			$('#trans_tbl').fixedHeader({width:(screen.width-150),height:195})
			$('#loading').hide();
			$('div#dtl_trans').show();
		})
}
function update(){
				var No_Agt		=$('#frm1 #No_Agt').val();
				var ID_Dept		=$('#frm1 #ID_Dept').val();
				var NIP			=$('#frm1 #NIP').val();
				var Nama		=$('#frm1 #Nama').val();
				var ID_Kelamin	=$('#frm1 #ID_Kelamin').val();
				var Alamat		=$('#frm1 #Alamat').val();
				var Kota		=$('#frm1 #Kota').val();
				var Propinsi	=$('#frm1 #Propinsi').val();
				var Telepon		=$('#frm1 #Telepon').val();
				var Faksimili	=$('#frm1 #Faksimili').val();
				var ID_Aktif	=$('#frm1 #ID_Aktif').val();
}
</script>
