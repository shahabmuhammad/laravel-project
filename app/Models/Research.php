<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Research extends Model implements HasMedia
{
    use InteractsWithMedia;



    protected $fillable = [
        'user_id',
        'title',
        'description',
        'keywords',
        'category_ids',
        'publisher_id',
        'type_id',
        'file_path',
        'slug',
        'status',
        'downloads',
        'views',
    ];

    protected $casts = [
        'category_ids' => 'array',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }



    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    /**
     * Get categories for this research based on category_ids JSON field
     * Note: This returns a collection, not a relationship
     */
    public function categories()
    {
        return Category::whereIn('id', $this->category_ids ?? [])->get();
    }

    public function getCategoryNamesAttribute()
    {
        return Category::whereIn('id', $this->category_ids ?? [])->pluck('name')->toArray();
    }
    public function bookmarkedByUsers()
    {
        return $this->belongsToMany(User::class, 'bookmarks')->withTimestamps();
    }


    public function registerMediaCollections(): void
    {
        // Store research files in private storage (storage/app/media)
        // Files cannot be accessed directly via URL - must go through controller
        $this->addMediaCollection('research_files')->useDisk('media_private');
    }
}
