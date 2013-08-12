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
        <th width="10%">Tanggal</th>
        <th width="10%">No. Faktur</th>
        <th width="20%">Nama Supplier</th>
        <th width="5%">PPN</th>
        <th width="5%">Materai</th>
        <th width="5%">Jatuh<br/> Tempo</th>
        <th width="5%">Diskon (%)</th>
        <th width="10%">Total RP.</th>
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
        'id' => $_GET['id_penerimaan'],
        'limit' => $limit,
        'start' => $offset,
        'search' => $_GET['search']
    );
    $penerimaan = penerimaan_load_data($param);
    $list_data = $penerimaan['data'];
    $total_data= $penerimaan['total'];
    foreach ($list_data as $key => $data) { ?>
        <tr class="<?= ($key%2==0)?'even':'odd' ?>">
            <td align="center"><?= (++$key+$offset) ?></td>
            <td align="center"><?= datefmysql($data->tanggal) ?></td>
            <td align="center"><?= $data->faktur ?></td>
            <td><?= $data->supplier ?></td>
            <td align="center"><?= $data->ppn ?></td>
            <td align="center"><?= rupiah($data->materai) ?></td>
            <td align="center"><?= datefmysql($data->jatuh_tempo) ?></td>
            <td align="center"><?= $data->diskon_persen ?></td>
            <td align="right"><?= rupiah($data->total) ?></td>
            <td class='aksi' align='center'>
                <!--<a class='edition' onclick="edit_penerimaan('<?= $str ?>');" title="Klik untuk edit penerimaan">&nbsp;</a>-->
                <a class='deletion' onclick="delete_penerimaan('<?= $data->id ?>','<?= $page ?>');" title="Klik untuk hapus penerimaan">&nbsp;</a>
            </td>
        </tr>
    <?php }
    ?>
</tbody>
</table>