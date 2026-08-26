<nav id="menu" class="main-menu">
    <ul>
        <li><span><a href="<?php echo base_url();?>"><?php echo get_phrase('home'); ?></a></span></li>
        <li><span><a href="<?php echo base_url();?>home/listings"><?php echo get_phrase('listings'); ?></a></span></li>
        <li><span><a href="<?php echo base_url();?>home/category"><?php echo get_phrase('category'); ?></a></span></li>
        <li><a href="https://docs.google.com/forms/d/e/1FAIpQLSenZdj9cKV0F1kJFyRRhL7f0equ-4q8D1ZDVys2YYNmjkkgrw/viewform" target="_BLANK" class="btn btn-success"><?php echo get_phrase('Regístrese'); ?></a></li>
        <?php if ($this->session->userdata('is_logged_in') == 1): ?>
            <li><span><a href="javascript::"><?php echo get_phrase('account'); ?></a></span>
                    <ul class="manage_account_navbar">
                        <li><a href="<?php echo base_url(strtolower($this->session->userdata('role')).'/listings');?>"><?php echo get_phrase('manage_account'); ?></a></li>
                        <li><a href="<?php echo site_url('login/logout') ?>"><?php echo get_phrase('logout'); ?></a></li>
                    </ul>
                </li>
        <?php endif; ?>
        <!-- Ítem de búsqueda en el menú -->
        <li class="nav-item nav-search-dropdown dropdown">
            <!-- Botón de Lupa -->
            <a class="nav-link search-toggle-btn" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Buscar comercios">
                <i class="fas fa-search"></i>
            </a>

            <!-- Caja flotante desplegable -->
            <div class="dropdown-menu dropdown-menu-right search-dropdown-box p-3" aria-labelledby="searchDropdown">
                <form action="<?php echo site_url('home/filter_listings'); ?>" method="get">
                    <!-- Parámetros ocultos necesarios -->
                    <input type="hidden" name="category" value="">
                    <input type="hidden" name="amenity" value="">
                    <input type="hidden" name="city" value="">
                    <input type="hidden" name="price-range" value="0">
                    <input type="hidden" name="status" value="">
                    
                    <!-- Valores fijos de ubicación -->
                    <?php $ACACIAS_ID = 3; ?>
                    <input type="hidden" name="selected_city_id" value="<?php echo $ACACIAS_ID; ?>">
                    <input type="hidden" name="state" value="meta">

                    <div class="input-group">
                        <input type="text" class="form-control" name="search_string" 
                            placeholder="<?php echo get_phrase('Buscar...'); ?>..." 
                            required autofocus>
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>
    </ul>
</nav>