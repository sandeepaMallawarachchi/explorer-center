const imgUploadContainer = document.getElementById('img-upload-container');

imgUploadContainer.addEventListener('dragover', (event) => {
    event.preventDefault();
    imgUploadContainer.style.borderColor = '#007bff';
});

imgUploadContainer.addEventListener('dragleave', () => {
    imgUploadContainer.style.borderColor = '#ccc';
});

imgUploadContainer.addEventListener('drop', (event) => {
    event.preventDefault();
    imgUploadContainer.style.borderColor = '#ccc';
    const file = event.dataTransfer.files[0];
    if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const bgImage = document.querySelector('.img-upload-bg');
            bgImage.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});

function previewImage(event) {
    const file = event.target.files[0];
    if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const bgImage = document.querySelector('.img-upload-bg');
            bgImage.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
}