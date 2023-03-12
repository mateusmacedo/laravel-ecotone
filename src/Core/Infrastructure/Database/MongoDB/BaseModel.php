<?php

declare(strict_types=1);

namespace Module\Core\Infrastructure\Database\MongoDB;

use Jenssegers\Mongodb\Eloquent\Model;
use MongoDB\BSON\UTCDateTime;

class BaseModel extends Model
{
    public function fromBsonToString(?UTCDateTime $dateTime): ?string
    {
        if (null === $dateTime) {
            return null;
        }

        return $dateTime->toDateTime()->format('Y-m-d H:i:s');
    }

    public function toBson(?string $dateTime): ?UTCDateTime
    {
        if (null === $dateTime) {
            return null;
        }

        return new UTCDateTime(new \DateTime($dateTime));
    }
}
