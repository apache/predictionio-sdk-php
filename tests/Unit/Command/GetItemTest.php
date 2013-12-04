<?php

namespace PredictionIO\Tests\Unit\Command;

use PredictionIO\Command\GetItem;

/**
 * Class GetItemTest
 *
 * @package PredictionIO\Tests\Unit\Command
 */
class GetItemTest extends \PHPUnit_Framework_TestCase
{
    public function testGetItemSetIid()
    {
        $mockIid = '1234';
        $getItemCommand = new GetItem();
        $getItemCommand->setIid($mockIid);

        $this->assertSame($mockIid, $getItemCommand->get('pio_iid'));
    }
}
