<?php

function form_input($name, $value = NULL, $attr = NULL) {
    return '<input type=text name="'.$name.'" value="'.$value.'" '.$attr.' />';
}

function form_hidden($name, $value = NULL, $attr = NULL) {
    return '<input type=hidden name="'.$name.'" value="'.$value.'" '.$attr.' />';
}

function form_textarea($name, $value = NULL, $attr = NULL) {
    return '<textarea name="'.$name.'" '.$attr.'>'.$value.'</textarea>';
}

function form_upload($name, $value = NULL, $attr = NULL) {
    return '<input type=file name="'.$name.'"  value="'.$value.'" '.$attr.' />';
}

function form_radio($name, $value, $id, $label = null, $checked = FALSE) {
    $attr = "";
    if ($checked == TRUE) {
        $attr = "checked";
    }
    return '<input type=radio name="'.$name.'" value="'.$value.'" id="'.$id.'" '.$attr.' /><label for="'.$id.'">'.$label.'</label>';
}

function form_checkbox($name, $value, $id, $label = null, $checked = FALSE) {
    $attr = "";
    if ($checked == TRUE) {
        $attr = "checked";
    }
    return '<input type=checkbox name="'.$name.'" value="'.$value.'" id="'.$id.'" '.$attr.' /><label for="'.$id.'">'.$label.'</label>';
}

function paging_ajax($jmldata, $dataPerPage, $klik, $tab = NULL, $search) {
    /*
     * Parameter '$search' dalam bentuk string , bisa json string atau yang lain
     * contoh 1#nama_barang#nama_pabrik
     */

    $showPage = NULL;
    ob_start();
    echo "
        <div class='body-page'>";
    if (!empty($klik)) {
        $noPage = $klik;
    } else {
        $noPage = 1;
    }

    $dataPerPage = $dataPerPage;


    $jumData = $jmldata;
    $jumPage = ceil($jumData / $dataPerPage);
    $get = $_GET;
    
    if ($jumData > $dataPerPage) {
        $onclick = null;
        if ($noPage > 1) {
            $get['page'] = ($noPage - 1);
            $onclick = $klik;
        }
        $prev = null;
        $last = ' class="last-block" ';
        if ($klik > 1) {
            $prev = "onClick=\"paging(" . ($klik - 1) . "," . $tab . ", '" . $search . "')\" ";
        }
        echo "<div class='page-prev' $prev>prev</div>";
        for ($page = 1; $page <= $jumPage; $page++) {
            if ((($page >= $noPage - 3) && ($page <= $noPage + 3)) || ($page == 1) || ($page == $jumPage)) {
                if (($showPage == 1) && ($page != 2))
                    echo "<div class='titik'>...</div>";
                if (($showPage != ($jumPage - 1)) && ($page == $jumPage))
                    echo "<div class='titik'>...</div>";
                if ($page == $noPage)
                    echo " <div class='noblock'>" . $page . "</div> ";
                else {
                    $get['page'] = $page;
                    if ($tab != NULL) {
                        $get['tab'] = $tab;
                    }
                    $next = "onClick=\"paging(" . $page . "," . $tab . ", '" . $search . "')\" ";
                    //echo " <a class='block' href='?" . generate_get_parameter($get) . "'>" . $page . "</a> ";
                    if ($page == $jumPage) {
                        echo '<div  class="block" ' . $next . '>' . $page . '</div>';
                    } else {
                        echo '<div class="block" ' . $next . '>' . $page . '</div>';
                    }
                }
                $showPage = $page;
            }
        }
        $next = null;
        if ($klik < $jumPage) {
            $next = "onClick=\"paging(" . ($klik + 1) . "," . $tab . ", '" . $search . "')\" ";
        }
        echo "<div class='page-next' $next >next</div>";
    }
    echo "</div>";

    $buffer = ob_get_contents();
    ob_end_clean();
    return $buffer;
}

function generate_get_parameter($get, $addArr = array(), $removeArr = array()) {
    if ($addArr == null)
        $addArr = array();
    foreach ($removeArr as $rm) {
        unset($get[$rm]);
    }
    $link = "";
    $get = array_merge($get, $addArr);
    foreach ($get as $key => $val) {
        if ($link == null) {
            $link.="$key=$val";
        }else
            $link.="&$key=$val";
    }
    return $link;
}

function date2mysql($tgl) {
    $tgl = explode("/", $tgl);
    if (empty($tgl[2]))
        return "";
    $news = "$tgl[2]-$tgl[1]-$tgl[0]";
    return $news;
}

function datefmysql($tgl) {
    if ($tgl == '' || $tgl == null) {
        return "";
    } else {
        $tgl = explode("-", $tgl);
        $new = $tgl[2] . "/" . $tgl[1] . "/" . $tgl[0];
        return $new;
    }
}

function rupiah($jml) {
    $int = number_format($jml, 0, '', '.');
    return $int;
}

function currencyToNumber($a) {
    return str_ireplace(".", "", $a);
}

function get_last_pemesanan() {
    $sql = mysql_query("select id from pemesanan order by id desc limit 1");
    $row = mysql_fetch_object($sql);
    if (!isset($row->id)) {
        return "000001";
    } else {
        return str_pad((string)($row->id+1), 6, "0", STR_PAD_LEFT);
    }
}
?>