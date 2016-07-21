<form name="search_at" role="search" method="get" id="searchform" action="<?php echo home_url('/'); ?>" class="Search-form">
	<div class="Search-inner">
		<input type="text" value="" name="s" id="SearchInput" onkeydown= "if(event.keyCode==13)search_at.submit()" />
		<label type="submit" id="searchsubmit" class="Label" for="SearchInput"></label>
	</div>
</form>


<!--<form action="submit" >-->
<!--	<div class="Search-inner">-->
<!--		<input type="search" id="SearchInput" placeholder="Search"/>-->
<!--		<label class="Label" for="SearchInput"></label>-->
<!--	</div>-->
<!---->
<!--</form>-->