// Product Details JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Product images
    const productImages = [
        '../../public/img/sp-1.webp',
        '../../public/img/sp-2.webp',
        '../../public/img/sp-3.webp'
    ];

    // Quantity controls
    const minusBtn = document.querySelector('.qty-btn.minus');
    const plusBtn = document.querySelector('.qty-btn.plus');
    const qtyInput = document.querySelector('.qty-input');

    if (minusBtn && plusBtn && qtyInput) {
        minusBtn.addEventListener('click', function() {
            let currentValue = parseInt(qtyInput.value);
            if (currentValue > 1) {
                qtyInput.value = currentValue - 1;
            }
        });

        plusBtn.addEventListener('click', function() {
            let currentValue = parseInt(qtyInput.value);
            qtyInput.value = currentValue + 1;
        });
    }

    // Image gallery
    const thumbnails = document.querySelectorAll('.thumbnail');
    const mainImage = document.getElementById('mainProductImage');
    
    thumbnails.forEach(function(thumbnail) {
        thumbnail.addEventListener('click', function() {
            // Remove active class from all thumbnails
            thumbnails.forEach(t => t.classList.remove('active'));
            
            // Add active class to clicked thumbnail
            this.classList.add('active');
            
            // Change main image
            const newImageSrc = this.querySelector('img').src;
            if (mainImage) {
                mainImage.src = newImageSrc;
            }
        });
    });

    // Image navigation
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');
    
    if (prevBtn && nextBtn) {
        let currentImageIndex = 0;
        const images = Array.from(thumbnails).map(thumb => thumb.querySelector('img').src);
        
        prevBtn.addEventListener('click', function() {
            currentImageIndex = currentImageIndex > 0 ? currentImageIndex - 1 : images.length - 1;
            updateMainImage();
        });
        
        nextBtn.addEventListener('click', function() {
            currentImageIndex = currentImageIndex < images.length - 1 ? currentImageIndex + 1 : 0;
            updateMainImage();
        });
        
        function updateMainImage() {
            if (mainImage && images[currentImageIndex]) {
                mainImage.src = images[currentImageIndex];
                
                // Update active thumbnail
                thumbnails.forEach((thumb, index) => {
                    thumb.classList.toggle('active', index === currentImageIndex);
                });
            }
        }
    }

    // Tab switching
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabPanes = document.querySelectorAll('.tab-pane');
    
    tabButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            const targetTab = this.getAttribute('data-tab');
            
            // Remove active class from all tabs and panes
            tabButtons.forEach(btn => btn.parentElement.classList.remove('active'));
            tabPanes.forEach(pane => pane.classList.remove('active'));
            
            // Add active class to clicked tab
            this.parentElement.classList.add('active');
            
            // Show corresponding pane
            const targetPane = document.getElementById(targetTab);
            if (targetPane) {
                targetPane.classList.add('active');
            }
        });
    });

    // Expand description
    const expandBtn = document.querySelector('.expand-btn');
    const descriptionText = document.querySelector('.description-text');
    
    if (expandBtn && descriptionText) {
        expandBtn.addEventListener('click', function() {
            if (descriptionText.style.maxHeight) {
                descriptionText.style.maxHeight = '';
                this.textContent = 'Xem chi tiết';
            } else {
                descriptionText.style.maxHeight = '200px';
                descriptionText.style.overflow = 'hidden';
                this.textContent = 'Thu gọn';
            }
        });
    }

    // Review filter buttons
    const filterButtons = document.querySelectorAll('.filter-btn');
    
    filterButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            // Remove active class from all filter buttons
            filterButtons.forEach(btn => btn.classList.remove('active'));
            
            // Add active class to clicked button
            this.classList.add('active');
            
            // Here you would typically filter the reviews
            // For now, we'll just show the selection
            console.log('Filter selected:', this.textContent);
        });
    });

    // Add to cart functionality
    const addToCartBtn = document.querySelector('.add-to-cart-btn');
    
    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', function() {
            const quantity = qtyInput ? qtyInput.value : 1;
            const productName = document.querySelector('.product-title').textContent;
            
            // Here you would typically send this data to your backend
            alert(`Đã thêm ${quantity} sản phẩm "${productName}" vào giỏ hàng!`);
        });
    }

    // Product action buttons
    const buyButtons = document.querySelectorAll('.btn-buy');
    const detailButtons = document.querySelectorAll('.btn-detail');
    
    buyButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            const productItem = this.closest('.product-item');
            const productName = productItem.querySelector('.product-name').textContent;
            alert(`Mua ngay sản phẩm: ${productName}`);
        });
    });
    
    detailButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            const productItem = this.closest('.product-item');
            const productName = productItem.querySelector('.product-name').textContent;
            alert(`Xem chi tiết sản phẩm: ${productName}`);
        });
    });

    // Write review button
    const writeReviewBtn = document.querySelector('.write-review-btn');
    
    if (writeReviewBtn) {
        writeReviewBtn.addEventListener('click', function() {
            alert('Chức năng viết đánh giá sẽ được triển khai!');
        });
    }

    // Initialize description state
    if (descriptionText) {
        descriptionText.style.maxHeight = '200px';
        descriptionText.style.overflow = 'hidden';
    }
});
