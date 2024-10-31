<?php

class Miga_show_post_page extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'miga_show_post_page';
    }

    public function get_title()
    {
        return __('Show post', 'miga_show_post_page');
    }

    public function get_icon()
    {
        return 'eicon-post-content';
    }

    public function get_categories()
    {
        return [ 'general' ];
    }

    protected function _register_controls()
    {
        $this->start_controls_section(
            'content_section',
            [
              'label' => __('Content', 'miga_show_post_page'),
              'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $posts = get_posts();
        $postOptions = array();
        foreach ($posts as $post) {
            $postOptions[$post->ID] = $post->post_title;
        }

        $this->add_control(
            'post_id',
            [
                'label' => esc_html__('Post', 'miga_show_post_page'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $postOptions
            ]
        );
        $this->add_control(
            'html_tag',
            [
                'label' => esc_html__('Title tag', 'miga_show_post_page'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'h2',
                'options' => [
                    'h1'  => esc_html__('H1', 'plugin-name'),
                    'h2' => esc_html__('H2', 'plugin-name'),
                    'h3' => esc_html__('H3', 'plugin-name'),
                    'h4' => esc_html__('H4', 'plugin-name'),
                    'p' => esc_html__('P', 'plugin-name'),
                    'div' => esc_html__('DIV', 'plugin-name'),
                ],
            ]
        );

        $this->add_control(
            'show_title',
            [
                'label' => esc_html__('Show Title', 'miga_show_post_page'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'miga_show_post_page'),
                'label_off' => esc_html__('Hide', 'miga_show_post_page'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_content',
            [
                'label' => esc_html__('Show Content', 'miga_show_post_page'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'miga_show_post_page'),
                'label_off' => esc_html__('Hide', 'miga_show_post_page'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $isEditor = \Elementor\Plugin::$instance->editor->is_edit_mode();
        $settings = $this->get_settings_for_display();

        if (isset($settings["post_id"])) {
            $post = get_post($settings["post_id"]);

            if ($settings["show_title"]) {
                echo '<'.esc_attr($settings["html_tag"]).'>'.wp_kses_post($post->post_title).'</'.esc_attr($settings["html_tag"]).'>';
            }
            if ($settings["show_content"]) {
                echo wp_kses_post($post->post_content);
            }
        }
    }

    protected function _content_template()
    {
    }
}
