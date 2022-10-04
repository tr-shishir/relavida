<?php



if (!function_exists('dt_clone_clonePageWithAllLayouts')) {
    function dt_clone_clonePageWithAllLayouts($htmlContent,$newPageId,$oldPageId){
        $html =   $htmlContent;
        $dom = new DOMDocument();
        $dom->encoding = 'utf-8';
        @$dom->loadHTML(utf8_decode($html));
        $nodes = array();
        $nodes = $dom->getElementsByTagName("module");
        $layout_field_id = array();
        $new_layout_field_id = array();
        foreach ($nodes as $element)
        {
            $data_type=$element->getAttribute("data-type");
            if($data_type!='layouts')continue;
            $template_skin= str_replace('.php','',$element->getAttribute("template"));
            $template= str_replace('/','-', $template_skin);
            $id = $element->getAttribute("id");
            $layout_field_id[]='layout'.'-'.$template.'-'.$id;
            $new_layout_field_id[]='layout'.'-'.$template.'-clone'.$newPageId.'-'.$id;
            // $old_id_array[]= $id;
            // $new_id_array[] ='clone'.$newPageId.'-'.$id;
            $element->setAttribute("id",'clone'.$newPageId.'-'.$id);
        }
        $save_html = $dom->saveHTML();
        $extra_tag_remove = array(
            'tag-1' =>  '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">',
            'tag-2' => '<html><body>',
            'tag-3' => '</body></html>'
        );
        $new_string = str_replace($extra_tag_remove,'', $save_html);
        $new_string = dt_clone_clonelLayoutsModules($new_string,$newPageId,$oldPageId);
        $new_string = html_entity_decode($new_string);
        // $new_string = str_ireplace($old_id_array,$new_id_array, $html);
        $returnContent = array(
            "new_string" => $new_string,
            "old_layout_field_id" => $layout_field_id,
            "new_layout_field_id" => $new_layout_field_id
        );
        return    $returnContent;
    }
}

if (!function_exists('dt_clone_clonelLayoutsModules')) {
    function dt_clone_clonelLayoutsModules($htmlContent,$newPageId,$oldPageId){
        $html =   $htmlContent;
        $dom = new DOMDocument();
        $dom->encoding = 'utf-8';
        @$dom->loadHTML(utf8_decode($html));
        $nodes = array();
        $nodes = $dom->getElementsByTagName("module");
        $old_id_array=array();
        $new_id_array=array();
        foreach ($nodes as $element)
        {
            $data_type=$element->getAttribute("data-type");
            $id = $element->getAttribute("id");
            if($data_type=='btn'){
                $old_id_array[]= $id;
                $new_id_array[] =$id.'-clone';
                $oldid =  $id;
                $newid = $id.'-clone';
                $btn_content = DB::table('options')->where('option_group', $oldid)->get();
                if(!empty($btn_content->count())){
                    $btn_value = array(
                        "option_key" => $btn_content[0]->option_key,
                        "option_value" =>$btn_content[0]->option_value,
                        "option_group" => $newid,
                        "module" =>$btn_content[0]->module
                    );
                    DB::table('options')->insert($btn_value);
                }
            }else if($data_type=='pictures'){
                $old_id_array[]= $id;
                $new_id_array[] ='clone'.$newPageId.'-'.$id;
                $oldid = $id;
                $newid = 'clone'.$newPageId.'-'.$id;
                $picture_contents = DB::table('media')->where('rel_id', $oldid)->get();
                if(!empty($picture_contents->count())){
                    foreach($picture_contents as $picture_content){
                        $picture_value = array(
                            'created_by' => user_id(),
                            'edited_by' => user_id(),
                            'rel_type' =>$picture_content->rel_type,
                            'rel_id' =>$newid,
                            'position' => $picture_content->position,
                            'title' =>$picture_content->title,
                            'description' => $picture_content->description,
                            'embed_code' =>$picture_content->embed_code,
                            'filename' =>$picture_content->filename,
                            'image_options' => $picture_content->image_options,
                            'image_id' =>$picture_content->image_id
                        );
                        DB::table('media')->insert($picture_value);
                    }
                }
            }else if($data_type=='contact_form'){
                $old_id_array[]= $id;
                $new_id_array[] ='clone'.$newPageId.'-'.$id;
                $oldid = $id;
                $newid = 'clone'.$newPageId.'-'.$id;
                $btn_content = DB::table('options')->where('option_group', $oldid."-btn")->get();
                if(!empty($btn_content->count())){
                    $btn_value = array(
                        "option_key" => $btn_content[0]->option_key,
                        "option_value" =>$btn_content[0]->option_value,
                        "option_group" => $newid."-btn",
                        "module" =>$btn_content[0]->module
                    );
                    DB::table('options')->insert($btn_value);
                }
                $custome_contents = DB::table('custom_fields')->where('rel_id', $oldid)->get();
                if(!empty($custome_contents->count())){
                    foreach($custome_contents as $custome_content){
                        $custome_value = array(
                          "rel_type" => $custome_content->rel_type,
                          "rel_id" =>  $newid,
                          "position" => $custome_content->position,
                          "type" => $custome_content->type,
                          "name" => $custome_content->name,
                          "name_key" => $custome_content->name_key,
                          "placeholder" => $custome_content->placeholder,
                          "error_text" => $custome_content->error_text,
                          "created_by" => user_id(),
                          "edited_by" => user_id(),
                          "session_id" => $custome_content->session_id,
                          "options" => $custome_content->options,
                          "show_label" => $custome_content->show_label,
                          "is_active" => $custome_content->is_active,
                          "required" => $custome_content->required,
                          "copy_of_field" => $custome_content->copy_of_field
                        );
                        DB::table('custom_fields')->insert($custome_value);
                    }
                }
            }else if($data_type=='ticker_text'){
                $old_id_array[]= $id;
                $uId = 'clone-'.uniqid().'-'.$id;
                $new_id_array[] = $uId;
                $ticker_texts = DB::table('options')->where('option_group',$id)->get();
                if(isset($ticker_texts) && !empty($ticker_texts)){

                    foreach($ticker_texts as $ticker_text){

                        $ticker_text->option_group = $uId;
                        DB::table('options')->insert([
                            'option_key' => $ticker_text->option_key,
                            'option_value' => $ticker_text->option_value,
                            'option_group' => $ticker_text->option_group,
                        ]);
                    }

                }

            }else if($data_type=='pricing_card'){
                $contents = DB::table('content_fields')
                ->where('rel_type','content')
                ->where('rel_id',$oldPageId)
                ->where('field', 'like', 'table_specific_column_serial%')
                ->get()
                ->map(function( $query ) use ($newPageId)
                {
                    $q = (array)$query;
                    $q['rel_id']=$newPageId;
                    unset($q['id']);
                    return $q;
                })->toArray();
                DB::table('content_fields')->insert($contents);

            }else if($data_type=='slider'){
                $old_id_array[]= $id;
                $new_id_array[] ='clone-'.$id;
                $contents = DB::table('options')
                ->where('option_group',$id)
                ->where('option_key','settings')
                ->get()
                ->map(function( $query ) use ($id)
                {
                    $q = (array)$query;
                    $q['option_group']='clone-'.$id;
                    unset($q['id']);
                    return $q;
                })->toArray();
                DB::table('options')->insert($contents);

            }
        }
        $layout_new_string = str_ireplace($old_id_array,$new_id_array, $html);
        $layout_new_string = html_entity_decode($layout_new_string);
        return    $layout_new_string;
    }
}


if (!function_exists('dtCloneClonelSingleLayoutsModules')) {
    function dtCloneClonelSingleLayoutsModules($htmlContent,$oldLayoutId=null,$newLayoutId=null,$pageId=null){
        $html =   $htmlContent;
        $dom = new DOMDocument();
        $dom->encoding = 'utf-8';
        @$dom->loadHTML(utf8_decode($html));
        $nodes = array();
        $finder = new DomXPath($dom);
        $nodes = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), element)]");
        $old_id_array=array();
        $new_id_array=array();
        $active_site_template = mw()->app->option_manager->get('current_template', 'template');

        $live_edit_css_folder = userfiles_path().'css'.DS.$active_site_template;
        $custom_live_edit = $live_edit_css_folder.DS.'live_edit.css';
        if(file_exists($custom_live_edit)){
            $str = trim(file_get_contents($custom_live_edit));
        }else{
            $str = '';
        }

        foreach ($nodes as $element)
        {
            $data_type = $element->getAttribute("data-type");
            $id = $element->getAttribute("id");
            if($data_type!='ticker_text'){
                if(isset($id) && !empty($id)){
                    if(str_starts_with($id, 'element')){
                        $cssElements = CssElementKeys("#".$id);
                        $newId = $id."".uniqid();
                        if(isset($cssElements) && count($cssElements)>1){
                            if(isset($cssElements['selector']) && $cssElements['selector'] != 'default'){
                                $newIdSelect = $newId.' '.$cssElements['selector'];
                                unset($cssElements['selector']);
                                if(isset($cssElements) && !empty($cssElements)){
                                    $str .= "\n#".$newIdSelect." {\n".implode(';',$cssElements)."\n}";
                                }
                            }else{
                                unset($cssElements['selector']);
                                if(isset($cssElements) && !empty($cssElements)){
                                    $str .= "\n#".$newId." {\n".implode(';',$cssElements)."\n}";
                                }
                            }


                            // file_put_contents($custom_live_edit, $str);
                        }
                        $old_id_array[] = $id;
                        $new_id_array[] = $newId;
                    }else if(str_starts_with($id, 'mw')){
                        $cssElements = CssElementKeys("#".$id);
                        $newId = $id."".uniqid();
                        if(isset($cssElements) && count($cssElements)>1){
                            if(isset($cssElements['selector']) && $cssElements['selector'] != 'default'){
                                $newIdSelect = $newId.' '.$cssElements['selector'];
                                unset($cssElements['selector']);
                                if(isset($cssElements) && !empty($cssElements)){
                                    $str .= "\n#".$newIdSelect." {\n".implode(';',$cssElements)."\n}";
                                }
                            }else{
                                unset($cssElements['selector']);
                                if(isset($cssElements) && !empty($cssElements)){
                                    $str .= "\n#".$newId." {\n".implode(';',$cssElements)."\n}";
                                }
                            }


                            // file_put_contents($custom_live_edit, $str);
                        }
                        $old_id_array[] = $id;
                        $new_id_array[] = $newId;
                    }else if(str_starts_with($id, 'layouts')){
                        if(isset($newLayoutId)){
                            $cssElements = CssElementKeys("#".$id);
                            $newId = $newLayoutId;
                            if(isset($cssElements['selector']) && $cssElements['selector'] != 'default'){
                                $newIdSelect = $newId.' '.$cssElements['selector'];
                                unset($cssElements['selector']);
                                if(isset($cssElements) && !empty($cssElements)){
                                    $str .= "\n#".$newIdSelect." {\n".implode(';',$cssElements)."\n}";
                                }
                            }else{
                                unset($cssElements['selector']);
                                if(isset($cssElements) && !empty($cssElements)){
                                    $str .= "\n#".$newId." {\n".implode(';',$cssElements)."\n}";
                                }
                            }
                        }

                        if(str_contains($id, '-btn-')){
                            $last_word = strrpos($id, "-clone");
                            if(substr_count($id, "-clone") >= 1)
                            {
                                $variable =  "btn-".substr($id, 0, $last_word);
                            }
                            $cssElements = CssElementKeys("#".$variable);
                            $newId = "btn-".$id;
                            if(isset($cssElements['selector']) && $cssElements['selector'] != 'default'){
                                $newIdSelect = $newId;
                                unset($cssElements['selector']);
                                if(isset($cssElements) && !empty($cssElements)){
                                    $str .= "\n#".$newIdSelect." {\n".implode(';',$cssElements)."\n}";
                                }
                            }else{
                                unset($cssElements['selector']);
                                if(isset($cssElements) && !empty($cssElements)){
                                    $str .= "\n#".$newId." {\n".implode(';',$cssElements)."\n}";
                                }
                            }
                        }

                    }
                    if($pageId != null){
                        $id = str_replace('clone'.$pageId.'-' , '' ,$id);
                        $cssElements = CssElementKeys("#".$id);
                        $newId = 'clone'.$pageId.'-'.$id;
                        if(isset($cssElements['selector']) && $cssElements['selector'] != 'default'){
                            $newIdSelect = $newId.' '.$cssElements['selector'];
                            unset($cssElements['selector']);
                            if(isset($cssElements) && !empty($cssElements)){
                                $str .= "\n#".$newIdSelect." {\n".implode(';',$cssElements)."\n}";
                            }
                        }else{
                            unset($cssElements['selector']);
                            if(isset($cssElements) && !empty($cssElements)){
                                $str .= "\n#".$newId." {\n".implode(';',$cssElements)."\n}";
                            }
                        }
                    }

                }
            }else{

                if(isset($id) && !empty($id)){
                    $idArray = explode('-',ltrim($id, 'clone-'));
                    $uId = $idArray[0];
                    unset($idArray[0]);
                    $id = implode('-',$idArray);
                    $cssElements = CssElementKeys("#". $id);
                    $newNid = $id;
                    if(isset($cssElements) && !empty($cssElements)){
                        if(isset($cssElements['selector']) && $cssElements['selector'] != 'default'){
                            $newIdSelect = 'clone-'.$uId.'-'.$newNid.' '.str_replace('typed-', 'typed-clone-'.$uId.'-', $cssElements['selector']);
                            unset($cssElements['selector']);
                            if(isset($cssElements) && !empty($cssElements)){
                                $str .= "\n#".$newIdSelect." {\n".implode(';',$cssElements)."\n}";
                            }
                        }else{
                            unset($cssElements['selector']);
                            if(isset($cssElements) && !empty($cssElements)){
                                $str .= "\n#".$newNid." {\n".implode(';',$cssElements)."\n}";
                            }
                        }
                        // file_put_contents($custom_live_edit, $str);
                    }
                    $old_id_array[] = $id;
                    $new_id_array[] = $newNid;
                }
            }
        }
        $layout_new_string = str_ireplace($old_id_array,$new_id_array, $html);
        $layout_new_string = dtCloneClonelSingleLayouts($layout_new_string,$str,$oldLayoutId,$newLayoutId);
        $layout_new_string = html_entity_decode($layout_new_string);
        return $layout_new_string;
    }
}

if (!function_exists('dtCloneClonelSingleLayouts')) {
    function dtCloneClonelSingleLayouts($htmlContent,$str,$oldLayoutId=null,$newLayoutId=null){

        $html =   $htmlContent;
        $dom1 = new DOMDocument();

        $dom1->encoding = 'utf-8';
        @$dom1->loadHTML(utf8_decode($html));
        $nodes = array();
        $finder1 = new DomXPath($dom1);
        $nodes1 = $finder1->query("//*[contains(concat(' ', normalize-space(@class), ' '), edit)]");
        $old_id_array=array();
        $new_id_array=array();
        $active_site_template = mw()->app->option_manager->get('current_template', 'template');

        $live_edit_css_folder = userfiles_path().'css'.DS.$active_site_template;
        $custom_live_edit = $live_edit_css_folder.DS.'live_edit.css';

        if(isset($oldLayoutId) && !empty($oldLayoutId)){
            $cssElements = CssElementKeys('.edit[field="'.$oldLayoutId.'"][rel="module"]');
            if(isset($cssElements) && !empty($cssElements)){
                unset($cssElements['selector']);
                if(isset($cssElements) && !empty($cssElements)){
                    $str .= "\n".'.edit[field="'.$newLayoutId.'"][rel="module"] {'."\n".implode(';',$cssElements)."\n".'}';
                }
            }
        }
        if(file_exists($custom_live_edit)){
            file_put_contents($custom_live_edit, $str);
        }
        $layout_new_string = $html;
        return $layout_new_string;
    }
}


if (!function_exists('dt_clone_copySingleLayout')) {
    function dt_clone_copySingleLayout($layout_info){
        $oldcontent = DB::table('content_fields')->where('rel_id',$layout_info['single_layout_copy_page_id'])->where('field',$layout_info['single_layout_copy_field_name'])->first();
        $html = $oldcontent->value;
        $dom = new DOMDocument();
        $dom->encoding = 'utf-8';
        @$dom->loadHTML(utf8_decode($html));

        $nodes = array();
        $nodes = $dom->getElementsByTagName("module");
        $temp_value = null;

        for($i=0; $i < count($nodes) ; $i++){
            $data_type=$nodes->item($i)->getAttribute("data-type");
            if($data_type!='layouts')continue;
            $id = $nodes->item($i)->getAttribute("id");
            if($id==$layout_info['single_layout_copy_module_id']){
                $template_skin= str_replace('.php','',$nodes->item($i)->getAttribute("template"));
                $template= str_replace('/','-', $template_skin);
                $layout_field_id='layout'.'-'.$template.'-'.$id;
                $temp_value = $nodes->item($i)->cloneNode();
            }
        }
        $old_layout = array(
            'clone_layout' =>  $temp_value,
            'layout_field_id' => $layout_field_id
        );

        return  @$old_layout;
    }
}


if (!function_exists('dt_clone_setModulePosition')) {
    function dt_clone_setModulePosition($layout_info){

        $oldcontent = DB::table('content_fields')->where('rel_id',$layout_info['single_layout_paste_page_id'])->where('field',$layout_info['single_layout_paste_field_name'])->first();
        // dd($oldcontent);
        $html = @$oldcontent->value;
        $dom = new DOMDocument();
        $dom->encoding = 'utf-8';
        @$dom->loadHTML(utf8_decode($html));

        $nodes = array();
        $nodes = $dom->getElementsByTagName("module");
        $copy_layout_field_id = null;
        $new_layout_id = null;
        $rand_id = rand();
        if(dt_clone_copySingleLayout($layout_info)){
            $old_layout = dt_clone_copySingleLayout($layout_info);
            $old_layout_field_id = $old_layout['layout_field_id'];
            $temp_value = $dom->importNode( $old_layout['clone_layout'], true);
        }else{
            $temp_value = null;
            $old_layout_field_id = null;
        }

        for($i=0; $i < count($nodes) ; $i++){
            $data_type=$nodes->item($i)->getAttribute("data-type");
            if($data_type!='layouts')continue;
            $id = $nodes->item($i)->getAttribute("id");
            if($id==$layout_info['single_layout_paste_module_id']){
                $new_layout_id = 'clone'.$rand_id.'-'.$layout_info['single_layout_copy_module_id'];
                $temp_value->setAttribute("id", $new_layout_id);
                $temp_value->setAttribute("parent-module-id", $new_layout_id);

                // dd($nodes->item($i)->nextSibling);
                if($layout_info['paste_position'] == 'up'){
                    $nodes->item($i)->parentNode->insertBefore($temp_value, $nodes->item($i));
                }else{
                    if($nodes->item($i)->nextSibling === null) {
                        $nodes->item($i)->parentNode->appendChild($temp_value);
                    } else {
                        $nodes->item($i)->parentNode->insertBefore($temp_value, $nodes->item($i)->nextSibling);
                    }
                }
                $save_html = $dom->saveHTML();
                $extra_tag_remove = array(
                    'tag-1' =>  '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">',
                    'tag-2' => '<html><body>',
                    'tag-3' => '</body></html>'
                );
                $new_string = str_replace($extra_tag_remove,'', $save_html);
                $new_string = dtCloneClonelSingleLayoutsModules($new_string,$old_layout_field_id,$new_layout_id);
                $new_string = html_entity_decode($new_string);

                $returnContent = array(
                    "new_string" => $new_string,
                    "old_layout_field_id" => $old_layout_field_id,
                    "new_layout_id" => $new_layout_id,
                    "rand_id" => $rand_id
                );
                return   $returnContent;
            }
        }

    }
}

if (!function_exists('dt_clone_setModuleContent')) {
    function dt_clone_setModuleContent($module_position){

        $dom = new DOMDocument();
        $dom->encoding = 'utf-8';
        @$dom->loadHTML(utf8_decode($module_position['new_string']));
        $nodes = array();
        $nodes = $dom->getElementsByTagName("module");

        $old_layout_field_id = $module_position['old_layout_field_id'];
        $new_layout_field_id = null;
        foreach ($nodes as $element)
        {
            $data_type=$element->getAttribute("data-type");
            if($data_type!='layouts')continue;
            $id = $element->getAttribute("id");
            if($id == $module_position['new_layout_id']){
                $template_skin= str_replace('.php','',$element->getAttribute("template"));
                $template= str_replace('/','-', $template_skin);
                $new_layout_field_id='layout'.'-'.$template.'-'.$module_position['new_layout_id'];
            }
        }

        $layout_field_value = DB::table('content_fields')->where('field', $old_layout_field_id )->first();
        if(!empty($layout_field_value)){
            $layout_string = dt_clone_clonelLayoutsModules($layout_field_value->value,$module_position['rand_id'],0);
            $layout_string = dtCloneClonelSingleLayoutsModules($layout_string,$old_layout_field_id,$new_layout_field_id);
            $layout_string = html_entity_decode($layout_string);
            $fieldcontent = array(
                "created_by" => user_id(),
                "edited_by" => user_id(),
                "rel_type" =>  $layout_field_value->rel_type,
                "rel_id" => 0,
                "field" =>  $new_layout_field_id,
                "value" =>   $layout_string
            );
            DB::table('content_fields')->insert($fieldcontent);
        }
    }
}


//parent field name get
if (!function_exists('dt_clone_getParentFieldName')) {
    function dt_clone_getParentFieldName($page_id){
        $template =  new \MicroweberPackages\Template\Template;
        $render_file_path = $template->get_layout(get_content_by_id($page_id));
        $dom = new DOMDocument();
        @$dom->loadHTML(@file_get_contents($render_file_path));
        $nodes = array();
        $nodes = $dom->getElementsByTagName("div");
        $page_field_names = null;
        foreach ($nodes as $element)
        {
            //if(db_get('table=content_fields&field='.$element->getAttribute("field").'&rel_id='.$page_id.'&single=true')){
            $page_field_names[] = $element->getAttribute("field");
            //}
        }
        return $page_field_names;
    }
}


