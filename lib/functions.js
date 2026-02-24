

//########################################### Alert Delete Safety Check Entry ##############################################
function alert_delete_safety_check_entry(entryID) {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            document.location.href =  document.getElementById("part").href + "&entry="+ entryID  + "&delete_entry";
        }
    });
}

function snackbar(message, type = "info", duration = 3000) {

    const bar = document.getElementById("snackbar");

    bar.textContent = message;
    bar.className = "";
    bar.classList.add(type);

    // Reflow erzwingen für Animation-Reset
    void bar.offsetWidth;

    bar.classList.add("show");

    setTimeout(() => {
        bar.classList.remove("show");
    }, duration);
}





