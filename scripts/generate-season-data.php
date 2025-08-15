<?php

require_once __DIR__ . '/../vendor/autoload.php';

use BKuhl\ScriptureRanges\ScriptureRangeBuilder;
use BKuhl\ScriptureRanges\ChapterRange;
use BKuhl\BibleCSB\Book\FirstSamuel;

$dataDir = __DIR__ . '/../data';
if (!is_dir($dataDir)) {
    mkdir($dataDir, 0755, true);
}

$samuelBook = new FirstSamuel();

$entireTextCollection = (new ScriptureRangeBuilder())
    ->with($samuelBook, ChapterRange::range(16, 24))
    ->with($samuelBook, ChapterRange::range(26, 31))
    ->build();

$block1Collection = (new ScriptureRangeBuilder())
    ->with($samuelBook, ChapterRange::range(16, 19))
    ->build();

$block2Collection = (new ScriptureRangeBuilder())
    ->with($samuelBook, ChapterRange::range(20, 24))
    ->build();

$block3Collection = (new ScriptureRangeBuilder())
    ->with($samuelBook, ChapterRange::range(26, 31))
    ->build();

$seasonData = [
    'id' => '16',
    'name' => '2025 Fall',
    'text' => $entireTextCollection->toArray(),
    'blocks' => [
        '1' => $block1Collection->toArray(),
        '2' => $block2Collection->toArray(),
        '3' => $block3Collection->toArray(),
    ]
];

$fileName = $seasonData['id'] . '.json';
$jsonData = json_encode($seasonData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
file_put_contents($dataDir . '/' . $fileName, $jsonData); 