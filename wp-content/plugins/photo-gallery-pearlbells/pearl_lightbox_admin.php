<?php $default_pearl_thumbnail_height = get_option('pearl_thumbnail_height');
      $default_pearl_thumbnail_width = get_option('pearl_thumbnail_width');
	  $default_pearl_thumbnail_margin = get_option('pearl_thumbnail_margin');
      $default_pearl_thumbnail_border_color = get_option('pearl_thumbnail_border_color');
	  $default_pearl_thumbnail_border_width = get_option('pearl_thumbnail_border_width');
	  $default_pearl_thumbnail_padding = get_option('pearl_thumbnail_padding');
	  $default_pearl_thumbnail_bg_color = get_option('pearl_thumbnail_bg_color');
      $default_pearl_lightbox_no_of_col = get_option('pearl_lightbox_no_of_col');
	  $default_pearl_lightbox_no_of_character = get_option('pearl_lightbox_no_of_character');
	  // Get default style of popup window
	  
	  $default_pearl_popupbox_height = get_option('pearl_popupbox_height');
      $default_pearl_popupbox_width = get_option('pearl_popupbox_width');
	  $default_pearl_popupbox_bg_color = get_option('pearl_popupbox_bg_color');
      $default_pearl_popupbox_border_color = get_option('pearl_popupbox_border_color');
	  $default_pearl_popupbox_border_width = get_option('pearl_popupbox_border_width');
	  
		?>
      <form method="post">
           <h3>Thumbnail Settings</h3>
           <label for="pearl_thumbnail_width">Thumbnail Width :</label>
           <input type="text" name="pearl_thumbnail_width" value="<?php echo $default_pearl_thumbnail_width;?>"/>
           <label for="pearl_thumbnail_height">Thumbnail Height :</label>
           <input type="text" name="pearl_thumbnail_height" value="<?php echo $default_pearl_thumbnail_height;?>"/><br/>
           <label for="pearl_thumbnail_border_width">Thumbnail Border Width :</label>
           <input type="text" name="pearl_thumbnail_border_width" value="<?php echo $default_pearl_thumbnail_border_width;?>"/>
           <label for="pearl_thumbnail_border_color">Thumbnail Border Color :</label>
           <input type="text" name="pearl_thumbnail_border_color" value="<?php echo $default_pearl_thumbnail_border_color;?>"/><br/>
           <label for="pearl_thumbnail_margin">Margin :</label>
           <input type="text" name="pearl_thumbnail_margin" value="<?php echo $default_pearl_thumbnail_margin;?>"/>
           <label for="pearl_thumbnail_padding">Padding :</label>
           <input type="text" name="pearl_thumbnail_padding" value="<?php echo $default_pearl_thumbnail_padding;?>"/><br/>
           <label for="pearl_thumbnail_bg_color">Bg Color :</label>
           <input type="text" name="pearl_thumbnail_bg_color" value="<?php echo $default_pearl_thumbnail_bg_color;?>"/>
           
           <label for="pearl_lightbox_no_of_col">No of Cols :</label>
           <input type="text" name="pearl_lightbox_no_of_col" value="<?php echo $default_pearl_lightbox_no_of_col;?>"/>
            <label for="pearl_lightbox_no_of_character">No of Character :</label>
           <input type="text" name="pearl_lightbox_no_of_character" value="<?php echo $default_pearl_lightbox_no_of_character;?>"/>
           
           <h3>Popup Window Settings</h3>
           <label for="pearl_popupbox_width">Width :</label>
           <input type="text" name="pearl_popupbox_width" value="<?php echo $default_pearl_popupbox_width;?>"/>
           <label for="pearl_popupbox_height">Height :</label>
           <input type="text" name="pearl_popupbox_height" value="<?php echo $default_pearl_popupbox_height;?>"/><br/>
           <label for="pearl_popupbox_border_width">Border Width :</label>
           <input type="text" name="pearl_popupbox_border_width" value="<?php echo $default_pearl_popupbox_border_width;?>"/>
           <label for="pearl_popupbox_border_color">Border Color :</label>
           <input type="text" name="pearl_popupbox_border_color" value="<?php echo $default_pearl_popupbox_border_color;?>"/><br/>
           <label for="pearl_popupbox_bg_color">Bg Color :</label>
           <input type="text" name="pearl_popupbox_bg_color" value="<?php echo $default_pearl_popupbox_bg_color;?>"/>
           
           
                   
           <input type="submit" name="submit" value="Submit"/>
        </form>
        
         <p>Created by <a href="http://pearlbells.co.uk/" target="_blank">Pearlbells</a><br/> Follow me : <a href="http://twitter.com/#!/pearlbells" target="_blank">Twitter</a><br/>Please Donate : <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=W884YAWEDPA9U" target="_blank">Click Here</a></p>
         <p>Feel free to email me lizeipe@gmail.com for any advice or suggestion.</p>