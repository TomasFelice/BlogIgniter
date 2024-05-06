<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="<?= base_url() . 'blog' ?>">
        <img src="<?= base_url() . 'assets/img/logo.png' ?>" alt="" class="logo">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#"><?= APP_NAME ?> <span class="sr-only">(current)</span></a>
            </li>
        </ul>
        <div class="form-inline my-2 my-lg-0" id="search-results">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <button class="list-categories btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-id="">Categoría</button>
                    <div class="dropdown-menu list-categories">
                        
                        <?php $this->load->view('blog/utils/category_list', ['categories' => get_all_categories()]) ?>
                    </div>
                </div>
                <input type="text" class="form-control input-search-post" placeholder="Buscar..." aria-label="Recipient's username" aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary btn-search-post" type="button"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div>
        <ul class="nav navbar-nav navbar-right user-options">
            <?php if($this->session->userdata('id') != null) : ?>
                <li title="Perfil">
                    <a href="<?= base_url() . 'app/profile' ?>">
                        <i class="fa fa-user fa-2x p-2"></i>
                    </a>
                </li>
                <li title="Favoritos">
                    <a href="<?php echo base_url() . 'blog/favorite_list' ?>">
                        <i class="fa fa-heart fa-2x p-2"></i>
                    </a>
                </li>
                <li title="Cerrar Sesión">
                    <a href="<?= base_url() . 'app/logout' ?>">
                        <i class="fa fa-sign-out fa-2x p-2"></i>
                    </a>
                </li>
            <?php else: ?>
                <li title="Login">
                    <a href="<?php echo base_url() ?>login">
                        <i class="fa fa-sign-in fa-2x p-2"></i>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>