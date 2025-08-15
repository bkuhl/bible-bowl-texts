# Bible Bowl Texts

A PHP library for managing Bible quiz text by seasons and blocks. This library generates and manages JSON files representing study text for Bible quiz programs, with easy access to the entire season's text and smaller segments called "blocks."

## Features

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

// Get season by ID
$season = $factory->getSeasonById('16');
echo $season['name']; // "2025 Fall"

// Get season by name
$season = $factory->getSeasonByName('2025 Fall');

// Get all seasons
$allSeasons = $factory->getAllSeasons();

// Get a specific block
$block = $factory->getBlock('16', 1);
echo $block['number']; // 1
```

## JSON Structure

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
    }
}
```

### Key Features of the JSON Format:

- **Efficient Chapter Ranges**: Uses single range objects for multi-chapter spans (e.g., chapters 16-24)
- **Multi-Book Support**: Can represent ranges spanning multiple books
- **Direct Block Access**: Blocks are keyed by number (`"1"`, `"2"`, `"3"`) for O(1) lookup
- **ScriptureRanges Compatible**: Follows the exact format used by `ScriptureRange::toArray()`

## Current Season Data

### Season 16: 2025 Fall
- **Text**: 1 Samuel 16-31 (without chapter 25)
- **Block 1**: 1 Samuel 16-19
- **Block 2**: 1 Samuel 20-24  
- **Block 3**: 1 Samuel 26-31

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