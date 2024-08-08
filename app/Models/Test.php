<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Test extends Model implements HasMedia
{
    protected $guarded = [];
    use HasFactory;
    use InteractsWithMedia;

    public function registerMediaConversions(Media $media = null): void
{
    $this
        ->addMediaConversion('preview')
        ->fit(Manipulations::FIT_CROP, 300, 300)
        ->nonQueued();
}

    public function Questions()
    {
        return $this->hasMany(Question::class);
    }

    public function scopeBeginnerTest($query)
    {
        return $query->where('is_beginner',true);
    }

    public static function getBeginnerTestId()
    {
        return self::beginnerTest()->pluck('id')->first();
    }

}
