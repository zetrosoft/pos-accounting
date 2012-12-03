// JavaScript Document
$(document).ready(function(e) {
	var path=$('#path').val();
    $('#perkiraan').removeClass('tab_button');
    $('#perkiraan').addClass('tab_select');
	$('table#panel tr td').click(function(){
		var id=$(this).attr('id');
				$('#'+id).removeClass('tab_button');
				$('#'+id).addClass('tab_select');
				$('table#panel tr td:not(#'+id+',.flt,.plt)').removeClass('tab_select');
				$('table#panel tr td:not(#'+id+',#kosong,.flt,.plt)').addClass('tab_button');
				$('span#v_'+id).show();
				$('span:not(#v_'+id+')').hide();
				$('#prs').val(id);
				if(id=='addperkiraan'){
					$('#frm1 :reset').click();
				}
	})
	read_dir();
	get_bulan('#dari_bln','1');
	get_bulan('#sampai_bln','');
	get_tahun('#thn');
	$('#proses').click(function(){
		create_backup('','acc');
		create_backup('','')
	})
})

	function get_bulan(field,pos){
		var path=$('#path').val();
		$.post(path+'akuntansi/get_bulan',{'id':pos},function(result){
			$(field).html(result)
		})
	}

	function get_tahun(field){
		var path=$('#path').val();
			$.post(path+'akuntansi/get_tahun',{'id':''},function(result){
				$('#thn').html(result)
			})
	}
	
	function create_backup(tabel,jenis){
		show_indicator('newTable',4);
		$.post('back_up_db',{
			'bln'	:$('#dari_bln').val(),
			's_bln'	:$('#sampai_bln').val(),
			'thn'	:$('#thn').val(),
			'Tabel'	:tabel,
			'jenis'	:jenis},
			function (result){
				$('table#newTable thead tr td#jdl').html('List Backup File    '+result)
				read_dir()
			})
/**/		
	}
	function read_dir(){
	 $.post('read_dir',{'id':''},
	 function(result){
		$('table#newTable tbody').html(result); 
	 })
	}
	
	function images_click(id,aksi){
		switch(aksi){
			case 'edit':
			$.post('download_file',{
				'fname':id},
				function(result){
					
				})
			break;
		}
	}
	
	
	
	