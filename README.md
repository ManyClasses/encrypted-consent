# Encrypted Consent

See [our blog post](https://www.manyclasses.org/updates/encrypted-consent/) on the ManyClasses website for the motivation for this project.

To use this script:

1. Update `config.php` if you wish. Pay special attention to the `$KEY_LENGTH` variable, which sets an upper bound on how many unique requests the consent script can handle. If `$KEY_LENGTH` is 3, then there are 900 unique keys -- `100` thru `999`. Roughly half of the keys will be consent and half dissent, so the script will run about 400 times before it runs out of unique keys. We exclude keys where the value would have a leading 0 so that Canvas's number field validator runs properly.
2. Upload all four `.php` files onto a webserver. Ensure that the folder that contains the `.php` files is writeable so that the sqlite database can be generated.
3. Run `setup.php` by going to the URL in your browser. With key lengths of 4 or more the script can take a while to run. It will print a message when it is complete.
4. Use `consent_buttons.php` to get consent values. You can embed this form in a Canvas quiz, for example.