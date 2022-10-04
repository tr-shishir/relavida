<?php
    $data_time = DB::table('handling_time')->orderBy('data', 'asc')->get();
    $is_admin = is_admin();

?>
<div class="hideorshow">
    <div class="row mt-4 ml-2">
        <h5><?php _e('List of all handling time'); ?></h5>
    </div>

    <hr>

    <div class="row mt-4 ml-2">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col"><b><?php _e('Handling time'); ?></b></th>
                    <th scope="col"><b><?php _e('Delivery time'); ?></b></th>
                    <?php if($is_admin): ?>
                        <th scope="col"><b><?php _e('Actions'); ?></b></th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data_time as $item): ?>
                    <tr>
                        <td><?php print $item->data." Days Handlungtime"; ?></td>
                        <td><?php if(function_exists('handling_time')) : print handling_time($item->data); else: _e('Something went wromg'); endif;?></td>
                        <?php if($is_admin):
                            $text = "";
                            if($item->text == null){
                                $text = handling_time($item->data);
                            } else{
                                $text = $item->text;
                            }
                            ?>
                            <td><a href="#" class="btn btn-primary" onclick="edit_handlingtime(<?php print $item->id; ?>, '<?php print $text; ?>')"><?php _e('Edit'); ?></a> <a href="#" class="btn btn-danger" onclick="delete_handlingtime(<?php print $item->id; ?>)"><?php _e('Delete'); ?></a></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><?php _e('Delivery Note'); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <input class="form-control" type="hidden" name="id" id="id" value="">
            <input type="text" class="form-control" id="text" name="text">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php _e('Close'); ?></button>
        <button type="button" class="btn btn-primary" onclick="addhandlingdata()"><?php _e('Save'); ?></button>
      </div>
    </div>
  </div>
</div>
<script>
    function delete_handlingtime(id){
        mw.tools.confirm("<?php _e("Do you want to delete this data"); ?>?", function () {
            $.post("<?=api_url('delete_handlingtime') ?>",{
                id : id
            });
        location.reload();
        });

    }

    function edit_handlingtime(id, data){
        $("#editModal").modal('show');
        $("#id").attr('value', id);
        $("#text").attr('value', data);
    }

    function addhandlingdata(){
        var id = $("#id").val();
        var text = $("#text").val();
        // alert(id);
        // alert(text);
        $.post("<?=api_url('update_handlingtime') ?>",{
            id : id,
            text : text
        });
        location.reload();
    }
</script>