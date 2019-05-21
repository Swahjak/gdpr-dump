<?php
declare(strict_types=1);

namespace Smile\Anonymizer\Tests\Dumper\Sql;

use Smile\Anonymizer\Dumper\Sql\TableFinder;
use Smile\Anonymizer\Tests\DbTestCase;

class TableFinderTest extends DbTestCase
{
    /**
     * Test if a table is found by name.
     */
    public function testFindByName()
    {
        $tableFinder = new TableFinder($this->getConnection());
        $expectedMatch = ['customers'];

        // Exact match
        $this->assertSame($expectedMatch, $tableFinder->findByName('customers'));

        // Pattern
        $this->assertSame($expectedMatch, $tableFinder->findByName('cust*'));
    }
}
