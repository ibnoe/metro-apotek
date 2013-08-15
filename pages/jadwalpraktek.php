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
$hari = get_data_day();
?>

<script type="text/javascript">
load_data_jadwal_praktek();
function form_add() {
var str = '<div id=form_add>'+
            '<form action="" method=post id="save_jadwal_praktek">'+
            '<?= form_hidden('id_jadwal_praktek', NULL, 'id=id_jadwal_praktek') ?>'+
            '<table width=100% class=data-input>'+
                '<tr><td width=30%>Nama:</td><td width=70%><?= form_input('dokter', NULL, 'id=dokter size=40 onBlur="javascript:this.value=this.value.toUpperCase();"') ?> <?= form_hidden('id_dokter', NULL, 'id=id_dokter') ?></td></tr>'+
                '<tr><td>Hari:</td><td><select name=hari id=hari style="min-width: 152px;"><option value="">Pilih ...</option><?php foreach ($hari as $data) { echo '<option value="'.$data.'">'.$data.'</option>'; } ?></select></td></tr>'+
                '<tr><td>Jam:</td><td><?= form_input('jam', '', 'id=jam size=6 maxlength=5') ?> s . d <?= form_input('akhir', NULL, 'id=akhir size=6 maxlength=5') ?> Ex: 07:00, 18:30</td></tr>'+
            '</table>'+
            '</form>'+
            '</div>';
    $('body').append(str);
    $('input[type=text]').blur(function() {
        this.value=this.value.toUpperCase();
    });
    $('#form_add').dialog({
        title: 'Tambah Jadwal Praktek',
        autoOpen: true,
        width: 480,
        height: 350,
        modal: true,
        hide: 'clip',
        show: 'blind',
        buttons: {
            "Simpan": function() {
                $('#save_jadwal_praktek').submit();
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
    var lebar = $('#dokter').width();
    $('#dokter').autocomplete("models/autocomplete.php?method=dokter",
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
            var str = '<div class=result>'+data.nama+'<br/> '+data.no_str+'</div>';
            return str;
        },
        width: lebar, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
        dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
    }).result(
    function(event,data,formated){
        $(this).val(data.nama);
        $('#id_dokter').val(data.id);
    });
    $('#save_jadwal_praktek').submit(function() {
        if ($('#dokter').val() === '') {
            alert('Nama jadwal_praktek tidak boleh kosong !');
            $('#dokter').focus(); return false;
        }
        var cek_id = $('#id_jadwal_praktek').val();
        $.ajax({
            url: 'models/update-masterdata.php?method=save_jadwal_praktek',
            type: 'POST',
            dataType: 'json',
            data: $(this).serialize(),
            cache: false,
            success: function(data) {
                if (data.status === true) {
                    if (cek_id === '') {
                        alert_tambah('#nama');
                        $('input[type=text]').val('');
                        load_data_jadwal_praktek('1','',data.id_jadwal_praktek);
                    } else {
                        alert_edit();
                        $('#form_add').dialog().remove();
                        load_data_jadwal_praktek($('.noblock').html());
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
    load_data_jadwal_praktek();
});
$.plugin($afterSubPageShow,{ // <-- event is here
    showAlert:function(){ // <-- random function name is here (choose whatever you want)
    /* The code that will be executed */
    }
});
function load_data_jadwal_praktek(page, search, id) {
    pg = page; src = search; id_barg = id;
    if (page === undefined) { var pg = ''; }
    if (search === undefined) { var src = ''; }
    if (id === undefined) { var id_barg = ''; }
    $.ajax({
        url: 'pages/jadwalpraktek-list.php',
        cache: false,
        data: 'page='+pg+'&search='+src+'&id_jadwal_praktek='+id_barg,
        success: function(data) {
            $('#result-jadwal_praktek').html(data);
        }
    });
}

function paging(page, tab, search) {
    load_data_jadwal_praktek(page, search);
}

function edit_jadwal_praktek(str) {
    
    var arr = str.split('#');
    form_add();
    $('#form_add').dialog({ title: 'Edit jadwal_praktek' });
    $('#id_jadwal_praktek').val(arr[0]);
    $('#dokter').val(arr[1]);
    $('#id_dokter').val(arr[2]);
    $('#hari').val(arr[3]);
    $('#jam').val(arr[4]);
    $('#akhir').val(arr[5]);
}

function delete_jadwal_praktek(id, page) {
    $('<div id=alert>Anda yakin akan menghapus data ini?</div>').dialog({
        title: 'Konfirmasi Penghapusan',
        autoOpen: true,
        modal: true,
        buttons: {
            "OK": function() {
                $.ajax({
                    url: 'models/update-masterdata.php?method=delete_jadwal_praktek&id='+id,
                    cache: false,
                    success: function() {
                        load_data_jadwal_praktek(page);
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
<h1 class="margin-t-0">Jadwal Praktek</h1>
<hr>
<button id="button">Tambah Data</button>
<button id="reset">Reset</button>
<div id="result-jadwal_praktek">
    
</div>