<?php

require_once __DIR__ . '/../vendor/autoload.php';

use BKuhl\ScriptureRanges\ScriptureRangeBuilder;
use BKuhl\ScriptureRanges\ChapterRange;
use BKuhl\BibleCSB\Book\FirstSamuel;
use BKuhl\BibleCSB\Book\Daniel;
use BKuhl\BibleCSB\Book\Jonah;
use BKuhl\BibleCSB\Book\Romans;
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
$danielBook = new Daniel();
$jonahBook = new Jonah();
$romansBook = new Romans();

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
                            1 => ['lead_in' => 'what the LORD said to Samuel', 'split_after_word' => 23],
                            7 => ['lead_in' => 'about what the LORD sees', 'split_after_word' => 20],
                            13 => ['lead_in' => 'about when Samuel anointed David', 'split_after_word' => 16],
                            18 => ['lead_in' => 'what one of the young men said about David', 'split_after_word' => 22],
                        ]
                    ],
                    17 => [
                        'verses' => [
                            26 => ['lead_in' => 'when David spoke to the men who were standing with him', 'split_after_word' => 27],
                            36 => ['lead_in' => 'what David said this uncircumcised Philistine will be', 'split_after_word' => 16],
                            37 => ['lead_in' => 'what David said about the LORD rescuing him', 'split_after_word' => 20],
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
                            4 => ['lead_in' => 'when Jonathan spoke well of David', 'split_after_word' => 22],
                            5 => ['lead_in' => 'what Jonathan said David did', 'split_after_word' => 24],
                        ]
                    ],
                    20 => [
                        'verses' => [
                            42 => ['lead_in' => 'how Jonathan told David to go', 'split_after_word' => 20],
                        ]
                    ],
                    22 => [
                        'verses' => [
                            2 => ['lead_in' => 'about who rallied around David', 'split_after_word' => 14],
                            14 => ['lead_in' => 'what Ahimelech said about David', 'split_after_word' => 15],
                            17 => ['lead_in' => 'about what the king\'s servants would not do', 'split_after_word' => 22],
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
                            10 => ['lead_in' => 'about what someone advised David to do', 'split_after_word' => 19],
                            12 => ['lead_in' => 'what David said for the LORD to do to Saul', 'split_after_word' => 8],
                            13 => ['lead_in' => 'about the old proverb', 'split_after_word' => 10],
                            14 => ['lead_in' => 'what David asked Saul chasing after', 'split_after_word' => 9],
                            17 => ['lead_in' => 'what Saul said after he wept aloud', 'split_after_word' => 10],
                            19 => ['lead_in' => 'what Saul said about the LORD repaying', 'split_after_word' => 12],
                            20 => ['lead_in' => 'what Saul said he knew for certain', 'split_after_word' => 10],
                            21 => ['lead_in' => 'what Saul told David to swear to him', 'split_after_word' => 15],
                        ]
                    ],
                    26 => [
                        'verses' => [
                            9 => ['lead_in' => 'what David told Abishai not do to', 'split_after_word' => 8],
                            10 => ['lead_in' => 'what David told Abishai would happen to Saul', 'split_after_word' => 13],
                            11 => ['lead_in' => 'what David told Abishai he would never do', 'split_after_word' => 17],
                            19 => ['lead_in' => 'when David said people should be cursed', 'split_after_word' => 30],
                            21 => ['lead_in' => 'when Saul said he had sinned', 'split_after_word' => 16],
                            23 => ['lead_in' => 'about what David wasn\'t willing to do', 'split_after_word' => 12],
                            24 => ['lead_in' => 'what David said to Saul about life being valuable', 'split_after_word' => 8],
                            25 => ['lead_in' => 'when Saul said David was blessed', 'split_after_word' => 20],
                        ]
                    ],
                    28 => [
                        'verses' => [
                            3 => ['lead_in' => 'about when Samuel had died', 'split_after_word' => 19],
                            16 => ['lead_in' => 'what Samuel asked Saul', 'split_after_word' => 10],
                            17 => ['lead_in' => 'what Samuel told Saul the LORD had done', 'split_after_word' => 11],
                            18 => ['lead_in' => 'what Samuel told Saul he had not done', 'split_after_word' => 16],
                            19 => ['lead_in' => 'what Samuel told Saul would happen to him', 'split_after_word' => 13],
                        ]
                    ],
                    30 => [
                        'verses' => [
                            6 => ['lead_in' => 'about when the troops were all very bitter', 'split_after_word' => 14],
                            23 => ['lead_in' => 'what David said to corrupt and worthless men', 'split_after_word' => 17],
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
                            7 => ['lead_in' => 'about what the LORD sees', 'split_after_word' => 20],
                            13 => ['lead_in' => 'about when Samuel anointed David', 'split_after_word' => 16],
                        ]
                    ],
                    17 => [
                        'verses' => [
                            4 => ['lead_in' => 'about the Philistine champion', 'split_after_word' => 13],
                            10 => ['lead_in' => 'about what the Philistine said to the Israelites', 'split_after_word' => 11],
                            26 => ['lead_in' => 'when David spoke to the men who were standing with him', 'split_after_word' => 27],
                            32 => ['lead_in' => 'what David told Saul not to let anyone be', 'split_after_word' => 11],
                            36 => ['lead_in' => 'what David said this uncircumcised Philistine will be', 'split_after_word' => 16],
                            37 => ['lead_in' => 'what David said about the LORD rescuing him', 'split_after_word' => 29],
                            45 => ['lead_in' => 'about how David said he came against the Philistine', 'split_after_word' => 15],
                            47 => ['lead_in' => 'what David said this whole assembly will know', 'split_after_word' => 19],
                            50 => ['lead_in' => 'about how David defeated the Philistine', 'split_after_word' => 10],
                        ]
                    ],
                    18 => [
                        'verses' => [
                            1 => ['lead_in' => 'about Jonathan loving David', 'split_after_word' => 15],
                        ]
                    ],
                    26 => [
                        'verses' => [
                            9 => ['lead_in' => 'what David told Abishai not do to', 'split_after_word' => 8],
                            10 => ['lead_in' => 'what David told Abishai would happen to Saul', 'split_after_word' => 13],
                            11 => ['lead_in' => 'what David told Abishai he would never do', 'split_after_word' => 17],
                            23 => ['lead_in' => 'about what David wasn\'t willing to do', 'split_after_word' => 12],
                            24 => ['lead_in' => 'what David said to Saul about life being valuable', 'split_after_word' => 8],
                            25 => ['lead_in' => 'when Saul said David was blessed', 'split_after_word' => 20],
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
                            6 => ['lead_in' => 'about when the troops were all very bitter', 'split_after_word' => 14],
                            19 => ['lead_in' => 'about what was missing', 'split_after_word' => 16],
                            23 => ['lead_in' => 'what David said to corrupt and worthless men', 'split_after_word' => 17],
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

// Season 17 Beginner Program Data (Daniel and Jonah)
$season17BeginnerEntireTextCollection = (new ScriptureRangeBuilder())
    ->with($danielBook, 1, null, null, 21)      // Dan 1:1-21
    ->with($danielBook, 3, null, null, 30)      // Dan 3:1-30
    ->with($danielBook, 5, null, null, 30)      // Dan 5:1-30
    ->with($danielBook, 6, null, null, 28)      // Dan 6:1-28
    ->with($jonahBook, 1, null, null, 17)       // Jonah 1:1-17
    ->with($jonahBook, 2, null, null, 10)       // Jonah 2:1-10
    ->with($jonahBook, 3, null, null, 10)       // Jonah 3:1-10
    ->with($jonahBook, 4, null, null, 11)       // Jonah 4:1-11
    ->build();

$season17BeginnerBlock1Collection = (new ScriptureRangeBuilder())
    ->with($danielBook, 1, null, null, 21)      // Dan 1:1-21
    ->with($danielBook, 3, null, null, 30)      // Dan 3:1-30
    ->with($danielBook, 5, null, null, 30)      // Dan 5:1-30
    ->build();

$season17BeginnerBlock2Collection = (new ScriptureRangeBuilder())
    ->with($danielBook, 6, null, null, 28)      // Dan 6:1-28
    ->with($jonahBook, 1, null, null, 17)       // Jonah 1:1-17
    ->with($jonahBook, 2, null, null, 10)       // Jonah 2:1-10
    ->with($jonahBook, 3, null, null, 10)       // Jonah 3:1-10
    ->with($jonahBook, 4, null, null, 11)       // Jonah 4:1-11
    ->build();

// Season 17 Beginner Program Season Data
$season17BeginnerSeasonData = [
    'id' => '17',
    'name' => '2026 Spring',
    'program' => 'beginner',
    'text' => $season17BeginnerEntireTextCollection->toArray(),
    'blocks' => [
        '1' => $season17BeginnerBlock1Collection->toArray(),
        '2' => $season17BeginnerBlock2Collection->toArray(),
    ],
    'memory_verses' => [
        'books' => [
            27 => [ // Daniel
                'chapters' => [
                    1 => [
                        'verses' => [
                            '8' => ['lead_in' => 'about what Daniel determined', 'split_after_word' => 19],
                            '9' => ['lead_in' => 'about what God granted Daniel', 'split_after_word' => 6],
                            '11-12' => ['lead_in' => 'what Daniel said to the guard', 'split_after_word' => 16],
                            '15' => ['lead_in' => 'about what happened at the end of ten days', 'split_after_word' => 10],
                            '17' => ['lead_in' => 'about the young men', 'split_after_word' => 16],
                            '19' => ['lead_in' => 'when the chief eunuch presented the young men to Nebuchadnezzar', 'split_after_word' => 21],
                            '20' => ['lead_in' => 'about how the king found them', 'split_after_word' => 14],
                        ]
                    ],
                    3 => [
                        'verses' => [
                            '17' => ['lead_in' => 'what Shadrach, Meshach, and Abednego said to the king', 'split_after_word' => 17],
                            '18' => ['lead_in' => 'what Shadrach, Meshach, and Abednego wanted the king to know', 'split_after_word' => 15],
                            '25' => ['lead_in' => 'about what the king said he saw', 'split_after_word' => 15],
                            '28' => ['lead_in' => 'when Nebuchadnezzar praised God', 'split_after_word' => 24],
                        ]
                    ],
                    5 => [
                        'verses' => [
                            '14' => ['lead_in' => 'what the king said he heard', 'split_after_word' => 12],
                        ]
                    ],
                    6 => [
                        'verses' => [
                            '10' => ['lead_in' => 'what happened after Darius signed the written edict', 'split_after_word' => 24],
                            '16' => ['lead_in' => 'what happened when the edict could not be changed', 'split_after_word' => 17],
                            '22' => ['lead_in' => 'what Daniel said after he was rescued from the lions', 'split_after_word' => 15],
                            '23' => ['lead_in' => 'what the king did after Daniel was rescued from the lions', 'split_after_word' => 14],
                            '27' => ['lead_in' => 'what Darius said God does', 'split_after_word' => 15],
                        ]
                    ],
                ]
            ],
            32 => [ // Jonah
                'chapters' => [
                    1 => [
                        'verses' => [
                            '9' => ['lead_in' => 'what Jonah answered the sailors', 'split_after_word' => 9],
                            '16' => ['lead_in' => 'what the men did after the sea stopped raging', 'split_after_word' => 10],
                            '17' => ['lead_in' => 'what the LORD did after the sea stopped raging', 'split_after_word' => 9],
                        ]
                    ],
                    2 => [
                        'verses' => [
                            '2' => ['lead_in' => 'what Jonah first said in the belly of the fish', 'split_after_word' => 12],
                            '6' => ['lead_in' => 'what Jonah did after seaweed was wrapped around his head', 'split_after_word' => 15],
                            '7' => ['lead_in' => 'when Jonah remembered', 'split_after_word' => 10],
                        ]
                    ],
                    3 => [
                        'verses' => [
                            '5' => ['lead_in' => 'what happened when Jonah proclaimed that Nineveh would be demolished', 'split_after_word' => 7],
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

// Season 17 Teen Program Data (Romans)
$season17TeenEntireTextCollection = (new ScriptureRangeBuilder())
    ->with($romansBook, ChapterRange::range(1, 16))
    ->build();

$season17TeenBlock1Collection = (new ScriptureRangeBuilder())
    ->with($romansBook, ChapterRange::range(1, 5))
    ->build();

$season17TeenBlock2Collection = (new ScriptureRangeBuilder())
    ->with($romansBook, ChapterRange::range(6, 10))
    ->build();

$season17TeenBlock3Collection = (new ScriptureRangeBuilder())
    ->with($romansBook, ChapterRange::range(11, 16))
    ->build();

// Season 17 Teen Program Season Data
$season17TeenSeasonData = [
    'id' => '17',
    'name' => '2026 Spring',
    'program' => 'teen',
    'text' => $season17TeenEntireTextCollection->toArray(),
    'blocks' => [
        '1' => $season17TeenBlock1Collection->toArray(),
        '2' => $season17TeenBlock2Collection->toArray(),
        '3' => $season17TeenBlock3Collection->toArray(),
    ],
    'memory_verses' => [
        'books' => [
            45 => [ // Romans
                'chapters' => [
                    1 => [
                        'verses' => [
                            '3-4' => ['lead_in' => 'about Jesus Christ', 'split_after_word' => 18],
                            '16' => ['lead_in' => 'about why Paul is not ashamed', 'split_after_word' => 17],
                            '17' => ['lead_in' => 'about what is revealed in the gospel', 'split_after_word' => 14],
                        ]
                    ],
                    2 => [
                        'verses' => [
                            '9-11' => ['lead_in' => 'about favoritism', 'split_after_word' => 21],
                        ]
                    ],
                    3 => [
                        'verses' => [
                            '9-10' => ['lead_in' => 'about who is under sin', 'split_after_word' => 24],
                            '23-24' => ['lead_in' => 'about what all have done', 'split_after_word' => 12],
                            '25' => ['lead_in' => 'about how Christ was presented', 'split_after_word' => 16],
                            '26' => ['lead_in' => 'about why God presented Christ', 'split_after_word' => 12],
                            '28' => ['lead_in' => 'about being justified', 'split_after_word' => 10],
                        ]
                    ],
                    4 => [
                        'verses' => [
                            '24-25' => ['lead_in' => 'about what was credited to us', 'split_after_word' => 21],
                        ]
                    ],
                    5 => [
                        'verses' => [
                            '1' => ['lead_in' => 'about peace', 'split_after_word' => 9],
                            '2' => ['lead_in' => 'about access', 'split_after_word' => 16],
                            '5' => ['lead_in' => 'about hope', 'split_after_word' => 16],
                            '6' => ['lead_in' => 'about those for whom Christ died', 'split_after_word' => 6],
                            '8' => ['lead_in' => 'about when Christ died', 'split_after_word' => 8],
                        ]
                    ],
                    6 => [
                        'verses' => [
                            '4' => ['lead_in' => 'about baptism', 'split_after_word' => 10],
                            '6-7' => ['lead_in' => 'about our old self', 'split_after_word' => 33],
                            '23' => ['lead_in' => 'about wages', 'split_after_word' => 7],
                        ]
                    ],
                    8 => [
                        'verses' => [
                            '1-2' => ['lead_in' => 'about condemnation', 'split_after_word' => 11],
                            '13' => ['lead_in' => 'about when you will live and die', 'split_after_word' => 13],
                            '15' => ['lead_in' => 'about the spirit of adoption', 'split_after_word' => 14],
                            '18' => ['lead_in' => 'about sufferings', 'split_after_word' => 10],
                            '28' => ['lead_in' => 'about what all things do', 'split_after_word' => 15],
                            '31-32' => ['lead_in' => 'about God being for us', 'split_after_word' => 18],
                            '35,37' => ['lead_in' => 'about conquerors', 'split_after_word' => 23],
                            '38-39' => ['lead_in' => 'about what Paul was persuaded', 'split_after_word' => 22],
                        ]
                    ],
                    10 => [
                        'verses' => [
                            '9' => ['lead_in' => 'about confessing and believing', 'split_after_word' => 9],
                            '12-13' => ['lead_in' => 'about who will be saved', 'split_after_word' => 22],
                            '14' => ['lead_in' => 'about the need for a preacher', 'split_after_word' => 12],
                            '15' => ['lead_in' => 'about sending preachers', 'split_after_word' => 9],
                        ]
                    ],
                    11 => [
                        'verses' => [
                            '33' => ['lead_in' => 'about the depth of God\'s attributes', 'split_after_word' => 15],
                            '34-35' => ['lead_in' => 'about man\'s inferiority to God', 'split_after_word' => 15],
                            '36' => ['lead_in' => 'about what all things are', 'split_after_word' => 12],
                        ]
                    ],
                    12 => [
                        'verses' => [
                            '1' => ['lead_in' => 'about living sacrifices', 'split_after_word' => 11],
                            '2' => ['lead_in' => 'about being transformed', 'split_after_word' => 16],
                            '9-10' => ['lead_in' => 'about love', 'split_after_word' => 12],
                            '21' => ['lead_in' => 'about good and evil', 'split_after_word' => 6],
                        ]
                    ],
                    13 => [
                        'verses' => [
                            '9' => ['lead_in' => 'about the commandments', 'split_after_word' => 15],
                            '12' => ['lead_in' => 'about the deeds of darkness', 'split_after_word' => 11],
                        ]
                    ],
                    14 => [
                        'verses' => [
                            '8' => ['lead_in' => 'about living and dying', 'split_after_word' => 17],
                            '11-12' => ['lead_in' => 'about every knee and tongue', 'split_after_word' => 24],
                            '13' => ['lead_in' => 'about a stumbling block', 'split_after_word' => 8],
                            '19' => ['lead_in' => 'about what we should pursue', 'split_after_word' => 8],
                            '21' => ['lead_in' => 'about what is a good thing', 'split_after_word' => 12],
                        ]
                    ],
                    16 => [
                        'verses' => [
                            '20' => ['lead_in' => 'about Satan', 'split_after_word' => 11],
                        ]
                    ],
                ]
            ]
        ]
    ]
];

// Generate Season 17 Beginner Program File
$season17FileName = $season17BeginnerSeasonData['id'] . '.json';
$season17JsonData = json_encode($season17BeginnerSeasonData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
file_put_contents($beginnerDir . '/' . $season17FileName, $season17JsonData);

// Generate Season 17 Teen Program File
$season17TeenJsonData = json_encode($season17TeenSeasonData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
file_put_contents($dataDir . '/' . $season17FileName, $season17TeenJsonData);

echo "Generated season data files:\n";
echo "- Team program: {$dataDir}/{$fileName}\n";
echo "- Beginner program: {$beginnerDir}/{$fileName}\n";
echo "- Season 17 Beginner program: {$beginnerDir}/{$season17FileName}\n";
echo "- Season 17 Teen program: {$dataDir}/{$season17FileName}\n"; 