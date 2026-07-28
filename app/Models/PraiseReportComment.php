<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PraiseReportComment extends Model
{
    use HasFactory;
    protected $fillable = ['praise_report_id','name','email','message','status','ip_hash'];
    protected $hidden = ['email','ip_hash'];
    public function praiseReport(): BelongsTo { return $this->belongsTo(PraiseReport::class); }
}
