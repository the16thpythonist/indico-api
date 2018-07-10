<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 10.07.18
 * Time: 11:19
 */

namespace the16thpythonist\Indico;


use GuzzleHttp\Client;
use Prophecy\Exception\InvalidArgumentException;

/**
 * Class IndicoApi
 *
 * @since 0.0.0.0
 *
 * @package the16thpythonist\Indico
 */
class IndicoApi
{
    const DEFAULT_CONFIG = array(
        'timeout'   => 30
    );

    public $key;
    public $url;
    public $config;

    private $client;

    /**
     * IndicoApi constructor.
     *
     * configuration key options:
     * - timeout        : the timeout for the http client in seconds
     *
     * CHANGELOG
     *
     * Added 10.07.2018
     *
     * @since 0.0.0.0
     *
     * @param string $url   the base url of the indico site from which the events are to be requested. The site url has
     *                      to be specified for the very front page and without a tailing slash ("/")!
     * @param string $key   the api key to be used to access the api off the specified indico site
     * @param array $config an associative array containing the configuration options for the api object
     */
    public function __construct(string $url, string $key, array $config=self::DEFAULT_CONFIG)
    {
        $this->url = $url;
        $this->key = $key;
        $this->config = $config;

        // Creating the client
        $this->client = new Client(array(
                'timeout' => $this->config['timeout']
        ));
    }

    /**
     * requests and returns the event corresponding to the given id from indico
     *
     * CHANGELOG
     *
     * Added 10.07.2018
     *
     * @since 0.0.0.0
     *
     * @param string $event_id the id of the event to request
     * @return Event
     */
    public function getEvent(string $event_id): Event {
        $uri = $this->createEventURI($event_id);
        $options = $this->createOptions();

        $response = $this->sendRequest($uri, $options);
        if ($response['count'] !== 1) {
            throw new InvalidArgumentException('The event ' . $event_id . ' was not found in ' . $this->url);
        } else {

            $entry = $response['results'][0];
            $adapter = new EventArgumentAdapter($entry);
            return new Event($adapter->getArgs());
        }
    }

    /**
     * returns all the event objects from the indico site corresponding to the given category id
     *
     * CHANGELOG
     *
     * Added 10.07.2018
     *
     * @since 0.0.0.0
     *
     * @param string $category_id the category id from which to get all the event entries
     * @return array
     */
    public function getCategory(string $category_id): array {
        $uri = $this->createCategoryURI($category_id);

        $options = $this->createOptions();

        $response = $this->sendRequest($uri, $options);
        $entries = $response['results'];

        $events = array();
        // Creating an Event object from each of these options
        foreach ($entries as $entry) {
            $adapter = new EventArgumentAdapter($entry);
            $args = $adapter->getArgs();
            $event = new Event($args);
            $events[] = $event;
        }

        return $events;
    }

    /**
     * Sends the GET request to indico using the http client
     *
     * CHANGELOG
     *
     * Added 10.07.2018
     *
     * @see Client
     *
     * @since 0.0.0.0
     *
     * @param string $uri       the uri, which to use for the GET request
     * @param array $options    the options for the request containing the query with the url variables
     * @return array
     */
    private function sendRequest(string $uri, array $options): array {
        $response = $this->client->get($uri, $options);
        $body = $response->getBody();
        return json_decode($body, true);
    }

    /**
     * Creates the URI string for requesting a specific event
     *
     * CHANGELOG
     *
     * Added 10.07.2018
     *
     * @since 0.0.0.0
     *
     * @param string $event_id the string of the int id of the specific event to be requested
     * @return string
     */
    private function createEventURI(string $event_id): string {
        $uri = $this->url . '/export/event/' . $event_id . '.json';
        return $uri;
    }

    /**
     * Creates the URI string requesting a category response from indico when given the specific category id
     *
     * CHANGELOG
     *
     * Added 10.07.2018
     *
     * @since 0.0.0.0
     *
     * @param string $category_id the string of the int id of the indico category for which to request all event entries
     * @return string
     */
    private function createCategoryURI(string $category_id): string {
        $uri = $this->url . '/export/categ/' . $category_id . '.json';
        return $uri;
    }

    /**
     * Creates the options array to be passed to the http client, when making the API GET request.
     *
     * The options array contains the query, array which specifies all the url variables to be passed along with the
     * get request. With indico the only url variable necessary is the api key.
     *
     * CHANGELOG
     *
     * Added 10.07.2018
     *
     * @since 0.0.0.0
     *
     * @return array
     */
    private function createOptions(): array {
        $query = array(
            'ak'    => $this->key,
        );
        $options = array(
            'query' => $query,
        );
        return $options;
    }
}