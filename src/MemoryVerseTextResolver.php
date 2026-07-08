<?php

declare(strict_types=1);

namespace BKuhl\BibleBowlTexts;

use BKuhl\BibleCSB\BookEnum;
use BKuhl\BibleCSB\BookFactory;
use BKuhl\BibleCSB\Exception\VerseNotFoundException;

/**
 * Fetches combined CSB text for a memory-verse reference.
 */
class MemoryVerseTextResolver
{
    public function __construct(
        private readonly BookFactory $bookFactory
    ) {}

    /**
     * @return list<string> One text per verse in the reference.
     *
     * @throws VerseNotFoundException
     */
    public function getVerseTexts(int $bookNumber, int $chapter, MemoryVerseReference|string $reference): array
    {
        if (is_string($reference)) {
            $reference = MemoryVerseReference::parse($reference);
        }

        $bookEnums = BookEnum::cases();
        if (! isset($bookEnums[$bookNumber - 1])) {
            throw new \InvalidArgumentException("Invalid book number: {$bookNumber}");
        }

        $chapterObj = $this->bookFactory->make($bookEnums[$bookNumber - 1])->chapter($chapter);
        $texts = [];

        foreach ($reference->verseNumbers() as $verse) {
            $texts[] = $chapterObj->verse($verse)->text();
        }

        return $texts;
    }

    /**
     * @throws VerseNotFoundException
     */
    public function getCombinedText(int $bookNumber, int $chapter, MemoryVerseReference|string $reference): string
    {
        return implode(' ', $this->getVerseTexts($bookNumber, $chapter, $reference));
    }
}
