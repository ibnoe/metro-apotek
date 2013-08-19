<?php

set_include_path("../");
include_once("inc/essentials.php");
include_once("inc/functions.php");
include_once("models/masterdata.php");
include_once("pages/message.php");
?>

<script type="text/javascript">
$(function() {
    load_data_penyakit();
    $('#search').keyup(function() {
        var value = $(this).val();
        load_data_penyakit('',value,'');
    });
});
function form_add() {
var str = '<div id=form_add>'+
            '<form action="" method=post id="save_barang">'+
            '<?= form_hidden('id_penyakit', NULL, 'id=id_penyakit') ?>'+
            '<table width=100% class=data-input>'+
                '<tr><td>Topik:</td><td><?= form_input('penyakit', NULL, 'id=penyakit size=50') ?></td></tr>'+
                '<tr><td width=30%>Sub Kode:</td><td><?= form_input('subkode', NULL, 'id=subkode size=10') ?></td></tr>'+
            '</table>'+
            '</form>'+
            '</div>';
    $('body').append(str);
    $('#form_add').dialog({
        title: 'Tambah penyakit',
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
    var lebar = $('#penyakit').width();
    $('#penyakit').dblclick(function() {
        $('<div title="Data penyakit" id="penyakit-data"></div>').dialog({
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
        var cek_id = $('#id_penyakit').val();
        $.ajax({
            url: 'models/update-masterdata.php?method=save_penyakit',
            type: 'POST',
            dataType: 'json',
            data: $(this).serialize(),
            cache: false,
            success: function(data) {
                if (data.status === true) {
                    if (cek_id === '') {
                        alert_tambah();
                        $('input').val('');
                        load_data_penyakit('1','',data.id_penyakit);
                    } else {
                        alert_edit();
                        $('#form_add').dialog().remove();
                        load_data_penyakit('1','',data.id_penyakit);
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
    load_data_penyakit();
    $('#search').val('');
});
$('#button').click(function() {
    form_add();
});
$.plugin($afterSubPageShow,{ // <-- event is here
    showAlert:function(){ // <-- random function name is here (choose whatever you want)
    /* The code that will be executed */
    }
});
function load_data_penyakit(page, search, id) {
    pg = page; src = search; id_barg = id;
    if (page === undefined) { var pg = ''; }
    if (search === undefined) { var src = ''; }
    if (id === undefined) { var id_barg = ''; }
    $.ajax({
        url: 'pages/penyakit-list.php',
        cache: false,
        data: 'page='+pg+'&search='+src+'&id_penyakit='+id_barg,
        success: function(data) {
            $('#result-penyakit').html(data);
        }
    });
}

function paging(page, tab, search) {
    load_data_penyakit(page, search);
}

function edit_penyakit(str) {
    var arr = str.split('#');
    form_add();
    $('#form_add').dialog({ title: 'Edit penyakit' });
    $('#id_penyakit').val(arr[0]);
    $('#subkode').val(arr[2]);
    $('#penyakit').val(arr[1]);
}

function delete_penyakit(id, page) {
    $('<div id=alert>Anda yakin akan menghapus data ini?</div>').dialog({
        title: 'Konfirmasi Penghapusan',
        autoOpen: true,
        modal: true,
        buttons: {
            "OK": function() {
                
                $.ajax({
                    url: 'models/update-masterdata.php?method=delete_penyakit&id='+id,
                    cache: false,
                    success: function() {
                        load_data_penyakit(page);
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
$.plugin($afterSubPageShow,{ // <-- event is here
    showAlert:function(){ // <-- random function name is here (choose whatever you want)
        $('#search').focus();
    }
});
</script>
<h1 class="margin-t-0">Data Penyakit ICD X</h1>
<hr>
<button id="button">Tambah Data</button>
<button id="reset">Reset</button>
<?= form_input('search', NULL, 'id=search placeholder="Search ..." class=search') ?>
<div id="result-penyakit">
    
</div>