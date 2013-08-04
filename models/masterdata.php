<?php

include_once '../config/database.php';

function load_data_barang($param) {
    $q = NULL;
    if ($param['id'] !== '') {
        $q.= "and b.id = '".$param['id']."'";
    }
    if ($param['search'] !== '') {
        $q.="and b.nama like ('%".$param['search']."%')";
    }
    $limit = " limit ".$param['start'].", ".$param['limit']."";
    $sql = "select b.*, p.nama as pabrik, g.nama as golongan, f.id as id_farmakoterapi, st.nama as satuan, sd.nama as sediaan 
        from barang b 
        left join pabrik p on (b.id_pabrik = p.id)
        left join golongan g on (b.id_golongan = g.id)
        left join satuan st on (b.satuan_kekuatan = st.id)
        left join kelas_terapi k on (k.id = b.id_kelas_terapi)
        left join farmako_terapi f on (f.id = k.id_farmako_terapi)
        left join sediaan sd on (b.id_sediaan = sd.id) where b.id is not NULL $q order by b.nama
        ";
    //echo $sql.$limit;
    
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

function load_data_pabrik($param) {
    $q = null;
    if ($param['id'] !== '') {
        $q = " and id = '".$param['id']."'";
    }
    $limit = " limit ".$param['start'].", ".$param['limit']."";
    $sql = "select * from pabrik where id is not NULL $q order by nama";
    
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

function load_data_instansi($param) {
    $q = null;
    if ($param['id'] !== '') {
        $q = " and id = '".$param['id']."'";
    }
    $limit = " limit ".$param['start'].", ".$param['limit']."";
    $sql = "select * from instansi where id is not NULL $q order by nama";
    
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

function load_data_supplier($param) {
    $q = null;
    if ($param['id'] !== '') {
        $q = "and id = '".$param['id']."'";
    }
    $limit = " limit ".$param['start'].", ".$param['limit']."";
    $sql = "select * from supplier where id is not NULL $q order by nama";
    
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

function load_data_bank($param = null) {
    $q = null;
    if ($param['id'] !== '') {
        $q = "and id = '".$param['id']."'";
    }
    $limit = " limit ".$param['start'].", ".$param['limit']."";
    $sql = "select * from bank where id is not NULL $q order by nama";
    
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

function load_data_customer($param) {
    $q = null;
    if ($param['id'] !== '') {
        $q = "and id = '".$param['id']."'";
    }
    $limit = " limit ".$param['start'].", ".$param['limit']."";
    $sql = "select p.*, a.nama as asuransi from pelanggan p
        left join asuransi a on (p.id_asuransi = a.id) $q 
        order by p.nama";
    
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

function load_data_karyawan($param) {
    $q = null;
    if ($param['id'] !== '') {
        $q = "and id = '".$param['id']."'";
    }
    $limit = " limit ".$param['start'].", ".$param['limit']."";
    $sql = "select * from karyawan where id is not NULL $q 
        order by nama";
    
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

function load_data_layanan($param) {
    $q = null;
    if ($param['id'] !== '') {
        $q = "and id = '".$param['id']."'";
    }
    $limit = " limit ".$param['start'].", ".$param['limit']."";
    $sql = "select * from tarif where id is not NULL $q 
        order by nama";
    
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

function load_data_asuransi($id = null) {
    $q = null;
    if ($id !== '') {
        $q = "where id = '$id'";
    }
    $sql = "select * from asuransi $q order by nama asc";
    $query = mysql_query($sql);
    $data = array();
    while ($row = mysql_fetch_object($query)) {
        $data[] = $row;
    }
    return $data;
}

function load_data_asuransi_list($param) {
    $q = null;
    if ($param['id'] !== '') {
        $q = "and id = '".$param['id']."'";
    }
    $limit = " limit ".$param['start'].", ".$param['limit']."";
    $sql = "select * from asuransi where id is not NULL $q order by nama asc";
    
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

function golongan_load_data() {
    $sql = "select * from golongan order by nama asc";
    $query = mysql_query($sql);
    $data = array();
    while ($row = mysql_fetch_object($query)) {
        $data[] = $row;
    }
    return $data;
}

function satuan_load_data($status = null) {
    $q = NULL;
    if ($status != NULL) {
        $q = "where is_satuan_kemasan = '$status'";
    }
    $sql = "select * from satuan $q order by nama asc";
    $query = mysql_query($sql);
    $data = array();
    while ($row = mysql_fetch_object($query)) {
        $data[] = $row;
    }
    return $data;
}

function sediaan_load_data($status = null) {
    $q = NULL;
    if ($status != NULL) {
        $q = "where id = '$status'";
    }
    $sql = "select * from sediaan $q order by nama asc";
    $query = mysql_query($sql);
    $data = array();
    while ($row = mysql_fetch_object($query)) {
        $data[] = $row;
    }
    return $data;
}

function admr_load_data() {
    return array('Oral','Rektal','Infus','Topikal','Sublingual','Transdermal','Intrakutan','Subkutan','Intravena','Intramuskuler','Vagina','Injeksi','Intranasal','Intraokuler','Intraaurikuler','Intrapulmonal','Implantasi','Subkutan','Intralumbal','Intrarteri');
}

function load_data_akun() {
    $sql = "select * from akun order by kode asc";
    $query = mysql_query($sql);
    $data = array();
    while ($row = mysql_fetch_object($query)) {
        $data[] = $row;
    }
    return $data;
}

function load_data_dokter($param) {
    $q = null;
    if ($param['id'] !== '') {
        $q = "and id = '".$param['id']."'";
    }
    $limit = " limit ".$param['start'].", ".$param['limit']."";
    $sql = "select * from dokter where id is not NULL $q 
        order by nama";
    
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

function perundangan_load_data() {
    return array('Bebas','Bebas Terbatas','OWA','Keras','Psikotropika','Narkotika');
}

function farmakoterapi_load_data() {
    $sql = "select * from farmako_terapi ORDER by nama";
    $query = mysql_query($sql);
    $data = array();
    while ($row = mysql_fetch_object($query)) {
        $data[] = $row;
    }
    return $data;
}

function fda_load_data() {
    return array('A','B','C','D','X');
}

?>