<?php
$subNav = array(
	"Basic Data ; barang.php ; #509601;",
        "Pelengkap ; pelengkap.php ; #509601;",
        "Item Kit ; item-kit.php ; #509601;"
);

set_include_path("../");
include_once("inc/essentials.php");
include_once("inc/functions.php");
include_once("models/masterdata.php");
include_once("pages/message.php");
?>
<script>
    load_data_itemkit();
$('#button').button({
    icons: {
        primary: 'ui-icon-newwin'
    }
}).click(function() {
    form_add();
});
$('#reset').button({
    icons: {
        primary: 'ui-icon-refresh'
    }
}).click(function() {
    load_data_barang();
});
function form_add() {
    
}
function load_data_itemkit(page, search, id) {
    pg = page; src = search; id_barg = id;
    if (page === undefined) { var pg = ''; }
    if (search === undefined) { var src = ''; }
    if (id === undefined) { var id_barg = ''; }
    $.ajax({
        url: 'pages/item-kit-list.php',
        cache: false,
        data: 'page='+pg+'&search='+src+'&id_itemkit='+id_barg,
        success: function(data) {
            $('#result-itemkit').html(data);
        }
    });
}

function paging(page, tab, search) {
    load_data_itemkit(page, search);
}
</script>
<h1 class="margin-t-0">Item Kit (Packaging)</h1>
<hr>
<button id="button">Tambah Data</button>
<button id="reset">Reset</button>
<div id="result-itemkit">
    
</div>