<?php

namespace Habari;
/**
 * Paged Posts plugin for Habari
 *
 * @package PagedPosts
 *
 * @todo allow styling/formatting of outputed page links (the nav).
 */
class PagedPosts extends Plugin
{
	/**
	 * Filter the content and display/return only the current page. Pages are seperated
	 * by the tag "<!--nextpage-->". We filter with priority 1 so we come before the
	 * formatting plugins.
	 *
	 * @param string $content The content of the post.
	 * @param Post $post The post object.
	 */
	public function filter_post_content_out_1( $content, Post $post )
	{
		if ( strpos($content, '<!--nextpage-->' ) !== false ) {
			$pages = explode('<!--nextpage-->', $content);
			$page = Controller::get_var('page', 1) - 1;
			$post->pages = $pages;
			if ( array_key_exists($page, $pages) ) {
				$content = $pages[$page];
				$i = 0;
				$nav = array();
				while ( $i < count($pages) ) {
					$post->page = $i+1;
					$nav[] .= $post->page == $page + 1 ? $post->page : '<a href ="'. $post->permalink .'">'. $post->page .'</a>';
					$i++;
				}
				$content .= '<nav>Pages: '. implode(', ', $nav) .'</nav>';
			}
			$post->page = $page;
		}
		return $content;
	}
}

?>