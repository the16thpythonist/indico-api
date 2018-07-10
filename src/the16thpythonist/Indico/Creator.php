<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 10.07.18
 * Time: 12:07
 */

namespace the16thpythonist\Indico;

/**
 * Class Creator
 *
 * @since 0.0.0.0
 *
 * @package the16thpythonist\Indico
 */
class Creator
{
    const DEFAULT = array(
        'id'            => '0',
        'name'          => '',
        'affiliation'   => '',
    );

    public $data;

    /**
     * Creator constructor.
     *
     * A creator is being constructed, by passing an associative array, that contains the data. The keys of that array
     * should be the following:
     * - id             : A string of the int id of the creator on the local indico site
     * - name           : The full name of the creator. Best is the native format of indico "LASTNAME, F."
     * - affiliation    : The name of the organisation, the creator is affiliated with.
     *
     * @since 0.0.0.0
     *
     * @param array $args
     */
    public function __construct(array $args)
    {
        $this->data = self::DEFAULT;
        $this->data = array_replace($this->data, $args);
    }

    /**
     * Returns the ID of the creator on the local indico site
     *
     * CHANGELOG
     *
     * Added 10.07.2018
     *
     * @return string
     */
    public function getID(): string {
        return $this->data['id'];
    }

    /**
     * Returns the full name of the author in indexed form
     *
     * An Example of the format of the name is:
     * TEUFEL, J.
     *
     * CHANGELOG
     *
     * Added 10.07.2018
     *
     * @since 0.0.0.0
     *
     * @return string
     */
    public function getFullName(): string {
        return $this->data['name'];
    }

    /**
     * Returns the affiliation of the creator
     *
     * Since indico is mainly used to manage events in a scientific context, the affiliation often specifies the
     * university or the institute, at which the creator works.
     *
     * CHANGELOG
     *
     * Added 10.07.2018
     *
     * @since 0.0.0.0
     *
     * @return string
     */
    public function getAffiliation(): string {
        return $this->data['affiliation'];
    }

}