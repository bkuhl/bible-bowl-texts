<?php

require_once __DIR__ . '/../vendor/autoload.php';

use BKuhl\ScriptureRanges\ScriptureRangeBuilder;
use BKuhl\ScriptureRanges\ChapterRange;
use BKuhl\BibleCSB\Book\FirstSamuel;
use BKuhl\BibleBowlTexts\SeasonFactory;

$dataDir = __DIR__ . '/../data';
$beginnerDir = $dataDir . '/beginner';

if (!is_dir($dataDir)) {
    mkdir($dataDir, 0755, true);
}

if (!is_dir($beginnerDir)) {
    mkdir($beginnerDir, 0755, true);
}

$samuelBook = new FirstSamuel();

// Team Program Data (Full Coverage)
$teamEntireTextCollection = (new ScriptureRangeBuilder())
    ->with($samuelBook, ChapterRange::range(16, 24))
    ->with($samuelBook, ChapterRange::range(26, 31))
    ->build();

$teamBlock1Collection = (new ScriptureRangeBuilder())
    ->with($samuelBook, ChapterRange::range(16, 19))
    ->build();

$teamBlock2Collection = (new ScriptureRangeBuilder())
    ->with($samuelBook, ChapterRange::range(20, 24))
    ->build();

$teamBlock3Collection = (new ScriptureRangeBuilder())
    ->with($samuelBook, ChapterRange::range(26, 31))
    ->build();

// Beginner Program Data (Specific Verse Ranges)
$beginnerEntireTextCollection = (new ScriptureRangeBuilder())
    ->with($samuelBook, 16, null, null, 13)      // 1 Sam 16:1-13
    ->with($samuelBook, 17, null, null, 58)        // 1 Sam 17:1-58
    ->with($samuelBook, 18, null, null, 9)         // 1 Sam 18:1-9
    ->with($samuelBook, 26, null, null, 25)        // 1 Sam 26:1-25
    ->with($samuelBook, 27, null, null, 12)         // 1 Sam 27:1-12
    ->with($samuelBook, 29, null, null, 11)        // 1 Sam 29:1-11
    ->with($samuelBook, 30, null, null, 15)        // 1 Sam 30:1-15
    ->with($samuelBook, 31, null, null, 6)         // 1 Sam 31:1-6
    ->build();

$beginnerBlock1Collection = (new ScriptureRangeBuilder())
    ->with($samuelBook, 16, null, null, 13)        // 1 Sam 16:1-13
    ->with($samuelBook, 17, null, null, 58)        // 1 Sam 17:1-58
    ->with($samuelBook, 18, null, null, 9)        // 1 Sam 18:1-9
    ->build();

$beginnerBlock2Collection = (new ScriptureRangeBuilder())
    ->with($samuelBook, 26, null, null, 25)       // 1 Sam 26:1-25
    ->with($samuelBook, 27, null, null, 12)       // 1 Sam 27:1-12
    ->with($samuelBook, 29, null, null, 11)       // 1 Sam 29:1-11
    ->with($samuelBook, 30, null, null, 15)       // 1 Sam 30:1-15
    ->with($samuelBook, 31, null, null, 6)        // 1 Sam 31:1-6
    ->build();

// Team Program Season Data
$teamSeasonData = [
    'id' => '16',
    'name' => '2025 Fall',
    'program' => 'teen',
    'text' => $teamEntireTextCollection->toArray(),
    'blocks' => [
        '1' => $teamBlock1Collection->toArray(),
        '2' => $teamBlock2Collection->toArray(),
        '3' => $teamBlock3Collection->toArray(),
    ],
    'memory_verses' => [
        'books' => [
            9 => [ // 1 Samuel
                'chapters' => [
                    16 => [
                        'verses' => [
                            1 => ['lead_in' => 'what the LORD said to Samuel', 'split_after_word' => 27],
                            7 => ['lead_in' => 'about what the LORD sees', 'split_after_word' => 23],
                            13 => ['lead_in' => 'about when Samuel anointed David', 'split_after_word' => 19],
                            18 => ['lead_in' => 'what one of the young men said about David', 'split_after_word' => 24],
                        ]
                    ],
                    17 => [
                        'verses' => [
                            26 => ['lead_in' => 'when David spoke to the men who were standing with him', 'split_after_word' => 33],
                            36 => ['lead_in' => 'what David said this uncircumcised Philistine will be', 'split_after_word' => 19],
                            37 => ['lead_in' => 'what David said about the LORD rescuing him', 'split_after_word' => 26],
                            45 => ['lead_in' => 'about how David said he came against the Philistine', 'split_after_word' => 22],
                            46 => ['lead_in' => 'what David told the Philistine would happen today', 'split_after_word' => 24],
                            47 => ['lead_in' => 'what David said this whole assembly will know', 'split_after_word' => 22],
                            50 => ['lead_in' => 'about how David defeated the Philistine', 'split_after_word' => 11],
                        ]
                    ],
                    18 => [
                        'verses' => [
                            12 => ['lead_in' => 'about Saul being afraid of David', 'split_after_word' => 5],
                            30 => ['lead_in' => 'about David being successful', 'split_after_word' => 10],
                        ]
                    ],
                    19 => [
                        'verses' => [
                            4 => ['lead_in' => 'when Jonathan spoke well of David', 'split_after_word' => 29],
                            5 => ['lead_in' => 'what Jonathan said David did', 'split_after_word' => 30],
                        ]
                    ],
                    20 => [
                        'verses' => [
                            42 => ['lead_in' => 'how Jonathan told David to go', 'split_after_word' => 23],
                        ]
                    ],
                    22 => [
                        'verses' => [
                            2 => ['lead_in' => 'about who rallied around David', 'split_after_word' => 15],
                            14 => ['lead_in' => 'what Ahimelech said about David', 'split_after_word' => 17],
                            17 => ['lead_in' => 'about what the king\'s servants would not do', 'split_after_word' => 23],
                        ]
                    ],
                    23 => [
                        'verses' => [
                            16 => ['lead_in' => 'about when Jonathan encouraged David', 'split_after_word' => 9],
                        ]
                    ],
                    24 => [
                        'verses' => [
                            5 => ['lead_in' => 'about David\'s conscience', 'split_after_word' => 5],
                            6 => ['lead_in' => 'about what David said he would never do', 'split_after_word' => 24],
                            10 => ['lead_in' => 'about what someone advised David to do', 'split_after_word' => 23],
                            12 => ['lead_in' => 'what David said for the LORD to do to Saul', 'split_after_word' => 8],
                            13 => ['lead_in' => 'about the old proverb', 'split_after_word' => 10],
                            14 => ['lead_in' => 'what David asked Saul chasing after', 'split_after_word' => 9],
                            17 => ['lead_in' => 'what Saul said after he wept aloud', 'split_after_word' => 10],
                            19 => ['lead_in' => 'what Saul said about the LORD repaying', 'split_after_word' => 12],
                            20 => ['lead_in' => 'what Saul said he knew for certain', 'split_after_word' => 10],
                            21 => ['lead_in' => 'what Saul told David to swear to him', 'split_after_word' => 18],
                        ]
                    ],
                    26 => [
                        'verses' => [
                            9 => ['lead_in' => 'what David told Abishai not do to', 'split_after_word' => 8],
                            10 => ['lead_in' => 'what David told Abishai would happen to Saul', 'split_after_word' => 16],
                            11 => ['lead_in' => 'what David told Abishai he would never do', 'split_after_word' => 21],
                            19 => ['lead_in' => 'when David said people should be cursed', 'split_after_word' => 34],
                            21 => ['lead_in' => 'when Saul said he had sinned', 'split_after_word' => 19],
                            23 => ['lead_in' => 'about what David wasn\'t willing to do', 'split_after_word' => 13],
                            24 => ['lead_in' => 'what David said to Saul about life being valuable', 'split_after_word' => 8],
                            25 => ['lead_in' => 'when Saul said David was blessed', 'split_after_word' => 22],
                        ]
                    ],
                    28 => [
                        'verses' => [
                            3 => ['lead_in' => 'about when Samuel had died', 'split_after_word' => 23],
                            16 => ['lead_in' => 'what Samuel asked Saul', 'split_after_word' => 13],
                            17 => ['lead_in' => 'what Samuel told Saul the LORD had done', 'split_after_word' => 13],
                            18 => ['lead_in' => 'what Samuel told Saul he had not done', 'split_after_word' => 21],
                            19 => ['lead_in' => 'what Samuel told Saul would happen to him', 'split_after_word' => 16],
                        ]
                    ],
                    30 => [
                        'verses' => [
                            6 => ['lead_in' => 'about when the troops were all very bitter', 'split_after_word' => 17],
                            23 => ['lead_in' => 'what David said to corrupt and worthless men', 'split_after_word' => 20],
                        ]
                    ],
                ]
            ]
        ]
    ]
];

// Beginner Program Season Data
$beginnerSeasonData = [
    'id' => '16',
    'name' => '2025 Fall',
    'program' => 'beginner',
    'text' => $beginnerEntireTextCollection->toArray(),
    'blocks' => [
        '1' => $beginnerBlock1Collection->toArray(),
        '2' => $beginnerBlock2Collection->toArray(),
    ],
    'memory_verses' => [
        'books' => [
            9 => [ // 1 Samuel
                'chapters' => [
                    16 => [
                        'verses' => [
                            7 => ['lead_in' => 'about what the LORD sees', 'split_after_word' => 23],
                            13 => ['lead_in' => 'about when Samuel anointed David', 'split_after_word' => 19],
                        ]
                    ],
                    17 => [
                        'verses' => [
                            4 => ['lead_in' => 'about the Philistine champion', 'split_after_word' => 15],
                            10 => ['lead_in' => 'about what the Philistine said to the Israelites', 'split_after_word' => 12],
                            26 => ['lead_in' => 'when David spoke to the men who were standing with him', 'split_after_word' => 30],
                            32 => ['lead_in' => 'what David told Saul not to let anyone be', 'split_after_word' => 13],
                            36 => ['lead_in' => 'what David said this uncircumcised Philistine will be', 'split_after_word' => 20],
                            37 => ['lead_in' => 'what David said about the LORD rescuing him', 'split_after_word' => 33],
                            45 => ['lead_in' => 'about how David said he came against the Philistine', 'split_after_word' => 22],
                            47 => ['lead_in' => 'what David said this whole assembly will know', 'split_after_word' => 22],
                            50 => ['lead_in' => 'about how David defeated the Philistine', 'split_after_word' => 10],
                        ]
                    ],
                    18 => [
                        'verses' => [
                            1 => ['lead_in' => 'about Jonathan loving David', 'split_after_word' => 17],
                        ]
                    ],
                    26 => [
                        'verses' => [
                            9 => ['lead_in' => 'what David told Abishai not do to', 'split_after_word' => 8],
                            10 => ['lead_in' => 'what David told Abishai would happen to Saul', 'split_after_word' => 16],
                            11 => ['lead_in' => 'what David told Abishai he would never do', 'split_after_word' => 21],
                            23 => ['lead_in' => 'about what David wasn\'t willing to do', 'split_after_word' => 13],
                            24 => ['lead_in' => 'what David said to Saul about life being valuable', 'split_after_word' => 8],
                            25 => ['lead_in' => 'when Saul said David was blessed', 'split_after_word' => 22],
                        ]
                    ],
                    27 => [
                        'verses' => [
                            12 => ['lead_in' => 'what Achish said about David', 'split_after_word' => 5],
                        ]
                    ],
                    30 => [
                        'verses' => [
                            4 => ['lead_in' => 'when David wept', 'split_after_word' => 9],
                            6 => ['lead_in' => 'about when the troops were all very bitter', 'split_after_word' => 17],
                            19 => ['lead_in' => 'about what was missing', 'split_after_word' => 18],
                            23 => ['lead_in' => 'what David said to corrupt and worthless men', 'split_after_word' => 20],
                        ]
                    ],
                    31 => [
                        'verses' => [
                            6 => ['lead_in' => 'about when Saul died', 'split_after_word' => 6],
                        ]
                    ],
                ]
            ]
        ]
    ]
];

// Generate Team Program File
$fileName = $teamSeasonData['id'] . '.json';
$jsonData = json_encode($teamSeasonData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
file_put_contents($dataDir . '/' . $fileName, $jsonData);

// Generate Beginner Program File
$jsonData = json_encode($beginnerSeasonData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
file_put_contents($beginnerDir . '/' . $fileName, $jsonData);

echo "Generated season data files:\n";
echo "- Team program: {$dataDir}/{$fileName}\n";
echo "- Beginner program: {$beginnerDir}/{$fileName}\n"; 