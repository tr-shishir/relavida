<?php
$from_live_edit = false;
if (isset($params["live_edit"]) and $params["live_edit"]) {
    $from_live_edit = $params["live_edit"];
}
?>



<?php
if (!user_can_access('module.marketplace.index')) {
    return;
}
?>

<!-- <script>mw.require('admin_package_manager.js');</script> -->

<?php
$is_update_mode = false;
$core_update = false;

//$search_packages_params = array();
$search_packages_params['cache'] = true;

//$search_packages_params2 = $search_packages_params;
//$search_packages_params2['return_local_packages'] = true;
//$search_packages_params2['return_only_updates'] = true;

if (isset($params['show_only_updates']) and $params['show_only_updates']) {
    $search_packages_params['return_local_packages'] = true;
    $search_packages_params['return_only_updates'] = true;
    $is_update_mode = true;
}

$search_packages = mw()->update->composer_search_packages($search_packages_params);
//$search_packages_update = mw()->update->composer_search_packages($search_packages_params2);
//$search_packages = mw()->update->composer_search_packages();


$packages_by_type = array();
$packages_by_type_with_update = array();

if ($search_packages and is_array($search_packages)) {
    foreach ($search_packages as $key => $item) {
        $package_has_update = false;
        //if ($item['type'] != 'microweber-core-update') {
        if (isset($item['has_update']) and $item['has_update']) {
            $package_has_update = true;
        }

        if ($package_has_update) {
            $package_has_update_key = $item['type'];
            if (!isset($packages_by_type_with_update[$package_has_update_key])) {
                $packages_by_type_with_update[$package_has_update_key] = array();
            }
            $packages_by_type_with_update[$package_has_update_key][] = $item;
        }
        //}
        if ($item['type'] != 'microweber-core-update') {
            if (!isset($packages_by_type[$item['type']])) {
                $packages_by_type[$item['type']] = array();
            }
            $packages_by_type[$item['type']][] = $item;
        }
    }
}

if ($is_update_mode and isset($packages_by_type_with_update['microweber-core-update']) and !empty($packages_by_type_with_update['microweber-core-update'])) {
    $core_update = $packages_by_type_with_update['microweber-core-update'];
    unset($packages_by_type_with_update['microweber-core-update']);
    //$packages_by_type_with_update['microweber-core-update'] = array();
    //$packages_by_type_with_update['microweber-core-update'][] = $core_update;
}

$packages_by_type_all = array_merge($packages_by_type, $packages_by_type_with_update);
// dd($packages_by_type_all,$packages_by_type_with_update);
?>

<div class="card style-1 mb-3 <?php if ($from_live_edit): ?>card-in-live-edit<?php endif; ?>">
    <div class="card-header d-flex justify-content-between">
        <?php $module_info = module_info($params['module']); ?>
        <h5>
            <?php if ($is_update_mode) { ?>
                <i class="mdi mdi-update text-primary mr-3"></i> <strong><?php _e("Updates"); ?></strong>
            <?php } else { ?>
                <i class="mdi mdi-fruit-cherries text-primary mr-3"></i> <strong><?php _e("Marketplace"); ?></strong>
            <?php } ?>
        </h5>

        <div clsas="d-flex align-items-center">
            <div class="d-inline-block">
                <div class="dropdown">
                    <button class="btn btn-outline-primary btn-sm btn-icon" type="button" id="moreSettings" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="mdi mdi-cog"></i></button>
                    <div class="dropdown-menu" aria-labelledby="moreSettings">
                        <?php if ($is_update_mode) { ?>
                            <a href="<?php print admin_url() ?>view:packages" class="dropdown-item"><?php _e("Show all packages"); ?></a>
                        <?php } else { ?>
                            <a href="<?php print admin_url() ?>view:settings#option_group=updates" class="dropdown-item"><?php _e("Show updates"); ?></a>
                        <?php } ?>
                        <a href="javascript:;" class="dropdown-item" onclick="mw.admin.admin_package_manager.reload_packages_list();"><?php _e("Reload packages"); ?></a>
                        <a href="javascript:;" class="dropdown-item" onclick="mw.admin.admin_package_manager.show_licenses_modal ();"><?php _e("Licenses"); ?></a>
                    </div>
                </div>
            </div>


            <div class="d-inline-block">
                <div class="form-inline">
                    <div class="input-group mb-0 prepend-transparent mx-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text px-1"><i class="mdi mdi-magnify"></i></span>
                        </div>

                        <input type="text" class="form-control form-control-sm" name="module_keyword" style="width: 100px;" value="" placeholder="Search" onkeyup="event.keyCode==13?mw.url.windowHashParam('search',this.value):false">
                    </div>

                    <button type="button" class="btn btn-primary btn-sm btn-icon" onclick="mw.url.windowHashParam('search',$(this).prev().find('input').val())"><i class="mdi mdi-magnify"></i></button>
                </div>
            </div>

        </div>
    </div>

    <div class="card-body pt-3">

        <script>
            $(document).ready(function () {
                mw.tabs({
                    nav: '#mw-packages-browser-nav-tabs-nav .mw-ui-navigation a.tablink',
                    tabs: '#mw-packages-browser-nav-tabs-nav .tab'
                    //linkable: 'section'
                });
            });
        </script>


<style>


      .marketplace-template-item{
        height: 650px;
        padding: 10px;
        box-shadow: 0 0 2px 2px #eaeaea;
        margin-bottom: 30px;
      }

      .marketplace-template-item-photo{
          height:500px;
          position:relative;
          overflow:hidden;
          cursor: -webkit-grab; */
          cursor: -moz-grab;
          cursor: grab;
      }
        .marketplace-template-item-info-right {
            text-align: right;
        }
         .marketplace-template-item-info-left p {
            margin-top: 5px;
        }
      .marketplace-template-item-info{
          display: flex;
          margin-top: 10px;
          justify-content: space-between;
            background: #fff;
          padding: 10px;
          border-radius: 5px;
      }
      .marketplace-template-item-photo img{
          position: absolute;
      }
      /* .marketplace-template-item-photo img {
          bottom: -1000px;
          width: 100%;
          height: auto;
          position: absolute;
          z-index: 0;
          margin:0;
          padding:0;
          transition: bottom 11s;
      }
      .marketplace-template-item-photo:hover img {
          bottom: 0;
          transition: all 11s;
      } */
      .template-version {
          display: flex;
          align-items: center;
          margin-bottom: 10px;
      }

      .template-version span {
          margin-right: 10px;
      }


      div#pageloader {
          width: 100%;
          margin: 0 auto;
          text-align: center;
      }
      .pre_loader .logo
      {
          display: flex;
          align-items: center;
          justify-content: center;
      }
      .pre_loader .logo img {
          max-height: 110px;
          margin-bottom: 10px;
      }
      .pre_loader .logo h2
      {
          font-weight: 900;
          margin: 0;
          font-size: 3rem;
          color: #0078d4;
      }
      .pre_loader .logo img
      {
          height: 5rem;
      }
      .pre_loader .progressbar
      {
          margin-top: 5px;
          height: 0.2rem;
          width: 10rem;
          background: #b3b3b3;
          margin: 0 auto !important;
      }
      .pre_loader .progressbar::after
      {
          content: "";
          width: 3rem;
          height: 0.2rem;
          background: #0078d4;
          display: block;
          border-radius: 0.5rem;
          animation: animation 1.5s cubic-bezier(0.65, 0.05, 0.36, 1) infinite;
      }
      .pre_loader p {
          margin-bottom: 10px;
      }
      .pre_loader h1
      {
          font-size: 1.5rem;
          color: #585858;
          position: absolute;
          bottom: 1rem;
          font-weight: 400;
      }

      @keyframes animation {
          0% {
              transform: translateX(0rem);
          }
          50% {
              transform: translateX(7rem);
          }
          100% {
              transform: translateX(0rem);
          }
      }
  </style>





      <p>Welcome to the marketplace. Here you will find new templates and updates.</p>


  <?php

      $ch = curl_init('https://packages.droptienda-templates.com/api/template_details');
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $response = curl_exec($ch);
      $themeInfo = json_decode($response, true);



  ?>

  <div id="mw-packages-browser-nav-tabs-nav">
      <div class="row">
          <div class="col-12">
              <div class="marketplace-heading">
                  <!-- <a class="btn btn-outline-secondary justify-content-center active show" data-toggle="tab" href="#template"><i class="mdi mr-1 mdi-pencil-ruler"></i> Template</a> -->
              </div>
              <div class="marketplace-template">
                  <div class="row">
                      <?php foreach ($themeInfo['data'] as $item):

                      ?>
                          <div class="col-md-4">
                              <div class="marketplace-template-item">
                                  <div class="marketplace-template-item-photo screen">
                                      <img src="<?php print $item['template_file'] ?>" alt="">
                                  </div>
                                  <div class="marketplace-template-item-info">
                                      <div class="marketplace-template-item-info-left">
                                          <h4 id="templateTitle"><?php print $item['name'] ?></h4>
                                          <span>Information</span>
                                           <?php
                                          $tname = $item['name'];
                                          $themedir = base_path('userfiles/templates/'.$tname);
                                          ?>
                                          <?php if(is_dir($themedir)): ?>
                                            <p>Installed</p>
                                          <?php endif; ?>
                                          <p id="textin<?php print $item['name'] ?>"></p>
                                      </div>
                                      <div class="marketplace-template-item-info-right">
                                          <div class="template-version">
                                              <span>v</span>
                                              <select class="form-control" id="templateVersion<?php print $item['name'] ?>">
                                                  <?php
                                                  foreach(array_reverse($item['pivots']) as $pv){
                                                      $versions = $pv['version']['version'];

                                                  ?><option value="<?php echo $versions ?>" ><?php echo $versions ?></option><?php
                                                  }
                                                  ?>
                                              </select>
                                          </div>
                                         <?php if(is_dir($themedir)): ?>
                                              <?php if(count($item['pivots'])>1): ?>
                                                <button  class="btn btn-primary">Update</button>
                                              <?php endif; ?>
                                          <?php else: ?>
                                              <button onclick="installTheme('<?php print $item['name'] ?>')" class="btn btn-success">Install</button>
                                          <?php endif; ?>

                                      </div>
                                  </div>
                              </div>
                          </div>
                      <?php endforeach; ?>
                  </div>
              </div>
          </div>
      </div>
  </div>




<!-- start template install pageloader modal -->
<div class="modal" id="installModal" tabindex="-1" role="dialog">
<div class="modal-dialog" role="document">
<div class="modal-content">
  <div class="modal-header">
      <h5 class="modal-title">Installing the new Theme</h5>
  </div>
  <div class="modal-body">
      <div class="pre_loader" id="pageloader" >
          <div class="logo">
              <img src="https://i.postimg.cc/xdrXJZ40/admin-logo.png" alt="prelaoder">
          </div>
          <p>Installing......</p>
          <div class="progressbar"></div>
      </div>
  </div>
</div>
</div>
</div>
<!-- end template install pageloader modal -->

<script>

function installTheme(name){
  // console.log($name);
  var version = $("#templateVersion"+name).val();
//   console.log(name,version);
  $.ajax({
      type: "POST",
      url: "<?=api_url('install_theme')?>",
      data:{ name : name, version : version },
      beforeSend: function(){
          $("#installModal").show();
      },
      success: function(response) {
        //   console.log(response.message);
          $("#textin"+name).html(response.message);
          window.location.href = "<?=url('/')?>/admin/view:content/action:settings?group=template";
      },
      error: function(response){
          $("#textin"+name).html(response.responseJSON.message);

      },
      complete: function(){
          $("#installModal").hide();

      }
  });

}

</script>
