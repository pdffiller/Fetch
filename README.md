# Fetch

[![Build Status](https://travis-ci.org/pdffiller/Fetch.svg?branch=master)][:repo:]
[![Latest Stable Version](https://poser.pugx.org/pdffiller/fetch/v/stable)][:packagist:]

A library focused on reading emails and attachments, primarily using the POP and IMAP protocols.

## Installing

### Composer

Installing Fetch can be done through a Composer.

Until Fetch reaches a stable API with version 1.0 it is recommended that you
review changes before even Minor updates, although bug fixes will always be
backwards compatible.

```json
"require": {
    "pdffiller/fetch": "^0.8"
}
```

## Sample Usage

This is just a simple code to show how to access messages by using Fetch. It
uses Fetch own autoload, but it can (and should be, if applicable) replaced
with the one generated by composer.

```php
use Fetch\Server;
use Fetch\Message;

$server = new Server('imap.example.com', 993);
$server->setAuthentication('username', 'password');

/** @var Message[] $message */
$messages = $server->getMessages();

foreach ($messages as $message) {
    echo "Subject: {$message->getSubject()}", PHP_EOL;
    echo "Body: {$message->getMessageBody()}", PHP_EOL;
}
```

## License

Fetch is is open source software licensed under the MIT License.
See the [`LICENSE.txt`](LICENSE.txt) file for more.

© 2017-2018 PDFfiller <br>
© 2009-2017 Robert Hafner <br>

All rights reserved.

[:releases:]: https://github.com/tedious/Fetch/releases
[:repo:]: https://github.com/pdffiller/Fetch
[:packagist:]: https://packagist.org/packages/pdffiller/fetch
