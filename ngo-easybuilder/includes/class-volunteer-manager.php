// includes/class-volunteer-manager.php
class NGO_EasyBuilder_Volunteer_Manager {
    
    public function __construct() {
        add_action('init', array($this, 'register_volunteer_post_type'));
        add_action('init', array($this, 'register_opportunity_post_type'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_shortcode('ngo_volunteer_application', array($this, 'volunteer_application_shortcode'));
        add_shortcode('ngo_volunteer_opportunities', array($this, 'volunteer_opportunities_shortcode'));
        add_action('wp_ajax_ngo_submit_volunteer_application', array($this, 'process_volunteer_application'));
        add_action('wp_ajax_nopriv_ngo_submit_volunteer_application', array($this, 'process_volunteer_application'));
    }
    
    public function register_volunteer_post_type() {
        register_post_type('ngo_volunteer', array(
            'labels' => array(
                'name' => __('Volunteers', 'ngo-easybuilder'),
                'singular_name' => __('Volunteer', 'ngo-easybuilder'),
                // Additional labels...
            ),
            'public' => false,
            'publicly_queryable' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'supports' => array('title'),
            'menu_icon' => 'dashicons-admin-users',
            'capability_type' => 'post',
            'capabilities' => array(
                'create_posts' => 'do_not_allow', // Removes 'Add New' button
            ),
            'map_meta_cap' => true,
        ));
    }
    
    public function register_opportunity_post_type() {
        register_post_type('ngo_opportunity', array(
            'labels' => array(
                'name' => __('Opportunities', 'ngo-easybuilder'),
                'singular_name' => __('Opportunity', 'ngo-easybuilder'),
                // Additional labels...
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
            'menu_icon' => 'dashicons-clipboard',
            'rewrite' => array('slug' => 'volunteer-opportunities'),
            'show_in_rest' => true,
        ));
        
        register_taxonomy('opportunity_category', 'ngo_opportunity', array(
            'label' => __('Categories', 'ngo-easybuilder'),
            'hierarchical' => true,
            'show_in_rest' => true,
            'rewrite' => array('slug' => 'opportunity-category'),
        ));
        
        register_taxonomy('opportunity_location', 'ngo_opportunity', array(
            'label' => __('Locations', 'ngo-easybuilder'),
            'hierarchical' => true,
            'show_in_rest' => true,
            'rewrite' => array('slug' => 'opportunity-location'),
        ));
    }
    
    public function enqueue_scripts() {
        wp_enqueue_script('ngo-volunteer-scripts', NGO_EASYBUILDER_URL . 'assets/js/volunteer.js', array('jquery'), NGO_EASYBUILDER_VERSION, true);
        wp_localize_script('ngo-volunteer-scripts', 'ngoVolunteer', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('ngo-volunteer-nonce'),
        ));
    }
    
    public function volunteer_application_shortcode($atts) {
        $atts = shortcode_atts(array(
            'opportunity_id' => 0,
        ), $atts, 'ngo_volunteer_application');
        
        ob_start();
        ?>
        <div class="ngo-volunteer-application-form">
            <form id="ngo-volunteer-form" method="post">
                <?php wp_nonce_field('ngo_volunteer_application', 'ngo_volunteer_nonce'); ?>
                
                <?php if ($atts['opportunity_id']) : ?>
                    <input type="hidden" name="opportunity_id" value="<?php echo intval($atts['opportunity_id']); ?>">
                <?php else : ?>
                    <div class="form-group">
                        <label for="opportunity"><?php _e('Select Opportunity', 'ngo-easybuilder'); ?></label>
                        <select name="opportunity_id" id="opportunity" required>
                            <option value=""><?php _e('Select an opportunity', 'ngo-easybuilder'); ?></option>
                            <?php
                            $opportunities = get_posts(array(
                                'post_type' => 'ngo_opportunity',
                                'numberposts' => -1,
                                'post_status' => 'publish',
                            ));
                            
                            foreach ($opportunities as $opportunity) {
                                echo '<option value="' . $opportunity->ID . '">' . $opportunity->post_title . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                <?php endif; ?>
                
                <div class="form-group">
                    <label for="first_name"><?php _e('First Name', 'ngo-easybuilder'); ?></label>
                    <input type="text" name="first_name" id="first_name" required>
                </div>
                
                <div class="form-group">
                    <label for="last_name"><?php _e('Last Name', 'ngo-easybuilder'); ?></label>
                    <input type="text" name="last_name" id="last_name" required>
                </div>
                
                <div class="form-group">
                    <label for="email"><?php _e('Email', 'ngo-easybuilder'); ?></label>
                    <input type="email" name="email" id="email" required>
                </div>
                
                <div class="form-group">
                    <label for="phone"><?php _e('Phone', 'ngo-easybuilder'); ?></label>
                    <input type="tel" name="phone" id="phone">
                </div>
                
                <div class="form-group">
                    <label for="message"><?php _e('Why do you want to volunteer?', 'ngo-easybuilder'); ?></label>
                    <textarea name="message" id="message" rows="5"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="availability"><?php _e('Availability', 'ngo-easybuilder'); ?></label>
                    <select name="availability" id="availability">
                        <option value="weekdays"><?php _e('Weekdays', 'ngo-easybuilder'); ?></option>
                        <option value="weekends"><?php _e('Weekends', 'ngo-easybuilder'); ?></option>
                        <option value="evenings"><?php _e('Evenings', 'ngo-easybuilder'); ?></option>
                        <option value="flexible"><?php _e('Flexible', 'ngo-easybuilder'); ?></option>
                    </select>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="ngo-volunteer-submit">
                        <?php _e('Submit Application', 'ngo-easybuilder'); ?>
                    </button>
                </div>
                
                <div class="ngo-volunteer-message"></div>
            </form>
        </div>
        <?php
        return ob_get_clean();
    }
    
    public function volunteer_opportunities_shortcode($atts) {
        $atts = shortcode_atts(array(
            'category' => '',
            'location' => '',
            'number' => 10,
            'columns' => 3,
        ), $atts, 'ngo_volunteer_opportunities');
        
        $args = array(
            'post_type' => 'ngo_opportunity',
            'posts_per_page' => intval($atts['number']),
            'post_status' => 'publish',
        );
        
        $tax_query = array();
        
        if (!empty($atts['category'])) {
            $tax_query[] = array(
                'taxonomy' => 'opportunity_category',
                'field' => 'slug',
                'terms' => explode(',', $atts['category']),
            );
        }
        
        if (!empty($atts['location'])) {
            $tax_query[] = array(
                'taxonomy' => 'opportunity_location',
                'field' => 'slug',
                'terms' => explode(',', $atts['location']),
            );
        }
        
        if (!empty($tax_query)) {
            $args['tax_query'] = $tax_query;
        }
        
        $opportunities = new WP_Query($args);
        
        ob_start();
        
        if ($opportunities->have_posts()) :
            ?>
            <div class="ngo-opportunities-grid columns-<?php echo intval($atts['columns']); ?>">
                <?php while ($opportunities->have_posts()) : $opportunities->the_post(); ?>
                    <div class="ngo-opportunity-card">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="ngo-opportunity-image">
                                <?php the_post_thumbnail('medium'); ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="ngo-opportunity-content">
                            <h3 class="ngo-opportunity-title"><?php the_title(); ?></h3>
                            
                            <div class="ngo-opportunity-meta">
                                <?php
                                $categories = get_the_terms(get_the_ID(), 'opportunity_category');
                                $locations = get_the_terms(get_the_ID(), 'opportunity_location');
                                
                                if ($categories) {
                                    echo '<span class="ngo-opportunity-category">';
                                    echo esc_html($categories[0]->name);
                                    echo '</span>';
                                }
                                
                                if ($locations) {
                                    echo '<span class="ngo-opportunity-location">';
                                    echo esc_html($locations[0]->name);
                                    echo '</span>';
                                }
                                ?>
                            </div>
                            
                            <div class="ngo-opportunity-excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                            
                            <a href="<?php the_permalink(); ?>" class="ngo-opportunity-link">
                                <?php _e('View Details', 'ngo-easybuilder'); ?>
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
            <?php
            wp_reset_postdata();
        else :
            ?>
            <p><?php _e('No volunteer opportunities found.', 'ngo-easybuilder'); ?></p>
            <?php
        endif;
        
        return ob_get_clean();
    }
    
    public function process_volunteer_application() {
        check_ajax_referer('ngo-volunteer-nonce', 'nonce');
        
        $opportunity_id = isset($_POST['opportunity_id']) ? intval($_POST['opportunity_id']) : 0;
        $first_name = isset($_POST['first_name']) ? sanitize_text_field($_POST['first_name']) : '';
        $last_name = isset($_POST['last_name']) ? sanitize_text_field($_POST['last_name']) : '';
        $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
        $phone = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '';
        $message = isset($_POST['message']) ? sanitize_textarea_field($_POST['message']) : '';
        $availability = isset($_POST['availability']) ? sanitize_text_field($_POST['availability']) : '';
        
        if (empty($opportunity_id) || empty($first_name) || empty($last_name) || empty($email)) {
            wp_send_json_error(array(
                'message' => __('Please fill in all required fields.', 'ngo-easybuilder')
            ));
            return;
        }
        
        $opportunity = get_post($opportunity_id);
        if (!$opportunity || $opportunity->post_type !== 'ngo_opportunity') {
            wp_send_json_error(array(
                'message' => __('Invalid opportunity selected.', 'ngo-easybuilder')
            ));
            return;
        }
        
        // Create volunteer record
        $volunteer_data = array(
            'post_title' => $first_name . ' ' . $last_name,
            'post_type' => 'ngo_volunteer',
            'post_status' => 'private',
        );
        
        $volunteer_id = wp_insert_post($volunteer_data);
        
        if (is_wp_error($volunteer_id)) {
            wp_send_json_error(array(
                'message' => __('Error creating application. Please try again.', 'ngo-easybuilder')
            ));
            return;
        }
        
        // Save volunteer meta data
        update_post_meta($volunteer_id, '_volunteer_first_name', $first_name);
        update_post_meta($volunteer_id, '_volunteer_last_name', $last_name);
        update_post_meta($volunteer_id, '_volunteer_email', $email);
        update_post_meta($volunteer_id, '_volunteer_phone', $phone);
        update_post_meta($volunteer_id, '_volunteer_message', $message);
        update_post_meta($volunteer_id, '_volunteer_availability', $availability);
        update_post_meta($volunteer_id, '_volunteer_opportunity', $opportunity_id);
        update_post_meta($volunteer_id, '_volunteer_status', 'pending');
        update_post_meta($volunteer_id, '_volunteer_application_date', current_time('mysql'));
        
        // Send notification emails
        $admin_email = get_option('admin_email');
        $site_name = get_bloginfo('name');
        
        // Email to admin
        $admin_subject = sprintf(__('New Volunteer Application: %s %s', 'ngo-easybuilder'), $first_name, $last_name);
        $admin_message = sprintf(
            __("A new volunteer application has been submitted for %s.\n\nName: %s %s\nEmail: %s\nPhone: %s\nAvailability: %s\nMessage: %s\n\nView application: %s", 'ngo-easybuilder'),
            $opportunity->post_title,
            $first_name,
            $last_name,
            $email,
            $phone,
            $availability,
            $message,
            admin_url('post.php?post=' . $volunteer_id . '&action=edit')
        );
        
        wp_mail($admin_email, $admin_subject, $admin_message);
        
        // Confirmation email to volunteer
        $volunteer_subject = sprintf(__('Your Volunteer Application to %s', 'ngo-easybuilder'), $site_name);
        $volunteer_message = sprintf(
            __("Dear %s,\n\nThank you for your interest in volunteering with %s. We have received your application for the position of \"%s\".\n\nWe'll review your application and get back to you soon.\n\nBest regards,\nThe team at %s", 'ngo-easybuilder'),
            $first_name,
            $site_name,
            $opportunity->post_title,
            $site_name
        );
        
        wp_mail($email, $volunteer_subject, $volunteer_message);
        
        wp_send_json_success(array(
            'message' => __('Your application has been submitted successfully. We will contact you soon.', 'ngo-easybuilder')
        ));
    }
}

new NGO_EasyBuilder_Volunteer_Manager();
