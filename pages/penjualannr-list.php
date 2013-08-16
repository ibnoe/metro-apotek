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
        <th width="20%">Customer</th>
        <th width="10%">Diskon Rp.</th>
        <th width="10%">Diskon %</th>
        <th width="10%">PPN %</th>
        <th width="10%">Tuslah RP.</th>
        <th width="10%">Embalage RP.</th>
        <th width="10%">Total</th>
        <!--<th width="5%">#</th>-->
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
        'id' => $_GET['id_penjualannr'],
        'limit' => $limit,
        'start' => $offset,
        'search' => $_GET['search']
    );
    $penjualan_nr = penjualan_nr_load_data($param);
    $list_data = $penjualan_nr['data'];
    $total_data= $penjualan_nr['total'];
    foreach ($list_data as $key => $data) { ?>
        <tr class="<?= ($key%2==0)?'even':'odd' ?>">
            <td align="center"><?= (++$key+$offset) ?></td>
            <td align="center"><?= datefmysql($data->waktu) ?></td>
            <td><?= $data->customer ?></td>
            <td align="right"><?= $data->diskon_rupiah ?></td>
            <td align="center"><?= $data->diskon_persen ?></td>
            <td align="center"><?= $data->ppn ?></td>
            <td align="right"><?= $data->tuslah ?></td>
            <td align="right"><?= $data->embalage ?></td>
            <td align="right"><?= rupiah($data->total) ?></td>
<!--            <td class='aksi' align='center'>
                <a class='edition' onclick="edit_penjualan_nr('<?= $str ?>');" title="Klik untuk edit penjualan_nr">&nbsp;</a>
                <a class='deletion' onclick="delete_penjualan_nr('<?= $data->id ?>','<?= $page ?>');" title="Klik untuk hapus penjualan_nr">&nbsp;</a>
            </td>-->
        </tr>
    <?php }
    ?>
</tbody>
</table>
<?= paging_ajax($total_data, $limit, $page, '1', $_GET['search']) ?>