<?php
include_once '../models/masterdata.php';
include_once '../inc/functions.php';
?>
<table cellspacing="0" width="60%" class="list-data">
<thead>
<tr class="italic">
    <th width="5%">No.</th>
    <th width="40%">Nama</th>
    <th width="10%">Hari</th>
    <th width="10%">Mulai</th>
    <th width="10%">Selesai</th>
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
    $nama = "";
    $no = 1;
    foreach ($master_jadwal_praktek as $key => $data) { 
        $str = $data->id.'#'.$data->nama.'#'.$data->id_dokter.'#'.$data->hari.'#'.substr($data->jam, 0, 5).'#'.substr($data->akhir, 0, 5);
        ?>
    <tr class="<?= ($data->nama !== $nama)?'odd':'even' ?>">
        <td align="center"><?= ($data->nama !== $nama)?($no+$offset):NULL ?></td>
        <td><?= ($data->nama !== $nama)?$data->nama:NULL ?></td>
        <td><?= $data->hari ?></td>
        <td align="center"><?= substr($data->jam, 0, 5) ?></td>
        <td align="center"><?= substr($data->akhir, 0, 5) ?></td>
        <td class='aksi' align='center'>
            <a class='edition' onclick="edit_jadwal_praktek('<?= $str ?>');" title="Klik untuk edit jadwal_praktek">&nbsp;</a>
            <a class='deletion' onclick="delete_jadwal_praktek('<?= $data->id ?>', '<?= $page ?>');" title="Klik untuk hapus jadwal_praktek">&nbsp;</a>
        </td>
    </tr>
    <?php 
    if ($data->nama !== $nama) {
        $no++;
    }
    $nama = $data->nama;
    } ?>
</tbody>
</table>
<?= paging_ajax($total_data, $limit, $page, '1', $_GET['search']) ?>