<?php
/** "Divider" block 
 * 
 * Variation of "Clear" block
 * Optional to use horizontal lines/images
**/
class AQ_Divider_Block extends AQ_Block {
	
	//set and create block
	function __construct() {
		$block_options = array(
			'name' => 'Divider',
			'size' => 'span12',
		);
		
		//create the block
		parent::__construct('aq_divider_block', $block_options);
	}
	
	function form($instance) {
		
		$defaults = array(
			'horizontal_line' => 'none',
			'line_color' => '#eee',
			'pattern' => '1',
			'height' => ''
		);
		
		$line_options = array(
			'none' => 'None',
			'single' => 'Single',
			'double' => 'Double',
			'image' => 'Use Image',
		);
		
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
		
		$line_color = isset($line_color) ? $line_color : '#eee';
		
		?>
		<p class="description note">
			<?php _e('Use this block to add spacing and horizontal rules between rows.', 'framework') ?>
		</p>
		<p class="description half">
			<label for="<?php echo $this->get_field_id('line_color') ?>">
				Pick a horizontal line<br/>
				<?php echo aq_field_select('horizontal_line', $block_id, $line_options, $horizontal_line, $block_id); ?>
			</label>
		</p>
		<div class="description fourth">
			<label for="<?php echo $this->get_field_id('height') ?>">
				Height (optional)<br/>
				<?php echo aq_field_input('height', $block_id, $height, 'min', 'number') ?> px
			</label>
		</div>
		<div class="description fourth last">
			<label for="<?php echo $this->get_field_id('line_color') ?>">
				Full Width?<br/>
				<?php echo aq_field_checkbox('full_width', $block_id, $full_width) ?> Yes
			</label>
		</div>
		<div class="cf"></div>
		<div class="description twelve last">
			<label for="<?php echo $this->get_field_id('line_color') ?>">
				Pick a line color<br/>
				<?php echo aq_field_color_picker('line_color', $block_id, $line_color, $defaults['line_color']) ?>
			</label>
		</div>
		<?php
		
	}
	
	function block($instance) {
		extract($instance);
		if($full_width != "1") $class = "not-full-width";
		switch($horizontal_line) {
			case 'none':
				break;
			case 'single':
				echo '<hr class="aq-block-clear aq-block-hr-single '.$class.'" style="border-color:'.$line_color.';"/>';
				break;
			case 'double':
				echo '<hr class="aq-block-clear aq-block-hr-double '.$class.'" style="border-color:'.$line_color.';margin-bottom:5px;"/>';
				echo '<hr class="aq-block-clear aq-block-hr-single '.$class.'" style="border-color:'.$line_color.';margin-top:5px;"/>';
				break;
			case 'image':
				echo '<hr class="aq-block-clear aq-block-hr-image '.$class.'"/>';
				break;
		}
		
		if($height) {
			echo '<div style="height:'.$height.'px"></div>';
		}
		
	}
	
}