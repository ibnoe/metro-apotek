<?php
include_once '../models/transaksi.php';
include_once '../inc/functions.php';
?>
<table cellspacing="0" width="100%" class="list-data">
<thead>
<tr class="italic">
    <th width="5%">No.</th>
    <th width="20%">Nama Barang</th>
    <th width="10%">No. Batch</th>
    <th width="10%">ED</th>
    <th width="10%">Masuk</th>
    <th width="10%">Keluar</th>
    <th width="10%">Sisa</th>
    <!--<th width="4%">#</th>-->
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
        'id' => $_GET['id_stokopname'],
        'limit' => $limit,
        'start' => $offset,
        'search' => $_GET['search']
    );
    $list_data = load_data_stok_opname($param);
    $master_stok_opname = $list_data['data'];
    $total_data = $list_data['total'];
    foreach ($master_stok_opname as $key => $data) { 
        $str = "";
        ?>
    <tr class="<?= ($key%2==0)?'even':'odd' ?>">
        <td align="center"><?= (++$key+$offset) ?></td>
        <td><?= $data->nama.' '.$data->kekuatan.' '.$data->satuan_kekuatan ?></td>
        <td align="center"><?= $data->nobatch ?></td>
        <td align="center"><?= datefmysql($data->ed) ?></td>
        <td align="center"><?= $data->masuk ?></td>
        <td align="center"><?= $data->keluar ?></td>
        <td align="center"><?= $data->sisa ?></td>
        <!--<td class='aksi' align='center'>
            <a class='edition' onclick="edit_stokopname('<?= $str ?>');" title="Klik untuk edit stok_opname">&nbsp;</a>
            <a class='deletion' onclick="delete_stokopname('<?= $data->id ?>', '<?= $page ?>');" title="Klik untuk hapus">&nbsp;</a>
        </td>-->
    </tr>
    <?php } ?>
</tbody>
</table>
<?= paging_ajax($total_data, $limit, $page, '1', $_GET['search']) ?>