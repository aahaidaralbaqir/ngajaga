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
})