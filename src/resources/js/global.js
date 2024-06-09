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
})