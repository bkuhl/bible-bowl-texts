<?php

declare(strict_types=1);

namespace BKuhl\BibleBowlTexts\Tests;

use BKuhl\BibleBowlTexts\SeasonFactory;
use PHPUnit\Framework\TestCase;

class SeasonFactoryTest extends TestCase
{
    private SeasonFactory $factory;

    protected function setUp(): void
    {
        $this->factory = new SeasonFactory(__DIR__ . '/data');
    }

    public function testGetSeasonById(): void
    {
        $season = $this->factory->getSeasonById('16');
        
        $this->assertInstanceOf(\BKuhl\BibleBowlTexts\Season::class, $season);
        $this->assertEquals('16', $season->getId());
        $this->assertEquals('2025 Fall', $season->getName());
        $this->assertIsArray($season->getText());
        $this->assertArrayHasKey('ranges', $season->getText());
        $this->assertCount(2, $season->getText()['ranges']); // 2 ranges: 16-24, 26-31
        
        // Check first range (16-24)
        $range1 = $season->getText()['ranges'][0];
        $this->assertEquals(9, $range1['start']['book']); // 1 Samuel
        $this->assertEquals(16, $range1['start']['chapter']);
        $this->assertEquals(9, $range1['end']['book']); // 1 Samuel
        $this->assertEquals(24, $range1['end']['chapter']);
        
        // Check second range (26-31)
        $range2 = $season->getText()['ranges'][1];
        $this->assertEquals(9, $range2['start']['book']); // 1 Samuel
        $this->assertEquals(26, $range2['start']['chapter']);
        $this->assertEquals(9, $range2['end']['book']); // 1 Samuel
        $this->assertEquals(31, $range2['end']['chapter']);
    }

    public function testGetSeasonByIdWithProgram(): void
    {
        // Test default program (null)
        $season = $this->factory->getSeasonById('16');
        $this->assertInstanceOf(\BKuhl\BibleBowlTexts\Season::class, $season);
        $this->assertEquals('16', $season->getId());
        $this->assertCount(2, $season->getText()['ranges']); // Default has 2 ranges
        
        // Test beginner program
        $season = $this->factory->getSeasonById('16', SeasonFactory::PROGRAM_BEGINNER);
        $this->assertInstanceOf(\BKuhl\BibleBowlTexts\Season::class, $season);
        $this->assertEquals('16', $season->getId());
        $this->assertCount(8, $season->getText()['ranges']); // Beginner has 8 specific ranges
    }

    public function testSeasonHasExclusions(): void
    {
        $season = $this->factory->getSeasonById('16');
        
        $this->assertInstanceOf(\BKuhl\BibleBowlTexts\Season::class, $season);
        
        // Check that chapter 25 is excluded by verifying we have 2 ranges: 16-24 and 26-31
        $ranges = $season->getText()['ranges'];
        $this->assertCount(2, $ranges);
        
        // First range should end at 24
        $this->assertEquals(24, $ranges[0]['end']['chapter']);
        
        // Second range should start at 26 (skipping 25)
        $this->assertEquals(26, $ranges[1]['start']['chapter']);
    }

    public function testGetSeasonByName(): void
    {
        $season = $this->factory->getSeasonByName('2025 Fall');
        
        $this->assertInstanceOf(\BKuhl\BibleBowlTexts\Season::class, $season);
        $this->assertEquals('16', $season->getId());
        $this->assertEquals('2025 Fall', $season->getName());
    }

    public function testGetSeasonByNameWithProgram(): void
    {
        // Test default program (null)
        $season = $this->factory->getSeasonByName('2025 Fall');
        $this->assertInstanceOf(\BKuhl\BibleBowlTexts\Season::class, $season);
        $this->assertEquals('16', $season->getId());
        
        // Test beginner program
        $season = $this->factory->getSeasonByName('2025 Fall', SeasonFactory::PROGRAM_BEGINNER);
        $this->assertInstanceOf(\BKuhl\BibleBowlTexts\Season::class, $season);
        $this->assertEquals('16', $season->getId());
    }

    public function testSeasonHasBlocks(): void
    {
        $season = $this->factory->getSeasonById('16');
        
        $this->assertInstanceOf(\BKuhl\BibleBowlTexts\Season::class, $season);
        $this->assertIsArray($season->getBlocks());
        $this->assertCount(3, $season->getBlocks());
        
        // Check that blocks are keyed by number
        $this->assertArrayHasKey('1', $season->getBlocks());
        $this->assertArrayHasKey('2', $season->getBlocks());
        $this->assertArrayHasKey('3', $season->getBlocks());
        
        // Check block 1 structure (chapters 16-19)
        $block1Data = $season->getBlocks()['1'];
        $this->assertArrayHasKey('ranges', $block1Data);
        $this->assertCount(1, $block1Data['ranges']); // One range covering 16-19
        
        $range1 = $block1Data['ranges'][0];
        $this->assertEquals(9, $range1['start']['book']); // 1 Samuel
        $this->assertEquals(16, $range1['start']['chapter']);
        $this->assertEquals(9, $range1['end']['book']); // 1 Samuel
        $this->assertEquals(19, $range1['end']['chapter']);
        
        // Check block 2 structure (chapters 20-24)
        $block2Data = $season->getBlocks()['2'];
        $this->assertCount(1, $block2Data['ranges']); // One range covering 20-24
        $range2 = $block2Data['ranges'][0];
        $this->assertEquals(9, $range2['start']['book']); // 1 Samuel
        $this->assertEquals(20, $range2['start']['chapter']);
        $this->assertEquals(9, $range2['end']['book']); // 1 Samuel
        $this->assertEquals(24, $range2['end']['chapter']);
        
        // Check block 3 structure (chapters 26-31)
        $block3Data = $season->getBlocks()['3'];
        $this->assertCount(1, $block3Data['ranges']); // One range covering 26-31
        $range3 = $block3Data['ranges'][0];
        $this->assertEquals(9, $range3['start']['book']); // 1 Samuel
        $this->assertEquals(26, $range3['start']['chapter']);
        $this->assertEquals(9, $range3['end']['book']); // 1 Samuel
        $this->assertEquals(31, $range3['end']['chapter']);
    }

    public function testGetBlock(): void
    {
        $block = $this->factory->getBlock('16', 1);
        
        $this->assertIsArray($block);
        $this->assertEquals(1, $block['number']);
        $this->assertArrayHasKey('range', $block);
        $this->assertArrayHasKey('ranges', $block['range']);
        
        $range = $block['range']['ranges'][0];
        $this->assertEquals(9, $range['start']['book']); // 1 Samuel
        $this->assertEquals(16, $range['start']['chapter']);
        $this->assertEquals(9, $range['end']['book']); // 1 Samuel
        $this->assertEquals(19, $range['end']['chapter']); // Block 1 covers 16-19
    }

    public function testGetBlockWithProgram(): void
    {
        // Test default program (null)
        $block = $this->factory->getBlock('16', 1);
        $this->assertIsArray($block);
        $this->assertEquals(1, $block['number']);
        $this->assertEquals(19, $block['range']['ranges'][0]['end']['chapter']); // Default block 1 ends at 19
        
        // Test beginner program
        $block = $this->factory->getBlock('16', 1, SeasonFactory::PROGRAM_BEGINNER);
        $this->assertIsArray($block);
        $this->assertEquals(1, $block['number']);
        $this->assertCount(3, $block['range']['ranges']); // Beginner block 1 has 3 ranges (16:1-13, 17:1-58, 18:1-9)
    }

    public function testGetAllSeasons(): void
    {
        $seasons = $this->factory->getAllSeasons();

        $this->assertIsArray($seasons);
        $this->assertGreaterThanOrEqual(1, count($seasons));

        $season = $seasons[0];
        $this->assertInstanceOf(\BKuhl\BibleBowlTexts\Season::class, $season);
        $this->assertEquals('16', $season->getId());
        $this->assertEquals('2025 Fall', $season->getName());
    }

    public function testGetAllSeasonsWithProgram(): void
    {
        // Test default program (null)
        $seasons = $this->factory->getAllSeasons();
        $this->assertIsArray($seasons);
        $this->assertGreaterThanOrEqual(1, count($seasons));

        // Test beginner program
        $seasons = $this->factory->getAllSeasons(SeasonFactory::PROGRAM_BEGINNER);
        $this->assertIsArray($seasons);
        $this->assertGreaterThanOrEqual(1, count($seasons));
    }

    public function testInvalidSeasonReturnsNull(): void
    {
        $season = $this->factory->getSeasonById('999');
        $this->assertNull($season);
        
        $season = $this->factory->getSeasonByName('Nonexistent Season');
        $this->assertNull($season);
        
        $block = $this->factory->getBlock('999', 1);
        $this->assertNull($block);
        
        $block = $this->factory->getBlock('16', 999);
        $this->assertNull($block);
        
        $memoryVerses = $this->factory->getMemoryVerses('999');
        $this->assertNull($memoryVerses);
    }

    public function testDirectBlockAccess(): void
    {
        $season = $this->factory->getSeasonById('16');
        
        $this->assertInstanceOf(\BKuhl\BibleBowlTexts\Season::class, $season);
        
        // Test direct access to block data
        $this->assertArrayHasKey('1', $season->getBlocks());
        $this->assertArrayHasKey('2', $season->getBlocks());
        $this->assertArrayHasKey('3', $season->getBlocks());
        
        // Test that we can directly access block ranges
        $block2Ranges = $season->getBlocks()['2']['ranges'];
        $this->assertIsArray($block2Ranges);
        $this->assertCount(1, $block2Ranges); // Block 2 has one range covering 20-24
        
        $range = $block2Ranges[0];
        $this->assertEquals(20, $range['start']['chapter']);
        $this->assertEquals(24, $range['end']['chapter']); // Range covering chapters 20-24
    }

    public function testSeasonHasMemoryVerses(): void
    {
        $season = $this->factory->getSeasonById('16');
        
        $this->assertInstanceOf(\BKuhl\BibleBowlTexts\Season::class, $season);
        $this->assertIsArray($season->getMemoryVerses());
        
        // Check nested structure
        $this->assertArrayHasKey('books', $season->getMemoryVerses());
        $this->assertArrayHasKey('9', $season->getMemoryVerses()['books']);
        $this->assertArrayHasKey('chapters', $season->getMemoryVerses()['books']['9']);
        $this->assertArrayHasKey('16', $season->getMemoryVerses()['books']['9']['chapters']);
        $this->assertArrayHasKey('17', $season->getMemoryVerses()['books']['9']['chapters']);
        
        // Check specific verses
        $this->assertContains(1, $season->getMemoryVerses()['books']['9']['chapters']['16']['verses']);
        $this->assertContains(7, $season->getMemoryVerses()['books']['9']['chapters']['16']['verses']);
        $this->assertContains(45, $season->getMemoryVerses()['books']['9']['chapters']['17']['verses']);
    }

    public function testGetMemoryVerses(): void
    {
        $memoryVerses = $this->factory->getMemoryVerses('16');
        
        $this->assertIsArray($memoryVerses);
        
        // Check nested structure
        $this->assertArrayHasKey('books', $memoryVerses);
        $this->assertArrayHasKey('9', $memoryVerses['books']);
        $this->assertArrayHasKey('chapters', $memoryVerses['books']['9']);
        $this->assertArrayHasKey('16', $memoryVerses['books']['9']['chapters']);
        $this->assertContains(1, $memoryVerses['books']['9']['chapters']['16']['verses']); // First verse is 16:1
    }

    public function testGetMemoryVersesFlattened(): void
    {
        $memoryVerses = $this->factory->getMemoryVersesFlattened('16');
        
        $this->assertIsArray($memoryVerses);
        $this->assertCount(45, $memoryVerses);
        
        $verse1 = $memoryVerses[0];
        $this->assertEquals(9, $verse1['book']); // 1 Samuel
        $this->assertEquals(16, $verse1['chapter']);
        $this->assertEquals(1, $verse1['verse']); // First verse is 16:1
    }

    public function testGetMemoryVersesWithProgram(): void
    {
        // Test default program (null)
        $memoryVerses = $this->factory->getMemoryVerses('16');
        $this->assertIsArray($memoryVerses);
        $this->assertArrayHasKey('books', $memoryVerses);
        
        // Test beginner program
        $memoryVerses = $this->factory->getMemoryVerses('16', SeasonFactory::PROGRAM_BEGINNER);
        $this->assertIsArray($memoryVerses);
        $this->assertArrayHasKey('books', $memoryVerses);
        
        // Test flattened versions
        $defaultFlattened = $this->factory->getMemoryVersesFlattened('16');
        $this->assertCount(45, $defaultFlattened);
        
        $beginnerFlattened = $this->factory->getMemoryVersesFlattened('16', SeasonFactory::PROGRAM_BEGINNER);
        $this->assertCount(24, $beginnerFlattened);
    }

    public function testMemoryVersesSupportsVerseRanges(): void
    {
        // Test that a SINGLE memory verse can span MULTIPLE verse numbers
        // This is critical functionality for Bible Bowl where one memory verse
        // may include content from multiple consecutive or non-consecutive Bible verses
        $season = $this->factory->getSeasonById('17');

        $this->assertInstanceOf(\BKuhl\BibleBowlTexts\Season::class, $season);

        $memoryVerses = $season->getMemoryVerses();
        $this->assertIsArray($memoryVerses);
        $this->assertArrayHasKey('books', $memoryVerses);
        $this->assertArrayHasKey('45', $memoryVerses['books']); // Romans

        $romans = $memoryVerses['books']['45'];
        $this->assertArrayHasKey('chapters', $romans);

        // Test Case 1: Single memory verse spanning consecutive verses (Romans 1:3-4)
        // This represents ONE memory verse that includes both verse 3 AND verse 4
        $chapter1Verses = $romans['chapters']['1']['verses'];
        $this->assertArrayHasKey('3-4', $chapter1Verses, 'Memory verse key should support consecutive verse ranges like "3-4"');
        $this->assertIsArray($chapter1Verses['3-4']);
        $this->assertArrayHasKey('lead_in', $chapter1Verses['3-4']);
        $this->assertArrayHasKey('split_after_word', $chapter1Verses['3-4']);
        $this->assertEquals('about Jesus Christ', $chapter1Verses['3-4']['lead_in']);

        // Test Case 2: Single memory verse spanning three consecutive verses (Romans 2:9-11)
        // This represents ONE memory verse that includes verses 9, 10, AND 11
        $chapter2Verses = $romans['chapters']['2']['verses'];
        $this->assertArrayHasKey('9-11', $chapter2Verses, 'Memory verse key should support multi-verse ranges like "9-11"');
        $this->assertIsArray($chapter2Verses['9-11']);
        $this->assertArrayHasKey('lead_in', $chapter2Verses['9-11']);
        $this->assertEquals('about favoritism', $chapter2Verses['9-11']['lead_in']);

        // Test Case 3: Multiple memory verses with verse ranges in the same chapter
        $chapter3Verses = $romans['chapters']['3']['verses'];
        $this->assertArrayHasKey('9-10', $chapter3Verses, 'Should support verse range "9-10"');
        $this->assertArrayHasKey('23-24', $chapter3Verses, 'Should support verse range "23-24"');

        // Verify these are distinct memory verses, not overlapping
        $this->assertNotEquals(
            $chapter3Verses['9-10']['lead_in'],
            $chapter3Verses['23-24']['lead_in'],
            'Different verse ranges should represent different memory verses'
        );

        // Test Case 4: Single memory verse with non-consecutive verses (Romans 8:35,37)
        // This represents ONE memory verse that includes verse 35 and verse 37 (skipping 36)
        $chapter8Verses = $romans['chapters']['8']['verses'];
        $this->assertArrayHasKey('35,37', $chapter8Verses, 'Memory verse key should support non-consecutive verses like "35,37"');
        $this->assertIsArray($chapter8Verses['35,37']);
        $this->assertArrayHasKey('lead_in', $chapter8Verses['35,37']);
        $this->assertArrayHasKey('split_after_word', $chapter8Verses['35,37']);
        $this->assertEquals('about conquerors', $chapter8Verses['35,37']['lead_in']);

        // Test Case 5: Single memory verse spanning two consecutive verses (Romans 8:1-2)
        $this->assertArrayHasKey('1-2', $chapter8Verses, 'Memory verse key should support verse range "1-2"');
        $this->assertEquals('about condemnation', $chapter8Verses['1-2']['lead_in']);
    }

    public function testMemoryVersesSupportsVerseRangesInBeginnerProgram(): void
    {
        // Test verse ranges in beginner program (Daniel and Jonah)
        $season = $this->factory->getSeasonById('17', SeasonFactory::PROGRAM_BEGINNER);

        $this->assertInstanceOf(\BKuhl\BibleBowlTexts\Season::class, $season);

        $memoryVerses = $season->getMemoryVerses();
        $this->assertIsArray($memoryVerses);
        $this->assertArrayHasKey('books', $memoryVerses);
        $this->assertArrayHasKey('27', $memoryVerses['books']); // Daniel

        $daniel = $memoryVerses['books']['27'];
        $this->assertArrayHasKey('chapters', $daniel);

        // Test Case: Daniel 1:11-12 as a verse range
        // This represents ONE memory verse spanning verses 11 AND 12
        $daniel1Verses = $daniel['chapters']['1']['verses'];
        $this->assertArrayHasKey('11-12', $daniel1Verses, 'Beginner program should support verse range "11-12" for Daniel 1:11-12');
        $this->assertIsArray($daniel1Verses['11-12']);
        $this->assertArrayHasKey('lead_in', $daniel1Verses['11-12']);
        $this->assertArrayHasKey('split_after_word', $daniel1Verses['11-12']);
        $this->assertEquals('what Daniel said to the guard', $daniel1Verses['11-12']['lead_in']);
    }

    public function testUsesStubData(): void
    {
        // Verify we're using test stub data, not actual data files
        $season = $this->factory->getSeasonById('16');

        $this->assertInstanceOf(\BKuhl\BibleBowlTexts\Season::class, $season);
        $this->assertEquals('16', $season->getId());
        $this->assertEquals('2025 Fall', $season->getName());

        // Verify the stub data structure matches our expectations
        $this->assertIsArray($season->getMemoryVerses());
        $this->assertArrayHasKey('books', $season->getMemoryVerses()); // Stub has explicit structure

        // Verify we're not accidentally using the actual data directory
        $reflection = new \ReflectionClass($this->factory);
        $dataPathProperty = $reflection->getProperty('dataPath');
        $dataPathProperty->setAccessible(true);
        $dataPath = $dataPathProperty->getValue($this->factory);

        $this->assertStringContainsString('/tests/data', $dataPath);
        $this->assertStringNotContainsString('/data/', $dataPath); // Should not be the actual data directory
    }
}