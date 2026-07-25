<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
class Leader extends Model { protected $fillable=['name','role','department','biography','photo_path','phone','email','facebook_url','instagram_url','x_url','sort_order','is_published']; protected function casts():array{return ['sort_order'=>'integer','is_published'=>'boolean'];} public function getPhotoUrlAttribute():?string{return $this->photo_path?Storage::disk('public')->url($this->photo_path):null;} }
