# Fetch

A library focused on reading emails and attachments, primarily using the POP and IMAP protocols.

## Installing

 > N.b. A note on Ubuntu 14.04 (probably other Debian-based / Apt managed
 > systems), the install of php5-imap does not enable the extension for CLI
 > (possibly others as well), which can cause composer to report fetch
 > requires `ext-imap`

 ```sh
sudo ln -s /etc/php5/mods-available/imap.ini /etc/php5/cli/conf.d/30-imap.ini
 ```

### Composer

Installing Fetch can be done through a Composer.

Until Fetch reaches a stable API with version 1.0 it is recommended that you
review changes before even Minor updates, although bug fixes will always be
backwards compatible.

```json
"repositories": [
    {
        "type": "vcs",
        "url": "git@github.com:pdffiller/Fetch.git"
    }
],
"require": {
    "tedivm/fetch": "^0.8"
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

Fetch is licensed under the BSD License. See the LICENSE file for details.

[:releases:]: https://github.com/tedious/Fetch/releases
