<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 10.07.18
 * Time: 14:54
 */

namespace the16thpythonist\Indico;

use DateTime;

class EventArgumentAdapter
{
    public $entry;

    public function __construct(array $response_entry)
    {
        $this->entry = $response_entry;
    }

    public function getArgs(): array {
        $args = $this->entry;
        $args['creator']['name'] = $args['creator']['fullName'];
        $args['start_time'] = $this->createDateTime($args['startDate']);
        $args['end_time'] = $this->createDateTime($args['endDate']);
        $args['modification_time'] = $this->createDateTime($args['modificationDate']);
        return $args;
    }

    private function createDateTime(array $args) {
        $string = $args['date'] . ' ' . $args['time'];
        $datetime = DateTime::createFromFormat('Y-m-d H:M:s', $string);
        return $datetime;
    }
}