
<style>

.product-upselling .form-group{
  margin-right: 20px;
}
.product-upselling .form-group label{
  margin-right: 10px;
}

.product-upselling table{
	margin-top:40px;
}

.product-upselling table thead{
	background-color:#ccc;
}

.product-upselling table thead th{
	font-weight:bold;
}

.btn-default{
	border:1px solid #ccc;
}
</style>


<?php
use Illuminate\Support\Facades\DB;


$update = false;
$sname ='';
$sprice = '';

if(isset($_GET['edit'])){
  $update = true;
  $editvalue =  DB::table("product_upselling")->find($_GET['edit']);

  $id = $editvalue->id;
  $sname =$editvalue->serviceName;
  $sprice = $editvalue->servicePrice;
}


?>

<div class="product-upselling">

  <p id="textin"></p>



  <?php


  $data = DB::table('product_upselling')->get()->all();

  ?>

  <table class="table table-bordered" >
    <thead>
      <tr>
        <th scope="col"><?php _e('Service Name'); ?></th>
        <th scope="col"><?php _e('Price'); ?></th>
        <th scope="col" style="text-align: right"><?php _e('Action'); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php if(isset($data)):  ?>
          <?php foreach($data as $item):  ?>
          <tr>
			<td><?php print $item->serviceName;  ?></td>
			<td><?php print currency_format($item->servicePrice);  ?></td>
			<td style="text-align: right">
				<a type="button"  href="?edit=<?php print $item->id;  ?>" class="btn btn-success" ><?php _e('EDIT'); ?></a>
				<a type="button" href="<?php print api_url('productUpsellingDelete'); ?>?delete=<?php print $item->id; ?>" class="btn btn-danger" ><?php _e('DELETE'); ?></a>
			</td>
          </tr>
          <?php endforeach;  ?>
      <?php endif;  ?>
    </tbody>
  </table>
  <div class="product-upselling-inner">
      <h2>
        Füge hier weitere Zusatzoptionen (Services oder Cross-Sellings) hinzu. Du kannst diese im Anschluss beim gewünschten Produkt aktivieren.
      </h2>
      <?php if($update): ?>
    <form action="<?php print api_url('productUpsellingUpdate'); ?>" class="form-inline"  method="post">

            <input type="hidden"  class="form-control" value="<?php print $id;  ?>" name="id" id="id">

        <div class="form-group">
            <label><?php _e('Service Name') ?></label>
            <input type="text" required class="form-control" value="<?php print $sname;  ?>" name="serviceName" id="serviceName">
        </div>
        <div class="form-group">
            <label><?php _e('Service Price') ?></label>
            <input type="text" required class="form-control" value="<?php print  $sprice;  ?>"  name="servicePrice" id="servicePrice">
        </div>
            <button class="btn btn-primary" type="submit" ><?php _e('Update') ?></button>
      </form>
      <?php else:  ?>
        <form action="<?php print api_url('productUpsellingInsert'); ?>" class="form-inline"  method="post">
        <div class="form-group">
            <label><?php _e('Service Name') ?></label>
            <input type="text" required class="form-control" name="serviceName" id="serviceName">
        </div>
        <div class="form-group">
            <label><?php _e('Service Price') ?></label>
            <input type="text" required class="form-control" name="servicePrice" id="servicePrice">
        </div>
            <button class="btn btn-primary" type="submit" ><?php _e('Save') ?></button>
      </form>
      <?php endif; ?>
  </div>
</div>



<script>
    function productUpsellingInsert(){
    // console.log($name);
    var sName = $("#servicesName").val();
    var sPrice = $("#servicesPrice").val();
    $.ajax({
        type: "POST",
        url: "<?=api_url('productUpsellingInsert')?>",
        data:{ servicesName : sName, servicesPrice : sPrice },
        success: function(response) {
            console.log(response.message);
            $("#textin"+name).html(response.message);
        },
        error: function(response){
            $("#textin"+name).html(response.responseJSON.message);

        }
    });

    }
</script>