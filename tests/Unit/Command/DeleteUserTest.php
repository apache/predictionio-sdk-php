<?php

namespace PredictionIO\Tests\Unit\Command;

use PredictionIO\Command\DeleteUser;

/**
 * Class DeleteUserTest
 *
 * @package PredictionIO\Tests\Unit\Command
 */
class DeleteUserTest extends \PHPUnit_Framework_TestCase
{
    public function testDeleteUserSetIid()
    {
        $mockUid = '1234';
        $deleteUserCommand = new DeleteUser();
        $deleteUserCommand->setUid($mockUid);

        $this->assertSame($mockUid, $deleteUserCommand->get('pio_uid'));
    }
}
