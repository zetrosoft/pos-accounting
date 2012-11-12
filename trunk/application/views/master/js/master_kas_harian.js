// JavaScript Document
$(document).ready(function(e) {
    $('#operasionaltoko').removeClass('tab_button');
	$('#operasionaltoko').addClass('tab_select');
	$('table#panel tr td').click(function(){
		var id=$(this).attr('id');
			if(id!=''){
				$('#'+id).removeClass('tab_button');
				$('#'+id).addClass('tab_select');
				$('table#panel tr td:not(#'+id+',.flt)').removeClass('tab_select');
				$('table#panel tr td:not(#'+id+',#kosong,.flt)').addClass('tab_button');
				$('span#v_'+id).show();
				$('span:not(#v_'+id+')').hide();
				
			}
	})
	$('#saved-kaskeluar').attr('disabled','disabled');
	_generate_nomor($('#trans_new').val(),'#frm2 input#no_transaksi')
	tglNow('#frm1 #tgl_kas');
	tglNow('#frm2 #tgl_transaksi');
	$('#frm1 #nm_kas').attr('disabled','disabled')
	$('#frm2 #no_transaksi').attr('disabled','disabled')
	//setup saldo kas
	$('#frm1 #tgl_kas')
		.click(function(){
			$(this).focus().select();
			
		})
		.dblclick(function(){
			tglNow('#frm1 #tgl_kas');
		})
		.keyup(function(){
			tanggal(this)
		})
		.keypress(function(e){
			if(e.keyCode==13){
				$('#frm1 #id_kas').focus().select();
			}
		})
	$('#frm1 #id_kas')
		.click(function(){
			auto_suggest3('get_datakas',$(this).val(),$(this).attr('id')+'-frm1');
			pos_div('#frm1 #id_kas');
		})
	$('#frm1 #sa_kas')
		.click(function(){
			$(this).focus().select();
		})
		.keyup(function(){
			pos_info(this,'terbilang');
			$(this).terbilang({'output_div':'terbilang'});
		})
		.keypress(function(e){
			if(e.which==13){
				$('#frm1 #saved-kas').focus();
				$(this).focusout();
			}
		})
		.focusout(function(){
			$('#terbilang').hide();
		})
		
	//transaksi pengeluaran kas
	$('#frm2 #tgl_transaksi')
		.click(function(){
			$(this).focus().select();
			
		})
		.dblclick(function(){
			tglNow('#frm2 #tgl_transaksi');
		})
		.keyup(function(){
			tanggal(this)
		})
		.keypress(function(e){
			if(e.keyCode==13){
				$('#frm1 #akun_transaksi').focus().select();
			}
		})
	$('#frm2 #akun_transaksi')
		.click(function(){
			pos_div('#frm2 #akun_transaksi');
			auto_suggest3('get_datakas',$(this).val(),$(this).attr('id')+'-frm2');
		})
		
	$('#frm2 #jml_transaksi')
		.click(function(){
			$(this).focus().select();
		})
		.keyup(function(){
			pos_info(this,'terbilang');
			$(this).terbilang({'output_div':'terbilang'});
		})
		.keypress(function(e){
			if(e.which==13){
				$('#frm2 #saved-kaskeluar').focus();
				$(this).focusout();
			}
		})
		.focusout(function(){
			$('#terbilang').hide();
		})
	
	$(':button').click(function(){
		var id=$(this).attr('id')
		$('#frm1 #nm_kas').removeAttr('disabled');
		switch(id){
			case 'saved-kas':
				$.post('simpan_kas_harian',{
					'tgl_kas'	:$('#frm1 #tgl_kas').val(),
					'id_kas'	:$('#frm1 #id_kas').val(),
					'nm_kas'	:$('#frm1 #nm_kas').val(),
					'sa_kas'	:$('#frm1 #sa_kas').val()
				},function(result){
					$('#frm1 :reset').click();
					tglNow('#frm1 #tgl_kas');
					$('#v_setupsaldokas table#ListTable tbody').html(result);
       				$('#v_setupsaldokas table#ListTable').fixedHeader({width:700, height:250})
        
				})
			break;
			case 'saved-kaskeluar':
				$.post('simpan_kas_keluar',{
					'tgl_transaksi'	:$('#frm2 #tgl_transaksi').val(),
					'no_transaksi'	:$('#frm2 #no_transaksi').val(),
					'ket_transaksi'	:$('#frm2 #ket_transaksi').val(),
					'harga_beli'	:$('#frm2 #harga_beli').val(),
					'akun_transaksi':$('#frm2 #akun_transaksi').val(),
					'jtran'			:$('#trans_new').val(),
					'tipe'			:$('#trans_new').val()
				},function(result){
					$('#frm2 :reset').click();
					_generate_nomor($('#trans_new').val(),'#frm2 input#no_transaksi')
					$('#v_operasionaltoko table#ListTable tbody').html(result);
					tglNow('#frm2 #tgl_transaksi');
					$('#v_operasionaltoko table#ListTable').fixedHeader({width:850, height:250})
					$('#frm2 #ket_transaksi').val('')
					$('#frm2 #harga_beli').val('')
					$('#frm2 #akun_transaksi').val('')
					$('#trans_new').val('D');
					lock('#saved-kaskeluar');
				})
			break;	
		}
	})
})

function on_clicked(clicked,id,frm){
	switch(id){
		case 'id_kas':
		$.post('get_datailkas',{'id_kas':clicked},
			function(result){
			 var obj=$.parseJSON(result)
				$('#frm1 #nm_kas').val(obj.nm_kas);	
				$('#frm1 #sa_kas').val(obj.sa_kas);	
			})
		break;
		case 'akun_transaksi':
		unlock('#saved-kaskeluar');
		$('#frm2 #ket_transaksi').focus().select();
		break;
	}
}
	function _generate_nomor(tipe,field){
		var path=$('#path').val();
		$.post(path+'penjualan/nomor_transaksi',{'tipe':tipe},
		function(result){
			$(field).val(result);
			$('#trans_new').val('D');
		})
	}

function image_click(id,cl){
	var id=id.split('-');
	switch(cl){
	  case 'del':
				 var no_transaksi	=$('#v_operasionaltoko table#ListTable tr#nm-'+id[1]+' td:nth-child(2)').html();
				 var tgl_transaksi	=$('#v_operasionaltoko table#ListTable tr#nm-'+id[1]+' td:nth-child(3)').html();
				 var akun_transaksi	=$('#v_operasionaltoko table#ListTable tr#nm-'+id[1]+' td:nth-child(4)').html();
				 var ket_transaksi	=$('#v_operasionaltoko table#ListTable tr#nm-'+id[1]+' td:nth-child(5)').html();
				 var jml_transaksi	=$('#v_operasionaltoko table#ListTable tr#nm-'+id[1]+' td:nth-child(6)').html();
					$('#trans_new').val('DR');
					//$('#frm2 #no_transaksi').val(no_transaksi);
					$('#frm2 #tgl_transaksi').val(tgl_transaksi);
					$('#frm2 #akun_transaksi').val(akun_transaksi);
					$('#frm2 #ket_transaksi').val(ket_transaksi+'-cancel transaksi');
					$('#frm2 #harga_beli').val(to_number(jml_transaksi.substr(0,(jml_transaksi.length-3))));
	  $('#saved-kaskeluar').click();
	}
}