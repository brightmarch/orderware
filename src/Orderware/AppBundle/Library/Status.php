<?php

namespace Orderware\AppBundle\Library;

class Status
{

    /** @const integer */
    const DISABLED = 0;

    /** @const integer */
    const ENABLED = 1;

    /** @const integer */
    const FEED_ENQUEUED = 500;

    /** @const integer */
    const FEED_PROCESSING = 510;

    /** @const integer */
    const FEED_PROCESSED = 520;

    /** @const integer */
    const ITEM_AVAILABLE = 600;

    /** @const integer */
    const ITEM_UNAVAILABLE = 610;

    /** @const integer */
    const LEDGER_OPEN = 300;

    /** @const integer */
    const LEDGER_INVOICED = 310;

    /** @const integer */
    const LEDGER_SETTLED = 320;

    /** @const integer */
    const LINE_OPEN = 200;

    /** @const integer */
    const LINE_CANCELED = 210;

    /** @const integer */
    const LINE_RETURNED = 220;

    /** @const integer */
    const LINE_CLOSED = 230;

    /** @const integer */
    const ORDER_OPEN = 100;

    /** @const integer */
    const ORDER_CANCELED = 110;

    /** @const integer */
    const ORDER_RETURNED = 120;

    /** @const integer */
    const ORDER_CLOSED = 130;

    /** @const integer */
    const ORDER_IMPORT_ENQUEUED = 180;

    /** @const integer */
    const ORDER_IMPORT_PROCESSING = 181;

    /** @const integer */
    const ORDER_IMPORT_PROCESSED = 182;

    /** @const integer */
    const PICK_TICKET_OPEN = 140;

    /** @const integer */
    const PICK_TICKET_SENT = 150;

    /** @const integer */
    const PICK_TICKET_INVOICED = 160;

    /** @const integer */
    const PICK_TICKET_CLOSED = 170;

    /** @const integer */
    const LOCK_INSUFFICIENT_PAYMENTS = 1000;

    /** @const integer */
    const LOCK_FRAUD_ALERT = 1100;

    /** @var array */
    public static $statuses = [
        self::DISABLED => 'Disabled',
        self::ENABLED => 'Enabled',
        self::FEED_ENQUEUED => 'Enqueued',
        self::FEED_PROCESSING => 'Processing',
        self::FEED_PROCESSED => 'Processed'
    ];

}
