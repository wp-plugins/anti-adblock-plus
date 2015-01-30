<?php
    
   /*
      Plugin Name: Anti AdBlock
      Plugin URI: http://www.sitepoint.com/creating-an-anti-adblock-plugin-for-wordpress/
      Description: This plugin lets you display alternative ads and also lets you disable website.
      Version: 1.0
      Author: Narayan Prusty
      Author URI: http://qnimate.com
      License: GPL2
   */
 
   function add_anti_adblock_menu_item()
   {
      add_submenu_page("options-general.php", "Anti Adblock", "Anti Adblock", "manage_options", "anti-adblock", "anti_adblock_page"); 
   }
 
   function anti_adblock_page()
   {
      ?>
         <div class="wrap">
            <h1>Anti Adblock</h1>
 
            <form method="post" action="options.php">
               <?php
                  settings_fields("anti_adblock_config_section");
 
                  do_settings_sections("anti-adblock");
                   
                  submit_button(); 
               ?>
            </form>
         </div>
 
      <?php
   }
 
   add_action("admin_menu", "add_anti_adblock_menu_item");
 
   function anti_adblock_settings()
   {
      add_settings_section("anti_adblock_config_section", "", null, "anti-adblock");
 
      add_settings_field("disable_website", "Do you want to disable website?", "disable_website_checkbox", "anti-adblock", "anti_adblock_config_section");
      add_settings_field("disable_website_url", "Image to display when website is disabled", "disable_website_image_input_field", "anti-adblock", "anti_adblock_config_section");
      add_settings_field("alternative_ads_code", "Do you want to display alternative ads code", "alternative_ads_checkbox", "anti-adblock", "anti_adblock_config_section");
      add_settings_field("alternative_ads_selector_1", "Alternaive Ad Code 1 Selector", "alternative_ads_selector_1_input_field", "anti-adblock", "anti_adblock_config_section");
      add_settings_field("alternative_ads_code_1", "Alternaive Ad Code 1", "alternative_ads_code_1_input_field", "anti-adblock", "anti_adblock_config_section");
      add_settings_field("alternative_ads_selector_2", "Alternaive Ad Code 2 Selector", "alternative_ads_selector_2_input_field", "anti-adblock", "anti_adblock_config_section");
      add_settings_field("alternative_ads_code_2", "Alternaive Ad Code 2", "alternative_ads_code_2_input_field", "anti-adblock", "anti_adblock_config_section");
      add_settings_field("custom_css", "Custom CSS", "custom_css_input_field", "anti-adblock", "anti_adblock_config_section");
 
      register_setting("anti_adblock_config_section", "disable_website");
      register_setting("anti_adblock_config_section", "disable_website_url");
      register_setting("anti_adblock_config_section", "alternative_ads_code");
      register_setting("anti_adblock_config_section", "alternative_ads_selector_1");
      register_setting("anti_adblock_config_section", "alternative_ads_code_1");
      register_setting("anti_adblock_config_section", "alternative_ads_selector_2");
      register_setting("anti_adblock_config_section", "alternative_ads_code_2");
      register_setting("anti_adblock_config_section", "custom_css");
   }
 
   function disable_website_checkbox()
   {  
      ?>
         <input type="checkbox" name="disable_website" value="1" <?php checked(1, get_option('disable_website'), true); ?> /> Check for Yes
      <?php
   }
 
   function disable_website_image_input_field()
   {
      ?>
         <input name="disable_website_url" type="txt" value="<?php echo get_option('disable_website_url'); ?>" />
      <?php
   }
 
   function alternative_ads_checkbox()
   {
      ?>
         <input type="checkbox" name="alternative_ads_code" value="1" <?php checked(1, get_option('alternative_ads_code'), true); ?> /> Check for Yes
      <?php
   }
 
   function alternative_ads_selector_1_input_field()
   {
      ?>
         <input name="alternative_ads_selector_1" type="txt" value="<?php echo get_option('alternative_ads_selector_1'); ?>" />
      <?php
   }
 
   function alternative_ads_code_1_input_field()
   {
      ?>
         <textarea name="alternative_ads_code_1"><?php echo get_option("alternative_ads_code_1"); ?></textarea>
      <?php
   }
 
   function alternative_ads_selector_2_input_field()
   {
      ?>
         <input name="alternative_ads_selector_2" type="txt" value="<?php echo get_option('alternative_ads_selector_2'); ?>" />
      <?php
   }
 
   function alternative_ads_code_2_input_field()
   {
      ?>
         <textarea name="alternative_ads_code_2"><?php echo get_option("alternative_ads_code_2"); ?></textarea>
      <?php
   }
 
   function custom_css_input_field()
   {
      $css = ".anti-adblock-textarea{display: none}" . get_option("custom_css");
      file_put_contents(plugin_dir_path(__FILE__) . "custom.css", $css);
       
      ?>
         <textarea name="custom_css"><?php echo get_option("custom_css"); ?></textarea>
      <?php  
   }
 
   add_action("admin_init", "anti_adblock_settings");
 
   function anti_adblock_footer_code()
   {
      if(get_option("disable_website") == 1)
      {
         ?>
            <span id="anti-adblock-disable-website" data-value="true"></span>
            <span id="anti-adblock-disable-website-url" data-value="<?php echo get_option('disable_website_url'); ?>"></span>
         <?php
      }
      else
      {
         ?>
            <span id="anti-adblock-disable-website" data-value="false"></span>
         <?php  
      }
 
      if(get_option("alternative_ads_code"))
      {
         //change this if your are adding more fields.
         $count = 2;
 
         ?>
            <span id="anti-adblock-alternative-ads" data-value="true" data-count="<?php echo $count; ?>"></span>
         <?php
 
         for($iii = 1; $iii <= $count; $iii++)
         {
            ?>
               <textarea class="anti-adblock-textarea" id="alternative_ads_selector_<?php echo $iii; ?>"><?php echo get_option("alternative_ads_selector_" . $iii); ?></textarea>
               <textarea class="anti-adblock-textarea" id="alternative_ads_code_<?php echo $iii; ?>"><?php echo esc_html(get_option("alternative_ads_code_" . $iii)); ?></textarea>
            <?php
         }
      }
      else
      {
         ?>
            <span id="anti-adblock-alternative-ads" data-value="false"></span>
         <?php
      }
   }
 
   function anti_adblock_style_script()
   {
      wp_register_style("anti-adblock-custom", plugin_dir_url(__FILE__) . "custom.css");
      wp_enqueue_style("anti-adblock-custom");
 
      wp_enqueue_script('anti-adblock-script', plugin_dir_url(__FILE__) . "index.js", array("jquery"), '1.0.0', true);
   }
 
   add_action("wp_footer","anti_adblock_footer_code");
   add_action("wp_enqueue_scripts", "anti_adblock_style_script");