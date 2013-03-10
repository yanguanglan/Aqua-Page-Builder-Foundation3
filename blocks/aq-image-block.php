<?php
/* Media Uploader Block */
if(!class_exists('AQ_Image_Block')) {
	class AQ_Image_Block extends AQ_Block {
		
		function __construct() {
			$block_options = array(
				'name' => 'Image',
				'size' => 'span6',
			);
			
			//create the block
			parent::__construct('aq_image_block', $block_options);
		}
		
		function form($instance) {
			$defaults = array(
				'image' => ''
			);
			$instance = wp_parse_args($instance, $defaults);
			extract($instance);
			
			?>
			<p class="description">
				<label for="<?php echo $this->get_field_id('image') ?>">
					File<br/>
					<?php echo aq_field_upload('image', $block_id, $image) ?>
				</label>
			</p>
			<?php
		}
		
		function block($instance) {
			extract($instance);
			echo '<img src="'.$image.'">';
		}
		
	}
}
