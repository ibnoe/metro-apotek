<?php
$subNav = array(
	"Penjualan Bebas ; penjualan-nr.php ; #509601;",
        "Penjualan Resep ; penjualan.php ; #509601;"
);
set_include_path("../");
include_once("inc/essentials.php");
include_once("inc/functions.php");
include_once("models/transaksi.php");
include_once("pages/message.php");
?>

<script type="text/javascript">
$(document).tooltip();
load_data_penjualan();
function add_new_rows(id_brg, nama_brg) {
    var jml = $('.tr_rows').length+1;
    
    var str = '<tr class="tr_rows">'+
                '<td align=center>'+jml+'</td>'+
                '<td>&nbsp;'+nama_brg+' <input type=hidden name=id_barang[] value="'+id_brg+'" class=id_barang id=id_barang'+jml+' /></td>'+
                '<td><input type=text name=nobatch[] id=nobatch'+jml+' /></td>'+
                '<td><input type=text name=ed[] id=ed'+jml+' /></td>'+
                '<td align=center id=sisa'+jml+'></td>'+
                '<td><input type=text name=masuk[] id=masuk'+jml+' /></td>'+
                '<td><input type=text name=keluar[] id=keluar'+jml+' /></td>'+
                '<td align=center><img onclick=removeMe('+jml+'); title="Klik untuk hapus" src="img/icons/delete.png" class=add_kemasan align=left /></td>'+
              '</tr>';
    $('#pesanan-list tbody').append(str);
    $('#ed'+jml).datepicker({
        changeYear: true,
        changeMonth: true,
        minDate: 0
    });
    $.ajax({
        url: 'models/autocomplete.php?method=get_stok_sisa&id='+id_brg,
        dataType: 'json',
        cache: false,
        success: function(data) {
            if (data.sisa === null) {
                sisa = '0';
            } else {
                sisa = data.sisa;
            }
            $('#sisa'+jml).html(sisa);
        }
    });
}

function form_add() {
    var str = '<div id="form_penjualan">'+
            '<form id="save_penjualan">'+
            '<table width=100% class=data-input><tr valign=top><td width=50%><table width=100%>'+
                '<tr><td>Tanggal:</td><td><?= form_input('tanggal', date("d/m/Y"), 'id=tanggal size=10') ?></td></tr>'+
                '<tr><td width=20%>Nama Barang:</td><td><?= form_input('barang', NULL, 'id=barang size=40') ?><?= form_hidden('id_barang', NULL, 'id=id_barang') ?></td></tr>'+
                '<tr><td></td><td><input type=button value="Pilih" id=pilih /></td></tr>'+
            '</table></td><td width=50%>'+
                
            '</td></tr></table>'+
            '<table width=100% cellspacing="0" class="list-data-input" id="pesanan-list"><thead>'+
                '<tr><th width=5%>No.</th>'+
                    '<th width=43%>Nama Barang</th>'+
                    '<th width=10%>No. Batch</th>'+
                    '<th width=10%>ED</th>'+
                    '<th width=10%>Sisa</th>'+
                    '<th width=10%>Masuk</th>'+
                    '<th width=10%>Keluar</th>'+
                    '<th width=2%>#</th>'+
                '</tr></thead>'+
                '<tbody></tbody>'+
            '</table>'+
            '</form></div>';
    $('body').append(str);
    var lebar = $('#pabrik').width();
    $('#pilih').click(function() {
        var id_barang   = $('#id_barang').val();
        var nama        = $('#barang').val();
        if (id_barang !== '') {
            add_new_rows(id_barang, nama);
        }
        $('#id_barang').val('');
        $('#barang').val('').focus();
    });
    $('#barang').keydown(function(e) {
        if (e.keyCode === 13) {
            $('#pilih').focus();
        }
    });
    $('#barang').autocomplete("models/autocomplete.php?method=barang",
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
            var str = '<div class=result>'+data.nama_barang+'</div>';
            return str;
        },
        width: lebar, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
        dataType: 'json', // tipe data yang diterima oleh library ini disetup sebagai JSON
        cacheLength: 0
    }).result(
    function(event,data,formated){
        $(this).val(data.nama_barang);
        $('#id_barang').val(data.id);
    });
    var wWidth = $(window).width();
    var dWidth = wWidth * 0.6;
    
    var wHeight= $(window).height();
    var dHeight= wHeight * 1;
    $('#form_penjualan').dialog({
        title: 'Penjualan',
        autoOpen: true,
        modal: true,
        width: dWidth,
        height: dHeight,
        hide: 'clip',
        show: 'blind',
        buttons: {
            "Simpan": function() {
                $('#save_penjualan').submit();
            }, 
            "Cancel": function() {    
                $(this).dialog().remove();
            }
        }, close: function() {
            $(this).dialog().remove();
        }, open: function() {
            $('#barang').focus();
        }
    });
    $('#tanggal').datepicker({
        changeYear: true,
        changeMonth: true
    });
    $('#save_penjualan').submit(function() {
        var jumlah = $('.tr_rows').length;
        
        if (jumlah === 0) {
            alert_empty('Barang', '#barang');
            return false;
        }
        if (jumlah > 0) {
            for (i = 1; i <= jumlah; i++) {
                if ($('#id_barang'+i).val() === '') {
                    alert_empty('Barang','#barang'+i);
                    return false;
                }
                if ($('#nobatch'+i).val() === '') {
                    alert_empty('No. batch','#nobatch'+i);
                    return false;
                }
                if ($('#ed'+i).val() === '') {
                    alert_empty('expired date','#nobatch'+i);
                    return false;
                }
                if ($('#masuk'+i).val() === '' || $('#keluar'+i).val() === '') {
                    alert_empty('masuk & keluar','#masuk'+i);
                    return false;
                }
            }
        }
        $.ajax({
            url: 'models/update-transaksi.php?method=save_penjualan',
            data: $(this).serialize(),
            dataType: 'json',
            type: 'POST',
            success: function(data) {
                if (data.status === true) {
                    alert_tambah();
                    load_data_penjualan();
                    $('#pesanan-list tbody').html('');
                }
            }
            
        });
        return false;
    });
}
$mainNav.set("home");
$('#button').button({
    icons: {
        primary: 'ui-icon-newwin'
    }
});
$('#button').click(function() {
    form_add();
});
$('#reset').button({
    icons: {
        primary: 'ui-icon-refresh'
    }
}).click(function() {
    load_data_penjualan();
});
$.plugin($afterSubPageShow,{ // <-- event is here
    showAlert:function(){ // <-- random function name is here (choose whatever you want)
    /* The code that will be executed */
    }
});
function load_data_penjualan(page, search, id) {
    pg = page; src = search; id_barg = id;
    if (page === undefined) { var pg = ''; }
    if (search === undefined) { var src = ''; }
    if (id === undefined) { var id_barg = ''; }
    $.ajax({
        url: 'pages/penjualan-list.php',
        cache: false,
        data: 'page='+pg+'&search='+src+'&id_penjualan='+id_barg,
        success: function(data) {
            $('#result-penjualan').html(data);
        }
    });
}

function paging(page, tab, search) {
    load_data_penjualan(page, search);
}

function edit_penjualan(str) {
    
    var arr = str.split('#');
    form_add();
    $('#form_add').dialog({ title: 'Edit penjualan' });
    $('#id_penjualan').val(arr[0]);
    $('#nama').val(arr[1]);
    if (arr[2] === 'P') { $('#prm').attr('checked','checked'); }
    if (arr[2] === 'L') { $('#l').attr('checked','checked'); }
    $('#alamat').val(arr[3]);
    $('#telp').val(arr[4]);
    $('#email').val(arr[5]);
    $('#nostr').val(arr[6]);
    $('#spesialis').val(arr[7]);
    $('#tglmulai').val(arr[8]);
    
}

function delete_penjualan(id, page) {
    $('<div id=alert>Anda yakin akan menghapus data ini?</div>').dialog({
        title: 'Konfirmasi Penghapusan',
        autoOpen: true,
        modal: true,
        buttons: {
            "OK": function() {
                $.ajax({
                    url: 'models/update-transaksi.php?method=delete_penjualan&id='+id,
                    cache: false,
                    success: function() {
                        load_data_penjualan(page);
                        $('#alert').dialog().remove();
                    }
                });
            },
            "Cancel": function() {
                $(this).dialog().remove();
            }
        }
    });
}
</script>
<h1 class="margin-t-0">Penjualan</h1>
<hr>
<button id="button">Tambah Data</button>
<button id="reset">Reset</button>
<div id="result-penjualan">
    
</div>