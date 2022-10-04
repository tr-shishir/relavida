<link rel="stylesheet" type="text/css" href="<?php print $config['url_to_module'] ?>css/style.css" />
<?php
    $page_field_names =  dt_clone_getParentFieldName(PAGE_ID);
    $layout_id_names = array();
    $module_templates = module_templates('layouts/admin');
    foreach($page_field_names as $page_field_name){
        $oldcontent = DB::table('content_fields')->where('rel_id',PAGE_ID)->where('field',$page_field_name)->get()->last();

        if($oldcontent){
            $html =   $oldcontent->value;
        }else{
            $html = null;
        }
        $dom = new DOMDocument();
        @$dom->loadHTML($html);
        $nodes = array();
        $nodes = $dom->getElementsByTagName("module");
        $rename_ids = array();
        foreach ($nodes as $element)
        {
            $data_mw_title = $element->getAttribute("data-mw-title");
            $module_template = $element->getAttribute("template");
            $module_id = $element->getAttribute("id");

            if(str_contains($module_id, 'faq') || str_contains($module_template, 'faq')){

                $rename_ids[] = $module_id;

            }

            $faq_question_count = 0;

            $module_information = DB::table('options')->where('option_group','sidebar-nav-module-list-'.PAGE_ID)->where('option_key',$module_id)->get();
            if(!empty($module_information[0])){
                if($data_mw_title == 'Layouts'){
                    $template_skin= str_replace('.php','',$module_template);
                    $template= str_replace('/','-', $template_skin);
                    $id = $module_id;
                    $layout_field_id='layout'.'-'.$template.'-'.$id;
                    if($module_template == "faq-heading.php" || $module_template = "faq-heading-default"){
                        $full_contentn = DB::table('content_fields')->where('field',$layout_field_id)->get()->last();
                        $domn = new DOMDocument();
                        @$domn->loadHTML($full_contentn->value);
                        $nodesnew = array();
                        $nodesnew = $domn->getElementsByTagName("module");
                        $faq_question_count = 0;
                        foreach ($nodesnew as $elementn)
                        {
                            $data_mw_titlen = $elementn->getAttribute("data-mw-title");
                            $module_templaten = $elementn->getAttribute("template");
                            $module_idn = $elementn->getAttribute("id");
                            if($data_mw_titlen == 'FAQ'){
                                $faq_all_questions = (get_option('settings',$module_idn)) ? get_option('settings',$module_idn) : get_option('settings','faq');
                                if($faq_all_questions){
                                    $faq_module_questions = array_filter(json_decode($faq_all_questions), function ($faq_question) use ($module_idn) {
                                    if(isset($faq_question->page_id) && isset($faq_question->module_id)){
                                        if($faq_question->page_id == PAGE_ID && $faq_question->module_id == $module_idn){
                                            return true;
                                        }
                                    }
                                    });
                                    $faq_question_count = count($faq_module_questions);
                                }
                                $faq=array("faq" => true);
                            }
                        }
                    }
                    $layout_id_names[]=array_merge(array("module_id" => $module_id,"layout_field_id" => $layout_field_id,"module_name" => $module_information[0]->option_value,"module_icon" => $module_information[0]->option_value2,"faq_question_count" => @$faq_question_count??0, "default" => false),$faq??[]);
                    $faq=array("faq" => false);
                }else if($data_mw_title == 'FAQ'){
                    $faq_all_questions = (get_option('settings',$module_id)) ? get_option('settings',$module_id) : get_option('settings','faq');
                    $faq_question_count = 0;
                    if($faq_all_questions){
                        $faq_module_questions = array_filter(json_decode($faq_all_questions), function ($faq_question) use ($module_id) {
                            if(isset($faq_question->page_id) && isset($faq_question->module_id)){

                                if($faq_question->page_id == PAGE_ID && $faq_question->module_id == $module_id){
                                    return true;
                                }
                            }
                        });
                        $faq_question_count = count($faq_module_questions);
                    }
                    $layout_id_names[]=array("module_id" => $module_id,"module_name" =>  $module_information[0]->option_value,"module_icon" => $module_information[0]->option_value2,"faq_question_count" => $faq_question_count, "default" => false,"faq" => true);
                }
            }else{
                if($data_mw_title == 'Layouts'){
                    $template_skin= str_replace('.php','',$module_template);
                    $template= str_replace('/','-', $template_skin);
                    $id = $module_id;
                    $layout_field_id='layout'.'-'.$template.'-'.$id;
                    if($module_template == "faq-heading.php" || $module_template = "faq-heading-default"){
                        $full_contentnd = DB::table('content_fields')->where('field',$layout_field_id)->get()->last();
                        $domnd = new DOMDocument();
                        @$domnd->loadHTML($full_contentnd->value);
                        $nodesnewdom = array();
                        $nodesnewdom = $domnd->getElementsByTagName("module");
                        $faq_question_count = 0;
                        foreach ($nodesnewdom as $elementnd)
                        {
                            $data_mw_titlen = $elementnd->getAttribute("data-mw-title");
                            $module_templaten = $elementnd->getAttribute("template");
                            $module_idn = $elementnd->getAttribute("id");

                            if($data_mw_titlen == 'FAQ'){
                                $faq_all_questions = (get_option('settings',$module_idn)) ? get_option('settings',$module_idn) : get_option('settings','faq');
                                if($faq_all_questions){
                                    $faq_module_questions = array_filter(json_decode($faq_all_questions), function ($faq_question) use ($module_idn) {
                                    if(isset($faq_question->page_id) && isset($faq_question->module_id)){

                                        if($faq_question->page_id == PAGE_ID && $faq_question->module_id == $module_idn){
                                            return true;
                                        }
                                    }
                                    });
                                    $faq_question_count = count($faq_module_questions);
                                }
                                $faq=array("faq" => true);
                            }
                        }

                    }
                    if (isset($module_template)) {
                        $cur_template = $module_template . '.php';
                    }
                    if ($cur_template != false) {
                        $cur_template = str_replace('..', '', $cur_template);
                        $cur_template = str_replace('.php.php', '.php', $cur_template);
                    }
                    foreach ($module_templates as $temp) {
                        if ($temp['layout_file'] == $cur_template) {
                            if (!isset($temp['screenshot'])) {
                                $temp['screenshot'] = '';
                            }
                            $current_template = array('name' => $temp['name'], 'screenshot' => $temp['screenshot'], 'layout_file' => $temp['layout_file']);
                        }
                    }
                    $layout_id_names[]=array_merge(array("module_id" => $module_id,"layout_field_id" => $layout_field_id,"module_name" => $current_template['name'],"faq_question_count" => @$faq_question_count??0, "default" => true),$faq??[]);
                    $faq=array("faq" => false);
                }else if($data_mw_title == 'FAQ'){
                    $faq_all_questions = (get_option('settings',$module_id)) ? get_option('settings',$module_id) : get_option('settings','faq');
                    $faq_question_count = 0;
                    if($faq_all_questions){
                        $faq_module_questions = array_filter(json_decode($faq_all_questions), function ($faq_question) use ($module_id) {
                            if(isset($faq_question->page_id) && isset($faq_question->module_id)){
                                if($faq_question->page_id == PAGE_ID && $faq_question->module_id == $module_id){
                                    return true;
                                }
                            }
                        });
                        $faq_question_count = count($faq_module_questions);
                    }
                    $layout_id_names[]=array("module_id" => $module_id,"module_name" => $data_mw_title,"faq_question_count" => $faq_question_count, "default" => true,"faq" => true);
                }
            }
        }
    }
?>
<span class="sidenav-open-close-for-mobile">
    <i class="fa fa-sliders" aria-hidden="true"></i>
</span>
<div class="fw-search-box">
    <input type="text" id="layout_search_key" placeholder="<?php _e('Search '); ?>" required>
</div>
<div class="fw-page-title-lists" id="sidebar_navigation_layout_information">
    <ul>
        <?php foreach($layout_id_names as  $layout_id_name):
            if( isset($layout_id_name["module_id"]) and !empty($layout_id_name["module_id"]) ){ ?>
            <li class='li-<?php print $layout_id_name["module_id"]; ?>'>
                <a href="#<?php print $layout_id_name["module_id"]; ?>">
                    <i class="<?php if(isset($layout_id_name["module_icon"])){ print $layout_id_name["module_icon"]; }else{ print "fa fa-bandcamp"; } ?>" aria-hidden="true"></i>
                    <p class='re-<?php print $layout_id_name["module_id"]; ?>'><?php print $layout_id_name["module_name"]; ?></p>
                </a>
                <?php if(isset($layout_id_name["faq_question_count"]) && $layout_id_name["faq_question_count"] != 0): ?>
                    <span class="qn" id="qn-<?php print $layout_id_name["module_id"]; ?>"><?php print $layout_id_name["faq_question_count"]; ?></span>
                <?php endif; ?>
                <?php if(is_admin()): ?>
                    <div class="sidebar_nav-option">
                        <span class="layout-edit-icon" onclick="sidebar_module_info_edit('<?php print $layout_id_name['module_id']; ?>','<?php print @$layout_id_name['faq']??false; ?>')"><i class="fa fa-pencil-square" aria-hidden="true"></i></span>
                        <span class="layout-delete-icon" onclick="sidebar_module_info_delete(`<?=PAGE_ID?>`,`<?=$layout_id_name['module_id']?>`,`<?=@$layout_id_name['layout_field_id']??null?>`)"><i class="fa fa-trash-o" aria-hidden="true"></i></span>
                    </div>
                    <?php endif; ?>
            </li>
        <?php
        if($layout_id_name["default"]){?>
            <script>
                $(document).ready(function(){
                    let ids = <?=json_encode([$layout_id_name["module_id"]])?>;
                    var headers = [];
                    // $.post("<?= url('/') ?>/api/v1/faq-count", { ids: ids }, (res) => {
                    //     if(res.success){
                    //         $.each(res.data, function( index, value ) {
                    //             if(value == 0){
                    //                 $("#qn-"+index).hide();
                    //             }else{
                    //                 $("#qn-"+index).text(value);
                    //             }
                    //         });
                    //     }
                    // });
                    $.each(ids, function( index, value ) {
                        let text = $("#"+value).find(".faq-heading-header").text().trim();
                        console.log(text);
                        if(text != ''){
                            $(".re-"+value).text(text)
                        }else{
                            text = $(".re-"+value).text();
                        }
                        headers.push(text);
                    });
                    $.post("<?= url('/') ?>/api/v1/save-header-faq-sidebar", { ids: ids, headers:headers, page_id: <?=PAGE_ID?> }, (res) => {
                    });
                });
            </script>
        <?php }
        } endforeach ?>
    </ul>
</div>
<script>
    $(document).ready(function(){
        $("#main-save-btn").click(function(){
            let ids = <?=json_encode($rename_ids)?>;
            var headers = [];
            $.each(ids, function( index, value ) {
                let text = $("#"+value).find(".faq-heading-header").text().trim();
                console.log(text);
                if(text != ''){
                    $(".re-"+value).text(text)
                }else{
                    text = $(".re-"+value).text();
                }
                headers.push(text);
            });

            $.post("<?= url('/') ?>/api/v1/save-header-faq-sidebar", { ids: ids, headers:headers, page_id: <?=PAGE_ID?> }, (res) => {

            });
        });
    });
</script>
