<?php

namespace App\Console\Commands;

use App\Models\News;
use App\Services\NewsService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ImportNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-news';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get top headlines from newsapi';

    /**
     * Execute the console command.
     */
    public function handle(NewsService $newsservice)
    {
        $is_get_all = true;
        $last_publish_news = News::select('published_at')->orderBy('published_at', 'DESC')->first();
        if ($last_publish_news) {
            $ls_pub_date = Carbon::parse($last_publish_news->published_at);
            $is_get_all = false;
        }
        if ($newsservice->getTopHeadLines($is_status = true) == 200) {
            $articles = $newsservice->getTopHeadLines()['articles'];
            if (count($articles) > 0) {
                foreach ($articles as $key => $article) {
                    $publish_date = Carbon::parse($article['publishedAt']);
                    // Check lastest published list
                    if (! $is_get_all && $publish_date->lte($ls_pub_date)) {
                        break;
                    }
                    $news = [
                        'author' => $article['author'],
                        'title' => $article['title'],
                        'description' => $article['description'],
                        'url' => $article['url'],
                        'url_to_image' => $article['urlToImage'],
                        'published_at' => $publish_date,
                    ];
                    $create_news = News::create($news);
                    $this->info('News was imported our table, news id is: '.$create_news->id."\n");
                }
            } else {
                $this->info('News not found...');
            }
        }
    }
}
