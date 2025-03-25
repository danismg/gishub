<?php

namespace App\Models;

use App\Enums\ReportStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocAudit extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'persyaratan',
        'noted',
        'file',
        'status',
        'report_id',
    ];

    protected static function booted()
    {
        static::created(function ($docAudit) {
            $docAudit->report?->updateStatus();
        });

        static::updated(function ($docAudit) {
            $docAudit->report?->updateStatus();
        });

        static::deleted(function ($docAudit) {
            $docAudit->report?->updateStatus();
        });
    }

    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }
}
