// JavaScript Document
$(document).ready(function(e) {
	var path=$('#path').val();
	var prs=$('#prs').val();
		$('#settingneraca').removeClass('tab_button');
		$('#settingneraca').addClass('tab_select');
	$('table#panel tr td:not(.flt,.plt,#kosong)').click(function(){
		var id=$(this).attr('id');
				$('#'+id).removeClass('tab_button');
				$('#'+id).addClass('tab_select');
				$('table#panel tr td:not(#'+id+',.flt,.plt)').removeClass('tab_select');
				$('table#panel tr td:not(#'+id+',#kosong,.flt,.plt)').addClass('tab_button');
				$('span#v_'+id).show();
				$('span:not(#v_'+id+')').hide();
				//$('#prs').val(id);
	})
	
	$('#SubTable').hide()
	$('#SubSHU').hide()
	$('#ListTable').fixedHeader({width:(screen.width-350),height:200/*(screen.height-320)*/})
	$('#HeadSHU').fixedHeader({width:(screen.width-350),height:140/*(screen.height-320)*/})
	show_detail_shu('8-2');
	$('#aktif').val('8')
	$('#calc').val('2');
	$('#saved-add').click(function(){
		$.post('set_head_shu',{
			'ID'		:$('#frm1 #ID').val(),
			'ID_Calc'	:$('#frm1 #ID_Head').val(),
			'ID_KBR'	:$('#frm1 #ID_KBR').val(),
			'ID_USP'	:$('#frm1 #ID_USP').val(),
			'jenis'		:$('#frm1 #jenis').val(),
			'ID_Head'	:'0'
		},function(result){
			$('#frm1 :reset').click();
			keluar_headshu();
			document.location.reload();
		})
	})
	$('#frm1 :reset').click(function(){
		keluar_headshu();
	})
	$('#frm2 :reset').click(function(){
		keluar_subshu();
	})
	$('#saved-addsub').click(function(){
		$.post('set_sub_shu',{
			'ID'		:$('#frm2 #ID_Sub').val(),
			'ID_Lap'	:$('#frm2 #ID_Lap').val(),
			'ID_Calc'	:$('#frm2 #ID_Calc').val(),
			'ID_Jenis'	:$('#frm2 #ID_Jenis').val(),
			'ID_KBR'	:$('#frm2 #ID_KBR').val(),
			'ID_USP'	:$('#frm2 #ID_USP').val(),
			'jenis'		:$('#frm2 #SubJenis').val()
		},function(result){
			$('#frm2 :reset').click();
			keluar_subshu();
			show_detail_shu($.trim(result))
		})
		
	})
	$('#addHead').click(function(){
		$('#pp-headshu').css({'left':'20%','top':'20%'});
			$('#frm1 :reset').click()
			$('#lock').show()
			$('#pp-headshu').show('slow');
	})
	$('#addSub').click(function(){
		$('#pp-subshu').css({'left':'20%','top':'20%'});
		$('#frm2 :reset').click()
		$('#frm2 #ID_Jenis').val($('#aktif').val()).select();
		$('#frm2 #ID_Lap').val('2').select();
		$('#frm2 #ID_Calc').val($('#calc').val()).select();
			$('#lock').show()
			$('#pp-subshu').show('slow');
	})
})

function show_detail(id){
	$('#ListTable_body_container #ListTable tbody tr#c-'+id).addClass('list_genap');
	$('#ListTable_body_container #ListTable tbody tr:not(#c-'+id+')').removeClass('list_genap');
	$.post('get_subneraca',{'ID':id},
		function(result){
			$('#SubTable tbody').html(result);
			$('#SubTable').fixedHeader({width:(screen.width-350),height:(screen.height-500)})
			$('#SubTable').show()
		})
}
function show_detail_shu(id){
	var idd=id.split('-')
	$('#aktif').val(idd[0]);
	$('#calc').val(idd[1]);
	$('#HeadSHU_body_container #HeadSHU tbody tr#c-'+idd[0]).addClass('list_genap');
	$('#HeadSHU_body_container #HeadSHU tbody tr:not(#c-'+id[0]+')').removeClass('list_genap');
	$.post('get_subneraca',{'ID':idd[0]},
		function(result){
			$('#SubSHU tbody').html(result);
			$('#SubSHU').fixedHeader({width:(screen.width-350),height:(screen.height-450)})
			$('#SubSHU').show()
		})
}

function images_click(id,aksi){
	var idd=id.split('-');
	if(idd[0]=='H'){
		switch(aksi){
			case 'edit':
				$('#pp-headshu').css({'left':'20%','top':'20%'});
				$.post('get_head_shu',{'ID':idd[1]},
				function(result){
					var hsl=$.parseJSON(result)
					$('#frm1 #ID_Head').val(hsl.ID_Calc).select()
					$('#frm1 #ID_KBR').val(hsl.ID_KBR)
					$('#frm1 #ID_USP').val(hsl.ID_USP)
					$('#frm1 #jenis').val(hsl.Jenis1)
					$('#frm1 #ID').val(idd[1]);
					
				})
				$('#lock').show()
				$('#pp-headshu').show('slow');
			break;
			case 'del':
			 if(confirm('Yakin data ini akan dihapus?')){
				$.post('del_head_shu',{'ID':idd[1]},
				function(result){
					document.location.reload();
				})
			 }
			break;
		}
	}else{
		switch(aksi){
			case 'edit':
				$('#pp-subshu').css({'left':'20%','top':'20%'});
				$.post('get_subjenis_shu',{
					'ID'	:idd[1]},
					function(result){
						var hsl=$.parseJSON(result)
						$('#frm2 #ID_Jenis').val(hsl.ID_Jenis).select()
						$('#frm2 #ID_Lap').val(hsl.ID_Lap).select()
						$('#frm2 #ID_Calc').val(hsl.ID_Calc).select()
						$('#frm2 #ID_KBR').val(hsl.ID_KBR)
						$('#frm2 #ID_USP').val(hsl.ID_USP)
						$('#frm2 #SubJenis').val(hsl.SubJenis)
						$('#frm2 #ID_Sub').val(idd[1]);
					})
				$('#lock').show()
				$('#pp-subshu').show('slow');
			break;
			case 'del':
			 if(confirm('Yakin data ini akan dihapus?')){
				$.post('del_sub_shu',{'ID':idd[1]},
				function(result){
					show_detail_shu($('#aktif').val())
				})
			 }
			break;
		}
	}
}