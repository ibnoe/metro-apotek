<?php
/* All tiles on the homepage are configured here, be sure to check the tutorials/docs on http://metro-webdesign.info */

/* GROUP 1 */

$tile[] = array("type"=>"img","group"=>0,"x"=>0,"y"=>0,'width'=>1,'height'=>1,"background"=>"#6950AB","url"=>"penjualan-nr.php",
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

$tile[] = array("type"=>"img","group"=>0,"x"=>1,"y"=>2,'width'=>1,'height'=>1,"background"=>"#614040","url"=>"penerimaan.php",
	"img"=>"img/icons/penerimaan.png","desc"=>"Penerimaan Produk","showDescAlways"=>true,"imgWidth"=>1,"imgHeight"=>1,
	"labelText"=>"","labelColor"=>"#000","labelPosition"=>"","classes"=>"");

$tile[] = array("type"=>"img","group"=>0,"x"=>0,"y"=>2,'width'=>1,'height'=>1,"background"=>"#6b6b6b","url"=>"stok-opname.php",
	"img"=>"img/icons/resep.png","desc"=>"Stok Opname","showDescAlways"=>true,"imgWidth"=>1,"imgHeight"=>1,
	"labelText"=>"","labelColor"=>"#000","labelPosition"=>"","classes"=>"");


$tile[] = array("type"=>"img","group"=>0,"x"=>0,"y"=>1,'width'=>1,'height'=>1,"background"=>"#009aff","url"=>"",
	"img"=>"img/icons/retur-penjualan.png","desc"=>"Retur Penjualan","showDescAlways"=>true,"imgWidth"=>1,"imgHeight"=>1,
	"labelText"=>"","labelColor"=>"#000","labelPosition"=>"","classes"=>"");

$tile[] = array("type"=>"img","group"=>0,"x"=>1,"y"=>1,'width'=>1,'height'=>1,"background"=>"#ea882b","url"=>"retur-penerimaan.php",
	"img"=>"img/icons/retur-penerimaan.png","desc"=>"Retur Penerimaan","showDescAlways"=>true,"imgWidth"=>1,"imgHeight"=>1,
	"labelText"=>"","labelColor"=>"#000","labelPosition"=>"","classes"=>"");


/* GROUP 2*/
/*<br />
SLIDEFX TILE -  only in full version 
$tile[] = array("type"=>"slidefx","group"=>1,"x"=>0,"y"=>0,'width'=>2,'height'=>1,"background"=>"#333","url"=>"external:img/metro_slide.png",
	"text"=>"Click to see in full","img"=>"img/metro_slide_300x150.png","classes"=>"lightbox"
);
*/

$tile[] = array("type"=>"img","group"=>1,"x"=>0,"y"=>0,'width'=>1,'height'=>1,"background"=>"#6950AB","url"=>"barang.php",
	"img"=>"img/icons/drug.png","desc"=>"Produk","showDescAlways"=>true,"imgWidth"=>1,"imgHeight"=>1,
	"labelText"=>"","labelColor"=>"#000","labelPosition"=>"","classes"=>"");

//$tile[] = array("type"=>"img","group"=>1,"x"=>3,"y"=>1,'width'=>1,'height'=>1,"background"=>"#6950AB","url"=>"instansi.php",
//	"img"=>"img/icons/instansi.png","desc"=>"Instansi","showDescAlways"=>true,"imgWidth"=>1,"imgHeight"=>1,
//	"labelText"=>"","labelColor"=>"#000","labelPosition"=>"","classes"=>"");

//$tile[] = array("type"=>"slide","group"=>1,"x"=>0,"y"=>1,'width'=>2,'height'=>1,"background"=>"#00BFFF","url"=>"pabrik.php",
//	"text"=>"<b>Data Pabrik <br/>Manajemen data pabrik</b>","img"=>"img/pabrik.jpg","imgSize"=>1,
//	"slidePercent"=>0.40,
//	"slideDir"=>"up", // can be up, down, left or right
//	"doSlideText"=>true,"doSlideLabel"=>true,
//	"labelText"=>"Pabrik","labelColor"=>"#00BFFF","labelPosition"=>"top",
//);

$tile[] = array("type"=>"img","group"=>1,"x"=>0,"y"=>2,'width'=>1,'height'=>1,"background"=>"#6950AB","url"=>"pelanggan.php",
	"img"=>"img/icons/user.png","desc"=>"Pelanggan","showDescAlways"=>true,"imgWidth"=>1,"imgHeight"=>1,
	"labelText"=>"","labelColor"=>"#000","labelPosition"=>"","classes"=>"");

$tile[] = array("type"=>"img","group"=>1,"x"=>1,"y"=>2,'width'=>1,'height'=>1,"background"=>"#6950AB","url"=>"golongan.php",
	"img"=>"img/icons/golongan.png","desc"=>"Golongan","showDescAlways"=>true,"imgWidth"=>1,"imgHeight"=>1,
	"labelText"=>"","labelColor"=>"#000","labelPosition"=>"","classes"=>"");


//$tile[] = array("type"=>"img","group"=>1,"x"=>2,"y"=>0,'width'=>1,'height'=>1,"background"=>"#00709f","url"=>"supplier.php",
//	"img"=>"img/icons/supplier.png","desc"=>"Supplier","showDescAlways"=>true,"imgWidth"=>1,"imgHeight"=>1,
//	"labelText"=>"","labelColor"=>"#000","labelPosition"=>"","classes"=>"");

//$tile[] = array("type"=>"simple","group"=>1,"x"=>2,"y"=>1,'width'=>1,'height'=>1,"background"=>"#bd1e4a","url"=>"bank.php",
//"title"=>"Bank","text"=>"Manajemen data bank.
//");

$tile[] = array("type"=>"img","group"=>1,"x"=>1,"y"=>1,'width'=>1,'height'=>1,"background"=>"#00709f","url"=>"farmakoterapi.php",
	"img"=>"img/icons/farmakoterapi.png","desc"=>"Farmakoterapi","showDescAlways"=>true,"imgWidth"=>1,"imgHeight"=>1,
	"labelText"=>"","labelColor"=>"#000","labelPosition"=>"","classes"=>"");

$tile[] = array("type"=>"img","group"=>1,"x"=>2,"y"=>1,'width'=>1,'height'=>1,"background"=>"#00709f","url"=>"penyakit.php",
	"img"=>"img/icons/kelas-terapi.png","desc"=>"Penyakit ICD X","showDescAlways"=>true,"imgWidth"=>1,"imgHeight"=>1,
	"labelText"=>"","labelColor"=>"#000","labelPosition"=>"","classes"=>"");

$tile[] = array("type"=>"img","group"=>1,"x"=>2,"y"=>0,'width'=>1,'height'=>1,"background"=>"#0072bc","url"=>"pabrik.php",
	"img"=>"img/icons/asuransi.png","desc"=>"Instansi-instansi","showDescAlways"=>true,"imgWidth"=>1,"imgHeight"=>1,
	"labelText"=>"","labelColor"=>"#000","labelPosition"=>"","classes"=>"");

$tile[] = array("type"=>"img","group"=>1,"x"=>1,"y"=>0,'width'=>1,'height'=>1,"background"=>"#009aff","url"=>"karyawan.php",
	"img"=>"img/icons/karyawan.png","desc"=>"Karyawan","showDescAlways"=>true,"imgWidth"=>1,"imgHeight"=>1,
	"labelText"=>"","labelColor"=>"#000","labelPosition"=>"","classes"=>"");

$tile[] = array("type"=>"img","group"=>1,"x"=>0,"y"=>1,'width'=>1,'height'=>1,"background"=>"#180052","url"=>"layanan.php",
	"img"=>"img/icons/layanan.png","desc"=>"Layanan","showDescAlways"=>true,"imgWidth"=>1,"imgHeight"=>1,
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
$tile[] = array("type"=>"img","group"=>2,"x"=>0,"y"=>0,'width'=>1,'height'=>1,"background"=>"#5f5f5f","url"=>"",
	"img"=>"img/icons/chart.png","desc"=>"Arus Stok",
	"showDescAlways"=>true,"showDescAlways"=>true,"imgWidth"=>1,"imgHeight"=>1,
	"labelText"=>"","labelColor"=>"#000","labelPosition"=>"","classes"=>"");
	
$tile[] = array("type"=>"img","group"=>2,"x"=>1,"y"=>0,'width'=>1,'height'=>1,"background"=>"#4577a4","url"=>"lap-sp.php",
	"img"=>"img/icons/lap-sp.png","desc"=>"Pemesanan","showDescAlways"=>true,"imgWidth"=>1,"imgHeight"=>1,
	"labelText"=>"","labelColor"=>"#000","labelPosition"=>"","classes"=>"");

$tile[] = array("type"=>"img","group"=>2,"x"=>2,"y"=>0,'width'=>1,'height'=>1,"background"=>"#175e88","url"=>"layanan.php",
	"img"=>"img/icons/layanan.png","desc"=>"Penerimaan","showDescAlways"=>true,"imgWidth"=>1,"imgHeight"=>1,
	"labelText"=>"","labelColor"=>"#000","labelPosition"=>"","classes"=>"");

?> 