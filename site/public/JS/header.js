// Header JavaScript functionality
console.log('Header JavaScript loaded');

// Additional header functionality can be added here
document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle if needed
    const navbar = document.getElementById('navbar');
    
    // Scroll effect for header
    window.addEventListener('scroll', function() {
        if (window.scrollY > 100) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });
    
    // Search form validation
    const searchForm = document.querySelector('.search-box');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            const keyword = this.querySelector('input[name="keyword"]').value.trim();
            if (keyword.length < 2) {
                e.preventDefault();
                alert('Vui lòng nhập ít nhất 2 ký tự để tìm kiếm');
            }
        });
    }
});
