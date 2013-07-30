<?php
/* AUTO FLUSH CACHE SYSTEM */
$autoFlush = false;
$autoFlushPlugins = false;
$compressJS = false;
$compressCSS = false;

/* LITE VERSION - no compressing system included */
$cssFiles = array_merge($cssFiles,$cssPluginsArray);
$jsFiles = array_merge($jsPluginsArray,$jsFiles);

/*CSS COMPRESS*/
$css = "";
foreach($cssFiles as $cssFile){
	$css .= '<link rel="stylesheet" type="text/css" href="'.$cssFile.'" />';
}

/*JAVASCRIPT COMPRESS*/
$js = '';
foreach($jsFiles as $jsFile){
	$js .= '<script type="text/javascript" src="'.$jsFile.'"></script>';
}
?>