<?php
class thumb {
   var $image;  
   var $type;  
   var $width;  
   var $height;
   var $name;
   
   function loadImage($name) {
	  $this->name = $name;
      $info = getimagesize($name);
      $this->width = $info[0];  
      $this->height = $info[1];  
      $this->type = $info[2];
	  
      switch($this->type){          
         case IMAGETYPE_JPEG:  
            $this->image = imagecreatefromjpeg($name);  
         break;          
         case IMAGETYPE_GIF:  
            $this->image = imagecreatefromgif($name);  
         break;          
         case IMAGETYPE_PNG:  
            $this->image = imagecreatefrompng($name);  
         break;
		 default:
		    $this->image = imagecreatefromjpeg($name);
      }       
   }
    
   function save($name, $quality = 100) { 
      switch($this->type){          
         case IMAGETYPE_JPEG:  
            imagejpeg($this->image, $name, $quality);  
         break;          
         case IMAGETYPE_GIF:  
             imagegif($this->image, $name);  
         break;          
         case IMAGETYPE_PNG:  
            $pngquality = floor(($quality - 10) / 10);  
            imagepng($this->image, $name, $pngquality);  
         break;
		 default:
		 	imagejpeg($this->image, $name, $quality);
      } 
     imagedestroy($this->image); 
   }
   
   function show($fileType) {  
      switch($this->type){          
         case IMAGETYPE_JPEG:
		 	header("Content-type: $fileType");
            imagejpeg($this->image);  
         break;          
         case IMAGETYPE_GIF:
		 	header("Content-type: $fileType");
            imagegif($this->image);  
         break;          
         case IMAGETYPE_PNG:
		 	header("Content-type: $fileType");
            imagepng($this->image);  
         break;
		 default:
		 	header("Content-type: $fileType");
            imagepng($this->image);
      }
     imagedestroy($this->image);
   }
   
   function resize($value, $prop){
      $prop_value = ($prop == 'width') ? $this->width : $this->height;  
      $prop_versus = ($prop == 'width') ? $this->height : $this->width;
	  
      $pcent = $value / $prop_value;        
      $value_versus = $prop_versus * $pcent;
	  
      $image = ($prop == 'width') ? imagecreatetruecolor($value, $value_versus) : imagecreatetruecolor($value_versus, $value);
	   
      switch($prop){
         case 'width':  
            imagecopyresampled($image, $this->image, 0, 0, 0, 0, $value, $value_versus, $this->width, $this->height);  
         break;
         case 'height':  
            imagecopyresampled($image, $this->image, 0, 0, 0, 0, $value_versus, $value, $this->width, $this->height);  
         break;  
           
      }
	  
      $info = getimagesize($this->name);
	  
      $this->width = imagesx($image);  
      $this->height = imagesy($image);  
      $this->image = $image;
   }
    
   function crop($cwidth, $cheight, $pos = 'center') {  
      $new_w = $cwidth; 
      $new_h = ($cwidth / $this->width) * $this->height; 
       
      if($new_h < $cheight){ 
          
         $new_h = $cheight; 
         $new_w = ($cheight / $this->height) * $this->width; 
       
      } 
       
      $this->resize($new_w, 'width');
	  
      $image = imagecreatetruecolor($cwidth, $cheight);
	  
      switch($pos){
		  
		  case 'center':
		  imagecopyresampled($image, $this->image, 0, 0, abs(($this->width - $cwidth) / 2), abs(($this->height - $cheight) / 2), $cwidth, $cheight, $cwidth, $cheight);
		  break;
		  
		  case 'left':
		  imagecopyresampled($image, $this->image, 0, 0, 0, abs(($this->height - $cheight) / 2), $cwidth, $cheight, $cwidth, $cheight);
		  break;
		  
		  case 'right':
		  imagecopyresampled($image, $this->image, 0, 0, $this->width - $cwidth, abs(($this->height - $cheight) / 2), $cwidth, $cheight, $cwidth, $cheight);
		  break;
		  
		  case 'top':
		  imagecopyresampled($image, $this->image, 0, 0, abs(($this->width - $cwidth) / 2), 0, $cwidth, $cheight, $cwidth, $cheight);
		  break;
		  
		  case 'bottom':
		  imagecopyresampled($image, $this->image, 0, 0, abs(($this->width - $cwidth) / 2), $this->height - $cheight, $cwidth, $cheight, $cwidth, $cheight);
		  break;
		  
      }
      $this->image = $image;  
   }
}  
?>