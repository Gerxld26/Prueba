document.addEventListener('DOMContentLoaded', function() {
    // Aquí puedes agregar funciones JavaScript si es necesario en el futuro.
    
    // Ejemplo: Mostrar una alerta cuando la página se carga
    console.log("Página cargada y lista.");

    // Ejemplo de agregar un evento a los botones de contenido (si existieran)
    const contentButtons = document.querySelectorAll('.content-button');
    contentButtons.forEach(button => {
        button.addEventListener('click', function() {
            alert('Contenido clickeado');
        });
    });
});
