document.querySelectorAll('.processItemId').forEach((link) =>{
    link.addEventListener('click', (e) =>{
        e.preventDefault();
        const processItemId = e.target.dataset.page;

        const form = document.getElementById('autoForm');
        const input = document.getElementById('processItemId');
        input.value = processItemId;
        form.submit();
    })
})