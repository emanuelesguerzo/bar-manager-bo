// Logica menu aggiunta ingrediente
document.addEventListener("DOMContentLoaded", function () {
    const wrapper = document.getElementById("ingredients-wrapper");
    const addBtn = document.getElementById("add-ingredient");
    const template = document.getElementById("ingredient-template");

    if (!wrapper || !addBtn || !template) return;

    // Aggiunta
    addBtn.addEventListener("click", function () {
        const clone = template.content.cloneNode(true);
        wrapper.appendChild(clone);
    });

    // Rimozione
    wrapper.addEventListener("click", function (e) {
        const removeBtn = e.target.closest(".remove-ingredient");
        if (removeBtn) {
            const group = removeBtn.closest(".ingredient-group");
            if (group) {
                group.remove();
            }
        }
    });
});

