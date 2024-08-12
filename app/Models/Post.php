<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Post extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    protected $guarded = [];
    const POST_IMAGE = "post_image";
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function commentsWithUsers()
    {
        return $this->hasMany(Comment::class)->with("User");
    }
    public function user()
    {
        return $this->mourphTo();
    }
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::POST_IMAGE)
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion("default")
                    ->keepOriginalImageFormat();
            });
    }

    public function image()
    {
        return $this->morphOne(Media::class,"model")->where("collection_name",self::POST_IMAGE);
    }
}
