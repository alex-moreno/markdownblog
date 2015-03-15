<?php

namespace SymblogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use cebe\markdown\GithubMarkdown;

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
        }

        // Lastly, we'll parse the data from github to html.
        // @todo: inject markdown parser.
        $parser = new GithubMarkdown();
        $parsed_text = $parser->parse($contents);

        return $this->render('SymblogBundle:blog:post.html.twig', array('title' => $parsed_text));
    }
}
