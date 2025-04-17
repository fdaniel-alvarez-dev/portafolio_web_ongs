// includes/class-donation-system.php
class NGO_EasyBuilder_Donation_System {
    
    private $detected_plugin = null;
    
    public function __construct() {
        add_action('admin_init', array($this, 'detect_donation_plugin'));
        add_action('ngo_easybuilder_campaign_meta_box', array($this, 'add_campaign_donation_fields'));
        add_action('save_post_ngo_campaign', array($this, 'save_campaign_donation_data'));
        add_shortcode('ngo_donation_form', array($this, 'donation_form_shortcode'));
    }
    
    public function detect_donation_plugin() {
        if (class_exists('Give')) {
            $this->detected_plugin = 'give';
        } elseif (class_exists('Charitable')) {
            $this->detected_plugin = 'charitable';
        } elseif (defined('WPCF_VERSION')) {
            $this->detected_plugin = 'wp_crowdfunding';
        }
    }
    
    public function add_campaign_donation_fields($post) {
        ?>
        <div class="ngo-meta-box-field">
            <label for="campaign_goal"><?php _e('Fundraising Goal', 'ngo-easybuilder'); ?></label>
            <input type="number" id="campaign_goal" name="campaign_goal" 
                   value="<?php echo esc_attr(get_post_meta($post->ID, '_campaign_goal', true)); ?>" min="0" step="1">
        </div>
        
        <div class="ngo-meta-box-field">
            <label for="campaign_end_date"><?php _e('End Date', 'ngo-easybuilder'); ?></label>
            <input type="date" id="campaign_end_date" name="campaign_end_date" 
                   value="<?php echo esc_attr(get_post_meta($post->ID, '_campaign_end_date', true)); ?>">
        </div>
        
        <div class="ngo-meta-box-field">
            <label><?php _e('Connect to Donation Form', 'ngo-easybuilder'); ?></label>
            <?php
            if ($this->detected_plugin == 'give') {
                $forms = get_posts(array('post_type' => 'give_forms', 'numberposts' => -1));
                if (!empty($forms)) {
                    ?>
                    <select name="give_form_id">
                        <option value=""><?php _e('Select a Give donation form', 'ngo-easybuilder'); ?></option>
                        <?php foreach ($forms as $form) : ?>
                            <option value="<?php echo $form->ID; ?>" <?php selected(get_post_meta($post->ID, '_give_form_id', true), $form->ID); ?>>
                                <?php echo $form->post_title; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php
                } else {
                    echo '<p>' . __('No Give donation forms found. Please create one first.', 'ngo-easybuilder') . '</p>';
                }
            } elseif ($this->detected_plugin == 'charitable') {
                $campaigns = get_posts(array('post_type' => 'campaign', 'numberposts' => -1));
                if (!empty($campaigns)) {
                    ?>
                    <select name="charitable_campaign_id">
                        <option value=""><?php _e('Select a Charitable campaign', 'ngo-easybuilder'); ?></option>
                        <?php foreach ($campaigns as $campaign) : ?>
                            <option value="<?php echo $campaign->ID; ?>" <?php selected(get_post_meta($post->ID, '_charitable_campaign_id', true), $campaign->ID); ?>>
                                <?php echo $campaign->post_title; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php
                } else {
                    echo '<p>' . __('No Charitable campaigns found. Please create one first.', 'ngo-easybuilder') . '</p>';
                }
            } else {
                echo '<p>' . __('No supported donation plugin detected. Please install GiveWP or Charitable.', 'ngo-easybuilder') . '</p>';
            }
            ?>
        </div>
        <?php
    }
    
    public function save_campaign_donation_data($post_id) {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        if (!current_user_can('edit_post', $post_id)) return;
        
        // Save campaign goal
        if (isset($_POST['campaign_goal'])) {
            update_post_meta($post_id, '_campaign_goal', sanitize_text_field($_POST['campaign_goal']));
        }
        
        // Save campaign end date
        if (isset($_POST['campaign_end_date'])) {
            update_post_meta($post_id, '_campaign_end_date', sanitize_text_field($_POST['campaign_end_date']));
        }
        
        // Save Give form connection
        if (isset($_POST['give_form_id'])) {
            update_post_meta($post_id, '_give_form_id', sanitize_text_field($_POST['give_form_id']));
        }
        
        // Save Charitable campaign connection
        if (isset($_POST['charitable_campaign_id'])) {
            update_post_meta($post_id, '_charitable_campaign_id', sanitize_text_field($_POST['charitable_campaign_id']));
        }
    }
    
    public function donation_form_shortcode($atts) {
        $atts = shortcode_atts(array(
            'campaign_id' => 0,
        ), $atts, 'ngo_donation_form');
        
        if (empty($atts['campaign_id'])) {
            return '<p>' . __('Please specify a campaign ID', 'ngo-easybuilder') . '</p>';
        }
        
        $campaign_id = intval($atts['campaign_id']);
        $output = '';
        
        if ($this->detected_plugin == 'give') {
            $give_form_id = get_post_meta($campaign_id, '_give_form_id', true);
            if ($give_form_id) {
                $output = do_shortcode('[give_form id="' . $give_form_id . '"]');
            } else {
                $output = '<p>' . __('No donation form connected to this campaign', 'ngo-easybuilder') . '</p>';
            }
        } elseif ($this->detected_plugin == 'charitable') {
            $charitable_campaign_id = get_post_meta($campaign_id, '_charitable_campaign_id', true);
            if ($charitable_campaign_id) {
                $output = do_shortcode('[charitable_donation_form campaign_id="' . $charitable_campaign_id . '"]');
            } else {
                $output = '<p>' . __('No charitable campaign connected to this campaign', 'ngo-easybuilder') . '</p>';
            }
        } else {
            $output = '<p>' . __('No supported donation plugin detected', 'ngo-easybuilder') . '</p>';
        }
        
        return $output;
    }
}

new NGO_EasyBuilder_Donation_System();

