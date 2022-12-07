<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 20px;
    }

    .switch input {
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
        height: 16px;
        width: 20px;
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
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
</style>

<script>
    function isShow(){
        if(document.getElementById('isChecked').checked){
            // alert("Show");
            document.getElementById('status').innerHTML="Einblenden";
            $.post("<?=api_url('store_quantity_status')?>", {
                isShow:"show",
                value: "null"
            }).then((res, err) => {
            mw.notification.success("All changes Saved");
            console.log(res, err);
            });
        }
        else{
            // alert("hide");
            document.getElementById('status').innerHTML="Ausblenden";
            document.getElementById('value').style.display="none";
            document.getElementById('itemShow').style.checked="";
            $.post("<?=api_url('remove_quantity_status')?>")
            .then((res, err) => {
                mw.notification.success("All changes Saved");
                console.log(res, err);
            });
        }
    }

    function showHide(){
        if(document.getElementById('itemShow').checked){
            document.getElementById('value').style.display="";
        } else {
            document.getElementById('value').style.display="none";
            $.post("<?=api_url('update_quantity_status_value')?>", {
                value:"null"
            }).then((res, err) => {
            mw.notification.success("All changes Saved");
            console.log(res, err);
            });
        }
    }

    function save(){
        var value = document.getElementById('itemValue').value;
        $.post("<?=api_url('update_quantity_status')?>", {
                value:value
            }).then((res, err) => {
            console.log(res, err);
            });
    }
</script>

<?php
     $data_show = Config::get('custom.isShow');
    $data_value = Config::get('custom.value');
    // dd($data->value);
?>
<div class="pt-4 pb-4 pl-4" style="border: 0.3px solid lightgray;">
    <h5>Lagerbestand anzeigen</h5><br>
    <label class="switch">
    <input type="checkbox" id="isChecked" onchange="isShow()"<?php if(isset($data_show) && $data_show == "show") echo "checked"; ?>>
    <span class="slider round"></span>
    </label>
    <h4 id="status"><?php if(isset($data_show) && $data_show== "show") echo "Einblenden"; else echo "Ausblenden"; ?></h4>
    <div id="item" class="mt-4 mb-4">
        <input type="checkbox" id="itemShow" onclick="showHide()" <?php if(isset($data_show) && $data_value != "null") echo "checked"; ?>>
        <label for="itemShow" style="font-size: 16px;">Zeige eine individuelle Nachricht wie zum Beispiel "jetzt Bestellen, nur noch [stock] an Lager".</label>
        <div id="value" <?php if(!isset($data_show) || $data_value == "null") : ?>style="display: none;" <?php endif;?> class="mt-4">
            <div class="form-group" style="width: 50%;">
                <input type="text" class="form-control" name="itemValue" id="itemValue" onchange="save()" placeholder="<?php _e("Enter specific quantity"); ?>" <?php if(isset($data_show) && $data_value != "null") : ?>value="<?php echo $data_value; ?>" <?php endif;?>autocomplete="off">
            </div>
        </div>
    </div>
</div>
