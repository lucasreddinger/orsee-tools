# orsee-tools

Supplemental utilities for [ORSEE](https://github.com/orsee/orsee).

## Batch searching participants in ORSEE

These tools facilitate searching for a large number of participants in ORSEE.

A Python script extracts email addresses from a large set of emails, removes duplicates, and sorts them.

A webpage provides an intuitive way to search for many participants in ORSEE at once. In the provided form you may enter multiple search queries, one per line, and return all matches at once. Alternately, you may input a file of strings (such as a text/CSV file of email addresses). The form provides a way to open manageable batches in ORSEE. In ORSEE you may then select all and make changes at once.

The batches are necessary to avoid overloading ORSEE. The webpage default to 40 participants per batch, but you can try a larger batch size.

Note that you keep the webpage tool locally! When you input a file, it does not go to the Internet. Your browser simply loads it locally using Javascript.

### Example use case

You have 1390 bounced emails and you want to unsubscribe those participants.

Using my Python tool, you extract all of the rejected email addresses from that set of emails. This provides a text/CSV file containing 576 unique and sorted email addresses.

Next, you log-in to ORSEE.

You then open the web-based search tool in your browser and input the text file. It loads the addresses and lets you search for 60 in ORSEE at a time. ***You can unsubscribe 576 paricipants with only 10 ORSEE searches.***

### Usage

1. Download `orsee_batch_search.html` from this repository: click [**Raw**](https://raw.githubusercontent.com/lucasreddinger/orsee-tools/refs/heads/master/orsee_batch_search.html), then *Save As*
2. Open the file in your web browser
3. Paste search strings or upload a file search strings (one participant per line)
4. Step through batches, opening each batch in ORSEE

> Note: GitHub displays HTML files as text. You must download the file and open it locally for the tool to work.

### Preparing input data

A Python script extracts recipient email addresses from email messages. You must first export email messages to a text file _en masse_. Thunderbird has a plug-in that can export many email amessages to a CSV file. You then use this script to extract email addresses for the recipients with failed delivery.

1. Install Thunderbird with the *ImportExportTools* add-on
2. Select multiple emails → right-click → export as CSV
3. Run `extract_recipients.py` without arguments to see how it is used
4. Once you extract the email addresses, you can use the `orsee_batch_search.html` tool above
