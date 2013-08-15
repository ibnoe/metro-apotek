<?php
include_once '../models/masterdata.php';
include_once '../inc/functions.php';
?>
<table cellspacing="0" width="50%" class="list-data">
<thead>
<tr class="italic">
    <th width="5%">No.</th>
    <th width="60%">Nama asuransi</th>
    <th width="10%">Diskon (%)</th>
    <th width="4%">#</th>
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
        'id' => $_GET['id_asuransi'],
        'limit' => $limit,
        'start' => $offset,
        'search' => $_GET['search']
    );
    $list_data = load_data_asuransi_list($param);
    $master_barang = $list_data['data'];
    $total_data = $list_data['total'];
    foreach ($master_barang as $key => $data) { 
        $str = $data->id.'#'.$data->nama.'#'.$data->diskon;
        ?>
    <tr class="<?= ($key%2==0)?'even':'odd' ?>">
        <td align="center"><?= (++$key+$offset) ?></td>
        <td><?= $data->nama ?></td>
        <td align="center"><?= $data->diskon ?></td>
        <td class='aksi' align='center'>
            <a class='edition' onclick="edit_asuransi('<?= $str ?>');" title="Klik untuk edit asuransi">&nbsp;</a>
            <a class='deletion' onclick="delete_asuransi('<?= $data->id ?>', '<?= $page ?>');" title="Klik untuk hapus asuransi">&nbsp;</a>
        </td>
    </tr>
    <?php } ?>
</tbody>
</table>
<?= paging_ajax($total_data, $limit, $page, '1', $_GET['search']) ?>