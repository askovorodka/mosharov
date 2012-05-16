<?php
class captchaZDR {

  var $UserString;
  var $font_path;
  var $base_path;
  
  function captchaZDR(){
  $this->font_path = $this->base_path.'/png_bank/font.ttf';  
  }

  function get_code(){
    return $_SESSION['captcha'];
  }

  function LoadPNG(){  
       $bgNUM = rand(1,8);
       $im = @imagecreatefrompng($this->base_path.'/png_bank/bg'.$bgNUM.'.png'); /* Attempt to open */
       if (!$im) { 
           $im  = imagecreatetruecolor(200, 50); /* Create a blank image */
           $bgc = imagecolorallocate($im, 255, 255, 255);
           $tc  = imagecolorallocate($im, 0, 0, 0);
           imagefilledrectangle($im, 0, 0, 200, 50, $bgc);
           imagestring($im, 1, 5, 5, "Error loading $imgname", $tc);
       }
       return $im;
  }
  
  function task_string(){
  
         // create a image from png bank
        $image = $this->LoadPNG(); 
  
        $string_a = array("a","b","c","d","e","f","g","h","j","k",
                          "l","m","n","p","r","s","t","u","v","w","x","y","z",
                          "2","3","4","5","6","7","8","9");

    $width=10;
  
        for($i=0;$i<5;$i++)
        {
            $colour  = imagecolorallocate($image, rand(0,0), rand(0,0), rand(0,0));
            $font   = $this->font_path;
            $font_size  = 15;
            $angle      = 0;
            $width      = $width  + 10;
            $height     = 20;
            $temp       = $string_a[rand(0,25)];
            $this->UserString .= $temp;
            imagettftext($image, $font_size, $angle, $width, $height, $colour, $font, $temp);

        }
        
        $_SESSION['captcha'] = $this->UserString;
        
        return $image;
  }
 
  function display(){
    
        switch(rand(1,3))
        {       
          default : $image  = $this->task_string();     break;      
        }
        
        
        // output the picture
        header("Content-type: image/png");
        imagepng($image);  
  } 

  function check_result(){
  if($_SESSION['captcha']!=$_REQUEST['capt'] || $_SESSION['captcha']=='BADCODE')
  {   
    $_SESSION['captcha']='BADCODE';
    return false;
  } 
  else 
  {
      return true;
  }
  } 

}

?>
