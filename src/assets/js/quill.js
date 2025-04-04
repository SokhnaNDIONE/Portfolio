document.addEventListener('DOMContentLoaded', function() {
    const quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': '1' }, { 'header': '2' }, { 'font': [] }],
                [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                ['bold', 'italic', 'underline'],
                ['link'],
                ['image'],
                [{ 'align': [] }],
            ]
        }
    });

    // Lorsque le contenu change, mettre à jour le champ caché
    quill.on('text-change', function() {
        const description = quill.root.innerHTML;
        document.getElementById('description').value = description;
    });
});
