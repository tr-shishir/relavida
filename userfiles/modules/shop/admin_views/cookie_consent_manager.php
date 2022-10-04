<style>
.icon-holder {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 20px;
}

.icon-holder img {
    height: 30px !important;
    width: 30px !important;
    object-fit: cover;
    max-width: none !important;
}
.info-holder {
    width: 80% !important;
    display: block;
}
.thank-switch {
    position: relative;
    display: inline-block;
    width: 30px;
    height: 17px;
    margin-right: 10px;
    margin-bottom: 0;
}

.thank-switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 13px;
  width: 13px;
  left: 2px;
  bottom: 2px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(13px);
  -ms-transform: translateX(13px);
  transform: translateX(13px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
/* For thank-Switch checkbox End*/

.legal-texts-with-toggle{
    display: flex;
    justify-content: space-between;
    align-items: center;
}
/* .it-legals-link{
    pointer-events: none;
}
.protected-legals-link{
    pointer-events: none;
} */


</style>
<script>
    $(document).ready(function () {
        mw.options.form('.<?php print $config['module_class'] ?>,.mw_adm_cont_head_change_holder', function () {
            mw.notification.success("Cookie consent manager settings updated.");
        });
    });
</script>
<div class="card bg-none style-1 mb-0">
    <div class="card-header px-0">
        <h5><i class="mdi mdi-shopping text-primary mr-3"></i> <strong><?php _e('Cookie Consent Manager'); ?></strong></h5>
    </div>
    <div class="card-body pt-3 px-0">
        <div class="card style-1 mb-3">
            <div class="card-body pt-3 px-5">
                <div class="form-group">
                    <label class="control-label"><?php _e('Cookie Setting'); ?></label>
                    <small class="text-muted d-block mb-2"><?php _e('Please insert your Code-ID here'); ?> : </small>
                    <small class="text-muted d-block mb-2"><a href="https://www.consentmanager.net/" target="_blank">www.consentmanager.net</a></small>
                    <input name="consentmanager_code_id" style="max-width: 300px;" class="mw_option_field form-control" type="text" option-group="consentmanager" value="<?php print get_option('consentmanager_code_id', 'consentmanager'); ?>">
                </div>
            </div>
        </div>
    </div>
</div>
