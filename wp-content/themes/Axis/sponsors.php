<div class="clear"></div>
<div class="squarebanner ">
	<h3 class="sidetitl"> Sponsors </h3>
<ul>


<li>
<?php 
	$ban1 = get_option('axis_banner1'); 
	$url1 = get_option('axis_url1'); 
	$lab1 = get_option('axis_lab1'); 
	$alt1 = get_option('axis_alt1');
?>
<a rel="nofollow" href="<?php echo ($url1); ?> " title="<?php echo ($lab1); ?>"><img src="<?php echo ($ban1); ?>" alt="<?php echo ($alt1); ?>" style="vertical-align:bottom;" /></a>
</li>			

<li>
<?php 
	$ban2 = get_option('axis_banner2'); 
	$url2 = get_option('axis_url2'); 
	$lab2 = get_option('axis_lab2'); 	
	$alt2 = get_option('axis_alt2');
?>
<a rel="nofollow" href="<?php echo ($url2); ?>" title="<?php echo ($lab2); ?>"><img src="<?php echo ($ban2); ?>" alt="<?php echo ($alt2); ?>" style="vertical-align:bottom;" /></a>
</li>

<li>
<?php 
	$ban3 = get_option('axis_banner3'); 
	$url3 = get_option('axis_url3'); 
	$lab3 = get_option('axis_lab3'); 
	$alt3 = get_option('axis_alt3');	
?>
<a rel="nofollow" href="<?php echo ($url3); ?>" title="<?php echo ($lab3); ?>"><img src="<?php echo ($ban3); ?>" alt="<?php echo ($alt3); ?>" style="vertical-align:bottom;" /></a>
</li>

<li>
<?php 
	$ban4 = get_option('axis_banner4'); 
	$url4 = get_option('axis_url4');
	$lab4 = get_option('axis_lab4'); 
	$alt4 = get_option('axis_alt4');	
?>
<a rel="nofollow" href="<?php echo ($url4); ?>" title="<?php echo ($lab4); ?>"><img src="<?php echo ($ban4); ?>" alt="<?php echo ($alt4); ?>" style="vertical-align:bottom;" /></a>
</li>



</ul>
</div>