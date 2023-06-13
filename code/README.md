# Code

## Generating data

### IF

Export views from SQLite and upload to ChecklistBank.

### IPNI

Export views from SQLite and upload to ChecklistBank.

### ION

Export `names` table as TSV then run scripts to generate `names.tsv` and `references.tsv`


## Generating figures

### Decade coverage

Create web-based figures of coverage of top journals across decades.

```
php if-coverage.php
```

Generates `fungi.html` which is HTML table. View in a web browser, save as PDF, open in graphics program to edit if desired. Repeat for `ipni-coverage.php` and `biomes-coverage.php`.

### Tails

Data for “long tail” figures is generated using `*-tail.php` files. Pipe output from each to a TSV file, then use charting program to display.

### Raw counts

Use `*-counts.php` to get TSV output of numbers of names and number of names with different PIDS. Merge into a table.

## Generating triples

### ORCID

See https://github.com/rdmpage/ld-orcid for code to generate triples

### IF, IPNI, ION

Each project has script `php export-triples.php` to generate a N-Triples file.

### Triple store

[to do]


