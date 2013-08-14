<?php
include_once '../models/masterdata.php';
include_once '../inc/functions.php';
?>
<table cellspacing="0" width="100%" class="list-data">
<thead>
<tr class="italic">
    <th width="5%">No.</th>
    <th width="20%">Nama</th>
    <th width="5%">Kelamin</th>
    <th width="25%">Alamat</th>
    <th width="10%">Telp</th>
    <th width="10%">Email</th>
    <th width="10%">No. STR</th>
    <th width="5%">Spesialis</th>
    <th width="5%">Fee %</th>
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
        'id' => $_GET['id_dokter'],
        'limit' => $limit,
        'start' => $offset,
        'search' => $_GET['search']
    );
    $list_data = load_data_dokter($param);
    $master_dokter = $list_data['data'];
    $total_data = $list_data['total'];
    foreach ($master_dokter as $key => $data) { 
        $str = $data->id.'#'.$data->nama.'#'.$data->kelamin.'#'.$data->alamat.'#'.
                $data->telp.'#'.$data->email.'#'.$data->no_str.'#'.$data->spesialis.'#'.datefmysql($data->tgl_mulai_praktek).'#'.$data->fee;
        ?>
    <tr class="<?= ($key%2==0)?'even':'odd' ?>">
        <td align="center"><?= (++$key+$offset) ?></td>
        <td><?= $data->nama ?></td>
        <td align="center"><?= $data->kelamin ?></td>
        <td><?= $data->alamat ?></td>
        <td><?= $data->telp ?></td>
        <td><?= $data->email ?></td>
        <td><?= $data->no_str ?></td>
        <td><?= $data->spesialis ?></td>
        <td align="center"><?= rupiah($data->fee) ?></td>
        <td class='aksi' align='center'>
            <a class='edition' onclick="edit_dokter('<?= $str ?>');" title="Klik untuk edit dokter">&nbsp;</a>
            <a class='deletion' onclick="delete_dokter('<?= $data->id ?>', '<?= $page ?>');" title="Klik untuk hapus dokter">&nbsp;</a>
        </td>
    </tr>
    <?php } ?>
</tbody>
</table>
<?= paging_ajax($total_data, $limit, $page, '1', $_GET['search']) ?>