<?php
declare(strict_types=1);

namespace Smile\Anonymizer\Tests\Config\Parser;

use PHPUnit\Framework\TestCase;
use Smile\Anonymizer\Config\Parser\YamlParser;
use Symfony\Component\Yaml\Yaml;

class YamlParserTest extends TestCase
{
    /**
     * Test the parsing of a YAML file.
     */
    public function testParseFile()
    {
        $fileName = APP_ROOT . '/config/templates/magento2.yaml';

        $parser = new YamlParser();
        $result = $parser->parse($fileName);

        $this->assertSame(Yaml::parseFile($fileName), $result);
    }

    /**
     * Test if an exception is thrown when the file is not found.
     *
     * @expectedException \Smile\Anonymizer\Config\Parser\ParseException
     */
    public function testFileNotFound()
    {
        $parser = new YamlParser();
        $parser->parse('notExists.yaml');
    }
}
