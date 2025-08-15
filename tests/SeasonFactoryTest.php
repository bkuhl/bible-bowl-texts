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
        $this->factory = new SeasonFactory();
    }

    public function testGetSeasonById(): void
    {
        $season = $this->factory->getSeasonById('16');
        
        $this->assertIsArray($season);
        $this->assertEquals('16', $season['id']);
        $this->assertEquals('2025 Fall', $season['name']);
        $this->assertIsArray($season['text']);
        $this->assertArrayHasKey('ranges', $season['text']);
        $this->assertCount(2, $season['text']['ranges']); // 2 ranges: 16-24, 26-31
        
        // Check first range (16-24)
        $range1 = $season['text']['ranges'][0];
        $this->assertEquals(9, $range1['start']['book']); // 1 Samuel
        $this->assertEquals(16, $range1['start']['chapter']);
        $this->assertEquals(9, $range1['end']['book']); // 1 Samuel
        $this->assertEquals(24, $range1['end']['chapter']);
        
        // Check second range (26-31)
        $range2 = $season['text']['ranges'][1];
        $this->assertEquals(9, $range2['start']['book']); // 1 Samuel
        $this->assertEquals(26, $range2['start']['chapter']);
        $this->assertEquals(9, $range2['end']['book']); // 1 Samuel
        $this->assertEquals(31, $range2['end']['chapter']);
    }

    public function testSeasonHasExclusions(): void
    {
        $season = $this->factory->getSeasonById('16');
        
        $this->assertIsArray($season);
        
        // Check that chapter 25 is excluded by verifying we have 2 ranges: 16-24 and 26-31
        $ranges = $season['text']['ranges'];
        $this->assertCount(2, $ranges);
        
        // First range should end at 24
        $this->assertEquals(24, $ranges[0]['end']['chapter']);
        
        // Second range should start at 26 (skipping 25)
        $this->assertEquals(26, $ranges[1]['start']['chapter']);
    }

    public function testGetSeasonByName(): void
    {
        $season = $this->factory->getSeasonByName('2025 Fall');
        
        $this->assertIsArray($season);
        $this->assertEquals('16', $season['id']);
        $this->assertEquals('2025 Fall', $season['name']);
    }

    public function testSeasonHasBlocks(): void
    {
        $season = $this->factory->getSeasonById('16');
        
        $this->assertIsArray($season);
        $this->assertArrayHasKey('blocks', $season);
        $this->assertCount(3, $season['blocks']);
        
        // Check that blocks are keyed by number
        $this->assertArrayHasKey('1', $season['blocks']);
        $this->assertArrayHasKey('2', $season['blocks']);
        $this->assertArrayHasKey('3', $season['blocks']);
        
        // Check block 1 structure (chapters 16-19)
        $block1Data = $season['blocks']['1'];
        $this->assertArrayHasKey('ranges', $block1Data);
        $this->assertCount(1, $block1Data['ranges']); // One range covering 16-19
        
        $range1 = $block1Data['ranges'][0];
        $this->assertEquals(9, $range1['start']['book']); // 1 Samuel
        $this->assertEquals(16, $range1['start']['chapter']);
        $this->assertEquals(9, $range1['end']['book']); // 1 Samuel
        $this->assertEquals(19, $range1['end']['chapter']);
        
        // Check block 2 structure (chapters 20-24)
        $block2Data = $season['blocks']['2'];
        $this->assertCount(1, $block2Data['ranges']); // One range covering 20-24
        $range2 = $block2Data['ranges'][0];
        $this->assertEquals(9, $range2['start']['book']); // 1 Samuel
        $this->assertEquals(20, $range2['start']['chapter']);
        $this->assertEquals(9, $range2['end']['book']); // 1 Samuel
        $this->assertEquals(24, $range2['end']['chapter']);
        
        // Check block 3 structure (chapters 26-31)
        $block3Data = $season['blocks']['3'];
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

    public function testGetAllSeasons(): void
    {
        $seasons = $this->factory->getAllSeasons();
        
        $this->assertIsArray($seasons);
        $this->assertCount(1, $seasons);
        
        $season = $seasons[0];
        $this->assertEquals('16', $season['id']);
        $this->assertEquals('2025 Fall', $season['name']);
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
    }

    public function testDirectBlockAccess(): void
    {
        $season = $this->factory->getSeasonById('16');
        
        $this->assertIsArray($season);
        
        // Test direct access to block data
        $this->assertArrayHasKey('1', $season['blocks']);
        $this->assertArrayHasKey('2', $season['blocks']);
        $this->assertArrayHasKey('3', $season['blocks']);
        
        // Test that we can directly access block ranges
        $block2Ranges = $season['blocks']['2']['ranges'];
        $this->assertIsArray($block2Ranges);
        $this->assertCount(1, $block2Ranges); // Block 2 has one range covering 20-24
        
        $range = $block2Ranges[0];
        $this->assertEquals(20, $range['start']['chapter']);
        $this->assertEquals(24, $range['end']['chapter']); // Range covering chapters 20-24
    }
} 