<!-- Modal -->
<div class="modal fade layout-name-edit" id="sidebar_nav_module_info_edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><?php _e('Please set Layout name and icon from here'); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="javascript:save_module_name_for_sidebar_nav();">
            <input type="hidden" id="current-module-id">
            <div class="input-group sidebar-icon">
                <label for=""><?php _e('Icon'); ?>:</label>
                <input type="text" class="form-control icon-class-input" id="layout_icon" placeholder="<?php _e('Add a name of icon or choose from here'); ?>"  required>
                <button type="button" class="btn btn-primary picker-button"><?php _e('Pick an Icon'); ?></button>
                <span class="demo-icon picker-button"></span>
            </div>
            <div class="input-group" id="layout_name_field">
                <label for=""><?php _e('Layout Name'); ?>:</label>
                <input type="text" class="form-control" id="layout_name_set"  required>
            </div>
            <div class="input-group button-group">
                <button type="submit" class="btn btn-success" style="margin-left:10px"><?php _e('Save'); ?></button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div id="iconPicker" class="sidebarNavIconPicker modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<div>
					<ul class="icon-picker-list">
						<li>
							<a data-class="{{item}} {{activeState}}" data-index="{{index}}" >
								<span class="{{item}}"></span>
							</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" id="change-icon" class="btn btn-success">
					<span class="fa fa-check-circle"></span>
          <?php _e('Selected Icon'); ?>
				</button>
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Cancel'); ?></button>
			</div>
		</div>
	</div>
</div>
