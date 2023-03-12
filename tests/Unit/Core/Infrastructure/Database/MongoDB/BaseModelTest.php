<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Infrastructure\Database\MongoDB;

use Module\Core\Infrastructure\Database\MongoDB\BaseModel;
use MongoDB\BSON\UTCDateTime;
use PHPUnit\Framework\TestCase;

class BaseModelTest extends TestCase
{
    public function testConvertsBsonToString()
    {
        $dateTime = new UTCDateTime(strtotime('2022-12-31 23:59:59') * 1000);
        $baseModel = new BaseModel();

        $stringDate = $baseModel->fromBsonToString($dateTime);

        $this->assertEquals($dateTime->toDateTime()->format('Y-m-d H:i:s'), $stringDate);
    }

    public function testConvertsBsonToStrinHandlesNullValue()
    {
        $baseModel = new BaseModel();

        $dateTime = $baseModel->fromBsonToString(null);

        $this->assertNull($dateTime);
    }

    public function testConvertsStringToBson()
    {
        $stringDate = '2022-12-31 23:59:59';
        $baseModel = new BaseModel();

        $dateTime = $baseModel->toBson($stringDate);

        $this->assertInstanceOf(UTCDateTime::class, $dateTime);
        $this->assertEquals(strtotime($stringDate) * 1000, $dateTime->__toString());
    }

    public function testConvertsStringToBsonHandlesNullValue()
    {
        $baseModel = new BaseModel();

        $dateTime = $baseModel->toBson(null);

        $this->assertNull($dateTime);
    }
}
