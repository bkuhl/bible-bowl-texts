<?php

declare(strict_types=1);

namespace BKuhl\BibleBowlTexts;

/**
 * Tokenizes CSB verse text using Bible Bowl memory-verse word-count rules.
 *
 * A word is an uninterrupted sequence of alphanumeric characters, optionally
 * joined by connector punctuation (hyphen, en dash, apostrophe) or by commas
 * and colons within numbers (1,234 or 3:16). Punctuation alone is never a word,
 * so floating quotes and em dashes in the source text do not affect counts.
 *
 * When splitting, punctuation between two words attaches to the preceding word,
 * except opening quotes, which attach to the word they introduce
 * (e.g. said,"you splits into said, + "you).
 */
class BibleBowlWordCounter
{
    private const WORD_PATTERN = '/[\p{L}\p{N}]+(?:[\'’\-–][\p{L}\p{N}]+|[,:]\p{N}+)*/u';

    private const TRAILING_QUOTES_PATTERN = '/["\'“”‘’]+\z/u';

    public function countWords(string $text): int
    {
        return preg_match_all(self::WORD_PATTERN, $text);
    }

    /**
     * Words with their surrounding punctuation attached.
     *
     * @return list<string>
     */
    public function tokenize(string $text): array
    {
        $boundaries = $this->splitOffsets($text);

        if ($boundaries === null) {
            return [];
        }

        $tokens = [];
        $previous = 0;

        foreach ([...$boundaries, strlen($text)] as $offset) {
            $tokens[] = trim(substr($text, $previous, $offset - $previous));
            $previous = $offset;
        }

        return $tokens;
    }

    /**
     * Split text after the given number of words, preserving the original text.
     *
     * @return array{lead_in: string, answer: string}
     */
    public function splitAt(string $text, int $splitAfterWord): array
    {
        $boundaries = $this->splitOffsets($text);

        if ($boundaries === null || $splitAfterWord <= 0) {
            return ['lead_in' => '', 'answer' => trim($text)];
        }

        if ($splitAfterWord > count($boundaries)) {
            return ['lead_in' => trim($text), 'answer' => ''];
        }

        $offset = $boundaries[$splitAfterWord - 1];

        return [
            'lead_in' => trim(substr($text, 0, $offset)),
            'answer' => trim(substr($text, $offset)),
        ];
    }

    /**
     * Split a memory verse spanning multiple verses after the given number of
     * words. When the split lands exactly on a verse boundary, the answer is
     * the remaining verses verbatim; otherwise the split falls mid-verse.
     *
     * @param list<string> $verseTexts
     * @return array{lead_in: string, answer: string, splits_at_verse_boundary: bool}
     */
    public function splitVerses(array $verseTexts, int $splitAfterWord): array
    {
        $split = $this->splitAt(implode(' ', $verseTexts), $splitAfterWord);
        $split['splits_at_verse_boundary'] = $this->splitsAtVerseBoundary($verseTexts, $splitAfterWord);

        return $split;
    }

    /**
     * Whether the split position matches the cumulative word count of the
     * leading verse(s), meaning the answer starts exactly at the next verse.
     *
     * @param list<string> $verseTexts
     */
    public function splitsAtVerseBoundary(array $verseTexts, int $splitAfterWord): bool
    {
        $cumulative = 0;

        foreach (array_slice($verseTexts, 0, -1) as $verseText) {
            $cumulative += $this->countWords($verseText);

            if ($cumulative === $splitAfterWord) {
                return true;
            }

            if ($cumulative > $splitAfterWord) {
                return false;
            }
        }

        return false;
    }

    /**
     * Whether split_after_word leaves at least one word in both segments.
     */
    public function isValidSplitPosition(string $text, int $splitAfterWord): bool
    {
        return $splitAfterWord > 0 && $splitAfterWord < $this->countWords($text);
    }

    /**
     * Byte offsets at which the text may be divided between consecutive words.
     * Offset [i] is the boundary after word i+1. Punctuation between words
     * attaches to the preceding word, except quotes immediately preceding the
     * next word, which attach to it.
     *
     * @return list<int>|null Null when the text contains no words.
     */
    private function splitOffsets(string $text): ?array
    {
        if (preg_match_all(self::WORD_PATTERN, $text, $matches, PREG_OFFSET_CAPTURE) === 0) {
            return null;
        }

        $words = $matches[0];
        $offsets = [];

        for ($i = 1, $count = count($words); $i < $count; $i++) {
            $gapStart = $words[$i - 1][1] + strlen($words[$i - 1][0]);
            $wordStart = $words[$i][1];
            $gap = substr($text, $gapStart, $wordStart - $gapStart);

            preg_match(self::TRAILING_QUOTES_PATTERN, $gap, $quotes);

            $offsets[] = $wordStart - strlen($quotes[0] ?? '');
        }

        return $offsets;
    }
}
