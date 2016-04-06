<header class="s_header">

	<nav>
	<?php
    if(isset($go_back) && $go_back==1){
        echo '<a href="javascript:history.back();" class="bg"> <span class="fa ">返回</span></a>';
    }
    ?>
		 <span style="font-size: 2rem;font-weight: bold;"><?php echo $this->title;?></span>
	</nav>
</header>