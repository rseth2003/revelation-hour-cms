<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class CommunicationRecipient extends Model {
 use HasFactory;
 protected $fillable=['communication_message_id','member_id','member_name','destination','status','failure_reason','delivered_at'];
 protected function casts(): array { return ['delivered_at'=>'datetime']; }
 public function message(){ return $this->belongsTo(CommunicationMessage::class,'communication_message_id'); }
 public function member(){ return $this->belongsTo(Member::class); }
}
