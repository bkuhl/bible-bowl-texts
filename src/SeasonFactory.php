<?php

declare(strict_types=1);

namespace BKuhl\BibleBowlTexts;

class SeasonFactory
{
    private string $dataPath;

    public function __construct(?string $dataPath = null)
    {
        $this->dataPath = $dataPath ?? __DIR__ . '/../data';
    }

    public function getSeasonById(string $id): ?array
    {
        $filePath = $this->dataPath . '/' . $id . '.json';
        
        if (!file_exists($filePath)) {
            return null;
        }

        $json = file_get_contents($filePath);
        return json_decode($json, true) ?: null;
    }

    public function getSeasonByName(string $name): ?array
    {
        $files = glob($this->dataPath . '/*.json');
        
        foreach ($files as $file) {
            $json = file_get_contents($file);
            $data = json_decode($json, true);
            
            if ($data && $data['name'] === $name) {
                return $data;
            }
        }
        
        return null;
    }

    public function getAllSeasons(): array
    {
        $seasons = [];
        $files = glob($this->dataPath . '/*.json');
        
        foreach ($files as $file) {
            $json = file_get_contents($file);
            $data = json_decode($json, true);
            
            if ($data) {
                $seasons[] = $data;
            }
        }
        
        return $seasons;
    }

    public function getBlock(string $seasonId, int $blockNumber): ?array
    {
        $season = $this->getSeasonById($seasonId);
        
        if (!$season) {
            return null;
        }
        
        $blockKey = (string) $blockNumber;
        
        if (isset($season['blocks'][$blockKey])) {
            return [
                'number' => $blockNumber,
                'range' => $season['blocks'][$blockKey]
            ];
        }
        
        return null;
    }
} 