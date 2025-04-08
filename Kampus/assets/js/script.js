document.addEventListener("DOMContentLoaded", function () {
    // Toggle menu pada tampilan mobile
    const menuToggle = document.getElementById("menu-toggle");
    const mobileMenu = document.getElementById("mobile-menu");

    if (menuToggle && mobileMenu) {
        menuToggle.addEventListener("click", function () {
            mobileMenu.classList.toggle("hidden");
        });
    }

    // Dropdown menu user
    const userDropdownToggle = document.getElementById("user-dropdown-toggle");
    const userDropdownMenu = document.getElementById("user-dropdown-menu");

    if (userDropdownToggle && userDropdownMenu) {
        userDropdownToggle.addEventListener("click", function () {
            userDropdownMenu.classList.toggle("hidden");
        });

        // Tutup dropdown jika klik di luar area menu
        document.addEventListener("click", function (event) {
            if (!userDropdownToggle.contains(event.target) && !userDropdownMenu.contains(event.target)) {
                userDropdownMenu.classList.add("hidden");
            }
        });
    }
});
