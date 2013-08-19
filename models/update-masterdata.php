<?php
include_once '../config/database.php';
include_once '../inc/functions.php';
$method = $_GET['method'];

if ($method === 'save_barang') {
    
    $nama       = $_POST['nama'];
    $barcode    = $_POST['barcode'];
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
    $aturan_pki = $_POST['aturan_pakai'];
    $kls_terapi = (isset($_POST['kls_terapi']) and ($_POST['kls_terapi'] !== ''))?$_POST['kls_terapi']:'NULL';
    $fda_pregnan= $_POST['fda_pregnan'];
    $fda_lactacy= $_POST['fda_lactacy'];
    $id_barang  = $_POST['id_barang'];
    $UploadDirectory	= '../img/barang/'; //Upload Directory, ends with slash & make sure folder exist
    $NewFileName= NULL;
        // replace with your mysql database details
    if (!@file_exists($UploadDirectory)) {
            //destination folder does not exist
            die("Make sure Upload directory exist!");
    }
    if(isset($_FILES['mFile']['name'])) {

            $FileName           = strtolower($_FILES['mFile']['name']); //uploaded file name
            $FileTitle		= mysql_real_escape_string($_POST['nama']); // file title
            $ImageExt		= substr($FileName, strrpos($FileName, '.')); //file extension
            $FileType		= $_FILES['mFile']['type']; //file type
            //$FileSize		= $_FILES['mFile']["size"]; //file size
            $RandNumber   		= rand(0, 9999999999); //Random number to make each filename unique.
            //$uploaded_date		= date("Y-m-d H:i:s");

            switch(strtolower($FileType))
            {
                    //allowed file types
                    case 'image/png': //png file
                    case 'image/gif': //gif file 
                    case 'image/jpeg': //jpeg file
                    case 'application/pdf': //PDF file
                    case 'application/msword': //ms word file
                    case 'application/vnd.ms-excel': //ms excel file
                    case 'application/x-zip-compressed': //zip file
                    case 'text/plain': //text file
                    case 'text/html': //html file
                            break;
                    default:
                            die('Unsupported File!'); //output error
            }


            //File Title will be used as new File name
            $NewFileName = preg_replace(array('/\s/', '/\.[\.]+/', '/[^\w_\.\-]/'), array('_', '.', ''), strtolower($FileTitle));
            $NewFileName = $NewFileName.'_'.$RandNumber.$ImageExt;
       //Rename and save uploded file to destination folder.
       if(move_uploaded_file($_FILES['mFile']["tmp_name"], $UploadDirectory . $NewFileName ))
       {
                    //die('Success! File Uploaded.');

       }else{
                    //die('error uploading File!');
       }
    }
    if ($id_barang === '') {
        $sql = "insert into barang set
                barcode = '$barcode',
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
                aturan_pakai = '$aturan_pki',
                id_kelas_terapi = $kls_terapi,
                fda_pregnancy = '$fda_pregnan',
                fda_lactacy = '$fda_lactacy',
                stok_minimal = '$stok_min',
                margin_non_resep = '$margin_nr',
                margin_resep = '$margin_r',
                plus_ppn = '$plus_ppn',
                hna = '$hna',
                aktif = '$aktif',
                image = '$NewFileName'";
        mysql_query($sql);
        $id = mysql_insert_id();
        
        if (isset($_POST['jumlah'])) {
            $jumlah     = $_POST['jumlah'];
            for ($i = 0; $i <= $jumlah; $i++) {
                $id_kemasan = $_POST['id_kemasan'.$i];
                $barcode    = $_POST['barcode'.$i];
                $kemasan    = $_POST['kemasan'.$i]; // kemasan terbesar
                $isi        = $_POST['isi'.$i];
                $satuan     = $_POST['satuan'.$i]; // kemasan terkecil
                $isi_satuan = $_POST['isi_kecil'.$i];
                $bertingkat = isset($_POST['is_bertingkat'.$i])?$_POST['is_bertingkat'.$i]:'0';
        
                $query="insert into kemasan set 
                        id_barang = '$id',
                        barcode = '$barcode',
                        id_kemasan = '$kemasan',
                        isi = '$isi',
                        id_satuan = '$satuan',
                        isi_satuan = '$isi_satuan',
                        is_harga_bertingkat = '".(isset($bertingkat)?$bertingkat:'0')."'";
                mysql_query($query);
                $id_packing = mysql_insert_id();
                if (isset($_POST['awal'.$i])) {
                    $awal       = $_POST['awal'.$i];
                    $akhir      = $_POST['akhir'.$i];
                    $margin_nr  = $_POST['margin_nr'.$i];
                    $margin_r   = $_POST['margin_r'.$i];
                    $diskon     = $_POST['d_persen'.$i];
                    $diskon_rp  = $_POST['d_rupiah'.$i];
                    $hj_nonresep= $_POST['hj_nonresep'.$i];
                    $hj_resep   = $_POST['hj_resep'.$i];
                    foreach ($awal as $no => $rows) {
                        $query1 = "insert into dinamic_harga_jual set
                            id_kemasan = '$id_packing',
                            jual_min = '$rows',
                            jual_max = '$akhir[$no]',
                            margin_non_resep = '$margin_nr[$no]',
                            margin_resep = '$margin_r[$no]',
                            diskon_persen = '$diskon[$no]',
                            diskon_rupiah = '".currencyToNumber($diskon_rp[$no])."',
                            hj_non_resep = '$hj_nonresep[$no]',
                            hj_resep = '$hj_resep[$no]'";
                        //echo $query1;
                        mysql_query($query1);
                    }
                }
            }
        }
    } else {
        $sql= "update barang set
                barcode = '$barcode',
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
                aturan_pakai = '$aturan_pki',
                id_kelas_terapi = $kls_terapi,
                fda_pregnancy = '$fda_pregnan',
                fda_lactacy = '$fda_lactacy',
                stok_minimal = '$stok_min',
                margin_non_resep = '$margin_nr',
                margin_resep = '$margin_r',
                plus_ppn = '$plus_ppn',
                hna = '$hna',
                aktif = '$aktif'";
        
        if (isset($_FILES['mFile']['name']) and $_FILES['mFile']['name'] !== '') {
            $sql.= ",image = '$NewFileName'";
        }
        $sql.="where id = '$id_barang'";
        mysql_query($sql);
        $id = $id_barang;
        
        if (isset($_POST['jumlah'])) {
            $jumlah     = $_POST['jumlah'];
            for ($i = 0; $i <= $jumlah; $i++) {
                $id_kemasan = $_POST['id_kemasan'.$i];
                $barcode    = $_POST['barcode'.$i];
                $kemasan    = $_POST['kemasan'.$i]; // kemasan terbesar
                $isi        = $_POST['isi'.$i];
                $satuan     = $_POST['satuan'.$i]; // kemasan terkecil
                $isi_satuan = $_POST['isi_kecil'.$i];
                $bertingkat = isset($_POST['is_bertingkat'.$i])?$_POST['is_bertingkat'.$i]:'0';
                if ($id_kemasan !== '') {
                $query="update kemasan set 
                        id_barang = '$id',
                        barcode = '$barcode',
                        id_kemasan = '$kemasan',
                        isi = '$isi',
                        id_satuan = '$satuan',
                        isi_satuan = '$isi_satuan',
                        is_harga_bertingkat = '$bertingkat'
                        where id = '$id_kemasan'";
                    mysql_query($query);
                    //echo $query;
                    $id_packing = $id_kemasan;
                } else {
                    $query="insert into kemasan set
                        id_barang = '$id',
                        barcode = '$barcode',
                        id_kemasan = '$kemasan',
                        isi = '$isi',
                        id_satuan = '$satuan',
                        isi_satuan = '$isi_satuan',
                        is_harga_bertingkat = '$bertingkat'";
                    mysql_query($query);
                    $id_packing = mysql_insert_id();
                }
                //echo $query."<br/>";


                mysql_query("delete from dinamic_harga_jual where id_kemasan = '$id_packing'");
                if (isset($_POST['awal'.$i])) {
                    $awal       = $_POST['awal'.$i];
                    $akhir      = $_POST['akhir'.$i];
                    $margin_nr  = $_POST['margin_nr'.$i];
                    $margin_r   = $_POST['margin_r'.$i];
                    $diskon     = $_POST['d_persen'.$i];
                    $diskon_rp  = $_POST['d_rupiah'.$i];
                    $hj_nonresep= $_POST['hj_nonresep'.$i];
                    $hj_resep   = $_POST['hj_resep'.$i];
                    foreach ($awal as $no => $rows) {
                        $query1 = "insert into dinamic_harga_jual set
                            id_kemasan = '$id_packing',
                            jual_min = '$rows',
                            jual_max = '$akhir[$no]',
                            margin_non_resep = '$margin_nr[$no]',
                            margin_resep = '$margin_r[$no]',
                            diskon_persen = '$diskon[$no]',
                            diskon_rupiah = '".currencyToNumber($diskon_rp[$no])."',
                            hj_non_resep = '$hj_nonresep[$no]',
                            hj_resep = '$hj_resep[$no]'";
                        //echo $query1;
                        mysql_query($query1);
                    }
                }
            }
        }
    }
    
    die(json_encode(array('status' => TRUE, 'id_barang' => $id)));
}

if ($method === 'delete_barang') {
    $id     = $_GET['id'];
    mysql_query("delete from barang where id = '$id'");
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
    $UploadDirectory	= '../img/pelanggan/'; //Upload Directory, ends with slash & make sure folder exist
    $NewFileName= NULL;
        // replace with your mysql database details
    if (!@file_exists($UploadDirectory)) {
            //destination folder does not exist
            die("Make sure Upload directory exist!");
    }
    if(isset($_FILES['mFile']['name'])) {

            $FileName           = strtolower($_FILES['mFile']['name']); //uploaded file name
            $FileTitle		= mysql_real_escape_string($_POST['nama']); // file title
            $ImageExt		= substr($FileName, strrpos($FileName, '.')); //file extension
            $FileType		= $_FILES['mFile']['type']; //file type
            //$FileSize		= $_FILES['mFile']["size"]; //file size
            $RandNumber   		= rand(0, 9999999999); //Random number to make each filename unique.
            //$uploaded_date		= date("Y-m-d H:i:s");

            switch(strtolower($FileType))
            {
                    //allowed file types
                    case 'image/png': //png file
                    case 'image/gif': //gif file 
                    case 'image/jpeg': //jpeg file
                    case 'application/pdf': //PDF file
                    case 'application/msword': //ms word file
                    case 'application/vnd.ms-excel': //ms excel file
                    case 'application/x-zip-compressed': //zip file
                    case 'text/plain': //text file
                    case 'text/html': //html file
                            break;
                    default:
                            die('Unsupported File!'); //output error
            }


            //File Title will be used as new File name
            $NewFileName = preg_replace(array('/\s/', '/\.[\.]+/', '/[^\w_\.\-]/'), array('_', '.', ''), strtolower($FileTitle));
            $NewFileName = $NewFileName.'_'.$RandNumber.$ImageExt;
       //Rename and save uploded file to destination folder.
       if(move_uploaded_file($_FILES['mFile']["tmp_name"], $UploadDirectory . $NewFileName ))
       {
                    //die('Success! File Uploaded.');

       }else{
                    //die('error uploading File!');
       }
    }
    
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
                nopolish = '$nopolish',
                foto = '$NewFileName'
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
                nopolish = '$nopolish'";
                if (isset($_FILES['mFile']['name']) and $_FILES['mFile']['name'] !== '') {
                    $sql.=",foto = '$NewFileName'";
                }
            $sql.="where id = '$id_cust'
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
    $fee        = $_POST['fee'];
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
            tgl_mulai_praktek = '".date2mysql($tgl_praktek)."',
            fee = '$fee'
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
            tgl_mulai_praktek = '".date2mysql($tgl_praktek)."',
            fee = '$fee'
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

if ($method === 'save_jadwal_praktek') {
    $dokter = $_POST['id_dokter'];
    $hari   = $_POST['hari'];
    $jam    = $_POST['jam'];
    $akhir  = $_POST['akhir'];
    $id_jp  = $_POST['id_jadwal_praktek'];
    
    if ($id_jp === '') {
        $sql = "insert into jadwal_dokter set
            id_dokter = '$dokter',
            hari = '$hari',
            jam = '$jam',
            akhir = '$akhir'";
        mysql_query($sql);
        $id = mysql_insert_id();
    } else {
        $sql = "update jadwal_dokter set
            id_dokter = '$dokter',
            hari = '$hari',
            jam = '$jam',
            akhir = '$akhir'
            where id = '$id_jp'    
            ";
        mysql_query($sql);
        $id = $id_jp;
    }
    die(json_encode(array('status' => TRUE, 'id_jadwal_praktek' => $id)));
}

if ($method === 'delete_jadwal_praktek') {
    $id = $_GET['id'];
    mysql_query("delete from jadwal_dokter where id = '$id'");
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

if ($method === 'save_golongan') {
    $nama       = $_POST['nama'];
    $margin_nr  = $_POST['margin_nr'];
    $margin_r   = $_POST['margin_r'];
    $diskon     = $_POST['diskon'];
    $id_golongan= $_POST['id_golongan'];
    
    if ($id_golongan === '') {
        $sql = "insert into golongan set
            nama = '$nama',
            margin_non_resep = '$margin_nr',
            margin_resep = '$margin_r',
            diskon = '$diskon'";
        mysql_query($sql);
        $id = mysql_insert_id();
    } else {
        $sql = "update golongan set
            nama = '$nama',
            margin_non_resep = '$margin_nr',
            margin_resep = '$margin_r',
            diskon = '$diskon'
            where id = '$id_golongan'";
        mysql_query($sql);
        $id = $id_golongan;
    }
    die(json_encode(array('status' => TRUE, 'id_golongan' => $id)));
}

if ($method === 'delete_golongan') {
    $id     = $_GET['id'];
    mysql_query("delete from golongan where id = '$id'");
}

if ($method === 'save_farmakoterapi') {
    $nama   = $_POST['nama'];
    $id     = $_POST['id_farmakoterapi'];
    
    if ($id === '') {
        $sql = "insert into farmako_terapi set
            nama = '$nama'";
        mysql_query($sql);
        $id_farmakoterapi = mysql_insert_id();
    } else {
        $sql = "update farmako_terapi set
            nama = '$nama'
            where id = '$id'";
        mysql_query($sql);
        $id_farmakoterapi = $id;
    }
    die(json_encode(array('status' => TRUE, 'id_farmakoterapi' => $id_farmakoterapi)));
}

if ($method === 'delete_farmakoterapi') {
    $id = $_GET['id'];
    mysql_query("delete from farmako_terapi where id = '$id'");
}

if ($method === 'save_kelasterapi') {
    $nama           = $_POST['nama'];
    $farmakoterapi  = $_POST['farmakoterapi'];
    $id             = $_POST['id_kelasterapi'];
    
    if ($id === '') {
        $sql = "insert into kelas_terapi set
            id_farmako_terapi = '$farmakoterapi',
            nama = '$nama'";
        mysql_query($sql);
        $id_kelas_terapi = mysql_insert_id();
    } else {
        $sql = "update kelas_terapi set
            id_farmako_terapi = '$farmakoterapi',
            nama = '$nama'
            where id = '$id'";
        mysql_query($sql);
        $id_kelas_terapi = $id;
    }
    die(json_encode(array('status' => TRUE, 'id_kelasterapi' => $id_kelas_terapi)));
}

if ($method === 'delete_kelasterapi') {
    $id = $_GET['id'];
    mysql_query("delete from kelas_terapi where id = '$id'");
}

if ($method === 'save_penyakit') {
    $topik      = $_POST['penyakit'];
    $subkode    = $_POST['subkode'];
    $id         = $_POST['id_penyakit'];
    
    if ($id === '') {
        $sql = "insert into penyakit set
            topik = '$topik',
            sub_kode = '$subkode'";
        mysql_query($sql);
        $id_penyakit = mysql_insert_id();
    } else {
        $sql = "update penyakit set
            topik = '$topik',
            sub_kode = '$subkode'
            where id = '$id'";
        mysql_query($sql);
        $id_penyakit = $id;
    }
    die(json_encode(array('status' => TRUE, 'id_penyakit' => $id_penyakit)));
    
}

if ($method === 'delete_penyakit') {
    $id = $_GET['id'];
    mysql_query("delete from penyakit where id = '$id'");
}
?>
