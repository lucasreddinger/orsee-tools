#!/usr/bin/env python3
import csv
import re
import sys
from collections import OrderedDict

#### config begin

OUTPUT_ORDER = "sorted"     # "sorted" = case-insensitive sort
                            # "seen"   = preserve order of first instance

#### config end

EMAIL_RE = re.compile(r"[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}", re.I)

FINAL_RECIP_RE = re.compile(r"Final-recipient:\s*RFC822;\s*(.+)", re.I)
ORIG_RECIP_RE  = re.compile(r"Original-Recipient:\s*rfc822;\s*(.+)", re.I)
RCPT_ADDR_RE   = re.compile(r"Recipient Address:\s*(.+)", re.I)

FAIL_BLOCK_RE = re.compile(
    r"Delivery has failed to these recipients or groups:\s*(.+?)(?:\r?\n\r?\n|$)",
    re.I | re.S
)

def extract_recipients_from_text(text: str) -> list[str]:
    hits: list[str] = []

    for m in FINAL_RECIP_RE.findall(text):
        hits += EMAIL_RE.findall(m)
    for m in ORIG_RECIP_RE.findall(text):
        hits += EMAIL_RE.findall(m)
    for m in RCPT_ADDR_RE.findall(text):
        hits += EMAIL_RE.findall(m)
    for blk in FAIL_BLOCK_RE.findall(text):
        hits += EMAIL_RE.findall(blk)

    return hits

def main(in_csv: str, out_csv: str, ignore: set[str]) -> None:
    seen = OrderedDict()

    with open(in_csv, "r", newline="", encoding="utf-8", errors="replace") as f:
        reader = csv.reader(f)
        for row in reader:
            if not row:
                continue

            text = "\n".join(row)
            for e in extract_recipients_from_text(text):
                key = e.lower()
                if key in ignore:
                    continue
                if key not in seen:
                    seen[key] = e

    if OUTPUT_ORDER == "sorted":
        email_list = sorted(seen.values(), key=lambda s: s.lower())
    elif OUTPUT_ORDER == "seen":
        email_list = list(seen.values())
    else:
        raise ValueError("OUTPUT_ORDER must be 'sorted' or 'seen'")

    with open(out_csv, "w", newline="", encoding="utf-8") as f:
        w = csv.writer(f)
        for e in email_list:
            w.writerow([e])

if __name__ == "__main__":
    if len(sys.argv) < 3:
        print(f"usage: {sys.argv[0]} messages.csv recipients.csv [ignore1@x] [ignore2@y] ...", file=sys.stderr)
        print("  messages.csv is an input file containing email messages,")
        print("  recipients.csv is an output file containing email recipients,")
        print("  and any further arguments are email addresses to be ignored.")
        sys.exit(2)

    in_csv, out_csv = sys.argv[1], sys.argv[2]
    ignore = {a.lower() for a in sys.argv[3:]}
    main(in_csv, out_csv, ignore)

