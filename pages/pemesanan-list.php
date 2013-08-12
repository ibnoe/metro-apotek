<?php
include_once '../models/transaksi.php';
include_once '../inc/functions.php';
?>
<script type="text/javascript">
$(function() {
    $( document ).tooltip();
});
</script>
<table cellspacing="0" width="100%" class="list-data">
<thead>
    <tr class="italic">
        <th width="5%">No.</th>
        <th width="10%">No. SP</th>
        <th width="10%">Tanggal</th>
        <th width="20%">Nama Supplier</th>
        <th width="15%">Karyawan</th>
        <th width="10%">Perkiraan <br/>Harga</th>
        <th width="5%">#</th>
    </tr>
</thead>
<tbody>
    <?php
    $limit = 10;
    $page  = $_GET['page'];
    if ($_GET['page'] === '') {
        $page = 1;
        $offset = 0;
    } else {
        $offset = ($page-1)*$limit;
    }
    
    $param = array(
        'id' => $_GET['id_pemesanan'],
        'limit' => $limit,
        'start' => $offset,
        'search' => $_GET['search']
    );
    $pemesanan = pemesanan_load_data($param);
    $list_data = $pemesanan['data'];
    $total_data= $pemesanan['total'];
    foreach ($list_data as $key => $data) { ?>
        <tr class="<?= ($key%2==0)?'even':'odd' ?>">
            <td align="center"><?= (++$key+$offset) ?></td>
            <td><?= $data->id ?></td>
            <td><?= datefmysql($data->tanggal) ?></td>
            <td><?= ($data->supplier !== NULL)?$data->supplier:'-' ?></td>
            <td><?= ($data->karyawan !== NULL)?$data->karyawan:'-' ?></td>
            <td></td>
            <td class='aksi' align='center'>
                <a class='edition' onclick="edit_pemesanan('<?= $str ?>');" title="Klik untuk edit pemesanan">&nbsp;</a>
                <a class='deletion' onclick="delete_pemesanan('<?= $data->id ?>','<?= $page ?>');" title="Klik untuk hapus pemesanan">&nbsp;</a>
            </td>
        </tr>
    <?php }
    ?>
</tbody>
</table>