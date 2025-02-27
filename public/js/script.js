document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('investigadoresContainer');
    const addButton = document.querySelector('.añadir-investigador');

    addButton.addEventListener('click', function() {
        const newInput = document.createElement('div');
        newInput.classList.add('investigador-input');
        newInput.innerHTML = `
            <input type="text" name="investigadores[]" placeholder="Nombre del investigador" required>
            <button type="button" class="eliminar-investigador">-</button>
        `;
        container.appendChild(newInput);

        const deleteButton = newInput.querySelector('.eliminar-investigador');
        deleteButton.addEventListener('click', function() {
            container.removeChild(newInput);
        });
    });
});
