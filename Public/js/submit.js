document.addEventListener("DOMContentLoaded", function () {
    let threadForm = document.getElementById("thread-form");

    threadForm.addEventListener("submit", (e) => {
        e.preventDefault();

        let formData = new FormData(threadForm);

        fetch("/form/thread", {
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
                    console.log(data.message);
                    console.log(...formData.entries());
                } else {
                    alert(data.message);
                }
            })
            .catch((error) => {
                alert(error);
            });
    });
});
