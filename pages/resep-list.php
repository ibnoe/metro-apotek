<?php
include_once '../models/transaksi.php';
include_once '../inc/functions.php';
?>
<table cellspacing="0" width="100%" class="list-data">
<thead>
<tr class="italic">
    <th width="5%">No.</th>
    <th width="5%">No. Resep</th>
    <th width="10%">Tanggal</th>
    <th width="5%">ID</th>
    <th width="15%">Pasien</th>
    <th width="15%">Dokter</th>
    <th width="5%">No.R /</th>
    <th width="15%">Apoteker</th>
    <th width="10%">Biaya <br/> Apoteker</th>
    <th width="10%">Nominal</th>
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
        'id' => $_GET['id_resep'],
        'limit' => $limit,
        'start' => $offset,
        'search' => $_GET['search']
    );
    $list_data = load_data_resep($param);
    $master_resep = $list_data['data'];
    $total_data = $list_data['total'];
    foreach ($master_resep as $key => $data) { 
        $str = "";
        ?>
    <tr class="<?= ($key%2==0)?'even':'odd' ?>">
        <td align="center"><?= (++$key+$offset) ?></td>
        <td align="center"><?= $data->id_resep ?></td>
        <td align="center"><?= datefmysql($data->tanggal) ?></td>
        <td align="center"><?= $data->id_pasien ?></td>
        <td><?= $data->pasien ?></td>
        <td><?= $data->dokter ?></td>
        <td><?= $data->r_no ?></td>
        <td><?= $data->apoteker ?></td>
        <td><?= $data->tarif ?></td>
        <td align="right"><?= rupiah($data->nominal) ?></td>
        <td class='aksi' align='center'>
            <a class='edition' onclick="edit_resep('<?= $str ?>');" title="Klik untuk edit resep">&nbsp;</a>
            <a class='deletion' onclick="delete_resep('<?= $data->id ?>', '<?= $page ?>');" title="Klik untuk hapus">&nbsp;</a>
        </td>
    </tr>
    <?php } ?>
</tbody>
</table>
<?= paging_ajax($total_data, $limit, $page, '1', $_GET['search']) ?>