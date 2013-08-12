<?php
include_once '../models/masterdata.php';
include_once '../inc/functions.php';

$barang_packing = kemasan_load_data($_GET['id']);
$kemasan  = satuan_load_data('0');

foreach ($barang_packing as $key => $rows) {

    ?>
    <tr class="mother" id="mother<?= $key ?>"><td width=15%>Barcode:</td><td width=70%><?= form_hidden('id_kemasan'.$key, $rows->id, 'id=id_kemasan'.$key) ?><?= form_input('barcode'.$key, $rows->barcode, 'id=barcode'.$key.' class=barcode size=10') ?> 
    Kemasan: <select name=kemasan<?= $key ?> onchange="isi_satuan_terkecil(<?= $key ?>);" id="kemasan<?= $key ?>" style="min-width: 100px;"><option value="">Pilih ...</option><?php foreach ($kemasan as $data) { echo '<option value="'.$data->id.'" '.(($data->id === $rows->id_kemasan)?"selected":NULL).'>'.$data->nama.'</option>'; } ?></select> 
    isi: <?= form_input('isi'.$key, $rows->isi, 'id=isi'.$key.' size=5 onblur="isi_satuan_terkecil('.$key.');"') ?> 
    Satuan: <select name=satuan<?= $key ?> id="satuan<?= $key ?>" onChange="config_auto_suggest(<?= $key ?>);" style="min-width: 100px;"><option value="">Pilih ...</option><?php foreach ($kemasan as $data) { echo '<option value="'.$data->id.'" '.(($data->id === $rows->id_satuan)?"selected":NULL).'>'.$data->nama.'</option>'; } ?></select>&nbsp;
    <input type=checkbox name=is_bertingkat<?= $key ?> value="1" id="checkbox<?= $key ?>" title="" <?= ($rows->is_harga_bertingkat !== '0')?'checked':NULL ?> /><input type=hidden name=isi_kecil<?= $key ?> id=isi_kecil<?= $key ?> value="<?= $rows->isi_satuan ?>" size=5 />
    <img onclick="add_setting_harga(<?= $key ?>);" title="Klik untuk setting harga" src="img/icons/add.png" class=add_kemasan align=right />
    <img onclick="delete_setting_harga(<?= $key ?>);" title="Klik untuk delete" src="img/icons/delete.png" class=delete_kemasan align=right style="margin: 0 5px;" />
        <?= form_hidden('jumlah', $key) ?>
        </td></tr>
    <script type='text/javascript'>
        $('#checkbox<?= $key ?>').mouseover(function() {
            if ($(this).is(':checked') === false) {
                $('#checkbox<?= $key ?>').attr('title', 'Check, jika menggunakan harga bertingkat');
            } else {
                $('#checkbox<?= $key ?>').attr('title', 'Uncheck jika TIDAK menggunakan harga bertingkat');
            }
        });
    </script>
<?php 
$array_dinamic = dinamic_load_data($rows->id);
foreach ($array_dinamic as $no => $data) { ?>
    <tr class="child<?= $key ?>" id="child<?= $key ?><?= $no ?>"><td></td><td>
        <table width=100% style="border-bottom: 1px dotted #ccc; margin-bottom: 5px; padding-bottom: 3px;">
            <tr><td colspan=2>&nbsp;</td></tr>
            <tr><td>Range Jual:</td><td><input type=text name=awal<?= $key ?>[] value="<?= $data->jual_min ?>" id=awal<?= $key ?><?= $no ?> size=5 /> <div class="space"> s.d </div> <input type=text name=akhir<?= $key ?>[] value="<?= $data->jual_max ?>" id=akhir<?= $key ?><?= $no ?> size=5 /></td><td>Diskon:</td><td><input type=text name=d_persen<?= $key ?>[] id=d_persen<?= $key ?><?= $no ?> value="<?= $data->diskon_persen ?>" size=5 /> <div class="space"> (%) </div> <input type=text name=d_rupiah<?= $key ?>[] value="<?= rupiah($data->diskon_rupiah) ?>" id=d_rupiah<?= $key ?><?= $no ?> onblur="FormNum(this);" onfocus="javascript:this.value=currencyToNumber(this.value);" size=5 /></td></tr>
            <tr><td>Margin Non Resep:</td><td><input type=text name=margin_nr<?= $key ?>[] value="<?= $data->margin_non_resep ?>" id=margin_nr<?= $key ?><?= $no ?> size=5 /> <div class="space"> (%) </div><input style="background: #f4f4f4; border: none;" type=text id=margin_nr_rp<?= $key ?><?= $no ?> size=5 disabled /></td><td>Harga Jual Non Resep (Rp.):</td><td><span id="hj_nonresep<?= $key ?><?= $no ?>"><?= rupiah($data->hj_non_resep) ?></span><input type=hidden name="hj_nonresep<?= $key ?>[]" value="<?= $data->hj_non_resep ?>" id="hj_nonresep_f<?= $key ?><?= $no ?>" /></td></tr>
            <tr><td>Margin Resep:</td><td><input type=text name=margin_r<?= $key ?>[] value="<?= $data->margin_resep ?>" id=margin_r<?= $key ?><?= $no ?> size=5 /> <div class="space"> (%) </div><input style="background: #f4f4f4; border: none;" type=text id=margin_r_rp<?= $key ?><?= $no ?> size=5 disabled /></td><td>Harga Jual Resep (Rp.):</td><td><span id="hj_resep<?= $key ?><?= $no ?>"><?= rupiah($data->hj_resep) ?></span><input type=hidden name="hj_resep<?= $key ?>[]" value="<?= $data->hj_resep ?>" id="hj_resep_f<?= $key ?><?= $no ?>" /><img src="img/icons/delete.png" onclick="removeMe(this)" align=right /></td></tr>
        </table>
    </td></tr>
    <script type="text/javascript">
    detail_hitung_dinamic(<?= $key ?>, <?= $no ?>, 'edit');
    </script>
<?php }
} ?>
