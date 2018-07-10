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
}