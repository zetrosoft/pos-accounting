// JavaScript Document
$(document).ready(function(e) {
    $('#departemen').removeClass('tab_button');
    $('#departemen').addClass('tab_select');
	$('table#panel tr td').click(function(){
		var id=$(this).attr('id');
				$('#'+id).removeClass('tab_button');
				$('#'+id).addClass('tab_select');
				$('table#panel tr td:not(#'+id+',.flt,.plt)').removeClass('tab_select');
				$('table#panel tr td:not(#'+id+',#kosong,.flt,.plt)').addClass('tab_button');
				$('span#v_'+id).show();
				$('span:not(#v_'+id+')').hide();
				$('#prs').val(id);
	})
	_get_ID();
	_show_data(); //generate data klasifikasi
	$('#frm1 #saved-klasifikasi').click(function(){
		var Kode=$('#ID').val();
		var Klas=$('#Departemen').val();
		var ID	=$('#ID_A').val();
		$.post('set_departemen',{
			'Kode'	:Kode,
			'Klas'	:Klas,
			'ID'	:ID,
			'Title'	:$('#Title').val()
		},function(result){
			$(':reset').click();
			_show_data();
		})
	})
});

function _get_ID(){
	$.post('get_dept_ID',{'ID':"order by ID desc limit 1"},
		function(result){
			var rst=$.parseJSON(result)
			var newID=rst.ID;
			$('#ID_A').val(parseFloat(newID)+1);
		})
}
function _show_data(){
	$.post('get_departemen','',
		function(result){
			$('table#ListTable tbody').html(result);
			$('#ID').val('');$('#Departemen').val('')
			$('table#ListTable').fixedHeader({width:(screen.width-150),height:(screen.height-400)})
		})
}

function img_onClick(id,tipe){
	switch(tipe){
		case 'edit':
			$.post('get_dept_ID',{'ID':"where ID='"+id+"'"},
			 function(result){
				var rst=$.parseJSON(result) 
				$('#ID_A').val(rst.ID);
				$('#ID').val(rst.Kode);
				$('#Departemen').val(rst.Departemen);
				$('#Title').val(rst.Title);
			 })
		break;
		case 'del':
		$.post('check_status_Klas',{'ID':id},
		function(result){
			if($.trim(result)=='dipakai'){
				alert('Data akun ini tidak bisa di hapus\nSudah dipakai untuk relasi di Data Perkiraan');
			}else if($.trim(result)=='hapus'){
				if(confirm('Yakin Data Klasifikasi ini akan dihapus???')){
					$.post('hapus_akun',{'ID':id,'sumber':'Klasifikasi'},
					function(result){
						_show_data()
					})
				}
			}
		})
		break;	
	}
}