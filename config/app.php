<?php
return [
    'base_url' => 'https://search.ipaustralia.gov.au',
    'main_page' => 'trademarks/search/advanced',
    'search_url' => 'trademarks/search/doSearch',
    'cache_lifetime' => 600,
    'cache_dir' => 'runtime/cache',
    'selectors' => [
        'csrf_token' => 'input[name="_csrf"]',
        'result_count' => '.number.qa-count',
        'pagination_links' => '.col.c-50.no-padding.right-aligned .pagination-buttons a',
        'table_result' => '#resultsTable'
    ],
];
