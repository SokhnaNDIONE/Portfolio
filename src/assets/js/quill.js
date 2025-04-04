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

    // Précharger le contenu dans l'éditeur Quill à partir de la description
    const description = document.getElementById('description').value;
    quill.root.innerHTML = description;  // Charge le HTML dans Quill (ne pas échapper le contenu)

    // Lorsque le contenu change, mettre à jour le champ caché
    quill.on('text-change', function() {
        const updatedDescription = quill.root.innerHTML;
        document.getElementById('description').value = updatedDescription;
    });
});
