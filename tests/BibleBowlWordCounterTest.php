<?php

declare(strict_types=1);

namespace BKuhl\BibleBowlTexts\Tests;

use BKuhl\BibleCSB\BookFactory;
use BKuhl\BibleBowlTexts\BibleBowlWordCounter;
use BKuhl\BibleBowlTexts\MemoryVerseReference;
use BKuhl\BibleBowlTexts\MemoryVerseTextResolver;
use PHPUnit\Framework\TestCase;

class BibleBowlWordCounterTest extends TestCase
{
    private BibleBowlWordCounter $counter;

    private MemoryVerseTextResolver $textResolver;

    protected function setUp(): void
    {
        $this->counter = new BibleBowlWordCounter();
        $this->textResolver = new MemoryVerseTextResolver(new BookFactory());
    }

    public function testTokenizesOpeningQuoteAfterCommaAsSeparateWord(): void
    {
        $tokens = $this->counter->tokenize('he said,"you have heard me speak about;');

        $this->assertSame(
            ['he', 'said,', '"you', 'have', 'heard', 'me', 'speak', 'about;'],
            $tokens
        );
    }

    public function testNaiveSplitMiscountsActs1Verse4Words(): void
    {
        $text = 'he said,"you have heard me speak about;';
        $naiveCount = count(explode(' ', $text));

        $this->assertSame(7, $naiveCount);
        $this->assertSame(8, $this->counter->countWords($text));
    }

    public function testActs1Verses4And5SplitAfterWord28(): void
    {
        $text = $this->textResolver->getCombinedText(44, 1, '4-5');
        $split = $this->counter->splitAt($text, 28);

        $this->assertStringEndsWith('about;', $split['lead_in']);
        $this->assertStringStartsWith('for John baptized', $split['answer']);

        $naiveSplit = $this->splitNaively($text, 28);
        $this->assertStringEndsWith('for', $naiveSplit['lead_in']);
        $this->assertStringStartsWith('John', $naiveSplit['answer']);
    }

    public function testSplitAtWordCountOfFirstVerseAlignsWithVerseBoundary(): void
    {
        $verseTexts = $this->textResolver->getVerseTexts(44, 1, '4-5');
        $splitAfterWord = $this->counter->countWords($verseTexts[0]);

        $split = $this->counter->splitVerses($verseTexts, $splitAfterWord);

        $this->assertTrue($split['splits_at_verse_boundary']);
        $this->assertSame($verseTexts[0], $split['lead_in']);
        $this->assertSame($verseTexts[1], $split['answer']);
    }

    public function testMidVerseSplitIsNotAVerseBoundary(): void
    {
        $verseTexts = $this->textResolver->getVerseTexts(44, 1, '4-5');

        $split = $this->counter->splitVerses($verseTexts, 5);

        $this->assertFalse($split['splits_at_verse_boundary']);
        $this->assertStringEndsWith('with them,', $split['lead_in']);
        $this->assertStringStartsWith('he commanded', $split['answer']);
    }

    public function testGenesis1Verse1SplitAfterWord5(): void
    {
        $text = $this->textResolver->getCombinedText(1, 1, '1');
        $split = $this->counter->splitAt($text, 5);

        $this->assertSame('In the beginning God created', $split['lead_in']);
        $this->assertSame('the heavens and the earth.', $split['answer']);
    }

    public function testNumbersWithCommasAndColonsAreSingleWords(): void
    {
        $this->assertSame(['1,234', 'people'], $this->counter->tokenize('1,234 people'));
        $this->assertSame(['3:16', 'says'], $this->counter->tokenize('3:16 says'));
    }

    public function testHyphenatedWordsAndPossessivesAreSingleWords(): void
    {
        $this->assertSame(['well-known'], $this->counter->tokenize('well-known'));
        $this->assertSame(['David\'s', 'sword'], $this->counter->tokenize('David\'s sword'));
        $this->assertSame(['don\'t', 'stop'], $this->counter->tokenize('don\'t stop'));
    }

    public function testStandalonePunctuationIsNotCountedAsAWord(): void
    {
        // Acts 1:6 in bible-csb ends with a floating closing quote: ...at this time? "
        $this->assertSame(3, $this->counter->countWords('at this time? "'));

        // Acts 1:12 contains a floating em dash: ...near Jerusalem — a Sabbath...
        $this->assertSame(4, $this->counter->countWords('near Jerusalem — a Sabbath'));
    }

    public function testOpeningQuoteAfterPeriodStartsANewWord(): void
    {
        $split = $this->counter->splitAt('he said."You have heard', 2);

        $this->assertSame('he said.', $split['lead_in']);
        $this->assertSame('"You have heard', $split['answer']);
    }

    public function testSplitPreservesOriginalTextExactly(): void
    {
        $text = 'he said, "It is not for you to know times or periods."';
        $split = $this->counter->splitAt($text, 2);

        $this->assertSame('he said,', $split['lead_in']);
        $this->assertSame('"It is not for you to know times or periods."', $split['answer']);
    }

    public function testMemoryVerseReferenceParsesVerseKeys(): void
    {
        $this->assertSame([16], MemoryVerseReference::parse('16')->verseNumbers());
        $this->assertSame([3, 4], MemoryVerseReference::parse('3-4')->verseNumbers());
        $this->assertSame([35, 37], MemoryVerseReference::parse('35,37')->verseNumbers());
    }

    /**
     * @return array{lead_in: string, answer: string}
     */
    private function splitNaively(string $text, int $splitAfterWord): array
    {
        $words = explode(' ', trim($text));

        return [
            'lead_in' => implode(' ', array_slice($words, 0, $splitAfterWord)),
            'answer' => implode(' ', array_slice($words, $splitAfterWord)),
        ];
    }
}
