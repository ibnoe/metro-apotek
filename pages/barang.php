<?php
$subNav = array(
	"Basic Data ; barang.php ; #509601;",
        "Pelengkap ; pelengkap.php ; #509601;"
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
$farmakoterapi   = farmakoterapi_load_data();
$fda      = fda_load_data();
?>

<script type="text/javascript">
$(function() {
    load_data_barang();
});

function create_new_packing(i) {
    var kemasan = $('#kemasan'+i).val();
    var satuan  = $('#satuan'+i).val();
    var jumlah  = $('.mother').length-1;
    
    
    if (kemasan !== satuan) {
        kemasan_add(jumlah+1);
        $('#kemasan'+(i+1)).val(satuan);
        $('#satuan'+(i+1)).val(satuan);
        $('.mother:eq('+(i+1)+')').attr('id', 'mother'+(i+1));
    }
}

function kemasan_add(i) {
    var str = '<tr class="mother" id="mother'+i+'"><td width=15%>Barcode:</td><td width=70%><input type=hidden name=id_kemasan'+i+' id=id_kemasan'+i+' /><input type=text name=barcode'+i+' id=barcode'+i+' class=barcode size=10 />'+
                '&nbsp;Kemasan: <select name=kemasan'+i+' id="kemasan'+i+'" onchange="isi_satuan_terkecil('+i+')" style="min-width: 100px;"><option value="">Pilih ...</option><?php foreach ($kemasan as $data) { echo '<option value="'.$data->id.'">'.$data->nama.'</option>'; } ?></select> '+
                'Isi: <input type=text name=isi'+i+' id=isi'+i+' onblur="isi_satuan_terkecil('+i+')" size=5 />&nbsp;'+
                'Satuan: <select name=satuan'+i+' id="satuan'+i+'" onchange="config_auto_suggest('+i+')" style="min-width: 100px;"><option value="">Pilih ...</option><?php foreach ($kemasan as $data) { echo '<option value="'.$data->id.'">'.$data->nama.'</option>'; } ?></select>&nbsp;'+
                '&nbsp;<input type=checkbox name=is_bertingkat'+i+' id=checkbox'+i+' value="1" /> <input type=hidden name=isi_kecil'+i+' id=isi_kecil'+i+' value="1" size=5 />'+
            '<img onclick=add_setting_harga('+i+'); title="Klik untuk setting harga" src="img/icons/add.png" class=add_kemasan align=right />'+
            '<img onclick=delete_setting_harga('+i+'); title="Klik untuk delete" src="img/icons/delete.png" class=delete_kemasan align=right style="margin: 0 5px;" />'+
            '<input type=hidden name=jumlah value="'+i+'" /></td></tr>';
    $('.packing').append(str);
    config_auto_suggest(i);
    $('#checkbox'+i).mouseover(function() {
        if ($(this).is(':checked') === false) {
            $('#checkbox'+i).attr('title', 'Check, jika menggunakan harga bertingkat');
        } else {
            $('#checkbox'+i).attr('title', 'Uncheck jika TIDAK menggunakan harga bertingkat');
        }
    });
}

function isi_satuan_terkecil(i) {
    var jml_baris = $('.barcode').length-1;
    for (j = 0; j <= jml_baris; j++) {
        /*var kemasan = $('#kemasan'+i).val();
        var isi     = $('#isi'+i).val();
        var satuan  = $('#satuan'+i).val();*/
        if ($('#kemasan'+i).val() === $('#satuan'+j).val()) {
            $('#isi_kecil'+j).val($('#isi'+i).val());
        }
    }
}

function config_auto_suggest(i) {
    
    var jml_baris = $('.barcode').length-1;
    if (i === jml_baris) {
        create_new_packing(i);
    } else {
        $('#kemasan'+(i+1)).val($('#satuan'+i).val());
        $('#satuan'+(i+1)).val($('#satuan'+i).val());
    }
}

function add_setting_harga(i) {
    var j   = $('.child'+i).length;
    var row = '<tr class="child'+i+'" id="child'+i+''+j+'"><td></td><td>'+
                '<table width=100% style="border-bottom: 1px dotted #ccc; margin-bottom: 5px; padding-bottom: 3px;">'+
                    '<tr><td colspan=2>&nbsp;</td></tr>'+
                    '<tr><td>Range Jual:</td><td><input type=text name=awal'+i+'[] id=awal'+i+''+j+' size=5 /> <div class="space"> s.d </div> <input type=text name=akhir'+i+'[] id=akhir'+i+''+j+' size=5 /></td><td>Diskon:</td><td><input type=text name=d_persen'+i+'[] id=d_persen'+i+''+j+' value="0" size=5 /> <div class="space"> (%) </div> <input type=text name=d_rupiah'+i+'[] value="0" id=d_rupiah'+i+''+j+' onblur="FormNum(this);" onfocus="javascript:this.value=currencyToNumber(this.value);" size=5 /></td></tr>'+
                    '<tr><td>Margin Non Resep:</td><td><input type=text name=margin_nr'+i+'[] id=margin_nr'+i+''+j+' size=5 /> <div class="space"> (%) </div> <input type=text id=margin_nr_rp'+i+''+j+' size=5 disabled /></td><td>Harga Jual Non Resep (Rp.):</td><td><span id="hj_nonresep'+i+''+j+'">-</span><input type=hidden name="hj_nonresep'+i+'[]" id="hj_nonresep_f'+i+''+j+'" /></td></tr>'+
                    '<tr><td>Margin Resep:</td><td><input type=text name=margin_r'+i+'[] id=margin_r'+i+''+j+' size=5 /> <div class="space"> (%) </div> <input type=text id=margin_r_rp'+i+''+j+' size=5 disabled /></td><td>Harga Jual Resep (Rp.):</td><td><span id="hj_resep'+i+''+j+'">-</span><input type=hidden name="hj_resep'+i+'[]" id="hj_resep_f'+i+''+j+'" /><img src="img/icons/delete.png" onclick="removeMe(this)" align=right /></td></tr>'+
                '</table>'+
            '</td></tr>';
    $(row).insertAfter('#mother'+i);
    detail_hitung_dinamic(i,j);
}

function detail_hitung_dinamic(i,j,status) {
    var isi = ($('#isi'+i).val()*$('#isi_kecil'+i).val());
    var mar_nr  = $('#margin_nr').val();
    var rp_nr   = parseInt(currencyToNumber($('#margin_nr_rp').val()))*isi;
    if (status !== 'edit') {
        $('#margin_nr'+i+''+j).val(mar_nr);
        $('#margin_nr_rp'+i+''+j).val(numberToCurrency(parseInt(rp_nr)));
    } else {
        var margin_nr_pr = ($('#margin_nr'+i+''+j).val()/100);
        var margin_nr_rp = rp_nr+(rp_nr*margin_nr_pr);
        $('#margin_nr_rp'+i+''+j).val(numberToCurrency(parseInt(margin_nr_rp)));
    }
    var mar_r   = $('#margin_r').val();
    var rp_r    = parseInt(currencyToNumber($('#margin_r_rp').val()))*isi;
    if (status !== 'edit') {
        $('#margin_r'+i+''+j).val(mar_r);
        $('#margin_r_rp'+i+''+j).val(numberToCurrency(parseInt(rp_r)));
    } else {
        var margin_r_pr = ($('#margin_r'+i+''+j).val()/100);
        var margin_r_rp = rp_nr+(rp_nr*margin_r_pr);
        $('#margin_r_rp'+i+''+j).val(numberToCurrency(parseInt(margin_r_rp)));
    }
    $('#d_persen'+i+''+j).keyup(function() {
        if ($(this).val() > 0) {
            $('#d_rupiah'+i+''+j).val('0');
        }
        hitung_dinamic_hja(i,j);
    });
    $('#awal'+i+''+j+', #akhir'+i+''+j).keyup(function() {
        hitung_dinamic_hja(i,j);
    });
    $('#d_rupiah'+i+''+j).keyup(function() {
        if ($(this).val() > 0) {
            $('#d_persen'+i+''+j).val('0');
        }
        hitung_dinamic_hja(i,j);
    });
    $('#margin_nr'+i+''+j).keyup(function() {
        var margin_nr_pr= ($(this).val()/100);
        var margin_nr_rp= rp_nr+(rp_nr*margin_nr_pr);
        $('#margin_nr_rp'+i+''+j).val(numberToCurrency(parseInt(margin_nr_rp)));
        hitung_dinamic_hja(i,j);
    });
    $('#margin_r'+i+''+j).keyup(function() {
        var margin_r_pr= ($(this).val()/100);
        var margin_r_rp= rp_nr+(rp_nr*margin_r_pr);
        $('#margin_r_rp'+i+''+j).val(numberToCurrency(parseInt(margin_r_rp)));
        hitung_dinamic_hja(i,j);
    });
}

function hitung_dinamic_hja(i,j) {
    var diskon_pr  = $('#d_persen'+i+''+j).val()/100;
    var diskon_rp  = parseInt(currencyToNumber($('#d_rupiah'+i+''+j).val()));
    
    var margin_nr_rp  = parseInt(currencyToNumber($('#margin_nr_rp'+i+''+j).val()));
    var margin_r_rp   = parseInt(currencyToNumber($('#margin_r_rp'+i+''+j).val()));
    
    if (diskon_pr !== 0) {
        hja_nr  = margin_nr_rp-(diskon_pr*margin_nr_rp);
        hja_r   = margin_r_rp-(diskon_pr*margin_r_rp);
    } else {
        hja_nr  = margin_nr_rp-diskon_rp;
        hja_r   = margin_r_rp-diskon_rp;
    }
    $('#hj_nonresep'+i+''+j).html(numberToCurrency(parseInt(hja_nr)));
    $('#hj_nonresep_f'+i+''+j).val(parseInt(hja_nr));
    
    $('#hj_resep'+i+''+j).html(numberToCurrency(parseInt(hja_r)));
    $('#hj_resep_f'+i+''+j).val(parseInt(hja_r));
    //var hja_nr        = 
}

function delete_setting_harga(i) {
    $('<div>Anda yakin akan menghapus baris ini?</div>').dialog({
        autoOpen: true,
        modal: true,
        title: 'Information Alert',
        buttons: {
            "OK": function() {
                $('tr#mother'+i).remove();
                $('tr.child'+i).remove();
                $(this).dialog().remove();
            }, "Cancel": function() {
                $(this).dialog().remove();
            }
        }
    });
    
}

function removeMe(el) {
    $('<div>Anda yakin akan menghapus baris ini?</div>').dialog({
        autoOpen: true,
        modal: true,
        title: 'Information Alert',
        buttons: {
            "OK": function() {
                $(this).dialog().remove();
                var parent = el.parentNode.parentNode.parentNode.parentNode;
                parent.parentNode.removeChild(parent);
            }, "Cancel": function() {
                $(this).dialog().remove();
            }
        }
    });
    
}

function hitung_hja() {
    var hna     = parseInt(currencyToNumber($('#hna').val()));
    var mar_nr  = $('#margin_nr').val();
    var mar_r   = $('#margin_r').val();
    var rp_nr   = hna+(hna*(mar_nr/100));
    var rp_r    = hna+(hna*(mar_r/100));
    $('#margin_nr_rp').val(numberToCurrency(parseInt(rp_nr)));
    $('#margin_r_rp').val(numberToCurrency(parseInt(rp_r)));
}

function form_add() {
var str = '<div id=form_add>'+
            '<form id="form_barang">'+
                '<div id="tabs">'+
                    '<ul>'+
                        '<li><a href="#tabs-1">Data Utama</a></li>'+
                        '<li><a href="#tabs-2">Pelengkap</a></li>'+
                        '<li><a href="#tabs-3">Kemasan Produk</a></li>'+
                    '</ul>'+
                    '<div id="tabs-1"><?= form_hidden('id_barang', NULL, 'id=id_barang') ?>'+
                            '<table width="100%"><tr valign=top><td width="60%"><table width=100% class=data-input>'+
                                '<tr><td width=48%>Nama Barang:</td><td><?= form_input('nama', NULL, 'id=nama size=50 onBlur="javascript:this.value=this.value.toUpperCase();"') ?></td></tr>'+
                                '<tr><td>Pabrik:</td><td><?= form_input('pabrik', NULL, 'id=pabrik size=50') ?><?= form_hidden('id_pabrik', NULL, 'id=id_pabrik') ?></td></tr>'+
                                '<tr><td>Kekuatan:</td><td><?= form_input('kekuatan', NULL, 'id=kekuatan style="min-width: 147px;"') ?></td></tr>'+
                                '<tr><td>Satuan Kekuatan:</td><td><select name=s_sediaan id=s_sediaan><option value="">Pilih ...</option><?php foreach ($satuan_kekuatan as $data) { echo '<option value="'.$data->id.'">'.$data->nama.'</option>'; } ?></select></td></tr>'+
                                '<tr><td>Sediaan:</td><td><select name=sediaan id=sediaan><option value="">Pilih ...</option><?php foreach ($sediaan as $data) { echo '<option value="'.$data->id.'">'.$data->nama.'</option>'; } ?></select></td></tr>'+
                                '<tr><td>Golongan:</td><td><select name=golongan id=golongan><option value="">Pilih ...</option><?php foreach ($golongan as $data) { echo '<option value="'.$data->id.'">'.$data->nama.'</option>'; } ?></select></td></tr>'+
                                '<tr><td>Formularium:</td><td><?= form_radio('formularium', 'Ya', 'yes', 'Ya', FALSE) ?> <?= form_radio('formularium', 'Tidak', 'no', 'Tidak', TRUE) ?></td></tr>'+
                                '<tr><td>R Administrasi:</td><td><select name=admr id=admr><option value="">Pilih ...</option><?php foreach ($admr as $data) { echo '<option value="'.$data.'">'.$data.'</option>'; } ?></select></td></tr>'+
                                '<tr><td></td><td><?= form_radio('generik', '1', 'ya', 'Generik', TRUE) ?> <?= form_radio('generik', '0', 'tidak', 'Non Generik') ?></td></tr>'+
                                '<tr><td>Perundangan:</td><td><select name="perundangan" id="perundangan"><?php foreach ($perundangan as $data) { echo '<option value="'.$data.'">'.$data.'</option>'; } ?></select></td></tr>'+
                                '<tr><td>Farmakoterapi:</td><td><select style="max-width: 147px;" name=farmakoterapi id=farmakoterapi><option value="">Pilih ...</option><?php foreach ($farmakoterapi as $data) { echo '<option value="'.$data->id.'">'.$data->nama.'</option>'; } ?></select></td></tr>'+
                                '<tr><td>Kelas Terapi:</td><td><select name=kls_terapi id=kls_terapi style="max-width: 147px;"><option value="">Pilih ...</option></select></td></tr></table></div>'+
                                '</td><td width=2%>&nbsp;</td><td width=38%>'+
                                '<table width=100% class=data-input>'+
                                    '<tr><td>Rak:</td><td><?= form_input('rak', NULL, 'id=rak style="min-width: 147px;"') ?></td></tr>'+
                                    '<tr><td width=50%>Stok Minimal:</td><td><?= form_input('stok_min', NULL, 'id=stok_min style="width: 60px;"') ?></td></tr>'+
                                    '<tr><td>Margin Non Resep:</td><td><?= form_input('margin_nr', NULL, 'id=margin_nr style="width: 60px;" onkeyup=hitung_hja()') ?> % <?= form_input('margin_nr_rp', NULL, 'id=margin_nr_rp style="width: 63px;" disabled') ?></td></tr>'+
                                    '<tr><td>Margin Resep:</td><td><?= form_input('margin_r', NULL, 'id=margin_r style="width: 60px;" onkeyup=hitung_hja()') ?> % <?= form_input('margin_r_rp', NULL, 'id=margin_r_rp disabled style="width: 63px;"') ?></td></tr>'+
                                    '<tr><td>HNA:</td><td><?= form_input('hna', NULL, 'id=hna onblur="FormNum(this)" onkeyup=hitung_hja() style="width: 147px;"') ?></td></tr>'+
                                    '<tr><td></td><td>&nbsp;</td></tr>'+
                                    '<tr><td></td><td><?= form_checkbox('aktifasi', '1', 'aktifasi', 'Aktifasi') ?></td></tr>'+
                                '</table>'+
                            '</td></tr></table>'+
                    '</div>'+
                    '<div id="tabs-2"><table width=100% class=data-input>'+
                                '<tr><td width=17% valign=top>Kandungan:</td><td><?= form_textarea('kandungan', NULL, 'cols=48 id=kandungan') ?></td></tr>'+
                                '<tr><td valign=top>Indikasi:</td><td><?= form_textarea('indikasi', NULL, 'cols=48 id=indikasi') ?></td></tr>'+
                                '<tr><td valign=top>Perhatian:</td><td><?= form_textarea('perhatian', NULL, 'cols=48 id=perhatian') ?></td></tr>'+
                                '<tr><td valign=top>Kontra Indikasi:</td><td><?= form_textarea('kontra_indikasi', NULL, 'cols=48 id=kontra_indikasi') ?></td></tr>'+
                                '<tr><td valign=top>Efek Samping:</td><td><?= form_textarea('efek_samping', NULL, 'cols=48 id=efek_samping') ?></td></tr>'+
                                '<tr><td valign=top>Dosis:</td><td><?= form_textarea('dosis', NULL, 'cols=48 id=dosis') ?></td></tr>'+
                                '<tr><td valign=top>Aturan Pakai:</td><td><?= form_textarea('aturan_pakai', NULL, 'cols=48 id=aturan_pakai') ?></td></tr>'+
                                '<tr><td>FDA Pregnancy:</td><td><select name=fda_pregnan id=fda_pregnan><option value="">Pilih ...</option><?php foreach ($fda as $data) { echo '<option value="'.$data.'">'.$data.'</option>'; } ?></select></td></tr>'+
                                '<tr><td>FDA Lactacy:</td><td><select name=fda_lactacy id=fda_lactacy><option value="">Pilih ...</option><?php foreach ($fda as $data) { echo '<option value="'.$data.'">'.$data.'</option>'; } ?></select></td></tr>'+

                            '</table></div>'+
                    '<div id="tabs-3"><?= form_hidden('id_kemasan', NULL, 'id=id_kemasan') ?>'+
                        '<img src="img/icons/add-kemasan.png" id=add_kemasan align=left style="margin-bottom: 3px;" />'+
                            '<table width=100% class="data-input packing">'+
                                
                            '</table>'+
                    '</div>'+
                '</div></form>'+
              '</div>';
    $('body').append(str);
    $('#tabs').tabs();
    $('add_kemasan').button();
    $('#farmakoterapi').change(function() {
        var id = $(this).val();
        $.getJSON('models/autocomplete.php?method=farmakoterapi&id='+id, function(data){
            $('#kls_terapi').html('');
            $.each(data, function (index, value) {
                $('#kls_terapi').append("<option value='"+value.id+"'>"+value.nama+"</option>");
            });
        });
    });
    
    $('#golongan').change(function() {
        var id = $(this).val();
        $.ajax({
            url: 'models/autocomplete.php?method=golongan_load_data&id='+id,
            cache: false,
            dataType: 'json',
            success: function(data) {
                $('#margin_nr').val(data.margin_non_resep);
                $('#margin_r').val(data.margin_resep);
            }
        });
    });
    $('#add_kemasan').click(function() {
        var jml = $('.mother').length;
        kemasan_add(jml);
        $('.mother:eq('+jml+')').attr('id', 'mother'+jml);
    });
    var lebar = $('#pabrik').width();
    /*$('#nama').autocomplete("models/autocomplete.php?method=barang",
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
        $('#hna').val(numberToCurrency(data.hna));
        $('#id_barang').val(data.id);
    });*/
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
    var dHeight= wHeight * 1;
    $('#form_add').dialog({
        title: 'Tambah Barang',
        autoOpen: true,
        modal: true,
        width: 800,
        height: 480,
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
            var jml = $('.mother').length;
            kemasan_add(jml);
            $('.mother:eq('+jml+')').attr('id', 'mother'+jml);
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
                        $('input[type=text], textarea, select').val('');
                        load_data_barang('1','',data.id_barang);
                    } else {
                        alert_edit();
                        $('#form_add').dialog().remove();
                        var page = $('.noblock').html();
                        load_data_barang(page,'');
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
    
    if (arr[11] === '1') { $('#yes').attr('checked','checked'); }
    if (arr[11] === '0') { $('#no').attr('checked','checked'); }
    
    $('#indikasi').val(arr[12]);
    $('#dosis').val(arr[13]);
    $('#kandungan').val(arr[14]);
    $('#perhatian').val(arr[15]);
    $('#kontra_indikasi').val(arr[16]);
    $('#efek_samping').val(arr[17]);
    $('#stok_min').val(arr[18]);
    $('#margin_nr').val(arr[19]);
    $('#margin_r').val(arr[20]);
    if (arr[21] === '0') { $('#ppn').removeAttr('checked'); } else { $('#ppn').attr('checked','checked'); }
    $('#hna').val(numberToCurrency(arr[22]));
    if (arr[23] === '0') { $('#aktifasi').removeAttr('checked'); } else { $('#aktifasi').attr('checked','checked'); }
    $('#aturan_pakai').val(arr[24]);
    $('#farmakoterapi').val(arr[25]);
    $.getJSON('models/autocomplete.php?method=farmakoterapi&id='+arr[25], function(data){
        $('#kls_terapi').html('');
        $.each(data, function (index, value) {
            $('#kls_terapi').append("<option value='"+value.id+"'>"+value.nama+"</option>");
        });
        $('#kls_terapi').val(arr[26]);
    });
    $.ajax({
        url: 'pages/kemasan-edit.php',
        data: 'id='+arr[0],
        cache: false,
        success: function(data) {
            $('.packing').html(data);
        }
    });
    $('#fda_pregnan').val(arr[27]);
    $('#fda_lactacy').val(arr[28]);
    hitung_hja();
}
function delete_barang(id, page) {
    $('<div id=alert>Anda yakin akan menghapus data ini?</div>').dialog({
        title: 'Konfirmasi Penghapusan',
        autoOpen: true,
        modal: true,
        buttons: {
            "OK": function() {
                
                $.ajax({
                    url: 'models/update-masterdata.php?method=delete_barang&id='+id,
                    cache: false,
                    success: function() {
                        load_data_barang(page);
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
<h1 class="margin-t-0">Data Produk</h1>
<hr>
<button id="button">Tambah Data</button>
<button id="reset">Reset</button>
<div id="result-barang">
    
</div>