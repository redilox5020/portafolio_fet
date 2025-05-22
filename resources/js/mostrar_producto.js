import { cargarMetadatosPDF, subirPdf } from './archivos.js';

document.addEventListener('DOMContentLoaded', function () {
    $('#formSubirArchivo').on('submit', function (e) {
        console.log("Subiendo archivo");
        e.preventDefault();
        const actionUrl = $(this).attr('action');
        subirPdf(this, actionUrl);

    });
    cargarMetadatosPDF();
});
