<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Infrastructure;

use Module\Core\Infrastructure\UuidGenerator;
use Tests\TestCase;

class UuidGeneratorTest extends TestCase
{
    public function testThatCanGenerateUuid(): void
    {
        $this->assertNotEmpty(UuidGenerator::generate());
    }
}
