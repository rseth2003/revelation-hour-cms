<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PraiseReportReaction extends Model
{
    use HasFactory;

    protected $fillable = ['praise_report_id', 'reaction', 'ip_hash'];
    protected $hidden = ['ip_hash'];

    public function praiseReport(): BelongsTo
    {
        return $this->belongsTo(PraiseReport::class);
    }
}
