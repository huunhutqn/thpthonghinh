<?php  if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Display each active feature settings tab
 *
 * @copyright   Copyright (C) 2016, Zraly Studio
 * @license http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */
function epsi_display_features_settings_page() {

	$feature_settings = epsi_get_instance()->settings->get_settings();

	ob_start();  ?>

	<div class="wrap" xmlns="http://www.w3.org/1999/html">
		<div class="epsi_admin_wrap">

			<div id="epsi-top-notice-message"><a hidden id="top"></a></div>
			<h1>Features Settings</h1>     <?php
			epsi_display_page_details( $feature_settings );    ?>

		</div>
	</div>  <?php

	echo ob_get_clean();
}

/**
 * Display all configuration fields
 *
 * @param $feature_settings
 */
function epsi_display_page_details( $feature_settings ) {

	$feature_specs = EPSI_Settings_Specs::get_fields_specification();
	$form = new EPSI_html_elements();   ?>

	<form method="post" action="<?php echo admin_url( 'admin-post.php' ); ?>">

		<div id="epsi-tabs" class="form-option-tabs">
			<section class="main-nav">
				<ul class="nav-tabs">
					<li class="active">
						<h2>Settings</h2>
					</li>
					<li>
						<h2>Support</h2>
					</li>
				</ul>
			</section>
			<div class="panel-container">
				<div class="tab-panel active">
					<section class="form-options">
						<ul>
							<li class="epsi-config-item">
								<?php echo $form->checkboxes_multi_select( $feature_specs['where_to_display_ids'] + array( 'value' => $feature_settings['where_to_display_ids'],
								                                                                                           'options' => array('test1' => 'test1', 'test2' => 'test2'),
								                                                                                           'main_class' => 'epsi-checkbox-columns')); ?>
							</li>
						</ul>
					</section>
				</div>
				<div class="tab-panel">
					<section>
						<div class="epsi_row">
							<div class="epsi_col epsi_col_20">
								<h3>Support</h3>
								<p>If you encounter an issue or have a question, please submit your request below.</p>
								<a class="button primary-btn" href="http://www.echoplugins.com/contact-us/?inquiry-type=technical" target="_blank">Contact us</a>
							</div>
							<div class="epsi_col epsi_col_20">
								<h3>About Us</h3>
								<p>We have other awesome plugins at <a href="http://www.echoplugins.com/" target="_blank">echoplugins.com</a></p>
							</div>
						</div>
					</section>
				</div>
			</div>
		</div>

		<section class="epsi-save-settings">	<?php
			$form->save_settings_button();  ?>
		</section>

		<div id="epsi-dialog-info-icon" title="">
			<p id="epsi-dialog-info-icon-msg"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span></p>
		</div>

	</form>   <?php
}
