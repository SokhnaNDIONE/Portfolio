document.addEventListener("DOMContentLoaded", function() {
    const categorySelect = document.getElementById("categorySelect");
    const projectItems = document.querySelectorAll(".project-item");
    const errorMessage = document.querySelector(".category-error");

    categorySelect.addEventListener("change", function() {
        const selectedCategoryId = categorySelect.value;
        let foundVisibleProject = false;

        projectItems.forEach(function(item) {
            const projectCategoryId = item.getAttribute("data-category-id");

            // Afficher les projets correspondant à la catégorie sélectionnée
            if (!selectedCategoryId || selectedCategoryId === projectCategoryId) {
                item.style.display = "block";
                foundVisibleProject = true;
            } else {
                item.style.display = "none";
            }
        });

        // Si aucun projet visible, afficher le message d'erreur
        if (!foundVisibleProject) {
            errorMessage.style.display = "block";
        } else {
            errorMessage.style.display = "none";
        }
    });
});
