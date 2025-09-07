<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildMoodEvaluation extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function child()
    {
        return $this->belongsTo(Child::class);
    }
    public function getMoodLabelAttribute()
    {
        return [
            'angry' => 'غاضب',
            'happy' => 'سعيد',
            'unsure' => 'غير متأكد',
            'anxious' => 'قلق',
            'sad' => 'حزين'
        ][$this->mood] ?? '';
    }

    public function getParticipationLabelAttribute()
    {
        return [
            'excellent' => 'ممتازة',
            'good' => 'جيدة',
            'average' => 'متوسطة',
            'poor' => 'ضعيفة'
        ][$this->participation] ?? '';
    }

    public function getActivityCompletionLabelAttribute()
    {
        return [
            'completed' => 'مكتمل',
            'partial' => 'جزئي',
            'not_completed' => 'غير مكتمل'
        ][$this->activity_completion] ?? '';
    }

    public function exercise()
{
    return $this->belongsTo(Exercise::class);
}
}
