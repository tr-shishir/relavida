<style>



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

</style>
 <?php
 use illuminate\Support\Facades\DB;

 $roundprice = Config::get('custom.round_amount');
 if(isset($roundprice)){
     $roundamount = $roundprice;
 }else{
    $roundamount = 0;
 }

 ?>

<div class="card style-1 mb-3">
    <div class="card-header">
        <h5>
            <img src="" class="module-icon-svg-fill"/> <strong><?php _e("Round Prices"); ?></strong>
        </h5>
    </div>

    <div class="card-body pt-3">
        <div class="d-flex justify-content-between">
            <div class="form-group">
                <div class="custom-control ">
                <?php if($roundamount > 0): ?>
                    <label class="thank-switch">
                        <input type="checkbox" onclick="round_price();" name="enable_round_price" id="enable_round_price"  checked>
                        <span class="slider round"></span>
                    </label>
                <?php else: ?>
                    <label class="thank-switch">
                    <input type="checkbox" onclick="round_price();"  name="enable_round_price" id="enable_round_price" >
                        <span class="slider round"></span>
                    </label>

                <?php endif; ?>

                    <label  for="enable_round_price"><?php _e("Enable round prices"); ?></label>
                </div>
                <small class="text-muted d-block"><?php _e("Setup round prices and they will appear automatically in your cart"); ?></small>
            </div>
            <div>
            <select class="form-control" id="roundPrice">
                <?php for($i = 1 ; $i <100 ; $i++):  ?>
                    <?php if($roundamount == $i): ?>
                        <option value="<?php echo $i ?>" selected ><?php echo $i ?></option>
                    <?php else: ?>
                        <option value="<?php echo $i ?>" ><?php echo $i ?></option>
                    <?php endif; ?>
                <?php endfor; ?>
            </select>
            </div>
        </div>
    </div>
</div>


<script>
$("#roundPrice").change(function(){
    if($('#enable_round_price').is(':checked')){
            var selectedRoundprice = $("#roundPrice").val();
            $.ajax({
                type: "POST",
                url: "<?=api_url('activeRoundprice')?>",
                data:{ round_price : selectedRoundprice},
                success: function(response) {
                    // console.log(response.message);
                },
                error: function(response){
                    console.log(response.responseJSON.message);
                }
            });
        }

});


function round_price(){
        if($('#enable_round_price').is(':checked')){
            var selectedRoundprice = $("#roundPrice").val();
            // console.log(selectedRoundprice);
            $.ajax({
                type: "POST",
                url: "<?=api_url('activeRoundprice')?>",
                data:{ round_price : selectedRoundprice},
                success: function(response) {
                    // console.log(response.message);
                },
                error: function(response){
                    console.log(response.responseJSON.message);
                }
            });
        }else{
            $.ajax({
                type: "POST",
                url: "<?=api_url('deactiveRoundprice')?>",
                data:{ },
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
