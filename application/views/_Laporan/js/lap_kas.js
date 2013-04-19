$(document).ready(function(e) {
	var prs=$('#prs').val();
	$('table#panel tr td.flt').hide()
    $('#kasharian').removeClass('tab_button');
	$('#kasharian').addClass('tab_select');
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

	$('#frm1 #dari_tgl')
		.click(function(){
			$(this).focus().select();
			tglNow('#frm1 #dari_tgl');
		})
		.keyup(function(){
			tanggal(this)
		})
		.keypress(function(e){
			if(e.keyCode==13){
				$('#frm1 #sampai_tgl').focus().select();
			}
		})
	$('#frm1 #sampai_tgl')
		.click(function(){
			$(this).focus().select();
			tglNow('#frm1 #sampai_tgl');
		})
		.keyup(function(){
			tanggal(this)
		})
		.keypress(function(e){
			if(e.keyCode==13){
				$('#frm1 #nm_produsen').focus().select();
			}
		})

	$('#frm1 #saved-lapkas').click(function(){
		$.post('generate_lapkas',{
			'dari_tgl'	:$('#frm1 #dari_tgl').val(),
			'sampai_tgl':$('#frm1 #sampai_tgl').val()
		},function(result){
			//alert(result);
			$('#frm1').attr('action','show_lapkas');
			document.frm1.submit();
		})
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