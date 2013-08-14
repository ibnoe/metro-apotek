<?php
include_once '../models/masterdata.php';
include_once '../inc/functions.php';
?>
<table cellspacing="0" width="60%" class="list-data">
<thead>
<tr class="italic">
    <th width="5%">No.</th>
    <th width="20%">Nama</th>
    <th width="10%">Hari</th>
    <th width="10%">Jam</th>
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
        'id' => $_GET['id_jadwal_praktek'],
        'limit' => $limit,
        'start' => $offset,
        'search' => $_GET['search']
    );
    $list_data = load_data_jadwal_praktek($param);
    $master_jadwal_praktek = $list_data['data'];
    $total_data = $list_data['total'];
    foreach ($master_jadwal_praktek as $key => $data) { 
        $str = $data->id.'#'.$data->nama.'#'.$data->id_dokter.'#'.$data->hari.'#'.substr($data->jam, 0, 5);
        ?>
    <tr class="<?= ($key%2==0)?'even':'odd' ?>">
        <td align="center"><?= (++$key+$offset) ?></td>
        <td><?= $data->nama ?></td>
        <td><?= $data->hari ?></td>
        <td align="center"><?= substr($data->jam, 0, 5) ?></td>
        <td class='aksi' align='center'>
            <a class='edition' onclick="edit_jadwal_praktek('<?= $str ?>');" title="Klik untuk edit jadwal_praktek">&nbsp;</a>
            <a class='deletion' onclick="delete_jadwal_praktek('<?= $data->id ?>', '<?= $page ?>');" title="Klik untuk hapus jadwal_praktek">&nbsp;</a>
        </td>
    </tr>
    <?php } ?>
</tbody>
</table>
<?= paging_ajax($total_data, $limit, $page, '1', $_GET['search']) ?>