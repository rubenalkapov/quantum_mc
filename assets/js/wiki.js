function dropdown(submenuId, arrowId) {
    document.querySelector("#" + submenuId).classList.toggle("hidden");
    document.querySelector("#" + arrowId + " svg").classList.toggle("rotate-90");
}

function toggleSidebar() {
    const sidebar = document.querySelector("#sidebar");
    const buttonSvg = document.querySelector(".sidebar-button svg");
    const sidebtn = document.querySelector(".sidebar-button");

    sidebar.classList.toggle("translate-x-0");
    sidebar.classList.toggle("-translate-x-full");

    sidebtn.classList.toggle("translate-x-0");
    sidebtn.classList.toggle("translate-x-[280px]");

    buttonSvg.classList.toggle("rotate-180");
}

function showContent(contentId) {
    // Hide all content sections
    document.querySelectorAll('.content').forEach(function(content) {
        content.classList.add('hidden');
    });
    // Show the selected content section
    document.querySelector('#content-' + contentId).classList.remove('hidden');
}

// Display default content on page load
document.addEventListener('DOMContentLoaded', function() {
    showContent('default');
});