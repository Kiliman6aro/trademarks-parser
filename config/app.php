<?php
return [
    'url' => [
        'base_url' => 'https://search.ipaustralia.gov.au',
        'main_page' => 'trademarks/search/advanced',
        'search_url' => 'trademarks/search/doSearch',
    ],
    'cache' => [
        'cache_lifetime' => 600, //10 minutes
        'cache_dir' => 'runtime/cache',
    ],
    'parser' => [
        'search_form' => [
            'csrf_field_selector' => 'input[name="_csrf"]',
            'search_field' => 'wv[0]'
        ],
        'result_page' => [
            'rows_selector' => '#resultsTable tbody tr',
            'count_selector' => '.number.qa-count',
            'pagination_links_selector' => '.col.c-50.no-padding.right-aligned .pagination-buttons a',
        ],
        'table' => [
            'rows_selector' => '#resultsTable tbody tr',
            'number_selector' => 'td.number',
            'status_selector' => 'td.status',
            'logo_selector' => 'td.trademark.image img',
            'name_selector' => 'td.trademark.words',
            'class_selector' => 'td.classes',
            'link_selector' => 'td.number a'
        ]
    ]
];
