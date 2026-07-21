<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class CommunicationMessage extends Model {
 use HasFactory;
 protected $fillable=['created_by','template_id','title','channel','subject','body','audience_type','campus_id','ministry_id','membership_type','membership_status','member_ids','status','scheduled_for','recipient_count','sent_count','failed_count','prepared_at','sent_at','notes'];
 protected function casts(): array { return ['member_ids'=>'array','scheduled_for'=>'datetime','prepared_at'=>'datetime','sent_at'=>'datetime']; }
 public function recipients(){ return $this->hasMany(CommunicationRecipient::class); }
 public function campus(){ return $this->belongsTo(Campus::class); }
 public function ministry(){ return $this->belongsTo(Ministry::class); }
}
