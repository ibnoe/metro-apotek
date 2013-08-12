<?php
$subNav = array(
	"Karyawan ; karyawan.php ; #509601;",
        "Dokter ; dokter.php ; #509601;",
        "Jadwal Praktek Dokter ; jadwalpraktek.php ; #509601;",
);

set_include_path("../");
include_once("inc/essentials.php");
include_once("inc/functions.php");
include_once("models/masterdata.php");
include_once("pages/message.php");
$asuransi = load_data_asuransi();
?>

<script type="text/javascript">
load_data_karyawan();
function form_add() {
var str = '<div id=form_add>'+
            '<form action="" method=post id="save_barang">'+
            '<?= form_hidden('id_karyawan', NULL, 'id=id_karyawan') ?>'+
            '<table width=100% class=data-input>'+
                '<tr><td width=30%>Nama:</td><td width=70%><?= form_input('nama', NULL, 'id=nama size=40 onBlur="javascript:this.value=this.value.toUpperCase();"') ?></td></tr>'+
                '<tr><td>Kelamin:</td><td><input type="radio" name=kelamin value="P" checked id="prm" /> <label for="prm">Perempuan</label> <input type="radio" name=kelamin value="L" id="l" /> <label for="l">Laki-laki</label></td></tr>'+
                '<tr><td>Tempat / Tgl Lahir:</td><td><input type=text name=tmp_lahir size=5 style="min-width: 200px;" id=tmp_lahir /> / <input type=text name=tgl_lahir style="min-width: 80px;" size=5 id="tanggal" /></td></tr>'+
                '<tr><td>Alamat:</td><td><?= form_input('alamat', NULL, 'id=alamat size=40 onBlur="javascript:this.value=this.value.toUpperCase();"') ?><input type=hidden name="id_pabrik" /></td></tr>'+
                '<tr><td>Kab. / Kodya:</td><td><?= form_input('kabupaten', '', 'id=kabupaten size=40') ?></td></tr>'+
                '<tr><td>Provinsi:</td><td><?= form_input('provinsi', '', 'id=provinsi size=40') ?></td></tr>'+
                '<tr><td>Telp:</td><td><?= form_input('telp', '', 'id=telp size=40') ?></td></tr>'+
                '<tr><td>Email:</td><td><?= form_input('email','', 'id=email size=40') ?></td></tr>'+
                '<tr><td>Jabatan:</td><td><select name=jabatan id=jabatan><option value="APA">APA</option><option value="Kasir">Kasir</option><option value="Staff">Staff</option></select></td></tr>'+
                '<tr><td>No. SIPA:</td><td><?= form_input('sipa', '', 'id=sipa size=40') ?></td></tr>'+
            '</table>'+
            '</form>'+
            '</div>';
    $('body').append(str);
    $('input[type=text]').blur(function() {
        this.value=this.value.toUpperCase();
    });
    $('#form_add').dialog({
        title: 'Tambah karyawan',
        autoOpen: true,
        width: 480,
        height: 370,
        modal: true,
        hide: 'clip',
        show: 'blind',
        buttons: {
            "Simpan": function() {
                $('#save_barang').submit();
            }, "Cancel": function() {
                $(this).dialog().remove();
            }
        }, close: function() {
            $(this).dialog().remove();
        }
    });
    $('#tanggal').datepicker({
        maxDate: 0,
        changeYear: true,
        changeMonth: true
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
    
    
    $('#save_barang').submit(function() {
        if ($('#nama').val() === '') {
            alert('Nama karyawan tidak boleh kosong !');
            $('#nama').focus(); return false;
        }
        var cek_id = $('#id_karyawan').val();
        $.ajax({
            url: 'models/update-masterdata.php?method=save_karyawan',
            type: 'POST',
            dataType: 'json',
            data: $(this).serialize(),
            cache: false,
            success: function(data) {
                if (data.status === true) {
                    if (cek_id === '') {
                        alert_tambah();
                        $('input[type=text]').val('');
                        load_data_karyawan('1','',data.id_karyawan);
                    } else {
                        alert_edit();
                        $('#form_add').dialog().remove();
                        load_data_karyawan('1','',data.id_karyawan);
                    }
                    
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
}).click(function() {
    form_add();
});
$('#reset').button({
    icons: {
        primary: 'ui-icon-refresh'
    }
}).click(function() {
    load_data_karyawan();
});
$.plugin($afterSubPageShow,{ // <-- event is here
    showAlert:function(){ // <-- random function name is here (choose whatever you want)
    
    /* The code that will be executed */
    
    
    }
});
function load_data_karyawan(page, search, id) {
    pg = page; src = search; id_barg = id;
    if (page === undefined) { var pg = ''; }
    if (search === undefined) { var src = ''; }
    if (id === undefined) { var id_barg = ''; }
    $.ajax({
        url: 'pages/karyawan-list.php',
        cache: false,
        data: 'page='+pg+'&search='+src+'&id_karyawan='+id_barg,
        success: function(data) {
            $('#result-karyawan').html(data);
        }
    });
}

function paging(page, tab, search) {
    load_data_karyawan(page, search);
}

function edit_karyawan(str) {
    
    var arr = str.split('#');
    form_add();
    $('#form_add').dialog({ title: 'Edit karyawan' });
    $('#id_karyawan').val(arr[0]);
    $('#nama').val(arr[1]);
    if (arr[2] === 'P') { $('#prm').attr('checked','checked'); }
    if (arr[2] === 'L') { $('#l').attr('checked','checked'); }
    $('#tmp_lahir').val(arr[3]);
    $('#tanggal').val(arr[4]);
    $('#alamat').val(arr[5]);
    $('#kabupaten').val(arr[6]);
    $('#provinsi').val(arr[7]);
    $('#telp').val(arr[8]);
    $('#email').val(arr[9]);
    $('#jabatan').val(arr[10]);
    $('#sipa').val(arr[11]);
    
}

function delete_karyawan(id, page) {
    $('<div id=alert>Anda yakin akan menghapus data ini?</div>').dialog({
        title: 'Konfirmasi Penghapusan',
        autoOpen: true,
        modal: true,
        buttons: {
            "OK": function() {
                $.ajax({
                    url: 'models/update-masterdata.php?method=delete_karyawan&id='+id,
                    cache: false,
                    success: function() {
                        load_data_karyawan(page);
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
<h1 class="margin-t-0">Data karyawan</h1>
<hr>
<button id="button">Tambah Data</button>
<button id="reset">Reset</button>
<div id="result-karyawan">
    
</div>