<?php
set_include_path("../");
include_once("inc/essentials.php");
include_once("inc/functions.php");
include_once("models/transaksi.php");
include_once("models/masterdata.php");
include_once("pages/message.php");

?>
<script type="text/javascript">
load_data_penerimaan();

function load_list_data(id_barang, nama_barang, id_satuan_beli, jumlah) {
    var no   = $('.tr_rows').length+1;
    var list = '<tr class=tr_rows>'+
                    '<td align=center>'+no+'</td>'+
                    '<td><input type=text name=barang value="'+nama_barang+'" id=barang'+no+' size=50 /> <input type=hidden name=id_barang[] id=id_barang'+no+' value="'+id_barang+'" /></td>'+
                    '<td><select name=satuan[] id=satuan'+no+'></select></td>'+
                    '<td><input type=text name=jumlah[] id=jumlah'+no+' value="'+jumlah+'" size=10 /></td>'+
                    '<td><input type=text name=nobatch[] id=nobatch'+no+' size=10 /></td>'+
                    '<td><input type=text name=ed[] id=ed'+no+' size=10 /></td>'+
                    '<td><input type=text name=harga[] id=harga'+no+' onblur=FormNum(this); onfocus=javascript:this.value=currencyToNumber(this.value); size=10 /></td>'+
                    '<td><input type=text name=diskon_pr[] id=diskon_pr'+no+' value="0" onblur="hitung_sub_total('+no+');" size=10 maxlength=5 /></td>'+
                    '<td><input type=text name=diskon_rp[] id=diskon_rp'+no+' value="0" onblur=FormNum(this); size=10 onfocus=javascript:this.value=currencyToNumber(this.value); /></td>'+
                    '<td><input type=text name=subtotal[] id=subtotal'+no+' size=10 /></td>'+
                    '<td align=center class=aksi><img src="img/icons/delete.png" align=left title="Klik untuk hapus" onclick="removeMe(this);" /></td>'+
               '</tr>';
    $('#penerimaan-list tbody').append(list);
    $('#ed'+no).datepicker({
        changeMonth: true,
        changeYear: true,
        minDate: 0
    });
    $('#harga'+no+', #diskon_rp'+no+', #subtotal'+no+', #diskon_pr'+no+', #jumlah'+no+', #disc_pr, #disc_rp, #materai').keyup(function() {
        hitung_sub_total(no);
    });
    $('#harga'+no+', #diskon_rp'+no+', #subtotal'+no).css('text-align','right');
    $('#diskon_pr'+no+', #jumlah'+no).css('text-align','center');
    $('#diskon_pr'+no).keyup(function() {
        var jumlah  = $('#jumlah'+no).val();
        var harga   = parseInt(currencyToNumber($('#harga'+no).val()));
        var subtotal= jumlah*harga;
        var disc_pr = ($('#diskon_pr'+no).val()/100);
        $('#diskon_rp'+no).val(numberToCurrency(parseInt(subtotal*disc_pr)));
    });
    $.getJSON('models/autocomplete.php?method=get_data_kemasan&id='+id_barang, function(data){
        $.each(data, function (index, value) {
            if (value.kemasan !== value.satuan_kecil) {
                label = value.kemasan+' isi: '+value.isi+' '+value.satuan_kecil;
            } else {
                label = value.kemasan;
            }
            $('#satuan'+no).append('<option value="'+value.id+'">'+label+'</option>');
        });
        $('#satuan'+no).val(id_satuan_beli);
    });
}

function hitung_sub_total(i) {
    var jumlah      = $('#jumlah'+i).val();
    var harga       = parseInt(currencyToNumber($('#harga'+i).val()));
    var diskon      = parseInt(currencyToNumber($('#diskon_rp'+i).val())); // diskon rupiah yg diambil
    var subtotal    = (harga*jumlah) - diskon;
    $('#subtotal'+i).val(numberToCurrency(subtotal));
    var jml_baris   = $('.tr_rows').length;
    var total       = 0;
    for (j = 1; j <= jml_baris; j++) {
        total = total + subtotal;
    }
    
    var ppn         = $('#ppn').val()/100;
    var materai     = parseInt(currencyToNumber($('#materai').val()));
    
    var ppn_total   = total+(total*ppn); // total PPN faktur setelah ditambah dengan total barang
    var disc_percent= $('#disc_pr').val()/100; // persentase diskon per faktur
    var dp_total    = ppn_total*disc_percent;
                      $('#disc_rp').val(numberToCurrency(parseInt(Math.ceil(dp_total))));
    var diskon_ttl  = parseInt(currencyToNumber($('#disc_rp').val()));
    var disc_ppn_ttl= ppn_total-diskon_ttl;
    var general_ttl = disc_ppn_ttl+materai;
    
    $('#total').val(numberToCurrency(parseInt(general_ttl)));
}

function form_add() {
    var str = '<div id="penerimaan"><form id="save_penerimaan">'+
                '<input type=hidden name=id_penerimaan id=id_penerimaan />'+
                '<table width=100% class=data-input><tr valign=top><td width=50%>'+
                    '<table width=100%>'+
                        '<tr><td>No. SP:</td><td><input type=text name=no_sp id=no_sp size=10 /></td></tr>'+
                        '<tr><td>Faktur:</td><td><input type=text name=faktur id=faktur size=10 readonly /></td></tr>'+
                        '<tr><td>Tanggal:</td><td><input type=text value="<?= date("d/m/Y") ?>" name=tanggal id=tanggal size=10 /></td></tr>'+
                        '<tr><td>Supplier:</td><td><input type=text name=supplier id=supplier size=40 /><input type=hidden name=id_supplier id=id_supplier /></td></tr>'+
                        '<tr><td>Jatuh Tempo:</td><td><input type=text name=tempo id=tempo size=10 /></td></tr>'+
                    '</table>'+
                    '</td><td width=50%>'+
                    '<table width=100%>'+
                        '<tr><td>PPN:</td><td><input type=text name=ppn id=ppn size=10 /> %</td></tr>'+
                        '<tr><td>Diskon:</td><td><input type=text name=disc_pr id=disc_pr size=10 /> %, Rp. <input type=text name=disc_rp id=disc_rp size=10 /></td></tr>'+
                        '<tr><td>Materai (Rp.):</td><td><input type=text name=materai onblur=FormNum(this); id=materai size=10 /></td></tr>'+
                        '<tr><td>Total (Rp.):</td><td><input type=text name=total id=total size=10 /></td></tr>'+
                    '</table>'+
                '</td></tr></table>'+
                '<table width=100% cellspacing="0" class="list-data-input" id="penerimaan-list"><thead>'+
                    '<tr>'+
                        '<th width=5%>No.</th>'+
                        '<th width=25%>Nama Barang</th>'+
                        '<th width=10%>Kemasan</th>'+
                        '<th width=5%>Jumlah</th>'+
                        '<th width=10%>No. Batch</th>'+
                        '<th width=10%>ED</th>'+
                        '<th width=10%>Harga @</th>'+
                        '<th width=5%>Diskon (%)</th>'+
                        '<th width=10%>Diskon Rp.</th>'+
                        '<th width=10%>SubTotal Rp.</th>'+
                        '<th width=10%>#&nbsp;#</th>'+
                    '</tr></thead>'+
                    '<tbody></tbody>'+
                '</table>'+
              '</form></div>';
    $('body').append(str);
    var wWidth = $(window).width();
    var dWidth = wWidth * 0.95;
    
    var wHeight= $(window).height();
    var dHeight= wHeight * 1;
    $('#penerimaan').dialog({
        title: 'Penerimaan Barang',
        autoOpen: true,
        modal: true,
        width: dWidth,
        height: dHeight,
        hide: 'clip',
        show: 'blind',
        buttons: {
            "Simpan": function() {
                $('#save_penerimaan').submit();
            }, 
            "Cancel": function() {    
                $(this).dialog().remove();
            }
        }, close: function() {
            $(this).dialog().remove();
        }, open: function() {
            $('#no_sp').focus();
        }
    });
    var lebar = $('#supplier').width();
    $('#no_sp').autocomplete("models/autocomplete.php?method=get_nomor_sp",
    {
        parse: function(data){
            var parsed = [];
            for (var i=0; i < data.length; i++) {
                parsed[i] = {
                    data: data[i],
                    value: data[i].id // nama field yang dicari
                };
            }
            return parsed;
        },
        formatItem: function(data,i,max){
            var str = '<div class=result>'+data.id+'<br/> '+data.supplier+'</div>';
            return str;
        },
        width: lebar, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
        dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
    }).result(
    function(event,data,formated){
        $(this).val(data.id);
        $('#supplier').val(data.supplier);
        $('#id_supplier').val(data.id_supplier);
        $('#penerimaan-list tbody').html('');
        $.ajax({
            url: 'models/autocomplete.php?method=get_attr_penerimaan',
            cache: false,
            dataType: 'json',
            success: function(msg) {
                $('#faktur').val(msg.faktur);
                $('#tempo').val(msg.tempo);
                $('#ppn,#materai,#disc_rp, #disc_pr').val('0');
            }
        });
        $.getJSON('models/autocomplete.php?method=get_data_pemesanan_penerimaan&id='+data.id, function(data){
            $.each(data, function (index, value) {
                // function here
                load_list_data(value.id_barang, value.nama+' '+value.kekuatan+' '+value.satuan_kekuatan, value.id_kemasan, value.jumlah);
            });
        });
    });
    $('#supplier').autocomplete("models/autocomplete.php?method=supplier",
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
            var str = '<div class=result>'+data.nama+'<br/> '+data.alamat+'</div>';
            return str;
        },
        width: lebar, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
        dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
    }).result(
    function(event,data,formated){
        $(this).val(data.nama);
        $('#id_supplier').val(data.id);
    });
    $('#save_penerimaan').submit(function() {
        var jml_baris = $('.tr_rows').length;
        for (i = 1; i <= jml_baris; i++) {
            if ($('#satuan'+i).val() === '') {
                alert_empty('Kemasan','#satuan'+i);
                return false;
            }
            if ($('#jumlah'+i).val() === '') {
                alert_empty('Jumlah', '#jumlah'+i);
                return false;
            }
            if ($('#ed'+i).val() === '') {
                alert_empty('Expired date','#ed'+i);
                return false;
            }
            if ($('#harga'+i).val() === '') {
                alert_empty('Harga','#harga'+i);
                return false;
            }
        }
        
        $.ajax({
            url: 'models/update-transaksi.php?method=save_penerimaan',
            type: 'POST',
            dataType: 'json',
            data: $('#save_penerimaan').serialize(),
            cache: false,
            success: function(data) {
                if (data.status === true) {
                    if (data.action === 'add') {
                        alert_tambah();
                        $('#penerimaan').dialog().remove();
                        load_data_penerimaan();
                    } else {
                        alert_edit();
                        load_data_penerimaan();
                    }
                }
            }
        });
        return false;
    });
}
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
    load_data_penerimaan();
});
function load_data_penerimaan(page, search, id) {
    pg = page; src = search; id_barg = id;
    if (page === undefined) { var pg = ''; }
    if (search === undefined) { var src = ''; }
    if (id === undefined) { var id_barg = ''; }
    $.ajax({
        url: 'pages/penerimaan-list.php',
        cache: false,
        data: 'page='+pg+'&search='+src+'&id_penerimaan='+id_barg,
        success: function(data) {
            $('#result-penerimaan').html(data);
        }
    });
}

function paging(page, tab, search) {
    load_data_penerimaan(page, search);
}
function delete_penerimaan(id, page) {
    $('<div id=alert>Anda yakin akan menghapus data ini?</div>').dialog({
        title: 'Konfirmasi Penghapusan',
        autoOpen: true,
        modal: true,
        buttons: {
            "OK": function() {
                
                $.ajax({
                    url: 'models/update-transaksi.php?method=delete_penerimaan&id='+id,
                    cache: false,
                    success: function() {
                        load_data_penerimaan(page);
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
<h1 class="margin-t-0">Penerimaan Barang</h1>
<hr>
<button id="button">Tambah Penerimaan</button>
<button id="reset">Reset</button>
<div id="result-penerimaan">
    
</div>