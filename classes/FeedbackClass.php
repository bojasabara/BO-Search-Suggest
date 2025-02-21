<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


class BOSS_FeedbackClass {
    public function __construct() {
        add_action('admin_footer-plugins.php', array($this, 'deactivation_form'));
        add_action('wp_ajax_bo_deactivation_reason', array($this, 'deactivation_reason'));
   }

   public function deactivation_form(){
        $deactivation_reasons = $this->get_deactivation_reasons();
        ?>
        <div id="bo_deactivation_form" class="boadmin-modal-mask">
            <div class="boadmin-modal">
                <div class="modal-container">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="model-header">
                                <span><?php echo __('Feedback', 'bo_search_suggest'); ?></span>
                            </div>
                            <main class="form-container main-full">
                                <p class="bo-title-text"><?php echo __('Please let us know why you want to deactivate this plugin', 'bo_search_suggest'); ?></p>
                                <ul class="deactivation-reason" data-nonce="<?php echo wp_create_nonce('bo_deactivate_nonce'); ?>">
                                    <?php 
                                    if($deactivation_reasons){
                                        foreach($deactivation_reasons as $key => $reason){
                                            $reason_type = isset($reason['reason_type']) ? $reason['reason_type'] : '';
                                            $reason_placeholder = isset($reason['reason_placeholder']) ? $reason['reason_placeholder'] : '';
                                            ?>
                                            <li data-type="<?php echo esc_attr($reason_type); ?>" data-placeholder="<?php echo esc_attr($reason_placeholder); ?> ">
                                                <label>
                                                    <input type="radio" name="selected-reason" value="<?php echo esc_attr($key); ?>">
                                                    <span><?php echo esc_html($reason['radio_label']); ?></span>
                                                </label>
                                            </li>
                                            <?php
                                        }
                                    }
                                    ?>
                                </ul>
                                <p class="bo-privacy-cnt"><?php echo __('This form is for getting your valuable feedback. We do not collect your personal data.', 'bo_search_suggest'); ?></a></p>
                            </main>
                            <footer class="modal-footer">
                                <div class="bo-left">
                                    <a class="bo-link bo-left-link bo-deactivate" href="#"><?php echo __('Skip & Deactivate', 'bo_search_suggest'); ?></a>
                                </div>
                                <div class="bo-right">

                                    <a class="bo-link bo-right-link bo-active bo-submit-deactivate" href="#"><?php echo __('Submit and Deactivate', 'bo_search_suggest'); ?></a>
                                    <a class="bo-link bo-right-link bo-close" href="#"><?php echo __('Cancel', 'bo_search_suggest'); ?></a>
                                </div>
                            </footer>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <style type="text/css">
            .th-logo{
                margin-right: 10px;
            }
            .boadmin-modal-mask{
                position: fixed;
                background-color: rgba(17,30,60,0.6);
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: 9999;
                overflow: scroll;
                transition: opacity 250ms ease-in-out;
            }
            .boadmin-modal-mask{
                display: none;
            }
            .boadmin-modal .modal-container{
                position: absolute;
                background: #fff;
                border-radius: 2px;
                overflow: hidden;
                left: 50%;
                top: 50%;
                transform: translate(-50%,-50%);
                width: 50%;
                max-width: 960px;
                /*min-height: 560px;*/
                /*height: 80vh;*/
                /*max-height: 640px;*/
                animation: appear-down 250ms ease-in-out;
                border-radius: 15px;
            }
            .model-header {
                padding: 21px;
            }
            .boadmin-modal .model-header span {
                font-size: 18px;
                font-weight: bold;
            }
            .boadmin-modal .model-header {
                padding: 21px;
                background: #ECECEC;
            }
            .boadmin-modal .form-container {
                margin-left: 23px;
                clear: both;
            }
            .boadmin-modal .deactivation-reason input {
                margin-right: 13px;
            }
            .boadmin-modal .bo-privacy-cnt {
                color: #919191;
                font-size: 12px;
                margin-bottom: 31px;
                margin-top: 18px;
                max-width: 75%;
            }
            .boadmin-modal .deactivation-reason li {
                margin-bottom: 17px;
            }
            .boadmin-modal .modal-footer {
                padding: 20px;
                border-top: 1px solid #E7E7E7;
                float: left;
                width: 100%;
                box-sizing: border-box;
            }
            .bo-left {
                float: left;
            }
            .bo-right {
                float: right;
            }
            .bo-link {
                line-height: 31px;
                font-size: 12px;
            }
            .bo-left-link {
                font-style: italic;
            }
            .bo-right-link {
                padding: 0px 20px;
                border: 1px solid;
                display: inline-block;
                text-decoration: none;
                border-radius: 5px;
            }
            .bo-right-link.bo-active {
                background: #0773AC;
                color: #fff;
            }
            .bo-title-text {
                color: #2F2F2F;
                font-weight: 500;
                font-size: 15px;
            }
            .reason-input {
                margin-left: 31px;
                margin-top: 11px;
                width: 70%;
            }
            .reason-input input {
                width: 100%;
                height: 40px;
            }
            .reason-input textarea {
                width: 100%;
                min-height: 80px;
            }
            input.th-snooze-checkbox {
                width: 15px;
                height: 15px;
            }
            input.th-snooze-checkbox:checked:before {
                width: 1.2rem;
                height: 1.2rem;
            }
            .th-snooze-select {
                margin-left: 20px;
                width: 172px;
            }

            /* Version B */
            .get-support-version-b {
                width: 100%;
                padding-left: 23px;
                clear: both;
                float: left;
                box-sizing: border-box;
                background: #0673ab;
                color: #fff;
                margin-bottom: 20px;
            }
            .get-support-version-b p {
                font-size: 12px;
                line-height: 17px;
                width: 70%;
                display: inline-block;
                margin: 0px;
                padding: 15px 0px;
            }
            .get-support-version-b .bo-right-link {
                padding-left: 31px;
                color: #0773AC;
                background-color: #fff;
                float: right;
                margin-top: 17px;
                margin-right: 20px;
            }
            .bo-privacy-link {
                font-style: italic;
            }
            .wcfe-review-link {
                margin-top: 7px;
                margin-left: 31px;
                font-size: 16px;
            }
            span.wcfe-rating-link {
                color: #ffb900;
            }
            .bo-review-and-deactivate {
                text-decoration: none;
            }
        </style>

        <script type="text/javascript">
            (function($){
                var popup = $("#bo_deactivation_form");
                var deactivation_link = '';
                $('#deactivate-bo-autosuggest-product-search').on('click', function(e){
                    e.preventDefault();
                    deactivation_link = $(this).attr('href');
                    popup.css("display", "block");
                    popup.find('a.bo-deactivate').attr('href', deactivation_link);
                });

                popup.on('click', 'input[type="radio"]', function () {
                    var parent = $(this).parents('li:first');
                    popup.find('.reason-input').remove();

                    var type = parent.data('type');
                    var placeholder = parent.data('placeholder');

                    var reason_input = '';
                    if('text' == type){
                        reason_input += '<div class="reason-input">';
                        reason_input += '<input type="text" placeholder="'+ placeholder +'">';
                        reason_input += '</div>';
                    }else if('textarea' == type){
                        reason_input += '<div class="reason-input">';
                        reason_input += '<textarea row="5" placeholder="'+ placeholder +'">';
                        reason_input += '</textarea>';
                        reason_input += '</div>';
                    }else if('reviewlink' == type){
                        reason_input += '<div class="reason-input wcfe-review-link">';
                        reason_input += '<input type="hidden" value="<?php _e('Upgraded', 'bo_search_suggest');?>">';
                        reason_input += '</div>';
                    }

                    if(reason_input !== ''){
                        parent.append($(reason_input));
                    }
                });

                popup.on('click', '.bo-close', function () {
                    popup.css("display", "none");
                });

                popup.on('click', '.bo-submit-deactivate', function (e) {
                    e.preventDefault();
                    var button = $(this);
                    if (button.hasClass('disabled')) {
                        return;
                    }
                    var radio = $('.deactivation-reason input[type="radio"]:checked');
                    var parent_li = radio.parents('li:first');
                    var parent_ul = radio.parents('ul:first');
                    var input = parent_li.find('textarea, input[type="text"], input[type="hidden"]');
                    var wcfe_deacive_nonce = parent_ul.data('nonce');

                    $.ajax({
                        url: ajaxurl,
                        type: 'POST',
                        data: {
                            action: 'bo_deactivation_reason',
                            reason: (0 === radio.length) ? 'none' : radio.val(),
                            comments: (0 !== input.length) ? input.val().trim() : '',
                            security: wcfe_deacive_nonce,
                        },
                        beforeSend: function () {
                            button.addClass('disabled');
                            button.text('Processing...');
                        },
                        complete: function () {
                            window.location.href = deactivation_link;
                        }
                    });
                });

            }(jQuery))
        </script>

        <?php 
    }

    private function get_deactivation_reasons(){
        return array(
            'hard_to_use' => array(
                'radio_val'          => 'hard_to_use',
                'radio_label'        => __('It was difficult to use', 'bo_search_suggest'),
                'reason_type'        => 'text',
                'reason_placeholder' => __('How can we improve your experience?', 'bo_search_suggest'),
            ),

            'feature_missing'=> array(
                'radio_val'          => 'feature_missing',
                'radio_label'        => __('A particular feature is absent', 'bo_search_suggest'),
                'reason_type'        => 'text',
                'reason_placeholder' => __('Type in the feature', 'bo_search_suggest'),
            ),

            'error_or_not_working'=> array(
                'radio_val'          => 'error_or_not_working',
                'radio_label'        => __('Plugin was not working', 'bo_search_suggest'),
                'reason_type'        => 'text',
                'reason_placeholder' => __('Specify the issue', 'bo_search_suggest'),
            ),

            'temporary' => array(
                'radio_val'          => 'temporary',
                'radio_label'        => __('It’s a temporary deactivation', 'bo_search_suggest'),
                'reason_type'        => 'checkbox',
                'reason_placeholder' => __('Could you please mention the plugin?', 'bo_search_suggest'),
            ),

            'found_better_plugin' => array(
                'radio_val'          => 'found_better_plugin',
                'radio_label'        => __('I found a better Plugin', 'bo_search_suggest'),
                'reason_type'        => 'text',
                'reason_placeholder' => __('Could you please mention the plugin?', 'bo_search_suggest'),
            ),

            

            'other' => array(
                'radio_val'          => 'other',
                'radio_label'        => __('Other', 'bo_search_suggest'),
                'reason_type'        => 'textarea',
                'reason_placeholder' => __('Kindly tell us your reason, so that we can improve', 'bo_search_suggest'),
            ),
        );
    }

    public function deactivation_reason(){
        global $wpdb;

        check_ajax_referer('bo_deactivate_nonce', 'security');

        if(!isset($_POST['reason'])){
            return;
        }
        
        $data = array(
            'plugin'        => 'bo_autosuggest',
            'reason'        => sanitize_text_field($_POST['reason']),
            'comments'      => isset($_POST['comments']) ? sanitize_textarea_field(wp_unslash($_POST['comments'])) : '',
            'date'          => gmdate("M d, Y h:i:s A"),
            'software'      => $_SERVER['SERVER_SOFTWARE'],
            'php_version'   => phpversion(),
            'mysql_version' => $wpdb->db_version(),
            'wp_version'    => get_bloginfo('version'),
            'wc_version'    => (!defined('WC_VERSION')) ? '' : WC_VERSION,
            'locale'        => get_locale(),
            'multisite'     => is_multisite() ? 'Yes' : 'No',
            'plugin_version'=> SS_VERSION
        );

        $response = wp_remote_post('#', array(
            'method'      => 'POST',
            'headers'     => array( 'Content-Type' => 'application/json' ),
            'sslverify'   => false,
            'body'        => json_encode($data),
                )
        );

        wp_send_json_success();
    }
}
new BOSS_FeedbackClass();