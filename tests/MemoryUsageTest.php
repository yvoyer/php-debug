<?php declare(strict_types=1);

namespace Star\Debug;

use PHPUnit\Framework\TestCase;

final class MemoryUsageTest extends TestCase
{
    /**
     * @param string $expected
     * @param float $value
     *
     * @dataProvider provideToStringValues
     */
    public function test_it_should_output_the_usage_with_string_format(string $expected, float $value)
    {
        $this->assertSame($expected, MemoryUsage::fromFloat($value)->toString());
    }

    public static function provideToStringValues(): array
    {
        return [
            ['1023 bytes', 1023],
            ['1 kilobytes', 1024],
            ['1 megabytes', 1024 * 1024],
            ['1024 megabytes', 1024 * 1024 * 1024],
            'should ignore negative value' => ['1 kilobytes', -1024],
        ];
    }
}
