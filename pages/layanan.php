<?php
$subNav = array(
	"Utama ; layanan.php ; #509601;"
);

set_include_path("../");
include_once("inc/essentials.php");
include_once("inc/functions.php");
include_once("models/masterdata.php");
include_once("pages/message.php");
$akun = load_data_akun();
?>

<script type="text/javascript">
$(function() {
    load_data_layanan();
});
function form_add() {
var str = '<div id=form_add>'+
            '<form action="" method=post id="save_barang">'+
            '<?= form_hidden('id_layanan', NULL, 'id=id_layanan') ?>'+
            '<table width=100% class=data-input>'+
                '<tr><td width=40%>Nama layanan:</td><td><?= form_input('nama', NULL, 'id=nama size=40') ?></td></tr>'+
                '<tr><td>Charge (%):</td><td><?= form_input('charge', NULL, 'id=charge size=40') ?></td></tr>'+
                '<tr><td width=40%>Kode Akun:</td><td><select name=akun id=akun><option value="">Pilih ...</option><?php foreach ($akun as $data) { echo '<option value="'.$data->kode.'">'.$data->kode.' '.$data->kelompok.'</option>'; } ?></select></td></tr>'+
            '</table>'+
            '</form>'+
            '</div>';
    $('body').append(str);
    $('#form_add').dialog({
        title: 'Tambah layanan',
        autoOpen: true,
        width: 480,
        height: 200,
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
            alert('Nama layanan tidak boleh kosong !');
            $('#nama').focus(); return false;
        }
        if ($('#charge').val() === '') {
            alert('Charge tidak boleh kosong !');
            $('#kemasan').focus(); return false;
        }
        var cek_id = $('#id_layanan').val();
        $.ajax({
            url: 'models/update-masterdata.php?method=save_layanan',
            type: 'POST',
            dataType: 'json',
            data: $(this).serialize(),
            cache: false,
            success: function(data) {
                if (data.status === true) {
                    if (cek_id === '') {
                        alert_tambah();
                        $('input').val('');
                        load_data_layanan('1','',data.id_layanan);
                    } else {
                        alert_edit();
                        $('#form_add').dialog().remove();
                        load_data_layanan('1','',data.id_layanan);
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
function load_data_layanan(page, search, id) {
    pg = page; src = search; id_barg = id;
    if (page === undefined) { var pg = ''; }
    if (search === undefined) { var src = ''; }
    if (id === undefined) { var id_barg = ''; }
    $.ajax({
        url: 'pages/layanan-list.php',
        cache: false,
        data: 'page='+pg+'&search='+src+'&id_layanan='+id_barg,
        success: function(data) {
            $('#result-layanan').html(data);
        }
    });
}

function paging(page, tab, search) {
    load_data_layanan(page, search);
}

function edit_layanan(str) {
    var arr = str.split('#');
    form_add();
    $('#form_add').dialog({ title: 'Edit layanan' });
    $('#id_layanan').val(arr[0]);
    $('#nama').val(arr[1]);
    $('#charge').val(arr[2]);
    $('#akun').val(arr[3]);
}
function delete_layanan(id, page) {
    $('<div id=alert>Anda yakin akan menghapus data ini?</div>').dialog({
        title: 'Konfirmasi Penghapusan',
        autoOpen: true,
        modal: true,
        buttons: {
            "OK": function() {
                
                $.ajax({
                    url: 'models/update-masterdata.php?method=delete_layanan&id='+id,
                    cache: false,
                    success: function() {
                        load_data_layanan(page);
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
<h1 class="margin-t-0">Data layanan</h1>
<hr>
<button id="button">Tambah Data</button>
<div id="result-layanan">
    
</div>