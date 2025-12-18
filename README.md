# orsee-tools

Supplemental utilities for [ORSEE](https://github.com/orsee/orsee).

## Batch searching participants in ORSEE

This tool facilitates searching for a large number of participants in ORSEE. This is tedious to do within the standard version of ORSEE. Further, ORSEE cannot handle searching for hundreds of strings at once. 

This tool lets you input a list of text search strings (one per line). It then divides the list into batches and allows you to search each batch individually. Stepping through each batch and searching for matching participants is then easy to manage.

**Example use case:** You receive hundreds of bounced emails and want to unsubscribe the corresponding participants. This tool makes the process easy!

### Usage

1. Download `orsee_batch_search.html` from this repository: click **Raw**, then *Save As*
2. Open the file in your web browser
3. Paste search strings or upload a file search strings (one participant per line)
4. Step through batches, opening each batch in ORSEE

> Note: GitHub displays HTML files as text. You must download the file and open it locally for the tool to work.

### Preparing input data

A python script is provided that can extract recipient email addresses from email messages.

1. Install Thunderbird with the *ImportExportTools* add-on
2. Select multiple emails → right-click → export as CSV
3. Run `extract_recipients.py` without arguments to see how it is used
4. Once you extract the email addresses, you can use the `orsee_batch_search.html` tool above
