document.addEventListener("DOMContentLoaded", function () {
    const imageInput = document.getElementById("image-input");
    const imageIcon = document.getElementById("image-icon");
    const imagePreview = document.getElementById("image-preview");

    imageIcon.addEventListener("click", function () {
        imageInput.click();

        let imageFile = imageInput.files[0];

        if (imageFile) {
            let reader = new FileReader();
            reader.addEventListener('load', () => {
                imagePreview.innerHTML =
                    '<img src="' + reader.result + '" alt="投稿された画像">';
            }, false,
            );
            if (file) {
            reader.readAsDataURL(file);
            }
        }
    });
});
