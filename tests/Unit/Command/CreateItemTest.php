<?php

namespace PredictionIO\Tests\Unit\Command;

use PredictionIO\Command\CreateItem;

/**
 * Class CreateItemTest
 *
 * @package PredictionIO\Tests\Unit\Command
 */
class CreateItemTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateItemSetIid()
    {
        $mockIid = '1234';
        $createItemCommand = new CreateItem();
        $createItemCommand->setIid($mockIid);

        $this->assertSame($mockIid, $createItemCommand->get('pio_iid'));
    }

    public function testCreateItemSetItypesImplodesAnArrayToCommaDelimitedString()
    {
        $mockTypes = array(
            'happy',
            'mocked',
            'types',
        );
        $createItemCommand = new CreateItem();
        $createItemCommand->setItypes($mockTypes);

        $this->assertSame(implode(',', $mockTypes), $createItemCommand->get('pio_itypes'));
    }

    public function testCreateItemSetItypesFromString()
    {
        $mockType = 'happy.mocked.type';
        $createItemCommand = new CreateItem();
        $createItemCommand->setItypes($mockType);

        $this->assertSame($mockType, $createItemCommand->get('pio_itypes'));
    }

    public function testCreateItemSetStartTSuccess()
    {
        $mockStartT = 'mock.startT';
        $createItemCommand = new CreateItem();
        $createItemCommand->setStartT($mockStartT);

        $this->assertSame($mockStartT, $createItemCommand->get('pio_startT'));
    }

    public function testCreateItemSetEndTSuccess()
    {
        $mockEndT = 'mock.endT';
        $createItemCommand = new CreateItem();
        $createItemCommand->setEndT($mockEndT);

        $this->assertSame($mockEndT, $createItemCommand->get('pio_endT'));
    }

    public function testCreateItemSetPriceSuccess()
    {
        $mockPrice = '1234.56';
        $createItemCommand = new CreateItem();
        $createItemCommand->setPrice($mockPrice);

        $this->assertSame($mockPrice, $createItemCommand->get('pio_price'));
    }

    public function testCreateItemSetProfitSuccess()
    {
        $mockProfit = '9876.54';
        $createItemCommand = new CreateItem();
        $createItemCommand->setProfit($mockProfit);

        $this->assertSame($mockProfit, $createItemCommand->get('pio_profit'));
    }

    public function testCreateItemSetLatlngSuccess()
    {
        $mockLatlng = '20.17,114.08';
        $createItemCommand = new CreateItem();
        $createItemCommand->setLatlng($mockLatlng);

        $this->assertSame($mockLatlng, $createItemCommand->get('pio_latlng'));
    }

    public function testCreateItemSetInactiveSuccess()
    {
        $mockInactive = 'true';
        $createItemCommand = new CreateItem();
        $createItemCommand->setInactive($mockInactive);

        $this->assertSame($mockInactive, $createItemCommand->get('pio_inactive'));
    }
}
