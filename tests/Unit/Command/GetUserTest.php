<?php

namespace PredictionIO\Tests\Unit\Command;

use PredictionIO\Command\GetUser;

/**
 * Class GetUserTest
 *
 * @package PredictionIO\Tests\Unit\Command
 */
class GetUserTest extends \PHPUnit_Framework_TestCase
{
    public function testGetUserSetIid()
    {
        $mockUid = '1234';
        $getUserCommand = new GetUser();
        $getUserCommand->setUid($mockUid);

        $this->assertSame($mockUid, $getUserCommand->get('pio_uid'));
    }
}
