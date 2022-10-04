<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CustomField extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "custom_fields";
    protected $guarded = ['id'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Content::class, 'id', 'rel_id');
    }

    public function customFieldValue(): HasMany
    {
        return $this->hasMany(CustomFieldValue::class, 'custom_field_id', 'id');
    }

    
    public function get_a_config($template)
    {
        if ($template) {
        
            $dir = $template;
            
            $file = base_path('userfiles/templates/' . $dir . '/config.php');
            
            $temp = new \MicroweberPackages\Template\Template();
            
            if (isset($temp->template_config_cache[$file])) {
            return $temp->template_config_cache[$file];
            }
            
            if(is_file($file)) {
            include $file;
            if (isset($config)) {
            $temp->template_config_cache[$file] = $config;
            return $config;
            }
            
            return false;
            }
        }
    }
}
