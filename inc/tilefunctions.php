<?php
$scaleSpacing = $scale+$spacing;

/* TILES */
$tileTypes['custom'] = array( /* Defaults*/
	"group"=>0,
	"x"=>0,
	"y"=>0,
	'width'=>2,
	'height'=>1,
	"background"=>$defaultBackgroundColor,
	"url"=>"",
	"content"=>"some content, can contain HTML",
	"labelText"=>"",
	"labelColor"=>$defaultLabelColor,
	"labelPosition"=>$defaultLabelPosition,
	"classes"=>"",
);
function tile_custom($group,$x,$y,$width,$height,$background,$url,$content,$labelText,$labelColor,$labelPosition,$classes){
	global $scale, $spacing, $scaleSpacing, $groupSpacing;
  
  	$marginTop = $y*$scaleSpacing+getMarginTop($group);
	$marginLeft = $x*$scaleSpacing+getMarginLeft($group);
	$tileWidth = $width*$scaleSpacing-$spacing;
	$tileHeight = $height*$scaleSpacing-$spacing;
	
	?>
  	<a <?php echo makeLink($url);?> class="tile group<?php echo $group?> <?php echo $classes?>" style="
    margin-top:<?php echo $marginTop;?>px; margin-left:<?php echo $marginLeft;?>px;
	width:<?php echo $tileWidth?>px; height:<?php echo $tileHeight?>px;
	background:<?php echo $background;?>;" <?php posVal($marginTop,$marginLeft,$tileWidth);?>> 
    <?php echo $content;?>
    <?php
	if($labelText!=""){
		if($labelPosition=='top'){
			echo "<div class='tileLabelWrapper top' style='border-top-color:".$labelColor.";'><div class='tileLabel top' >".$labelText."</div></div>";
		}else{
			echo "<div class='tileLabelWrapper bottom'><div class='tileLabel bottom' style='border-bottom-color:".$labelColor.";'>".$labelText."</div></div>";
		}
	}
	?>
    </a>
    <?php
}
$tileTypes['simple'] = array( /* Defaults*/
	"group"=>0,
	"x"=>0,
	"y"=>0,
	'width'=>2,
	'height'=>1,
	"background"=>$defaultBackgroundColor,
	"url"=>"",
	"title"=>"The title",
	"text"=>"the description text",
	"img"=>"",
	"imgSize"=>"50",
	"imgToTop"=>"5",
	"imgToLeft"=>"5",
	"labelText"=>"",
	"labelColor"=>$defaultLabelColor,
	"labelPosition"=>$defaultLabelPosition,
	"classes"=>"",
);
function tile_simple($group,$x,$y,$width,$height,$background,$url,$title,$text,$img,$imgSize,$imgToTop,$imgToLeft,$labelText,$labelColor,$labelPosition,$classes){
	global $scale, $spacing, $scaleSpacing, $groupSpacing;
    
	$marginTop = $y*$scaleSpacing+getMarginTop($group);
	$marginLeft = $x*$scaleSpacing+getMarginLeft($group);
	$tileWidth = $width*$scaleSpacing-$spacing;
	$tileHeight = $height*$scaleSpacing-$spacing;
	if($img == ""){
		$hasImg = 0;
	}else{
		$hasImg = 1;
	}
	?>
  	<a <?php echo makeLink($url);?> class="tile group<?php echo $group?> <?php echo $classes?>" style="
    margin-top:<?php echo $marginTop;?>px; margin-left:<?php echo $marginLeft;?>px;
	width:<?php echo $tileWidth?>px; height:<?php echo $tileHeight?>px;
	background:<?php echo $background;?>;" <?php posVal($marginTop,$marginLeft,$tileWidth);?>> 
    <?php if($img != ""){?>
    <img style='float:left; margin-top:<?php echo $imgToTop?>px;margin-left:<?php echo $imgToLeft?>px;' 
    src='<?php echo $img?>' height="<?php echo $imgSize?>" width="<?php echo $imgSize?>"/>
    <?php } ?>
	<div class='tileTitle' style='margin-left:<?php echo ($imgSize+$imgToLeft)*$hasImg+10;?>px;'><?php echo $title?></div>
	<div class='tileDesc' style='margin-left:<?php echo ($imgSize+$imgToLeft)*$hasImg+12;?>px;'><?php echo $text?></div>
    <?php
    if($labelText!=""){
		if($labelPosition=='top'){
			echo "<div class='tileLabelWrapper top' style='border-top-color:".$labelColor.";'><div class='tileLabel top' >".$labelText."</div></div>";
		}else{
			echo "<div class='tileLabelWrapper bottom'><div class='tileLabel bottom' style='border-bottom-color:".$labelColor.";'>".$labelText."</div></div>";
		}
	}?> 
    </a>
    <?php
}
 /* Defaults*/
$tileTypes['scrollText'] = array(
"group"=>0,
"x"=>0,
"y"=>0,
'width'=>2,
'height'=>1,
"background"=>$defaultBackgroundColor,
"url"=>"",
"title"=>"Title",
"text"=>array(""),
"scrollSpeed"=>5000,
"img"=>"",
"imgSize"=>"50",
"imgToTop"=>"5",
"imgToLeft"=>"5",
"labelText"=>"",
"labelColor"=>$defaultLabelColor,
"labelPosition"=>$defaultLabelPosition,
"classes"=>""
);

function tile_scrollText($group,$x,$y,$width,$height,$background,$url,$title,$text,$scrollSpeed,$img,$imgSize,$imgToTop,$imgToLeft,$labelText,$labelColor,$labelPosition,$classes){
	global $scale, $spacing, $scaleSpacing, $groupSpacing;
	
	$marginTop = $y*$scaleSpacing+getMarginTop($group);
	$marginLeft = $x*$scaleSpacing+getMarginLeft($group);
	$tileWidth = $width*$scaleSpacing-$spacing;
	$tileHeight = $height*$scaleSpacing-$spacing;
	
	if($img == ""){
		$hasImg = 0;
	}else{
		$hasImg = 1;
	}
	$id =  str_replace(".","_",$group."_".$x."-".$y);
	?>
  	<a <?php echo makeLink($url);?> id="tileScroll<?php echo $id?>" class="tile tileScroll group<?php echo $group?> <?php echo $classes?>" style="
    margin-top:<?php echo $marginTop;?>px; margin-left:<?php echo $marginLeft?>px;
	width:<?php echo $tileWidth?>px; height:<?php echo $tileHeight;?>px;
	background:<?php echo $background;?>;" <?php posVal($marginTop,$marginLeft,$tileWidth);?>> 
    <?php if($img!=""){?>
    <img style='float:left; margin-top:<?php echo $imgToTop?>px;margin-left:<?php echo $imgToLeft?>px;' 
    src='<?php echo $img?>' height="<?php echo $imgSize?>" width="<?php echo $imgSize?>"/><?php } ?>
	<div class='tileTitle' style='margin-left:<?php echo ($imgSize+$imgToLeft)*$hasImg+10?>px;'><?php echo $title?></div>
	<div class='divScroll' style='margin-left:<?php echo ($imgSize+$imgToLeft)*$hasImg+12?>px;'><?php echo $text[0]?></div>
    <script>scrollTile("<?php echo $id?>",<?php echo json_encode($text)?>,<?php echo $scrollSpeed?>,0)</script>
    <?php /* Echo label */
	if($labelText!=""){
		if($labelPosition=='top'){
			echo "<div class='tileLabelWrapper top' style='border-top-color:".$labelColor.";'><div class='tileLabel top' >".$labelText."</div></div>";
		}else{
			echo "<div class='tileLabelWrapper bottom'><div class='tileLabel bottom' style='border-bottom-color:".$labelColor.";'>".$labelText."</div></div>";
		}
	}
	?>
    </a>
    <?php
}

$tileTypes['img'] = array( /* Defaults*/
	"group"=>0,
	"x"=>0,
	"y"=>0,
	'width'=>1,
	'height'=>1,
	"background"=>$defaultBackgroundColor,
	"url"=>"",
	"img"=>"",
	"desc"=>"The description text",
	"showDescAlways"=>true,
	"imgWidth"=>1,
	"imgHeight"=>1,
	"labelText"=>"",
	"labelColor"=>$defaultLabelColor,
	"labelPosition"=>$defaultLabelPosition,
	"classes"=>"",
);
function tile_img($group,$x,$y,$width,$height,$background,$url,$img,$desc,$showDescAlways,$imgWidth,$imgHeight,$labelText,$labelColor,$labelPosition,$classes){
	global $scale, $spacing, $scaleSpacing, $groupSpacing;
	$tileWidth = $width*$scaleSpacing-$spacing;
	$tileHeight = $height*$scaleSpacing-$spacing;
	$marginTop = $y*$scaleSpacing+getMarginTop($group);
	$marginLeft = $x*$scaleSpacing+getMarginLeft($group);
	$imgWidthPx = $imgWidth*$scaleSpacing-$spacing;
	$imgHeightPx = $imgHeight*$scaleSpacing-$spacing;
	?>
  	<a <?php echo makeLink($url);?> class="tile tileImg group<?php echo $group?> <?php if(!$showDescAlways && $desc!=""){echo $labelPosition;}?> <?php echo $classes?>" style="
    margin-top:<?php echo $marginTop;?>px; margin-left:<?php echo $marginLeft?>px;
	width:<?php echo $tileWidth?>px; height:<?php echo $tileHeight?>px;
	background:<?php echo $background;?>;"  <?php posVal($marginTop, $marginLeft,$tileWidth);?>> 
    <img src='<?php echo $img?>' width="<?php echo $imgWidthPx;?>" style='margin-left:-<?php echo $imgWidthPx*0.5;?>px; margin-top: -<?php echo $imgHeightPx*0.5?>px; max-height:<?php echo $imgHeightPx?>px;'/>
    <?php /* echo label */
		if($labelPosition=='top'){
			echo "<div class='tileLabelWrapper top' style='border-top-color:".$labelColor.";'>";
			if($labelText!=""){
				echo "<div class='tileLabel top' >".$labelText."</div>";
			}
		}else{
			echo "<div class='tileLabelWrapper bottom'>";
			if($labelText!=""){
				echo "<div class='tileLabel bottom' style='border-bottom-color:".$labelColor.";'>".$labelText."</div>";
			}
		}
	if($desc!=""){
		echo "<div class='imgDesc' ";
		if(!$showDescAlways){
			echo "style='display:none;'";
		}
		echo ">".$desc."</div>";
	}
	?>
    </div>
    </a>
    <?php
}
?>