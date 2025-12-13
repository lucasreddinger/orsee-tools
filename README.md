# orsee-tools

Supplemental utilities for [ORSEE](https://github.com/orsee/orsee).

## Batch searching participants in ORSEE

This tool lets you input a list of free-text search strings (one per line) and step through them in manageable ORSEE search batches.

**Example use case.** You receive hundreds of bounced emails and want to unsubscribe the corresponding participants. ORSEE cannot realistically search for hundreds of strings at once, and doing it manually is tedious.  
`orsee_batch_search.html` generates and opens batched ORSEE searches for you.

### Preparing input data

If you need to extract recipient addresses from emails, one option is:

1. Install Thunderbird with the *ImportExportTools* add-on  
2. Select multiple emails → right-click → export as CSV  
3. Run `extract_recipients.py` to extract one address per line  
4. Load the resulting file into `orsee_batch_search.html`

