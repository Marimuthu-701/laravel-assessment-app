<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class News extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'author',
        'title',
        'description',
        'content',
        'url',
        'url_to_image',
        'published_at',
    ];

    /**
     * Making news response array
     * 
     * @return <array>
     */
    public function toApi()
    {
        return [
            'id'     => $this->id,
            'author' => $this->author,
            'title'  => $this->title,
            'description' => $this->description,
            'content' => $this->content,
            'url' => $this->url,
            'url_to_image' => $this->url_to_image,
            'published_at' => Carbon::parse($this->published_at)->format(config('app.datetime_format')),
            'created_at' => Carbon::parse($this->created_at)->format(config('app.datetime_format')),
            'updated_at' => Carbon::parse($this->updated_at)->format(config('app.datetime_format'))         
        ];
    }
}
