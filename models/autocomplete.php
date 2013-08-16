<?php

include_once '../config/database.php';
$method = isset($_GET['method'])?$_GET['method']:NULL;
$q      = isset($_GET['q'])?$_GET['q']:NULL;
if ($method === 'pabrik') {
    $rows = array();
    $sql = mysql_query("select * from pabrik where nama like ('%$q%') order by locate('$q',nama)");
    while ($data = mysql_fetch_object($sql)) {
        $rows[] = $data;
    }
    die(json_encode($rows));
}

if ($method === 'dokter') {
    $sql = mysql_query("select * from dokter where nama like ('%$q%') order by locate('$q', nama)");
    $rows = array();
    while ($data = mysql_fetch_object($sql)) {
        $rows[] = $data;
    }
    die(json_encode($rows));
}

if ($method === 'pasien') {
    $sql = mysql_query("select p.*, a.nama as asuransi, a.diskon as reimburse from pelanggan p
        left join asuransi a on (p.id_asuransi = a.id) 
        where p.nama like ('%$q%') order by locate('$q', p.nama)");
    $rows = array();
    while ($data = mysql_fetch_object($sql)) {
        $rows[] = $data;
    }
    die(json_encode($rows));
}

if ($method === 'get_data_kemasan') {
    $id = $_GET['id'];
    $sql = mysql_query("select s.id, s.nama as kemasan, st.nama as satuan_kecil, k.isi from kemasan k
        join satuan s on (k.id_kemasan = s.id)
        left join satuan st on (k.id_satuan = st.id)
        where k.id_barang = '$id'");
    $rows = array();
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

if ($method === 'get_barang') {
    $barcode = $_GET['barcode'];
    $sql = mysql_query("select b.*, p.nama as pabrik, g.nama as golongan, st.nama as satuan, sd.nama as sediaan,
        concat_ws(' ', b.nama, b.kekuatan, st.nama) as nama_barang
        from barang b 
        left join pabrik p on (b.id_pabrik = p.id)
        left join golongan g on (b.id_golongan = g.id)
        left join satuan st on (b.satuan_kekuatan = st.id)
        left join sediaan sd on (b.id_sediaan = sd.id) where b.barcode = '$barcode'");
    $data = mysql_fetch_object($sql);
    die(json_encode($data));
}

if ($method === 'farmakoterapi') {
    $rows = array();
    $id   = $_GET['id'];
    $sql = mysql_query("select * from kelas_terapi where id_farmako_terapi = '$id'");
    while ($data = mysql_fetch_object($sql)) {
        $rows[] = $data;
    }
    die(json_encode($rows));
}

if ($method === 'golongan_load_data') {
    $id   = $_GET['id'];
    $sql = mysql_query("select * from golongan where id = '$id'");
    $data = mysql_fetch_object($sql);
    die(json_encode($data));
}

if ($method === 'get_kemasan_barang') {
    $id = $_GET['id'];
    $rows = NULL;
    $sql = mysql_query("select k.id, k.id_kemasan, s.nama from kemasan k join satuan s on (k.id_kemasan = s.id) where k.id_barang = '$id' order by k.id desc");
    while ($data = mysql_fetch_object($sql)) {
        $rows[] = $data;
    }
    die(json_encode($rows));
}

if ($method === 'get_nomor_sp') {
    $sql = mysql_query("select p.*, s.nama as supplier FROM pemesanan p join supplier s on (p.id_supplier = s.id) where p.id like ('%$q%') order by locate('$q',p.id)");
    while ($data = mysql_fetch_object($sql)) {
        $rows[] = $data;
    }
    die(json_encode($rows));
}

if ($method === 'get_attr_penerimaan') {
    $query= mysql_query("select penerimaan from config_autonumber");
    $auto = mysql_fetch_object($query);
    
    $sql  = mysql_query("select faktur from penerimaan order by id desc limit 1");
    $row  = mysql_fetch_object($sql);
    
    
    if (isset($row->faktur)) {
        $last_faktur = $auto->penerimaan.str_pad((string)($row->id+1), 6, "0", STR_PAD_LEFT);
    } else {
        $last_faktur = $auto->penerimaan.'000001';
    }
    
    $date = mktime(0, 0, 0, date("m"), date("d")+30, date("Y"));
    $tempo= date("d/m/Y",$date);
    die(json_encode(array('faktur' => $last_faktur, 'tempo' => $tempo)));
}

if ($method === 'get_data_pemesanan_penerimaan') {
    $sql = "select b.id as id_barang, b.nama, b.kekuatan, st.nama as satuan_kekuatan, s.id as id_kemasan, s.nama as kemasan, k.id, dp.jumlah 
        from detail_pemesanan dp
        join kemasan k on (k.id = dp.id_kemasan)
        join barang b on (b.id = k.id_barang)
        join satuan s on (k.id_kemasan = s.id)
        join satuan st on (b.satuan_kekuatan = st.id)";
    $result = mysql_query($sql);
    while ($data = mysql_fetch_object($result)) {
        $rows[] = $data;
    }
    die(json_encode($rows));
}

if ($method === 'get_stok_sisa') {
    $id  = $_GET['id'];
    $sql = mysql_query("select (sum(masuk)-sum(keluar)) as sisa from stok where id_barang = '$id'");
    $row = mysql_fetch_object($sql);
    
    die(json_encode($row));
}

if ($method === 'get_detail_harga_barang') {
    $id = $_GET['id'];
    $jml= $_GET['jumlah'];
    $qry= mysql_query("select is_harga_bertingkat from kemasan where id = '$id'");
    $cek= mysql_fetch_object($qry);
    if ($cek->is_harga_bertingkat === '0') {
        $sql = mysql_query("select b.*, (b.hna+(b.hna*(b.margin_non_resep/100))) as harga_jual from kemasan k join barang b on (k.id_barang = b.id) where k.id = '$id'");
        $rows= mysql_fetch_object($sql);
    } else {
        $sql= mysql_query("select *, hj_non_resep as harga_jual from dinamic_harga_jual where id_kemasan = '$id' and $jml between jual_min and jual_max");
        $rows= mysql_fetch_object($sql);
    }
    die(json_encode($rows));
}
?>