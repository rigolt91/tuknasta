function toastError(message) {
    Toastify({
        text: message,
        duration: 3000,
        newWindow: true,
        close: true,
        gravity: "top",
        offset: {
            y: 80
        },
        position: "right",
        stopOnFocus: true,
        style: {
            background: "linear-gradient(to bottom, #ef4444, #b91c1c)",
            borderRadius: "5px",
            color: "white",
        },
    }).showToast();
}

function toastSuccess(message) {
    Toastify({
        text: message,
        duration: 3000,
        newWindow: true,
        close: true,
        gravity: "top",
        offset: {
            y: 80
        },
        position: "right",
        stopOnFocus: true,
        style: {
            background: "linear-gradient(to bottom, #22c55e, #15803d)",
            borderRadius: "5px",
            color: "white",
        },
    }).showToast();
}

function toastInfo(message) {
    Toastify({
        text: message,
        duration: 3000,
        newWindow: true,
        close: true,
        gravity: "top",
        offset: {
            y: 80
        },
        position: "right",
        stopOnFocus: true,
        style: {
            background: "linear-gradient(to bottom, #f9fafb, #f3f4f6)",
            borderRadius: "5px",
            color: "gray",
        },
    }).showToast();
}
