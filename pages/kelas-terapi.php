<?php
$subNav = array(
	"Farmakoterapi ; farmakoterapi.php ; #509601;",
        "Kelas Terapi ; kelas-terapi.php ; #509601;"
);
set_include_path("../");
include_once("inc/essentials.php");
include_once("inc/functions.php");
include_once("models/masterdata.php");
include_once("pages/message.php");
$farmakoterapi = farmakoterapi_load_data();
?>

<script type="text/javascript">
$(function() {
    load_data_kelasterapi();
    $('#search').keyup(function() {
        var value = $(this).val();
        load_data_kelasterapi('',value,'');
    });
});
function form_add() {
var str = '<div id=form_add>'+
            '<form action="" method=post id="save_barang">'+
            '<?= form_hidden('id_kelasterapi', NULL, 'id=id_kelasterapi') ?>'+
            '<table width=100% class=data-input>'+
                '<tr><td>Farmakoterapi:</td><td><select name=farmakoterapi id=farmakoterapi><option value="">Pilih ...</option><?php foreach ($farmakoterapi as $data) { echo '<option value="'.$data->id.'">'.$data->nama.'</option>'; } ?></select></td></tr>'+
                '<tr><td width=30%>Nama:</td><td><?= form_input('nama', NULL, 'id=nama size=50') ?></td></tr>'+
            '</table>'+
            '</form>'+
            '</div>';
    $('body').append(str);
    $('#form_add').dialog({
        title: 'Tambah kelasterapi',
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
    var lebar = $('#kelasterapi').width();
    $('#kelasterapi').dblclick(function() {
        $('<div title="Data kelasterapi" id="kelasterapi-data"></div>').dialog({
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
        var cek_id = $('#id_kelasterapi').val();
        $.ajax({
            url: 'models/update-masterdata.php?method=save_kelasterapi',
            type: 'POST',
            dataType: 'json',
            data: $(this).serialize(),
            cache: false,
            success: function(data) {
                if (data.status === true) {
                    if (cek_id === '') {
                        alert_tambah();
                        $('input').val('');
                        load_data_kelasterapi('1','',data.id_kelasterapi);
                    } else {
                        alert_edit();
                        $('#form_add').dialog().remove();
                        load_data_kelasterapi('1','',data.id_kelasterapi);
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
    load_data_kelasterapi();
});
$('#button').click(function() {
    form_add();
});
$.plugin($afterSubPageShow,{ // <-- event is here
    showAlert:function(){ // <-- random function name is here (choose whatever you want)
    /* The code that will be executed */
    }
});
function load_data_kelasterapi(page, search, id) {
    pg = page; src = search; id_barg = id;
    if (page === undefined) { var pg = ''; }
    if (search === undefined) { var src = ''; }
    if (id === undefined) { var id_barg = ''; }
    $.ajax({
        url: 'pages/kelasterapi-list.php',
        cache: false,
        data: 'page='+pg+'&search='+src+'&id_kelasterapi='+id_barg,
        success: function(data) {
            $('#result-kelasterapi').html(data);
        }
    });
}

function paging(page, tab, search) {
    load_data_kelasterapi(page, search);
}

function edit_kelasterapi(str) {
    var arr = str.split('#');
    form_add();
    $('#form_add').dialog({ title: 'Edit kelasterapi' });
    $('#id_kelasterapi').val(arr[0]);
    $('#nama').val(arr[2]);
    $('#farmakoterapi').val(arr[1]);
}

function delete_kelasterapi(id, page) {
    $('<div id=alert>Anda yakin akan menghapus data ini?</div>').dialog({
        title: 'Konfirmasi Penghapusan',
        autoOpen: true,
        modal: true,
        buttons: {
            "OK": function() {
                
                $.ajax({
                    url: 'models/update-masterdata.php?method=delete_kelasterapi&id='+id,
                    cache: false,
                    success: function() {
                        load_data_kelasterapi(page);
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
<h1 class="margin-t-0">Data Kelas Terapi</h1>
<hr>
<button id="button">Tambah Data</button>
<button id="reset">Reset</button>
<?= form_input('search', NULL, 'id=search placeholder="Search ..." class=search') ?>
<div id="result-kelasterapi">
    
</div>