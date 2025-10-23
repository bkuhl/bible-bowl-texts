<?php

declare(strict_types=1);

namespace BKuhl\BibleBowlTexts;

class SeasonFactory
{
    public const PROGRAM_BEGINNER = 'beginner';
    
    private string $dataPath;

    public function __construct(?string $dataPath = null)
    {
        $this->dataPath = $dataPath ?? __DIR__ . '/../data';
    }

    private function getProgramPath(?string $program): string
    {
        if ($program === self::PROGRAM_BEGINNER) {
            return $this->dataPath . '/beginner';
        }
        
        return $this->dataPath;
    }

    public function getSeasonById(string $id, ?string $program = null): ?Season
    {
        $programPath = $this->getProgramPath($program);
        $filePath = $programPath . '/' . $id . '.json';
        
        if (!file_exists($filePath)) {
            return null;
        }

        $json = file_get_contents($filePath);
        $data = json_decode($json, true);
        
        if (!$data) {
            return null;
        }
        
        return Season::fromArray($data);
    }

    public function getSeasonByName(string $name, ?string $program = null): ?Season
    {
        $programPath = $this->getProgramPath($program);
        $files = glob($programPath . '/*.json');
        
        foreach ($files as $file) {
            $json = file_get_contents($file);
            $data = json_decode($json, true);
            
            if ($data && $data['name'] === $name) {
                return Season::fromArray($data);
            }
        }
        
        return null;
    }

    public function getAllSeasons(?string $program = null): array
    {
        $seasons = [];
        $programPath = $this->getProgramPath($program);
        $files = glob($programPath . '/*.json');
        
        foreach ($files as $file) {
            $json = file_get_contents($file);
            $data = json_decode($json, true);
            
            if ($data) {
                $seasons[] = Season::fromArray($data);
            }
        }
        
        return $seasons;
    }

    public function getBlock(string $seasonId, int $blockNumber, ?string $program = null): ?array
    {
        $season = $this->getSeasonById($seasonId, $program);
        
        if (!$season) {
            return null;
        }
        
        return $season->getBlock($blockNumber);
    }

    /**
     * Get memory verses for a season in explicit books.chapters.verses structure.
     * 
     * @param string $seasonId Season identifier
     * @param string|null $program Program type (null for default, SeasonFactory::PROGRAM_BEGINNER for beginner)
     * @return array|null Memory verses structure or null if season not found:
     *                   [
     *                       'books' => [
     *                           bookId => [
     *                               'chapters' => [
     *                                   chapterId => [
     *                                       'verses' => [verse1, verse2, ...]
     *                                   ]
     *                               ]
     *                           ]
     *                       ]
     *                   ]
     * 
     * @example
     * $memoryVerses = $factory->getMemoryVerses('16');
     * $chapter16Verses = $memoryVerses['books'][9]['chapters'][16]['verses']; // [1, 7, 13, 18]
     */
    public function getMemoryVerses(string $seasonId, ?string $program = null): ?array
    {
        $season = $this->getSeasonById($seasonId, $program);
        
        if (!$season) {
            return null;
        }
        
        return $season->getMemoryVerses();
    }

    /**
     * Get memory verses as a flattened array for backward compatibility.
     * 
     * @param string $seasonId Season identifier
     * @param string|null $program Program type (null for default, SeasonFactory::PROGRAM_BEGINNER for beginner)
     * @return array|null Flattened memory verses or null if season not found:
     *                   [
     *                       ['book' => int, 'chapter' => int, 'verse' => int],
     *                       ['book' => int, 'chapter' => int, 'verse' => int],
     *                       ...
     *                   ]
     * 
     * @example
     * $flattened = $factory->getMemoryVersesFlattened('16');
     * foreach ($flattened as $verse) {
     *     echo "Book: {$verse['book']}, Chapter: {$verse['chapter']}, Verse: {$verse['verse']}";
     * }
     */
    public function getMemoryVersesFlattened(string $seasonId, ?string $program = null): ?array
    {
        $season = $this->getSeasonById($seasonId, $program);
        
        if (!$season) {
            return null;
        }
        
        return $season->getMemoryVersesFlattened();
    }
} 