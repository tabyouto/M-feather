<form name="search_at" role="search" method="get" id="searchform" action="<?php echo home_url('/'); ?>"></form>
	<div><label class="screen-reader-text" for="s">Search for:</label>
		<input type="text" value="" name="s" id="s" onkeydown= "if(event.keyCode==13)search_at.submit()" />
		<input type="submit" value="Search" id="searchsubmit" />
	</div>
</form>