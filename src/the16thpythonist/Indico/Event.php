<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 10.07.18
 * Time: 12:05
 */

namespace the16thpythonist\Indico;

use DateTime;
use the16thpythonist\Indico\Creator;


/**
 * Class Event
 *
 * @since 0.0.0.0
 *
 * @package the16thpythonist\Indico
 */
class Event {

    const DEFAULT = array(
        'id'                => '0',
        'type'              => 'event',
        'title'             => '',
        'description'       => '',
        'location'          => '',
        'address'           => '',
        'url'               => '',
        'start_time'        => '',
        'end_time'          => '',
        'modification_time' => '',
        'creator'           => array()
    );

    public $data;

    /**
     * Event constructor.
     *
     * An event is being constructed using an associative array to specify its attributes. This array should contain
     * the following keys:
     * - id                 : A string of the int id of the event entry in the local indico website
     * - type               : The type of event that is being described, examples would be "meeting" and "conference"
     * - title              : The title or name of the event
     * - description        : If constructed from the API this contains the actual (html) content of the event entry
     *                        from the indico site
     * - location           : A name for the location where the event will take place (Mostly used as the city)
     * - address            : The concrete address of where the event will take place
     * - url                : The url to the actual page of the indico platform for this specific event
     * - start_time         : The DateTime object for the time the event starts
     * - end_time           : The DateTime object for when the event ends
     * - modification_time  : The DateTime object for when the event entry has been last modified / updated on the
     *                        indico site
     * - creator            : An associative array describing the person, that has created the event entry on the
     *                        indico platform. The array should contain the keys "name", "affiliation" and "id"
     *
     * @see Creator
     *
     * @since 0.0.0.0
     *
     * @param array $args
     */
    public function __construct(array $args)
    {
        $this->data = self::DEFAULT;
        $this->data = array_replace($this->data, $args);

        $this->createObject('creator', Creator::class);
    }

    /**
     * Returns the string of the int id, that the event entry has on the indico website
     *
     * Caution: Since anyone can set up their separate indico website, these ids are not publicly unique, they are
     * only unique to the very website the event has been fetched from. If using seperate websites to fetch events from
     * events have to have an additional id for the website to be used in addition to the indico id to be uniquely
     * identified.
     *
     * CHANGELOG
     *
     * Added 10.07.2018
     *
     * @since 0.0.0.0
     *
     * @return string
     */
    public function getID(): string {
        return $this->data['id'];
    }

    /**
     * Returns the type of the event
     *
     * Examples would be "meeting", "conference" etc
     *
     * CHANGELOG
     *
     * Added 10.07.2018
     *
     * @since 0.0.0.0
     *
     * @return string
     */
    public function getType(): string {
        return $this->data['type'];
    }

    /**
     * Returns the title of the event
     *
     * CHANGELOG
     *
     * Added 10.07.2018
     *
     * @since 0.0.0.0
     *
     * @return string
     */
    public function getTitle(): string {
        return $this->data['title'];
    }

    /**
     * Returns the description of the event
     *
     * CHANGELOG
     *
     * Added 10.07.2018
     *
     * @since 0.0.0.0
     *
     * @return string
     */
    public function getDescription(): string {
        return $this->data['description'];
    }

    /**
     * Returns the location of where the event will take place
     *
     * CHANGELOG
     *
     * Added 10.07.2018
     *
     * @since 0.0.0.0
     *
     * @return string
     */
    public function getLocation(): string {
        return $this->data['location'];
    }

    /**
     * Returns the address of the event location
     *
     * CHANGELOG
     *
     * Added 10.07.2018
     *
     * @since 0.0.0.0
     *
     * @return string
     */
    public function getAddress(): string {
        return $this->data['address'];
    }

    /**
     * Returns the URL, which leads to the page of the event on the indico site
     *
     * CHANGELOG
     *
     * Added 10.07.2018
     *
     * @since 0.0.0.0
     *
     * @return string
     */
    public function getURL(): string {
        return $this->data['url'];
    }

    /**
     * Returns the DateTime object for the time when the event starts
     *
     * CHANGELOG
     *
     * Added 10.07.2018
     *
     * @since 0.0.0.0
     *
     * @return DateTime
     */
    public function getStartTime(): DateTime {
        return $this->data['start_time'];
    }

    /**
     * Returns the DateTime object for the time when the event ends
     *
     * CHANGELOG
     *
     * Added 10.07.2018
     *
     * @since 0.0.0.0
     *
     * @return DateTime
     */
    public function getEndTime(): DateTime {
        return $this->data['end_time'];
    }

    /**
     * Returns the DateTime object for the Time when the event entry on the indico platform got last modified/updated
     *
     * CHANGELOG
     *
     * Added 10.07.2018
     *
     * @since 0.0.0.0
     *
     * @return DateTime
     */
    public function getModificationTime(): DateTime {
        return $this->data['modification_time'];
    }

    /**
     * Returns the Creator object, that describes, who has created the event entry on the indico platform
     *
     * CHANGELOG
     *
     * Added 10.07.2018
     *
     * @since 0.0.0.0
     *
     * @return Creator
     */
    public function getCreator(): Creator {
        return $this->data['creator'];
    }

    /**
     * Creates an object from a data array in the main data array and then replaces that
     *
     * This method takes one of the key names of the $args array, that is passed to the constructor and the class that
     * should be build from the corresponding value.
     * It all comes down, that certain attributes of this class are supposed to be custom data model objects as well,
     * but these objects are not being passed as values of the $args array directly, instead another associative array
     * is being passed in their placed and saved into the data array of this object.
     * Using the class that has been passed to this method, a new object will be created using exactly that sub array
     * that has been passed to specify the argumnets for the new object. The array of the arguments in the data array
     * at the given key will then be replaced with the new object that has been created from it
     *
     * CHANGELOG
     *
     * Added 10.07.2018
     *
     * @since 0.0.0.0
     *
     * @param $key string       the key of the data array in whose value there is the associative array that specifies
     *                          the arguments for the new object to be created and which is supposed to be the value
     *                          of that key instead
     * @param $class string     the class name of the class which is supposed to be used to create a new object with
     * @return mixed
     */
    private function createObject(string $key, string $class) {
        if (!($this->data[$key] instanceof $class)) {
            $this->data[$key] = new $class($this->data[$key]);
        }
    }
}