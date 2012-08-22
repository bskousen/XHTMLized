<?php

include_once('columns/cart.php');

if ($this->registry->column(2)) {
	foreach ($this->registry->column(2) as $column_name => $column_items) {
		include_once('columns/' . $column_name . '.php');
	}
}

?>
<?php $this->mpbanners->print_banner('column-secondary', 'halfbanner'); ?>