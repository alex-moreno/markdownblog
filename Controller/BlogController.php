<?php

namespace SymblogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use cebe\markdown\GithubMarkdown;
use SymblogBundle\Controller\BlogFileReader;

class BlogController extends Controller
{

  /**
   * @param $title
   * @param $folder
   * @return \Symfony\Component\HttpFoundation\Response
   */
  public function readPostAction($title, $folder)
    {
        $contents = "";

        $finder = new Finder();
        $finder->files()->in(__DIR__ . $folder);

        // Read only the title + rd extension file.
        $finder->name($title . '.rd');

        foreach ($finder as $file) {
            // @TODO: Add some date facility to organize the files.

            /* @type SplFileInfo $file */
            $contents = $file->getContents();
            // @TODO: empty the contents related to title, description, etc...
        }

        // Lastly, we'll parse the data from github to html.
        // @todo: inject markdown parser.
        $parser = new GithubMarkdown();
        $parsed_text = $parser->parse($contents);

        return $this->render('SymblogBundle:blog:post.html.twig', array('title' => $parsed_text));
    }

    /**
     * List posts in the given folder.
     * @param int $index
     * @param $folder
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listPostsAction($index = 0, $folder) {

        $finder = new Finder();
        // Finder will contains the list of files.
        $finder->files()->in(__DIR__ . $folder);
        // Just read .rd files.
        $finder->name('*.rd');

        foreach ($finder as $path) {
            /* @type SplFileInfo $path */
            $fileReader = new BlogFileReader($path->getContents());

            // Initzialise the array.
            $the_file = Array();
            $the_file['title'] = $fileReader->fetchTitle();
            $the_file['description'] = $fileReader->fetchDescription();
            $the_file['author'] = $fileReader->fetchAuthor();
            $the_file['category'] = $fileReader->fetchCategory();
            $the_file['path'] = $fileReader->fetchPath();

            $files[] = $the_file;
        }

        return $this->render('SymblogBundle:blog:post_list.html.twig', array('index' => $index, 'list' => $files));
    }

}
