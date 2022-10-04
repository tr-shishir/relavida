<style>
      .btn-purchase{
          background-color: #F26522;
          color: #fff;
      }
      .update-btn{
          margin-left:auto !important;
      }

      .marketplace-template-item{
        height: auto;
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
            width: 100%;
            min-height: 700px;
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

        .template-premium-text {
            display: inline-block;
            position: absolute;
            width: 100px;
            height: 100px;
            overflow: hidden;
            z-index: 9;
            top: -9px;
            right: 4px;
        }

        .template-premium-text span{
            position: absolute;
            display: block;
            width: 185px;
            padding: 6px 0;
            background-color: #4050fd;
            box-shadow: 0 5px 10px rgb(0 0 0 / 10%);
            color: #fff;
            font: 500 12px/1 'Lato', sans-serif;
            text-shadow: 0 1px 1px rgb(0 0 0 / 20%);
            text-transform: uppercase;
            text-align: center;
            left: -34px;
            top: 30px;
            transform: rotate(45deg);
        }

        .template-premium-text::before {
            top: 0;
            left: 0;
            position: absolute;
            z-index: -1;
            content: '';
            display: block;
            border: 5px solid #313fb1;
        }

        .template-premium-text::after{
            bottom: 0;
            right: 0;
            position: absolute;
            z-index: -1;
            content: '';
            display: block;
            border: 5px solid #313fb1;
        }
        .feature-update{
            margin-left: 20px;
        }

        .dt_t_countdown_data{
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .theme-countdown{
            background: #fff;
          padding: 10px;
          border-radius: 5px;
        }

</style>





      <p>Willkommen in deinem Droptienda-Templatestore. Hier findest du alle verfügbaren Template-Vorlagen und Updates.</p>

<?php
$curl = curl_init();
//    dd(Config::get('microweber.userPassToken'));
curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://eu-dropshipping.com/api/v1/check-purchase-template',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_CUSTOMREQUEST => 'POST',
    //                                       CURLOPT_POSTFIELDS => array('template_id' => $item['id']),
    CURLOPT_HTTPHEADER => array(
        'userToken: '.Config::get('microweber.userToken'),
        'userPassToken: '.Config::get('microweber.userPassToken'),
        'Cookie: SameSite=None'
    ),
));

$response = curl_exec($curl);
curl_close($curl);
$res = json_decode($response, true);
$purchase = $res['purchase']?? [];
$has_flat_rate = $res['has_flat_rate']?? false;
?>
  <?php



      $ch = curl_init('https://packages.droptienda-templates.com/api/template_details');
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $response = curl_exec($ch);
      curl_close($ch);
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
                            if(str_replace(' ', '', $item['name'])){
                            $tname = str_replace(' ', '', $item['name']);
                            }
                           else{
                            $tname = $item['name'];
                           }

                          $themedir = base_path('userfiles/templates/'.$tname);
                          $purchase_item = $purchase[$item['id']]?? [];
                            if($has_flat_rate == true ) {
                                $purchase_item['flat'] = 1;
                            }

                      ?>
                          <div class="col-md-4">
                              <div class="marketplace-template-item">
                                  <div class="marketplace-template-item-photo screen">
                                      <img src="<?php print $themeInfo['url'].'/'.$item['template_file'] ?>" alt="">

                                  </div>

                                  <div class="marketplace-template-item-info">
                                      <div class="marketplace-template-item-info-left">
                                          <h4 id="templateTitle<?php print $item['id'] ?>"><?php print $item['name'] ?></h4>
                                          <span>Information </span>



                                           <?php
                                            $updateTheme = false;
                                            $currentVersion= 1.0;
                                            $get_config_temp = new App\Models\CustomField();
                                            ?>
                                            <?php if(is_dir($themedir)):
                                             $currentVersion = $get_config_temp->get_a_config($tname)['version'];
                                            ?>
                                                <p>Installed <?php print $currentVersion; ?> </p>
                                            <?php endif; ?>
                                            <p id="textin<?php print $item['id'] ?>"></p>
                                      </div>
                                      <div class="marketplace-template-item-info-right">
                                          <div class="template-version">
                                          <?php
                                            foreach(array_reverse($item['pivots']) as $pv){
                                                $versions = $pv['version']['version'];
                                                if($currentVersion < $versions){
                                                    $updateTheme = true;
                                                }
                                            }
                                            ?>

                                        <input type="hidden" id="templateVersion<?php print $item['id'];  ?>" value="<?php if(@end($item['pivots'])['version']['version']){ print end($item['pivots'])['version']['version']; } ?>">
                                          </div>

                                            <?php if(is_dir($themedir)): ?>
                                                <?php if($updateTheme == true): ?>
                                                    <button  class="btn btn-primary update-btn" data-toggle="modal" data-target="#updatepopup<?php print $item['id'];  ?>" style="margin-bottom: 10px;">Aktualisieren</button>
                                                <?php endif; ?>

                                                <?php if(isset($purchase_item['is_trial']) && (!empty($purchase_item) && $purchase_item['is_trial'])): ?>
                                                    <a href="https://drm.software/admin/template-store?template=<?php print $item['id'] ?>" class="btn btn-purchase" target="_blank">Testen & Kaufen</a>
                                                <?php endif; ?>
                                                <?php if(!isset($purchase_item['is_trial']) && !$has_flat_rate): ?>
                                                    <a href="https://drm.software/admin/template-store?template=<?php print $item['id'] ?>" class="btn btn-purchase" target="_blank">Testen & Kaufen</a>
                                                <?php endif; ?>

                                                <?php
                                                    if(empty($purchase_item)){
                                                        Config::set('template.'.$tname, $item['id']);
                                                        Config::save(array('template'));
                                                    }else{
                                                        Config::set('template.'.$tname, 0);
                                                        Config::save(array('template'));
                                                    }
                                                ?>

                                            <?php else:  ?>
                                                <?php if(!empty($purchase_item) || $has_flat_rate): ?>
                                                    <button onclick="installTheme('<?php print $item['id'] ?>')" class="btn btn-success" style="margin-bottom: 10px;">Installieren</button>
                                                <?php
                                                if(isset($purchase_item['is_trial'])){
                                                if($purchase_item['is_trial']){ ?>
                                                        <a href="https://drm.software/admin/template-store?template=<?php print $item['id'] ?>" class="btn btn-purchase" target="_blank">Testen & Kaufen</a>
                                                    <?php }}
                                                    ?>

                                                <?php else:  ?>
                                                    <a href="https://drm.software/admin/template-store?template=<?php print $item['id'] ?>" class="btn btn-purchase" target="_blank">Testen & Kaufen</a>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                      </div>

                                  </div>
                                  <div class="theme-countdown">
                                            <?php
                                                if(isset($purchase_item['is_trial']) && (!empty($purchase_item) && $purchase_item['is_trial'] && ($purchase_item['remaining'] > 0)) ){
                                                    echo '<div class="dt_t_countdown_data" data-end="'.$purchase_item['remaining'].'"></div>';
                                                }
                                            ?>
                                      </div>
                              </div>

                          </div>

                          <!-- start template Update  modal -->
                            <div class="modal fade" tabindex="-1" id="updatepopup<?php print $item['id'];  ?>" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <p class="text-muted small" ><?php print $item['name']; ?>  Update Version <?php if(@end($item['pivots'])['version']['version']){ print end($item['pivots'])['version']['version']; } ?></p>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                                </div>
                                <div class="modal-body">
                                    <p>Ein neues Update ist verfugbar. Du kannst es jetzt kostenfrei installieren. Sichere zuvor deine Daten, damit du sie jederzeit wiederherstellen kannst.</p>
                                    <p>Das Update beinhaltet folgende Neuerungen:</p>
                                    <?php foreach($item['pivots'] as $tinfo):  ?>
                                        <?php if(@$currentVersion && $currentVersion < $tinfo['version']['version'] ): ?>
                                            <div class="tab<?php print $item['id'] ?>">
                                                <p>Information of update version <?php print $tinfo['version']['version'] ?> </p>
                                                <ul class="feature-update">
                                                    <li ><?php print $tinfo['info'] ?></li>
                                                </ul>
                                             </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                                <div class="modal-footer"  style="justify-content: space-between;">
                                    <p class="text-muted small" ><?php print $item['name']; ?>  Current Version <?php if(@$currentVersion){ print $currentVersion; } ?></p>
                                    <div>
                                        <button type="button" id="prevBtn<?php print $item['id'] ?>" class="btn btn-secondary" onclick="nextPrev<?php print $item['id'] ?>(-1)">zurück</button>
                                        <button type="button" id="nextBtn<?php print $item['id'] ?>" class="btn btn-primary" onclick="nextPrev<?php print $item['id'] ?>(1)">weiter</button>
                                        <button type="button" id="updateTemplateBtn" onclick="updateTheme('<?php print $item['id'] ?>')" class="btn btn-success">Update starten</button>
                                    </div>
                                </div>
                                </div>
                            </div>
                            </div>
                            <!-- end template Update  modal -->

                          <script>
                            // $("#templateVersion<?php //print $item['id'] ?>").change(function(){
                            //     var selectedVersion = $(this).children("option:selected").val();
                            //     if(selectedVersion <=  <?php //print $currentVersion ?> ){
                            //         console.log(selectedVersion);
                            //         $(".update-btn").css('display','none');
                            //     }else{
                            //         $(".update-btn").css('display','block');
                            //     }

                            // });
                          </script>
                        <?php if(is_dir($themedir)): ?>
                            <script type="text/javascript">
                               $(".tab<?php print $item['id'] ?>").css("display", "none");
                                var currentTab<?php print $item['id'] ?> = 0; // Current tab is set to be the first tab (0)
                                showTab<?php print $item['id'] ?>(currentTab<?php print $item['id'] ?>); // Display the current tab

                                function showTab<?php print $item['id'] ?>(n<?php print $item['id'] ?>) {
                                // This function will display the specified tab of the form ...
                                    var x<?php print $item['id'] ?> = document.getElementsByClassName("tab<?php print $item['id'] ?>");

                                    x<?php print $item['id'] ?>[n<?php print $item['id'] ?>].style.display = "block";
                                    // ... and fix the Previous/Next buttons:
                                    if (n<?php print $item['id'] ?> == 0) {
                                        document.getElementById("prevBtn<?php print $item['id'] ?>").style.display = "none";
                                    } else {
                                        document.getElementById("prevBtn<?php print $item['id'] ?>").style.display = "inline";
                                    }

                                    if (n<?php print $item['id'] ?> == (x<?php print $item['id'] ?>.length - 1)) {
                                        $("#nextBtn<?php print $item['id'] ?>").css("display", "none");
                                        $("#updateTemplateBtn").css("display", "inline");
                                    }else{
                                        $("#nextBtn<?php print $item['id'] ?>").css("display", "inline");
                                        $("#updateTemplateBtn").css("display", "none");
                                    }
                                    // ... and run a function that displays the correct step indicator:
                                }

                                function nextPrev<?php print $item['id'] ?>(n<?php print $item['id'] ?>) {
                                    // This function will figure out which tab to display
                                    var x<?php print $item['id'] ?> = document.getElementsByClassName("tab<?php print $item['id'] ?>");
                                    // Exit the function if any field in the current tab is invalid:
                                    // Hide the current tab:
                                    x<?php print $item['id'] ?>[currentTab<?php print $item['id'] ?>].style.display = "none";
                                    // Increase or decrease the current tab by 1:
                                    currentTab<?php print $item['id'] ?> = currentTab<?php print $item['id'] ?> + n<?php print $item['id'] ?>;
                                    // Otherwise, display the correct tab:
                                    showTab<?php print $item['id'] ?>(currentTab<?php print $item['id'] ?>);
                                }
                            </script>
                        <?php endif; ?>
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

<!-- start template Update pageloader modal -->
<div class="modal" id="updateModal" tabindex="-1" role="dialog">
<div class="modal-dialog" role="document">
<div class="modal-content">
  <div class="modal-header">
      <h5 class="modal-title">Updating the Theme</h5>
  </div>
  <div class="modal-body">
      <div class="pre_loader" id="pageloader" >
          <div class="logo">
              <img src="https://i.postimg.cc/xdrXJZ40/admin-logo.png" alt="prelaoder">
          </div>
          <p>Updating......</p>
          <div class="progressbar"></div>
      </div>
  </div>
</div>
</div>
</div>
<!-- end template Update pageloader modal -->








<script>
// function updateInfo(id){
//     var version = $("#templateVersion"+id).val();
//     var name = $("#templateTitle"+id).text();
//     console.log(name,version);
//     $.ajax({
//         type: "POST",
//         url: "<?=api_url('themeupdateinfo')?>",
//         data:{ name : name, version : version },
//         success: function(response) {
//             console.log(response.message);
//             $("#updateinfo"+id).html(response.message);

//         },
//         error: function(response){
//             $("#updateinfo"+id).html(response.responseJSON.message);

//         }
//     });
// }

function installTheme(id){
  // console.log($name);
  var version = $("#templateVersion"+id).val();
  var name = $("#templateTitle"+id).text();
//   console.log(name,version);
  $.ajax({
      type: "POST",
      url: "<?=api_url('install_theme')?>",
      data:{ name : name, version : version },
      beforeSend: function(){
          $("#installModal").show();

      },
      success: function(response) {
          console.log(response.message);
          $("#textin"+id).html(response.message);
          window.location.href = "<?=url('/')?>/admin/view:content/action:settings?group=template";
      },
      error: function(response){
          $("#textin"+id).html(response.responseJSON.message);

      },
      complete: function(){
          $("#installModal").hide();

      }
  });

}



function updateTheme(id){
  // console.log($name);
  var version = $("#templateVersion"+id).val();
  var name = $("#templateTitle"+id).text();
//   console.log(name,version);
  $.ajax({
      type: "POST",
      url: "<?=api_url('install_theme')?>",
      data:{ name : name, version : version },
      beforeSend: function(){
          $("#updatepopup"+id).hide();
          $("#updateModal").show();
      },
      success: function(response) {
          console.log(response.message);
          $("#textin"+id).html(response.message);
          window.location.href = "<?=url('/')?>/admin";
      },
      error: function(response){
          $("#textin"+id).html(response.responseJSON.message);

      },
      complete: function(){
          $("#updateModal").hide();

      }
  });

}

//Update trial clock
function updateDTTemplateTrialClock(el){
    let time_interval = setInterval(function() {
        let total = el.data('end');

        if(!total){
            el.hide();
            el.html('');
            clearInterval(time_interval);
            return;
        }

        const seconds = Math.floor( total % 60 );
        const minutes = Math.floor( (total/60) % 60 );
        const hours = Math.floor( (total/(60*60)) % 24 );
        const days = Math.floor( total/(60*60*24) );
        --total;

        el.data('end', total);
        el.css('padding', '10px 15px');
        el.html(`${days < 10? ' 0'+days : days} Days, H: ${hours < 10?  '0'+hours : hours} M: ${minutes < 10?  '0'+minutes : minutes} S: ${seconds < 10?  '0'+seconds : seconds}`);

    }, 1000);
}

function show_dt_template_trial_countdown()
{
    if(!$('.dt_t_countdown_data').length) return;

    $('.dt_t_countdown_data').each(function() {
        let _st = $(this).data('end');
        if(_st){
            updateDTTemplateTrialClock($(this))
        }
    });
}

$(document).ready(function(){
    show_dt_template_trial_countdown();
})
</script>
