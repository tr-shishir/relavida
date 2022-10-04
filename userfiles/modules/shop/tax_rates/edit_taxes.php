<?php must_have_access();
// use Illuminate\Support\Facades\DB;
?>

<?php if (isset($params['tax_id']) && $params['tax_id'] !== 'false') {
    $addNew = false;
    $tax = DB::table('tax_rates')->where('id', $params['tax_id'])->first();
    $country_name = $tax->country;
    $country_de =  $tax->country_de;
    $country_code =  $tax->country_code;
    $charge =  $tax->charge;
    $lang_code =  $tax->lang_kod;
    $alpha_three =  $tax->alpha_three;
    $id = $tax->id;
} else{
    $addNew = true;
    $country_name = "";
    $country_de = "";
    $country_code = "";
    $charge = "";
    $lang_code = "";
    $alpha_three = "";
}
$countries_all = mw()->forms_manager->countries_list(true);
?>
<div class="js-validation-messages"></div>

<form class="js-edit-tax-form" action="">

    <div class="form-group">
        <label class="control-label">Country Name</label>
        <!--        <input type="text " id="country_name" placeholder="Enter country name" class="form-control" value="--><?php //echo $country_name; ?><!--">-->
        <select name="country" class="shipping-country-select form-control" id="country_name">
            <option value=""><?php _e("Choose country"); ?></option>
            <?php foreach($countries_all  as $item): ?>
                <option value="<?php print $item[1] ?>"  <?php if(isset($country_name) and $country_name == $item[1]): ;?> selected="selected" <?php endif; ?>><?php print $item[1] ?></option>
            <?php endforeach ;?>
        </select>
    </div>

    <!--    <div class="form-group">-->
    <!--        <label class="control-label">Country De</label>-->
    <!--        <input type="text " id="country_de" placeholder="Enter country De" class="form-control" value="--><?php //echo $country_de; ?><!--">-->
    <!--    </div>-->
    <!---->
    <!--    <div class="form-group">-->
    <!--        <label class="control-label">Country Code</label>-->
    <!--        <input type="text " id="country_code" placeholder="Enter country Code" class="form-control" value="--><?php //echo $country_code; ?><!--">-->
    <!--    </div>-->

    <div class="form-group">
        <label class="control-label">Tax Percent</label>
        <input type="text " id="tax" placeholder="Enter Charge tax" class="form-control" value="<?php echo $charge; ?>">
    </div>

    <!--    <div class="form-group">-->
    <!--        <label class="control-label">Language Code</label>-->
    <!--        <input type="text " id="lang_code" placeholder="Enter Charge tax" class="form-control" value="--><?php //echo $lang_code; ?><!--">-->
    <!--    </div>-->
    <!---->
    <!--    <div class="form-group">-->
    <!--        <label class="control-label">Alpha Three</label>-->
    <!--        <input type="text " id="alpha_three" placeholder="Enter Charge tax" class="form-control" value="--><?php //echo $alpha_three; ?><!--">-->
    <!--    </div>-->

    <div class="d-flex justify-content-between">
        <div>
            <?php if (!$addNew) { ?>
                <a class="btn btn-outline-danger btn-sm" href="javascript:deleteTax(<?php print $id; ?>)">Delete</a>
            <?php } ?>
        </div>

        <div>
            <?php if (!$addNew) : ?>
                <button type="button" class="btn btn-success btn-sm js-save-tax" onclick="save(<?php print $id; ?>)">Update</button>
            <?php else : ?>
                <button type="button" class="btn btn-success btn-sm js-save-tax" onclick="save()">Save</button>
            <?php endif; ?>
        </div>
    </div>
</form>
<script>
    function save(id = 0){
        var country_name = document.getElementById('country_name').value;
        // var country_de = document.getElementById('country_de').value;
        // var country_code = document.getElementById('country_code').value;
        var tax = document.getElementById('tax').value;
        // var lang_code = document.getElementById('lang_code').value;
        // var alpha_three = document.getElementById('alpha_three').value;
        if(country_name == ""){
            document.getElementById('country_name').style.border= "1px solid red";
            return;
        } else{
            document.getElementById('country_name').style.border= "none";
        }
        // if(country_de == ""){
        //     document.getElementById('country_de').style.border= "1px solid red";
        //     return;
        // } else{
        //     document.getElementById('country_de').style.border= "none";
        // }
        // if(country_code == ""){
        //     document.getElementById('country_code').style.border= "1px solid red";
        //     return;
        // } else{
        //     document.getElementById('country_code').style.border= "none";
        // }
        if(tax == "" || tax <= 0){
            document.getElementById('tax').style.border= "1px solid red";
            return;
        } else{
            document.getElementById('tax').style.border= "none";
        }
        // if(lang_code == ""){
        //     document.getElementById('lang_code').style.border= "1px solid red";
        //     return;
        // } else{
        //     document.getElementById('lang_code').style.border= "none";
        // }
        // if(alpha_three == ""){
        //     document.getElementById('alpha_three').style.border= "1px solid red";
        //     return;
        // } else{
        //     document.getElementById('alpha_three').style.border= "none";
        // }
        if(id == 0){
            $.post("<?=api_url('save_taxs')?>", {
                country : country_name,
                // country_de : country_de,
                // country_code : country_code,
                charge : tax,
                // lang_kod : lang_code,
                // alpha_three : alpha_three

            }).then((res, err) => {
                console.log(res, err);
            });
        } else {
            $.post("<?=api_url('update_tax')?>", {
                id : id,
                country : country_name,
                // country_de : country_de,
                // country_code : country_code,
                charge : tax,
                // lang_kod : lang_code,
                // alpha_three : alpha_three

            }).then((res, err) => {
                console.log(res, err);
            });
        }
        location.reload()
    }
</script>
