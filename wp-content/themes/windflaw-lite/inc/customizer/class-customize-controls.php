<?php
/**
* @package Windflaw
* @author  Suihai Huang From Loft.Ocean team
* @link    http://www.loftocean.com
* @since   version 1.0.0
*/

/**
* @description custom customize controls
*/

if(class_exists('WP_Customize_Control')){
	class Windflaw_Customize_Number_Control extends WP_Customize_Control {
		public $type = 'number';	
		public function render_content(){
			$attrs = $this->input_attrs; 
		    ?>
		<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php if ( ! empty( $this->description ) ) : ?>
			<span class="description customize-control-description"><?php echo $this->description; ?></span>
			<?php endif; ?>
			<input type="number"<?php echo !empty($attrs) ? ' style="width: 65%;"' : ''; ?> value="<?php echo esc_attr($this->value()); ?>" <?php $this->link(); ?>><?php echo isset($attrs['after']) ? ' ' . $attrs['after'] : ''; ?>
		</label>
		    <?php
		}
	}

}
