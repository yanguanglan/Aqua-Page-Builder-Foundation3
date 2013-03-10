<?php
/** Notifications block **/

if(!class_exists('AQ_Alert_Block')) {
	class AQ_Alert_Block extends AQ_Block {
		
		//set and create block
		function __construct() {
			$block_options = array(
				'name' => 'Alerts',
				'size' => 'span6',
			);
			
			//create the block
			parent::__construct('aq_alert_block', $block_options);
		}
		
		function form($instance) {
			
			$defaults = array(
				'type' => '',
				'style' => ''
			);
			$instance = wp_parse_args($instance, $defaults);
			extract($instance);
			
			$type_options = array(
				'' => 'Standard',
				'success' => 'Success',
				'alert' => 'Alert/Warning',
				'secondary' => 'Secondary/Info'
			);
			?>
			
			<p class="description">
				<label for="<?php echo $this->get_field_id('title') ?>">
					Alert Text<br/>
					<?php echo aq_field_input('title', $block_id, $title) ?>
				</label>
			</p>
			<p class="description half">
				<label for="<?php echo $this->get_field_id('type') ?>">
					Alert Type<br/>
					<?php echo aq_field_select('type', $block_id, $type_options, $type) ?>
				</label>
			</p>
			<p class="description half">
				<label for="<?php echo $this->get_field_id('closable') ?>">
					Closable?<br/>
					<?php echo aq_field_checkbox('closable', $block_id, $closable) ?> Yes
				</label>
			</p>
			<p class="description half last">
				<label for="<?php echo $this->get_field_id('style') ?>">
					Additional inline css styling (optional)<br/>
					<?php echo aq_field_input('style', $block_id, $style) ?>
				</label>
			</p>
			<?php
			
		}
		
		function block($instance) {
			extract($instance);
			if($closable == "1") $cross = '<a href="" class="close">&times;</a>';
			echo '<div class="alert-box '.$type.'" style="'. $style .'">' . do_shortcode(htmlspecialchars_decode($title)) . $cross . '</div>';
			
		}
		
	}
}