<?php
set_include_path("../");
include_once("inc/essentials.php");
include_once("inc/functions.php");
include_once("models/masterdata.php");
include_once("pages/message.php");
?>

<script type="text/javascript">
$(function() {
    load_data_golongan();
});
function form_add() {
var str = '<div id=form_add>'+
            '<form action="" method=post id="save_barang">'+
            '<?= form_hidden('id_golongan', NULL, 'id=id_golongan') ?>'+
            '<table width=100% class=data-input>'+
                '<tr><td width=40%>Nama:</td><td><?= form_input('nama', NULL, 'id=nama size=40') ?></td></tr>'+
                '<tr><td>Margin Non Resep:</td><td><?= form_input('margin_nr', NULL, 'id=margin_nr size=5 maxlength=4') ?> %</td></tr>'+
                '<tr><td width=40%>Margin Resep:</td><td><?= form_input('margin_r', NULL, 'id=margin_r size=5 maxlength=4') ?> %</td></tr>'+
                '<tr><td>Diskon:</td><td><?= form_input('diskon', NULL, 'id=diskon size=5 maxlength=4') ?> %</td></tr>'+
            '</table>'+
            '</form>'+
            '</div>';
    $('body').append(str);
    $('#form_add').dialog({
        title: 'Tambah golongan',
        autoOpen: true,
        width: 480,
        height: 220,
        modal: false,
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
    var lebar = $('#golongan').width();
    $('#golongan').dblclick(function() {
        $('<div title="Data golongan" id="golongan-data"></div>').dialog({
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
            alert('Nama barang tidak boleh kosong !');
            $('#nama').focus(); return false;
        }
        var cek_id = $('#id_golongan').val();
        $.ajax({
            url: 'models/update-masterdata.php?method=save_golongan',
            type: 'POST',
            dataType: 'json',
            data: $(this).serialize(),
            cache: false,
            success: function(data) {
                if (data.status === true) {
                    if (cek_id === '') {
                        alert_tambah();
                        $('input').val('');
                        load_data_golongan('1','',data.id_golongan);
                    } else {
                        alert_edit();
                        $('#form_add').dialog().remove();
                        load_data_golongan('1','',data.id_golongan);
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
});
$('#reset').button({
    icons: {
        primary: 'ui-icon-refresh'
    }
}).click(function() {
    load_data_golongan();
});
$('#button').click(function() {
    form_add();
});
$.plugin($afterSubPageShow,{ // <-- event is here
    showAlert:function(){ // <-- random function name is here (choose whatever you want)
    /* The code that will be executed */
    }
});
function load_data_golongan(page, search, id) {
    pg = page; src = search; id_barg = id;
    if (page === undefined) { var pg = ''; }
    if (search === undefined) { var src = ''; }
    if (id === undefined) { var id_barg = ''; }
    $.ajax({
        url: 'pages/golongan-list.php',
        cache: false,
        data: 'page='+pg+'&search='+src+'&id_golongan='+id_barg,
        success: function(data) {
            $('#result-golongan').html(data);
        }
    });
}

function paging(page, tab, search) {
    load_data_golongan(page, search);
}

function edit_golongan(str) {
    var arr = str.split('#');
    form_add();
    $('#form_add').dialog({ title: 'Edit golongan' });
    $('#id_golongan').val(arr[0]);
    $('#nama').val(arr[1]);
    $('#margin_nr').val(arr[2]);
    $('#margin_r').val(arr[3]);
    $('#diskon').val(arr[4]);
}

function delete_golongan(id, page) {
    $('<div id=alert>Anda yakin akan menghapus data ini?</div>').dialog({
        title: 'Konfirmasi Penghapusan',
        autoOpen: true,
        modal: true,
        buttons: {
            "OK": function() {
                
                $.ajax({
                    url: 'models/update-masterdata.php?method=delete_golongan&id='+id,
                    cache: false,
                    success: function() {
                        load_data_golongan(page);
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
<h1 class="margin-t-0">Data golongan</h1>
<hr>
<button id="button">Tambah Data</button>
<button id="reset">Reset</button>
<div id="result-golongan">
    
</div>