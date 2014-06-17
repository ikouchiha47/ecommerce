<?php
// @(#) $Id$
// +-----------------------------------------------------------------------+
// | Copyright (C) 2008, http://ecomm.org                                   |
// +-----------------------------------------------------------------------+
// | This file is free software; you can redistribute it and/or modify     |
// | it under the terms of the GNU General Public License as published by  |
// | the Free Software Foundation; either version 2 of the License, or     |
// | (at your option) any later version.                                   |
// | This file is distributed in the hope that it will be useful           |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of        |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the          |
// | GNU General Public License for more details.                          |
// +-----------------------------------------------------------------------+
// | Author: blackbee                                                          |
// +-----------------------------------------------------------------------+
//?>

<div id="top">
	<?php
	   if(isset($_SESSION['login'])){
        ?>
          
	  Welcome <span>[<?php print_r($_SESSION['name']);?>]</span>
	  <span>[<a href='./logout.php'>logout</a>]</span>
	  
        <?php
           }
           else{
             ?>
		<span>[<a href='./signup.php'>Signup</a>]</span>
		<span>[<a href='./login.php'>Login</a>]</span>
      <?php
          }
	  if(isset($_SESSION['cart'])){
	     print_r("<span>[<a href='./showcart.php'>cart(".$_SESSION['cart']."</a>]</span>");
	     }
       ?>
</div>
<div id="seperator"></div>
		