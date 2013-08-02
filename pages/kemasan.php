<?php
$subNav = array(
	"Basic Data ; kemasan.php ; #509601;",
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
    load_data_kemasan();
});
function add_setting_harga(i) {
    var row = '<tr class="mother"><td></td><td>'+
                '<table width=100% style="border-bottom: 1px dotted #ccc; margin-bottom: 5px; padding-bottom: 3px;">'+
                    '<tr><td colspan=2>&nbsp;</td></tr>'+
                    '<tr><td>Range Jual:</td><td><?= form_input('awal', NULL, 'id=awal size=5') ?> <div class="space"> s.d </div> <?= form_input('akhir', NULL, 'id=akhir size=5') ?></td></tr>'+
                    '<tr><td>Margin:</td><td><?= form_input('m_persen', NULL, 'id=m_persen maxlength=3 size=5') ?> <div class="space"> (%) </div> <?= form_input('m_rupiah', NULL, 'id=m_rupiah size=10') ?></td></tr>'+
                    '<tr><td>Diskon:</td><td><?= form_input('d_persen', NULL, 'id=d_persen maxlength=3 size=5') ?> <div class="space"> (%) </div> <?= form_input('d_rupiah', NULL, 'id=d_rupiah size=10') ?></td></tr>'+
                    '<tr><td>Harga Jual (Rp.):</td><td id=harga_jual>-</td></tr>'+
                '</table>'+
            '</td></tr>';
    $(row).insertAfter('#mother'+i);
    
}
function kemasan_add(i) {
    var str = '<tr class="mother"><td width=15%>Barcode:</td><td width=70%><?= form_input('barcode', NULL, 'id=barcode size=10') ?> '+
                'Kemasan: <select name=kemasan[] style="min-width: 100px;"><option value="">Pilih ...</option><?php foreach ($kemasan as $data) { echo '<option value="'.$data->id.'">'.$data->nama.'</option>'; } ?></select> '+
                'Isi: <?= form_input('isi[]', NULL, 'id=isi size=5') ?> '+
                'Satuan: <select name=satuan[] style="min-width: 100px;"><option value="">Pilih ...</option><?php foreach ($kemasan as $data) { echo '<option value="'.$data->id.'">'.$data->nama.'</option>'; } ?></select>&nbsp;'+
            '<img onclick=add_setting_harga('+i+'); title="Klik untuk setting harga" src="img/icons/add.png" class=add_kemasan align=right />'+
            '<img onclick=delete_setting_harga('+i+'); title="Klik untuk delete" src="img/icons/delete-icon.png" class=delete_kemasan align=right /></td></tr>';
    $('.data-input').append(str);
}
function form_add() {
/*$('.mother:eq('+jml+')').attr('id', 'mother'+jml);
$('.mother:eq('+jml+')').children('td:eq(1)').children('.add_kemasan').attr('id', jml);
$('.mother:eq('+jml+')').children('td:eq(1)').children('.delete_kemasan').attr('id', jml);*/
var str = '<div id=form_add>'+
            '<form id="form_kemasan">'+
                '<?= form_hidden('id_kemasan', NULL, 'id=id_kemasan') ?>'+
                    '<div><table width=100% class=data-input>'+
                        '<tr><td width=15%>Nama Barang:</td><td width=70%><?= form_input('nama', NULL, 'id=nama size=25 style="float: left"') ?>&nbsp;<img title="Klik untuk tambah kemasan" src="img/icons/add.png" id=add_kemasan align=left /></td></tr>'+
                        '<tr><td colspan=2>&nbsp;</td></tr>'+

                    '</table>'+
            '</div></form>'+
          '</div>';
    $('body').append(str);
    $("#accordion").accordion({ header: "h3" });
    $('#add_kemasan').click(function() {
        var jml = $('.mother').length;
        kemasan_add(jml);
        $('.mother:eq('+jml+')').attr('id', 'mother'+jml);
    }); 
    $('.add_kemasan').click(function() {
        //var id = $(this).attr('id');
        alert('asd');
    });
    
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
            var str = '<div class=result>'+data.nama_kemasan+'</div>';
            return str;
        },
        width: lebar, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
        dataType: 'json', // tipe data yang diterima oleh library ini disetup sebagai JSON
        cacheLength: 0
    }).result(
    function(event,data,formated){
        $(this).val(data.nama_kemasan);
        $('#id_pabrik').val(data.id);
    });
    var wWidth = $(window).width();
    var dWidth = wWidth * 0.6;
    
    var wHeight= $(window).height();
    var dHeight= wHeight * 0.8;
    $('#form_add').dialog({
        title: 'Tambah Kemasan & Setting Harga',
        autoOpen: true,
        modal: true,
        width: 710,
        height: dHeight,
        hide: 'clip',
        show: 'blind',
        buttons: {
            "Simpan": function() {
                $('#form_kemasan').submit();
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
    
    
    $('#form_kemasan').submit(function() {
        if ($('#nama').val() === '') {
            alert('Nama produk tidak boleh kosong !');
            $('#nama').focus(); return false;
        }
        if ($('#kekuatan').val() === '') {
            alert('Kekuatan kemasan tidak boleh kosong !');
            $('#kekuatan').focus(); return false;
        }
        if ($('#h_pokok').val() === '') {
            alert('Harga pokok tidak boleh kosong !');
            $('#h_pokok').focus(); return false;
        }
        var cek_id = $('#id_kemasan').val();
        $.ajax({
            url: 'models/update-masterdata.php?method=save_kemasan',
            type: 'POST',
            dataType: 'json',
            data: $(this).serialize(),
            cache: false,
            success: function(data) {
                if (data.status === true) {
                    if (cek_id === '') {
                        alert_tambah();
                        $('#form_kemasan input[type=text], #form_kemasan textarea').val('');
                        load_data_kemasan('1','',data.id_kemasan);
                    } else {
                        alert_edit();
                        $('#form_kemasan').dialog().remove();
                        load_data_kemasan('1','',cek_id);
                    }
                    
                }
            }
        });
        return false;
    });
}
function load_data_kemasan(page, search, id) {
    pg = page; src = search; id_barg = id;
    if (page === undefined) { var pg = ''; }
    if (search === undefined) { var src = ''; }
    if (id === undefined) { var id_barg = ''; }
    $.ajax({
        url: 'pages/kemasan-list.php',
        cache: false,
        data: 'page='+pg+'&search='+src+'&id_kemasan='+id_barg,
        success: function(data) {
            $('#result-kemasan').html(data);
        }
    });
}

function paging(page, tab, search) {
    load_data_kemasan(page, search);
}

function edit_kemasan(str) {
    var arr = str.split('#');
    form_add();
    $('#id_kemasan').val(arr[0]);
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
    load_data_kemasan();
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
<div id="result-kemasan">
    
</div>