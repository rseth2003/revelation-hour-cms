<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ServiceTime extends Model { const DAYS=['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday']; protected $fillable=['name','day','start_time','end_time','description','sort_order','is_published']; protected function casts():array{return ['sort_order'=>'integer','is_published'=>'boolean'];} public function getTimeRangeAttribute():string{$s=date('g:i A',strtotime($this->start_time));return $this->end_time?$s.' – '.date('g:i A',strtotime($this->end_time)):$s;} }
