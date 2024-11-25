<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


// Elementor PostsDisclosure Widget - Elementor widget that displays recent posts with details/summary disclosure elements.
class Elementor_PostsDisclosure_Widget extends \Elementor\Widget_Base {
	// Set widget internal name.
	public function get_name() {
		return 'posts-disclosure';
	}


	// Set widget title.
	public function get_title() {
		//return esc_html__( 'oEmbed', 'elementor-oembed-widget' );
		return 'Posts Disclosure';
	}


	// Set widget icon - use an Caret Right icon as it matches the details/summary element icon.
	// All icons at: https://elementor.github.io/elementor-icons/
	public function get_icon() {
		return 'eicon-caret-right';  // 'eicon-sort-down', 'eicon-angle-right'
	}


	// Set custom help URL - Set a URL where the user can get more information about the widget.
//	public function get_custom_help_url() {
//		return 'https://developers.elementor.com/docs/widgets/';
//	}


	// Set widget categories - Set the list of categories the widget belongs to.
	public function get_categories() {
		return [ 'general' ];
	}


	// Set widget keywords - set the list of keywords the widget belongs to.
	public function get_keywords() {
		return [ 'posts', 'disclosure' ];
	}


	// Register widget controls - input fields to allow the user to customize the widget settings.
	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html( 'Content' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'num_posts',
			[
				'label' => esc_html( 'Number of posts to show' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 2,
				'min' => 1,
				'max' => 20,
				'classes' => 'num-posts',
			]
		);
		$this->add_control(
			'append_date',
			[
				'label' => esc_html( 'Append date to post title' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html( 'Yes' ),
				'label_off' => esc_html( 'No' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'classes' => 'append-date',
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'style_section',
			[
				'label' => esc_html( 'Style' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'text_color',
			[
				'label' => esc_html( 'Text Color' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'selector' => '{{WRAPPER}}',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Text_Stroke::get_type(),
			[
				'name' => 'text_stroke',
				'selector' => '{{WRAPPER}}',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'text_shadow',
				'selector' => '{{WRAPPER}}',
			]
		);
		$this->end_controls_section();
	}


	// Render the DaysMessages widget on the frontend.
	protected function render() {
		$settings = $this->get_settings_for_display();

		$num_posts = $settings['num_posts'];
		$append_date = $settings['append_date'];
		
		if ( is_admin() ) {
		}
		
		$args = array( 'category_name' => 'updates', 'posts_per_page' => $num_posts );
		$query = new WP_Query( $args );
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				$date = $append_date ? ' ' . get_the_date() : '';
				echo '<details><summary>' . esc_html( get_the_title() ) . $date . '</summary>', get_the_content(), '</details>', "\n";
			}
		} else {
			esc_html_e( 'Sorry, no posts matched your criteria.' );
		}
		// Restore original Post Data.
		wp_reset_postdata();
	}
}