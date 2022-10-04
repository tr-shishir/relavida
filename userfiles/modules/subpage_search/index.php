<style>
.iwant-element {
    position: relative;
    background: rgb(215 215 215);
    padding: 50px 0px;
    text-align: center;
}

.iwant-element .ie-box {
    position: relative;
    /* max-width: 540px; */
    margin: 0px auto;
    vertical-align: middle;
}

.iwant-element .ie-box h4 {
    position: relative;
    display: inline-block;
    font-size: 25px;
    margin-right: 10px;
    vertical-align: middle;
    margin-bottom: 0;
}
.ie-box-heading {
    display: inline-block;
    vertical-align: middle;
}
.select-box-ie {
    position: relative;
    display: inline-block;
}

.select-box-ie select {
    width: 320px;
    height: 44px;
    font-size: 18px;
    border-radius: 5px;
    background-color: #fefff3;
}

.select-box-ie button {
    height: 44px;
    font-size: 18px;
    border-radius: 5px;
    padding: 0px 30px;
}
.iwant-element .ie-box {
    /* max-width: 590px; */
}

.select-box-ie {
    width: auto;
    vertical-align: middle;
}

.select-box-ie span.select2.select2-container {
    width: 300px !important;
    margin-left: -10px;
}

.select-box-ie span.select2-selection.select2-selection--single {
    height: 44px;
    position: relative;
    padding-top: 5px;
    border: 1px solid #bdbdbd;
    background-color: #ffffff;
}

.select-box-ie span.select2-selection.select2-selection--single span#select2-selected_subpage_link-container {
    height: 100%;
    font-size: 18px;
    line-height: 31px;
}

.select-box-ie span.select2-selection__arrow {
    top: 9px !IMPORTANT;
}
.ie-container h3 {
    font-size: 30px;
    font-weight: 600;
    margin-bottom: 25px;
    line-height: 38px;
}
.subpage-search-button .btn.btn-primary{
    padding: 10px 5px !important;
    border-radius: 4px;
    margin-left: 10px;
}
@media screen and (max-width: 767px){
    .iwant-element .ie-box h4{
        display: block;
    }
    .ie-box-heading {
        display: block;
    }
    .select-box-ie {
        width: auto;
    }
}
</style>
<div class="iwant-element">
    <div class="ie-container">
        <div class="edit" field="subpage_search_heading-<?php print $params['id'] ?>" rel="module">
            <h3>HOW CAN WE HELP YOU TODAY?</h3>
        </div>
        <div class="ie-box">
            <div class="ie-box-heading edit" field="subpage_search_content-<?php print $params['id'] ?>" rel="module">
                <h4>I want to</h4>
            </div>
            <?php
                $all_subpage_link_list = DB::table('options')->where('option_group',$params['id'])->get() ?? [];
            ?>
            <div class="select-box-ie">
                <select class="js-example-basic-single" id="selected_subpage_link-<?php print $params['id']; ?>">
                    <option value=""><?php _e('Select subpage link from here'); ?>.</option>
                    <?php foreach($all_subpage_link_list as $subpage_name): ?>
                        <option value="<?php print $subpage_name->option_value; ?>"><?php print $subpage_name->option_key; ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="edit subpage-search-button" field="subpage_search_button-<?php print $params['id'] ?>" rel="module" <?php if(!is_live_edit()): ?> onclick="lets_go_subpage();" <?php endif; ?> style="display:inline-block; cursor: pointer;">
                    <h1 class="btn btn-primary">Let's Go!</h1>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
    function lets_go_subpage(){
        let subpage_redirect_url_link = $("#selected_subpage_link-<?php print $params['id']; ?>").val();
        console.log(subpage_redirect_url_link);
        window.location.href = subpage_redirect_url_link;
    }
</script>