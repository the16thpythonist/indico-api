<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 10.07.18
 * Time: 15:37
 */

use PHPUnit\Framework\TestCase;

use the16thpythonist\Indico\IndicoApi;
use the16thpythonist\Indico\Event;


define('DATE_FORMAT', 'Y-m-d');


class TestIndicoApi extends TestCase
{

    /**
     * Tests if a basic getCategory works and actually returns a list of events
     */
    public function testDoesBasicallyWork() {
        $api = new IndicoApi('https://indico.desy.de/indico', '829e3826-39ad-4be3-b50f-1d25397e67bd');
        $events = $api->getCategory('100');
        $this->assertNotEquals(count($events), 0);
    }

    /**
     * Tests if getting a single event by id works
     */
    public function testGettingSingleEvent() {
        $api = new IndicoApi('https://indico.desy.de/indico', '829e3826-39ad-4be3-b50f-1d25397e67bd');
        $event = $api->getEvent(255);

        $this->assertNotEquals($event->getID(), '');
    }

    /**
     * Test if the modification time of all the events in a selected category are being created correctly
     */
    public function testCorrectModificationTime() {
        $api = new IndicoApi('https://indico.desy.de/indico', '829e3826-39ad-4be3-b50f-1d25397e67bd');
        $events = $api->getCategory(388);

        foreach ($events as $event) {
            /** @var Event $event */
            $modification_date = $event->getModificationTime()->format(DATE_FORMAT);
            $this->assertTrue(is_string($modification_date));
            $this->assertInstanceOf(DateTime::class, $event->getModificationTime());
        }
    }
}