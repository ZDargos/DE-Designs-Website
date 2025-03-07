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


//Helper function to get root variable
function getCSSRootVariable(variableName) {
    return getComputedStyle(document.documentElement).getPropertyValue(variableName);
}

//Converts background color based on seeing threshold amount of section_trigger
// function change_background (trigger_id, original_color, altered_color, threshold, exit=true) {
//     document.addEventListener("DOMContentLoaded", function () {
//         const triggerSection = document.getElementById(trigger_id); // Section that triggers the color change
//         const body = document.body;
//         const observer = new IntersectionObserver(
//             (entries) => {
//                 entries.forEach((entry) => {
//                     if (entry.isIntersecting) {
//                         body.style.backgroundColor = altered_color; // Change to dark background
//                     } else if (exit) {
//                         body.style.backgroundColor = original_color; // Revert to default (or specify a color)
//                     }
//                 });
//             },
//             { threshold: threshold } // Adjust threshold as needed (0.5 means 50% of the section must be visible)
//         );

//         observer.observe(triggerSection);
//     });
// }
function change_background(trigger_id, original_color, altered_color, threshold, text_ids=[], original_text_color="#141313", altered_text_color="#141313", box_ids=[], original_box_color="white", altered_box_color="black") {
    document.addEventListener("DOMContentLoaded", function () {
        const triggerSection = document.getElementById(trigger_id); // Section that triggers the color change
        const textElements = text_ids.map(id => document.getElementById(id)); // Array of text elements
        const boxElements = box_ids.map(id => document.getElementById(id));
        const body = document.body;
        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        body.style.backgroundColor = altered_color; // Change to dark background
                        textElements.forEach(element => {
                            element.style.color = altered_text_color; // Change text color for each element
                        });
                        boxElements.forEach(element => {
                            element.style.backgroundColor = altered_box_color; // Change text color for each element
                        });
                    } else {
                        body.style.backgroundColor = original_color; // Revert to default (or specify a color)
                        textElements.forEach(element => {
                            element.style.color = original_text_color; // Revert text color for each element
                        });
                        boxElements.forEach(element => {
                            element.style.backgroundColor = original_box_color; // Change text color for each element
                        });
                    }
                });
            },
            { threshold: threshold } // Adjust threshold as needed (0.5 means 50% of the section must be visible)
        );

        observer.observe(triggerSection);
    });
}

function alter_light_dark_bg(trigger_id, threshold, text_ids=[], box_ids=[]) {
    change_background(trigger_id, getCSSRootVariable('--menu-main-bg-color').trim(), getCSSRootVariable('--menu-light-bg-color').trim(), threshold,
    text_ids, getCSSRootVariable('--menu-dark-bg-text-color').trim(), getCSSRootVariable('--menu-light-bg-text-color').trim(), 
    box_ids, getCSSRootVariable('--menu-dark-bg-box-color').trim(), getCSSRootVariable('--menu-light-bg-box-color').trim());
}
