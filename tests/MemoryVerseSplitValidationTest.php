<?php

declare(strict_types=1);

namespace BKuhl\BibleBowlTexts\Tests;

use BKuhl\BibleCSB\BookFactory;
use BKuhl\BibleBowlTexts\BibleBowlWordCounter;
use BKuhl\BibleBowlTexts\MemoryVerseTextResolver;
use BKuhl\BibleBowlTexts\SeasonFactory;
use PHPUnit\Framework\TestCase;

class MemoryVerseSplitValidationTest extends TestCase
{
    private BibleBowlWordCounter $counter;

    private MemoryVerseTextResolver $textResolver;

    protected function setUp(): void
    {
        $this->counter = new BibleBowlWordCounter();
        $this->textResolver = new MemoryVerseTextResolver(new BookFactory());
    }

    public function testActs1Verses4And5TeenSplitAfterWord28(): void
    {
        $factory = new SeasonFactory(__DIR__ . '/../data');
        $season = $factory->getSeasonById('18');
        $this->assertNotNull($season);

        $meta = $season->getMemoryVerses()['books']['44']['chapters']['1']['verses']['4-5'];
        $text = $this->textResolver->getCombinedText(44, 1, '4-5');
        $split = $this->counter->splitAt($text, $meta['split_after_word']);

        $this->assertSame(28, $meta['split_after_word']);
        $this->assertStringEndsWith('about;', $split['lead_in']);
        $this->assertStringStartsWith('for John baptized', $split['answer']);
    }

    /**
     * Answer text (line 2) from the official beginner study guide, blocks 1–2.
     *
     * @return array<string, array{0: string, 1: int, 2: string}>
     */
    public static function beginnerStudyGuideSplitProvider(): array
    {
        return [
            '6:10' => ['6:10', 10, 'and the Spirit by whom he was speaking.'],
            '7:55' => ['7:55', 9, 'He saw the glory of God, and Jesus standing at the right hand of God.'],
            '7:59' => ['7:59', 5, 'he called out, "Lord Jesus, receive my spirit!"'],
            '7:60' => ['7:60', 18, 'And after saying this, he fell asleep.'],
            '8:4-5' => ['8:4-5', 12, 'Philip went down to a city in Samaria and proclaimed the Messiah to them.'],
            '8:35' => ['8:35', 10, 'beginning with that Scripture.'],
            '8:36' => ['8:36', 12, 'The eunuch said, "Look, there\'s water. What would keep me from being baptized?"'],
            '9:4-5' => ['9:4-5', 18, '"Who are you, Lord? " Saul said. "I am Jesus, the one you are persecuting," he replied.'],
            '9:15' => ['9:15', 14, 'to take my name to Gentiles, kings, and Israelites.'],
            '9:20' => ['9:20', 8, '"He is the Son of God."'],
            '9:22' => ['9:22', 13, 'by proving that Jesus is the Messiah.'],
            '9:31' => ['9:31', 14, 'Living in the fear of the Lord and encouraged by the Holy Spirit, it increased in numbers.'],
            '10:4' => ['10:4', 15, '"Your prayers and your acts of charity have ascended as a memorial offering before God.'],
            '10:34-35' => ['10:34-35', 13, 'but in every nation the person who fears him and does what is right is acceptable to him.'],
            '10:36' => ['10:36', 7, 'proclaiming the good news of peace through Jesus Christ — he is Lord of all.'],
            '10:39' => ['10:39', 16, 'and yet they killed him by hanging him on a tree.'],
            '10:42' => ['10:42', 11, 'that he is the one appointed by God to be the judge of the living and the dead.'],
            '10:43' => ['10:43', 10, 'everyone who believes in him receives forgiveness of sins."'],
            '10:45' => ['10:45', 10, 'because the gift of the Holy Spirit had been poured out even on the Gentiles.'],
            '10:47' => ['10:47', 11, 'who have received the Holy Spirit just as we have?"'],
            '11:21' => ['11:21', 6, 'and a large number who believed turned to the Lord.'],
            '11:23' => ['11:23', 12, 'and encouraged all of them to remain true to the Lord with devoted hearts,'],
            '12:5' => ['12:5', 6, 'but the church was praying fervently to God for him.'],
            '12:11' => ['12:11', 19, 'and rescued me from Herod\'s grasp and from all that the Jewish people expected."'],
        ];
    }

    /**
     * Teen season 18 single-verse references that share the beginner study guide split.
     *
     * @return array<string, array{0: string, 1: int, 2: string}>
     */
    public static function teenSharedStudyGuideSplitProvider(): array
    {
        $shared = ['8:36', '9:31', '10:4', '10:39', '10:45', '10:47', '11:23'];

        return array_intersect_key(self::beginnerStudyGuideSplitProvider(), array_flip($shared));
    }

    /**
     * @dataProvider beginnerStudyGuideSplitProvider
     */
    public function testBeginnerSeason18SplitsMatchStudyGuide(string $ref, int $expectedSplit, string $expectedAnswer): void
    {
        [$chapter, $verseKey] = explode(':', $ref);

        $factory = new SeasonFactory(__DIR__ . '/../data');
        $season = $factory->getSeasonById('18', SeasonFactory::PROGRAM_BEGINNER);
        $this->assertNotNull($season);

        $meta = $season->getMemoryVerses()['books']['44']['chapters'][$chapter]['verses'][$verseKey];
        $text = $this->textResolver->getCombinedText(44, (int) $chapter, $verseKey);
        $split = $this->counter->splitAt($text, $meta['split_after_word']);

        $this->assertSame($expectedSplit, $meta['split_after_word'], "$ref split_after_word");
        $this->assertSame(
            self::normalizeStudyGuideText($expectedAnswer),
            self::normalizeStudyGuideText($split['answer']),
            "$ref answer text"
        );
    }

    /**
     * @dataProvider teenSharedStudyGuideSplitProvider
     */
    public function testTeenSeason18SharedSingleVerseSplitsMatchStudyGuide(string $ref, int $expectedSplit, string $expectedAnswer): void
    {
        [$chapter, $verseKey] = explode(':', $ref);

        $factory = new SeasonFactory(__DIR__ . '/../data');
        $season = $factory->getSeasonById('18');
        $this->assertNotNull($season);

        $meta = $season->getMemoryVerses()['books']['44']['chapters'][$chapter]['verses'][$verseKey];
        $text = $this->textResolver->getCombinedText(44, (int) $chapter, $verseKey);
        $split = $this->counter->splitAt($text, $meta['split_after_word']);

        $this->assertSame($expectedSplit, $meta['split_after_word'], "$ref split_after_word");
        $this->assertSame(
            self::normalizeStudyGuideText($expectedAnswer),
            self::normalizeStudyGuideText($split['answer']),
            "$ref answer text"
        );
    }

    /**
     * @dataProvider seasonProgramProvider
     */
    public function testMemoryVerseSplitPositionsAreValid(string $seasonId, ?string $program): void
    {
        $factory = new SeasonFactory(__DIR__ . '/../data');
        $season = $factory->getSeasonById($seasonId, $program);
        $this->assertNotNull($season);

        $invalid = $this->collectInvalidSplitPositions($season->getMemoryVerses());

        $this->assertSame([], $invalid, 'Invalid split_after_word values found: ' . implode('; ', $invalid));
    }

    /**
     * @return list<array{0: string, 1: ?string}>
     */
    public static function seasonProgramProvider(): array
    {
        $cases = [];

        foreach (['16', '17', '18'] as $seasonId) {
            $cases["season {$seasonId} teen"] = [$seasonId, null];
            $cases["season {$seasonId} beginner"] = [$seasonId, SeasonFactory::PROGRAM_BEGINNER];
        }

        return $cases;
    }

    private static function normalizeStudyGuideText(string $text): string
    {
        $text = preg_replace('/\s+/', ' ', trim($text));
        $text = preg_replace('/\s*([—–-])\s*/u', ' $1 ', $text);
        $text = preg_replace('/\s+([\"\'\x{201C}\x{201D}\x{2018}\x{2019}])/u', '$1', $text);
        $text = preg_replace('/([\"\'\x{201C}\x{201D}\x{2018}\x{2019}])\s+/u', '$1', $text);

        return trim($text);
    }

    /**
     * @param array<string, mixed> $memoryVerses
     * @return list<string>
     */
    private function collectInvalidSplitPositions(array $memoryVerses): array
    {
        $invalid = [];

        foreach ($memoryVerses['books'] as $book => $bookData) {
            foreach ($bookData['chapters'] as $chapter => $chapterData) {
                foreach ($chapterData['verses'] as $verseKey => $meta) {
                    if (! is_array($meta)) {
                        continue;
                    }

                    try {
                        $text = $this->textResolver->getCombinedText((int) $book, (int) $chapter, (string) $verseKey);
                    } catch (\Throwable $exception) {
                        $invalid[] = sprintf(
                            '%s:%s:%s missing verse text (%s)',
                            $book,
                            $chapter,
                            $verseKey,
                            $exception->getMessage()
                        );
                        continue;
                    }

                    $splitAfterWord = (int) $meta['split_after_word'];
                    if (! $this->counter->isValidSplitPosition($text, $splitAfterWord)) {
                        $invalid[] = sprintf(
                            '%s:%s:%s split_after_word=%d (word count=%d)',
                            $book,
                            $chapter,
                            $verseKey,
                            $splitAfterWord,
                            $this->counter->countWords($text)
                        );
                    }
                }
            }
        }

        return $invalid;
    }
}
