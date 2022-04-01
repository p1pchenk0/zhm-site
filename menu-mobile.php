<div class="mobile-menu">
    <div
        class="mobile-menu__button"
        id="mobileMenuBtn"
    >
        <span></span>
        <span></span>
        <span></span>
    </div>
    <div
        id="mobileMenu"
        class="mobile-menu__inner p-5"
    >   
        <span id="closeMenuBtn">
            <?php echo zhm_get_icon('close'); ?>
        </span>
        <div class="mobile-menu__list-wrapper">
            <ul class="navbar-nav bold">
                <?php
                    wp_nav_menu(
                        array(
                            'container'       => '',
                            'items_wrap'      => '%3$s',
                            'theme_location'  => 'primary',
                            'add_li_class'    => 'nav-item primary-font'
                        )
                    );
                ?>
            </ul>
        </div>
    </div>
</div>

<script>
    var mobileMenuBtn = document.getElementById('mobileMenuBtn');
    var closeMenuBtn = document.getElementById('closeMenuBtn');
    var mobileMenu = document.getElementById('mobileMenu');
    var isMenuShown = false;

    function toggleMenuVisibility() {
        isMenuShown = !isMenuShown;
        var action = isMenuShown ? 'add' : 'remove';

        mobileMenu.classList[action]('displayed');
        document.body.classList[action]('mobile-menu-shown');
    }

    mobileMenuBtn.addEventListener('click', toggleMenuVisibility);
    closeMenuBtn.addEventListener('click', toggleMenuVisibility);
</script>