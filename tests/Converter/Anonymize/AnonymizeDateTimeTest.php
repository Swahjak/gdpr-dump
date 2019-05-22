<?php
declare(strict_types=1);

namespace Smile\Anonymizer\Tests\Converter\Anonymize;

use Smile\Anonymizer\Converter\Anonymizer\AnonymizeDateTime;

class AnonymizeDateTimeTest extends AnonymizeDateTest
{
    /**
     * Test the converter.
     */
    public function testConverter()
    {
        $converter = new AnonymizeDateTime();

        $date = '1990-12-31 12:05:41';
        $anonymizedDate = $converter->convert($date);
        $this->assertDateIsAnonymized($date, $anonymizedDate, 'Y-m-d H:i:s');
    }

    /**
     * Test using a custom format.
     */
    public function testCustomFormat()
    {
        $format = 'd/m/Y H:i:s';
        $converter = new AnonymizeDateTime(['format' => $format]);

        $date = '31/12/1990 12:05:41';
        $anonymizedDate = $converter->convert($date);
        $this->assertDateIsAnonymized($date, $anonymizedDate, $format);
    }
}
