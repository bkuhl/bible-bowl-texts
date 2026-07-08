<?php

declare(strict_types=1);

namespace BKuhl\BibleBowlTexts;

/**
 * Parses memory-verse reference keys such as "16", "3-4", or "35,37".
 */
final class MemoryVerseReference
{
    private function __construct(
        private readonly string $key,
        /** @var list<int> */
        private readonly array $verseNumbers
    ) {}

    public static function parse(string $key): self
    {
        $key = trim($key);

        if ($key === '') {
            throw new \InvalidArgumentException('Verse key cannot be empty.');
        }

        if (str_contains($key, '-')) {
            [$start, $end] = explode('-', $key, 2);

            return new self($key, range((int) $start, (int) $end));
        }

        if (str_contains($key, ',')) {
            return new self(
                $key,
                array_map(static fn (string $verse): int => (int) trim($verse), explode(',', $key))
            );
        }

        return new self($key, [(int) $key]);
    }

    public function key(): string
    {
        return $this->key;
    }

    /**
     * @return list<int>
     */
    public function verseNumbers(): array
    {
        return $this->verseNumbers;
    }
}
