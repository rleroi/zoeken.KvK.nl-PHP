# zoeken.KvK.nl-PHP
Free Kamer van Koophandel (Dutch Chamber of Commerce) API. Uses zoeken.kvk.nl's json API, which is used on the kvk.nl website.

# Usage
``Kvk::search('test query');`` will return only the first 10 results.

``Kvk::searchAll('test query');`` does multiple requests to get all the search results of all pages.

The first parameter for both methods should be a string or array. If a string is used, it will search all fields.

If you use an associative array as first parameter, you can use the following optional fields to search in:
``handelsnaam
kvknummer
straat
postcode
huisnummer
plaats
hoofdvestiging
rechtspersoon
nevenvestiging
zoekvervallen
zoekuitgeschreven``

For example:
``Kvk::searchAll(['handelsnaam' => 'pizza', 'plaats' => 'Den Haag', 'hoofdvestiging' => 'true', 'nevenvestiging' => 'false', 'rechtspersoon' => 'false']);``
Will return all 'hoofdvestiging' companies in 'Den Haag' who have 'pizza' in the 'handelsnaam'.