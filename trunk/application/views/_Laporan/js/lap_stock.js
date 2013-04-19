$(document).ready(function(e) {
	var prs=$('#prs').val();
	$('table#panel tr td.flt').hide()
    $('#stocklist').removeClass('tab_button');
	$('#stocklist').addClass('tab_select');
	$('#v_stocklist table#ListTable').hide();
	$('table#panel tr td').click(function(){
		var id=$(this).attr('id');
			if(id!=''){
				$('#'+id).removeClass('tab_button');
				$('#'+id).addClass('tab_select');
				$('table#panel tr td:not(#'+id+',.flt)').removeClass('tab_select');
				$('table#panel tr td:not(#'+id+',#kosong,.flt)').addClass('tab_button');
				$('span#v_'+id).show();
				$('span:not(#v_'+id+')').hide();
				$('#prs').val(id);
					if(id!='stocklist'){
						$('table#panel tr td.flt').hide()//else if(id=='listobat'){
					}else{
						$('table#panel tr td.flt').show()
					}///$('table#panel tr td:not(#'+id+')')	
			}
	});

	$('#frm1 input#nm_barang')
		.keyup(function(){
			pos_div('#frm1 input#nm_barang');
			auto_suggest('data_material',$(this).val(),$(this).attr('id')+'-frm1');
		})
		.keypress(function(e){
			if(e.which==13 || e.which==27){
				$('.autosuggest').hide();
			}
		})
	$('#frm2 select#nm_jenis').change(function(){
		
	})
	$('#frm2 select#nm_kategori').change(function(){
		
	})
	$('#frm2 select#nm_golongan').change(function(){
		
	})
	$('#frm2 #saved-filter').click(function(){
		$('#frm2').attr('action','print_laporan_stock');
		document.frm2.submit();
	})
	$('#frm1 #saved-expired').click(function(){
		$('#frm1').attr('action','print_laporan_stock');
		document.frm1.submit();
	})
	$('#frm3 #saved-limit').click(function(){
		$('#frm3').attr('action','print_laporan_stock');
		document.frm3.submit();
	})
})

function on_clicked(id,fld,frm){
	switch(frm){
		case 'frm1':
		if(fld=='nm_barang'){
			$.post('data_hgb',{'nm_barang':id},
			function(result){
				var rst=$.parseJSON(result)
				$('#frm1 input#nm_jenis').val(rst.nm_jenis);
				$('#frm1 input#nm_kategori').val(rst.nm_kategori);
				$('#frm1 input#nm_golongan').val(rst.nm_golongan);
				$('#v_stockoverview table#ListTable').show();
				$.post('list_stock',{'nm_barang':id},
				function(result){
					$('#v_stockoverview table#ListTable tbody').html(result);
				});
			})
		}
		break;
	}
}