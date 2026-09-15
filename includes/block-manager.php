<?php

if ( function_exists( 'acf_add_options_page' ) ) {
	acf_add_options_page( [
		'page_title' => 'Amren Options',
		'menu_title' => 'Amren Options',
		'menu_slug'  => 'ar-options',
	] );
}

if ( function_exists( 'acf_add_local_field_group' ) ) {
	acf_add_local_field_group( [
		'key'                   => 'group_59e8fd4a8b2ac',
		'title'                 => 'Block Manager',
		'fields'                => [
			[
				'key'               => 'field_59e8fd5295c7b',
				'label'             => 'Do you wish to display any global blocks on this page BEFORE the content?',
				'name'              => 'page_top_block',
				'type'              => 'select',
				'value'             => null,
				'instructions'      => 'If you select yes, you\'ll be able to specify which block or blocks to utilize. These blocks will appear BEFORE the content for this page but AFTER the header.',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => [
					'width' => '',
					'class' => '',
					'id'    => '',
				],
				'choices'           => [
					'no'  => 'No',
					'yes' => 'Yes',
				],
				'default_value'     => [
					0 => 'no',
				],
				'allow_null'        => 0,
				'multiple'          => 0,
				'ui'                => 0,
				'ajax'              => 0,
				'return_format'     => 'value',
				'placeholder'       => '',
			],
			[
				'key'               => 'field_59e8fda895c7c',
				'label'             => 'Specify Top Block(s)',
				'name'              => 'page_top_blocks',
				'type'              => 'repeater',
				'value'             => null,
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => [
					[
						[
							'field'    => 'field_59e8fd5295c7b',
							'operator' => '==',
							'value'    => 'yes',
						],
					],
				],
				'wrapper'           => [
					'width' => '',
					'class' => '',
					'id'    => '',
				],
				'collapsed'         => '',
				'min'               => 0,
				'max'               => 0,
				'layout'            => 'table',
				'button_label'      => 'Add Block',
				'sub_fields'        => [
					[
						'key'               => 'field_59e8fdc495c7d',
						'label'             => 'Select Block',
						'name'              => 'select_block',
						'type'              => 'post_object',
						'value'             => null,
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => [
							'width' => '',
							'class' => '',
							'id'    => '',
						],
						'post_type'         => [
							0 => 'blocks',
						],
						'taxonomy'          => [
						],
						'allow_null'        => 0,
						'multiple'          => 0,
						'return_format'     => '',
						'ui'                => 1,
					],
				],
			],
			[
				'key'               => 'field_59e8fde195c7e',
				'label'             => 'Do you wish to display any global blocks on this page AFTER the content?',
				'name'              => 'page_bottom_block',
				'type'              => 'select',
				'value'             => null,
				'instructions'      => 'If you select yes, you\'ll be able to specify which block or blocks to utilize. These blocks will appear AFTER the content for this page but BEFORE the footer.',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => [
					'width' => '',
					'class' => '',
					'id'    => '',
				],
				'choices'           => [
					'no'  => 'No',
					'yes' => 'Yes',
				],
				'default_value'     => [
					0 => 'no',
				],
				'allow_null'        => 0,
				'multiple'          => 0,
				'ui'                => 0,
				'ajax'              => 0,
				'return_format'     => 'value',
				'placeholder'       => '',
			],
			[
				'key'               => 'field_59e8fdfd95c7f',
				'label'             => 'Specify Bottom Block(s)',
				'name'              => 'page_bottom_blocks',
				'type'              => 'repeater',
				'value'             => null,
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => [
					[
						[
							'field'    => 'field_59e8fde195c7e',
							'operator' => '==',
							'value'    => 'yes',
						],
					],
				],
				'wrapper'           => [
					'width' => '',
					'class' => '',
					'id'    => '',
				],
				'collapsed'         => '',
				'min'               => 0,
				'max'               => 0,
				'layout'            => 'table',
				'button_label'      => 'Add Block',
				'sub_fields'        => [
					[
						'key'               => 'field_59e8fdfd95c80',
						'label'             => 'Select Block',
						'name'              => 'select_block',
						'type'              => 'post_object',
						'value'             => null,
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => [
							'width' => '',
							'class' => '',
							'id'    => '',
						],
						'post_type'         => [
							0 => 'blocks',
						],
						'taxonomy'          => [
						],
						'allow_null'        => 0,
						'multiple'          => 0,
						'return_format'     => 'id',
						'ui'                => 1,
					],
				],
			],
		],
		'location'              => [
			[
				[
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'page',
				],
			],
		],
		'menu_order'            => 0,
		'position'              => 'normal',
		'style'                 => 'default',
		'label_placement'       => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen'        => '',
		'active'                => 1,
		'description'           => '',
	] );
}
