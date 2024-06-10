window.addEventListener('DOMContentLoaded', function () {
    const dropdown = document.querySelectorAll('[role="dropdown"]')
    dropdown.forEach(function (item) {
        item.addEventListener('click', function (event) {
            event.preventDefault()
            const targetId = item.getAttribute('data-id')
            const targetName = item.getAttribute('data-name')
            const dropdownContents = document.querySelectorAll('[role="dropdown-content"]')
            dropdownContents.forEach(function (dc) {
                const id = dc.getAttribute('data-id')
                const name = dc.getAttribute('data-name')
                if (targetId == id && targetName == name) {
                    dc.classList.toggle('hidden')
                    if (targetName !== 'table') dc.classList.toggle('flex')
                }
            })
        })
    })

    const permission = document.querySelectorAll('#permission')
    permission.forEach(function (item) {
        item.addEventListener('change', function (event) {
            const permissionId = event.target.value
            permission.forEach((elem) => {
                const parentId = elem.getAttribute('data-id-parent')
                if (permissionId == parentId) {
                }
            })
        })
    })

    const deleteButtons = this.document.querySelectorAll('#delete-data')
    console.log(deleteButtons)
    deleteButtons.forEach(function (btn) {
        btn.addEventListener('click', function(event) {
            event.preventDefault();
            const targetUrl = btn.getAttribute('href')
            const needConfirm = btn.hasAttribute('show-confirm')
            const title = btn.getAttribute('title')
            if (!needConfirm) {
                window.location = targetUrl
            }

            const dialog = `
                <dialog id="dialog">
                    <header>
                        <h2 class="text-2xl">${title}</h2>
                        <div role="button" class="close" aria-label="Close"></div>
                    </header>
                    <h4 class="font-bold mt-2">Apakah kamu yakin ingin menghapus data ini?</h4>
                    <footer class="mt-3">
                        <button id="confirm-no" class="button text-base text-black p-3 rounded border border-black">Batal</button>
                        <button id="confirm-yes" class="button text-base bg-[red] text-white p-3 rounded border border-black">Hapus</button>
                    </footer>
                </dialog>
            `
            const parentElement = btn.parentElement
            parentElement.insertAdjacentHTML('afterbegin', dialog)
            const d = document.getElementById('dialog')
            d.showModal()

            const x = document.getElementById('confirm-no')
            const y = document.getElementById('confirm-yes')

            x.addEventListener('click', function(event) {
                event.preventDefault()
                d.remove()
            })

            y.addEventListener('click', function (event) {
                event.preventDefault()
                window.location = targetUrl
            })
        })
    })

    function removeToast(toast) {
        toast.remove();
    }

    function createToastError(description) {
        const toast = document.createElement('div');
        toast.id = 'toast';
        toast.className = 'flex w-full max-w-sm p-4 toast toast-error';
        toast.innerHTML = `
          <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd" d="M7.93389 12.1C7.38389 12.1 6.93389 11.65 6.93389 11.1C6.93389 10.539 7.38389 10.1 7.93389 10.1C8.48389 10.1 8.93389 10.539 8.93389 11.1C8.93389 11.65 8.48389 12.1 7.93389 12.1ZM7.05389 5.72003C7.05389 5.23003 7.44389 4.84003 7.93389 4.84003C8.41389 4.84003 8.80389 5.23003 8.80389 5.72003V8.22003C8.80389 8.70003 8.41389 9.09003 7.93389 9.09003C7.44389 9.09003 7.05389 8.70003 7.05389 8.22003V5.72003ZM14.0939 9.73003C13.6539 8.46003 13.0239 7.28003 12.3839 6.10003C11.5739 4.58003 10.5339 2.42003 8.67389 2.05003C8.51389 2.01003 8.35389 2.00003 8.19389 2.00003C6.02389 1.99003 4.63389 4.34003 3.63389 5.94003C2.88389 7.12003 2.13389 8.33003 1.72389 9.66103C1.52389 10.28 1.41389 10.95 1.58389 11.57C1.79389 12.289 2.36389 12.86 3.02389 13.2C3.68389 13.55 4.42389 13.7 5.16389 13.8C6.95389 14.05 8.77389 14.07 10.5739 13.87C11.3639 13.78 12.1739 13.64 12.8839 13.27C13.5839 12.9 14.1939 12.25 14.3339 11.46C14.4339 10.88 14.2839 10.289 14.0939 9.73003Z" fill="#DA160B"/>
          </svg>
          <div class="ml-3 text-sm"> ${description} </div>
        `
    
        document.body.appendChild(toast);
        toast.timeoutId = setTimeout(() => removeToast(toast), 5000)
    }

    function createToastSuccess(description) {
        const toast = document.createElement('div');
        toast.id = 'toast';
        toast.className = 'flex w-full max-w-sm p-4 toast toast-success';
        toast.innerHTML = `
            <svg width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 21.61a9.6 9.6 0 1 0 0-19.2 9.6 9.6 0 0 0 0 19.2Zm4.45-11.152a1.2 1.2 0 0 0-1.698-1.697l-3.951 3.952-1.552-1.552a1.2 1.2 0 0 0-1.697 1.697l2.4 2.4a1.2 1.2 0 0 0 1.697 0l4.8-4.8Z" fill="#23A094"/>
            </svg>
            <div class="ml-3 text-sm"> ${description} </div>
        `
    
        document.body.appendChild(toast);
        toast.timeoutId = setTimeout(() => removeToast(toast), 5000)
    }

    const errorMessages = document.querySelectorAll(".error-message")

    errorMessages.forEach(async function (item) {
        const currentToast = document.getElementById('toast')
        if (currentToast) currentToast.remove()
    
        if (item.innerHTML != "") {
          createToastError(item.innerHTML)
        }
    })

    const successMessages = document.querySelectorAll(".success-message")

    successMessages.forEach(async function (item) {
        const currentToast = document.getElementById('toast')
        if (currentToast) currentToast.remove()
    
        if (item.innerHTML != "") {
            createToastSuccess(item.innerHTML)
        }
    })
})