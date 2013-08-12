<?php
set_include_path("../");
include_once("inc/essentials.php");
include_once("inc/functions.php");
include_once("models/masterdata.php");
include_once("pages/message.php");
$biaya_apoteker = tarif_load_data();
?>
<script type="text/javascript">
$(function() {
    $(document).tooltip();
    load_data_resep();
    $('#button').button({
        icons: {
            primary: 'ui-icon-newwin'
        }
    }).click(function() {
        form_add();
    });
    $('#reset').button({
        icons: {
            primary: 'ui-icon-refresh'
        }
    });
    $('#addnewrows').click(function() {
        var row = $('.masterresep').length;
        addnoresep(row);
    });
});

function add(i) {
    var j = $('.detailobat'+i).length;
    var str = ' <div class=tr_rows style="width: 100%; display: block; font-size: 11px;">'+
                '<table align=right width=100% style="padding: 0 0 0 5px; margin-bottom:2px;" class="data-input detailobat'+i+'">'+
                '<tr><td width=25%>Nama Produk:</td><td>  <input type=text name=pb'+i+'[] id=pb'+i+''+j+' class=pb size=40 />'+
                    '<input type=hidden name=id_pb'+i+'[] id=id_pb'+i+''+j+' class=id_pb />'+
                    '<input type=hidden name=kr'+i+'[] id=kr'+i+''+j+' class=kr />'+
                    '<input type=hidden name=jp'+i+'[] id=jp'+i+''+j+' class=jp /></td></tr>'+
                '<tr><td>Kekuatan:</td><td><span class=label id=kekuatan'+i+''+j+'>-</span></td></tr>'+
                '<tr><td>Dosis Racik:</td><td> <input type=text name=dr'+i+'[] id=dr'+i+''+j+' class=dr onkeyup=jmlPakai('+i+','+j+') size=10 value="" /></td></tr>'+
                '<tr><td>Jumlah Pakai:</td><td><span class=label id=jmlpakai'+i+''+j+'>-</span> <img src="img/icons/delete.png" align=right id="deleting'+i+''+j+'" onclick=eliminatechild(this,'+i+','+j+') /></td></tr>'+
                '</table>'+
            '</div>';

        
    $('#resepno'+i).append(str);
    $('#pb'+i+''+j).autocomplete("",
    {
        parse: function(data){
            var parsed = [];
            for (var i=0; i < data.length; i++) {
                parsed[i] = {
                    data: data[i],
                    value: data[i].nama // nama field yang dicari
                };
            }
            return parsed;
        },
        formatItem: function(data,i,max){
            var isi = ''; var satuan = ''; var sediaan = ''; var pabrik = ''; var satuan_terkecil = ''; var kekuatan = '';
            if (data.isi !== '1') { var isi = '@ '+data.isi; }
            if (data.kekuatan !== null && data.kekuatan !== '0') { var kekuatan = data.kekuatan; }
            if (data.satuan !== null) { var satuan = data.satuan; }
            if (data.sediaan !== null) { var sediaan = data.sediaan; }
            if (data.pabrik !== null) { var pabrik = data.pabrik; }
            if (data.satuan_terkecil !== null) { var satuan_terkecil = data.satuan_terkecil; }
            if (data.id_obat === null) {
                var str = '<div class=result>'+data.nama+' '+pabrik+' '+isi+' '+satuan_terkecil+'</div>';
            } else {
                if (data.generik === 'Non Generik') {
                    var str = '<div class=result>'+data.nama+' '+((kekuatan === '1')?'':kekuatan)+' '+satuan+' '+sediaan+' '+isi+' '+satuan_terkecil+'</div>';
                } else {
                    var str = '<div class=result>'+data.nama+' '+((kekuatan === '1')?'':kekuatan)+' '+satuan+' '+sediaan+' '+pabrik+' '+isi+' '+satuan_terkecil+'</div>';
                }
            }
            return str;
        },
        width: 400, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
        dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
    }).result(
    function(event,data,formated){
        if (data.kekuatan === null) {
            var ok=confirm('Kekuatan untuk Kemasan Barang yang dipilih = NULL, Anda yakin akan menambahkan dalam form resep?');
            if (!ok) {
                $(this).val('');
                $('#id_pb'+i+''+j).val('');
                $('#bc'+i+''+j).val('');
                $('#kekuatan'+i+''+j).html('');
                $('#dr'+i+''+j).val('');
                return false;
            } else {
                $('#kekuatan'+i+''+j).html('1');
                $('#jmlpakai'+i+''+j).html($('#jt'+i).val());
                $('#dr'+i+''+j).val('1');
                $('#jp'+i+''+j).val($('#jt'+i).val());
            }
        }
        var isi = ''; var satuan = ''; var sediaan = ''; var pabrik = ''; var satuan_terkecil = ''; var kekuatan = '';
        if (data.isi !== '1') { var isi = '@ '+data.isi; }
        if (data.kekuatan !== null && data.kekuatan !== '0') { var kekuatan = data.kekuatan; }
        if (data.satuan !== null) { var satuan = data.satuan; }
        if (data.sediaan !== null) { var sediaan = data.sediaan; }
        if (data.pabrik !== null) { var pabrik = data.pabrik; }
        if (data.satuan_terkecil !== null) { var satuan_terkecil = data.satuan_terkecil; }
        if (data.id_obat === null) {
            $(this).val(data.nama+' '+pabrik+' '+isi+' '+satuan_terkecil);
        } else {
            if (data.generik === 'Non Generik') {
                $(this).val(data.nama+' '+((kekuatan === '1')?'':kekuatan)+' '+satuan+' '+sediaan+' '+isi+' '+satuan_terkecil);
            } else {
                $(this).val(data.nama+' '+((kekuatan === '1')?'':kekuatan)+' '+satuan+' '+sediaan+' '+pabrik+' '+isi+' '+satuan_terkecil);
            }
        }
        $('#id_pb'+i+''+j).val(data.id);
        $('#bc'+i+''+j).val(data.barcode);
        $('#kekuatan'+i+''+j).html(data.kekuatan);
        $('#dr'+i+''+j).val(data.kekuatan);
        
        jmlPakai(i, j);
        
    });
}
function jmlPakai(i,j) {
        var dosis_racik = $('#dr'+i+''+j).val();
        var jumlah_tbs  = parseInt($('#jt'+i).val());
        var kekuatan    = $('#kekuatan'+i+''+j).html();
        var jumlah_pakai= (dosis_racik*jumlah_tbs)/kekuatan;
		
        if (isNaN(kekuatan) || kekuatan === '0') {
            alert('Kekuatan obat tidak boleh bernilai nol, silahkan diubah pada master data obat !');
            $('#pb'+i+''+j).val('');
            $('#id_pb'+i+''+j).val('');
            $('#bc'+i+''+j).val('');
            $('#kekuatan'+i+''+j).html('');
            $('#dr'+i+''+j).val('');
            return false;
        }
        $('#jmlpakai'+i+''+j).html(jumlah_pakai);
        $('#kr'+i+''+j).val(kekuatan);
        $('#jp'+i+''+j).val(jumlah_pakai);
}

function subTotal() {
    
    var jumlah = $('.tr_row').length-1;
    var total_jasa = 0;
    for(i = 0; i<= jumlah; i++) {
        var valjasa  = $('#ja'+i).val();
        var n=valjasa.split("-");
        var jasa = parseInt(n[1]);
        var total_jasa = total_jasa + jasa;
    }
    $('#totalbiaya').html(numberToCurrency(total_jasa));
}

function eliminate(el) {
    $('<div id=alert>Anda yakin akan menghapus data ini?</div>').dialog({
        title: 'Konfirmasi Penghapusan',
        autoOpen: true,
        modal: true,
        buttons: {
            "OK": function() {
                $('#alert').dialog().remove();
                var parent = el.parentNode.parentNode.parentNode.parentNode;
                parent.parentNode.removeChild(parent);
                var jumlah = $('.tr_row').length-1;
                for (i = 0; i <= jumlah; i++) {

                    $('.tr_row:eq('+i+')').children('.masterresep:eq(0)').children('.nr').attr('value',(i+1));
                    $('.tr_row:eq('+i+')').children('.masterresep:eq(0)').children('.nr').attr('id','nr'+i);
                    $('.tr_row:eq('+i+')').children('.psdg-right:eq(0)').children('.jr').attr('id','jr'+i);
                    $('.tr_row:eq('+i+')').children('.psdg-right:eq(0)').children('.jt').attr('id','jt'+i);
                    $('.tr_row:eq('+i+')').children('.psdg-right:eq(0)').children('.ap').attr('id','ap'+i);
                    $('.tr_row:eq('+i+')').children('.psdg-right:eq(0)').children('.it').attr('id','it'+i);
                    $('.tr_row:eq('+i+')').children('.psdg-right:eq(0)').children('.ja').attr('id','ja'+i);
                    $('.tr_row:eq('+i+')').children('.psdg-right:eq(0)').children('.ad').attr('id','ad'+i);
                    $('.tr_row:eq('+i+')').children('.psdg-right:eq(0)').children('.de').attr('id','de'+i);
                }
            },
            "Cancel": function() {
                $(this).dialog().remove();
            }
        }
    });
    
}

function eliminatechild(el,x,y) {
    ok=confirm('Anda yakin akan menghapus data ini ?');
    if (ok) {

        var parent = el.parentNode.parentNode.parentNode.parentNode.parentNode;
        parent.parentNode.removeChild(parent);
        var jumlah = $('.tr_rows').length-1;
    } else {
        return false;
    }
}

function addnoresep(i) {
    
    var str = ' <div style="display: inline-block; width: 100%" class=tr_row>'+
                '<div class="masterresep" style="display: inline-block; width: 100%; margin-top:3px; border-bottom: #333;"><table width=100% class=data-input>'+
                    '<tr><td width=25%>No. R/:</td><td><input style="border: none; background: #f4f4f4" type=text name=nr[] id=nr'+i+' value='+(i+1)+' class=nr size=20 onkeyup=Angka(this) readonly maxlength=2 /></td></tr>'+
                    '<tr><td>Permintaan:</td><td><input type=text name=jr[] id=jr'+i+' class=jr size=20 onkeyup=Angka(this) /></td></tr>'+
                    '<tr><td>Jumlah Tebus:</td><td><input type=text name=jt[] id=jt'+i+' class=jt onkeyup=Angka(this) size=20 /></td></tr>'+
                    '<tr><td>Aturan Pakai:</td><td><input type=text name=ap[] id=ap'+i+' class=ap size=20 /></td></tr>'+
                    '<tr><td>Iterasi:</td><td><input type=text name=it[] id=it'+i+' class=it size=10 value="0" onkeyup=Angka(this) /></td></tr>'+
                    '<tr><td>Jasa Apoteker:</td><td><select onchange="subTotal()" name=ja[] id=ja'+i+'><option value="0-0">Pilih biaya ..</option><?php foreach ($biaya_apoteker as $value) { echo '<option value="'.$value->id.'-'.$value->nominal.'">'.$value->nama.' Rp. '.$value->nominal.'</option>'; } ?></select></td></tr>'+
                    '<tr><td></td><td><img src="img/icons/add.png" style="margin-right: 2px;" title="Tambah Barang" align=left onclick=add('+i+') id="addition'+i+'" />&nbsp;'+
                    '<img src="img/icons/delete.png" style="margin-right: 2px;" align=left id="deletion'+i+'" title="Hapus R/" onclick=eliminate(this) /> <input type=button value="Etiket" id="etiket'+i+'" style="display: none" class="etiket" onclick=cetak_etiket('+(i+1)+') /></td></tr></table>'+
                '</div>'+
                '<div id=resepno'+i+' style="display: inline-block;width: 100%"></div>'+
            '</div>';
    
    $('#psdg-middle').append(str);
    $('input[type=button]').button();
}

function form_add() {
    var str = '<div id=form_resep>'+
                '<form id=resep_save>'+
                    '<table width=100% class=data-input>'+
                    '<tr><td width=25%>Waktu:</td><td><?= form_input('waktu', date("d/m/Y"), 'id=waktu size=10') ?></td></tr>'+
                    '<tr><td>Dokter:</td><td><?= form_input('dokter', NULL, 'id=dokter size=40') ?><?= form_hidden('id_dokter', NULL, 'id=id_dokter') ?></td></tr>'+
                    '<tr><td>Pasien:</td><td><?= form_input('pasien', NULL, 'id=pasien size=40') ?><?= form_hidden('id_pasien', NULL, 'id=id_pasien') ?></td></tr>'+
                    '<tr><td>Keterangan:</td><td><?= form_textarea('keterangan', NULL, 'cols=37 rows=3') ?></td></tr>'+
                    '</table>'+
                '</form>'+
                '<div id=psdg-middle></div>'+
              '</div>';
    $('body').append(str);
    var lebar = $('#dokter').width();
    $('#dokter').autocomplete("models/autocomplete.php?method=dokter",
    {
        parse: function(data){
            var parsed = [];
            for (var i=0; i < data.length; i++) {
                parsed[i] = {
                    data: data[i],
                    value: data[i].nama // nama field yang dicari
                };
            }
            return parsed;
        },
        formatItem: function(data,i,max){
            var str = '<div class=result>'+data.nama+'<br/> '+data.no_str+'</div>';
            return str;
        },
        width: lebar, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
        dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
    }).result(
    function(event,data,formated){
        $(this).val(data.nama);
        $('#id_dokter').val(data.id);
    });
    $('#pasien').autocomplete("models/autocomplete.php?method=pasien",
    {
        parse: function(data){
            var parsed = [];
            for (var i=0; i < data.length; i++) {
                parsed[i] = {
                    data: data[i],
                    value: data[i].nama // nama field yang dicari
                };
            }
            return parsed;
        },
        formatItem: function(data,i,max){
            var str = '<div class=result>'+data.nama+'<br/> '+data.alamat+'</div>';
            return str;
        },
        width: lebar, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
        dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
    }).result(
    function(event,data,formated){
        $(this).val(data.nama);
        $('#id_pasien').val(data.id);
    });
    var wWidth = $(window).width();
    var dWidth = wWidth * 0.6;
    
    var wHeight= $(window).height();
    var dHeight= wHeight * 1;
    $('#form_resep').dialog({
        title: 'Tambah resep Barang',
        autoOpen: true,
        modal: true,
        width: 400,
        height: dHeight,
        hide: 'clip',
        show: 'blind',
        buttons: {
            "Tambah R/": function() {
                var row = $('.masterresep').length;
                addnoresep(row);
            },
            "Simpan": function() {
                $('#save_resep').submit();
            }, 
            "Cancel": function() {    
                $(this).dialog().remove();
            }
        }, close: function() {
            $(this).dialog().remove();
        }, open: function() {
            addnoresep(0);
            add(0);
        }
    });
}

function load_data_resep(page, search, id) {
    pg = page; src = search; id_barg = id;
    if (page === undefined) { var pg = ''; }
    if (search === undefined) { var src = ''; }
    if (id === undefined) { var id_barg = ''; }
    $.ajax({
        url: 'pages/resep-list.php',
        cache: false,
        data: 'page='+pg+'&search='+src+'&id_resep='+id_barg,
        success: function(data) {
            $('#result-resep').html(data);
        }
    });
}

function paging(page, tab, search) {
    load_data_resep(page, search);
}
</script>
<h1 class="margin-t-0">Resep</h1>
<hr>
<button id="button">Resep Baru</button>
<button id="reset">Reset</button>
<div id="result-resep">
    
</div>