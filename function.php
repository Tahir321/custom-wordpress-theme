<?php
function my_custom_theme_setup()
{
    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');
    // Enable support for Post Thumbnails on posts and pages.
    add_theme_support('post-thumbnails');
    // Add support for custom logo.
    add_theme_support('custom-logo');
    // Add support for title tag.
    add_theme_support('title-tag');
    // Register a single navigation menu.
    register_nav_menus(
        array(
            'primary' => __('Primary Menu', 'my-custom-theme'),
        )
    );
}
add_action('after_setup_theme', 'my_custom_theme_setup');

function my_custom_theme_scripts()
{
    wp_enqueue_style('style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'my_custom_theme_scripts');

function my_custom_theme_widgets_init()
{
    register_sidebar(
        array(
            'name' => __('Main Sidebar', 'my-custom-theme'),
            'id' => 'main-sidebar',
            'description' => __('Widgets in this area will be shown in the sidebar.', 'my-custom-theme'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h2 class="widget-title">',
            'after_title' => '</h2>',
        )
    );
}
add_action('widgets_init', 'my_custom_theme_widgets_init');

function my_custom_theme_entry_footer()
{
    // Hide category and tag text for pages.
    if ('post' === get_post_type()) {
        $categories_list = get_the_category_list(', ');
        if ($categories_list) {
            printf('<span class="cat-links">' . esc_html__('Posted in %1$s', 'my-custom-theme') . '</span>', $categories_list); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        }

        $tags_list = get_the_tag_list('', ', ');
        if ($tags_list) {
            printf('<span class="tags-links">' . esc_html__('Tagged %1$s', 'my-custom-theme') . '</span>', $tags_list); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        }
    }

    if (!is_single() && !post_password_required() && (comments_open() || get_comments_number())) {
        echo '<span class="comments-link">';
        comments_popup_link(esc_html__('Leave a comment', 'my-custom-theme'), esc_html__('1 Comment', 'my-custom-theme'), esc_html__('% Comments', 'my-custom-theme'));
        echo '</span>';
    }

    edit_post_link(
        sprintf(
            wp_kses(
                /* translators: %s: Name of current post. Only visible to screen readers */
                __('Edit <span class="screen-reader-text">%s</span>', 'my-custom-theme'),
                array(
                    'span' => array(
                        'class' => array(),
                    ),
                )
            ),
            get_the_title()
        ),
        '<span class="edit-link">',
        '</span>'
    );
}
?>