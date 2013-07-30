<?php
session_start();
/* METRO UI TEMPLATE v4.a4
/*
/* Copyright 2013 Thomas Verelst, http://metro-webdesign.info
/* Do not redistribute or sell this template, nor claim this is your own work. 
/* Donation required when using this. */

require_once('inc/defaults.php');
require_once('config/general.php');
require_once('config/layout.php');
require_once('config/pages.php');
//require_once('config/mobile.php');

require_once('inc/detectdevice.php');

/* TILE INITS */
require_once('inc/init.php');
require_once('inc/tilefunctions.php');

/* FILES*/
$cssFiles = array( /* Add your css files to this array */
	'css/layout.css',
	'css/nav.css',
	'css/tiles.css',
	'themes/'.$theme.'/theme.css',
        'plugins/metro-jquery/jquery-ui.css',
        'plugins/metro-jquery/styles.css',
        'plugins/metro-jquery/jquery.autocomplete.css'
);
$jsFiles = array( /* Add your js files to this array */
        'plugins/metro-jquery/jquery-ui-1.9.2.custom.js',
	'js/functions.js',
	'js/main.js',
        'plugins/metro-jquery/jquery.autocomplete.js',
        'plugins/metro-jquery/combo.autocomplete.js',
        'plugins/metro-jquery/functions.js'
);

/* PLUGIN SYSTEM */
require_once("inc/plugins.php");
foreach(glob("plugins/" . "*") as $folder){
	if(is_dir($folder) && !in_array($folder, $disabledPluginsDesktop)){
		if(file_exists($folder."/plugin.js")){
			$jsPluginsArray[] = $folder."/plugin.js";		
		}
		if(file_exists($folder."/plugin.css")){
			$cssPluginsArray[] = $folder."/plugin.css";		
		}
		if(file_exists($folder."/desktop.js")){
			$jsPluginsArray[] = $folder."/desktop.js";		
		}
		if(file_exists($folder."/desktop.css")){
			$cssPluginsArray[] = $folder."/desktop.css";		
		}
		if(file_exists($folder."/plugin.php")){
			include($folder."/plugin.php");
		}
	}
}

triggerEvent("beforeDoctype");
?>
<!DOCTYPE html>
<?php
triggerEvent("afterDoctype");


if(file_exists('themes/'.$theme.'/theme.js')){
	$jsFiles[] = 'themes/'.$theme.'/theme.js';
}
if(file_exists('themes/'.$theme.'/theme.php')){
	require_once('themes/'.$theme.'/theme.php');
}

triggerEvent("fileInclude");

require_once("inc/compress.php");
require_once("inc/seo.php");
?>
<?php // if(strpos($_SERVER['HTTP_USER_AGENT'],"Version/4.0")!=false&&strpos($_SERVER['HTTP_USER_AGENT'],"Android")!=false&&strpos($_SERVER['HTTP_USER_AGENT'],"AppleWebKit/")!=false){}?>
<html>
<head>
	<?php triggerEvent("headStart");?>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="Description" content="<?php echo $siteMetaDesc;?>"/>
    <meta name="keywords" content="<?php echo $siteMetaKeywords;?>"/>
    <meta name="viewport" content="width=1024,initial-scale=1.00, minimum-scale=1.00">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    
    <title><?php echo $siteTitle;?></title> 
    
    <?php 
	if($bot && $nojsuser){
		echo '<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">';
	}
	
    /*FONT*/
    if($googleFontURL != ""){?>
    	<link href='<?php echo $googleFontURL?>' rel='stylesheet' type='text/css'>
		<?php
	}

	/*CSS*/
	echo $css;
	include_once("inc/css.php");
	
	/*GA*/
	if($googleAnalyticsCode != ""){
		?><script type='text/javascript'>var _gaq = _gaq || [];_gaq.push(['_setAccount', '<?php echo $googleAnalyticsCode?>']);_gaq.push(['_trackPageview']);(function(){var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);})();</script><?php
	}
	?> 
    <!--[if lt IE 9]>
    <script type="text/javascript" language="javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="js/html5.js">
	<![endif]-->
	<!--[if gte IE 9]>
    <script src="http://code.jquery.com/jquery-2.0.0b2.js"></script>
    <script src="js/html5.js">
	<![endif]-->
    <!--[if !IE]>
    <script src="http://code.jquery.com/jquery-2.0.0b2.js"></script>
	<![endif]-->

    <script type="text/javascript">window.jQuery || document.write('<script type="text/javascript" src="js/jquery191.js"><\/script>')</script> 
    <script type="text/javascript" language="javascript" src="js/plugins.js"></script>
    
	<?php
	/*JS */
	include("inc/phptojs.php");
	if(!$bot){
		echo $js;
	}

    triggerEvent("headEnd");
	?>
    <noscript><style>#tileContainer{display:block}</style></noscript>
</head>
<body class="full <?php echo $device?>">
<?php
triggerEvent("bodyBegin");

/*BG image*/
if($bgImage!=""){
	echo "<img src='".$bgImage."' id='bgImage'/>";
}
?>
<header>
	<div id="headerWrapper">
		<div id="headerCenter">
			<div id="headerTitles">
				<h1><a href="<?php if($bot){echo "index.php";}?>#!"><?php echo $siteName?></a></h1>
		   		<h2><?php echo $siteDesc;?></h2>
		    </div>
		    <nav>
            	<?php
				triggerEvent("mainNavBegin");
		  		include_once("config/main-nav.php");
				triggerEvent("mainNavEnd");
				?>
			</nav>
		</div>
    </div>
    <?php triggerEvent("headerEnd");?>
</header>
<div id="wrapper">
	<div id="centerWrapper">
  		<?php
		if(!$bot || ($bot && $reqUrl == "")){
		?>
    	<div id="tileContainer" 
			<?php if($bot && $reqUrl==""){
				 echo "style='display:block;'";
			}?>>
            <?php if($groupDirection == "horizontal"){?>
        		<img id='arrowLeft' class="navArrows" src='themes/<?php echo $theme?>/img/primary/arrowLeft.png' onClick="javascript:$group.goLeft();" alt="left arrow"/>
            	<img id='arrowRight' class="navArrows" src='themes/<?php echo $theme?>/img/primary/arrowRight.png' onClick="javascript:$group.goRight();" alt="right arrow"/>
       		<?php 
			}
			include("inc/tilegen.php");
			triggerEvent("tileContainerEnd");
			?>
        </div> 
        <?php
		}
		?>
        <div id="subNavWrapper"></div>
    	<div id="contentWrapper" <?php if($bot && $reqUrl != ""){ echo "style='display:block;'";}?>>   		    
	   		<?php triggerEvent("contentWrapperBegin");?>
            <div id="content">	        	
				<?php
				if($bot){	
					if($page == "" || $page == "home"){					
					}else{
						if(file_exists("pages/".$reqUrl)){	
							include("pages/".$reqUrl);
						}else{		
							echo "<h2 style='margin-top:0px;'>We're sorry :(</h2>the page you're looking for is not found.";
						}
					}		
				}
				?>
	        </div>
    	    <?php triggerEvent("contentWrapperEnd");?>
		</div>
        <?php triggerEvent("centerWrapperEnd");?>
    </div>
	<footer>
		<?php 
		echo $siteFooter; 
		triggerEvent("siteFooter");
		?>
        | <a href="http://mycss1.com" target="_blank">Metro Apotek</a>
    </footer>
    <?php triggerEvent("wrapperEnd");?>
</div> 
<div id="catchScroll"></div>
<?php
/*if(isset($_SESSION['username']) && $_SESSION['username'] == $username){?>
	<div id="adminPanel">
	<ul id="adminHovered">
	<li><a href="" target="_blank" id="adminEditButton">Edit this page</a></li>
	<li><a href="admin/logout.php" id="logoutButton">Logout</a></li>
	</ul>
	<a href="admin/" id="adminText">Welcome admin</a>
	</div>
	<?php
}*/
/*if($device=='mobileOnDesktop'){
	?>
	<a id="mobileOnDesktop" href="mobile.php">Go to mobile site</a>
    <?php
}*/
?>
<?php triggerEvent("bodyEnd");?>
</body>
</html>