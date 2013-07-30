<?php
$subNav = array(
	"Utama ; dokter.php ; #509601;",
	"Jadwal Praktek ; jadwalpraktek.php ; #509601;",
);

set_include_path("../");
include_once("inc/essentials.php");
include_once("inc/functions.php");
include_once("models/masterdata.php");
include_once("pages/message.php");
?>

<script type="text/javascript">
load_data_dokter();
function form_add() {
var str = '<div id=form_add>'+
            '<form action="" method=post id="save_dokter">'+
            '<?= form_hidden('id_dokter', NULL, 'id=id_dokter') ?>'+
            '<table width=100% class=data-input>'+
                '<tr><td width=30%>Nama:</td><td width=70%><?= form_input('nama', NULL, 'id=nama size=40 onBlur="javascript:this.value=this.value.toUpperCase();"') ?></td></tr>'+
                '<tr><td>Kelamin:</td><td><input type="radio" name=kelamin value="P" checked id="prm" /> <label for="prm">Perempuan</label> <input type="radio" name=kelamin value="L" id="l" /> <label for="l">Laki-laki</label></td></tr>'+
                '<tr><td>Alamat:</td><td><?= form_input('alamat', NULL, 'id=alamat size=40 onBlur="javascript:this.value=this.value.toUpperCase();"') ?><input type=hidden name="id_pabrik" /></td></tr>'+
                '<tr><td>Telp:</td><td><?= form_input('telp', '', 'id=telp size=40') ?></td></tr>'+
                '<tr><td>Email:</td><td><?= form_input('email','', 'id=email size=40') ?></td></tr>'+
                '<tr><td>No. STR:</td><td><?= form_input('nostr', '', 'id=nostr size=40') ?></td></tr>'+
                '<tr><td>Spesialis:</td><td><?= form_input('spesialis', '', 'id=spesialis size=40') ?></td></tr>'+
                '<tr><td>Tgl Mulai Praktek:</td><td><?= form_input('tglmulai', '', 'id=tglmulai size=40') ?></td></tr>'+
            '</table>'+
            '</form>'+
            '</div>';
    $('body').append(str);
    $('input[type=text]').blur(function() {
        this.value=this.value.toUpperCase();
    });
    $('#form_add').dialog({
        title: 'Tambah Customer',
        autoOpen: true,
        width: 480,
        height: 320,
        modal: true,
        hide: 'clip',
        show: 'blind',
        buttons: {
            "Simpan": function() {
                $('#save_dokter').submit();
            }, "Cancel": function() {
                $(this).dialog().remove();
            }
        }, close: function() {
            $(this).dialog().remove();
        }
    });
    $('#tglmulai').datepicker({
        maxDate: 0,
        changeYear: true,
        changeMonth: true
    });
    
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
    
    
    $('#save_dokter').submit(function() {
        if ($('#nama').val() === '') {
            alert('Nama dokter tidak boleh kosong !');
            $('#nama').focus(); return false;
        }
        var cek_id = $('#id_dokter').val();
        $.ajax({
            url: 'models/update-masterdata.php?method=save_dokter',
            type: 'POST',
            dataType: 'json',
            data: $(this).serialize(),
            cache: false,
            success: function(data) {
                if (data.status === true) {
                    if (cek_id === '') {
                        alert_tambah();
                        $('input[type=text]').val('');
                        load_data_dokter('1','',data.id_dokter);
                    } else {
                        alert_edit();
                        $('#form_add').dialog().remove();
                        load_data_dokter('1','',data.id_dokter);
                    }
                }
            }
        });
        return false;
    });
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
    /* The code that will be executed */
    }
});
function load_data_dokter(page, search, id) {
    pg = page; src = search; id_barg = id;
    if (page === undefined) { var pg = ''; }
    if (search === undefined) { var src = ''; }
    if (id === undefined) { var id_barg = ''; }
    $.ajax({
        url: 'pages/dokter-list.php',
        cache: false,
        data: 'page='+pg+'&search='+src+'&id_dokter='+id_barg,
        success: function(data) {
            $('#result-dokter').html(data);
        }
    });
}

function paging(page, tab, search) {
    load_data_dokter(page, search);
}

function edit_dokter(str) {
    
    var arr = str.split('#');
    form_add();
    $('#form_add').dialog({ title: 'Edit dokter' });
    $('#id_dokter').val(arr[0]);
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

function delete_dokter(id, page) {
    $('<div id=alert>Anda yakin akan menghapus data ini?</div>').dialog({
        title: 'Konfirmasi Penghapusan',
        autoOpen: true,
        modal: true,
        buttons: {
            "OK": function() {
                $.ajax({
                    url: 'models/update-masterdata.php?method=delete_dokter&id='+id,
                    cache: false,
                    success: function() {
                        load_data_dokter(page);
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
<h1 class="margin-t-0">Data dokter</h1>
<hr>
<button id="button">Tambah Data</button>
<div id="result-dokter">
    
</div>