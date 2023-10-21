<?php

namespace App\Services;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class NewsService extends Controller
{
    /**
     * Set api endpoint url
     *
     * @var <string>
     */
    protected $api_endpoint;

    /**
     * Set API_KEY
     *
     * @var <string>
     */
    protected $api_key;

    /**
     * Set API Country
     *
     * @var <string>
     */
    protected $api_country;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->api_endpoint = config('news.api_enpoint');
        $this->api_key = config('news.api_key');
        $this->api_country = config('news.country');
    }

    /**
     * Get top-headlines list API
     *
     * @return <mixed>
     */
    public function getTopHeadLines($is_status = false): mixed
    {
        $url_maping = $this->api_endpoint.'?country='.$this->api_country.'&apiKey='.$this->api_key.'&page_size=50';
        $response = Http::get($url_maping);
        if ($is_status) {
            return $response->status();
        }

        return $response->json();
    }
}
