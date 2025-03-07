// base-scripts.js

document.addEventListener("DOMContentLoaded", function () {
    // Load the header from header.html and insert it into the page
    fetch('header.html')
        .then(response => response.text())
        .then(data => {
            document.getElementById('main-header').innerHTML = data;

            let currentPage = window.location.pathname.split("/").pop();
        
        // Get all nav links
        let navLinks = document.querySelectorAll("nav ul li a");

        // Loop through the links and compare with current page
        navLinks.forEach(link => {
            if (link.getAttribute("href") === currentPage) {
                link.classList.add("active");
            }
        });
        })
        .catch(error => console.error('Error loading header:', error));
});



fetch('footer.html')
            .then(response => response.text())
            .then(data => {
                console.log('Footer fetched successfully');
                document.getElementById('main-footer').innerHTML = data;
            })
            .catch(error => {
                console.error('Error fetching footer:', error);
            });