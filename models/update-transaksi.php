<?php
include_once '../config/database.php';
include_once '../inc/functions.php';
$method = $_GET['method'];

if ($method === 'save_pemesanan') {
    $tanggal        = date2mysql($_POST['tanggal']);
    $id_supplier    = $_POST['id_supplier'];
    $id_barang      = $_POST['id_barang'];
    $id_kemasan     = $_POST['kemasan'];
    $jumlah         = $_POST['jumlah'];
    //$id_user        = 'NULL';
    $sql = "insert INTO pemesanan set
        tanggal = '$tanggal',
        id_supplier = '$id_supplier'";
    mysql_query($sql);
    $id_pemesanan = mysql_insert_id();
    
    foreach ($id_barang as $key => $data) {
        $id_packing = mysql_query("select id from kemasan where id_barang = '$data' and id_kemasan = '$id_kemasan'");
        $sql = "insert into detail_pemesanan set
            id_pemesanan = '$id_pemesanan',
            id_kemasan = '$id_packing',
            jumlah = '$jumlah[$key]'";
        mysql_query($sql);
    }
    
    $result['status'] = TRUE;
    $result['id_pemesanan'] = get_last_pemesanan();
    
    die(json_encode($result));
}

if ($method === 'delete_pemesanan') {
    $id     = $_GET['id'];
    mysql_query("delete from pemesanan where id = '$id'");
}

if ($method === 'save_penerimaan') {
    $faktur         = $_POST['faktur'];
    $tanggal        = date2mysql($_POST['tanggal']);
    $no_sp          = $_POST['no_sp'];
    $supplier       = $_POST['id_supplier'];
    $ppn            = $_POST['ppn'];
    $materai        = currencyToNumber($_POST['materai']);
    $tempo          = date2mysql($_POST['tempo']);
    //$id_user        = ""; // unUsed
    $disc_pr        = $_POST['disc_pr'];
    $disc_rp        = currencyToNumber($_POST['disc_rp']);
    $total          = currencyToNumber($_POST['total']);
    $id_penerimaan  = $_POST['id_penerimaan'];
    
    if ($id_penerimaan === '') {
        $sql = "insert into penerimaan set
            faktur = '$faktur',
            tanggal = '$tanggal',
            id_supplier = '$supplier',
            id_pemesanan = '$no_sp',
            ppn = '$ppn',
            materai = '$materai',
            jatuh_tempo = '$tempo',
            diskon_persen = '$disc_pr',
            diskon_rupiah = '$disc_rp',
            total = '$total'";
        mysql_query($sql);
        $id = mysql_insert_id();
        
        $id_barang  = $_POST['id_barang'];
        $id_kemasan = $_POST['satuan'];
        $jumlah     = $_POST['jumlah'];
        $no_batch   = $_POST['nobatch'];
        $ed         = $_POST['ed'];
        $harga      = $_POST['harga'];
        $diskon_pr  = $_POST['diskon_pr'];
        $diskon_rp  = $_POST['diskon_rp'];
        foreach ($id_barang as $key => $data) {
            $query  = mysql_query("select * from kemasan where id_barang = '$data' and id_kemasan = '$id_kemasan[$key]'");
            $rows   = mysql_fetch_object($query);
            
            $harga_a= currencyToNumber($harga[$key]);
            $hna_ttl= $harga_a+($harga_a*($ppn/100));
            $hna    = $hna_ttl/($rows->isi*$rows->isi_satuan);
            
            mysql_query("update barang set hna = '$hna' where id = '$data'"); // update HNA baru
            
            $sql = "insert into detail_penerimaan set
                id_penerimaan = '$id',
                id_kemasan = '".$rows->id."',
                nobatch = '$no_batch[$key]',
                expired = '$ed[$key]',
                harga = '$harga_a',
                jumlah = '$jumlah[$key]',
                disc_pr = '$diskon_pr[$key]',
                disc_rp = '".currencyToNumber($diskon_rp[$key])."'
                ";
            mysql_query($sql);
            
            $stok= "insert into stok set
                waktu = '$tanggal ".date("H:i:s")."',
                id_transaksi = '$id',
                transaksi = 'Penerimaan',
                nobatch = '$no_batch[$key]',
                id_barang = '$data',
                ed = '".date2mysql($ed[$key])."',
                masuk = '".($jumlah[$key]*($rows->isi*$rows->isi_satuan))."'
            ";
            mysql_query($stok);
        }
        $result['action'] = 'add';
    } else {
        $sql = "update penerimaan set
            faktur = '$faktur',
            tanggal = '$tanggal',
            id_supplier = '$supplier',
            id_pemesanan = '$no_sp',
            ppn = '$ppn',
            materai = '$materai',
            jatuh_tempo = '$tempo',
            diskon_persen = '$disc_pr',
            diskon_rupiah = '$disc_rp',
            total = '$total'
            where id = '$id_penerimaan'";
        mysql_query($sql);
        $id = $id_penerimaan;
        mysql_query("delete from detail_penerimaan where id_penerimaan = '$id_penerimaan'");
        $id_barang  = $_POST['id_barang'];
        $id_kemasan = $_POST['satuan'];
        $jumlah     = $_POST['jumlah'];
        $no_batch   = $_POST['nobatch'];
        $ed         = $_POST['ed'];
        $harga      = $_POST['harga'];
        $diskon_pr  = $_POST['diskon_pr'];
        $diskon_rp  = $_POST['diskon_rp'];
        foreach ($id_barang as $key => $data) {
            $query = mysql_query("select * from kemasan where id_barang = '$data' and id_kemasan = '$id_kemasan[$key]'");
            $rows  = mysql_fetch_object($query);
            $sql = "insert into detail_penerimaan set
                id_penerimaan = '$id',
                id_kemasan = '".$rows->id."',
                nobatch = '$no_batch[$key]',
                expired = '$ed[$key]',
                harga = '$harga_a',
                jumlah = '$jumlah[$key]',
                disc_pr = '$diskon_pr[$key]',
                disc_rp = '".currencyToNumber($diskon_rp[$key])."'
                ";
            mysql_query($sql);
        }
        $result['action'] = 'edit';
    }
    $result['status'] = TRUE;
    $result['id_penerimaan'] = $id;
    
    die(json_encode($result));
}

if ($method === 'delete_penerimaan') {
    $id     = $_GET['id'];
    mysql_query("delete from penerimaan where id = '$id'");
    mysql_query("delete from stok where id_transaksi = '$id' and transaksi = 'Penerimaan'");
}

if ($method === 'save_stokopname') {
    $tanggal    = date2mysql($_POST['tanggal']).' '.date("H:i:s");
    $id_barang  = $_POST['id_barang'];
    $nobatch    = $_POST['nobatch'];
    $ed         = $_POST['ed'];
    $masuk      = $_POST['masuk'];
    $keluar     = $_POST['keluar'];
    
    foreach ($id_barang as $key => $data) {
        $sql = "insert into stok set
            waktu = '$tanggal',
            transaksi = 'Stok Opname',
            nobatch = '$nobatch[$key]',
            id_barang = '$data',
            ed = '".date2mysql($ed[$key])."',
            masuk = '$masuk[$key]',
            keluar = '$keluar[$key]'
        ";
        mysql_query($sql);
    }
    die(json_encode(array('status' => TRUE)));
}

if ($method === 'delete_stokopname') {
    $id = $_GET['id'];
    mysql_query("delete from stok where id = '$id'");
}

if ($method === 'save_penjualannr') {
    $tanggal    = date2mysql($_POST['tanggal']).' '.date("H:i:s");
    $customer   = ($_POST['id_customer'] !== '')?$_POST['id_customer']:"NULL";
    $diskon_pr  = $_POST['diskon_pr'];
    $diskon_rp  = currencyToNumber($_POST['diskon_pr']);
    $ppn        = $_POST['ppn'];
    $total      = $_POST['total_penjualan'];
    $tuslah     = currencyToNumber($_POST['tuslah']);
    $sql = "insert into penjualan set
        waktu = '$tanggal',
        id_pelanggan = $customer,
        diskon_persen = '$diskon_pr',
        diskon_rupiah = '$diskon_rp',
        ppn = '$ppn',
        total = '$total',
        tuslah = '$tuslah'";
    
    mysql_query($sql);
    $id_penjualan = mysql_insert_id();
    
    $id_barang  = $_POST['id_barang'];
    $kemasan    = $_POST['kemasan'];
    $jumlah     = $_POST['jumlah'];
    $harga_jual = $_POST['harga_jual'];
        foreach ($id_barang as $key => $data) {
            $query = mysql_query("select * from kemasan where id = '$kemasan[$key]'");
            $rows  = mysql_fetch_object($query);
            $isi   = $rows->isi*$rows->isi_satuan;
            $sql = "insert into detail_penjualan set
                id_penjualan = '$id_penjualan',
                id_kemasan = '$kemasan[$key]',
                qty = '".($jumlah[$key]*$isi)."',
                harga_jual = '$harga_jual[$key]'
                ";
            mysql_query($sql);
            
            $last = mysql_fetch_object(mysql_query("select * from stok where id_barang = '$data' order by id desc limit 1"));
            
            $stok = "insert into stok set
                waktu = '$tanggal',
                id_transaksi = '$id_penjualan',
                transaksi = 'Penjualan',
                id_barang = '$data',
                keluar = '".($jumlah[$key]*$isi)."'";
            //echo $stok;
            mysql_query($stok);
        }
    die(json_encode(array('status' => TRUE)));
}
?>
