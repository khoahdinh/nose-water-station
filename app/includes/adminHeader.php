<header>
    <a class="logo" href="<?php echo BASE_URL . '/' ?>">
        <h1 class="logo-text"><span>Nose</span>Water</h1>
    </a>
    <i class="fa fa-bars menu-toggle"></i>

    <div class="nav">
        <?php if (isset($_SESSION['username'])): ?>
            <div class="nav-item">

                <a href="#">
                    <i class="fa fa-user"></i> <!-- icon user -->
                    <?php echo $_SESSION['username']; ?>
                    <i class="fa fa-chevron-down" style="font-size: .8em;"></i> <!--icon chevron down -->
                </a>


                <div class="dropdown-menu">
                    <li><a href="<?php echo BASE_URL . '/logout.php'; ?>" class="logout">Logout</a></li>
                </div>
            </div>

            <?php
            $currentUrl = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            if (strpos($currentUrl, '/admin/languages/index.php') !== false) {
            ?>
                <div class="nav-item language-toggle">
                    <a href="javascript:void(0)">
                        <button type="button" id="languageSwitcher">
                            <i class="fa fa-globe"></i>
                            <?php echo ($_SESSION['lang'] ?? 'vi') === 'en' ? 'English (US)' : 'Vietnam'; ?>
                        </button>
                    </a>
                </div>
            <?php
            }
            ?>

        <?php endif; ?>
    </div>
</header>

<script>
    document.addEventListener('click', function(e) {
        const isDropdown = e.target.closest('.nav-item');
        if (!isDropdown) {
            // Đóng tất cả dropdown menu khi click bên ngoài
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.classList.remove('active');
            });
        }
    });

    // Lắng nghe sự kiện click trên các mục menu
    document.querySelectorAll('.nav-item > a').forEach(item => {
        item.addEventListener('click', function(e) {
            // Kiểm tra xem có dropdown menu không
            const dropdownMenu = this.nextElementSibling;

            if (dropdownMenu && dropdownMenu.classList.contains('dropdown-menu')) {
                e.preventDefault(); // Ngăn chặn hành vi mặc định (chỉ khi có dropdown menu)

                // Đóng tất cả các dropdown khác
                document.querySelectorAll('.dropdown-menu').forEach(menu => {
                    if (menu !== dropdownMenu) {
                        menu.classList.remove('active');
                    }
                });

                // Toggle trạng thái dropdown menu hiện tại
                dropdownMenu.classList.toggle('active');
            }
        });
    });

    //Language

    document.addEventListener("DOMContentLoaded", () => {
        const languageSwitcher = document.getElementById("languageSwitcher");
        let currentLang = "<?php echo $_SESSION['lang'] ?? 'vi'; ?>"; // Lấy ngôn ngữ hiện tại từ PHP

        // Xử lý khi người dùng nhấn nút
        languageSwitcher.addEventListener("click", () => {
            // Xác định ngôn ngữ mới
            const newLang = currentLang === "en" ? "vi" : "en";

            // Gửi request POST để đổi ngôn ngữ
            const form = document.createElement("form");
            form.method = "POST";
            form.action = window.location.href;

            const input = document.createElement("input");
            input.type = "hidden";
            input.name = "lang";
            input.value = newLang;
            form.appendChild(input);

            document.body.appendChild(form);
            form.submit();
        });
    });
</script>