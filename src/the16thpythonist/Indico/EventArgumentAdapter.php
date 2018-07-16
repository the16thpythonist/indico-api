<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 10.07.18
 * Time: 14:54
 */

namespace the16thpythonist\Indico;

use DateTime;

/**
 * Class EventArgumentAdapter
 *
 * Takes the array from the indico response and turns it into an array of arguments, that can be used directly to be
 * passed to the constructor of an Event object.
 *
 * @package the16thpythonist\Indico
 */
class EventArgumentAdapter
{
    /**
     * @var array the array structure, directly from the indico api response
     */
    public $entry;

    public function __construct(array $response_entry)
    {
        $this->entry = $response_entry;
    }

    /**
     * Adapts the arguments of the response array so that they can be used for a Event object creation directly
     *
     * CHANGELOG
     *
     * Added 10.07.2018
     *
     * @since 0.0.0.0
     *
     * @return array
     */
    public function getArgs(): array {
        $args = $this->entry;
        $args['creator']['name'] = $args['creator']['fullName'];
        $args['start_time'] = $this->createDateTime($args['startDate']);
        $args['end_time'] = $this->createDateTime($args['endDate']);
        $args['modification_time'] = $this->createDateTime($args['modificationDate']);
        return $args;
    }

    /**
     * Creates a DateTime object from the array structure of Date entries in the indico response
     *
     * CHANGELOG
     *
     * Added 10.07.2018
     *
     * Changed 16.07.2018
     *
     * The format string, which was used for the creation of the DateTime object was wrong. The symbol 'i' stands for
     * minutes and not 'H'. This would result in the method just returning False.
     *
     * @param array $args
     * @return bool|DateTime
     */
    private function createDateTime(array $args) {
        $string = $args['date'] . ' ' . $args['time'];
        $datetime = DateTime::createFromFormat('Y-m-d H:i:s', $string);
        return $datetime;
    }
}