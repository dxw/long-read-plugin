<?php

namespace LongReadPlugin;

class Template implements \Dxw\Iguana\Registerable
{
	public const TEMPLATE_FILE = 'single-long-read.php';

	public function register(): void
	{
		add_filter('single_template', [$this, 'useDefault'], 99);
	}

	public function useDefault(string $template): string
	{
		global $post;
		if ($post->post_type == 'long-read' && function_exists('get_field') && get_field('long_read_plugin_use_default_template', 'option')) {
			if (file_exists(dirname(plugin_dir_path(__FILE__)) . '/template/' . self::TEMPLATE_FILE)) {
				$template = dirname(plugin_dir_path(__FILE__)) . '/template/' . self::TEMPLATE_FILE;
			}
		}

		return $template;
	}
}
