<form role="search" method="get" id="searchform" class="searchform" action="<?php echo home_url( '/' ); ?>">
    <div>
        <input type="text" onfocus="if(this.value == 'Enter Keywords') { this.value = ''; }"value="Enter Keywords" name="s" id="s" />
        <input type="submit" id="searchsubmit" value="Search" />
    </div>
</form>