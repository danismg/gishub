<?php

namespace App\Models;

use App\Enums\ReportStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_name',
        'tanggal_audit',
        'tanggal_terbit',
        'location',
        'laboratorium',
        'service_id',
        'status',
        'event_id',
    ];

    public function docAudits(): HasMany
    {
        return $this->hasMany(DocAudit::class);
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Update status report berdasarkan status docAudits terkait
     */
    public function updateStatus()
    {
        $docAudits = $this->docAudits()->pluck('status')->toArray();

        if (empty($docAudits)) {
            $this->update(['status' => ReportStatus::New->value]);
            return;
        }

        if (in_array(ReportStatus::Pending->value, $docAudits)) {
            $this->update(['status' => ReportStatus::Processing->value]);
        } elseif (in_array(ReportStatus::Rejected->value, $docAudits)) {
            $this->update(['status' => ReportStatus::Rejected->value]);
        } elseif (count(array_unique($docAudits)) === 1 && $docAudits[0] === ReportStatus::Approved->value) {
            $this->update(['status' => ReportStatus::Approved->value]);
        }
    }
}
