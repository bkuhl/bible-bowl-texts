<?php

declare(strict_types=1);

namespace BKuhl\BibleBowlTexts;

/**
 * Represents a Bible Bowl season with text ranges, blocks, and memory verses.
 */
class Season
{
    /**
     * @param string $id Season identifier (e.g., "16")
     * @param string $name Season name (e.g., "2025 Fall")
     * @param array $text Scripture text ranges following BKuhl\ScriptureRanges format
     * @param array $blocks Season blocks keyed by block number ("1", "2", "3")
     * @param array $memoryVerses Memory verses in explicit books.chapters.verses structure
     */
    public function __construct(
        private readonly string $id,
        private readonly string $name,
        private readonly array $text,
        private readonly array $blocks,
        private readonly array $memoryVerses
    ) {}

    /**
     * Get the season identifier.
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Get the season name.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the scripture text ranges.
     * 
     * @return array Text ranges following BKuhl\ScriptureRanges format:
     *               [
     *                   'ranges' => [
     *                       [
     *                           'start' => ['book' => int, 'chapter' => int, 'verse' => int|null],
     *                           'end' => ['book' => int, 'chapter' => int, 'verse' => int|null]
     *                       ]
     *                   ]
     *               ]
     */
    public function getText(): array
    {
        return $this->text;
    }

    /**
     * Get all season blocks.
     * 
     * @return array Blocks keyed by block number:
     *               [
     *                   "1" => [
     *                       'ranges' => [
     *                           [
     *                               'start' => ['book' => int, 'chapter' => int, 'verse' => int|null],
     *                               'end' => ['book' => int, 'chapter' => int, 'verse' => int|null]
     *                           ]
     *                       ]
     *                   ],
     *                   "2" => [...],
     *                   "3" => [...]
     *               ]
     */
    public function getBlocks(): array
    {
        return $this->blocks;
    }

    /**
     * Get memory verses in explicit books.chapters.verses structure.
     * 
     * @return array Memory verses structure:
     *               [
     *                   'books' => [
     *                       bookId => [
     *                           'chapters' => [
     *                               chapterId => [
     *                                   'verses' => [verse1, verse2, ...]
     *                               ]
     *                           ]
     *                       ]
     *                   ]
     *               ]
     * 
     * @example
     * $memoryVerses = $season->getMemoryVerses();
     * $chapter16Verses = $memoryVerses['books'][9]['chapters'][16]['verses']; // [1, 7, 13, 18]
     */
    public function getMemoryVerses(): array
    {
        return $this->memoryVerses;
    }

    /**
     * Get memory verses as a flattened array for backward compatibility.
     * 
     * @return array Flattened memory verses:
     *               [
     *                   ['book' => int, 'chapter' => int, 'verse' => int],
     *                   ['book' => int, 'chapter' => int, 'verse' => int],
     *                   ...
     *               ]
     * 
     * @example
     * $flattened = $season->getMemoryVersesFlattened();
     * foreach ($flattened as $verse) {
     *     echo "Book: {$verse['book']}, Chapter: {$verse['chapter']}, Verse: {$verse['verse']}";
     * }
     */
    public function getMemoryVersesFlattened(): array
    {
        $flattened = [];
        foreach ($this->memoryVerses['books'] as $book => $bookData) {
            foreach ($bookData['chapters'] as $chapter => $chapterData) {
                foreach ($chapterData['verses'] as $verse) {
                    $flattened[] = [
                        'book' => $book,
                        'chapter' => $chapter,
                        'verse' => $verse
                    ];
                }
            }
        }
        
        return $flattened;
    }

    /**
     * Get a specific block by number.
     * 
     * @param int $blockNumber Block number (1, 2, 3, etc.)
     * @return array|null Block data or null if not found:
     *                    [
     *                        'number' => int,
     *                        'range' => [
     *                            'ranges' => [
     *                                [
     *                                    'start' => ['book' => int, 'chapter' => int, 'verse' => int|null],
     *                                    'end' => ['book' => int, 'chapter' => int, 'verse' => int|null]
     *                                ]
     *                            ]
     *                        ]
     *                    ]
     * 
     * @example
     * $block = $season->getBlock(1);
     * if ($block) {
     *     echo "Block {$block['number']} covers chapters {$block['range']['ranges'][0]['start']['chapter']}-{$block['range']['ranges'][0]['end']['chapter']}";
     * }
     */
    public function getBlock(int $blockNumber): ?array
    {
        $blockKey = (string) $blockNumber;
        
        if (isset($this->blocks[$blockKey])) {
            return [
                'number' => $blockNumber,
                'range' => $this->blocks[$blockKey]
            ];
        }
        
        return null;
    }

    /**
     * Create a Season instance from array data (typically from JSON).
     * 
     * @param array $data Season data array with keys: id, name, text, blocks, memory_verses
     * @return self New Season instance
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'],
            $data['name'],
            $data['text'],
            $data['blocks'],
            $data['memory_verses'] ?? []
        );
    }
}
