<?php

namespace PredictionIO\Tests\Unit\Command;

use PredictionIO\Command\DeleteItem;

/**
 * Class DeleteItemTest
 *
 * @package PredictionIO\Tests\Unit\Command
 */
class DeleteItemTest extends \PHPUnit_Framework_TestCase
{
    public function testDeleteItemSetIid()
    {
        $mockIid = '1234';
        $deleteItemCommand = new DeleteItem();
        $deleteItemCommand->setIid($mockIid);

        $this->assertSame($mockIid, $deleteItemCommand->get('pio_iid'));
    }
}
