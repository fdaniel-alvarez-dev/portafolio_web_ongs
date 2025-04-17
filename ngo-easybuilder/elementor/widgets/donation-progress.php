// elementor/widgets/donation-progress.php
class NGO_EasyBuilder_Donation_Progress extends \Elementor\Widget_Base {
    
    public function get_name() {
        return 'ngo_donation_progress';
    }
    
    public function get_title() {
        return __('Donation Progress', 'ngo-easybuilder');
    }
    
    public function get_icon() {
        return 'eicon-skill-bar';
    }
    
    public function get_categories() {
        return ['ngo-easybuilder'];
    }
    
    protected function _register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'ngo-easybuilder'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        
        $this->add_control(
            'campaign_id',
            [
                'label' => __('Campaign', 'ngo-easybuilder'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $this->get_campaigns(),
                'default' => '0',
            ]
        );
        
        $this->add_control(
            'display_style',
            [
                'label' => __('Display Style', 'ngo-easybuilder'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'bar' => __('Progress Bar', 'ngo-easybuilder'),
                    'circle' => __('Circle Progress', 'ngo-easybuilder'),
                    'thermometer' => __('Thermometer', 'ngo-easybuilder'),
                ],
                'default' => 'bar',
            ]
        );
        
        $this->end_controls_section();
        
        // Style controls would go here
    }
    
    private function get_campaigns() {
        $campaigns = get_posts([
            'post_type' => 'ngo_campaign',
            'numberposts' => -1,
            'post_status' => 'publish',
        ]);
        
        $options = [
            '0' => __('Select a Campaign', 'ngo-easybuilder'),
        ];
        
        foreach ($campaigns as $campaign) {
            $options[$campaign->ID] = $campaign->post_title;
        }
        
        return $options;
    }
    
    protected function render() {
        $settings = $this->get_settings_for_display();
        
        if ($settings['campaign_id'] == '0') {
            echo __('Please select a campaign', 'ngo-easybuilder');
            return;
        }
        
        $campaign_id = $settings['campaign_id'];
        $goal = get_post_meta($campaign_id, '_campaign_goal', true);
        $current = get_post_meta($campaign_id, '_campaign_current', true);
        
        if (!$goal) {
            echo __('Campaign goal not set', 'ngo-easybuilder');
            return;
        }
        
        $percentage = min(100, floor(($current / $goal) * 100));
        
        // Output based on display style
        if ($settings['display_style'] == 'bar') {
            ?>
            <div class="ngo-progress-bar-container">
                <div class="ngo-progress-bar-wrapper">
                    <div class="ngo-progress-bar" style="width: <?php echo $percentage; ?>%"></div>
                </div>
                <div class="ngo-progress-stats">
                    <span class="ngo-progress-percentage"><?php echo $percentage; ?>%</span>
                    <span class="ngo-progress-raised"><?php echo esc_html(get_option('ngo_currency_symbol', '$') . number_format($current)); ?> raised</span>
                    <span class="ngo-progress-goal">of <?php echo esc_html(get_option('ngo_currency_symbol', '$') . number_format($goal)); ?> goal</span>
                </div>
            </div>
            <?php
        } elseif ($settings['display_style'] == 'circle') {
            // Circle progress implementation
            ?>
            <div class="ngo-circle-progress" data-percentage="<?php echo $percentage; ?>">
                <svg viewBox="0 0 100 100">
                    <circle class="ngo-circle-bg" cx="50" cy="50" r="45"></circle>
                    <circle class="ngo-circle-progress-path" cx="50" cy="50" r="45" style="stroke-dashoffset: <?php echo (100 - $percentage) * 2.83; ?>"></circle>
                    <text class="ngo-circle-text" x="50" y="50"><?php echo $percentage; ?>%</text>
                </svg>
                <div class="ngo-progress-stats">
                    <span class="ngo-progress-raised"><?php echo esc_html(get_option('ngo_currency_symbol', '$') . number_format($current)); ?> raised</span>
                    <span class="ngo-progress-goal">of <?php echo esc_html(get_option('ngo_currency_symbol', '$') . number_format($goal)); ?> goal</span>
                </div>
            </div>
            <?php
        } else {
            // Thermometer implementation
            ?>
            <div class="ngo-thermometer">
                <div class="ngo-thermometer-container">
                    <div class="ngo-thermometer-track">
                        <div class="ngo-thermometer-progress" style="height: <?php echo $percentage; ?>%"></div>
                    </div>
                    <div class="ngo-thermometer-goal"><?php echo esc_html(get_option('ngo_currency_symbol', '$') . number_format($goal)); ?></div>
                    <div class="ngo-thermometer-current" style="bottom: <?php echo $percentage; ?>%">
                        <?php echo esc_html(get_option('ngo_currency_symbol', '$') . number_format($current)); ?>
                    </div>
                </div>
            </div>
            <?php
        }
    }
}

