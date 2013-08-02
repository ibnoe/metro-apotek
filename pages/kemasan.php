<?php
$subNav = array(
	"Basic Data ; barang.php ; #509601;",
        "Pelengkap ; pelengkap.php ; #509601;",
	"Kemasan ; kemasan.php ; #509601;",
);

set_include_path("../");
include_once("inc/essentials.php");
include_once("inc/functions.php");
include_once("models/masterdata.php");
include_once("pages/message.php");
$golongan = golongan_load_data();
$satuan_kekuatan = satuan_load_data('1');
$kemasan  = satuan_load_data('0');
$sediaan  = sediaan_load_data();
$admr     = admr_load_data();
$perundangan = perundangan_load_data();
?>

<script type="text/javascript">
$(function() {
    load_data_barang();
});
function form_add() {
var kemasan = '<tr><td width=15%>Barcode:</td><td width=70%><?= form_input('barcode', NULL, 'id=barcode size=10') ?> '+
                    'Kemasan: <select name=kemasan[] style="min-width: 100px;"><option value="">Pilih ...</option><?php foreach ($kemasan as $data) { echo '<option value="'.$data->id.'">'.$data->nama.'</option>'; } ?></select> '+
                    'Isi: <?= form_input('isi[]', NULL, 'id=isi size=5') ?> '+
                    'Satuan: <select name=satuan[] style="min-width: 100px;"><option value="">Pilih ...</option><?php foreach ($kemasan as $data) { echo '<option value="'.$data->id.'">'.$data->nama.'</option>'; } ?></select>'+
                '</td></tr>';
$('.data-input').append(kemasan);
var str = '<div id=form_add>'+
            '<form id="form_barang">'+
                    '<?= form_hidden('id_barang', NULL, 'id=id_barang') ?>'+
                        '<div><table width=100% class=data-input>'+
                            '<tr><td width=15%>Nama Barang:</td><td width=70%><?= form_input('nama', NULL, 'id=nama size=25 style="float: left"') ?>&nbsp;<img title="Klik untuk tambah kemasan" src="img/icons/add.png" align=left /></td></tr>'+
                            '<tr><td colspan=2>&nbsp;</td></tr>'+
                            
                        '</table>'+
            '</div></form>'+
          '</div>';
    $('body').append(str);
    $("#accordion").accordion({ header: "h3" });
    
    var lebar = $('#pabrik').width();
    $('#nama').autocomplete("models/autocomplete.php?method=barang",
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
        $('#id_pabrik').val(data.id);
    });
    $('#add_kemasan').button({
        icons: {
            primary: 'ui-icon-refresh'
        }
    });
    var wWidth = $(window).width();
    var dWidth = wWidth * 0.6;
    
    var wHeight= $(window).height();
    var dHeight= wHeight * 0.8;
    $('#form_add').dialog({
        title: 'Tambah Kemasan & Setting Harga',
        autoOpen: true,
        modal: true,
        width: 700,
        height: dHeight,
        hide: 'clip',
        show: 'blind',
        buttons: {
            "Simpan": function() {
                $('#form_barang').submit();
            }, 
            "Cancel": function() {    
                $(this).dialog().remove();
            }
        }, close: function() {
            $(this).dialog().remove();
        }, open: function() {
            $('#nama').focus();
        }
    });
    
    var lebar = $('#pabrik').width();
    $('#pabrik').dblclick(function() {
        $('<div title="Data pabrik" id="pabrik-data"></div>').dialog({
            autoOpen: true,
            modal: true,
            width: 500,
            height: 350,
            buttons: {
                
            }
        });
    });
    
    
    $('#form_barang').submit(function() {
        if ($('#nama').val() === '') {
            alert('Nama produk tidak boleh kosong !');
            $('#nama').focus(); return false;
        }
        if ($('#kekuatan').val() === '') {
            alert('Kekuatan barang tidak boleh kosong !');
            $('#kekuatan').focus(); return false;
        }
        if ($('#h_pokok').val() === '') {
            alert('Harga pokok tidak boleh kosong !');
            $('#h_pokok').focus(); return false;
        }
        var cek_id = $('#id_barang').val();
        $.ajax({
            url: 'models/update-masterdata.php?method=save_barang',
            type: 'POST',
            dataType: 'json',
            data: $(this).serialize(),
            cache: false,
            success: function(data) {
                if (data.status === true) {
                    if (cek_id === '') {
                        alert_tambah();
                        $('#form_barang input[type=text], #form_barang textarea').val('');
                        load_data_barang('1','',data.id_barang);
                    } else {
                        alert_edit();
                        $('#form_barang').dialog().remove();
                        load_data_barang('1','',cek_id);
                    }
                    
                }
            }
        });
        return false;
    });
}
function load_data_barang(page, search, id) {
    pg = page; src = search; id_barg = id;
    if (page === undefined) { var pg = ''; }
    if (search === undefined) { var src = ''; }
    if (id === undefined) { var id_barg = ''; }
    $.ajax({
        url: 'pages/barang-list.php',
        cache: false,
        data: 'page='+pg+'&search='+src+'&id_barang='+id_barg,
        success: function(data) {
            $('#result-barang').html(data);
        }
    });
}

function paging(page, tab, search) {
    load_data_barang(page, search);
}

function edit_barang(str) {
    var arr = str.split('#');
    form_add();
    $('#id_barang').val(arr[0]);
    $('#nama').val(arr[1]);
    $('#kekuatan').val(arr[2]);
    $('#s_sediaan').val(arr[3]);
    $('#sediaan').val(arr[4]);
    $('#golongan').val(arr[5]);
    $('#admr').val(arr[6]);
    $('#pabrik').val(arr[8]);
    $('#id_pabrik').val(arr[7]);
    $('#rak').val(arr[9]);
    if (arr[10] === '1') { $('#ya').attr('checked','checked'); }
    if (arr[10] === '0') { $('#tidak').attr('checked','checked'); }
    
    $('#indikasi').val(arr[11]);
    $('#dosis').val(arr[12]);
    $('#kandungan').val(arr[13]);
    $('#perhatian').val(arr[14]);
    $('#kontra_indikasi').val(arr[15]);
    $('#efek_samping').val(arr[16]);
}
$mainNav.set("home");
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
}).click(function() {
    load_data_barang();
});

$.plugin($afterSubPageShow,{ // <-- event is here
    showAlert:function(){ // <-- random function name is here (choose whatever you want)
    
    }
});
</script>
<h1 class="margin-t-0">Kemasan Produk</h1>
<hr>
<button id="button">Tambah Data</button>
<button id="reset">Reset</button>
<div id="result-barang">
    
</div>