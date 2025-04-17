// includes/class-post-types.php
class NGO_EasyBuilder_Post_Types {
    
    public function __construct() {
        add_action('init', array($this, 'register_post_types'));
    }
    
    public function register_post_types() {
        // Projects post type
        register_post_type('ngo_project', array(
            'labels' => array(
                'name' => __('Projects', 'ngo-easybuilder'),
                'singular_name' => __('Project', 'ngo-easybuilder'),
                // Additional labels...
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
            'menu_icon' => 'dashicons-portfolio',
            'rewrite' => array('slug' => 'projects'),
            'show_in_rest' => true,
        ));
        
        // Campaigns post type
        register_post_type('ngo_campaign', array(
            'labels' => array(
                'name' => __('Campaigns', 'ngo-easybuilder'),
                'singular_name' => __('Campaign', 'ngo-easybuilder'),
                // Additional labels...
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
            'menu_icon' => 'dashicons-megaphone',
            'rewrite' => array('slug' => 'campaigns'),
            'show_in_rest' => true,
        ));
        
        // Team members post type
        register_post_type('ngo_team', array(
            'labels' => array(
                'name' => __('Team', 'ngo-easybuilder'),
                'singular_name' => __('Team Member', 'ngo-easybuilder'),
                // Additional labels...
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'thumbnail'),
            'menu_icon' => 'dashicons-groups',
            'rewrite' => array('slug' => 'team'),
            'show_in_rest' => true,
        ));
        
        // Impact stories post type
        register_post_type('ngo_impact', array(
            'labels' => array(
                'name' => __('Impact Stories', 'ngo-easybuilder'),
                'singular_name' => __('Impact Story', 'ngo-easybuilder'),
                // Additional labels...
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
            'menu_icon' => 'dashicons-heart',
            'rewrite' => array('slug' => 'impact'),
            'show_in_rest' => true,
        ));
    }
}

new NGO_EasyBuilder_Post_Types();

