import * as FilePond from "filepond";

const inputElement = document.querySelector('input[type="file"].filepond');
const csrfToken = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");

FilePond.create(inputElement).setOptions({
    server: {
        process: "/uploads/process",
        headers: {
            "X-CSRF-TOKEN": csrfToken,
        },
    },
});
