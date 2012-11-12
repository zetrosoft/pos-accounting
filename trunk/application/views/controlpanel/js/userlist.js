// JavaScript Document
$(document).ready(function(e) {
	var path=$('#path').val();
	var prs=$('#prs').val();
	($('#otor').val()=='disabled')? $('#nm_group').attr('disabled','disabled'):	$('#nm_group').removeAttr('disabled');  
   	$('#frm2 select#nm_group').val($('#uea').val()).select();
    $('#listuser').removeClass('tab_button');
	$('#listuser').addClass('tab_select');
	$('table#panel tr td').click(function(){
		var id=$(this).attr('id');
			$('#'+id).removeClass('tab_button');
			$('#'+id).addClass('tab_select');
			$('table#panel tr td:not(#'+id+')').removeClass('tab_select');
			$('table#panel tr td:not(#'+id+',#kosong)').addClass('tab_button');
			$('span#v_'+id).show();
			$('span:not(#v_'+id+')').hide();
			$('#prs').val(id);
				if(id=='adduser'){
					$('#frm1 #userid').focus().select();
				}

	});
	//$('#v_listuser table#ListTable thead th:nth-child(5)').hide();
	//$('#v_listuser table#ListTable tbody td:nth-child(5)').hide();
	//$('#v_listuser table#ListTable tbody td:nth-child(5)').html('');
	
	//tab authorisation
	//tab_modul
	$('table#tab tr td:first').removeClass('tab_button');
	$('table#tab tr td:first').addClass('tab_select');
		$('table#tab tr td:first').click();
		get_data_menu($('table#tab tr td:first').html(),$('#nm_group').val());
		
	//group select click
	$('#nm_group').change(function(){
		$('table#tab tr td:first').click();
		get_data_menu($('table#tab tr td:first').html(),$(this).val());
	})
	$('table#tab tr td').click(function(){
		var id=$(this).attr('id');
		var mn=$(this).html();
		$('table#tab tr td#'+id).removeClass('tab_button');
		$('table#tab tr td#'+id).addClass('tab_select');
		$('table#tab tr td:not(#'+id+')').removeClass('tab_select');
		$('table#tab tr td:not(#'+id+',#kosong)').addClass('tab_button');
		get_data_menu(mn,$('#nm_group').val())
	})
	//tab adduser
	
	$('#frm1 #userid')
		.keyup(function(){
			pos_div(this);
			auto_suggest2('get_userid',$(this).val(),$(this).attr('id')+'-frm1');
		})
		.focus().select();
	$(':button').click(function(){
		var id=($(this).attr('id'));
		//alert(id)
		switch(id){
			case 'saved-userlist':
			//alert(id)
				var userid		=$('#frm1 #userid').val();
				var username	=$('#frm1 #username').val();
				var userlevel	=$('#frm1 #idlevel').val();
				var userpwd		=$('#frm1 #password').val();
				$.post('simpan_newuser',{
					'userid'	:userid,
					'username'	:username,
					'idlevel'	:userlevel,
					'password'	:userpwd
					},function(result){
						$('#v_listuser table#ListTable tbody').html(result);
						$(':reset').click();
						})
				break;
			case 'add-idlevel':
				var pos=$(this).offset();
				var l=pos.left+5;
				var t=pos.top+24;
				$('#pp-adduserlevel').css({'left':l,'top':t});
				$('#nama').val('adduserlevel');
				$('#lock').show();
				$('#pp-adduserlevel').show('slow');
				$('#frm3 #idlevel').val('0');
				$('#frm3 #idlevel').attr('disabled','disabled');
				$('#frm3 #nmlevel').focus().select();
			break;
			case 'saved-addlevel':
				$.post('simpan_newlevel',{'nmlevel':$('#frm3 #nmlevel').val()},
					function(result){
						$('#frm1 #idlevel').html(result);
						$('#frm3 input:reset').click();
						keluar();
					})
			break;
			case 'saved-edited':
			$('#frm4 #userid').removeAttr('disabled')
				var userid		=$('#frm4 #userid').val();
				var username	=$('#frm4 #username').val();
				var userlevel	=$('#frm4 #idlevel').val();
				var userpwd		=$('#frm4 #password').val();
				$.post('set_userupdate',{
					'userid'	:userid,
					'username'	:username,
					'idlevel'	:userlevel,
					'password'	:userpwd
					},function(result){
						$('#v_listuser table#ListTable tbody').html(result);
						$('#frm4 :reset').click();
						keluar();
						})
			break;
		}
	})
	$('img.close').click(function(){
		keluar()
	})
		
		
})

//function support

//function checkbok on click
function mnu_onClick(tp,id){
	var path=$('#path').val();
	var nm=$('span#v_authorisation div#v_panel table#usrmenu tbody  tr td input:checkbox#'+tp+'-'+id).is(':checked')
		var grp=$('#frm2 #nm_group').val();
		(nm)?st='Y':st='N';
			$.post('useroto_update',{'userid':grp,'stat':st,'idmenu':id,'idfld':tp},
				function(result){
					//alert(result);
				})
}

function get_data_menu(mn,uid){
		$.post('get_data_menu',{'section':mn,'nm_group':uid},
			function(result){
				$('div#v_panel table#usrmenu tbody').html(result);
			})
}

//callback autosuggest
function on_clicked(id,fld,frm){
	alert(id+' sudah ada, Silahkan gunakan user id yang lain');	
}

function image_click(id,cl){
	id=id.split('-')
	switch(cl){
		case 'edit':
				$('#pp-edituser').css({'left':'25%','top':'20%'});
				$('#nama').val('edituser');
				$('#lock').show();
				$('#pp-edituser').show('slow');
				$('#frm4 #userid')
					.val(id[1])
					.attr('disabled','disabled')
				$('#frm4 #add-idlevel').attr('disabled','disabled');
				$.post('get_datauser',{'userid':id[1]},
					function(result){
						var obj=$.parseJSON(result);
						$('#frm4 #username').val(obj.username);
						$('#frm4 #idlevel').val(obj.idlevel).select();
						$('#frm4 #password')
							.val(obj.password)
							.attr('disabled','disabled');
					})
		break;
		case 'del':
		if(confirm("Yakin data ini akan di hapus?")){
			$.post('hapus_user',{'userid':id[1]},
				function(result){
				$('#v_listuser table#ListTable tbody tr#nm-'+id[1]).remove();
				})
		}
		break	
	}
}
//popup handle
	function keluar(){
		var nama=$('#nama').val();
		$('.autosuggest').hide();
		$('#pp-'+nama).hide('slow');
		$('#kekata').hide();
		$('#lock').hide();
	}
