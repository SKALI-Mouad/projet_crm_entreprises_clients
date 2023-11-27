export function useSwalSuccess(message) {
    Swal.fire({
        toast: true,
        icon: "success",
        title: message,
        animation: true,
        position: "top-right",
        showConfirmButton: false,
        timer: 4000,
    });
}

export function useSwalError(message) {
    Swal.fire({
        toast: true,
        icon: "error",
        title: message,
        animation: true,
        position: 'top-right',
        showConfirmButton: false,
        timer: 4000,
    });
}

export function useSwalConfirm(message, callback) {
    Swal.fire({
        html: message,
        icon: "warning",
        buttonsStyling: true,
        showCancelButton: true,
        confirmButtonText: "Oui, supprimer",
        cancelButtonText: "Non, fermer",
        customClass:{
            confirmButton: "btn btn-primary",
            cancelButton: "btn btn-danger",
        },
    }).then((result) => {
    if (result.isConfirmed) {
        callback();
    } else if (result.isDenied){
        Swal.close();
    }
    });
}

