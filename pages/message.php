<script type="text/javascript">
function alert_tambah() {
    $( "#tambah" ).dialog({
        modal: true,
        buttons: {
          Ok: function() {
            $( this ).dialog( "close" );
          }
        }
    });
}

function alert_edit() {
    $( "#edit" ).dialog({
        modal: true,
        buttons: {
          Ok: function() {
            $( this ).dialog( "close" );
          }
        }
    });
}

function alert_delete() {
    $( "#delete" ).dialog({
        modal: true,
        buttons: {
          Ok: function() {
            $( this ).dialog( "close" );
          }
        }
    });
}

function alert_resets() {
    $( "#resets" ).dialog({
        modal: true,
        buttons: {
          Ok: function() {
            $( this ).dialog( "close" );
          }
        }
    });
}

function alert_empty(variable, focus) {
    $( "<div title='Alert: Warning'>Data "+variable+" tidak boleh kosong !</div>" ).dialog({
        autoOpen: true,
        modal: true,
        buttons: {
          Ok: function() {
            $( this ).dialog( "close" );
            $(focus).focus();
          }
        }
    });
}
</script>
<div id="tambah" style="display: none" title="Information Alert">
    <p>
      <span class="ui-icon ui-icon-circle-check" style="float: left; margin: 0 7px 50px 0;"></span>
      Data Telah Berhasil di Tambahkan
    </p>
</div>
<div id="edit" style="display: none" title="Information Alert">
    <p>
      <span class="ui-icon ui-icon-circle-check" style="float: left; margin: 0 7px 50px 0;"></span>
      Data Telah Berhasil di Update
    </p>
</div>
<div id="delete" style="display: none" title="Information Alert">
    <p>
      <span class="ui-icon ui-icon-circle-check" style="float: left; margin: 0 7px 50px 0;"></span>
      Data Telah Berhasil di Hapus
    </p>
</div>
<div id="resets" style="display: none" title="Information Alert">
    <p>
      <span class="ui-icon ui-icon-circle-check" style="float: left; margin: 0 7px 50px 0;"></span>
      Reset data berhasil dilakukan
    </p>
</div>