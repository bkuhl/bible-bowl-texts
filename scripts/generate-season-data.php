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
                    16 => ['verses' => [1, 7, 13, 18]],
                    17 => ['verses' => [26, 36, 37, 45, 46, 47, 50]],
                    18 => ['verses' => [12, 30]],
                    19 => ['verses' => [4, 5]],
                    20 => ['verses' => [42]],
                    22 => ['verses' => [2, 14, 17]],
                    23 => ['verses' => [16]],
                    24 => ['verses' => [5, 6, 10, 12, 13, 14, 17, 19, 20, 21]],
                    26 => ['verses' => [9, 10, 11, 19, 21, 23, 24, 25]],
                    28 => ['verses' => [3, 16, 17, 18, 19]],
                    30 => ['verses' => [6, 23]],
                ]
            ]
        ]
    ]
];

// Beginner Program Season Data
$beginnerSeasonData = [
    'id' => '16',
    'name' => '2025 Fall',
    'text' => $beginnerEntireTextCollection->toArray(),
    'blocks' => [
        '1' => $beginnerBlock1Collection->toArray(),
        '2' => $beginnerBlock2Collection->toArray(),
    ],
    'memory_verses' => [
        'books' => [
            9 => [ // 1 Samuel
                'chapters' => [
                    16 => ['verses' => [7, 13]],
                    17 => ['verses' => [4, 10, 26, 32, 36, 37, 45, 47, 50]],
                    18 => ['verses' => [1]],
                    26 => ['verses' => [9, 10, 11, 23, 24, 25]],
                    27 => ['verses' => [12]],
                    30 => ['verses' => [4, 6, 19, 23]],
                    31 => ['verses' => [6]],
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