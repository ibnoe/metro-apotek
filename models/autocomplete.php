<?php

include_once '../config/database.php';
$method = isset($_GET['method'])?$_GET['method']:NULL;
$q      = $_GET['q'];
if ($method === 'pabrik') {
    $rows = array();
    $sql = mysql_query("select * from pabrik where nama like ('%$q%') order by locate('$q',nama)");
    while ($data = mysql_fetch_object($sql)) {
        $rows[] = $data;
    }
    die(json_encode($rows));
}

if ($method === 'supplier') {
    $rows = array();
    $sql = mysql_query("select * from supplier where nama like ('%$q%') order by locate('$q',nama)");
    while ($data = mysql_fetch_object($sql)) {
        $rows[] = $data;
    }
    die(json_encode($rows));
}

if ($method === 'barang') {
    $rows = array();
    $sql = mysql_query("select b.*, p.nama as pabrik, g.nama as golongan, st.nama as satuan, sd.nama as sediaan,
        concat_ws(' ', b.nama, b.kekuatan, st.nama) as nama_barang
        from barang b 
        left join pabrik p on (b.id_pabrik = p.id)
        left join golongan g on (b.id_golongan = g.id)
        left join satuan st on (b.satuan_kekuatan = st.id)
        left join sediaan sd on (b.id_sediaan = sd.id) having nama_barang like ('%$q%')");
    while ($data = mysql_fetch_object($sql)) {
        $rows[] = $data;
    }
    die(json_encode($rows));
}

?>