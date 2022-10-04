<?php

namespace MicroweberPackages\App\Http\Controllers;

use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use MicroweberPackages\Content\Content;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Symfony\Component\VarDumper\Cloner\Data;
use Exception;

class OptinController extends Controller
{
    private $userToken;
    private $userPassToken;

    public function __construct()
    {
        $this->userToken = Config::get('microweber.userToken');
        $this->userPassToken = Config::get('microweber.userPassToken');
    }

    public function webhook_for_optin_form(Request $request)
    {
        try {
        $template_id = $request->template_id;
        $is_default = $request->is_default;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'userToken' => $this->userToken,
            'userPassToken' => $this->userPassToken
        ])->get('https://drm.software/api/droptienda/getTemplates');

        $data = json_decode($response->body(), true);
        $data = $data['data']['custom'] ?? null;

        if (isset($data)) {
            foreach ($data as $value) {
                if ($value['id'] == $template_id) {
                    $path = template_dir() . 'modules/layouts/templates/optin-form/skin-' . $template_id . '.php';
                    $fp = fopen($path, "w");

                    // php part write
                    fwrite($fp, "<?php" . PHP_EOL . PHP_EOL);
                    fwrite($fp, "/*" . PHP_EOL . PHP_EOL);
                    fwrite($fp, "type: layout" . PHP_EOL . PHP_EOL);
                    fwrite($fp, "name: " . $value['title'] . PHP_EOL . PHP_EOL);
                    fwrite($fp, "description: optinform" . PHP_EOL . PHP_EOL);
                    fwrite($fp, "position: 1" . PHP_EOL . PHP_EOL);
                    fwrite($fp, "*/" . PHP_EOL . PHP_EOL);
                    fwrite($fp, "?>" . PHP_EOL . PHP_EOL);
                    fwrite($fp, "<?php" . PHP_EOL);
                    fwrite($fp, "if (!" . "$" . "classes['padding_top']) {" . PHP_EOL);
                    fwrite($fp, "$" . "classes['padding_top'] = 'p-t-100';" . PHP_EOL);
                    fwrite($fp, "}" . PHP_EOL);
                    fwrite($fp, "if (!" . "$" . "classes['padding_bottom']) {" . PHP_EOL);
                    fwrite($fp, "$" . "classes['padding_bottom'] = 'p-b-100';" . PHP_EOL);
                    fwrite($fp, "}" . PHP_EOL);
                    fwrite($fp, "$" . "layout_classes = ' '" . " . " . "$" . "classes['padding_top'] " . "." . " ' ' " . "." . " $" . "classes['padding_bottom'] . ' ';" . PHP_EOL);
                    fwrite($fp, "?>" . PHP_EOL . PHP_EOL);

                    // style part write
                    fwrite($fp, "<style>" . PHP_EOL);
                    fwrite($fp, $value['css'] . PHP_EOL);
                    fwrite($fp, "</style>" . PHP_EOL);

                    // html part write
                    fwrite($fp, '<section class="section-optin-form-' . $template_id . '" field="layout_optin_form-' . $template_id . '" rel="module">' . PHP_EOL);
                    fwrite($fp, '<div class="container allow-drop">' . PHP_EOL);
                    fwrite($fp, $value['html'] . PHP_EOL);
                    fwrite($fp, "</div>" . PHP_EOL);
                    fwrite($fp, "</section>" . PHP_EOL . PHP_EOL);

                    // javascript part write
                    fwrite($fp, "<script>" . PHP_EOL);
                    fwrite($fp, "$('." . $value['from_class_name'] . "').on('submit', function(event) {" . PHP_EOL . PHP_EOL);
                    fwrite($fp, "event.preventDefault();" . PHP_EOL . PHP_EOL);
                    fwrite($fp, "var $" . "form = $(this)," . PHP_EOL);
                    fwrite($fp, "url = $" . "form.attr('action');" . PHP_EOL . PHP_EOL);
                    fwrite($fp, "var opln = {" . PHP_EOL);
                    fwrite($fp, "'name': $(this).find(\"" . ":input[name='opln[name]']\"" . ").val()," . PHP_EOL);
                    fwrite($fp, "'email': $(this).find(\"" . ":input[name='opln[email]']\"" . ").val()," . PHP_EOL);
                    fwrite($fp, "'phone': $(this).find(\"" . ":input[name='opln[phone]']\"" . ").val()" . PHP_EOL);
                    fwrite($fp, "};" . PHP_EOL . PHP_EOL);
                    fwrite($fp, "var posting = $.post(url, {" . PHP_EOL);
                    fwrite($fp, "opln: opln," . PHP_EOL);
                    fwrite($fp, "slug: '" . $value['from_class_name'] . "'," . PHP_EOL);
                    fwrite($fp, "type: 'dt_request'" . PHP_EOL);
                    fwrite($fp, "});" . PHP_EOL . PHP_EOL);
                    fwrite($fp, "posting.done(function(data) {" . PHP_EOL);
                    fwrite($fp, "$('.section-optin-form-" . $template_id . "').html(data['html']);" . PHP_EOL);
                    fwrite($fp, "mw.notification.success(data['message']);" . PHP_EOL);
                    fwrite($fp, "});" . PHP_EOL);
                    fwrite($fp, "posting.fail(function() {" . PHP_EOL);
                    fwrite($fp, "mw.notification.warning('failed');" . PHP_EOL);
                    fwrite($fp, "});" . PHP_EOL . PHP_EOL);
                    fwrite($fp, "});" . PHP_EOL);
                    fwrite($fp, "</script>");

                    fclose($fp);
                    
                    // layout image download
                    if (isset($value['thumbnail']) && $value['thumbnail'] != "null") {
                        $url = $value['thumbnail'];
                        $img_path = template_dir() . 'modules/layouts/templates/optin-form/skin-' . $template_id . '.jpg';;
                        file_put_contents($img_path, file_get_contents($url));
                    }
                }
            }

            return redirect()->to(site_url());
        } else {
            return redirect()->to(site_url());
        }
        } catch (Exception $e) {
            return redirect()->to(site_url());
        }
    }
}
