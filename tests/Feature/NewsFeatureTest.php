<?php

use App\Models\NewsItem;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows live news entries on the public news page', function () {
    NewsItem::create([
        'title' => 'Career Track enrollment is now open',
        'category' => 'announcement',
        'content' => 'Applications for the next cohort are now open.',
        'is_featured' => true,
        'published_at' => now(),
    ]);

    $response = $this->get('/news');

    $response->assertOk();
    $response->assertSee('Career Track enrollment is now open');
});
