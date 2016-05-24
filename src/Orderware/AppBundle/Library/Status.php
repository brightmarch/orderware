<?php

namespace Orderware\AppBundle\Library;

class Status
{

    /** @const integer */
    const DISABLED = 0;

    /** @const integer */
    const ENABLED = 1;

    /** @const integer */
    const FEED_QUEUED = 100;

    /** @const integer */
    const FEED_PROCESSING = 110;

    /** @const integer */
    const FEED_COMPLETED = 120;

    /** @const integer */
    const ITEM_ACTIVE = 600;

    /** @const integer */
    const ITEM_INACTIVE = 610;

}
