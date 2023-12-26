document.addEventListener("DOMContentLoaded", function () {
    let threadForm = document.getElementById("thread-form");
    const load = document.getElementById('load');

    threadForm.addEventListener("submit", (e) => {
        e.preventDefault();

        let formData = new FormData(threadForm);
        load.open = true;

        fetch("/submit", {
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
