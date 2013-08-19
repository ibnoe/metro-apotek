<?php
include_once '../models/masterdata.php';
include_once '../inc/functions.php';
?>
<table cellspacing="0" width="100%" class="list-data">
<thead>
<tr class="italic">
    <th width="5%">No.</th>
    <th width="20%">Nama Supplier</th>
    <th width="25%">Alamat</th>
    <th width="10%">Email</th>
    <th width="10%">Telp</th>
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
        'id' => $_GET['id_supplier'],
        'limit' => $limit,
        'start' => $offset,
        'search' => $_GET['search']
    );
    $data_list = load_data_supplier($param);
    $list_data = $data_list['data'];
    $total_data= $data_list['total'];
    foreach ($list_data as $key => $data) { 
        $str = $data->id.'#'.$data->nama.'#'.$data->alamat.'#'.$data->email.'#'.$data->telp;
        ?>
    <tr class="<?= ($key%2==0)?'even':'odd' ?>">
        <td align="center"><?= (++$key+$offset) ?></td>
        <td><?= $data->nama ?></td>
        <td><?= $data->alamat ?></td>
        <td><?= $data->email ?></td>
        <td><?= $data->telp ?></td>
        <td class='aksi' align='center'>
            <a class='edition' onclick="edit_supplier('<?= $str ?>');" title="Klik untuk edit supplier">&nbsp;</a>
            <a class='deletion' onclick="delete_supplier('<?= $data->id ?>','<?= $page ?>');" title="Klik untuk hapus supplier">&nbsp;</a>
        </td>
    </tr>
    <?php } ?>
</tbody>
</table>
<?= paging_ajax($total_data, $limit, $page, '1', $_GET['search']) ?>