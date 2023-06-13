# Data

## Index Fungorum

Export the views `names_with_references` to `names.tsv` and `references` to `references.tsv`. Use tabs as delimiters, make sure to include the column headings. Make a release on Github using the current date YYYY-MM-DD as release version and tag, a DOI will be generated by Zenodo. Zip the two files and metadata.yml and upload to ChecklistBank.

## IPNI

Export the views `names_with_references` to `names.tsv` and `references` to `references.tsv`. Use tabs as delimiters, make sure to include the column headings. Make a release on Github using the current date YYYY-MM-DD as release version and tag, a DOI will be generated by Zenodo. Zip the two files and metadata.yml and upload to ChecklistBank.

## BioNames

Use `dump.php` to get tab-delimited dump from BioNames MySQL database. Run `parse.php`, manually setting `$mode` flag to generate either `names.tsv` or `references.tsv` files. Make a release on Github using the current date YYYY-MM-DD as release version and tag, a DOI will be generated by Zenodo. Zip the two files and metadata.yml and upload to ChecklistBank.