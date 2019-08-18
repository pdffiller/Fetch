<?php

namespace Fetch;

use ArrayObject;
use Fetch\Exception\InvalidStreamException;
use Fetch\Exception\InvalidMessageOverviewException;

class MessageOverview extends ArrayObject
{
    public function __construct(Server $server, $uid, $charset)
    {
        $imapStream = $server->getImapStream();

        if (!is_resource($imapStream)) {
            throw new InvalidStreamException(
                "Unable to get message overview. The IMAP stream is not initialized."
            );
        }

        $results = imap_fetch_overview($imapStream, $uid, FT_UID);

        if (!is_array($results) || empty($results)) {
            throw new InvalidMessageOverviewException(
                'Unable to fetch overview: ' . imap_last_error()
            );
        }

        // returns an array, and since we just want one message we can grab the only result
        $overview = $this->setUpOverview(array_shift($results), $charset);

        parent::__construct(json_decode(json_encode($overview), true));
    }

    protected function setUpOverview($overview, $charset)
    {
        if (empty($overview->date)) {
            $overview->date = null;
        } else {
            $overview->date = strtotime($overview->date);
        }

        if (!empty($overview->subject)) {
            $overview->subject = MIME::decode($overview->subject, $charset);
        } else {
            $overview->subject = '';
        }

        if (empty($overview->size)) {
            $overview->size = 0;
        }

        return $overview;
    }
}
