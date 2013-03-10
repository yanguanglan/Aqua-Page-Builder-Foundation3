<?php
class AQ_Panel_Block extends AQ_Block {
	
	function __construct() {
		$block_options = array(
			'name' => 'Panel',
			'size' => 'span6',
		);
		
		parent::__construct('aq_panel_block', $block_options);
	}
	
	function form($instance) {
		
		$defaults = array(
			'text' => '',
		);

		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
			
		$panel_types = array(
			'normal' => 'Normal',
			'callout' => 'Callout'
		);
		
		?>
		<p class="description">
			<label for="<?php echo $this->get_field_id('title') ?>">
				Title (optional)
				<?php echo aq_field_input('title', $block_id, $title, $size = 'full') ?>
			</label>
		</p>
		
		<p class="description">
			<label for="<?php echo $this->get_field_id('text') ?>">
				Content
				<?php echo aq_field_textarea('text', $block_id, $text, $size = 'full') ?>
			</label>
		</p>

		<p class="description">
			<label for="<?php echo $this->get_field_id('type') ?>">
				Panel style<br/>
				<?php echo aq_field_select('type', $block_id, $panel_types, $type) ?>
			</label>
		</p>
		
		<?php
	}
	
	function block($instance) {
		extract($instance);
		
		$classes = '';
		if($type == 'callout') $classes = ' callout';

		echo '<div class="panel radius'.$classes.'">';
		if($title) echo '<h4 class="block-title">'.strip_tags($title).'</h4>';
		echo wpautop(do_shortcode(htmlspecialchars_decode($text)));
		echo '</div>';
	}
	
}