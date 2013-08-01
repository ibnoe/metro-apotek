<?php
$subNav = array(
	"Utama ; barang.php ; #509601;",
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
var str = '<div id=form_add>'+
            '<form id="form_barang"><div id="accordion">'+
                    '<?= form_hidden('id_barang', NULL, 'id=id_barang') ?>'+
                    '<div>'+
                            '<h3><a href="#">Data Primer</a></h3>'+
                            '<div><table width="100%"><tr valign=top><td width="60%"><table width=100% class=data-input>'+
                                '<tr><td width=40%>Nama Barang:</td><td><?= form_input('nama', NULL, 'id=nama size=32 onBlur="javascript:this.value=this.value.toUpperCase();"') ?></td></tr>'+
                                '<tr><td>Kekuatan:</td><td><?= form_input('kekuatan', NULL, 'id=kekuatan size=32') ?></td></tr>'+
                                '<tr><td>Satuan Kekuatan:</td><td><select name=s_sediaan id=s_sediaan><option value="">Pilih ...</option><?php foreach ($satuan_kekuatan as $data) { echo '<option value="'.$data->id.'">'.$data->nama.'</option>'; } ?></select></td></tr>'+
                                '<tr><td>Sediaan:</td><td><select name=sediaan id=sediaan><option value="">Pilih ...</option><?php foreach ($sediaan as $data) { echo '<option value="'.$data->id.'">'.$data->nama.'</option>'; } ?></select></td></tr>'+
                                '<tr><td>Golongan:</td><td><select name=golongan id=golongan><option value="">Pilih ...</option><?php foreach ($golongan as $data) { echo '<option value="'.$data->id.'">'.$data->nama.'</option>'; } ?></select></td></tr>'+
                                '<tr><td>Formularium:</td><td><?= form_radio('formularium', 'Ya', 'ya', 'Ya', FALSE) ?> <?= form_radio('formularium', 'Tidak', 'tidak', 'Tidak', TRUE) ?></td></tr>'+
                                '<tr><td>R Administrasi:</td><td><select name=admr id=admr><option value="">Pilih ...</option><?php foreach ($admr as $data) { echo '<option value="'.$data.'">'.$data.'</option>'; } ?></select></td></tr>'+
                                '<tr><td>Pabrik:</td><td><?= form_input('pabrik', NULL, 'id=pabrik size=32') ?><?= form_hidden('id_pabrik', NULL, 'id=id_pabrik') ?></td></tr>'+
                                '<tr><td>Perundangan:</td><td><select name="perundangan" id="perundangan"><?php foreach ($perundangan as $data) { echo '<option value="'.$data.'">'.$data.'</option>'; } ?></select></td></tr>'+
                                '<tr><td>Rak:</td><td><?= form_input('rak', NULL, 'id=rak size=32') ?></td></tr>'+
                                '<tr><td></td><td><?= form_radio('generik', '1', 'ya', 'Generik', TRUE) ?> <?= form_radio('generik', '0', 'tidak', 'Non Generik') ?></td></tr>'+

                            '</table></td><td width=2%>&nbsp;</td><td width=38%>'+
                                '<table width=100% class=data-input>'+
                                    '<tr><td width=50%>Stok Minimal:</td><td><?= form_input('stok_min', NULL, 'id=stok_min size=1') ?></td></tr>'+
                                    '<tr><td>Margin Non Resep:</td><td><?= form_input('margin_nr', NULL, 'id=margin_nr size=1') ?> % <?= form_input('margin_nr_rp', NULL, 'id=margin_nr_rp size=7') ?></td></tr>'+
                                    '<tr><td>Margin Resep:</td><td><?= form_input('margin_r', NULL, 'id=margin_r size=1') ?> % <?= form_input('margin_r_rp', NULL, 'id=margin_r_rp size=7') ?></td></tr>'+
                                    '<tr><td></td><td>&nbsp;</td></tr>'+
                                    '<tr><td colspan=2><?= form_checkbox('ppn', '10', 'ppn', 'PPN (10%)') ?><?= form_checkbox('aktifasi', '10', 'aktifasi', 'Aktifasi') ?></td></tr>'+
                                '</table>'+
                            '</td></tr></table></div>'+
                    '</div>'+
                    '<div>'+
                            '<h3><a href="#">Data Pelengkap</a></h3>'+
                            '<div><table width=100% class=data-input>'+
                                '<tr><td width=24% valign=top>Indikasi:</td><td><?= form_textarea('indikasi', NULL, 'cols=30 id=indikasi') ?></td></tr>'+
                                '<tr><td valign=top>Dosis:</td><td><?= form_textarea('dosis', NULL, 'cols=30 id=dosis') ?></td></tr>'+
                                '<tr><td valign=top>Kandungan:</td><td><?= form_textarea('kandungan', NULL, 'cols=30 id=kandungan') ?></td></tr>'+
                                '<tr><td valign=top>Perhatian:</td><td><?= form_textarea('perhatian', NULL, 'cols=30 id=perhatian') ?></td></tr>'+
                                '<tr><td valign=top>Kontra Indikasi:</td><td><?= form_textarea('kontra_indikasi', NULL, 'cols=30 id=kontra_indikasi') ?></td></tr>'+
                                '<tr><td valign=top>Efek Samping:</td><td><?= form_textarea('efek_samping', NULL, 'cols=30 id=efek_samping') ?></td></tr>'+
                            '</table></div>'+
                    '</div>'+
                    '<div>'+
                            '<h3><a href="#">Data Kemasan</a></h3>'+
                            '<div><table width=100% class=data-input>'+
                                '<tr><td width=24%>Barcode:</td><td width=70%><?= form_input('barcode1', NULL, 'id=barcode1 size=32') ?></td></tr>'+
                                '<tr><td>Kemasan Terbesar:</td><td><select name=s_besar><option value="">Pilih ...</option><?php foreach ($kemasan as $data) { echo '<option value="'.$data->id.'">'.$data->nama.'</option>'; } ?></select></td></tr>'+
                                
                                '<tr><td colspan=2>&nbsp;</td></tr>'+
                                '<tr><td>Barcode:</td><td width=70%><?= form_input('barcode2', NULL, 'id=barcode2 size=32') ?></td></tr>'+
                                '<tr><td>Isi:</td><td><?= form_input('isi1', NULL, 'size=5 class=small-input') ?><select name=s_sedang><option value="">Pilih ...</option><?php foreach ($kemasan as $data) { echo '<option value="'.$data->id.'">'.$data->nama.'</option>'; } ?></select></td></tr>'+
                                
                                '<tr><td colspan=2>&nbsp;</td></tr>'+
                                '<tr><td>Barcode:</td><td width=70%><?= form_input('barcode3', NULL, 'id=barcode3 size=32') ?></td></tr>'+
                                '<tr><td>Isi:</td><td><?= form_input('isi2', NULL, 'size=5 class=small-input') ?><select name=s_kecil><option value="">Pilih ...</option><?php foreach ($kemasan as $data) { echo '<option value="'.$data->id.'">'.$data->nama.'</option>'; } ?></select></td></tr>'+
                                
                            '</table></div>'+
                    '</div>'+
            '</div></form>'+
          '</div>';
    $('body').append(str);
    $("#accordion").accordion({ header: "h3" });
    //$("#sediaan").combobox();
    var lebar = $('#pabrik').width();
    $('#pabrik').autocomplete("models/autocomplete.php?method=pabrik",
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
        $('#id_pabrik').val(data.id);
    });
    $('#supplier').autocomplete("models/autocomplete.php?method=supplier",
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
        $('#id_supplier').val(data.id);
    });
    var wWidth = $(window).width();
    var dWidth = wWidth * 0.8;
    
    var wHeight= $(window).height();
    var dHeight= wHeight * 0.8;
    $('#form_add').dialog({
        title: 'Tambah Barang',
        autoOpen: true,
        modal: true,
        width: 850,
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
$('button').button({
    icons: {
        primary: 'ui-icon-newwin'
    }
});
$('#button').click(function() {
    form_add();
});
$.plugin($afterSubPageShow,{ // <-- event is here
    showAlert:function(){ // <-- random function name is here (choose whatever you want)
    
    }
});
</script>
<h1 class="margin-t-0">Data Produk</h1>
<hr>
<button id="button">Tambah Data</button>
<div id="result-barang">
    
</div>