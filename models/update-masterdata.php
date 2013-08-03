<?php
include_once '../config/database.php';
include_once '../inc/functions.php';
$method = $_GET['method'];

if ($method === 'save_barang') {
    
    $nama       = $_POST['nama'];
    $pabrik     = ($_POST['id_pabrik'] !== '')?$_POST['id_pabrik']:'NULL';
    $perundangan= $_POST['perundangan'];
    $rak        = $_POST['rak'];
    $formularium= $_POST['formularium'];
    $kekuatan   = $_POST['kekuatan'];
    $golongan   = ($_POST['golongan'] !== '')?$_POST['golongan']:'NULL';
    $s_kekuatan = $_POST['s_sediaan'];
    $sediaan    = ($_POST['sediaan'] !== '')?$_POST['sediaan']:'NULL';
    $admr       = $_POST['admr'];
    $generik    = $_POST['generik'];
    
    $indikasi   = strip_tags($_POST['indikasi']);
    $dosis      = strip_tags($_POST['dosis']);
    $kandungan  = strip_tags($_POST['kandungan']);
    $perhatian  = strip_tags($_POST['perhatian']);
    $kontra_ind = strip_tags($_POST['kontra_indikasi']);
    $ef_samping = strip_tags($_POST['efek_samping']);
    
    $stok_min   = $_POST['stok_min'];
    $margin_nr  = $_POST['margin_nr'];
    $margin_r   = $_POST['margin_r'];
    $hna        = currencyToNumber($_POST['hna']);
    $plus_ppn   = isset($_POST['ppn'])?$_POST['ppn']:'0';
    $aktif      = isset($_POST['aktifasi'])?$_POST['aktifasi']:'0';
    $id_barang  = $_POST['id_barang'];
    if ($id_barang === '') {
        $sql = "insert into barang set
                nama = '$nama',
                id_pabrik = $pabrik,
                perundangan = '$perundangan',
                rak = '$rak',
                kekuatan = '$kekuatan',
                id_golongan = $golongan,
                satuan_kekuatan = $s_kekuatan,
                id_sediaan = $sediaan,
                adm_r = '$admr',
                generik = '$generik',
                indikasi = '$indikasi',
                dosis = '$dosis',
                kandungan = '$kandungan',
                perhatian = '$perhatian',
                kontra_indikasi = '$kontra_ind',
                efek_samping = '$ef_samping',
                formularium = '$formularium',
                stok_minimal = '$stok_min',
                margin_non_resep = '$margin_nr',
                margin_resep = '$margin_r',
                plus_ppn = '$plus_ppn',
                hna = '$hna',
                aktif = '$aktif'";
        mysql_query($sql);
        $id = mysql_insert_id();
    } else {
        $sql = "update barang set
                nama = '$nama',
                id_pabrik = $pabrik,
                perundangan = '$perundangan',
                rak = '$rak',
                kekuatan = '$kekuatan',
                id_golongan = $golongan,
                satuan_kekuatan = $s_kekuatan,
                id_sediaan = $sediaan,
                adm_r = '$admr',
                generik = '$generik',
                indikasi = '$indikasi',
                dosis = '$dosis',
                kandungan = '$kandungan',
                perhatian = '$perhatian',
                kontra_indikasi = '$kontra_ind',
                efek_samping = '$ef_samping',
                formularium = '$formularium',
                stok_minimal = '$stok_min',
                margin_non_resep = '$margin_nr',
                margin_resep = '$margin_r',
                plus_ppn = '$plus_ppn',
                hna = '$hna',
                aktif = '$aktif'
            where id = '$id_barang'";
        mysql_query($sql);
        $id = $id_barang;
    }
    
    die(json_encode(array('status' => TRUE, 'id_barang' => $id)));
}

if ($method === 'save_supplier') {
    $nama       = $_POST['nama'];
    $alamat     = $_POST['alamat'];
    $email      = $_POST['email'];
    $telp       = $_POST['telp'];
    $id_supplier= $_POST['id_supplier'];
    
    if ($id_supplier === '') {
        $sql = "
        insert into supplier set
            nama = '$nama',
            alamat = '$alamat',
            email = '$email',
            telp = '$telp'
        ";
        mysql_query($sql);
        $id_sup = mysql_insert_id();
    } else {
        $sql = "
        update supplier set
            nama = '$nama',
            alamat = '$alamat',
            email = '$email',
            telp = '$telp'
        where id = '$id_supplier'";
        mysql_query($sql);
        $id_sup = $id_supplier;
    }
    die(json_encode(array('status' => TRUE, 'id_supplier' => $id_sup)));
}

if ($method === 'delete_supplier') {
    $id     = $_GET['id'];
    mysql_query("delete from supplier where id = '$id'");
}

if ($method === 'save_pabrik') {
    $nama       = $_POST['nama'];
    $alamat     = $_POST['alamat'];
    $email      = $_POST['email'];
    $telp       = $_POST['telp'];
    $id_pabrik  = $_POST['id_pabrik'];
    
    if ($id_pabrik === '') {
        $sql = "
        insert into pabrik set
            nama = '$nama',
            alamat = '$alamat',
            email = '$email',
            telp = '$telp'
        ";
        mysql_query($sql);
        $id_sup = mysql_insert_id();
    } else {
        $sql = "
        update pabrik set
            nama = '$nama',
            alamat = '$alamat',
            email = '$email',
            telp = '$telp'
        where id = '$id_pabrik'";
        mysql_query($sql);
        $id_sup = $id_pabrik;
    }
    die(json_encode(array('status' => TRUE, 'id_pabrik' => $id_sup)));
}

if ($method === 'delete_pabrik') {
    $id     = $_GET['id'];
    mysql_query("delete from pabrik where id = '$id'");
}

if ($method === 'save_instansi') {
    $nama       = $_POST['nama'];
    $alamat     = $_POST['alamat'];
    $email      = $_POST['email'];
    $telp       = $_POST['telp'];
    $id_instansi  = $_POST['id_instansi'];
    
    if ($id_instansi === '') {
        $sql = "
        insert into instansi set
            nama = '$nama',
            alamat = '$alamat',
            email = '$email',
            telp = '$telp'
        ";
        mysql_query($sql);
        $id_sup = mysql_insert_id();
    } else {
        $sql = "
        update instansi set
            nama = '$nama',
            alamat = '$alamat',
            email = '$email',
            telp = '$telp'
        where id = '$id_instansi'";
        mysql_query($sql);
        $id_sup = $id_instansi;
    }
    die(json_encode(array('status' => TRUE, 'id_instansi' => $id_sup)));
}

if ($method === 'delete_instansi') {
    $id     = $_GET['id'];
    mysql_query("delete from instansi where id = '$id'");
}

if ($method === 'save_bank') {
    $nama       = $_POST['nama'];
    $charge     = $_POST['charge'];
    $kodeakun   = $_POST['akun'];
    $id_bank    = $_POST['id_bank'];
    
    if ($id_bank === '') {
        $sql = "
        insert into bank set
            nama = '$nama',
            charge = '$charge',
            kode_akun = '$kodeakun'
        ";
        mysql_query($sql);
        $id_sup = mysql_insert_id();
    } else {
        $sql = "
        update bank set
            nama = '$nama',
            charge = '$charge',
            kode_akun = '$kodeakun'
        where id = '$id_bank'";
        mysql_query($sql);
        $id_sup = $id_bank;
    }
    die(json_encode(array('status' => TRUE, 'id_bank' => $id_sup)));
}

if ($method === 'delete_bank') {
    $id     = $_GET['id'];
    mysql_query("delete from bank where id = '$id'");
}

if ($method === 'save_pelanggan') {
    $nama       = $_POST['nama'];
    $jenis      = $_POST['jenis'];
    $kelamin    = $_POST['kelamin'];
    $tempat     = $_POST['tmp_lahir'];
    $tgllahir   = $_POST['tgl_lahir'];
    $alamat     = $_POST['alamat'];
    $telp       = $_POST['telp'];
    $email      = $_POST['email'];
    $diskon     = $_POST['diskon'];
    $catatan    = $_POST['catatan'];
    $id_asuransi= ($_POST['asuransi'] !== '')?$_POST['asuransi']:'NULL';
    $nopolish   = $_POST['nopolish'];
    $id_cust    = $_POST['id_pelanggan'];
    
    if ($id_cust === '') {
        $sql = "
            insert into pelanggan set
                nama = '$nama',
                jenis = '$jenis',
                kelamin = '$kelamin',
                tempat_lahir = '$tempat',
                tanggal_lahir = '".date2mysql($tgllahir)."',
                alamat = '$alamat',
                telp = '$telp',
                email = '$email',
                diskon = '$diskon',
                catatan = '$catatan',
                id_asuransi = $id_asuransi,
                nopolish = '$nopolish'
        ";
        mysql_query($sql);
        $id_pelanggan = mysql_insert_id();
    }
    else {
        $sql = "
            update pelanggan set
                nama = '$nama',
                jenis = '$jenis',
                kelamin = '$kelamin',
                tempat_lahir = '$tempat',
                tanggal_lahir = '".date2mysql($tgllahir)."',
                alamat = '$alamat',
                telp = '$telp',
                email = '$email',
                diskon = '$diskon',
                catatan = '$catatan',
                id_asuransi = $id_asuransi,
                nopolish = '$nopolish'
            where id = '$id_cust'
        ";
        mysql_query($sql);
        $id_pelanggan = $id_cust;
    }
    die(json_encode(array('status' => TRUE, 'id_pelanggan' => $id_pelanggan)));
}

if ($method === 'delete_pelanggan') {
    $id     = $_GET['id'];
    mysql_query("delete from pelanggan where id = '$id'");
}

if ($method === 'save_dokter') {
    $nama       = $_POST['nama'];
    $kelamin    = $_POST['kelamin'];
    $alamat     = $_POST['alamat'];
    $telp       = $_POST['telp'];
    $email      = $_POST['email'];
    $nostr      = $_POST['nostr'];
    $spesialis  = $_POST['spesialis'];
    $tgl_praktek= $_POST['tglmulai'];
    $id_dokter  = $_POST['id_dokter'];
    if ($id_dokter === '') {
    $sql = "
        insert into dokter set
            nama = '$nama',
            kelamin = '$kelamin',
            alamat = '$alamat',
            telp = '$telp',
            email = '$email',
            no_str = '$nostr',
            spesialis = '$spesialis',
            tgl_mulai_praktek = '".date2mysql($tgl_praktek)."'
    ";
    mysql_query($sql);
    $id_dktr = mysql_insert_id();
    
    } else {
        $sql = "
        update dokter set
            nama = '$nama',
            kelamin = '$kelamin',
            alamat = '$alamat',
            telp = '$telp',
            email = '$email',
            no_str = '$nostr',
            spesialis = '$spesialis',
            tgl_mulai_praktek = '".date2mysql($tgl_praktek)."'
        where id = '$id_dokter'
    ";
    mysql_query($sql);
    $id_dktr = $id_dokter;
    }
    die(json_encode(array('status' => TRUE, 'id_dokter' => $id_dktr)));
}

if ($method === 'delete_dokter') {
    $id     = $_GET['id'];
    mysql_query("delete from dokter where id = '$id'");
}

if ($method === 'save_asuransi') {
    $nama       = $_POST['nama'];
    $diskon     = $_POST['diskon'];
    $id_asuransi= $_POST['id_asuransi'];
    if ($id_asuransi === '') {
        $sql = "
            insert into asuransi set
                nama = '$nama',
                diskon = '$diskon'
        ";
        mysql_query($sql);
        $id_asu = mysql_insert_id();
    } else {
        $sql = "
            update asuransi set
                nama = '$nama',
                diskon = '$diskon'
            where id = '$id_asuransi'
        ";
        mysql_query($sql);
        $id_asu = $id_asuransi;
    }
    die(json_encode(array('status' => TRUE, 'id_asuransi' => $id_asu)));
}

if ($method === 'save_karyawan') {
    $nama       = $_POST['nama'];
    $kelamin    = $_POST['kelamin'];
    $tempat     = $_POST['tmp_lahir'];
    $tgllahir   = $_POST['tgl_lahir'];
    $alamat     = $_POST['alamat'];
    $kabupaten  = $_POST['kabupaten'];
    $provinsi   = $_POST['provinsi'];
    $telp       = $_POST['telp'];
    $email      = $_POST['email'];
    $jabatan    = $_POST['jabatan'];
    $no_sipa    = $_POST['sipa'];
    $id_karyawan= $_POST['id_karyawan'];
    
    if ($id_karyawan === '') {
        $sql = "
            insert into karyawan set
                nama = '$nama',
                kelamin = '$kelamin',
                tempat_lahir = '$tempat',
                tanggal_lahir = '".date2mysql($tgllahir)."',
                alamat = '$alamat',
                kabupaten = '$kabupaten',
                propinsi = '$provinsi',
                telp = '$telp',
                email = '$email',
                jabatan = '$jabatan',
                no_sipa = '$no_sipa'
        ";
        mysql_query($sql);
        $id_kyw = mysql_insert_id();
    } else {
        $sql = "
            update karyawan set
                nama = '$nama',
                kelamin = '$kelamin',
                tempat_lahir = '$tempat',
                tanggal_lahir = '".date2mysql($tgllahir)."',
                alamat = '$alamat',
                kabupaten = '$kabupaten',
                propinsi = '$provinsi',
                telp = '$telp',
                email = '$email',
                jabatan = '$jabatan',
                no_sipa = '$no_sipa'
            where id = '$id_karyawan'
        ";
        mysql_query($sql);
        $id_kyw = $id_karyawan;
    }
    die(json_encode(array('status' => TRUE, 'id_karyawan' => $id_kyw)));
}

if ($method === 'delete_karyawan') {
    $id     = $_GET['id'];
    mysql_query("delete from karyawan where id = '$id'");
}

if ($method === 'save_layanan') {
    $nama       = $_POST['nama'];
    $nominal    = $_POST['nominal'];
    $akun       = $_POST['akun'];
    $id_layanan = $_POST['id_layanan'];
    
    if ($id_layanan === '') {
        $sql = "
            insert into tarif set
                nama = '$nama',
                nominal = '".currencyToNumber($nominal)."',
                kode_akun = ".(($akun !== '')?$akun:'NULL')."
        ";
        mysql_query($sql);
        $id = mysql_insert_id();
    } else {
        $sql = "
            update tarif set
                nama = '$nama',
                nominal = '".currencyToNumber($nominal)."',
                kode_akun = ".(($akun !== '')?$akun:'NULL')."    
            where id = '$id_layanan'
        ";
        
        mysql_query($sql);
        $id = $id_layanan;
    }   
    die(json_encode(array('status' => TRUE, 'id_layanan' => $id)));
}

if ($method === 'delete_layanan') {
    $id     = $_GET['id'];
    mysql_query("delete from tarif where id = '$id'");
}
?>
