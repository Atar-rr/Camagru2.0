document.getElementById('navbarButton').onclick = function () {
    let navbarNav = document.getElementById("navbarNav");

    if (navbarNav.style.display === 'none' || navbarNav.style.display === '') {
        navbarNav.style.display = 'block';
    } else {
        navbarNav.style.display = 'none'
    }
}
