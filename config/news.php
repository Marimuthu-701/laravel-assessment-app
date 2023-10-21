<?php

return [
    /*
    |-------------------------------------------------------------------
    | News feed api credentials details
    |-------------------------------------------------------------------
    | New feed api key and api endpoint details below
    |
     */

    'api_key' => env('NEWS_API_KEY', 'd0ad12c034e049b8a4c942caa0258a96'),

    'api_enpoint' => env('NEWS_ENDPOINT', 'https://newsapi.org/v2/top-headlines'),

    'country' => env('NEWS_COUNTRY', 'us'),

];
