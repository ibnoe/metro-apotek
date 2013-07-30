<?php
include_once '../models/masterdata.php';
include_once '../inc/functions.php';
?>
<table cellspacing="0" width="100%" class="list-data">
<thead>
<tr class="italic">
    <th width="5%">No.</th>
    <th width="15%">Nama</th>
    <th width="5%">Kelamin</th>
    <th width="10%">Tmp Lahir</th>
    <th width="20%">Alamat</th>
    <th width="10%">Telp</th>
    <th width="10%">Email</th>
    <th width="5%">Jabatan</th>
    <th width="15%">No. SIPA</th>
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
        'id' => $_GET['id_karyawan'],
        'limit' => $limit,
        'start' => $offset,
        'search' => $_GET['search']
    );
    $list_data = load_data_karyawan($param);
    $master_barang = $list_data['data'];
    $total_data = $list_data['total'];
    foreach ($master_barang as $key => $data) { 
        $str = $data->id.'#'.$data->nama.'#'.$data->kelamin.'#'.$data->tempat_lahir.'#'.datefmysql($data->tanggal_lahir)
                .'#'.$data->alamat.'#'.$data->kabupaten.'#'.$data->propinsi.'#'.$data->telp.'#'.$data->email.'#'.$data->jabatan
                .'#'.$data->no_sipa;
        ?>
    <tr class="<?= ($key%2==0)?'even':'odd' ?>">
        <td align="center"><?= (++$key+$offset) ?></td>
        <td><?= $data->nama ?></td>
        <td align="center"><?= $data->kelamin ?></td>
        <td><?= $data->tempat_lahir ?></td>
        <td><?= $data->alamat ?></td>
        <td><?= $data->telp ?></td>
        <td><?= $data->email ?></td>
        <td align="center"><?= $data->jabatan ?></td>
        <td><?= $data->no_sipa ?></td>
        <td class='aksi' align='center'>
            <a class='edition' onclick="edit_karyawan('<?= $str ?>');" title="Klik untuk edit barang">&nbsp;</a>
            <a class='deletion' onclick="delete_karyawan('<?= $data->id ?>', '<?= $page ?>');" title="Klik untuk hapus barang">&nbsp;</a>
        </td>
    </tr>
    <?php } ?>
</tbody>
</table>
<?= paging_ajax($total_data, $limit, $page, '1', $_GET['search']) ?>