# Bible Bowl Texts

A PHP library for managing Bible quiz text by seasons and blocks. This library generates and manages JSON files representing study text for Bible quiz programs, with easy access to the entire season's text and smaller segments called "blocks." Supports multiple programs (Team and Beginner) with different text ranges and memory verses.

## Features

- **Multi-Program Support**: Separate data for Team and Beginner programs
- **Memory Verses**: Support for memory verse collections with book, chapter, and verse references
- **Efficient JSON Format**: Compatible with the [`bkuhl/scripture-ranges`](https://github.com/bkuhl/scripture-ranges) package format
- **Multi-Book Support**: Can handle ranges spanning multiple books
- **Direct Block Access**: Blocks are stored as objects keyed by number for O(1) lookup
- **Concise Chapter Ranges**: Uses efficient chapter ranges (e.g., 16-24) instead of individual chapters
- **Factory Pattern**: Easy instantiation of season and block data by ID or name

## Installation

```bash
composer require bkuhl/bible-bowl-texts
```

## Usage

```php
use BKuhl\BibleBowlTexts\SeasonFactory;

$factory = new SeasonFactory();

// Get season by ID (defaults to null program)
$season = $factory->getSeasonById('16');
echo $season->getName(); // "2025 Fall"

// Get season by ID for specific program
$defaultSeason = $factory->getSeasonById('16');
$beginnerSeason = $factory->getSeasonById('16', SeasonFactory::PROGRAM_BEGINNER);

// Get season by name
$season = $factory->getSeasonByName('2025 Fall');

// Get all seasons for a program
$allDefaultSeasons = $factory->getAllSeasons();
$allBeginnerSeasons = $factory->getAllSeasons(SeasonFactory::PROGRAM_BEGINNER);

// Get a specific block
$block = $factory->getBlock('16', 1);
echo $block['number']; // 1

// Get memory verses (explicit structure)
$memoryVerses = $factory->getMemoryVerses('16');
$chapter16Verses = $memoryVerses['books']['9']['chapters']['16']['verses']; // [1, 7, 13, 18]

// Get memory verses (flattened structure)
$memoryVersesFlattened = $factory->getMemoryVersesFlattened('16');
foreach ($memoryVersesFlattened as $verse) {
    echo "Book: {$verse['book']}, Chapter: {$verse['chapter']}, Verse: {$verse['verse']}";
}
```

## Data Structure

### Directory Layout

```
data/
├── 16.json              # Team program data
└── beginner/
    └── 16.json          # Beginner program data
```

### JSON Structure

The library generates efficient JSON files with the following structure:

```json
{
    "id": "16",
    "name": "2025 Fall",
    "text": {
        "ranges": [
            {
                "start": {
                    "book": 9,
                    "chapter": 16
                },
                "end": {
                    "book": 9,
                    "chapter": 24
                }
            },
            {
                "start": {
                    "book": 9,
                    "chapter": 26
                },
                "end": {
                    "book": 9,
                    "chapter": 31
                }
            }
        ]
    },
    "blocks": {
        "1": {
            "ranges": [
                {
                    "start": {
                        "book": 9,
                        "chapter": 16
                    },
                    "end": {
                        "book": 9,
                        "chapter": 19
                    }
                }
            ]
        },
        "2": {
            "ranges": [
                {
                    "start": {
                        "book": 9,
                        "chapter": 20
                    },
                    "end": {
                        "book": 9,
                        "chapter": 24
                    }
                }
            ]
        },
        "3": {
            "ranges": [
                {
                    "start": {
                        "book": 9,
                        "chapter": 26
                    },
                    "end": {
                        "book": 9,
                        "chapter": 31
                    }
                }
            ]
        }
    },
    "memory_verses": {
        "books": {
            "9": {
                "chapters": {
                    "16": {
                        "verses": [1, 7, 13, 18]
                    },
                    "17": {
                        "verses": [26, 36, 37, 45, 46, 47, 50]
                    },
                    "18": {
                        "verses": [12, 30]
                    }
                }
            }
        }
    }
}
```

### Key Features of the JSON Format:

- **Multi-Program Support**: Separate JSON files for Team and Beginner programs
- **Memory Verses**: Explicit structure with books → chapters → verses hierarchy
- **Efficient Chapter Ranges**: Uses single range objects for multi-chapter spans (e.g., chapters 16-24)
- **Multi-Book Support**: Can represent ranges spanning multiple books
- **Direct Block Access**: Blocks are keyed by number (`"1"`, `"2"`, `"3"`) for O(1) lookup
- **ScriptureRanges Compatible**: Uses the `BKuhl\ScriptureRanges` composer package for range building

## Programs

### Team Program
The default program with full text coverage and comprehensive memory verses.

### Beginner Program
A simplified program with reduced text coverage and fewer memory verses, stored in the `data/beginner/` directory.

## Current Season Data

### Season 16: 2025 Fall

#### Team Program
- **Text**: 1 Samuel 16-31 (without chapter 25)
- **Block 1**: 1 Samuel 16-19
- **Block 2**: 1 Samuel 20-24  
- **Block 3**: 1 Samuel 26-31
- **Memory Verses**: 3 verses (1 Samuel 16:7, 17:45, 18:3)

#### Beginner Program
- **Text**: 1 Samuel 16-20
- **Block 1**: 1 Samuel 16-18
- **Block 2**: 1 Samuel 19-20
- **Memory Verses**: 2 verses (1 Samuel 16:7, 17:45)

## Generating Season Data

Use the included script to generate new season data:

```bash
php scripts/generate-season-data.php
```

This script uses the `bkuhl/scripture-ranges` package to build proper range objects with:
- `ChapterRange` objects for efficient multi-chapter spans
- No manual verse specification (whole chapters automatically handled)
- Book objects from `bkuhl/bible-csb` package

## Testing

```bash
composer test
```

## Requirements

- PHP 8.1+
- Compatible with `bkuhl/scripture-ranges` package format

## License

MIT 