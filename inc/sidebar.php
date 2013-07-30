<?php
/*Include necessary files*/
include_once("inc/plugins.php");
include_once("inc/defaults.php");
include("config/general.php");
include("config/layout.php");
include("config/pages.php");
include_once("inc/init.php");
include_once("inc/tilefunctions.php");

$sidebar = array();
/*Init tile functions if not inited yet */

if(!function_exists("getMarginLeft")){
	function getMarginLeft($group){
		return 0;
	}
}
if(!function_exists("getMarginTop")){
	function getMarginTop($group){
		return 0;
	}
}
if(!function_exists("posVal")){
	function posVal($marginTop,$marginLeft,$width){
		echo " ";
	}
}
function showSidebar($name){
	global $sidebar,$scale, $spacing, $scaleSpacing, $groupSpacing,$tileTypes, $defaultBackgroundColor, $defaultLabelColor, $defaultLabelPosition;
	include_once("config/sidebar.php");
	if(!array_key_exists($name,$sidebar)){ // if sidebar not found
		echo "Sidebar could not be loaded because sidebar name doesn't exist";
	}else{
		$t = $scaleSpacing*$sidebar[$name]['size']+5; // width of sidebar
		?>
        <div class='sidebar sidebar-<?php echo $sidebar[$name]['pos']?>' <?php if($sidebar[$name]['pos']!="top"){?>style='width:<?php echo $t?>px'<?php } ?>>
        <?php
		triggerEvent("sidebarBegin");
		/* Plugins */
		foreach($sidebar[$name]["load_plugins"] as $plugin){
			if(file_exists("../plugins/".$plugin."/plugin.php")){
				include_once("plugins/".$plugin."/plugin.php");
			}
		}
		/* Load tiles */
		foreach($sidebar[$name]["tiles"] as $args){
			$n_args = array();
			foreach($tileTypes[$args['type']] as $key=>$std){
				if(array_key_exists($key,$args)){
					$n_args[] = $args[$key];
				}else{
					$n_args[] = $std;
				}
			}
			call_user_func_array("tile_".$args['type'],$n_args);
		}
		triggerEvent("sidebarEnd");
		?>
        </div>
        <style>
		<?php
		switch($sidebar[$name]["pos"]){
			case "left":
			echo "#content{margin-left:".$t."px;}.sidebar-left{margin-left:-".$t."px;}";
			break;
			case "right":
			echo "#content{margin-right:".$t."px;}.sidebar-right{left:".$t."px;}";
			break;
		}
		?>
		</style>
        <script>
		<?php
		if(!$sidebar[$name]["full_height"]){
			?>
			$("#content").css("margin-left",0);
			$(".sidebar").css("margin-left",0);
			<?php	
		}
		?>
		/* Fix height of sidebar for layout */
		sbDown = 0;
	    $("#content, #panelContent").children('.sidebar').children(".tile").each(function(){
			if(typeof $(this).attr("href") != "undefined"){
				$(this).attr("href",$(this).attr("href").replace("?p=","#!/"));
			}	
			var thisDown= parseInt($(this).css("margin-top"))+$(this).height();
			if(thisDown>sbDown){
				sbDown=thisDown;
			}	
		});
		$('#contentWrapper, .sidebar').css("min-height",sbDown+20+"px");
		
		
		/* Responsive sidebar position */
		<?php if($sidebar[$name]["pos"] != "top"){?>
		$.plugin($toColumn,{
			sidebarAfter:function(){
				$("#content").children(".sidebar").appendTo("#centerWrapper").css("top",20);
			}
		});
		$.plugin($toSmall,{
			sidebarBefore:function(){
				$("#centerWrapper").children(".sidebar").prependTo("#content").css("top",0);
			}
		}); 
		$.plugin($toFull,{
			sidebarBefore:function(){
				$toSmall.sidebarBefore();
			}
		});
		$.plugin($beforeSubPageShow,{
			checkSidebar:function(){
				switch($page.layout){
					case "column": $toColumn.sidebarAfter();break;
					case "small": $toSmall.sidebarBefore();break;
					case "full": $toSmall.sidebarBefore();break;
				}
			}
		});
		<?php }?>
		</script>
        <?php
	}
}
?>