<?php

namespace LongReadPlugin;

class Options implements \Dxw\Iguana\Registerable
{
	public function register(): void
	{
		add_action('acf/init', [$this, 'addOptionsPage']);
		add_action('acf/init', [$this, 'addOptions']);
	}

	public function addOptionsPage(): void
	{
		if (function_exists('acf_add_options_page')) {
			acf_add_options_page([
				'page_title' 	=> 'Long Read Settings',
				'menu_title'	=> 'Long Read Settings',
				'menu_slug' 	=> 'long-read-settings',
				'capability'	=> 'edit_posts',
				'parent_slug' => 'options-general.php'
			]);
		}
	}

	public function addOptions(): void
	{
		if (function_exists('acf_add_local_field_group')):

			acf_add_local_field_group([
				'key' => 'group_long_read_plugin_settings',
				'title' => 'Long Read Settings',
				'fields' => [
					[
						'key' => 'field_long_read_plugin_settings-default_template',
						'label' => 'Use default template',
						'name' => 'long_read_plugin_use_default_template',
						'type' => 'true_false',
						'instructions' => 'Use the default template for Long Read posts? (Requires a theme based on the dxw gov.uk theme)',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => [
							'width' => '',
							'class' => '',
							'id' => '',
						],
						'message' => '',
						'default_value' => 0,
						'ui' => 0,
						'ui_on_text' => '',
						'ui_off_text' => '',
					],
				],
				'location' => [
					[
						[
							'param' => 'options_page',
							'operator' => '==',
							'value' => 'long-read-settings',
						],
					],
				],
				'menu_order' => 0,
				'position' => 'normal',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => true,
				'description' => '',
				'show_in_rest' => 0,
			]);

		endif;
	}
}
