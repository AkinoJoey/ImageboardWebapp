document.addEventListener("DOMContentLoaded", function () {
    let replyForm = document.getElementById("reply-form");

    replyForm.addEventListener("submit", (e) => {
        e.preventDefault();

        let formData = new FormData(replyForm);
        const url = this.location.pathname;
        formData.append('url', url);

        fetch("/comment", {
            method: "POST",
            body: formData,
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then((data) => {
                if (data.success) {
                    window.location.href = data.url;
                } else {
                    alert(data.message);
                }
            })
            .catch((error) => {
                alert(error);
            });
    });
});
