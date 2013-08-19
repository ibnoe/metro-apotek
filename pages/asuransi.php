<?php
$subNav = array(
        "Pabrik ; pabrik.php ; #509601;",
	"Instansi ; instansi.php ; #509601;",
        "Supplier ; supplier.php ; #509601;",
        "Asuransi ; asuransi.php ; #509601;",
        "Bank ; bank.php ; #509601;",
);

set_include_path("../");
include_once("inc/essentials.php");
include_once("inc/functions.php");
include_once("models/masterdata.php");
include_once("pages/message.php");
?>

<script type="text/javascript">
$(function() {
    load_data_asuransi();
    $('#search').keyup(function() {
        var value = $(this).val();
        load_data_asuransi('',value,'');
    });
});
function form_add() {
var str = '<div id=form_add>'+
            '<form action="" method=post id="save_barang">'+
            '<?= form_hidden('id_asuransi', NULL, 'id=id_asuransi') ?>'+
            '<table width=100% class=data-input>'+
                '<tr><td width=40%>Nama asuransi:</td><td><?= form_input('nama', NULL, 'id=nama size=40 onBlur="javascript:this.value=this.value.toUpperCase();"') ?></td></tr>'+
                '<tr><td>Diskon (%):</td><td><?= form_input('diskon', NULL, 'id=diskon size=40') ?></td></tr>'+
            '</table>'+
            '</form>'+
            '</div>';
    $('body').append(str);
    $('#form_add').dialog({
        title: 'Tambah asuransi',
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
            alert('Nama asuransi tidak boleh kosong !');
            $('#nama').focus(); return false;
        }
        if ($('#diskon').val() === '') {
            alert('Diskon tidak boleh kosong !');
            $('#diskon').focus(); return false;
        }
        var cek_id = $('#id_asuransi').val();
        $.ajax({
            url: 'models/update-masterdata.php?method=save_asuransi',
            type: 'POST',
            dataType: 'json',
            data: $(this).serialize(),
            cache: false,
            success: function(data) {
                if (data.status === true) {
                    if (cek_id === '') {
                        alert_tambah();
                        $('input').val('');
                        load_data_asuransi('1','',data.id_asuransi);
                    } else {
                        alert_edit();
                        $('#form_add').dialog().remove();
                        load_data_asuransi('1','',data.id_asuransi);
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
$('#button').click(function() {
    form_add();
});
$('#reset').button({
    icons: {
        primary: 'ui-icon-refresh'
    }
}).click(function() {
    load_data_asuransi();
    $('#search').val('');
});
$.plugin($afterSubPageShow,{ // <-- event is here
    showAlert:function(){ // <-- random function name is here (choose whatever you want)
    
    /* The code that will be executed */
    
    
    }
});
function load_data_asuransi(page, search, id) {
    pg = page; src = search; id_barg = id;
    if (page === undefined) { var pg = ''; }
    if (search === undefined) { var src = ''; }
    if (id === undefined) { var id_barg = ''; }
    $.ajax({
        url: 'pages/asuransi-list.php',
        cache: false,
        data: 'page='+pg+'&search='+src+'&id_asuransi='+id_barg,
        success: function(data) {
            $('#result-asuransi').html(data);
        }
    });
}

function paging(page, tab, search) {
    load_data_asuransi(page, search);
}

function edit_asuransi(str) {
    var arr = str.split('#');
    form_add();
    $('#form_add').dialog({ title: 'Edit asuransi' });
    $('#id_asuransi').val(arr[0]);
    $('#nama').val(arr[1]);
    $('#diskon').val(arr[2]);
}
function delete_asuransi(id, page) {
    $('<div id=alert>Anda yakin akan menghapus data ini?</div>').dialog({
        title: 'Konfirmasi Penghapusan',
        autoOpen: true,
        modal: true,
        buttons: {
            "OK": function() {
                
                $.ajax({
                    url: 'models/update-masterdata.php?method=delete_asuransi&id='+id,
                    cache: false,
                    success: function() {
                        load_data_asuransi(page);
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
<h1 class="margin-t-0">Data asuransi</h1>
<hr>
<button id="button">Tambah Data</button>
<button id="reset">Reset</button>
<?= form_input('search', NULL, 'id=search placeholder="Search ..." class=search') ?>
<div id="result-asuransi">
    
</div>