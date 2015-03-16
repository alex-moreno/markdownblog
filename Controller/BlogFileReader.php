<?php
/**
 * Created by PhpStorm.
 * User: alexmoreno
 * Date: 15/03/2015
 * Time: 19:05
 */

namespace SymblogBundle\Controller;


class BlogFileReader {

    /**
     * @var $file String with the contents of a file.
     */
    protected $file;

    const SEPARATOR = '"';
    const TITLE = 'title:';
    const DESCRIPTION = 'description:';
    const AUTHOR = 'author:';
    const CATEOGORY = 'category:';

    /**
     * Default constructor
     */
    public function __construct($fileContents) {
        $this->file = $fileContents;
    }

    /**
     * Return the title for the current file.
     *
     * @return string
     *   Return title.
     */
    public function fetchTitle() {
        $title = '';
        // Find occurrence of TITLE in the file
        $existsTitle = strpos($this->file, self::TITLE);

        if ($existsTitle > 0) {
            $this->findString($this->file, $existsTitle);

            dump($title);
        }

        return $title;
    }

    public function findString($string, $begining) {
        // Search for the first separator.
        $startPosition = strpos($string, self::SEPARATOR, $begining);
        // Search for the position of the end of the current line.
        // We +1 to search for the next one and avoid the one on the begining.
        $endPosition = strpos($string, self::SEPARATOR, $startPosition + 1);

        dump($startPosition);
        dump($endPosition);

        // Read from endposition to startposition.
        $string = substr($string, $startPosition, $endPosition - $startPosition);

        dump($string);
        // Curate the result.
        $string = str_replace('"', '', $string);

        return $string;
    }

    /**
     * Fetch the description for the current post.
     *
     * @return string
     *   Description of the post.
     */
    public function fetchDescription() {
        return 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer luctus dictum quam, at interdum purus egestas id. Suspendisse dictum commodo pellentesque.';
    }

    /**
     * Return the author of the current file.
     *
     * @return string
     *   Author of the file or empty string if none.
     */
    public function fetchAuthor() {
        return 'Alex Moreno.';
    }

    /**
     * Get the category of the post.
     *
     * @return string
     *   Category of the post or empty string if none found.
     */
    public function fetchCategory() {
        return 'One nice category';
    }

    public function fetchPath() {

        return $this->file;
    }

}
