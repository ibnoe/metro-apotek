<?php
/* All tiles on the homepage are configured here, be sure to check the tutorials/docs on http://metro-webdesign.info */

/* GROUP 1 */

$tile[] = array("type"=>"img","group"=>0,"x"=>0,"y"=>0,'width'=>1,'height'=>1,"background"=>"#019601","url"=>"penjualan.php",
	"img"=>"img/icons/penjualan.png","desc"=>"Penjualan","showDescAlways"=>true,"imgWidth"=>1,"imgHeight"=>1,
	"labelText"=>"","labelColor"=>"#000","labelPosition"=>"","classes"=>"");

$tile[] = array("type"=>"img","group"=>0,"x"=>1,"y"=>0,'width'=>1,'height'=>1,"background"=>"#0072bc","url"=>"pemesanan.php",
	"img"=>"img/icons/pemesanan.png","desc"=>"Surat Pemesanan","showDescAlways"=>true,"imgWidth"=>1,"imgHeight"=>1,
	"labelText"=>"","labelColor"=>"#000","labelPosition"=>"","classes"=>"");

/*SLIDESHOW TILE - only in full version 
$tile[] = array("type"=>"slideshow","group"=>0,"x"=>0,"y"=>1,"width"=>1,"height"=>1,"background"=>"#6950ab","url"=>"welcome.php",
	"images"=>array("img/img1.png","img/img2.jpg","img/img3.jpg"),
	"effect"=>"slide-right","speed"=>5000,"arrows"=>true,
	"labelText"=>"Slideshow","labelColor"=>"#11528f","labelPosition"=>"bottom",
	"classes"=>"noClick");*/

$tile[] = array("type"=>"img","group"=>0,"x"=>2,"y"=>0,'width'=>1,'height'=>1,"background"=>"#ff6309","url"=>"pemesanan.php",
	"img"=>"img/icons/penerimaan.png","desc"=>"Penerimaan Barang","showDescAlways"=>true,"imgWidth"=>1,"imgHeight"=>1,
	"labelText"=>"","labelColor"=>"#000","labelPosition"=>"","classes"=>"");


$tile[] = array("type"=>"simple","group"=>0,"x"=>0,"y"=>2,'width'=>2,'height'=>1,"background"=>"#b13a3a","url"=>"stokopname.php",
	"title"=>"<span style='font-size:24px;'>Stock Opname</span>",
	"text"=>"Proses mencocokkan persediaan barang",
	"img"=>"img/icons/box_warning.png","imgSize"=>"50","imgToTop"=>"5","imgToLeft"=>"5",
	"labelText"=>"Metro Apotek","labelColor"=>"#453B5E","labelPosition"=>"bottom");



$tile[] = array("type"=>"img","group"=>0,"x"=>0,"y"=>1,'width'=>1,'height'=>1,"background"=>"#4d0ca6","url"=>"retur-penjualan.php",
	"img"=>"img/icons/retur-penjualan.png","desc"=>"Retur Penjualan","showDescAlways"=>true,"imgWidth"=>1,"imgHeight"=>1,
	"labelText"=>"","labelColor"=>"#000","labelPosition"=>"","classes"=>"");

$tile[] = array("type"=>"img","group"=>0,"x"=>1,"y"=>1,'width'=>1,'height'=>1,"background"=>"#ffd600","url"=>"retur-penerimaan.php",
	"img"=>"img/icons/retur-penerimaan.png","desc"=>"Retur Penerimaan","showDescAlways"=>true,"imgWidth"=>1,"imgHeight"=>1,
	"labelText"=>"","labelColor"=>"#000","labelPosition"=>"","classes"=>"");

/* GROUP 2*/
/*<br />
SLIDEFX TILE -  only in full version 
$tile[] = array("type"=>"slidefx","group"=>1,"x"=>0,"y"=>0,'width'=>2,'height'=>1,"background"=>"#333","url"=>"external:img/metro_slide.png",
	"text"=>"Click to see in full","img"=>"img/metro_slide_300x150.png","classes"=>"lightbox"
);
*/
$tile[] = array("type"=>"simple","group"=>1,"x"=>0,"y"=>0,'width'=>2,'height'=>1,"background"=>"#6950AB","url"=>"barang.php",
	"title"=>"<span style='font-size:24px;'>Barang</span>",
	"text"=>"Management data obat dan non obat, HNA etc ...",
	"img"=>"img/icons/drug.png","imgSize"=>"50","imgToTop"=>"5","imgToLeft"=>"5",
	"labelText"=>"Metro Apotek","labelColor"=>"#453B5E","labelPosition"=>"bottom");

$tile[] = array("type"=>"slide","group"=>1,"x"=>0,"y"=>1,'width'=>2,'height'=>1,"background"=>"#00BFFF","url"=>"pabrik.php",
	"text"=>"<b>Data Pabrik <br/>Manajemen data pabrik</b>","img"=>"img/pabrik.jpg","imgSize"=>1,
	"slidePercent"=>0.40,
	"slideDir"=>"up", // can be up, down, left or right
	"doSlideText"=>true,"doSlideLabel"=>true,
	"labelText"=>"Pabrik","labelColor"=>"#00BFFF","labelPosition"=>"top",
);
$tile[] = array("type"=>"simple","group"=>1,"x"=>0,"y"=>2,'width'=>2,'height'=>1,"background"=>"#da532c","url"=>"pelanggan.php",
	"title"=>"<span style='font-size:24px;'>Pelanggan</span>",
	"text"=>"Manajemen pelanggan umum, ASKES, etc ...",
	"img"=>"img/icons/user.png","imgSize"=>"50","imgToTop"=>"5","imgToLeft"=>"5",
	"labelText"=>"Metro Apotek","labelColor"=>"#453B5E","labelPosition"=>"bottom");

$tile[] = array("type"=>"img","group"=>1,"x"=>2,"y"=>0,'width'=>1,'height'=>1,"background"=>"#009aff","url"=>"supplier.php",
	"img"=>"img/icons/supplier.png","desc"=>"Data Supplier","showDescAlways"=>true,"imgWidth"=>1,"imgHeight"=>1,
	"labelText"=>"","labelColor"=>"#000","labelPosition"=>"","classes"=>"");

$tile[] = array("type"=>"simple","group"=>1,"x"=>2,"y"=>1,'width'=>1,'height'=>1,"background"=>"#bd1e4a","url"=>"bank.php",
"title"=>"Bank","text"=>"Manajemen data bank.
");

$tile[] = array("type"=>"simple","group"=>1,"x"=>2,"y"=>2,'width'=>1,'height'=>1,"background"=>"#180052","url"=>"dokter.php",
"title"=>"<span style='font-size:22px;'>Dokter</span>","text"=>"Manajemen data dokter.
");
$tile[] = array("type"=>"img","group"=>1,"x"=>3,"y"=>0,'width'=>1,'height'=>1,"background"=>"#0072bc","url"=>"asuransi.php",
	"img"=>"img/icons/asuransi.png","desc"=>"Asuransi","showDescAlways"=>true,"imgWidth"=>1,"imgHeight"=>1,
	"labelText"=>"","labelColor"=>"#000","labelPosition"=>"","classes"=>"");
/*
SLIDESHOW TILE - only in full version
$tile[] = array("type"=>"slideshow","group"=>1,"x"=>2,"y"=>0,"width"=>1,"height"=>1,"background"=>"#6950ab","url"=>"newtab:http://google.com",
	"images"=>array("img/chars/a.png","img/chars/b.png","img/chars/c.png","img/chars/d.png","img/chars/e.png","img/chars/f.png","img/chars/g.png"),
	"effect"=>"slide-right, slide-left, slide-down, slide-up, flip-vertical, flip-horizontal, fade",
	"speed"=>1500,"arrows"=>false,
	"labelText"=>"Random fx","labelColor"=>"#453B5E","labelPosition"=>"top");
*/

/*FLIP TILE - only in full version
$tile[] = array("type"=>"flip","group"=>1,"x"=>2,"y"=>1,'width'=>1,'height'=>1,"background"=>"#C82345","url"=>"accordions.php","img"=>"img/metro_150x150.png",
	"text"=>"<h4 style='color:#FFF;'>Click for accordions!</h4>");
*/
	
/* GROUP 3 */
$tile[] = array("type"=>"img","group"=>2,"x"=>0,"y"=>0,'width'=>1,'height'=>1,"background"=>"#0F6D32","url"=>"",
	"img"=>"img/img2.jpg","desc"=>"Mengetahui jumlah awal, masuk, keluar dan sisa stok",
	"showDescAlways"=>true,"imgWidth"=>1,"imgHeight"=>1,
	"labelText"=>"Arus Stok","labelColor"=>"#509601","labelPosition"=>"bottom");
	
$tile[] = array("type"=>"slide","group"=>2,"x"=>1,"y"=>0,'width'=>2,'height'=>1,"background"=>"#FE2E64","url"=>"",
	"text"=>"<h3>Arus Stok</h3>","img"=>"img/metro_slide_300x150_2.png","imgSize"=>1,
	"slidePercent"=>0.50,
	"slideDir"=>"left", // can be up, down, left or right
	"doSlideText"=>false,"doSlideLabel"=>false,
	"labelText"=>"Other direction slide","labelColor"=>"#CC1A46","labelPosition"=>"top"
);

?> 