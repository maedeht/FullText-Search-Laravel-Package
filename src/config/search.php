<?php

return [
    /*** This is a sample config file for searching
    'tables' => [
        'primary' => 'products', // primary search table
        'joins' => [ // other search joined tables
            'tags' => [ // table one
                'product_id' => [ // table one's reference foreign key
                    'column' => 'id', // table one's reference primary key
                    'table' => 'products' // table one's reference
                ]
            ],
            'groups' => [ // table two
                'product_id' => [ // table two's reference foreign key
                    'column' => 'id', // table two's reference primary key
                    'table' => 'products' // table two's reference
                ]
            ]
        ]
    ],
    /*** tables fields for searching on
    'fields' => [
        'products' => [ // table xxx - for columns will be added here a fulltext index should be created
            'slug', // table xxx column
            'name', // table xxx column
        ],
        'groups' => [ // table yyy - - for columns will be added here a fulltext index should be created
            'slug', // table yyy column
            'name', // table yyy column
        ],
        'tags' => [ // table zzz - - for columns will be added here a fulltext index should be created
            'name' // table zzz column
        ]
    ]
    */
];