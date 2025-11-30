<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'content',
        'image_path',
        'tags',
        'recommended_state',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tags' => 'array',
        ];
    }

    /**
     * Set the tags attribute (convert comma-separated string to array).
     */
    public function setTagsAttribute($value): void
    {
        if (is_string($value)) {
            $tags = array_map('trim', explode(',', $value));
            $tags = array_filter($tags); // Remove empty values
            $this->attributes['tags'] = json_encode(array_values($tags));
        } else {
            $this->attributes['tags'] = json_encode($value);
        }
    }
}

