<?php

namespace PredictionIO\Tests\Unit\Command;

use PredictionIO\Command\CreateUser;

/**
 * Class CreateUserTest
 *
 * @package PredictionIO\Tests\Unit\Command
 */
class CreateUserTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateUserSetIid()
    {
        $mockUid = '1234';
        $createUserCommand = new CreateUser();
        $createUserCommand->setUid($mockUid);

        $this->assertSame($mockUid, $createUserCommand->get('pio_uid'));
    }

    public function testCreateUserSetLatlngSuccess()
    {
        $mockLatlng = '20.17,114.08';
        $createUserCommand = new CreateUser();
        $createUserCommand->setLatlng($mockLatlng);

        $this->assertSame($mockLatlng, $createUserCommand->get('pio_latlng'));
    }

    public function testCreateUserSetInactiveSuccess()
    {
        $mockInactive = 'true';
        $createUserCommand = new CreateUser();
        $createUserCommand->setInactive($mockInactive);

        $this->assertSame($mockInactive, $createUserCommand->get('pio_inactive'));
    }
}
