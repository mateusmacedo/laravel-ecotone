<?php

declare(strict_types=1);

namespace Module\Users\Infrastructure\Repository\MongoDB\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use MongoDB\BSON\UTCDateTime;

class BaseModel extends Model
{
    protected function fromBsonToString($dateTime): ?string
    {
        if (null === $dateTime) {
            return null;
        }

        return $dateTime->toDateTime()->format('Y-m-d H:i:s');
    }

    protected function toBson($dateTime): ?UTCDateTime
    {
        if (null === $dateTime) {
            return null;
        }

        return new UTCDateTime(new \DateTime($dateTime));
    }
}
