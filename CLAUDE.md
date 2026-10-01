# Claude Context for bible-bowl-texts

PHP library holding Bible Bowl study text per season: text ranges, blocks, and memory verses, as JSON
in `data/{seasonId}.json` (Teen/"Team" program) and `data/beginner/{seasonId}.json` (Beginner). Book
ids are canonical 1–66 (e.g. 9 = 1 Samuel, 44 = Acts). Consumers (e.g. the Play Bible Bowl app) render
this data directly to quizzers, so the wording in it is user-facing.

## Memory verses

### Shape

```json
"memory_verses": {
    "books": {
        "44": {
            "chapters": {
                "1": {
                    "verses": {
                        "3":   { "lead_in": "when Jesus presented himself alive", "split_after_word": 15 },
                        "4-5": { "lead_in": "when Jesus commanded the apostles", "split_after_word": 28 }
                    }
                }
            }
        }
    }
}
```

- `verses` is an **object keyed by verse key**, not a list. A key is one memory verse: a single verse
  (`"16"`), a range (`"3-4"`), or a comma list (`"35,37"`). Parse keys with `MemoryVerseReference::parse()`.
- Teen and Beginner files are independent: the same passage can have a different key, lead-in, or split
  per program (season 18 Teen has Acts 9:15-16, Beginner has Acts 9:15).
- Season 18 was authored directly in the JSON; `scripts/generate-season-data.php` only covers season 16.

### `lead_in` — the quizmaster's prompt (exact wording contract)

Consumers print `lead_in` **verbatim** after the reference, in the official question-set format:

```
Give {reference}, {lead_in}, for 10 points each quoted segment or 5 points if close:
```

e.g. `Give Acts 3:6, what Peter said to a lame man, for 10 points…`. Consumers add no words, so the
data must be exactly what the official question set prints between `Give <reference>,` and
`, for 10 points`:

- **Copy it from the official question set** (the season's memory verse list or competition PDFs). Do not
  paraphrase, summarise, or "fix" its grammar to a house style.
- It must read naturally after `Give Acts 3:6, `. It starts lower-case and is a complete phrase —
  "about …", "when …", "what …", "how …", "after …", "the answer to …" are all valid openers.
- Include **"about" only when the official text does**. Never add it as a default and never strip it;
  consumers rely on the data, not a prefix, so a missing or extra "about" shows up as broken phrasing.
- No reference, no "Give", no scoring text, no leading/trailing punctuation or whitespace. Quotes
  inside the phrase are fine (`when an angel said "Cornelius"`).
- It is **not scripture**. Don't confuse it with `BibleBowlWordCounter::splitAt()`'s `lead_in` key,
  which is the scripture the quizmaster reads aloud before the quizzer recites (same name, different
  thing).

When adding or editing lead-ins, read the result back in the printed form above. If it doesn't read as a
sentence a quizmaster would say, recheck it against the official source before committing.

### `split_after_word`

The number of words the quizmaster reads before the quizzer starts reciting, counted across the combined
text of every verse in the key using Bible Bowl word-counting rules (`BibleBowlWordCounter`; e.g.
`said,"you` is two words). Resolve the text with `MemoryVerseTextResolver::getCombinedText()`.
`tests/MemoryVerseSplitValidationTest.php` checks splits against the official study guide's answer
lines — extend it when adding a season.

## Testing

```bash
composer install
composer test
```
