// includes/class-templates.php
class NGO_EasyBuilder_Templates {
    
    public function __construct() {
        add_action('admin_menu', array($this, 'add_templates_page'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
        add_action('wp_ajax_ngo_import_template', array($this, 'import_template'));
    }
    
    public function add_templates_page() {
        add_submenu_page(
            'edit.php?post_type=ngo_project',
            __('NGO Templates', 'ngo-easybuilder'),
            __('Templates', 'ngo-easybuilder'),
            'edit_posts',
            'ngo-templates',
            array($this, 'render_templates_page')
        );
    }
    
    public function enqueue_admin_scripts($hook) {
        if ('ngo_project_page_ngo-templates' !== $hook) {
            return;
        }
        
        wp_enqueue_style('ngo-admin-css', NGO_EASYBUILDER_URL . 'assets/css/admin.css', array(), NGO_EASYBUILDER_VERSION);
        wp_enqueue_script('ngo-admin-js', NGO_EASYBUILDER_URL . 'assets/js/admin.js', array('jquery'), NGO_EASYBUILDER_VERSION, true);
        wp_localize_script('ngo-admin-js', 'ngoTemplates', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('ngo-templates-nonce'),
        ));
    }
    
    public function render_templates_page() {
        ?>
        <div class="wrap ngo-templates-page">
            <h1><?php _e('NGO Website Templates', 'ngo-easybuilder'); ?></h1>
            
            <div class="ngo-templates-grid">
                <?php $this->display_template_cards(); ?>
            </div>
        </div>
        <?php
    }
    
    private function display_template_cards() {
        $templates = $this->get_available_templates();
        
        foreach ($templates as $template_id => $template) {
            ?>
            <div class="ngo-template-card">
                <div class="ngo-template-image">
                    <img src="<?php echo esc_url($template['thumbnail']); ?>" alt="<?php echo esc_attr($template['name']); ?>">
                </div>
                
                <div class="ngo-template-info">
                    <h3><?php echo esc_html($template['name']); ?></h3>
                    <p><?php echo esc_html($template['description']); ?></p>
                    
                    <div class="ngo-template-actions">
                        <a href="<?php echo esc_url($template['preview']); ?>" target="_blank" class="button">
                            <?php _e('Preview', 'ngo-easybuilder'); ?>
                        </a>
                        
                        <button class="button button-primary ngo-import-template" data-template="<?php echo esc_attr($template_id); ?>">
                            <?php _e('Import', 'ngo-easybuilder'); ?>
                        </button>
                    </div>
                </div>
            </div>
            <?php
        }
    }
    
    private function get_available_templates() {
        return array(
            'homepage' => array(
                'name' => __('NGO Homepage', 'ngo-easybuilder'),
                'description' => __('A complete homepage with hero section, impact metrics, program highlights, and donation appeal.', 'ngo-easybuilder'),
                'thumbnail' => NGO_EASYBUILDER_URL . 'assets/images/templates/homepage-thumb.jpg',
                'preview' => 'https://demos.ngo-easybuilder.com/homepage/',
                'file' => NGO_EASYBUILDER_PATH . 'templates/homepage.json',
            ),
            'about' => array(
                'name' => __('About Us Page', 'ngo-easybuilder'),
                'description' => __('Showcase your mission, vision, history, and team with this professionally designed about page.', 'ngo-easybuilder'),
                'thumbnail' => NGO_EASYBUILDER_URL . 'assets/images/templates/about-thumb.jpg',
                'preview' => 'https://demos.ngo-easybuilder.com/about/',
                'file' => NGO_EASYBUILDER_PATH . 'templates/about.json',
            ),
            'donation' => array(
                'name' => __('Donation Page', 'ngo-easybuilder'),
                'description' => __('Increase conversion with this optimized donation page featuring impact stories and trust elements.', 'ngo-easybuilder'),
                'thumbnail' => NGO_EASYBUILDER_URL . 'assets/images/templates/donation-thumb.jpg',
                'preview' => 'https://demos.ngo-easybuilder.com/donate/',
                'file' => NGO_EASYBUILDER_PATH . 'templates/donation.json',
            ),
            'projects' => array(
                'name' => __('Projects Archive', 'ngo-easybuilder'),
                'description' => __('A beautiful grid layout for showcasing your projects with filtering options.', 'ngo-easybuilder'),
                'thumbnail' => NGO_EASYBUILDER_URL . 'assets/images/templates/projects-thumb.jpg',
                'preview' => 'https://demos.ngo-easybuilder.com/projects/',
                'file' => NGO_EASYBUILDER_PATH . 'templates/projects.json',
            ),
            'contact' => array(
                'name' => __('Contact Page', 'ngo-easybuilder'),
                'description' => __('A professional contact page with map, form, and office information.', 'ngo-easybuilder'),
                'thumbnail' => NGO_EASYBUILDER_URL . 'assets/images/templates/contact-thumb.jpg',
                'preview' => 'https://demos.ngo-easybuilder.com/contact/',
                'file' => NGO_EASYBUILDER_PATH . 'templates/contact.json',
            ),
        );
    }
    
    public function import_template() {
        check_ajax_referer('ngo-templates-nonce', 'nonce');
        
        if (!current_user_can('edit_posts')) {
            wp_send_json_error(array(
                'message' => __('You do not have permission to import templates.', 'ngo-easybuilder')
            ));
            return;
        }
        
        $template_id = isset($_POST['template']) ? sanitize_text_field($_POST['template']) : '';
        $templates = $this->get_available_templates();
        
        if (!isset($templates[$template_id])) {
            wp_send_json_error(array(
                'message' => __('Template not found.', 'ngo-easybuilder')
            ));
            return;
        }
        
        $template = $templates[$template_id];
        
        // Read template file
        $template_file = $template['file'];
        if (!file_exists($template_file)) {
            wp_send_json_error(array(
                'message' => __('Template file not found.', 'ngo-easybuilder')
            ));
            return;
        }
        
        $template_data = file_get_contents($template_file);
        $template_data = json_decode($template_data, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            wp_send_json_error(array(
                'message' => __('Invalid template data.', 'ngo-easybuilder')
            ));
            return;
        }
        
        // Create a new page with the template
        $page_title = $template['name'];
        $page_slug = sanitize_title($template_id);
        
        $existing_page = get_page_by_path($page_slug);
        if ($existing_page) {
            $page_slug .= '-' . time();
        }
        
        $page_data = array(
            'post_title' => $page_title,
            'post_name' => $page_slug,
            'post_status' => 'draft',
            'post_type' => 'page',
            'post_content' => isset($template_data['content']) ? $template_data['content'] : '',
        );
        
        $page_id = wp_insert_post($page_data);
        
        if (is_wp_error($page_id)) {
            wp_send_json_error(array(
                'message' => $page_id->get_error_message()
            ));
            return;
        }
        
        // Set page template if specified
        if (isset($template_data['template']) && !empty($template_data['template'])) {
            update_post_meta($page_id, '_wp_page_template', $template_data['template']);
        }
        
        // Set Elementor data
        if (isset($template_data['elementor_data']) && !empty($template_data['elementor_data'])) {
            update_post_meta($page_id, '_elementor_data', $template_data['elementor_data']);
            update_post_meta($page_id, '_elementor_edit_mode', 'builder');
            update_post_meta($page_id, '_elementor_version', '3.6.0');
        }
        
        wp_send_json_success(array(
            'message' => __('Template imported successfully!', 'ngo-easybuilder'),
            'redirect' => admin_url('post.php?post=' . $page_id . '&action=edit')
        ));
    }
}

new NGO_EasyBuilder_Templates();

