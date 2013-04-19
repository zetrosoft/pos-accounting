<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$zfm=new zetro_frmBuilder('asset/bin/zetro_member.frm');
$zlb=new zetro_buildlist();
$zlb->config_file('asset/bin/zetro_member.frm');
calender();
link_js('jquery.fixedheader.js,zetro_number.js','asset/js,asset/js');
tab_head('Member Detail',"style='background:#333'");
panel_multi('memberdata','none',false);
echo "<table width='100%' border='0'>
	<tr valign='top'><td width='45%'>";
		$zfm->Addinput("<input type='hidden' id='idne' name='idne' value='$kunci'/><input type='hidden' id='Photolink' name='Photolink' value=''/>");
		$zfm->AddBarisKosong(false);
		$zfm->Start_form(true,'frm1');
		$zfm->BuildForm('registrasi',false,'100%');
echo "</td><td width='5%'>&nbsp;</td>
	 <td width='50%'>";
	 $zfm->Addinput("");
		$zfm->AddBarisKosong(false);
		$zfm->Start_form(true,'frm2');
		$zfm->BuildForm('biodata',false,'100%');
echo"<hr><div id='pic' style='height:350px; border:1px inset #FFF'>
	<img src='' id='photone' width='500px' height='350px'></div>";
echo "</td></tr>
	 </table>
		<hr>
		<div id='btn' style='width:90%; border:0px outset #CCC;padding:5px; padding-right:20px' align='right'>
		<span id='rst'></span>
		<input type='button' id='update_b' value='Update Data'>
		<input type='button' id='cetak_b' value='Cetak'>
		<input type='button' id='keluar_b' value='Tutup'></div>";
panel_multi_end();
panel_multi('membertrans','block',false);
addText(array('No. Anggota','Nama Lengkap','Department','','',''),
		array("<input type='text' id='no_anggota' readonly value='$no_anggota'>",
			  "<input type='text' id='nm_anggota' readonly value='$nm_anggota'>",
			  "<input type='text' id='id_department' readonly value='$id_department' size='30'>",
			  "","<input type='button' id='cetak' value='Cetak'>",
				"<input type='button' id='keluar' value='Tutup'>"));
		$zlb->section('detail');
		$zlb->aksi(false);
		$zlb->Header('90%','detail_tbl');
		$zlb->icon();
		$n=0;
		foreach($transaksi->result() as $trn){
			$n++;$sAkhir=0;
			$sAkhir=($trn->ID_Calc=='1')?($trn->SaldoAwal+$trn->Debet-$trn->Kredit):($trn->SaldoAwal+$trn->Kredit-$trn->Debet);
			echo "<tr class='xx' id='t-".$trn->ID."' align='center' onclick=\"get_detail_trans('".$trn->ID."');\">
				  <td class='kotak'>$n</td>
				  <td class='kotak'>".$trn->Kode."</td>
				  <td class='kotak' align='left'>".$trn->Jenis."</td>
				  <td class='kotak' align='right'>".number_format($trn->SaldoAwal,2)."</td>
				  <td class='kotak' align='right'>".number_format($trn->Debet,2)."</td>
				  <td class='kotak' align='right'>".number_format($trn->Kredit,2)."</td>
				  <td class='kotak' align='right'>".number_format($sAkhir,2)."</td>
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
		<span id='loading' style='display:none'><img src='".base_url()."asset/images/indicator.gif'>Data being process... please wait!</span> &nbsp;&nbsp;
		<input type='hidden' id='kunci' value='$kunci' />
		<input type='hidden' id='kunci_cetak' value='' /></div>";
panel_multi_end();
tab_head_end();
popup_start('preview',"Print Preview",800);

popup_end();
?>

<input type='hidden' id='id_jenis' value='' />

<script language="javascript">
var path='<?=base_url();?>';
$(document).ready(function(e) {
	ab=path.replace('index.php/','');
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
							$('#Photolink').val(obj.PhotoLink);
							$('#frm2 #TanggalMasuk')
								//.error(function(){})
								.val((obj.TanggalMasuk=='null')?'':tglFromSql(obj.TanggalMasuk))
								//.attr('readonly','readonly')
							$('#frm2 #TanggalKeluar')
								//.error(function(){	})
								.val((obj.TanggalKeluar=='null')?'':tglFromSql(obj.TanggalKeluar))
								//.attr('readonly','readonly')
							
							$('img#photone')
								.error(function(){
									//alert(photo);
									$(this).attr('src',ab+'uploads/member/images.jpg')
								})
								.attr('src',ab+'uploads/member/'+obj.PhotoLink)})
								
						lock('#cetak');
				}else{
					unlock('#cetak');
				}
	})
    //show simpanan pokok detail
	$('#TanggalMasuk')
	.keyup(function(){
		tanggal(this)
	})
	$('#TanggalKeluar').keyup(function(){
		tanggal(this)
	})		
	get_detail_trans('1');
	//create table scroll with header fix
	$('#detail_tbl').fixedHeader({width:(screen.width-50),height:150})

	$('#cetak').click(function(){
		$('span#loading').css('display','');
		var id=$('#kunci_cetak').val();
		var jn=$('#kunci').val();
		$.post('member_print',{
			'ID_Agt':jn,
			'ID_Jenis':id,
			'nm_angg':$('#nm_anggota').val(),
			'nm_dept':$('#id_department').val()},
		function(result){
			$('#pp-preview').css({'left':'10%','top':'5%','max-height':'550px'})
			$('#tbl-preview').css({'height':'500px'});
			$('#tbl-preview').html('<iframe src="<?=base_url();?>application/logs/<?=$this->session->userdata('userid');?>_saldo_personal.pdf" height="100%" width="100%" frameborder="0" allowtransparency="1"></iframe>')
			$('#pp-preview').show();
			$('#lock-preview').show()
			$('span#loading').css('display','none');
		})
	})
	$('#keluar').click(function(){
		$('#mm_lock').hide();	
		$('#mm_detail').hide();
	})
	$('#keluar_b').click(function(){
		$('#mm_lock').hide();	
		$('#mm_detail').hide();
	})
	$('#update_b').click(function()
	{
		update_data();
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
	$('#id_jenis').val(id);
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
function update_data()
{
	$.post('set_anggota',$('#frm1').serialize()+'&'+$('#frm2').serialize(),
	function(result)
	{
		$('span#rst').html(result).show().fadeOut(5000);
	})
}
</script>
