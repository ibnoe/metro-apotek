<?php
$subNav = array(
	"Utama ; pelanggan.php ; #509601;"
);

set_include_path("../");
include_once("inc/essentials.php");
include_once("inc/functions.php");
include_once("models/masterdata.php");
include_once("pages/message.php");
$asuransi = load_data_asuransi();
?>

<script type="text/javascript">
$(function() {
    load_data_pelanggan();
    $('#search').keyup(function() {
        var value = $(this).val();
        load_data_pelanggan('',value,'');
    });
});

function form_add() {
var str = '<div id=form_add>'+
            '<form action="models/update-masterdata.php?method=save_pelanggan" enctype=multipart/form-data method=post id="save_barang">'+
            '<?= form_hidden('id_pelanggan', NULL, 'id=id_pelanggan enctype="multipart/form-data"') ?>'+
            '<table width=100% class=data-input>'+
                '<tr><td width=30%>Nama:</td><td width=70%><?= form_input('nama', NULL, 'id=nama size=40 onBlur="javascript:this.value=this.value.toUpperCase();"') ?></td></tr>'+
                '<tr><td>Jenis:</td><td><input type="radio" name=jenis value="Personal" checked id="p" /> <label for="p">Personal</label> <input type="radio" name=jenis value="Perusahaan" id="pr" /> <label for="pr">Perusahaan</label></td></tr>'+
                '<tr><td>Kelamin:</td><td><input type="radio" name=kelamin value="P" checked id="prm" /> <label for="prm">Perempuan</label> <input type="radio" name=kelamin value="L" id="l" /> <label for="l">Laki-laki</label></td></tr>'+
                '<tr><td>Tempat / Tgl Lahir:</td><td><input type=text name=tmp_lahir size=5 style="min-width: 200px;" id=tmp_lahir /> / <input type=text name=tgl_lahir style="min-width: 80px;" size=5 id="tanggal" /></td></tr>'+
                '<tr><td>Alamat:</td><td><?= form_input('alamat', NULL, 'id=alamat size=40 onBlur="javascript:this.value=this.value.toUpperCase();"') ?><input type=hidden name="id_pabrik" /></td></tr>'+
                '<tr><td>Telp:</td><td><?= form_input('telp', '', 'id=telp size=40') ?></td></tr>'+
                '<tr><td>Email:</td><td><?= form_input('email','', 'id=email size=40') ?></td></tr>'+
                '<tr><td>Diskon:</td><td><?= form_input('diskon', '', 'id=diskon size=40') ?></td></tr>'+
                '<tr><td>Catatan:</td><td><?= form_input('catatan', '', 'id=catatan size=40') ?></td></tr>'+
                '<tr><td>Asuransi:</td><td><select name="asuransi" id="asuransi"><option value="">Pilih asuransi ...</option><?php foreach ($asuransi as $data) { echo '<option value="'.$data->id.'">'.$data->nama.'</option>'; } ?></select></td></tr>'+
                '<tr><td>No. Polish:</td><td><?= form_input('nopolish', '', 'id=nopolish size=40') ?></td></tr>'+
                '<tr><td>Foto:</td><td><?= form_upload('mFile',null,'id=mFile') ?></td></tr>'+
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
        height: 390,
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
            alert('Nama pelanggan tidak boleh kosong !');
            $('#nama').focus(); return false;
        }
        var cek_id = $('#id_pelanggan').val();
        $(this).ajaxSubmit({
            target: '#output',
            dataType: 'json',
            success:  function(data) {
                if (data.status === true) {
                    if (cek_id === '') {
                        alert_tambah('#nama');
                        $('input[type=text]').val('');
                        load_data_pelanggan('1','',data.id_pelanggan);
                    } else {
                        alert_edit();
                        $('#form_add').dialog().remove();
                        load_data_pelanggan($('.noblock').html());
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
});
$('#reset').click(function() {
    load_data_pelanggan();
    $('#search').val('');
});
$.plugin($afterSubPageShow,{ // <-- event is here
    showAlert:function(){ // <-- random function name is here (choose whatever you want)
    
    /* The code that will be executed */
    
    
    }
});
function load_data_pelanggan(page, search, id) {
    pg = page; src = search; id_barg = id;
    if (page === undefined) { var pg = ''; }
    if (search === undefined) { var src = ''; }
    if (id === undefined) { var id_barg = ''; }
    $.ajax({
        url: 'pages/pelanggan-list.php',
        cache: false,
        data: 'page='+pg+'&search='+src+'&id_pelanggan='+id_barg,
        success: function(data) {
            $('#result-pelanggan').html(data);
        }
    });
}

function paging(page, tab, search) {
    load_data_pelanggan(page, search);
}

function edit_pelanggan(str) {
    
    var arr = str.split('#');
    form_add();
    $('#form_add').dialog({ title: 'Edit pelanggan' });
    $('#id_pelanggan').val(arr[0]);
    $('#nama').val(arr[1]);
    if (arr[2] === 'Personal') { $('#p').attr('checked','checked'); }
    if (arr[2] === 'Perusahaan') { $('#pr').attr('checked','checked'); }
    if (arr[3] === 'P') { $('#prm').attr('checked','checked'); }
    if (arr[3] === 'L') { $('#l').attr('checked','checked'); }
    $('#tmp_lahir').val(arr[4]);
    $('#tanggal').val(arr[5]);
    $('#alamat').val(arr[6]);
    $('#telp').val(arr[7]);
    $('#email').val(arr[8]);
    $('#diskon').val(arr[9]);
    $('#catatan').val(arr[10]);
    $('#asuransi').val(arr[11]);
    $('#nopolish').val(arr[12]);
    
}

function delete_pelanggan(id, page) {
    $('<div id=alert>Anda yakin akan menghapus data ini?</div>').dialog({
        title: 'Konfirmasi Penghapusan',
        autoOpen: true,
        modal: true,
        buttons: {
            "OK": function() {
                
                $.ajax({
                    url: 'models/update-masterdata.php?method=delete_pelanggan&id='+id,
                    cache: false,
                    success: function() {
                        load_data_pelanggan(page);
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
<h1 class="margin-t-0">Data Customer</h1>
<hr>
<button id="button">Tambah Data</button>
<button id="reset">Reset</button>
<?= form_input('search', NULL, 'id=search placeholder="Search ..." class=search') ?>
<div id="result-pelanggan">
    
</div>