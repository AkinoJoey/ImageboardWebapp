document.addEventListener("DOMContentLoaded", function () {
    let replyForm = document.getElementById("reply-form");
    const load = document.getElementById('load');

    replyForm.addEventListener("submit", (e) => {
        e.preventDefault();

        let formData = new FormData(replyForm);
        const url = this.location.pathname;
        formData.append('url', url);

        load.open = true;

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
                    load.open = false;
                    
                    window.location.href = data.url;
                } else {
                    load.open = false;
                    alert(data.message);
                }
            })
            .catch((error) => {
                load.open = false;
                alert(error);
            });
    });
});
