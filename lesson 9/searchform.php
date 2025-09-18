<?php 

$uniqe_id = esc_attr(uniqid("search-form"));

?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url("/"));?>">
<label class="screen-reader-text" for=""></label>

<input type="text">