<?php
namespace PayPal\Test\Validation;

use PayPal\Validation\ArgumentValidator;
use PHPUnit\Framework\TestCase;

class ArgumentValidatorTest extends TestCase
{

    public static function positiveProvider()
    {
        return array(
            array("1"),
            array("something here"),
            array(1),
            array(array(1,2,3)),
            array(0.123),
            array(true),
            array(false),
            array(array()),
        );
    }

    public static function invalidProvider()
    {
        return array(
            array(null),
            array(''),
            array('     ')
        );
    }

    /**
     *
     * @dataProvider positiveProvider
     */
    public function testValidate($input)
    {
        $this->assertTrue(ArgumentValidator::validate($input, "Name"));
    }

    /**
     * @dataProvider invalidProvider
     */
    public function testInvalidDataValidate($input)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->assertTrue(ArgumentValidator::validate($input, "Name"));
    }
}
