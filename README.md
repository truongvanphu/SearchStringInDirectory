# SearchStringInDirectory
PHP Search String In Directory

Searching for the contents of files in PHP is easy. However it can be slow when you need to search for data in many files.

This class provides an alternative that can be faster by using the grep command that is available in most Unix or Linux distributions, so it can search many files at once traversing directories recursively.

How to use
 1. Require class: `require_once 'SearchStringInDirectory.php';`
 2. Using: `$srch = new SearchStringInDirectory('/path/to/search/folder');`
 3. Using: `$result $srch->search("Search string");`

Example code in 'index.php' file.

Thank you !

# Donations
I highly appreciate any of your donations.

[![paypal](https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif)](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=FLHJAF2ECGXGQ)