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
     * Changed 08.08.2018
     * Checking if the 'modificationDate' key even exists in the args array, because when events have just been created
     * sometimes the item will not even exist. In such a case the 'creationDate' will be used as the time of last
     * modification.
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
        // Sometimes when a event hasnt been modified yet, the modificationDate item will not even exist leading to an
        // error, in this case the creation date will be used as the date of last modification
        if (array_key_exists('modificationDate', $args)) {
            $args['modification_time'] = $this->createDateTime($args['modificationDate']);
        } else {
            $args['modification_time'] = $this->createDateTime($args['creationDate']);
        }

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
        // Using a substring of the time, because sometimes there is the possibility of the milliseconds also being part
        // of the string and then the format doesnt work
        $string = $args['date'] . ' ' . substr($args['time'], 0, 8);
        $datetime = DateTime::createFromFormat('Y-m-d H:i:s', $string);
        return $datetime;
    }
}