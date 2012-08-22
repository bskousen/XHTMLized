<?php

function category_list($categories, &$i = 0, $p_name = false)
{
	$html = '';
	foreach ($categories as $category) {
		/*
		if ($i % 2) {
			$html.= '	<tr class="odd">';
		} else {
			$html.= '	<tr class="even">';
		}
		*/
		$name = ($p_name) ? $p_name . ' > ' . $category['name'] : $category['name'];
		$html.= '	<tr class="' . (($i % 2) ? "odd" : "even") . '">';
		$html.= '		<td></td>';
		$html.=	'		<td class="column-title"><a href="' . _reg('module_url') . 'category/edit/' . $category['category_ID'] . '">' . $name . '</a></td>';
		$html.= '		<td class="column-buttons"><a href="' . _reg('module_url') . 'category/edit/' . $category['category_ID'] . '">editar</a> <a href="' . _reg('module_url') . 'category/delete/' . $category['category_ID'] . '">borrar</a></td>';
		$html.= '	</tr>';
		$i++;
		if ($category['childs']) {
			$html.= category_list($category['childs'], $i, $name);
		}
	}
	return $html;
}

?>
<div class="buttons"><a href="<?php echo _reg('site_url'); ?>admin/blog/category/edit">nueva categoría</a></div>
<div class="section-box">
	<div class="header">
		<h3>Listado de categorías</h3>
	</div>
	<div class="content">
		<?php if ($data['categories']): ?>
		<table>
			<thead>
				<tr>
					<th class="column-checks"></th>
					<th class="column-title">nombre categoría</th>
					<th class="column-buttons"></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th class="column-checks"></th>
					<th class="column-title">nombre categoría</th>
					<th class="column-buttons"></th>
				</tr>
			</tfoot>
			<tbody>
			<?php echo category_list($data['categories']); ?>
			</tbody>
		</table>
		<?php else: ?>
		<div class="message info">No hay categorías<?php echo ($this->registry->request('search')) ? ' para la busqueda \'' . $this->registry->request('search') . '\'' : ''; ?>.</div>
		<?php endif; ?>
		<div class="pagination">
			<?php echo $data['pagination']; ?>
		</div>
	</div>
</div>