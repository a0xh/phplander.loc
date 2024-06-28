<?php

namespace App\Domain\Category\Domain;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Application\Enums\StatusEnum;
use Cviebrock\EloquentSluggable\Sluggable;

class Category extends Model
{
    protected $table = 'categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'description',
        'keywords',
        'type',
        'status',
        'media',
        'category_id',
        'user_id',
        'data'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'title' => 'string',
            'slug' => 'string',
            'keywords' => 'string',
            'type' => 'string',
            'status' => StatusEnum::class,
            'media' => 'string',
            'category_id' => 'int',
            'user_id' => 'int',
            'data' => 'array',
        ];
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
    
    protected function data(): Attribute
    {
        return Attribute::make(
            get: fn ($data) => json_decode($data),
            set: fn ($data) => json_encode($data),
        );
    }

    protected function category_id(): Attribute
    {
        return Attribute::make(
            set: fn ($category_id) => ($category_id == 0) ? null : $category_id
        );
    }

    public function categories(): HasMany
    {
        return $this->hasMany(\App\Domain\Category\Domain\Category::class);
    }

    public function childrenCategories(): HasMany
    {
        return $this->hasMany(self::class)->with('categories');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Domain\User\Domain\User::class);
    }
}