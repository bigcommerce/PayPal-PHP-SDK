<?php
use PayPal\Core\PayPalCredentialManager;
use PHPUnit\Framework\TestCase;

/**
 * Test class for PayPalCredentialManager.
 *
 * @runTestsInSeparateProcesses
 */
class PayPalCredentialManagerTest extends TestCase
{
    /**
     * @var PayPalCredentialManager
     */
    protected $object;

    private $config = array(
        'acct1.ClientId' => 'client-id',
        'acct1.ClientSecret' => 'client-secret',
        'http.ConnectionTimeOut' => '30',
        'http.Retry' => '5',
        'service.RedirectURL' => 'https://www.sandbox.paypal.com/webscr&cmd=',
        'service.DevCentralURL' => 'https://developer.paypal.com',
        'service.EndPoint.IPN' => 'https://www.sandbox.paypal.com/cgi-bin/webscr',
        'service.EndPoint.AdaptivePayments' => 'https://svcs.sandbox.paypal.com/',
        'service.SandboxEmailAddress' => 'platform_sdk_seller@gmail.com',
        'log.FileName' => 'PayPal.log',
        'log.LogLevel' => 'INFO',
        'log.LogEnabled' => '1',
    );

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        $this->object = PayPalCredentialManager::getInstance($this->config);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown(): void
    {
    }

    /**
     * @test
     */
    public function testGetInstance()
    {
        $instance = $this->object->getInstance($this->config);
        $this->assertInstanceOf('PayPal\Core\PayPalCredentialManager', $instance);
    }

    /**
     * @test
     */
    public function testGetSpecificCredentialObject()
    {
        $cred = $this->object->getCredentialObject('acct1');
        $this->assertNotNull($cred);
    }

    /**
     * @after testGetDefaultCredentialObject
     *
     * @throws \PayPal\Exception\PayPalInvalidCredentialException
     */
    public function testSetCredentialObject()
    {
        $authObject = $this->getMockBuilder('\Paypal\Auth\OAuthTokenCredential')
            ->disableOriginalConstructor()
            ->getMock();
        $cred = $this->object->setCredentialObject($authObject)->getCredentialObject();

        $this->assertNotNull($cred);
        $this->assertSame($this->object->getCredentialObject(), $authObject);
    }

    /**
     * @after testGetDefaultCredentialObject
     *
     * @throws \PayPal\Exception\PayPalInvalidCredentialException
     */
    public function testSetCredentialObjectWithUserId()
    {
        $authObject = $this->getMockBuilder('\Paypal\Auth\OAuthTokenCredential')
            ->disableOriginalConstructor()
            ->getMock();
        $cred = $this->object->setCredentialObject($authObject, 'sample')->getCredentialObject('sample');
        $this->assertNotNull($cred);
        $this->assertSame($this->object->getCredentialObject(), $authObject);
    }

    /**
     * @after testGetDefaultCredentialObject
     *
     * @throws \PayPal\Exception\PayPalInvalidCredentialException
     */
    public function testSetCredentialObjectWithoutDefault()
    {
        $authObject = $this->getMockBuilder('\Paypal\Auth\OAuthTokenCredential')
            ->disableOriginalConstructor()
            ->getMock();
        $cred = $this->object->setCredentialObject($authObject, null, false)->getCredentialObject();
        $this->assertNotNull($cred);
        $this->assertNotSame($this->object->getCredentialObject(), $authObject);
    }


    /**
     * @test
     */
    public function testGetInvalidCredentialObject()
    {
        $this->expectException(\PayPal\Exception\PayPalInvalidCredentialException::class);
        $cred = $this->object->getCredentialObject('invalid_biz_api1.gmail.com');
    }

    /**
     *
     */
    public function testGetDefaultCredentialObject()
    {
        $cred = $this->object->getCredentialObject();
        $this->assertNotNull($cred);
    }

    /**
     * @test
     */
    public function testGetRestCredentialObject()
    {
        $cred = $this->object->getCredentialObject('acct1');

        $this->assertNotNull($cred);
    }
}
