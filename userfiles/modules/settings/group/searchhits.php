
<style>
    .form-check-label{
        font-size:18px;
    }
    .searchhits-wrapper{
        margin-top: 30px;
        border: 1px solid #ebebeb;
        box-shadow: 0 0 2px 2px #ebebeb;
        padding: 20px 30px;
    }
    .form-check {
         margin-bottom: 10px;
    }
    .form-check-input{
        position: relative;
        transform: scale(1.3);
    }
</style>
<div class="container searchhits-wrapper">
    <div class="row">
        <h3><?php _e("Please select the one you want to display first"); ?></h3>
        <p><?php _e("If you select blog option then in search page blog related search will appear first. If you select product option then in search page product related search will appear first"); ?>.</p>
    </div>
    <div class="row">
        <?php if(Config::get('custom.search_hits')==0): ?>
            <div class="form-check">
                <input class="form-check-input" type="radio" onclick="searchHits('bloghit',0)"  name="flexRadioDefault"  checked id="bloghit">
                <label class="form-check-label" for="flexRadioDefault1">
                    <?php _e("Blog"); ?>
                </label>
            </div>
        <?php else: ?>
            <div class="form-check">
                <input class="form-check-input" type="radio" onclick="searchHits('bloghit',0)" name="flexRadioDefault" id="bloghit" >
                <label class="form-check-label" for="flexRadioDefault2">
                    <?php _e("Blog"); ?>
                </label>
            </div>
        <?php endif; ?>
    </div>
    <div class="row">
        <?php if(Config::get('custom.search_hits')==1): ?>
            <div class="form-check">
                <input class="form-check-input" type="radio" onclick="searchHits('producthit',1)"  name="flexRadioDefault" checked id="producthit">
                <label class="form-check-label" for="flexRadioDefault1">
                    <?php _e("Product"); ?>
                </label>
            </div>
        <?php else: ?>
            <div class="form-check">
                <input class="form-check-input" type="radio" onclick="searchHits('producthit',1)" name="flexRadioDefault" id="producthit" >
                <label class="form-check-label" for="flexRadioDefault2">
                    <?php _e("Product"); ?>
                </label>
            </div>
        <?php endif; ?>
    </div>
</div>


<script>
    function searchHits(name,n){
        if($('#'+name).is(':checked')){
            $.ajax({
                type: "POST",
                url: "<?=api_url('searchHits')?>",
                data:{ n : n},
                success: function(response) {
                    // console.log(response.message);
                },
                error: function(response){
                    console.log(response.responseJSON.message);
                }
            });
        }
    }
</script>