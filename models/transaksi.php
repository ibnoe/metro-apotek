<?php

include_once '../config/database.php';

function pemesanan_load_data($param) {
    $q = NULL;
    if ($param['id'] !== '') {
        $q.="and p.id = '".$param['id']."' ";
    }
    $limit = " limit ".$param['start'].", ".$param['limit']."";
    $sql = "select p.*, k.nama as karyawan, s.nama as supplier from pemesanan p
        join supplier s on (p.id_supplier = s.id)
        left join users u on (p.id_users = u.id)
        left join karyawan k on (u.id_karyawan = k.id)
        where p.id is not NULL $q";
    //echo $sql;
    $query = mysql_query($sql.$limit);
    $data = array();
    while ($row = mysql_fetch_object($query)) {
        $data[] = $row;
    }
    $total = mysql_num_rows(mysql_query($sql));
    $result['data'] = $data;
    $result['total']= $total;
    return $result;
}

function penerimaan_load_data($param) {
    $q = NULL;
    if ($param['id'] !== NULL) {
        $q.="and p.id = '".$param['id']."' ";
    }
    $limit = " limit ".$param['start'].", ".$param['limit']."";
    $sql = "select p.*, k.nama as karyawan, s.nama as supplier from penerimaan p
        left join pemesanan ps on (p.id_pemesanan = ps.id)
        join supplier s on (ps.id_supplier = s.id)
        left join users u on (p.id_users = u.id)
        left join karyawan k on (u.id_karyawan = k.id)
        where p.id is not NULL";
    $query = mysql_query($sql.$limit);
    $data = array();
    while ($row = mysql_fetch_object($query)) {
        $data[] = $row;
    }
    $total = mysql_num_rows(mysql_query($sql));
    $result['data'] = $data;
    $result['total']= $total;
    return $result;
}

function load_data_stok_opname($param) {
    $q = NULL;
    if ($param['id'] !== '') {
        $q.="and s.id = '".$param['id']."' ";
    }
    $limit = " limit ".$param['start'].", ".$param['limit']."";
    $sql = "select s.*, b.kekuatan, b.nama, st.nama as satuan_kekuatan, sum(s.masuk) as masuk, sum(s.keluar) as keluar, (sum(s.masuk)-sum(s.keluar)) as sisa from stok s 
        join barang b on (s.id_barang = b.id)
        left join satuan st on (b.satuan_kekuatan = st.id)
        where s.id is not NULL $q group by s.id_barang";
    //echo $sql;
    $query = mysql_query($sql.$limit);
    $data = array();
    while ($row = mysql_fetch_object($query)) {
        $data[] = $row;
    }
    $total = mysql_num_rows(mysql_query($sql));
    $result['data'] = $data;
    $result['total']= $total;
    return $result;
}

function load_data_resep($param) {
    $q = NULL;
    if ($param['id'] !== '') {
        $q.="and r.id = '".$param['id']."' ";
    }
    $limit = " limit ".$param['start'].", ".$param['limit']."";
    $sql   = "select r.*, rr.id_resep, rr.r_no, d.nama as dokter, k.nama as apoteker, t.nama as tarif, p.nama as pasien, rr.resep_r_jumlah, 
        rr.tebus_r_jumlah, rr.pakai_aturan, rr.iter, rr.nominal from resep r
        join resep_r rr on (r.id = rr.id_resep)
        join tarif t on (t.id = rr.id_tarif)
        left join pelanggan p on (p.id = r.id_pasien)
        left join dokter d on (d.id = r.id_dokter)
        left join karyawan k on (k.id = rr.id_karyawan)
        where r.id is not NULL $q
    ";
    $query = mysql_query($sql.$limit);
    $data = array();
    while ($row = mysql_fetch_object($query)) {
        $data[] = $row;
    }
    $total = mysql_num_rows(mysql_query($sql));
    $result['data'] = $data;
    $result['total']= $total;
    return $result;
}

function penjualan_nr_load_data($param) {
    $q = NULL;
    if ($param['id'] !== '') {
        $q.="and r.id = '".$param['id']."' ";
    }
    $limit = " limit ".$param['start'].", ".$param['limit']."";
    $sql = "select p.*, date(p.waktu) as tanggal, pl.nama as customer, a.nama as asuransi from penjualan p
        left join pelanggan pl on (p.id_pelanggan = pl.id)
        left join asuransi a on (pl.id_asuransi = a.id)";
    $query = mysql_query($sql.$limit);
    $data = array();
    while ($row = mysql_fetch_object($query)) {
        $data[] = $row;
    }
    $total = mysql_num_rows(mysql_query($sql));
    $result['data'] = $data;
    $result['total']= $total;
    return $result;
}
?>