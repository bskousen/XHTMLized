<div class="section business">
    <div class="header_individual">
        <h4>EMPRESAS</h4>
    </div>
    <div class="content">
        <?php if ($data['search_query'] and $data['companies']): ?>
        <div>
            <p class="message">Resultados para la búsqueda: <?php echo $data['search_query']; ?></p>
        </div>
        <?php endif; ?>
        <?php if (isset($data['companies']) and $data['companies']): ?>
        <?php foreach($data['companies'] as $company): ?>
        <div id="bizdata_listado">
            <?php if ($company['logo']): ?>
            <?php
            // get the filename for the logo image:
            // slice the filename in name and extension, add file size suffix at the en of the name and stick it again
            $filename = pathinfo($company['logo'], PATHINFO_FILENAME);
            $fileext = strtolower(pathinfo($company['logo'], PATHINFO_EXTENSION));
            $logo_path = _reg('site_url') . 'usrs/empresas/' . $filename . '.' . $fileext;
            ?>
            <img src="<?php echo $logo_path; ?>" class="photo" />
            <?php endif; ?>
            <h2><a href="<?php echo _reg('site_url'); ?>empresas/<?php echo $company['slug']; ?>"><?php echo $company['name']; ?></a></h2>
            <div class="excerpt">
                <?php echo substr($company['description'], 0, 180); ?>...
            </div>
            <div class="address">
                <p><?php echo $company['address']; ?><br />
                    <?php echo $company['zipcode']; ?> <?php echo $company['city']; ?> (<?php echo $company['state']; ?>)</p>
                <p>(T) <?php echo $company['phone']; ?></p>
                <p>(web) <?php echo $company['web']; ?></p>
            </div>
            <!-- .address -->
        </div>
        <!-- .bizdata -->
        <?php endforeach; ?>
        <?php else: ?>
        <div id="bizdata">
            <p class="message info">No hay empresas en la guía comercial<?php echo ($data['search_query']) ? ' para la busqueda \'' . $data['search_query'] . '\'' : ''; ?>.</p>
        </div>
        <?php endif; ?>
    </div>
    <!-- .content -->
    <div class="search companiessearch">
        <form method="post" action="<?php echo _reg('site_url'); ?>empresas/search" name="companiessearchform">
            <p>
                <input name="searchquery" type="text" value="Buscar en guía comercial…" />
                <a href="javascript:document.companiessearchform.submit();" id="search-btn"><img src="<?php echo _reg('site_url') . _reg('theme_path'); ?>images/btn_search.png" alt="buscar" /></a></p>
        </form>
    </div>
    <!-- .companiessearch --> 
    <img src="<?php echo _reg('site_url') . _reg('theme_path'); ?>images/6x6.jpg" alt="" />
</div>
<!-- .business .section -->