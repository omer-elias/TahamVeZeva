<?php
/**
 * User: Oren
 * Date: 6/16/2015
 * Time: 2:35 PM
 */

namespace matat;


class form {

    /**
     * @param $args
     * $type  valid values: text, tel, email, password, radio (single) checkbox (single)
     */
    public function input( $args ){
        $args = $this->parse_args( $args);

        ?>
        <?php $this->field_start( $args['wrap'] )?>
            <label for="<?php $this->id( $args ) ?>" class="field-label <?php $this->label_class( $args )?>"><?php echo $args['label_text'] ?></label>
            <input <?php $this->required( $args )?> class="full-field"  type="<?php echo $args['type'] ?>" placeholder="<?php $args['placeholder'] ?>"
                   value="<?php echo $args['value'] ?>" name="<?php echo $args['name'] ?>" id="<?php $this->id( $args ) ?>"/>
        <?php $this->field_end( $args['wrap'] )?>


    <?php
    }

    public function textarea( $args ){

        /**
         * Parse incoming $args into an array and merge it with $defaults
         */
        $args = $this->parse_args( $args);


        ?>
        <?php $this->field_start( $args['wrap'] )?>
        <label for="<?php $this->id( $args ) ?>" class="field-label <?php $this->label_class( $args )?>"><?php echo $args['label_text'] ?></label>
        <textarea class="full-field" <?php $this->required( $args )?> placeholder="<?php _e('Type Second Title Here', 'matat')?>"
                  name="<?php echo $args['name'] ?>" id="<?php $this->id( $args ) ?>" cols="<?php echo$args['cols']?>" rows="<?php echo$args['rows']?>"><?php  echo  $args['value'] ?></textarea>

        <?php $this->field_end( $args['wrap'] )?>


    <?php
    }

    public function editor( $args ){
        $args = $this->parse_args( $args);

        ?>
        <?php $this->field_start( $args['wrap'] )?>
        <label for="<?php $this->id( $args ) ?>" class="field-label <?php $this->label_class( $args )?>"><?php echo $args['label_text'] ?></label>
        <?php
            $settings = array( 'media_buttons' => $args['media_buttons'] );
            wp_editor( $args['value'], $args['id'], $settings );
        ?>
        <?php $this->field_end( $args['wrap'] )?>


    <?php
    }

    public function image_upload( $args ){
        $args = $this->parse_args( $args);
        $id = $this->id ($args , false);
        $drop_area = $id."_display_area";
        ?>
        <?php $this->field_start( $args['wrap'] )?>
        <label for="<?php $this->id( $args ) ?>" class="field-label file-upload-label<?php $this->label_class( $args )?>"><?php echo $args['label_text'] ?></label>
        <span class="fa-lg fa"></span>
        <span class="fa-stack  fa-lg">
          <i class="fa fa-photo fa-stack-2x"></i>
       </span>
        <input class="short-field hidden"  onchange="preview(this, '<?php echo $drop_area ?>');"  type="file"
               placeholder="<?php $args['placeholder'] ?>" value="" name="<?php echo $args['name'] ?>[]" id="<?php echo $id ?>"/>
        <div id="<?php echo $drop_area?>" class="images-list-preview">

        </div>
        <?php $this->field_end( $args['wrap'] )?>


    <?php
    }
    /**
     * @param $args
     */
    public function select_posts( $args ){


        /**
         * Parse incoming $args into an array and merge it with $defaults
         */
        $args = $this->parse_args( $args);

        $this->field_start($args['wrap']);
        wp_dropdown_pages($args);
        $this->field_end($args['wrap']);

        ?>


    <?php
    }

    /**
     * start div wrapper for input
     * @param $wrap
     */
    private function field_start( $wrap ){
        if($wrap){
            echo  '<div class="form-field-wrap">';
        }
    }

    /**
     * close div wrapper for field
     * @param $wrap
     */
    private function field_end( $wrap ){
        if($wrap){
            echo  '</div>';
        }
    }

    /**
     * print hidden for label
     * @param $args
     */
    private function label_class($args){
       echo  ($args['show_label'] == false) ? 'hidden': '';
    }

    /**
     * print field id (or name if id is empty)
     * @param $args
     */
    private function id( $args ,$echo = true){
        $id = ($args['id'] == '' ) ? $args['name']: $args['id'];
       if( $echo )
           echo $id;
        return $id;
    }

    private function required($args)  {
        echo ($args['required']) ? ' required ' : '';
    }

    private function value($args)  {
        echo  ($args['value'] == '') ?  $args['placeholder']: $args['value'];
    }

    private function parse_args( $args ){
        $defaults = array(
            'selected'              => 0,
            'id'                    => '',
            'name'                  => '',
            'show_option_none'      => 'Please select', // string
            'sort_order'            => 'ASC',
            'sort_column'           => 'post_title',
            'hierarchical'          => 1,
            'post_type'             => 'post',
            'value'                 => '',
            'label_text'            => '',
            'show_label'            => true,
            'wrap'                  => true,
            'type'                  => 'text',
            'cols'                  => "30" ,
            'rows'                  => "4",
            'required'              => false,
            'media_buttons'         => false,
            'multiple'              => false

        );
        return    wp_parse_args( $args, $defaults );
    }
} 