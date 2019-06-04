<?php
declare(strict_types=1);

namespace Smile\GdprDump\Tests\Converter\Setter;

use Smile\GdprDump\Converter\Setter\SetValue;
use Smile\GdprDump\Tests\TestCase;

class SetValueTest extends TestCase
{
    /**
     * Test the converter.
     */
    public function testConverter()
    {
        $parameters = [
            'value' => 1,
        ];

        $converter = new SetValue($parameters);

        $value = $converter->convert('notAnonymized');
        $this->assertSame(1, $value);
    }

    /**
     * Check if an exception is thrown when the value is not set.
     *
     * @expectedException \InvalidArgumentException
     */
    public function testValueNotSet()
    {
        new SetValue([]);
    }
}
