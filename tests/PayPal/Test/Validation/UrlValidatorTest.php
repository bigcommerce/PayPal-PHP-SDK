<?php
namespace PayPal\Test\Validation;

use PayPal\Validation\UrlValidator;
use PHPUnit\Framework\TestCase;

class UrlValidatorTest extends TestCase
{

    public static function positiveProvider()
    {
        return array(
            array("https://www.paypal.com"),
            array("http://www.paypal.com"),
            array("https://paypal.com"),
            array("https://www.paypal.com/directory/file"),
            array("https://www.paypal.com/directory/file?something=1&other=true"),
            array("https://www.paypal.com?value="),
            array("https://www.paypal.com/123123"),
            array("https://www.subdomain.paypal.com"),
            array("https://www.sub-domain-with-dash.paypal-website.com"),
            array("https://www.paypal.com?value=space%20separated%20value"),
            array("https://www.special@character.com"),
        );
    }

    public static function invalidProvider()
    {
        return array(
            array("www.paypal.com"),
            array(""),
            array(null),
            array("https://www.sub_domain_with_underscore.paypal.com"),
        );
    }

    /**
     * @doesNotPerformAssertions
     * @dataProvider positiveProvider
     */
    public function testValidate($input)
    {
        UrlValidator::validate($input, "Test Value");
    }

    /**
     * @dataProvider invalidProvider
     */
    public function testValidateException($input)
    {
        $this->expectException(\InvalidArgumentException::class);
        UrlValidator::validate($input, "Test Value");
    }
}
