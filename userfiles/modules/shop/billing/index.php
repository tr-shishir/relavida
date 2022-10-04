
<div class="mb-3">
  <h3 class="checkout-header">Rechnungsadresse</h3><hr>
</div>
<div class="form-group ">
  <div id="shipping_country_825e13eb8c0301440cc53e5c1e73609c126d38fd7d7caa4c24205c822cb938ed">
    <label>
      Land auswählen<span style="color: red;">*</span>
    </label>
    <?php if(is_logged()):  ?>
      <?php 
        $user_profile_country = user_country(user_id());
        if(!$user_profile_country){
            $tax= mw()->tax_manager->get();
            $user_profile_country = $tax['0']['name'];
        }
      ?>
      <select name="billing_country" class="field-full form-control countrySelectBox country-rate" id="billing_country" style="pointer-events: none !important;" required>
        <option value="<?php print $user_profile_country; ?>"   selected="selected"><?php print $user_profile_country; ?></option>
      </select>
    <?php else: ?>
      <?php $all_country_list = DB::table('tax_rates')->orderBy('country','asc')->get('country'); ?>
      <select name="billing_country" class="field-full form-control countrySelectBox country-rate" id="billing_country" required>
        <?php if(isset($all_country_list)): ?>
          <?php foreach($all_country_list  as $item): ?>
            <option value="<?php print $item->country; ?>" <?php if("Germany" == $item->country): ?>selected<?php endif; ?>><?php print $item->country; ?></option>
          <?php endforeach ; ?>
        <?php endif; ?>
      </select>
    <?php endif; ?>
  </div>
</div>
<!-- <label class="control-label">Adresse</label> -->
<div class="row">
  <div class="col-md-12">
      <div class="form-group ">
        <label for="billing_zip">Name </label>
        <span style="color: red;">*</span>
        <input type="text" name="billing_name" class="form-control" id="billing_name" aria-describedby="emailHelp" value="<?php if (isset($user)) {
            print $user['first_name'].' '.$user['last_name'];
        }elseif (@mw()->user_manager->session_get("first_name") != null || @mw()->user_manager->session_get("last_name") != null){
            print mw()->user_manager->session_get("first_name").' '.mw()->user_manager->session_get("last_name");
        }?>" required>
      </div>
  </div>
</div>
<div class="row">
  <div class="col-md-6">
    <div class="form-group ">
      <label for="billing_zip">Postleitzahl </label>
      <span style="color: red;">*</span>
      <input type="text" name="billing_zip" class="form-control" id="billing_zip" aria-describedby="emailHelp"  required>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group ">
      <label for="billing_city">Stadt </label>
      <span style="color: red;">*</span>
      <input type="text" name="billing_city" class="form-control" id="billing_city" aria-describedby="emailHelp"  required>
    </div>
  </div>
</div>


<!-- <div class="form-group ">
  <label for="billing_state">Bundesland</label>
  <span style="color: red;">*</span>
  <input type="text" name="billing_state" class="form-control" id="billing_state" aria-describedby="emailHelp"  required>
</div> -->
<div class="form-group ">
  <label for="billing_address">Straße und Hausnummer</label>
  <span style="color: red;">*</span>
  <input type="text" name="billing_address" class="form-control" id="billing_address" aria-describedby="emailHelp" required>
</div>
