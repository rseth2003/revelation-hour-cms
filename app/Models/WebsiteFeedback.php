<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class WebsiteFeedback extends Model {
    protected $table='website_feedback';
    protected $fillable=['name','email','rating','category','message','status','admin_notes','approved_for_display'];
    protected function casts(): array { return ['rating'=>'integer','approved_for_display'=>'boolean']; }
}
