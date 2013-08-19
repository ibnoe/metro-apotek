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
?>

<script type="text/javascript">
$(function() {
    load_data_farmakoterapi();
    $('#search').keyup(function() {
        var value = $(this).val();
        load_data_farmakoterapi('',value,'');
    });
});
function form_add() {
var str = '<div id=form_add>'+
            '<form action="" method=post id="save_barang">'+
            '<?= form_hidden('id_farmakoterapi', NULL, 'id=id_farmakoterapi') ?>'+
            '<table width=100% class=data-input>'+
                '<tr><td width=30%>Nama:</td><td><?= form_input('nama', NULL, 'id=nama size=50') ?></td></tr>'+
            '</table>'+
            '</form>'+
            '</div>';
    $('body').append(str);
    $('#form_add').dialog({
        title: 'Tambah farmakoterapi',
        autoOpen: true,
        width: 480,
        height: 160,
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
    var lebar = $('#farmakoterapi').width();
    $('#farmakoterapi').dblclick(function() {
        $('<div title="Data farmakoterapi" id="farmakoterapi-data"></div>').dialog({
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
        var cek_id = $('#id_farmakoterapi').val();
        $.ajax({
            url: 'models/update-masterdata.php?method=save_farmakoterapi',
            type: 'POST',
            dataType: 'json',
            data: $(this).serialize(),
            cache: false,
            success: function(data) {
                if (data.status === true) {
                    if (cek_id === '') {
                        alert_tambah();
                        $('input').val('');
                        load_data_farmakoterapi('1','',data.id_farmakoterapi);
                    } else {
                        alert_edit();
                        $('#form_add').dialog().remove();
                        load_data_farmakoterapi('1','',data.id_farmakoterapi);
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
    load_data_farmakoterapi();
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
function load_data_farmakoterapi(page, search, id) {
    pg = page; src = search; id_barg = id;
    if (page === undefined) { var pg = ''; }
    if (search === undefined) { var src = ''; }
    if (id === undefined) { var id_barg = ''; }
    $.ajax({
        url: 'pages/farmakoterapi-list.php',
        cache: false,
        data: 'page='+pg+'&search='+src+'&id_farmakoterapi='+id_barg,
        success: function(data) {
            $('#result-farmakoterapi').html(data);
        }
    });
}

function paging(page, tab, search) {
    load_data_farmakoterapi(page, search);
}

function edit_farmakoterapi(str) {
    var arr = str.split('#');
    form_add();
    $('#form_add').dialog({ title: 'Edit farmakoterapi' });
    $('#id_farmakoterapi').val(arr[0]);
    $('#nama').val(arr[1]);
}

function delete_farmakoterapi(id, page) {
    $('<div id=alert>Anda yakin akan menghapus data ini?</div>').dialog({
        title: 'Konfirmasi Penghapusan',
        autoOpen: true,
        modal: true,
        buttons: {
            "OK": function() {
                
                $.ajax({
                    url: 'models/update-masterdata.php?method=delete_farmakoterapi&id='+id,
                    cache: false,
                    success: function() {
                        load_data_farmakoterapi(page);
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
<h1 class="margin-t-0">Data farmakoterapi</h1>
<hr>
<button id="button">Tambah Data</button>
<button id="reset">Reset</button>
<?= form_input('search', NULL, 'id=search placeholder="Search ..." class=search') ?>
<div id="result-farmakoterapi">
    
</div>